<?php

namespace app\models\hronline;

use Yii;
use yii\helpers\Html;
use app\models\hronline\JenisAkaun;
use app\models\hronline\TujuanAkaun;
use app\models\hronline\NamaAkaun;
use app\models\hronline\Bandar;
use app\models\hronline\CawanganAkaun;
//audit trail
use app\models\hronline\Updatestatus;
use app\models\hronline\Tblstat;

/**
 * This is the model class for table "hronline.tblpracc".
 *
 * @property string $ICNO
 * @property string $AccNo
 * @property string $AccTypeCd
 * @property string $AccPurposeCd
 * @property string $AccNmCd
 * @property string $CityCd
 * @property int $AccStatus
 * @property string $AccBranch
 * @property string $AccBranchCd
 * @property int $id
 */
class Tblakaun extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    public $file ;
    
    public static function tableName()
    {
        return 'hronline.tblpracc';
    }

    public function rules()
    {
        return [
            [['ICNO', 'AccNo', 'AccTypeCd', 'AccPurposeCd', 'AccNmCd', 'CityCd', 'AccBranch'], 'required','message'=>'Ruang ini adalah mandatori'],
            [['AccStatus'], 'integer'],
            [['ICNO'], 'string', 'max' => 12],
            [['AccNo', 'AccBranchCd'], 'string', 'max' => 20],
            [['AccTypeCd', 'AccPurposeCd'], 'string', 'max' => 2],
            [['AccNmCd'], 'string', 'max' => 4],
            [['CityCd'], 'string', 'max' => 6],
            [['AccBranch'], 'string', 'max' => 50],
            [['ICNO', 'AccNo'], 'unique', 'targetAttribute' => ['ICNO', 'AccNo'],'message'=>'No. Akaun telah wujud '],
            [['file'], 'file','extensions'=>['pdf','jpg','png','jpeg'] , 'maxSize'=>6666240, 'tooBig' => 'Limit is 6MB'],
            [['file'],'safe'],
            
        ];
    }

    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
            'AccNo' => 'Acc No',
            'AccTypeCd' => 'Acc Type Cd',
            'AccPurposeCd' => 'Acc Purpose Cd',
            'AccNmCd' => 'Acc Nm Cd',
            'CityCd' => 'City Cd',
            'AccStatus' => 'Acc Status',
            'AccBranch' => 'Acc Branch',
            'AccBranchCd' => 'Acc Branch Cd',
            'id' => 'ID',
        ];
    }
    
    public function getJenisAkaun() {
        return $this->hasOne(JenisAkaun::className(), ['AccTypeCd'=>'AccTypeCd']);
    }
    
    public function getTujuanAkaun() {
        return $this->hasOne(TujuanAkaun::className(), ['AccPurposeCd'=>'AccPurposeCd']);
    }
    
    public function getNamaAkaun() {
        return $this->hasOne(NamaAkaun::className(), ['AccNmCd'=>'AccNmCd']);
    }
    
    public function getBandar() {
        return $this->hasOne(Bandar::className(), ['CityCd'=>'CityCd']);
    }
    
    public function getCawanganAkaun() {
        return $this->hasOne(CawanganAkaun::className(), ['AccBranchCd'=>'AccBranchCd']);
    }
    
    //display functions
    
    public function getJenakaun() {
        if($this->jenisAkaun){
            return $this->jenisAkaun->AccType;
        }
        return '-';
    }
    public function getTujakaun() {
        if($this->tujuanAkaun){
            return $this->tujuanAkaun->AccPurpose;
        }
        return '-';
    }
    public function getNamakaun() {
        if($this->namaAkaun){
            return $this->namaAkaun->AccNm;
        }
        return '-';
    }
    
    public function getcawakaun() {
        if($this->cawanganAkaun){
            return $this->cawanganAkaun->AccBranchNm;
        }
        return '-';
        
    }
    
    public function getNamcawakaun() {
        if($this->AccBranch){
            return $this->AccBranch;
        }
        return "-";
    }
    
    public function getBanakaun() {
        if($this->CityCd){
            return $this->bandar->City;
        }
        return "-";
    }
    
    public function getStaakaun() {
        if($this->AccStatus){
            return "Aktif";
        }
        return "Tidak Aktif";
    }
    
    public function getDisplayLink() {
        if(!empty($this->filename) && $this->filename != 'deleted'){
        return html::a(Yii::$app->FileManager->NameFile($this->filename), Yii::$app->FileManager->DisplayFile($this->filename), ['target'=>'_blank']);
        }
        return 'File not exist!';
    }
    
    //log for Create, update or delete data.
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
                //aftersave will handle it
                break;
        }
        if(count($changes)>0) {
            //log activity to updatestatus table
            $log = new Updatestatus();
            $log->usern = $tempObj->ICNO; //Yii::$app->user->getId();
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
            $stat = Tblstat::find()->where(['ICNO' => $this->ICNO, 'table' => $this->tableName(), 'idval' => $this->id])->one();
            if ($stat == null) {
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
        }
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

    public function afterDelete(){
        
        //--biodata last update--//
        Yii::$app->MP->BiodataLastUpdate($this->ICNO);

        parent::afterDelete();
    }
    
}
