<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.ref_doktoral".
 *
 * @property int $id
 * @property string $syarat
 * @property int $syarat_id
 * @property int $status
 */
class RefDoktoral extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_ref_doktoral';
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
}
