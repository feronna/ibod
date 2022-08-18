<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "{{%myidp.tbl_slotlatihanjfpiu}}".
 *
 * @property int $siriLatihanID
 * @property int $slotID
 * @property int $slot
 * @property string $tarikhSlot
 * @property string $masaMula
 * @property string $masaTamat
 * @property int $mataSlot
 * @property string $slotKini
 */
class SlotLatihanJfpiu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%myidp.tbl_slotlatihanjfpiu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['siriLatihanID', 'slot', 'mataSlot'], 'integer'],
            [['tarikhSlot', 'masaMula', 'masaTamat'], 'safe'],
            [['slotKini'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'siriLatihanID' => 'Siri Latihan ID',
            'slotID' => 'Slot ID',
            'slot' => 'Slot',
            'tarikhSlot' => 'Tarikh Slot',
            'masaMula' => 'Masa Mula',
            'masaTamat' => 'Masa Tamat',
            'mataSlot' => 'Mata Slot',
            'slotKini' => 'Slot Kini',
        ];
    }
    
    /** Relation **/
    public function getSasaran4(){
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasOne(SiriLatihanJfpiu::className(), ['siriLatihanID' => 'siriLatihanID']);
    }
    
    /** Relation **/
    public function getPesertaa(){
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasMany(KehadiranJfpiu::className(), ['slotID' => 'slotID']);
    }
}
