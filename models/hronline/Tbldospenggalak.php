<?php

namespace app\models\hronline;

use Yii;
use app\models\hronline\JenisDospenggalak;

/**
 * This is the model class for table "hronline.tbldospenggalak".
 *
 * @property int $id
 * @property int $status_vaksinasi_id
 * @property string $jenis_dos
 * @property string $tarikh_dos
 * @property string $catatan
 * @property string $last_update
 * @property string $last_updater
 */
class Tbldospenggalak extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    public static function tableName()
    {
        return 'hronline.tbldospenggalak';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_dos','batch_dos','tempat_dos'],'required','message'=>'Ruangan ini adalah mandatori.'],
            [['status_vaksinasi_id'], 'integer'],
            [['tarikh_dos', 'last_update','tarikh_luput'], 'safe'],
            [['catatan','tempat_dos'], 'string'],
            [['jenis_dos'], 'string', 'max' => 5],
            [['last_updater'], 'string', 'max' => 15],
            [['batch_dos'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_vaksinasi_id' => 'Status Vaksinasi ID',
            'jenis_dos' => 'Jenis Dos',
            'tarikh_dos' => 'Tarikh Dos',
            'tempat_dos' => 'Tempat Dos',
            'catatan' => 'Catatan',
            'last_update' => 'Last Update',
            'last_updater' => 'Last Updater',
            'batch_dos' => 'Batch DOS',
            'tarikh_luput' => 'Tarikh Luput',
        ];
    }

    public function getJenisDosPenggalak()
    {
        return $this->hasOne(JenisDospenggalak::className(), ['id' => 'jenis_dos']);
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
             $log = new log_vaksinasi();
             $log->usern = $tempObj->icno;
             $log->TableName = $this->tableName();
             $log->Activity = $activity;
             $log->UpdateDate = date('Y-m-d H:i:s');
             $log->UpdateIP = Yii::$app->request->getRemoteIP();
             $log->UpdateComp = Yii::$app->request->getRemoteIP();
             $log->UpdateCompUser = Yii::$app->user->getId(); //login account
             $log->UpdateSQL = serialize($changes);
             $log->idval = $this->id;
             $log->save(false);
         }
 
         return true;
         
     }
     
     public function afterSave($insert, $changedAttributes)
     {
         parent::afterSave($insert, $changedAttributes);
 
         if ($insert) {
 
             $changes = [];
             $attrib = $this->activeAttributes();
             $activity = 0;
             for ($i = 0; $i < count($attrib); $i++) {
                 array_push($changes, [$attrib[$i], $this->{$attrib[$i]}]);
             }
 
             $log = new log_vaksinasi();
             $log->usern = $this->icno;
             $log->TableName = $this->tableName();
             $log->Activity = $activity;
             $log->UpdateDate = date('Y-m-d H:i:s');
             $log->UpdateIP = Yii::$app->request->getRemoteIP();
             $log->UpdateComp = Yii::$app->request->getRemoteIP();
             $log->UpdateCompUser = Yii::$app->user->getId();
             $log->UpdateSQL = serialize($changes);
             $log->idval = $this->id;
             $log->save(false);
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
         $log = new log_vaksinasi();
         $log->usern = $this->icno;
         $log->TableName = $this->tableName();
         $log->Activity = 2;
         $log->UpdateDate = date('Y-m-d H:i:s');
         $log->UpdateIP = Yii::$app->request->getRemoteIP();        
         $log->UpdateComp = Yii::$app->request->getRemoteIP();
         $log->UpdateCompUser = Yii::$app->user->getId();
         $log->UpdateSQL = serialize($changes);
         $log->save(false);
         
         return true;
     }
 
     public function afterDelete(){
         parent::afterDelete();
     }
}
