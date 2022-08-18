<?php

namespace app\models\smp_ppi;

use Yii;

/**
 * This is the model class for table "dbo.vw_Research".
 *
 * @property int $ID
 * @property string $IC
 * @property string $User_Name
 * @property string $NoPer
 * @property string $Dept
 * @property string $Title
 * @property string $StartDate
 * @property string $EndDate
 * @property string $Keyword
 * @property string $Membership
 * @property string $Amount
 * @property string $AgencyName
 * @property string $ProjectID
 * @property string $ResearchStatus
 * @property string $Keterangan
 * @property string $ResearchAreaDesc
 * @property int $Y
 * @property int $GrantTypeID
 * @property string $Description
 * @property int $Duration
 * @property int $ExtraDuration
 * @property string $GrantTypeDecs
 * @property int $Research_Status
 * @property string $Researchers
 */
class Penyelidikan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_Research';
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
            [['ID', 'User_Name'], 'required'],
            [['ID', 'Y', 'GrantTypeID', 'Duration', 'ExtraDuration', 'Research_Status'], 'integer'],
            [['IC','Amount', 'User_Name', 'NoPer', 'Dept', 'Title', 'Keyword', 'Membership', 'AgencyName', 'ProjectID', 'ResearchStatus', 'Keterangan', 'ResearchAreaDesc', 'Description', 'GrantTypeDecs', 'Researchers'], 'string'],
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
            'IC' => 'Ic',
            'User_Name' => 'User Name',
            'NoPer' => 'No Per',
            'Dept' => 'Dept',
            'Title' => 'Title',
            'StartDate' => 'Start Date',
            'EndDate' => 'End Date',
            'Keyword' => 'Keyword',
            'Membership' => 'Membership',
            'Amount' => 'Amount',
            'AgencyName' => 'Agency Name',
            'ProjectID' => 'Project ID',
            'ResearchStatus' => 'Research Status',
            'Keterangan' => 'Keterangan',
            'ResearchAreaDesc' => 'Research Area Desc',
            'Y' => 'Y',
            'GrantTypeID' => 'Grant Type ID',
            'Description' => 'Description',
            'Duration' => 'Duration',
            'ExtraDuration' => 'Extra Duration',
            'GrantTypeDecs' => 'Grant Type Decs',
            'Research_Status' => 'Research Status',
            'Researchers' => 'Researchers',
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
    
    public function getResearchstatus() {
        if($this->Research_Status == '1'){
            return 'Completed';
        }
        elseif($this->Research_Status == '2'){
            return 'In Progress';
        }
        elseif($this->Research_Status == '3'){
            return 'Postponed';
        }
        elseif($this->Research_Status == '4'){
            return 'Problematic';
        }
        elseif($this->Research_Status == '5'){
            return 'Terminated';
        }
        elseif($this->Research_Status == '6'){
            return 'Sick Project';
        }
        elseif($this->Research_Status == '7'){
            return 'Entry';
        }
        elseif($this->Research_Status == '8'){
            return 'Incomplete';
        }
        else{
            return $this->ResearchStatus;
        }
    }
    
     public function getMembershipstatus() {
        if($this->Membership == 'Leader'){
            return 'Penyelidik Utama';
        }
        elseif($this->Membership == 'Member'){
            return 'Ahli';
        }
        else{
            return $this->Membershipstatus;
        }
    }
}
