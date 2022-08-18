<?php

namespace app\models\hronline;

use Yii;
use yii\helpers\Html;
use app\models\hronline\JenisLesen;
use app\models\hronline\KelasLesen;
//audit trail
use app\models\hronline\Updatestatus;
use app\models\hronline\Tblstat;

/**
 * This is the model class for table "hronline.tblprlic".
 *
 * @property string $licId
 * @property string $ICNO
 * @property string $LicNo
 * @property string $LicCd
 * @property string $LicClassCd
 * @property string $LicExpiryDt
 * @property string $LicRnwlFee
 * @property string $FirstLicIssuedDt
 */
class Tbllesen extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public $file ;
    
    public static function tableName()
    {
        return 'hronline.tblprlic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LicNo', 'LicCd', 'LicClassCd', 'LicExpiryDt', 'FirstLicIssuedDt', 'LicRnwlFee'], 'required','message'=>'Ruang ini adalah mandatori'],
            [['LicNo'], 'unique', 'message' => 'Nombor Lesen sudah wujud!'],
            [['LicExpiryDt', 'FirstLicIssuedDt'], 'safe'],
            [['LicRnwlFee'], 'number'],
            [['ICNO'], 'string', 'max' => 12],
            [['LicNo'], 'string', 'max' => 20],
            [['LicCd'], 'string', 'max' => 2],
            [['LicClassCd'], 'string', 'max' => 3],
            [['filename'], 'string', 'max'=>100],
            [['file'],'safe'],
            [['file'], 'file','extensions'=>['pdf','jpg','jpeg','png'], 'maxSize'=>6666240, 'tooBig' => 'Limit is 6MB'],
            [['Name'], 'string'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'licId' => 'Lic ID',
            'ICNO' => 'Icno',
            'LicNo' => 'Nombor Lesen',
            'LicCd' => 'Jenis Lesen',
            'LicClassCd' => 'Kelas Lesen',
            'LicExpiryDt' => 'Tarikh Luput',
            'LicRnwlFee' => 'Yuran Pembaharuan',
            'FirstLicIssuedDt' => 'Tarikh Dikeluarkan',
            'Name' => 'Nama Pemegang Lesen',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
    public function getJenisLesen() {
        return $this->hasOne(JenisLesen::className(), ['LicCd' => 'LicCd']);
    }
    
    public function getJenlesen() {
        if($this->jenisLesen){
            return $this->jenisLesen->LicType;
        }
        return '-';
    }
    
    public function getKelasLesen() {
        return $this->hasOne(KelasLesen::className(), ['LicClassCd' => 'LicClassCd']);
    }
    
    public function getKellesen() {
        if($this->kelasLesen){
            return $this->kelasLesen->LicClass;
        }
        return '-';
    }

    public function getDisplayLink() {
        if(!empty($this->filename)){
        return html::a(Yii::$app->FileManager->NameFile($this->filename), Yii::$app->FileManager->DisplayFile($this->filename), ['target'=>'_blank']);
        }
        return 'File not exist!';
    }
    
    public function getFirstLicIssuedDt() {
        return Yii::$app->MP->Tarikh($this->FirstLicIssuedDt);
    }
    public function getLicExpiryDt() {
        return Yii::$app->MP->Tarikh($this->LicExpiryDt);
    }
    public function LatestLicense($icno = null) {
        if(($model = self::find()->where(['ICNO'=>($icno == null) ? $icno = Yii::$app->user->getId() : $icno])->orderBy(['LicExpiryDt'=> SORT_DESC])->one()) !== null){
            return $model;
        }
        return null;
    }
    
    
    
    //log for Create, update or delete data.
    public function beforeSave($insert)
    {   
        if(!parent::beforeSave($insert)){
            return false;
        }

        $changes = [];
        $tempObj = self::findOne(['licId'=>$this->licId]);
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
            $log->idval = $this->licId;
            $log->save(false);
            
                //save to tbl_stat
                $stat = Tblstat::find()->where(['ICNO'=>$this->ICNO,'table'=>$this->tableName(),'idval'=>$this->licId])->one();
                if($stat==null)
                {
                    $stat = new Tblstat();
                    $stat->ICNO = $this->ICNO;
                    $stat->table = $this->tableName();
                    $stat->idval = $this->licId;
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
            $stat->idval = $this->licId;
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
            $log->idval = $this->licId;
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
        $stat = Tblstat::find()->where(['ICNO'=>$this->ICNO, 'table'=>$this->tableName(),'idval'=>$this->licId])->one();
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
    
    public static function expirydate($icno) {
        return Tbllesen::find()->where(['ICNO' => $icno])->orderBy(['licId' => SORT_DESC])->one()?
                Tbllesen::find()->where(['ICNO' => $icno])->orderBy(['licId' => SORT_DESC])->one()->LicExpiryDt:'';
    }
}
