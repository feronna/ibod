<?php

namespace app\models\e_mou;

use Yii;

/**
 * This is the model class for table "emou.t_emou03_activity".
 *
 * @property int $activity_id
 * @property int $id_memorandum
 * @property string $order_no
 * @property string $activity_desc
 */
class TblMemorandumActivity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emou.t_emou03_activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_memorandum', 'order_no', 'activity_desc'], 'required'],
            [['id_memorandum'], 'integer'],
            [['order_no'], 'string', 'max' => 3],
            [['activity_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'activity_id' => 'Activity ID',
            'id_memorandum' => 'Id Memorandum',
            'order_no' => 'Order No',
            'activity_desc' => 'Activity Desc',
        ];
    }
}
