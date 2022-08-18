<?php

namespace app\models\e_mou;

use Yii;

/**
 * This is the model class for table "emou.r_emou05_status".
 *
 * @property int $status_id
 * @property string $status_desc
 */
class RefMemorandumStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emou.r_emou05_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_desc'], 'required'],
            [['status_desc'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'status_id' => 'Status ID',
            'status_desc' => 'Status Desc',
        ];
    }
}
