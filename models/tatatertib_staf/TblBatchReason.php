<?php

namespace app\models\tatatertib_staf;

use Yii;

/**
 * This is the model class for table "tatatertib_staf.tbl_batch_reason".
 *
 * @property int $id
 * @property string $reason
 */
class TblBatchReason extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tertib_tbl_batch_reason';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['reason'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'reason' => Yii::t('app', 'Reason'),
        ];
    }
}
