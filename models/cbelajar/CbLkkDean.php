<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.cb_lkk_dean".
 *
 * @property int $id
 * @property int $sem
 * @property string $activity
 * @property int $HighestEduLevelCd
 */
class CbLkkDean extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_lkk_dean';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','sem', 'HighestEduLevelCd'], 'integer'],
            [['activity'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sem' => 'Sem',
            'activity' => 'Activity',
            'HighestEduLevelCd' => 'Highest Edu Level Cd',
        ];
    }
    
     
    public function checkUpload(){
        $model = LkkDean::find()->where(['icno' => Yii::$app->user->getId(),'dokumen' => 'id'])->all(); 
        
        return $model;
    } 
}
