<?php

namespace app\models\hronline;

use Yii;
use yii\helpers\Html;
use app\models\hronline\BadanProfesional;
use app\models\hronline\TarafKeahlian;


/**
 * This is the model class for table "hronline.tblprprofassoc".
 *
 * @property string $profId
 * @property string $ICNO
 * @property string $ProfBodyCd
 * @property string $ProfBodyOther
 * @property string $MembershipTypeCd
 * @property string $JoinDt
 * @property string $FeeAmt
 * @property string $Designation
 * @property string $ResignDt
 * @property int $ProfAssocStatus
 */
class TblBadanProfesional extends \yii\db\ActiveRecord
{    
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public $file ;
    
    public static function tableName()
    {
        return 'hronline.tblprprofassoc';
    }

    public function rules()
    {
        return [
            [['JoinDt', 'ResignDt'], 'safe'],
            [['FeeAmt'], 'number', 'message'=>'Yuran hendaklah dalam nilai nombor.'],
            [['ProfAssocStatus'], 'integer'],
            [['ICNO'], 'string', 'max' => 12],
            [['ProfBodyCd'], 'string', 'max' => 4],
            [['ProfBodyOther'], 'string', 'max' => 200],
            [['MembershipTypeCd'], 'string', 'max' => 1],
            [['Designation'], 'string', 'max' => 40],
            [['ProfBodyCd','MembershipTypeCd','Designation','FeeAmt','ICNO', 'ProfAssocLvl'],'required','message'=>'Ruang ini adalah mandatori'],
            [['filename'], 'string'],
            [['file'], 'file','extensions'=>'pdf'],
            [['ProfAssocLvl'], 'integer',],
            [['membership_no'], 'string','max' => 50],
            [['url'],'string'],
            [['isMedicalBody','isVerified'],'integer'],
        ];
    }

 
    public function attributeLabels()
    {
        return [
            'profId' => 'Profesional ID',
            'ICNO' => 'IC / Passport',
            'ProfBodyCd' => 'Profesional Body',
            'ProfBodyOther' => 'Prof Body Other',
            'MembershipTypeCd' => 'Membership Type',
            'JoinDt' => 'Join Date',
            'FeeAmt' => 'Fee Amount',
            'Designation' => 'Designation',
            'ResignDt' => 'Resign Dt',
            'ProfAssocStatus' => 'Profesional Association Status',
            'filename' => 'filename',
            'ProfAssocLvl' => 'Profesional Association Level',
            'membership_no' => 'Nombor Keahlian',
            'url' => 'url',
        ];
    }
    
    public function getBadanProfesional() {
        return $this->hasOne(BadanProfesional::className(), ['ProfBodyCd' => 'ProfBodyCd']);
    }
    
    public function getTarafKeahlian() {
        return $this->hasOne(TarafKeahlian::className(), ['MembershipTypeCd' => 'MembershipTypeCd']);
    }
    public function getPeringkat() {
        return $this->hasOne(ProfesionalAssociationLevel::className(), ['id' => 'ProfAssocLvl']);
    }
    
    //function utk display
    
    public function getnambadanprofesional() {
        if($this->ProfBodyCd == 9999){
            return $this->ProfBodyOther;
        }
        return $this->badanProfesional? $this->badanProfesional->ProfBody:'-';
    }
   
    public function getTarkeahlian() {
        
        return $this->tarafKeahlian->MembershipType;
    }
    
    public function getJaw() {
        if($this->Designation && $this->Designation != null){
            return $this->Designation;
        }
        return "-";
    }
    
    public function getTarikhmula() {
        if($this->JoinDt){
            return Yii::$app->MP->Tarikh($this->JoinDt);
        }
        
        return "-";
    }
    
    public function getTarikhakhir() {
        if($this->ResignDt){
            return Yii::$app->MP->Tarikh($this->ResignDt);
        }
        
        return "-";
    }
    
    public function getYuran() {
        if($this->FeeAmt){
            return "RM ".$this->FeeAmt;
        }
        
        return "-";
    }
    
     public function getStaaktif() {
        if($this->ProfAssocStatus){
            return "Aktif";
        }
        
        return "Tidak Aktif";
    }
     public function getStaMedicBody() {
        if($this->isMedicalBody){
            return "YA";
        }
        
        return "TIDAK";
    }
     public function getStasah() {
        if($this->isVerified){
            return '<span class="label label-success">Telah disahkan</span>';
        }
        
        return '<span class="label label-warning">Belum disahkan</span>';
    }
    
    public function getDisplayLink() {
        if(!empty($this->filename) && $this->filename != 'deleted'){
        return html::a(Yii::$app->FileManager->NameFile($this->filename), Yii::$app->FileManager->DisplayFile($this->filename), ['target'=>'_blank']);
        }
        return 'File not exist!';
    }
    public function getMembershipNo() {
        if(!empty($this->membership_no)){
        return $this->membership_no;
        }
        return '<span class="label label-warning">Sila Kemaskini</span>';
    }

    
    //log for Create, update or delete data.
    public function beforeSave($insert)
    {   
        if(!parent::beforeSave($insert)){
            return false;
        }

        $changes = [];
        $tempObj = self::findOne(['profId'=>$this->profId]);
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
            $log->idval = $this->profId;
            $log->save(false);
            
                //save to tbl_stat
                $stat = Tblstat::find()->where(['ICNO'=>$this->ICNO,'table'=>$this->tableName(),'idval'=>$this->profId])->one();
                if($stat==null)
                {
                    $stat = new Tblstat();
                    $stat->ICNO = $this->ICNO;
                    $stat->table = $this->tableName();
                    $stat->idval = $this->profId;
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
            $stat->idval = $this->profId;
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
            $log->idval = $this->profId;
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
        $stat = Tblstat::find()->where(['ICNO'=>$this->ICNO, 'table'=>$this->tableName(),'idval'=>$this->profId])->one();
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
