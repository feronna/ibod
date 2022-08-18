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
class Country extends \yii\db\ActiveRecord
{
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
