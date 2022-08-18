<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "keselamatan.stc_sticker_pelawat".
 *
 * @property int $id
 * @property string $v_co_icno
 * @property string $veh_owner 
 * @property string $rel_owner_user
 * @property string $reg_number
 * @property string $veh_color
 * @property string $veh_type
 * @property string $veh_brand
 * @property string $veh_model
 * @property string $roadtax_no
 * @property string $roadtax_exp 
 * @property string $daftar_date
 * @property string $updater
 * @property string $status_kenderaan 
 * @property int $lesen_id
 * @property int $lesen_no
 * @property string $catatan_modifikasi
 * @property string $staf_v_co_icno
 * @property string $staf_rel
 */
class TblStickerPelawat extends \yii\db\ActiveRecord {

    public $grant, $kod_siri, $siri;

    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.stc_sticker_pelawat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['v_co_icno', 'veh_owner', 'rel_owner_user', 'reg_number', 'veh_color', 'veh_type', 'veh_brand', 'veh_model', 'lesen_no', 'lesen_exp', 'roadtax_no', 'roadtax_exp', 'staf_v_co_icno', 'staf_rel'], 'required', 'message' => 'Ruang ini adalah mandatori.'],
            [['kod_siri', 'siri', 'roadtax_exp', 'daftar_date', 'lesen_exp'], 'safe'],
            [['lesen_no'], 'integer'],
            [['v_co_icno', 'staf_v_co_icno'], 'string', 'max' => 12],
            [['veh_owner'], 'string', 'max' => 100],
            [['rel_owner_user', 'veh_color', 'staf_rel'], 'string', 'max' => 30],
            [['reg_number'], 'string', 'max' => 9],
            [['veh_type'], 'string', 'max' => 10],
            [['veh_brand', 'veh_model', 'roadtax_no'], 'string', 'max' => 50],
            [['updater', 'status_kenderaan'], 'string', 'max' => 15],
            [['catatan_modifikasi'], 'string', 'max' => 250],
            [['reg_number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'v_co_icno' => 'V Co Icno',
            'veh_owner' => 'Veh Owner',
            'rel_owner_user' => 'Rel Owner User',
            'reg_number' => 'Reg Number',
            'veh_color' => 'Veh Color',
            'veh_type' => 'Veh Type',
            'veh_brand' => 'Veh Brand',
            'veh_model' => 'Veh Model',
            'roadtax_no' => 'Roadtax No',
            'roadtax_exp' => 'Roadtax Exp', 
            'daftar_date' => 'Daftar Date',
            'updater' => 'Updater',
            'status_kenderaan' => 'Status Kenderaan',
            'lesen_exp' => 'Lesen Exp',
            'lesen_no' => 'Lesen No',
            'catatan_modifikasi' => 'Catatan Modifikasi',
            'staf_v_co_icno' => 'Staf V Co Icno',
            'staf_rel' => 'Staf Rel',
        ];
    }

    public function getJenisKenderaan() {
        return $this->hasOne(\app\models\esticker\RefJenisKenderaan::className(), ['KODJENIS' => 'veh_type']);
    }

    public function getKodSiri() {
        return $this->hasOne(\app\models\esticker\RefKodSiri::className(), ['veh_type' => 'veh_type'])->where(['stc_type' => 5]);
    } 
    
    public static function checkOwnKenderaan($reg_number) {
        return TblStickerPelawat::find()->where(['LIKE', 'reg_number', $reg_number])->exists();
    }

    public static function checkOwnKenderaanSendiri($ic) {
        return TblStickerPelawat::find()->where(['v_co_icno' => $ic])->andWhere(['status_kenderaan'=>'AKTIF'])->exists();
    }

    public function getPelekat() {
        return $this->hasOne(\app\models\esticker\TblPelekatKenderaanPelawat::className(), ['id_kenderaan' => 'id']);
    }

    public function getBiodata() {
        return $this->hasOne(\app\models\esticker\TblPelawat::className(), ['ICNO' => 'v_co_icno']);
    }

    public static function findKenderaan($id) {
        return TblStickerPelawat::find()->where(['stc_sticker_pelawat.id' => $id])->joinWith('pelekat')->joinWith('biodata')->one();
    }

    public static function Checking($id) {
//        $check = TblStickerPelawat::CheckTotalAktifSticker($id); //CHECK LEBIH 3 PERMOHONAN
        $check2 = TblStickerPelawat::CheckLesenTamat($id); //CHECK LESEN EXPIRED  
        $check3 = TblStickerPelawat::CheckRoadtaxTamat($id); //CHECK ROADTAX EXPIRED 
//        if ($check === true) {
            if ($check2 === true) {
                if ($check3 === true) {
                    return true; //pass ALL condition 
                } else {
                    return TblStickerPelawat::CheckRoadtaxTamat($id); // return error message
                }
            } else {
                return TblStickerPelawat::CheckLesenTamat($id); // return error message
            }
//        } else {
//            return TblStickerPelawat::CheckTotalAktifSticker($id); // return error message
//        }
    }

    public static function CheckTotalAktifSticker($id) {
        $kenderaan = TblStickerPelawat::findOne(['id' => $id]);
        $pelawat = TblPelawat::findOne(['ICNO' => $kenderaan->v_co_icno]);
        $model = TblPelekatKenderaanPelawat::find()->where(['id_pelawat' => $pelawat->id])->all();
        $max_veh = TblPelekatKenderaan::findPaymentRate('PELAWAT');
        $i = 0;

        if ($model) {
            foreach ($model as $model) {
                if ($model->status_mohon == 'AKTIF') {
                    if (date('Y-m-d') < $model->expired_date) {
                        $i++;
                    }
                }
            }
        }

        if (empty($model)) {
            return true;
        } elseif ($i <= $max_veh->maximum) {
            return true;
        } else {
            return 'Maaf anda mempunyai lebih daripada ' . $max_veh->maximum . ' permohonan aktif.';
        }
    }

    public static function CheckRoadtaxTamat($id) {
        $model = TblStickerPelawat::findKenderaan($id);

        if (date('Y-m-d') < $model->roadtax_exp) {
            return true;
        } else {
            return 'Maaf tarikh roadtax anda telah tamat. Sila kemaskini maklumat kenderaan anda.';
        }
    }

    public static function CheckLesenTamat($id) {
        $model = TblStickerPelawat::findKenderaan($id);

        if (date('Y-m-d') < $model->lesen_exp) {
            return true;
        } else {
            return 'Maaf tarikh lesen anda telah tamat. Sila kemaskini maklumat kenderaan anda.';
        }
    }

}
