<?php

namespace app\models\survey;

use Yii;

/**
 * This is the model class for table "hrm.survey_tbl_votes".
 *
 * @property int $id
 * @property int $aktiviti_id survey_tbl_aktiviti ID
 * @property int $calon_id survey_tbl_calon ID
 * @property int $pengundi_id survey_tbl_pengundi ID
 * @property string $vote_dt Votes DT
 */
class TblVotes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.survey_tbl_votes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aktiviti_id', 'calon_id', 'pengundi_id'], 'integer'],
            [['vote_dt'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aktiviti_id' => 'survey_tbl_aktiviti ID',
            'calon_id' => 'survey_tbl_calon ID',
            'pengundi_id' => 'survey_tbl_pengundi ID',
            'vote_dt' => 'Votes DT',
        ];
    }

    public static function totalVoteCalon($calon_id)
    {
        $model = self::find()->where(['calon_id'=>$calon_id])->count();

        return $model;

    }

    
}
