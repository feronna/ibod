<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.tbl_kompetensi".
 *
 * @property int $id
 * @property int $permohonan_id
 * @property int $status_id
 * @property int $status_kehadiran_id
 * @property int $status_saringan_id
 * @property string $noti_komp
 * @property int $dustBstatus 0 - active, 1 - deleted
 */
class TblpKompetensi extends \yii\db\ActiveRecord
{
    public $ulasan;
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.tbl_kompetensi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [ 
            [['permohonan_id', 'status_id', 'status_kehadiran_id', 'status_saringan_id', 'dustBstatus'], 'integer'],
            [['ulasan','noti_komp','iklan_id','ICNO', 'sah_kehadiran'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'permohonan_id' => 'Permohonan ID',
            'iklan_id' => 'Iklan ID',
            'status_id' => 'Status ID',
            'status_kehadiran_id' => 'Status Kehadiran ID',
            'status_saringan_id' => 'Status Saringan ID',
            'noti_komp' => 'Noti Komp',
            'dustBstatus' => 'Dust Bstatus',
        ];
    }
    
    public function getPermohonan() {
        return $this->hasOne(\app\models\ejobs\TblpPermohonan::className(), ['id' => 'permohonan_id']);
    }
    
    public function getIklan() {
        return $this->hasOne(\app\models\ejobs\Iklan::className(), ['id' => 'iklan_id']);
    }
    
    public function getKehadiranKomp() {
        return $this->hasOne(\app\models\ejobs\KehadiranKompetensi::className(), ['id' => 'status_kehadiran_id']);
    }
    
    public function getStatusKomp() {
        return $this->hasOne(\app\models\ejobs\StatusKompetensi::className(), ['id' => 'status_id']);
    }
}
