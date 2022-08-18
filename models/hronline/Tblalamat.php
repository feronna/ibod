<?php

namespace app\models\hronline;

use Yii;
use yii\helpers\Html;
use app\models\hronline\JenisAlamat;
use app\models\hronline\Negara;
use app\models\hronline\Negeri;
use app\models\hronline\Bandar;
//audit trail
use app\models\hronline\Updatestatus;
use app\models\hronline\Tblstat;

/**
 * This is the model class for table "hronline.tblpraddr".
 *
 * @property string $ICNO
 * @property string $StateCd
 * @property string $CityCd
 * @property string $AddrTypeCd
 * @property string $CountryCd
 * @property string $Addr1
 * @property string $Addr2
 * @property string $Addr3
 * @property string $Postcode
 * @property string $TelNo
 * @property int $id
 */
class Tblalamat extends \yii\db\ActiveRecord {
    public $temp;
    
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    

    public static function tableName() {
        return 'hronline.tblpraddr';
    }

    public function rules() {
        return [
            [['AddrTypeCd', 'Addr1', 'TelNo', 'Postcode'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['StateCd'], 'string', 'max' => 5],
            [['CityCd'], 'string', 'max' => 6],
            [['ICNO'], 'string', 'max' => 12],
            [['AddrTypeCd'], 'string', 'max' => 2],
            [['CountryCd'], 'string', 'max' => 3],
            [['Addr2', 'Addr3'], 'string', 'max' => 100],
            [['TelNo'], 'string', 'max' => 14],
            [['ICNO', 'AddrTypeCd'], 'unique', 'targetAttribute'=>['ICNO', 'AddrTypeCd'], 'message'=>'Jenis alamat sudah wujud.'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'AddrTypeCd' => 'Jenis Alamat',
            'ICNO' => 'ICNO',
            'Addr1' => 'Alamat 1',
            'Addr2' => 'Alamat 2',
            'Addr3' => 'Alamat 3',
            'CountryCd' => 'Negara',
            'StateCd' => 'Negeri',
            'CityCd' => 'Bandar',
            'Postcode' => 'Poskod',
            'TelNo' => 'No. Tel.',
            
        ];
    }

    public function attributes(){ 
        
        $attrs = parent::attributes();
        $temp_attrs = $attrs;

        $all_attributes = [
            'AddrTypeCd',
            'ICNO',
            'CountryCd',
            'StateCd',
            'CityCd',
            'Addr1',
            'Addr2',
            'Addr3',
            'Postcode',
            'TelNo',
        ];

        for($i=0;$i<count($all_attributes);$i++){
            for($j=0;$j<count($attrs);$j++){
                if($all_attributes[$i] == $temp_attrs[$j]){
                    $attrs[$i] = $all_attributes[$i];
                break;
                }
            }           
        }

        return $attrs;
    }

    public function attributeValues($attr,$id = null) {
        
        switch ($attr) {
            
            case 'CityCd':
                return Bandar::findOne(['CityCd'=>$id])->City;
                break;
            case 'StateCd':
                return Negeri::findOne(['StateCd'=>$id])->State;
                break;
            case 'CountryCd':
                return Country::findOne(['CountryCd'=>$id])->Country;
                break;
            case 'AddrTypeCd':
                return JenisAlamat::findOne(['AddrTypeCd'=>$id])->AddrType;
                break;
            
            default:
                return $id;
                break;
        }

    }

    public function getJenisAlamat() {
        return $this->hasOne(JenisAlamat::className(), ['AddrTypeCd' => 'AddrTypeCd']);
    }

    public function getNegara() {
        return $this->hasOne(Negara::className(), ['CountryCd' => 'CountryCd']);
    }

    public function getNegeri() {
        return $this->hasOne(Negeri::className(), ['StateCd' => 'StateCd']);
    }

    public function getBandar() {
        return $this->hasOne(Bandar::className(), ['CityCd' => 'CityCd']);
    }

    public function getJenalamat() {
        if($this->jenisAlamat){
            return $this->jenisAlamat->AddrType;
        }
        return '-';
    }
    
    public function getAddr1() {
        if($this->Addr1){
            return $this->Addr1;
        }
        return '-';
    }
    public function getAddr2() {
        if($this->Addr2){
            return $this->Addr2;
        }
        return '-';
    }
    public function getAddr3() {
        if($this->Addr3){
            return $this->Addr3;
        }
        return '-';
    }
    
    public function getDisplayNegara() {
        if($this->negara){
            return $this->negara->Country;
        }
        return '-';
    }
    
    public function getDisplayNegeri() {
        if($this->negeri){
            return $this->negeri->State;
        }
        return '-';
    }
    
    public function getDisplayDaerah() {
        if($this->bandar){
            return $this->bandar->City;
        }
        return '-';
    }
    
     public function getAlamatPenuh() { 
        
        if($this->bandar){ $City = $this->bandar->City.', ';
        }else{ $City = ""; }
         
        if($this->negeri){ $State = $this->negeri->State.', ';
        }else{ $State = ""; }
        
        if($this->negara){ $Country = $this->negara->Country.'.';
        }else{ $Country = ""; }
        
        if($this->Addr2){ $Add2 = ucwords(strtolower($this->Addr2.', '));
        }else{ $Add2 = ""; }
        
        if($this->Addr3){ $Add3 = ucwords(strtolower($this->Addr3.', '));
        }else{ $Add3 = ""; }
        
        return ucwords(strtolower($this->Addr1)).', '.$Add2.$Add3.$this->Postcode.', '.$City.$State.$Country;
    }
    
    public function beforeSave($insert)
    {   
        if(!parent::beforeSave($insert)){
            return false;
        }

        $changes = [];
        $tempObj = self::findOne($this->id);
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
            $log->usern = $this->ICNO;//Yii::$app->user->getId();
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

                //--biodata last update--//
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

            //--biodata last update--//
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
