<?php

namespace app\models\hronline;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "hronline.tblpenerima_vaksin".
 *
 * @property int $id
 * @property int $bil_dos
 * @property string $tarikh_vaksin
 * @property string $jenis_vaksin
 * @property string $tempat_vaksin
 * @property string $batch_vaksin
 */
class Tblpenerimavaksin extends \yii\db\ActiveRecord
{

    public $file;

    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public static function tableName()
    {
        return 'hronline.tblpenerima_vaksin';
    }

    public function rules()
    {
        return [
            [['bil_dos'], 'integer'],
            [['jenis_vaksin','tempat_vaksin','batch_vaksin'], 'required', 'message'=>'Ruang ini adalah mandatori'],
            [['icno'], 'string', 'max'=>15],
            [['tarikh_vaksin'], 'safe'],
            [['jenis_vaksin'], 'string', 'max' => 2],
            [['tempat_vaksin', 'batch_vaksin'], 'string', 'max' => 255],
            [['file'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bil_dos' => 'Bil Dos',
            'tarikh_vaksin' => 'Tarikh Vaksin',
            'jenis_vaksin' => 'Jenis Vaksin',
            'tempat_vaksin' => 'Tempat Vaksin',
            'batch_vaksin' => 'Batch Vaksin',
        ];
    }

    public function getVaksin()
    {
        return $this->hasOne(Tblstatusvaksinasi::className(), ['icno' => 'icno']);
    }
    public function getJenisVaksin()
    {
        return $this->hasOne(jenis_vaksin::className(), ['id' => 'jenis_vaksin']);
    }
    public function getBiodata()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getDisplayLink() {
        if(!empty($this->sijil_digital) && $this->sijil_digital != 'deleted'){
        return html::a(Yii::$app->FileManager->NameFile($this->sijil_digital), Yii::$app->FileManager->DisplayFile($this->sijil_digital), ['target'=>'_blank']);
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
