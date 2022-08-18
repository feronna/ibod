<?php

namespace app\models\ejobs;

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
class TblConference extends \yii\db\ActiveRecord
{ 
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
    public static function tableName()
    {
        return 'dbo.vw_Conference';
    } 
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IC', 'PaperworkTitle', 'ConferenceTitle', 'Place', 'Role', 'ConfLevel'], 'string'],
            [['StartDate', 'EndDate'], 'safe'],
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
