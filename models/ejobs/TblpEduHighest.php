<?php

namespace app\models\ejobs;

use Yii;
use yii\helpers\Html;
use app\models\hronline\Institut;
use app\models\hronline\PendidikanTertinggi;
use app\models\ejobs\PendidikanRank;
use app\models\hronline\Penaja;
use app\models\hronline\MajorMinor;
use app\models\hronline\Tblpendidikan;
/**
 * This is the model class for table "ejobs.tbl_eduhighest".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $InstCd
 * @property string $InstNm
 * @property int $HighestEduLevelCd
 * @property string $SponsorshipCd
 * @property string $SponsorshipNm
 * @property string $MajorCd
 * @property string $MinorCd
 * @property string $EduCertTitle
 * @property string $EduCertTitleBI
 * @property string $ConfermentDt
 * @property string $OverallGrade
 * @property int $AcrtdEduAch
 */
class TblpEduHighest extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    public $file ;
    public static function tableName()
    {
        return 'ejobs.tbl_eduhighest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO','Bon', 'InstCd', 'HighestEduLevelCd', 'SponsorshipCd', 'MajorCd', 'EduCertTitle', 'EduCertTitleBI', 'ConfermentDt', 'OverallGrade'], 'required', 'message'=>'Required'],
            [['HighestEduLevelCd', 'AcrtdEduAch'], 'integer'],
            [['ConfermentDt','file','FileSisraf','JumlahBon'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
            [['InstCd'], 'string', 'max' => 8],
            [['InstNm', 'SponsorshipNm'], 'string', 'max' => 200],
            [['SponsorshipCd'], 'string', 'max' => 4],
            [['MajorCd', 'MinorCd'], 'string', 'max' => 6],
            [['EduCertTitle', 'EduCertTitleBI'], 'string', 'max' => 100],
            [['OverallGrade'], 'string', 'max' => 20], 
            [['file'], 'file','extensions'=>'pdf', 'maxSize' => 1024 * 1024 * 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'InstCd' => 'Institusi',
            'InstNm' => 'Nama Institusi',
            'HighestEduLevelCd' => 'Tahap Pendidikan',
            'SponsorshipCd' => 'Tajaan',
            'SponsorshipNm' => 'Nama Tajaan',
            'MajorCd' => 'Major',
            'MinorCd' => 'Minor',
            'EduCertTitle' => 'Nama Sijil (Malay)',
            'EduCertTitleBI' => 'Nama Sijil (English)',
            'ConfermentDt' => 'Tarikh Dianugerahkan',
            'OverallGrade' => 'Gred Keseluruhan',
            'AcrtdEduAch' => 'Status Pengiktirafan',
        ];
    }
    
    public function getInstitut() {
        return $this->hasOne(Institut::className(), ['InstCd'=>'InstCd']);
    }
    
    public function getPendidikanTertinggi() {
        return $this->hasOne(PendidikanTertinggi::className(), ['HighestEduLevelCd'=>'HighestEduLevelCd']);
    }
    
    public function getPendidikanRank() {
        return $this->hasOne(PendidikanRank::className(), ['HighestEduLevelCd'=>'HighestEduLevelCd']);
    }
    
    public function getPenaja() {
        return $this->hasOne(Penaja::className(), ['SponsorshipCd'=>'SponsorshipCd']);           
    }
    
    public function getMajor() {
        return $this->hasOne(MajorMinor::className(), ['MajorMinorCd'=>'MajorCd']);
    }
    
    public function getMinor() {
        return $this->hasOne(MajorMinor::className(), ['MajorMinorCd'=>'MinorCd']);
    }
    
    public function getNamapenaja() {
     if($this->SponsorshipCd){
         
       if(is_int($this->SponsorshipCd)){
           
        if($this->SponsorshipCd == 9999){
            return $this->Sponsorship;
        }
        return $this->penaja->SponsorshipNm;
       }
       else{
           return "Tidak Berkaitan";
       }
     }
     
     return "Tiada Maklumat";
    }
    
    public function getNamamajor() {
        if($this->MajorCd){
            return $this->major->MajorMinor;
        }
        
         return "Tidak Berkaitan";
    }
    
    public function getNamaminor() {
        if($this->MinorCd){
            return $this->minor->MajorMinor;
        }
        
        return "Tidak berkaitan";
    }
    
    
    
    public function getTahapPendidikan() {
        $value = $this->pendidikanTertinggi->HighestEduLevel;
        
        if($this->HighestEduLevelCd == 14 || $this->HighestEduLevelCd == 15){
          $value = Html::a('<u>'.$this->pendidikanTertinggi->HighestEduLevel.'</u>', ['subjek/index', 'EduAch_id'=>$this->id, 'ICNO'=>$this->ICNO, 'EduCd'=>$this->HighestEduLevelCd]);   
        }
        
        return $value;
    }
    
    public function getNamainstitut() {
        
        return $this->institut->InstNm ;
    }
    
    public function getGredkeseluruhan() {
        if($this->OverallGrade){
            return $this->OverallGrade;
        }
        return "No information";
    }
    
    public function Tarikh($bulan){
        
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
    
    public function LaporDiri($ICNO) {
        $model = TblpEduHighest::findAll(['ICNO'=>$ICNO]);
        $simpan = new Tblpendidikan();
        
        if($model){
            foreach ($model as $model){
                $simpan->ICNO = $model->ICNO;
                $simpan->InstCd = $model->InstCd;
                $simpan->InstNm = $model->InstNm;
                $simpan->HighestEduLevelCd = $model->HighestEduLevelCd;
                $simpan->SponsorshipCd = $model->SponsorshipCd; 
                $simpan->Sponsorship = $model->SponsorshipNm;
                $simpan->MajorCd = $model->MajorCd;
                $simpan->MinorCd = $model->MinorCd;
                $simpan->EduCertTitle = $model->EduCertTitle; 
                $simpan->EduCertTitleBI = $model->EduCertTitleBI; 
                $simpan->ConfermentDt = $model->ConfermentDt;
                $simpan->OverallGrade = $model->OverallGrade; 
                $simpan->AcrtdEduAch = $model->AcrtdEduAch; 
                $simpan->Bon = $model->Bon;
                $simpan->JumlahBon = $model->JumlahBon; 
                $simpan->HighEdu = 0; //undeclare
                $simpan->save(false);
            }
        } 
    } 
}
