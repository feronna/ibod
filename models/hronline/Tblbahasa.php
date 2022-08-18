<?php

namespace app\models\hronline;

use Yii;
use app\models\hronline\NamaBahasa;
use app\models\hronline\TahapKemahiranBahasa;

/**
 * This is the model class for table "hronline.tblprlangskill".
 *
 * @property string $ICNO
 * @property string $LangSkillOral
 * @property string $LangCd
 * @property string $LangSkillWritten
 * @property int $LangSkillCert
 * @property int $id
 */
class Tblbahasa extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.tblprlangskill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'LangCd', 'LangSkillCert', 'LangSkillOral', 'LangSkillWritten'], 'required', 'message'=>'Ruang ini adalah mandatori'],
            [['LangSkillCert'], 'integer'],
            [['ICNO'], 'string', 'max' => 12],
            [['LangSkillOral', 'LangSkillWritten'], 'string', 'max' => 1],
            [['LangCd'], 'string', 'max' => 2],
            [['ICNO','LangCd'], 'unique', 'targetAttribute' => ['ICNO', 'LangCd'], 'message'=>'Bahasa sudah wujud'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
            'LangSkillOral' => 'Lang Skill Oral',
            'LangCd' => 'Lang Cd',
            'LangSkillWritten' => 'Lang Skill Written',
            'LangSkillCert' => 'Lang Skill Cert',
            'id' => 'ID',
        ];
    }
    
    public function getNamaBahasa(){
        return $this->hasOne(NamaBahasa::className(), ['LangCd' => 'LangCd']); 
    }
    
    public function getTahapKemahiranBahasaOral(){
        return $this->hasOne(TahapKemahiranBahasa::className(), ['LangProficiencyCd' => 'LangSkillOral']); 
    }
    
    public function getTahapKemahiranBahasaWritten(){
        return $this->hasOne(TahapKemahiranBahasa::className(), ['LangProficiencyCd' => 'LangSkillWritten']); 
    }
    
    public function getBahasa() {
        if($this->namaBahasa){
            return $this->namaBahasa->Lang;
        }
        return '-';
    }
    
    public function getOral() {
        if($this->tahapKemahiranBahasaOral){
            return $this->tahapKemahiranBahasaOral->LangProficiency;
        }
        return '-';
    }
    
    public function getWritten() {
        if($this->tahapKemahiranBahasaWritten){
            return $this->tahapKemahiranBahasaWritten->LangProficiency;
        }
        return '-';
    }
    
    public function getSijil() {
        if($this->LangSkillCert){
            return 'Ada';
        }
        return 'Tiada';
    }
    
    public function TahapKemahiran($id) {
        if($id==1){
            return 100;
        }else if($id==2){
            return 80;
        }
        else if($id==3){
            return 40;
        }else{
            return 0;
        }
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
    
}
