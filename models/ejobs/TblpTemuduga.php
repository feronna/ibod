<?php

namespace app\models\ejobs;
use app\models\ejobs\Penempatan;
use Yii;

/**
 * This is the model class for table "ejobs.tbl_temuduga".
 *
 * @property int $id
 * @property int $permohonan_id
 * @property int $status_id
 * @property int $status_kehadiran_id
 * @property int $status_saringan_iv
 * @property string $noti_iv
 * @property int $dustBstatus 0 - active, 1 - deleted
 */
class TblpTemuduga extends \yii\db\ActiveRecord
{
    public $ulasan;
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7');  // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.tbl_temuduga';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [ 
            [['permohonan_id', 'status_id', 'status_kehadiran_id', 'status_saringan_id', 'dustBstatus'], 'integer'],
            [['ulasan','noti_iv','iklan_id','ICNO', 'saringan_at', 'saringan_by', 'sah_kehadiran'], 'safe'],
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
            'status_saringan_id' => 'Status Saringan Iv',
            'noti_iv' => 'Noti Iv',
            'dustBstatus' => 'Dust Bstatus',
        ];
    }
    
    public function getPermohonan() {
        return $this->hasOne(\app\models\ejobs\TblpPermohonan::className(), ['id' => 'permohonan_id']);
    } 
    
    public function getIklan() {
        return $this->hasOne(\app\models\ejobs\Iklan::className(), ['id' => 'iklan_id']);
    }
    
    public function getKehadiranSkypeIv() {
        return $this->hasOne(\app\models\ejobs\KehadiranTemuduga::className(), ['id' => 'status_kehadiran_id']);
    }
    
    public function getKehadiranIv() {
        return $this->hasOne(\app\models\ejobs\KehadiranKompetensi::className(), ['id' => 'status_kehadiran_id']);
    }
    
    public function getStatusIv() {
        return $this->hasOne(\app\models\ejobs\StatusTemuduga::className(), ['id' => 'status_id']);
    }
}
