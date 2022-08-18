<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "keselamatan.stc_sticker_kontraktor".
 *
 * @property int $id
 * @property int $id_kontraktor
 * @property string $v_co_icno
 * @property string $veh_owner
 * @property string $veh_user
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
 * @property string $catatan
 * @property string $filename_grant
 */
class TblStickerKontraktor extends \yii\db\ActiveRecord {

    public $grant,$kod_siri,$siri;

    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.stc_sticker_kontraktor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id_kontraktor', 'v_co_icno', 'veh_owner', 'veh_user', 'rel_owner_user', 'reg_number', 'veh_color', 'veh_type', 'veh_brand', 'veh_model', 'lesen_no', 'lesen_exp', 'roadtax_no', 'roadtax_exp', 'grant'], 'required', 'message' => 'Ruang ini adalah mandatori.'],
            [['id_kontraktor'],'string', 'max' => 11],
            [['kod_siri','siri','lesen_exp', 'roadtax_exp', 'daftar_date', 'grant'], 'safe'],
            [['catatan'], 'string'],
            [['v_co_icno'], 'string', 'max' => 12],
            [['veh_owner', 'veh_user', 'filename_grant'], 'string', 'max' => 100],
            [['rel_owner_user', 'veh_color'], 'string', 'max' => 30],
            [['reg_number'], 'string', 'max' => 9],
            [['veh_type'], 'string', 'max' => 10],
            [['veh_brand', 'veh_model', 'roadtax_no', 'lesen_no'], 'string', 'max' => 50],
            [['updater', 'status_kenderaan'], 'string', 'max' => 15],
            [['reg_number'], 'unique'],
            [['grant'], 'file', 'extensions' => 'pdf', 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'id_kontraktor' => 'Id Kontraktor',
            'v_co_icno' => 'No. K/P',
            'veh_owner' => 'Veh Owner',
            'veh_user' => 'Nama Pengguna',
            'rel_owner_user' => 'Rel Owner User',
            'reg_number' => 'No Kenderaan',
            'veh_color' => 'Veh Color',
            'veh_type' => 'Veh Type',
            'veh_brand' => 'Veh Brand',
            'veh_model' => 'Veh Model',
            'roadtax_no' => 'Roadtax No',
            'roadtax_exp' => 'Roadtax Exp', 
            'daftar_date' => 'Daftar Date',
            'updater' => 'Updater',
            'status_kenderaan' => 'Status Kenderaan',
            'catatan' => 'Catatan',
            'filename_grant' => 'Filename Grant',
        ];
    }
    
    public function getJenisKenderaan() {
        return $this->hasOne(\app\models\esticker\RefJenisKenderaan::className(), ['KODJENIS' => 'veh_type']);
    }
    
    public function getKodSiri() { 
        return $this->hasOne(\app\models\esticker\RefKodSiri::className(), ['veh_type' => 'veh_type'])->where(['stc_type' => 3]);
    }

    public function getPelekat() {
        return $this->hasOne(\app\models\esticker\TblPelekatKenderaanKontraktor::className(), ['id_kenderaan' => 'id']);
    } 

    public function getBiodata() {
        return $this->hasOne(\app\models\esticker\TblKontraktor::className(), ['apsu_suppid' => 'id_kontraktor']);
    }
    
    public static function checkOwnKenderaan($reg_number) {
        return TblStickerKontraktor::find()->where(['LIKE', 'reg_number', $reg_number])->exists();
    }

    public static function checkOwnKenderaanSendiri($ic) {
        return TblStickerKontraktor::find()->where(['v_co_icno' => $ic])->andWhere(['rel_owner_user'=>'DIRI SENDIRI'])->andWhere(['status_kenderaan'=>'AKTIF'])->exists();
    }

    public static function findKenderaan($id) {
        return TblStickerKontraktor::find()->where(['stc_sticker_kontraktor.id' => $id])->one();
    } 
    
    public function checkhasApplied($id) {
        return TblPelekatKenderaan::find()->where(['id_kenderaan' => $id])->one();
    }

    public static function Checking($id) {
        $check = TblStickerKontraktor::CheckTotalAktifSticker($id); //CHECK LEBIH 3 PERMOHONAN

        $check1 = TblStickerKontraktor::CheckFile($id); //CHECK ROADTAX/GRANT TERKINI

        $check2 = TblStickerKontraktor::CheckLesenTamat($id); //CHECK LESEN EXPIRED 
        //1. Check kereta 'veh_type: KERETA,LORI,VAN'
        //2. Check motor 'veh_type: MOTOSIKAL,MOTORSIKAL MELEBIHI 125CC'
        //3. Check lesen OKU

        $check3 = TblStickerKontraktor::CheckRoadtaxTamat($id); //CHECK ROADTAX EXPIRED
         
            if ($check1 === true) {
                if ($check2 === true) {
                    if ($check3 === true) {
                        return true; //pass ALL condition
                    } else {
                        return TblStickerKontraktor::CheckRoadtaxTamat($id); // return error message
                    }
                } else {
                    return TblStickerKontraktor::CheckLesenTamat($id); // return error message
                }
            } else {
                return TblStickerKontraktor::CheckFile($id); // return error message
            }
         
    }

    public static function CheckTotalAktifSticker($id) {
//        $model = TblPelekatKenderaanKontraktor::findAllPelekat($id);
//        $record = array();
//        foreach ($model as $model) {
//            if ($model->status_mohon == 'AKTIF') {
//                if (date('Y-m-d') < $model->expired_date) {
//                    $record[] = $model->kenderaan->reg_number;
//                }
//            } else {
//                $record[] = $model->kenderaan->reg_number;
//            }
//        }
//
//        $unique = array_unique($record);
//
//        if (count($unique) < 3) {
//            return true;
//        } else {
//            return 'Maaf anda mempunyai lebih daripada 3 permohonan aktif.';
//        }
    }

    public static function CheckFile($id) {
        $model = TblStickerKontraktor::findKenderaan($id);

        if (!empty($model->filename_grant)) {
            return true;
        } else {
            return 'Sila muatnaik kad kereta.';
        }
    }

    public static function CheckLesenTamat($id) {
        $model = TblStickerKontraktor::findKenderaan($id); 
        
        if (date('Y-m-d') < $model->lesen_exp) {
            return true;
        } else {
            return 'Maaf tarikh lesen anda telah tamat. Sila kemaskini maklumat lesen anda.';
        }
    }

    public static function CheckRoadtaxTamat($id) {
        $model = TblStickerKontraktor::findKenderaan($id);

        if (date('Y-m-d') < $model->roadtax_exp) {
            return true;
        } else {
            return 'Maaf tarikh roadtax anda telah tamat. Sila kemaskini maklumat kenderaan anda.';
        }
    }

}
