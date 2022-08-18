<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "{{%keselamatan.stc_sticker_vip}}".
 *
 * @property int $id
 * @property int $id_lpu
 * @property string $veh_owner
 * @property string $rel_owner_user
 * @property string $reg_number
 * @property string $veh_color
 * @property string $veh_type
 * @property string $veh_brand
 * @property string $veh_model
 * @property string $roadtax_no
 * @property string $roadtax_exp
 * @property string $apply_type
 * @property string $daftar_date
 * @property string $updater
 * @property string $status_kenderaan
 * @property string $lesen_exp
 * @property int $lesen_no
 * @property string $catatan_modifikasi
 */
class TblStickerVip extends \yii\db\ActiveRecord {

    public $kod_siri, $siri;
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%keselamatan.stc_sticker_vip}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id_lpu','veh_owner','rel_owner_user','reg_number','veh_color','veh_type','veh_brand', 'veh_model'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['id_lpu', 'lesen_no'], 'integer'],
            [['kod_siri', 'siri','roadtax_exp', 'daftar_date', 'lesen_exp'], 'safe'],
            [['veh_owner'], 'string', 'max' => 100],
            [['rel_owner_user', 'veh_color'], 'string', 'max' => 30],
            [['reg_number'], 'string', 'max' => 9],
            [['veh_type', 'apply_type'], 'string', 'max' => 10],
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
            'id_lpu' => 'Nama',
            'veh_owner' => 'Pemilik Kenderaan',
            'rel_owner_user' => 'Hubungan',
            'reg_number' => 'No. Kereta',
            'veh_color' => 'Warna Kenderaan',
            'veh_type' => 'Jenis Kenderaan',
            'veh_brand' => 'Jenama Kenderaan',
            'veh_model' => 'Model Kenderaan',
            'roadtax_no' => 'Roadtax No',
            'roadtax_exp' => 'Roadtax Exp',
            'apply_type' => 'Apply Type',
            'daftar_date' => 'Daftar Date',
            'updater' => 'Updater',
            'status_kenderaan' => 'Status Kenderaan',
            'lesen_exp' => 'Lesen Exp',
            'lesen_no' => 'Lesen No',
            'catatan_modifikasi' => 'Catatan Modifikasi',
        ];
    }

     public function getJenisKenderaan() {
        return $this->hasOne(\app\models\esticker\RefJenisKenderaan::className(), ['KODJENIS' => 'veh_type']);
    }
    
    public function getKodSiri() {
        return $this->hasOne(\app\models\esticker\RefKodSiri::className(), ['veh_type' => 'veh_type'])->where(['stc_type' => 4]);
    } 
    
    public function checkOwnKenderaan($reg_number, $id) {
        return TblStickerVip::find()->where(['stc_sticker_vip.id_lpu' => $id])->where(['LIKE', 'stc_sticker_vip.reg_number', $reg_number])->exists();
    }

    public function getPelekat() {
        return $this->hasOne(\app\models\esticker\TblPelekatKenderaanVip::className(), ['id_kenderaan' => 'id']);
    }

    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\TblAhliLembagaPengarah::className(), ['id' => 'id_lpu']);
    }

    public static function findKenderaan($id) {
        return TblStickerVip::find()->where(['stc_sticker_vip.id' => $id])->joinWith('pelekat')->joinWith('biodata')->one();
    }

    public static function Checking($id) {
        $check2 = TblStickerVip::CheckLesenTamat($id); //CHECK LESEN EXPIRED  
        $check3 = TblStickerVip::CheckRoadtaxTamat($id); //CHECK ROADTAX EXPIRED 

        if ($check2 === true) {
            if ($check3 === true) {
                return true; //pass ALL condition 
            } else {
                return TblStickerVip::CheckRoadtaxTamat($id); // return error message
            }
        } else {
            return TblStickerVip::CheckLesenTamat($id); // return error message
        }
    }

    public static function CheckRoadtaxTamat($id) {
        $model = TblStickerVip::findKenderaan($id);

        if (date('Y-m-d') < $model->roadtax_exp) {
            return true;
        } else {
            return 'Maaf tarikh roadtax anda telah tamat. Sila kemaskini maklumat kenderaan anda.';
        }
    }

    public static function CheckLesenTamat($id) {
        $model = TblStickerVip::findKenderaan($id);

        if (date('Y-m-d') < $model->lesen_exp) {
            return true;
        } else {
            return 'Maaf tarikh lesen anda telah tamat. Sila kemaskini maklumat kenderaan anda.';
        }
    }

}
