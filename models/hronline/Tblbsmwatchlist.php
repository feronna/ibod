<?php

namespace app\models\hronline;

use app\models\umsshield\Covid19Sample;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "hronline.tblbsmwatchlist".
 *
 * @property string $icno
 * @property string $name
 * @property int $isAllowed 1=allowed;0=not allowed
 * @property string $dateAD date allowed/disallowed
 * @property int $isDone 1=done;0=not done
 * @property string $dateDone date done/undone
 */
class Tblbsmwatchlist extends \yii\db\ActiveRecord
{
    public $sample_result = null;

    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public static function tableName()
    {
        return 'hronline.tblbsmwatchlist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno', 'name'], 'required'],
            [['isAllowed', 'isDone','category','isNew'], 'integer'],
            [['dateAD', 'dateDone','sample_result'], 'safe'],
            [['icno','sample_result'], 'string', 'max' => 15],
            [['name'], 'string', 'max' => 255],
            [['icno'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'icno' => 'Icno',
            'name' => 'Name',
            'isAllowed' => 'Is Allowed',
            'dateAD' => 'Date Ad',
            'isDone' => 'Is Done',
            'dateDone' => 'Date Done',
            'category' => 'Category',
            'sample_result' => 'Sample Result',
            'isNew' => 'Is New',
        ];
    }

    public function getCovid19Sample()
    {
        return $this->hasOne(Covid19Sample::className(), ['icno' => 'icno']);
    }

    public function getSampleResult(){
        if($this->category == 1){
            return -1;
        }
        if($this->covid19Sample){
            return $this->covid19Sample->result;
        }
        return 0;
    }

    public static function isAllowed($icno){
        $model = self::findWatchlist($icno,'required');
        if(empty($model)){ //tidak berkaitan dlm watch list
            return ['status'=>true,'category'=>0];
        }

        if($model->isAllowed){
            return ['status'=>true,'category'=>-1];
        }

        //category == 1//
        if($model->category == 1){
            if($model->isAllowed){
                return ['status'=>true,'category'=>1];
            }
            return ['status'=>false,'category'=>1];
        }
        //category == 2//
        if($model->covid19Sample){
            if($model->covid19Sample->isVerified == 'Yes'){
                if($model->covid19Sample->result == 'Detected'){
                    return ['status'=>false,'category'=>2];
                }else{
                    return ['status'=>true,'category'=>2];
                }
            }else{
                return ['status'=>false,'category'=>2];
            }
        }
        return ['status'=>false,'category'=>2];
        
    }

    public static function findWatchlist($icno,$modelnotempty = null){ //used in controller

        if (($model = Tblbsmwatchlist::find()->where(['icno' => $icno])->one()) !== null) {
            return $model;
        }
        if($modelnotempty == 'required'){
            return $model;
        }
        throw new NotFoundHttpException('Staf tidak wujud dalam senarai pemantauan.');
    }

    //log for Create, update or delete data.
    public function beforeSave($insert)
    {   
        if(!parent::beforeSave($insert)){
            return false;
        }

        $changes = [];
        $tempObj = self::findOne(['icno'=>$this->icno]);
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
            $log->idval = $this->icno;
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
            $log->idval = $this->icno;
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
