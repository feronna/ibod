<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.tbl_subjquestion".
 *
 * @property int $id
 * @property int $jawatan_id
 * @property string $question
 * @property string $panel_icno
 * @property string $created_at
 */
class TblpQuestion extends \yii\db\ActiveRecord
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
        return 'ejobs.tbl_subjquestion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jawatan_id', 'question', 'panel_icno', 'created_at'], 'required'],
            [['jawatan_id','subj_id'], 'integer'], 
            [['question'], 'string'],
            [['created_at'], 'safe'],
            [['panel_icno'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jawatan_id' => 'Jawatan ID',
            'question' => 'Question',
            'panel_icno' => 'Panel Icno',
            'created_at' => 'Created At',
        ];
    }
}
