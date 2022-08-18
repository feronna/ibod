<?php

namespace app\models\system_core;

use Yii;

/**
 * This is the model class for table "system_core.tbl_pending_task".
 *
 * @property int $id
 * @property string $name
 * @property string $count
 * @property string $url
 * @property int $status
 */
class TblPendingtask extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_core.tbl_pending_task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['name', 'count', 'url', 'icon'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'count' => 'Count',
            'url' => 'Url',
            'status' => 'Status',
        ];
    }
    
    public function getCountpending(){
        return eval('return '.$this->count.';');
    }
    
    public function getStatusname(){
        return $this->status === 1? 'Enable':'Disable';
    }
}
