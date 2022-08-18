<?php

namespace app\models\umsshield;

use Yii;

/**
 * This is the model class for table "dbo.Covid19SampleWatchlistStaff".
 *
 * @property string $icno
 * @property string $sampleDate
 * @property string $result
 */
class Covid19Sample extends \yii\db\ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('db12');
    }

    public static function tableName()
    {
        return 'dbo.Covid19SampleWatchlistStaff';
    }

    public function rules()
    {
        return [
            [['sampleDate'], 'safe'],
            [['icno'], 'string', 'max' => 50],
            [['result'], 'string', 'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'icno' => 'Icno',
            'sampleDate' => 'Sample Date',
            'result' => 'Result',
        ];
    }

   


}
