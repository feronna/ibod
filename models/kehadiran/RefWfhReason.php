<?php

namespace app\models\kehadiran;

use Yii;

/**
 * This is the model class for table "ref_wfh_reason".
 *
 * @property int $id
 * @property string $reason
 */
class RefWfhReason extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_wfh_reason';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reason'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reason' => 'Reason',
        ];
    }
}
