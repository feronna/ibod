<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "e_sticker.pelekat_kenderaan".
 *
 * @property int $id
 * @property string $status_mohon
 * @property string $mohon_date
 * @property string $app_date
 * @property string $no_siri
 * @property string $apply_type
 * @property string $updater
 * @property string $expired_date
 * @property int $id_kenderaan
 * @property string $total
 */
class TblPelekatKenderaanStudent extends \yii\db\ActiveRecord {

    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.stc_pelekat_kenderaan_student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [ 
            [['apply_type','siri','no_resit'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['kod_siri','mohon_date', 'app_date', 'expired_date','expired_date_2','deleted','catatan','reg_number'], 'safe'],
            [['siri'], 'number'],
            [['siri'], 'string', 'min' => 6, 'max' => 6],
            [['id_kenderaan'], 'integer'],
            [['total'], 'number'],
            [['status_mohon'], 'string', 'max' => 30],
            [['no_siri', 'updater'], 'string', 'max' => 15],
            [['apply_type','no_resit'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'status_mohon' => 'Status Permohonan',
            'mohon_date' => 'Tarikh Mohon',
            'app_date' => 'Tarikh Diluluskan',
            'no_siri' => 'No. Siri',
            'no_resit' => 'No. Resit',
            'apply_type' => 'Jenis Permohonan',
            'updater' => 'Pengemaskini',
            'expired_date' => 'Tarikh Luput Pelekat',
            'id_kenderaan' => 'Id Kenderaan',
            'total' => 'Harga Pelekat (RM)',
        ];
    }  
    public static function totalPending($category) {
        $count = TblPelekatKenderaanStudent::find()->where(['status_mohon' => $category])->andWhere(['deleted' => 0])->count();

        return '&nbsp;<span class="badge bg-red">' . $count . '</span>';
    }

    
    public function findPelekat($id) {
        return TblPelekatKenderaanStudent::findOne(['id_kenderaan' => $id]);
    }
    
    public function findOwnPelekat($id) {
        return TblPelekatKenderaanStudent::findOne(['id' => $id]);
    }
    
    public function findAllPelekat() {
        return TblPelekatKenderaanStudent::find()->joinWith('kenderaan')->where(['stc_sticker_student.v_co_icno' => Yii::$app->user->getId()])->andWhere(['stc_sticker_student.status_kenderaan' => 'AKTIF'])->all();
    }
    
    public function findPelekatDiterima($id) {
        return TblPelekatKenderaanStudent::find()->where(['id_kenderaan' => $id])->andWhere(['status_mohon' => 'DIHANTAR'])->one();
    }
    
    public function findPelekatMenungguKutipan($id) {
        return TblPelekatKenderaanStudent::find()->where(['id_kenderaan' => $id])->andWhere(['status_mohon' => 'MENUNGGU KUTIPAN'])->one();
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\User::className(), ['ICNO' => 'updater']);
    }
    
    public function getKenderaan() {
        return $this->hasOne(\app\models\esticker\TblStickerStudent::className(), ['id' => 'id_kenderaan']);
    }
    
    public function getUser() {
        return $this->hasOne(\app\models\esticker\TblStickerStudent::className(), ['id' => 'id_kenderaan']);
    } 
}
