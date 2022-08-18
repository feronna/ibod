<?php

namespace app\models\smp_ppi;

use Yii;

/**
 * This is the model class for table "dbo.vw_Conference".
 *
 * @property string $IC
 * @property string $PaperworkTitle
 * @property string $ConferenceTitle
 * @property string $Place
 * @property string $StartDate
 * @property string $EndDate
 * @property string $Role
 * @property string $ConfLevel
 */
class Persidangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_Conference';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db6');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PaperworkTitle', 'ConferenceTitle', 'Place'], 'string'],
            [['StartDate', 'EndDate'], 'safe'],
            [['IC', 'Role', 'ConfLevel'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IC' => 'Ic',
            'PaperworkTitle' => 'Paperwork Title',
            'ConferenceTitle' => 'Conference Title',
            'Place' => 'Place',
            'StartDate' => 'Start Date',
            'EndDate' => 'End Date',
            'Role' => 'Role',
            'ConfLevel' => 'Conf Level',
        ];
    }
}
