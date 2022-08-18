<?php

namespace app\models\system_core;

use Yii;

/**
 * This is the model class for table "system_core.ref_icon".
 *
 * @property int $id
 * @property string $icon_label
 * @property int $status
 */
class RefIcon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_core.ref_icon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['icon_label'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icon_label' => 'Icon Label',
            'status' => 'Status',
        ];
    }
}
