<?php

namespace app\models\smp_ppi;

use Yii;

/**
 * This is the model class for table "vw_Consultation".
 *
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
 * @property string $Keterangan_MembershipID
 * @property string $Keterangan_ResearchClassification
 * @property string $KeteranganBI_ResearchClassification
 * @property string $Profit
 * @property string $Keterangan_StatusPenyelidikan
 * @property string $KeteranganBI_StatusPenyelidikan
 * @property string $ApproveStatus
 * @property string $Type
 */
class Perundingan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vw_Consultation';
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
            [['ICNo', 'Title', 'ProjectID', 'Company', 'Role', 'Keterangan_JobSector', 'KeteranganBI_JobSector', 'Keterangan_ConsultationLevelID', 'KeteranganBI_ConsultationLevelID', 'Keterangan_MembershipID', 'Keterangan_ResearchClassification', 'KeteranganBI_ResearchClassification', 'Keterangan_StatusPenyelidikan', 'KeteranganBI_StatusPenyelidikan', 'ApproveStatus', 'Type'], 'string'],
            [['TotalCost', 'Profit'], 'number'],
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
            'Keterangan_MembershipID' => 'Keterangan Membership ID',
            'Keterangan_ResearchClassification' => 'Keterangan Research Classification',
            'KeteranganBI_ResearchClassification' => 'Keterangan Bi Research Classification',
            'Profit' => 'Profit',
            'Keterangan_StatusPenyelidikan' => 'Keterangan Status Penyelidikan',
            'KeteranganBI_StatusPenyelidikan' => 'Keterangan Bi Status Penyelidikan',
            'ApproveStatus' => 'Approve Status',
            'Type' => 'Type',
        ];
    }
    
    public function getTarikh($bulan){
        
        $m = date_format(date_create($bulan), "m");
        if($m == 01){
            $m = "Januari";}
        elseif ($m == 02){
          $m = "Februari";}
        elseif ($m == 03){
          $m = "Mac";}
        elseif ($m == 04){
          $m = "April";}
        elseif ($m == 05){
          $m = "Mei";}
        elseif ($m == 06){
          $m = "Jun";}
        elseif ($m == 07){
          $m = "Julai";}
        elseif ($m == '08'){
          $m = "Ogos";}
        elseif ($m == '09'){
          $m = "September";}
        elseif ($m == '10'){
          $m = "Oktober";}
        elseif ($m == '11'){
          $m = "November";}
        elseif ($m == '12'){
          $m = "Disember";}
          
        return date_format(date_create($bulan), "d").' '.$m.' '.date_format(date_create($bulan), "Y");
    }
    public function getStartDate() {
        return  $this->getTarikh($this->StartDate);
    }
    public function getEndDate() {
        return  $this->getTarikh($this->EndDate);
    }
    public function getMembership(){
        if($this->Keterangan_MembershipID == 'Perkhidmatan Professional'){
            return 'Professional Services';
        }
        elseif($this->Keterangan_MembershipID == 'Ketua'){
            return 'Leader';
        }
        elseif($this->Keterangan_MembershipID == 'Ahli'){
            return 'Member';
        }
        if($this->Keterangan_MembershipID == 'Tiada Data'){
            return '';
        }
        else{
            return $this->Keterangan_MembershipID;
        }
    }
}
