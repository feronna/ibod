<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.country".
 *
 * @property string $CountryCd
 * @property string $Country
 * @property int $StudyExtPeriod
 * @property string $CountryCdMM
 */
class Warganegara extends \yii\db\ActiveRecord
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
        return 'hronline.country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CountryCd'], 'required'],
            [['StudyExtPeriod'], 'integer'],
            [['CountryCd'], 'string', 'max' => 3],
            [['Country'], 'string', 'max' => 255],
            [['CountryCdMM'], 'string', 'max' => 20],
            [['CountryCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CountryCd' => 'Country Cd',
            'Country' => 'Country',
            'StudyExtPeriod' => 'Study Ext Period',
            'CountryCdMM' => 'Country Cd Mm',
        ];
    }
}
