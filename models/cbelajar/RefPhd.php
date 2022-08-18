<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.ref_phd".
 *
 * @property int $id
 * @property string $syarat
 * @property string $syarat_id
 * @property int $status
 * @property int $HighestEduLevelCd
 */
class RefPhd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_ref_phd';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['syarat'], 'string'],
            [['status', 'HighestEduLevelCd'], 'integer'],
            [['syarat_id'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'syarat' => 'Syarat',
            'syarat_id' => 'Syarat ID',
            'status' => 'Status',
            'HighestEduLevelCd' => 'Highest Edu Level Cd',
        ];
    }
    
     public function checkWarganegara($id){
        $model = StatusWarganegara::findOne(['NatStatusCd' => Yii::$app->user->getId(),'NatStatusCd' => $id]); 
        
        return $model;
    } 
     public function getPendidikanTertinggi() {
        return $this->hasOne(PendidikanTertinggi::className(), ['HighestEduLevelCd'=>'HighestEduLevelCd']);
    }

     public function getTahapPendidikan() {
        
        return $this->pendidikanTertinggi->HighestEduLevel;
    }
}
