<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.status_permohonan".
 *
 * @property int $id
 * @property string $name
 * @property string $status_desc
 * @property string $label
 */
class StatusPermohonan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cbelajar.status_permohonan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status_desc', 'label'], 'required'],
            [['status_desc'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['label'], 'string', 'max' => 20],
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
            'status_desc' => 'Status Desc',
            'label' => 'Label',
        ];
    }
}
