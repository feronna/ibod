<?php

namespace app\models\elnpt\penerbitan;

use Yii;

/**
 * This is the model class for table "dbo.vw_LNPT_PublicationV2".
 *
 * @property string $PubID
 * @property string $Title
 * @property int $PublicationYear
 * @property int $SubmissionYear
 * @property int $AcceptanceYear
 * @property string $Keterangan_PublicationStatus
 * @property string $IndexingDesc
 * @property string $Keterangan_PublicationTypeID
 * @property string $PubCategoryID
 * @property string $PubTypeId
 * @property string $ApproveStatus
 * @property string $User_Ic
 * @property int $WriterStatusID
 * @property string $KeteranganBI_WriterStatus
 * @property string $FullAuthorName
 * @property string $Publisher
 * @property int $PublicationMonth
 * @property string $PageNumber
 * @property string $Volume
 * @property string $ProsidingName
 * @property string $SeminarName
 * @property string $SourceName
 * @property string $Issue
 * @property string $CreateDate
 * @property string $ApproveDate
 */
class TblLnptPublicationV2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_LNPT_PublicationV2';
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
            [['Title', 'FullAuthorName', 'SeminarName'], 'string'],
            [['PublicationYear', 'SubmissionYear', 'AcceptanceYear', 'WriterStatusID', 'PublicationMonth'], 'integer'],
            [['CreateDate', 'ApproveDate'], 'safe'],
            [['PubID'], 'string', 'max' => 20],
            [['Keterangan_PublicationStatus', 'IndexingDesc', 'User_Ic', 'KeteranganBI_WriterStatus', 'PageNumber', 'Volume'], 'string', 'max' => 50],
            [['Keterangan_PublicationTypeID'], 'string', 'max' => 100],
            [['PubCategoryID', 'ApproveStatus'], 'string', 'max' => 1],
            [['PubTypeId'], 'string', 'max' => 2],
            [['Publisher'], 'string', 'max' => 500],
            [['ProsidingName', 'Issue'], 'string', 'max' => 2500],
            [['SourceName'], 'string', 'max' => 700],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PubID' => 'Pub ID',
            'Title' => 'Title',
            'PublicationYear' => 'Publication Year',
            'SubmissionYear' => 'Submission Year',
            'AcceptanceYear' => 'Acceptance Year',
            'Keterangan_PublicationStatus' => 'Keterangan Publication Status',
            'IndexingDesc' => 'Indexing Desc',
            'Keterangan_PublicationTypeID' => 'Keterangan Publication Type ID',
            'PubCategoryID' => 'Pub Category ID',
            'PubTypeId' => 'Pub Type ID',
            'ApproveStatus' => 'Approve Status',
            'User_Ic' => 'User Ic',
            'WriterStatusID' => 'Writer Status ID',
            'KeteranganBI_WriterStatus' => 'Keterangan Bi Writer Status',
            'FullAuthorName' => 'Full Author Name',
            'Publisher' => 'Publisher',
            'PublicationMonth' => 'Publication Month',
            'PageNumber' => 'Page Number',
            'Volume' => 'Volume',
            'ProsidingName' => 'Prosiding Name',
            'SeminarName' => 'Seminar Name',
            'SourceName' => 'Source Name',
            'Issue' => 'Issue',
            'CreateDate' => 'Create Date',
            'ApproveDate' => 'Approve Date',
        ];
    }
}
