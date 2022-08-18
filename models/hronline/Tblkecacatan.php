<?php

namespace app\models\hronline;

use Yii;
use yii\helpers\Html;
use app\models\hronline\JenisKecacatan;
use app\models\hronline\PuncaKecacatan;
//audit trail
use app\models\hronline\Updatestatus;
use app\models\hronline\Tblstat;

/**
 * This is the model class for table "hronline.tblprdisability".
 *
 * @property string $ICNO
 * @property string $DisabilityTypeCd
 * @property string $DisabilityCauseCd
 * @property string $DisabilityDt
 * @property string $AccidentDt
 * @property string $SocialWelfareNo
 * @property string $HealDt
 * @property string $DrRptNo
 * @property int $id
 */
class Tblkecacatan extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    public $file ;
    
    public static function tableName()
    {
        return 'hronline.tblprdisability';
    }

    public function rules()
    {
        return [
            [['DisabilityDt', 'AccidentDt', 'HealDt'], 'safe'],
            [['SocialWelfareNo', 'DrRptNo', 'DisabilityTypeCd', 'DisabilityCauseCd', ], 'required', 'message'=>'Ruangan ini adalah mandatori'],
            [['ICNO'], 'string', 'max' => 12],
            [['DisabilityTypeCd', 'DisabilityCauseCd'], 'string', 'max' => 2],
            [['SocialWelfareNo', 'DrRptNo'], 'string', 'max' => 20],
            [['ICNO', 'DisabilityTypeCd'], 'unique', 'targetAttribute' => ['ICNO', 'DisabilityTypeCd']],
            [['file'],'safe'],
            [['file'], 'file','extensions'=>'pdf'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
            'DisabilityTypeCd' => 'Jenis Kecacatan',
            'DisabilityCauseCd' => 'Punca Kecacatan',
            'DisabilityDt' => 'Disability Dt',
            'AccidentDt' => 'Accident Dt',
            'SocialWelfareNo' => 'No. Fail Kebajikan',
            'HealDt' => 'Heal Dt',
            'DrRptNo' => 'No. Laporan Doktor',
            'id' => 'ID',
        ];
    }
    
    public function getJenisKecacatan() {
        return $this->hasOne(JenisKecacatan::className(), ['DisabilityTypeCd'=>'DisabilityTypeCd']);
    }
    
     public function getPuncaKecacatan() {
        return $this->hasOne(PuncaKecacatan::className(), ['DisabilityCauseCd'=>'DisabilityCauseCd']);
    }
    
    public function getJenkecacatan() {
        if($this->jenisKecacatan){
            return $this->jenisKecacatan->DisabilityType;
        }
        return '-';
    }
    
    public function getPunkecacatan() {
        if($this->puncaKecacatan){
            return $this->puncaKecacatan->DisabilityCause;
        }
        return '-';
    }
    public function getTarikhsembuh() {
        if($this->HealDt){
            return Yii::$app->MP->Tarikh($this->HealDt); 
        }
        return 'Tidak Berkaitan';
    }
    public function getDisabilityDt() {
        if($this->DisabilityDt){
            return Yii::$app->MP->Tarikh($this->DisabilityDt); 
        }
        return 'Tidak Berkaitan';
    }
    public function getDisplayLink() {
        if(!empty($this->filename)){
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

    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
}
