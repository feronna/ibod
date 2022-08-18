<?php

namespace app\models\hronline;

use Yii;
use yii\helpers\Html;
use app\models\hronline\JenisPasport;
use app\models\hronline\Negara;
use app\models\hronline\Negeri;
//audit trail
use app\models\hronline\Updatestatus;
use app\models\hronline\Tblstat;


/**
 * This is the model class for table "hronline.tblprpassport".
 *
 * @property string $ICNO
 * @property string $PassportNo
 * @property string $PassportTypeCd
 * @property string $CountryCd
 * @property string $StateCd
 * @property string $IssuedDt
 * @property string $PassportExpiryDt
 * @property int $id
 */
class Tblpasport extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    public $file ;
    
    public static function tableName()
    {
        return 'hronline.tblprpassport';
    }

    public function rules()
    {
        return [
            [['PassportNo', 'PassportTypeCd', 'CountryCd', 'StateCd', 'IssuedDt', 'PassportExpiryDt'], 'required','message'=>'Ruang ini adalah mandatori'],
            [['IssuedDt', 'PassportExpiryDt'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
            [['PassportNo'], 'string', 'max' => 15],
            [['PassportTypeCd', 'StateCd'], 'string', 'max' => 2],
            [['CountryCd'], 'string', 'max' => 3],
            [['ICNO','PassportNo'], 'unique', 'targetAttribute' => ['ICNO','PassportNo'],'message'=>'No. Paspot ini sudah wujud'],
            [['file'], 'file','extensions'=>['pdf','jpg','jpeg','png'],'maxSize'=>6666240, 'tooBig' => 'Limit is 6MB'],
            [['isActive'],'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
            'PassportNo' => 'Nombor Pasport',
            'PassportTypeCd' => 'Jenis Pasport',
            'CountryCd' => 'Negara',
            'StateCd' => 'Negeri',
            'IssuedDt' => 'Tarikh Dikeluarkan',
            'PassportExpiryDt' => 'Tarikh Luput',
            'id' => 'ID',
        ];
    }
    
    public function getJenisPasport() {
        return $this->hasOne(JenisPasport::className(), ['PassportTypeCd' => 'PassportTypeCd']);
    }
    
    public function getJenpaspot() {
        if($this->jenisPasport){
            return $this->jenisPasport->PassportType;
        }
        
        return '-';
    }
    
    public function getNegara() {
        return $this->hasOne(Negara::className(), ['CountryCd' => 'CountryCd']);
    }
      
    public function getNega() {
        if($this->negara){
            return $this->negara->Country;
        }
        
        return '-';
    }
    
    public function getNegeri() {
        return $this->hasOne(Negeri::className(), ['StateCd' => 'StateCd']);
    }
    
    public function getNege() {
        if($this->negeri){
            return $this->negeri->State;
        }
        
        return '-';
    }
    
    public function getIssuedDt() {
        return Yii::$app->MP->Tarikh($this->IssuedDt);
    }
    
    public function getPassportExpiryDt() {
        return Yii::$app->MP->Tarikh($this->PassportExpiryDt);
    }
    
    public function getDisplayLink() {
        if(!empty($this->filename) && $this->filename != 'deleted'){
        return html::a(Yii::$app->FileManager->NameFile($this->filename), Yii::$app->FileManager->DisplayFile($this->filename), ['target'=>'_blank']);
        }
        return 'File not exist!';
    }

    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
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
            $log->COUpdateIP = Yii::$app->getRequest()->isConsoleRequest ? Yii::$app->controller->id : Yii::$app->request->getRemoteIP()  ;
            $log->COUpdateComp = Yii::$app->getRequest()->isConsoleRequest ? Yii::$app->controller->id : Yii::$app->request->getRemoteIP();
            $log->COUpdateCompUser = Yii::$app->user->getId() ? Yii::$app->user->getId() : Yii::$app->controller->id;
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
            $log->COUpdateIP = Yii::$app->getRequest()->getUserIP();
            $log->COUpdateComp = Yii::$app->getRequest()->getUserIP();
            $log->COUpdateCompUser = Yii::$app->user->getId() ? Yii::$app->user->getId() : Yii::$app->controller->id;;
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
        $log->COUpdateIP = Yii::$app->request->getRemoteIP() ? Yii::$app->request->getRemoteIP() : Yii::$app->controller->id;        
        $log->COUpdateComp = Yii::$app->request->getRemoteIP() ? Yii::$app->request->getRemoteIP() : Yii::$app->controller->id;
        $log->COUpdateCompUser = Yii::$app->user->getId() ? Yii::$app->user->getId() : Yii::$app->controller->id;
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

    public static function LatestPassport($icno = null){
        if(($paspot = self::find()->where(['ICNO'=>($icno == null) ? $icno = Yii::$app->user->getId() : $icno])->orderBy(['PassportExpiryDt'=> SORT_DESC])->one()) !== null){
            return $paspot;
        }
        return null;
    }

    public static function expirydate($icno){
        return Tblpasport::find()->where(['ICNO' => $icno])->orderBy(['id' => SORT_DESC])->one()? Tblpasport::find()->where(['ICNO' => $icno])->orderBy(['id' => SORT_DESC])->one()->PassportExpiryDt:'';
    }

    
}
