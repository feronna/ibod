<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "myidp.slotLatihan".
 *
 * @property int $slotID
 * @property int $siriLatihanID
 * @property int $slot
 * @property string $slotKini
 */
class SlotLatihan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_slotLatihan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['siriLatihanID', 'slot'], 'integer'],
            [['mataSlot'], 'number'],
            [['slotKini'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'siriLatihanID' => Yii::t('app', 'Siri Latihan ID'),
            'slotID' => Yii::t('app', 'Slot ID'),
            'slot' => Yii::t('app', 'Slot'),
            'slotKini' => Yii::t('app', 'Slot Kini'),
            'mataSlot' => Yii::t('app', 'Mata Slot'),
        ];
    }
    
    /** Relation **/
    public function getSasaran4(){
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasOne(SiriLatihan::className(), ['siriLatihanID' => 'siriLatihanID']);
    }
    
    /** Relation **/
    public function getSasaran55(){
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasOne(Kehadiran::className(), ['slotID' => 'slotID']);
    }
}
