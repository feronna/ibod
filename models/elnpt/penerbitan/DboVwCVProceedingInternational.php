<?php

namespace app\models\elnpt\penerbitan;

use Yii;

/**
 * This is the model class for table "dbo.vw_CV_ProceedingInternational".
 *
 * @property int $ID
 * @property string $PubID
 * @property string $User_Ic
 * @property string $ProceedingLevel
 * @property string $AuthorType
 * @property string $FullAuthorName
 * @property string $StartDate
 * @property string $EndDate
 * @property string $ProsidingName
 * @property string $Isbn_issn
 * @property string $Volume
 * @property string $Isu
 * @property string $Venue
 * @property int $SeminarTypeID
 * @property int $ProsidingLevel
 * @property string $PaperTitle
 * @property string $ApproveStatus
 */
class DboVwCVProceedingInternational extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_CV_ProceedingInternational';
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
            [['ID', 'PaperTitle'], 'required'],
            [['ID', 'SeminarTypeID', 'ProsidingLevel'], 'integer'],
            [['PubID', 'User_Ic', 'ProceedingLevel', 'AuthorType', 'FullAuthorName', 'ProsidingName', 'Isbn_issn', 'Volume', 'Isu', 'Venue', 'PaperTitle', 'ApproveStatus'], 'string'],
            [['StartDate', 'EndDate'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'PubID' => 'Pub ID',
            'User_Ic' => 'User Ic',
            'ProceedingLevel' => 'Proceeding Level',
            'AuthorType' => 'Author Type',
            'FullAuthorName' => 'Full Author Name',
            'StartDate' => 'Start Date',
            'EndDate' => 'End Date',
            'ProsidingName' => 'Prosiding Name',
            'Isbn_issn' => 'Isbn Issn',
            'Volume' => 'Volume',
            'Isu' => 'Isu',
            'Venue' => 'Venue',
            'SeminarTypeID' => 'Seminar Type ID',
            'ProsidingLevel' => 'Prosiding Level',
            'PaperTitle' => 'Paper Title',
            'ApproveStatus' => 'Approve Status',
        ];
    }
}
