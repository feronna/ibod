<?php

namespace app\models\cbelajar;

use Yii;
use app\models\hronline\StatusWarganegara;

/**
 * This is the model class for table "cbelajar.tbl_syarat".
 *
 * @property int $id
 * @property string $syarat
 * @property int $syarat_id
 * @property int $status
 */
class TblSyarat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_syarat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['syarat'], 'string'],
            [['syarat_id', 'status'], 'integer'],
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
        ];
    }

     public function checkWarganegara($id){
        $model = StatusWarganegara::findOne(['NatStatusCd' => Yii::$app->user->getId(),'NatStatusCd' => $id]); 
        
        return $model;
    } 
}
