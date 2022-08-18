<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "dbo.vw_Consultation".
 *
 * @property string $ConsultationType
 * @property int $ID
 * @property string $ICNo
 * @property string $Title
 * @property string $ProjectID
 * @property string $Company
 * @property string $Role
 * @property string $Keterangan_JobSector
 * @property string $KeteranganBI_JobSector
 * @property string $TotalCost
 * @property string $StartDate
 * @property string $EndDate
 * @property string $Keterangan_ConsultationLevelID
 * @property string $KeteranganBI_ConsultationLevelID
 * @property string $Keterangan_ResearchClassification
 * @property string $KeteranganBI_ResearchClassification
 * @property string $Profit
 * @property string $Keterangan_StatusPenyelidikan
 * @property string $KeteranganBI_StatusPenyelidikan
 * @property string $ApproveStatus
 * @property string $Type
 * @property string $Keterangan_MembershipID
 */
class TblConsultancy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_Consultation';
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
            [['ID', 'ICNo', 'Title', 'Company', 'Role', 'TotalCost', 'Profit'], 'required'],
            [['ID'], 'integer'],
            [['TotalCost', 'Profit'], 'number'],
            [['StartDate', 'EndDate'], 'safe'],
            [['ConsultationType'], 'string', 'max' => 20],
            [['ICNo', 'ProjectID', 'Keterangan_JobSector', 'KeteranganBI_JobSector', 'Keterangan_ConsultationLevelID', 'KeteranganBI_ConsultationLevelID', 'Keterangan_ResearchClassification', 'KeteranganBI_ResearchClassification', 'Keterangan_StatusPenyelidikan', 'KeteranganBI_StatusPenyelidikan'], 'string', 'max' => 50],
            [['Title', 'Company', 'Role'], 'string', 'max' => 500],
            [['ApproveStatus', 'Type'], 'string', 'max' => 1],
            [['Keterangan_MembershipID'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ConsultationType' => 'Consultation Type',
            'ID' => 'ID',
            'ICNo' => 'Ic No',
            'Title' => 'Title',
            'ProjectID' => 'Project ID',
            'Company' => 'Company',
            'Role' => 'Role',
            'Keterangan_JobSector' => 'Keterangan Job Sector',
            'KeteranganBI_JobSector' => 'Keterangan Bi Job Sector',
            'TotalCost' => 'Total Cost',
            'StartDate' => 'Start Date',
            'EndDate' => 'End Date',
            'Keterangan_ConsultationLevelID' => 'Keterangan Consultation Level ID',
            'KeteranganBI_ConsultationLevelID' => 'Keterangan Bi Consultation Level ID',
            'Keterangan_ResearchClassification' => 'Keterangan Research Classification',
            'KeteranganBI_ResearchClassification' => 'Keterangan Bi Research Classification',
            'Profit' => 'Profit',
            'Keterangan_StatusPenyelidikan' => 'Keterangan Status Penyelidikan',
            'KeteranganBI_StatusPenyelidikan' => 'Keterangan Bi Status Penyelidikan',
            'ApproveStatus' => 'Approve Status',
            'Type' => 'Type',
            'Keterangan_MembershipID' => 'Keterangan Membership ID',
        ];
    }
}
