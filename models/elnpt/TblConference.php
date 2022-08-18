<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "dbo.vw_LNPT_Conference".
 *
 * @property string $IC
 * @property string $TajukPersidangan
 * @property string $Peranan
 * @property string $Peringkat
 * @property string $TajukKertas
 * @property string $Mula
 * @property string $Tamat
 * @property string $Tempat
 * @property int $ID
 * @property string $StatusConference
 * @property int $StartYear
 */
class TblConference extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_LNPT_Conference';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db10');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TajukPersidangan', 'TajukKertas', 'Tempat'], 'string'],
            [['ID'], 'required'],
            [['ID', 'StartYear'], 'integer'],
            [['IC', 'Peranan', 'Peringkat'], 'string', 'max' => 50],
            [['Mula', 'Tamat'], 'string', 'max' => 10],
            [['StatusConference'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IC' => 'No Kp',
            'TajukPersidangan' => 'Conference/Seminar Title',
            'Peranan' => 'Role',
            'Peringkat' => 'Level',
            'TajukKertas' => 'Article`s Title',
            'Mula' => 'Mula',
            'Tamat' => 'Tamat',
            'Tempat' => 'Venue',
            'ID' => 'ID',
            'StatusConference' => 'Status Conference',
            'StartYear' => 'Start Year',
        ];
    }
}
