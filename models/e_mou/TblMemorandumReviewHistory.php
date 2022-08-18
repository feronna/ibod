<?php

namespace app\models\e_mou;

use Yii;

/**
 * This is the model class for table "emou.t_emou17_reviewhistory".
 *
 * @property int $reviewhistory_id ID
 * @property int $id_memorandum Memorandum
 * @property int $id_review Semakan BPI
 * @property string $review_date Tarikh Semakan
 * @property string $review_comment Komen
 * @property string $bpt_files Dokumen Memorandum
 * @property string $bpt_files2 Kertas Dasar
 */
class TblMemorandumReviewHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emou.t_emou17_reviewhistory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_memorandum', 'id_review'], 'required'],
            [['id_memorandum', 'id_review'], 'integer'],
            [['review_date'], 'safe'],
            [['review_comment'], 'string'],
            [['bpt_files', 'bpt_files2'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reviewhistory_id' => 'Reviewhistory ID',
            'id_memorandum' => 'Id Memorandum',
            'id_review' => 'Id Review',
            'review_date' => 'Review Date',
            'review_comment' => 'Review Comment',
            'bpt_files' => 'Bpt Files',
            'bpt_files2' => 'Bpt Files2',
        ];
    }

    public function getReview()
    {
        return $this->hasOne(RefReviewHistory::className(), ['review_id' => 'id_review']);
    }
}
