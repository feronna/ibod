<?php

namespace app\models\hronline;

use Yii;
use yii\helpers\Html;
use app\models\hronline\Institut;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\Penaja;
use app\models\hronline\MajorMinor;
//audit trail
use app\models\hronline\Updatestatus;
use app\models\hronline\Tblstat;

/**
 * This is the model class for table "hronline.tblpreduach".
 *
 * @property string $ICNO
 * @property string $InstCd
 * @property int $HighestEduLevelCd
 * @property string $SponsorshipCd
 * @property string $Sponsorship
 * @property string $MajorCd
 * @property string $MinorCd
 * @property string $EduCertTitle
 * @property string $EduCertTitleBI
 * @property string $ConfermentDt
 * @property string $OverallGrade
 * @property int $AcrtdEduAch
 * @property int $id
 * @property string $filename
 */
class Tblpendidikan extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public $file;

    public static function tableName()
    {
        return 'hronline.tblpreduach';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO','HighestEduLevelCd','AcrtdEduAch','ConfermentDt','InstCd','SponsorshipCd','EduCertTitle', 'EduCertTitleBI','MajorCd','OverallGrade','Bon'], 'required', 'message'=>'Ruang ini adalah mandatori'],
            ['Sponsorship', 'required', 'when'=> function($model){
                return $model->SponsorshipCd == '9999';
            },'whenClient'=>"function(attribute, value){
               return $('#SponsorshipCd').val() == '9999';     
            }",'message'=>'Ruang ini adalah mandatori'],
            ['JumlahBon', 'required', 'when'=> function($model){
                return $model->Bon == '1';
            },'whenClient'=>"function(attribute, value){
               return $('#jumlahbon').val() == '1';     
            }",'message'=>'Ruang ini adalah mandatori'],
            [['HighestEduLevelCd', 'AcrtdEduAch','Bon'], 'integer'],
            [['ConfermentDt'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
            [['InstCd'], 'string', 'max' => 8],
            [['SponsorshipCd'], 'string', 'max' => 4],
            [['filename'], 'string', 'max' => 100],
            [['Sponsorship'], 'string', 'max' => 200],
            [['MajorCd', 'MinorCd'], 'string', 'max' => 6],
            [['EduCertTitle', 'EduCertTitleBI'], 'string', 'max' => 100],
            [['OverallGrade'], 'string', 'max' => 20],
            [['file'], 'file','extensions'=>['pdf','jpg','jpeg','png'], 'maxSize'=>6666240, 'tooBig' => 'Limit is 6MB'],
            [['SerialNo'], 'string', 'max'=>15],
            [['InstNm'],'string','max'=>100],
            [['JumlahBon'],'string','max'=>4],
            [['HighEdu'],'integer'],
            [['StartEduDt'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
            'InstCd' => 'Inst Cd',
            'HighestEduLevelCd' => 'Highest Edu Level Cd',
            'SponsorshipCd' => 'Sponsorship Cd',
            'Sponsorship' => 'Sponsorship',
            'MajorCd' => 'Major Cd',
            'MinorCd' => 'Minor Cd',
            'EduCertTitle' => 'Edu Cert Title',
            'EduCertTitleBI' => 'Edu Cert Title Bi',
            'ConfermentDt' => 'Conferment Dt',
            'OverallGrade' => 'Overall Grade',
            'AcrtdEduAch' => 'Acrtd Edu Ach',
            'id' => 'ID',
            'StartEduDt' => 'Start Education Date',
        ];
    }
    
    public function getInstitut() {
        return $this->hasOne(Institut::className(), ['InstCd'=>'InstCd']);
    }

    public function getInstNm(){
        if ($this->InstNm) {
            return $this->InstNm;
        }
        return '-';
    }
    
    public function getPendidikanTertinggi() {
        return $this->hasOne(PendidikanTertinggi::className(), ['HighestEduLevelCd'=>'HighestEduLevelCd']);
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
       if(is_numeric($this->SponsorshipCd)){
           
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

    public function getBon(){
        if ($this->Bon) {
            return 'Ada';
        }
        return 'Tiada';
    }

    public function getJumlahBon(){
        if ($this->JumlahBon) {
            return $this->JumlahBon . ' Bulan';
        }
        return '-';
    }
    
    public function getNamamajor() {
        if($this->major){
            return $this->major->MajorMinor;
        }
        
         return "Tidak Berkaitan";
    }
    
    public function getNamaminor() {
        if($this->minor){
            return $this->minor->MajorMinor;
        }
        
        return "Tidak berkaitan";
    }
    
    
    
    public function getTahapPendidikan() {
        
        if($this->pendidikanTertinggi){
          return $this->pendidikanTertinggi->HighestEduLevel;
        }
        
        return '-';
    }
    public function getAdminTahapPendidikan() {
        $value = $this->pendidikanTertinggi->HighestEduLevel;
        
        if($this->HighestEduLevelCd == 13 || $this->HighestEduLevelCd == 14 || $this->HighestEduLevelCd == 15){
          $value = Html::a('<u>'.$this->pendidikanTertinggi->HighestEduLevel.'</u>', ['pendidikan/adminview-subjek', 'id'=>$this->HighestEduLevelCd, 'icno'=>$this->ICNO]);   
        }
        
        return $value;
    }
    
    public function getNamainstitut() {
        if ($this->institut) {
            return $this->institut->InstNm ;
        }
        return '-';
    }
    
    public function getConfermentDt() {
        return Yii::$app->MP->Tarikh($this->ConfermentDt);
    }
    
    public function getSerialNo(){
        if ($this->SerialNo) {
            return $this->SerialNo;
        }
        return '-';
    }

    public function getGredkeseluruhan() {
        if($this->OverallGrade){
            return $this->OverallGrade;
        }
        return "tidak berkaitan";
    }
    
    public function getDiiktiraf() {
        if(!empty($this->AcrtdEduAch)){
            if($this->AcrtdEduAch){
                return 'Diiktiraf';
            }
            return 'Tidak Diiktiraf';
        }
        return "Tidak Berkaitan";
        
    }
    
    public function getDisplayLink() {
        if(!empty($this->filename) && $this->filename != 'deleted'){
        return html::a(Yii::$app->FileManager->NameFile($this->filename), Yii::$app->FileManager->DisplayFile($this->filename), ['target'=>'_blank']);
        }
        return 'File not exist!';
    }
    
    
    
    //log for Create, update or delete data.
    // public function beforeSave1($insert)
    public function beforeSave($insert)
    {   
        if(!parent::beforeSave($insert)){
            return false;
        }

        $changes = [];
        $tempObj = self::findOne(['id'=>$this->id]);
        $attrib = $this->activeAttributes();

        switch ($insert) {
            case (false):
                $activity = 1;
                for($i=0;$i<count($attrib);$i++){

                    if($tempObj->{$attrib[$i]}!=$this->{$attrib[$i]}){
                        array_push($changes,[$attrib[$i],$tempObj->{$attrib[$i]},$this->{$attrib[$i]}]);   
                    }
           
                }
                break;
            
            default:
                //aftersave will handle it;
                break;
        }
        if(count($changes)>0)
        {   
            //log activity to updatestatus table
            $log = new Updatestatus();
            $log->usern = $tempObj->ICNO;//Yii::$app->user->getId();
            $log->COTableName = $this->tableName();
            $log->COActivity = $activity;
            $log->COUpadteDate = date('Y-m-d H:i:s');
            $log->COUpdateIP = Yii::$app->request->getRemoteIP();
            $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            $log->COUpdateCompUser = Yii::$app->user->getId();
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);
            
                //save to tbl_stat
                $stat = Tblstat::find()->where(['ICNO'=>$this->ICNO,'table'=>$this->tableName(),'idval'=>$this->id])->one();
                if($stat==null)
                {
                    $stat = new Tblstat();
                    $stat->ICNO = $this->ICNO;
                    $stat->table = $this->tableName();
                    $stat->idval = $this->id;
                }
                $stat->status = 1;
                $stat->date_submit = date('Y-m-d H:i:s');
                $stat->save(false);

                Yii::$app->MP->BiodataLastUpdate($this->ICNO);
        }
        return true;
    }
    
    // public function afterSave1($insert, $changedAttributes)
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            //save to tbl_stat
            $stat = new Tblstat();
            $stat->ICNO = $this->ICNO;
            $stat->table = $this->tableName();
            $stat->idval = $this->id;
            $stat->status = 0;
            $stat->date_submit = date('Y-m-d H:i:s');
            $stat->save(false);

            $changes = [];
            //$tempObj = self::findOne(['id' => $this->id]);
            $attrib = $this->activeAttributes();
            $activity = 0;

            for ($i = 0; $i < count($attrib); $i++) {
                array_push($changes, [$attrib[$i], $this->{$attrib[$i]}]);
            }

            $log = new Updatestatus();
            $log->usern = $this->ICNO; //Yii::$app->user->getId();
            $log->COTableName = $this->tableName();
            $log->COActivity = $activity;
            $log->COUpadteDate = date('Y-m-d H:i:s');
            $log->COUpdateIP = Yii::$app->request->getRemoteIP();
            $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            $log->COUpdateCompUser = Yii::$app->user->getId();
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);

            Yii::$app->MP->BiodataLastUpdate($this->ICNO);

        }else{
            //beforeSave() handle it
        }

        //UPDATE BIODATA
        self::UpdateBiodataPendidikan();

        return true;
    }

    public function beforeDelete()
    {   
        if (!parent::beforeDelete()) {
            return false;
        }

        $changes = []; 
     
        //get list of attributes
        $attrib = $this->activeAttributes();
        
        for($i=0;$i<count($attrib);$i++)
        {
            array_push($changes,array($attrib[$i],$this->{$attrib[$i]}));
        }
        //log activity to updatestatus table
        $log = new Updatestatus();
        $log->usern = $this->ICNO;
        $log->COTableName = $this->tableName();
        $log->COActivity = 2;
        $log->COUpadteDate = date('Y-m-d H:i:s');
        $log->COUpdateIP = Yii::$app->request->getRemoteIP();        
        $log->COUpdateComp = Yii::$app->request->getRemoteIP();
        $log->COUpdateCompUser = Yii::$app->user->getId();
        $log->COUpdateSQL = serialize($changes);
        $log->save(false);
        $stat = Tblstat::find()->where(['ICNO'=>$this->ICNO, 'table'=>$this->tableName(),'idval'=>$this->id])->one();
        if($stat == null)
            return true;
            
        $stat->delete();
        
        return true;
    }

    public function afterDelete()
    {
         //UPDATE BIODATA;
         self::UpdateBiodataPendidikan();

         //ada function update biodata di atas, so xperlu panggil function ini lagi.
         //Yii::$app->MP->BiodataLastUpdate($this->ICNO);

        parent::afterDelete();
    }

    public function UpdateBiodataPendidikan(){
        $biodata = Tblprcobiodata::findOne($this->ICNO);
        $tblpendidikan = Tblpendidikan::find()->joinWith('pendidikanTertinggi')->where(['ICNO'=>$this->ICNO])->asArray()->all();
        if(!empty($tblpendidikan)){
            $tblpendidikan = self::susunPendidikan($tblpendidikan);
            $biodata->HighestEduLevelCd = $tblpendidikan[0]['HighestEduLevelCd'];
            $biodata->ConfermentDt = $tblpendidikan[0]['ConfermentDt'];
            $biodata->save(false);
        }else{
            $biodata->HighestEduLevelCd = null;
            $biodata->ConfermentDt = null;
            $biodata->save(false);
        }
        return true;
    }

    private function susunPendidikan($array){
        for ($i=0; $i < count($array); $i++) { 
            for ($j=0; $j < count($array); $j++) { 
                if($array[$i]['pendidikanTertinggi']['HighestEduLevelRank'] > $array[$j]['pendidikanTertinggi']['HighestEduLevelRank'] &&  $i < $j ){
                 
                    $temp = $array[$i];
                    $array[$i] = $array[$j];
                    $array[$j] = $temp;
                }
                else if($array[$i]['pendidikanTertinggi']['HighestEduLevelRank'] == $array[$j]['pendidikanTertinggi']['HighestEduLevelRank'] &&  $i < $j){

                    // $array[$i]['title'] = $array[$i]['title'] .' '. $array[$j]['title'];
                    // array_splice($array,$j,1);
                    // $j--;

                } 
                else{

                }
            }
        }
        return $array;
    }
   
}
