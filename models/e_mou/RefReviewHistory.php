<?php

namespace app\models\e_mou;

use Yii;

/**
 * This is the model class for table "emou.r_emou08_review".
 *
 * @property int $review_id
 * @property string $review_desc
 */
class RefReviewHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emou.r_emou08_review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['review_desc'], 'required'],
            [['review_desc'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'review_id' => 'Review ID',
            'review_desc' => 'Review Desc',
        ];
    }
}
