<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.ref_latihan".
 *
 * @property int $id
 * @property string $syarat
 * @property int $status
 */
class RefLatihanIndustri extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_ref_latihan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['syarat'], 'string'],
            [['status'], 'integer'],
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
            'status' => 'Status',
        ];
    }
}
