<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.corporatebody".
 *
 * @property string $CorpBodyTypeCd
 * @property string $CorpBodyType
 */
class JenisBadanMajikan extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.corporatebody';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CorpBodyTypeCd'], 'required'],
            [['CorpBodyTypeCd'], 'string', 'max' => 2],
            [['CorpBodyType'], 'string', 'max' => 255],
            [['CorpBodyTypeCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CorpBodyTypeCd' => 'Corp Body Type Cd',
            'CorpBodyType' => 'Corp Body Type',
        ];
    }
}
