<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.gender".
 *
 * @property string $GenderCd
 * @property string $Gender
 * @property string $GenderMM
 */
class Jantina extends \yii\db\ActiveRecord
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
        return 'hronline.gender';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['GenderCd'], 'required'],
            [['GenderCd'], 'string', 'max' => 1],
            [['Gender'], 'string', 'max' => 255],
            [['GenderMM'], 'string', 'max' => 10],
            [['GenderCd'], 'unique'],
            [['GenderBI'], 'string', 'max' => 100],
            [['isActive'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'GenderCd' => 'Gender Cd',
            'Gender' => 'Gender',
            'GenderMM' => 'Gender Mm',
        ];
    }
}
