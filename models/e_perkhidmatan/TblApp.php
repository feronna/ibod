<?php

namespace app\models\e_perkhidmatan;

use Yii;

/**
 * This is the model class for table "{{%utilities.evc_tbl_app_details}}".
 *
 * @property int $event_id
 * @property int $event_control_type
 * @property int $quantity
 */
class TblApp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%keselamatan.utils_tbl_app_details}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'event_control_type'], 'required'],
            [['event_id', 'event_control_type', 'quantity'], 'integer'],
            [['event_id', 'event_control_type'], 'unique', 'targetAttribute' => ['event_id', 'event_control_type']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'event_id' => 'Event ID',
            'event_control_type' => 'Event Control Type',
            'quantity' => 'Quantity',
        ];
    }
}
