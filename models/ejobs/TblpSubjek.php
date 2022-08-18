<?php

namespace app\models\ejobs; 
use Yii;

/**
 * This is the model class for table "ejobs.tbl_subj".
 *
 * @property int $id
 * @property string $subj
 * @property string $created_at
 * @property string $created_by
 */
class TblpSubjek extends \yii\db\ActiveRecord
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
        return 'ejobs.tbl_subj';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subj', 'created_at', 'created_by','desc'], 'required'],
            [['created_at','desc'], 'safe'],
            [['subj'], 'string', 'max' => 150],
            [['created_by'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subj' => 'Subj',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    } 
    
    public function getLevel() {
        return $this->hasMany(\app\models\ejobs\TblpSubjekLevel::className(), ['subj_id' => 'id']);
    }
    
    public function getIndicators() {
        return $this->hasMany(\app\models\ejobs\TblpSubjekIndicators::className(), ['subj_id' => 'id']);
    }
}
