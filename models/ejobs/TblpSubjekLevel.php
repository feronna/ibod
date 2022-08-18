<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.tbl_subjlevel".
 *
 * @property int $id
 * @property int $subj_id
 * @property int $level
 * @property string $desc
 */
class TblpSubjekLevel extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.tbl_subjlevel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subj_id', 'level'], 'integer'],
            [['desc'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subj_id' => 'Subj ID',
            'level' => 'Level',
            'desc' => 'Desc',
        ];
    }
}
