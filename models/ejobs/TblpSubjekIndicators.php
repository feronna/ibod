<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.tbl_subjindicators".
 *
 * @property int $id
 * @property int $subj_id
 * @property string $desc
 */
class TblpSubjekIndicators extends \yii\db\ActiveRecord
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
        return 'ejobs.tbl_subjindicators';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subj_id'], 'integer'],
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
            'desc' => 'Desc',
        ];
    }
}
