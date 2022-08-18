<?php

namespace app\models\hronline;
use app\models\hronline\Updatestatus;
use app\models\hronline\Tblstat;
use Yii;

/**
 * This is the model class for table "hronline.tblrscoservstatus".
 *
 * @property string $ICNO
 * @property int $ServStatusCd
 * @property int $ServStatusDtl
 * @property string $ServStatusStDt
 * @property string $id
 * @property string $sebab_berhenti
 */
class Tblrscoservstatus extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.tblrscoservstatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
         
            [['ServStatusCd', 'ServStatusDtl'], 'integer'],
            [['ServStatusStDt'], 'safe'],
            [['sebab_berhenti'], 'string'],
            [['ICNO'], 'string', 'max' => 12],
            [['ServStatusCd', 'ServStatusStDt', 'ServStatusDtl', 'sebab_berhenti'], 'required', 'message' => "Wajib Diisi"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
            'ServStatusCd' => 'Serv Status Cd',
            'ServStatusDtl' => 'Serv Status Dtl',
            'ServStatusStDt' => 'Serv Status St Dt',
            'id' => 'ID',
            'sebab_berhenti' => 'Sebab Berhenti',
        ];
    }
     public function getTarikh($bulan){
        
        $m = date_format(date_create($bulan), "m");
        if($m == 01){
            $m = "Januari";}
        elseif ($m == 02){
          $m = "Februari";}
        elseif ($m == 03){
          $m = "Mac";}
        elseif ($m == 04){
          $m = "April";}
        elseif ($m == 05){
          $m = "Mei";}
        elseif ($m == 06){
          $m = "Jun";}
        elseif ($m == 07){
          $m = "Julai";}
        elseif ($m == '08'){
          $m = "Ogos";}
        elseif ($m == '09'){
          $m = "September";}
        elseif ($m == '10'){
          $m = "Oktober";}
        elseif ($m == '11'){
          $m = "November";}
        elseif ($m == '12'){
          $m = "Disember";}
          
        return date_format(date_create($bulan), "d").' '.$m.' '.date_format(date_create($bulan), "Y");
    }
    
    public function getTarikhMula() {
        return  $this->getTarikh($this->ServStatusStDt);
    }
//     public function getTarikhTamat() {
//
//         }
     public function getStatusPerkhidmatan() {
        return $this->hasOne(ServiceStatus::className(), ['ServStatusCd' => 'ServStatusCd']);
    }
     public function getStatusTerperinci() {
        return $this->hasOne(Servicestatusdetail::className(), ['id' => 'ServStatusDtl']);
    }
    
    //log for Create, update or delete data.
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $changes = [];
        $tempObj = self::findOne(['id' => $this->id]);
        $attrib = $this->activeAttributes();

        switch ($insert) {
            case (false):
                $activity = 1;
                for ($i = 0; $i < count($attrib); $i++) {

                    if ($tempObj->{$attrib[$i]} != $this->{$attrib[$i]}) {
                        array_push($changes, [$attrib[$i], $tempObj->{$attrib[$i]}, $this->{$attrib[$i]}]);
                    }
                }

                break;

            default:
                //aftersave will handle it
                break;
        }
        if (count($changes) > 0) {
            //log activity to updatestatus table
            $log = new Updatestatus();
            $log->usern = $tempObj->ICNO;//Yii::$app->user->getId();
            $log->COTableName = $this->tableName();
            $log->COActivity = $activity;
            $log->COUpadteDate = date('Y-m-d H:i:s');
            if(Yii::$app->user->getId()){
                 $log->COUpdateIP = Yii::$app->request->getRemoteIP() ;
                $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            }else{
                $log->COUpdateIP = yii::$app->controller->id;
                $log->COUpdateComp = yii::$app->controller->id;
            }
//            $log->COUpdateIP = Yii::$app->request->getRemoteIP();
//            $log->COUpdateComp = Yii::$app->request->getRemoteIP();
//            $log->COUpdateCompUser = Yii::$app->user->getId()? Yii::$app->user->getId():yii::$app->controller->id;
//            $log->COUpdateIP = Yii::$app->request->getRemoteIP();
//            $log->COUpdateComp = Yii::$app->request->getUserHost() ? Yii::$app->request->getUserHost() : Yii::$app->request->getRemoteIP();
            $log->COUpdateCompUser = Yii::$app->user->getId()? Yii::$app->user->getId(): yii::$app->controller->id;
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
        }

        return true;
    }

    public function afterSave($insert, $changedAttributes) {
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
             if(Yii::$app->user->getId()){
                 $log->COUpdateIP = Yii::$app->request->getRemoteIP() ;
                $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            }else{
                $log->COUpdateIP = yii::$app->controller->id;
                $log->COUpdateComp = yii::$app->controller->id;
            }
//            $log->COUpdateIP = Yii::$app->request->getRemoteIP();
//            $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            $log->COUpdateCompUser = Yii::$app->user->getId()? Yii::$app->user->getId():yii::$app->controller->id;
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);
        }

        return true;
    }

    public function beforeDelete() {
        if (!parent::beforeDelete()) {
            return false;
        }

        $changes = [];

        //get list of attributes
        $attrib = $this->activeAttributes();

        for ($i = 0; $i < count($attrib); $i++) {
            array_push($changes, array($attrib[$i], $this->{$attrib[$i]}));
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
        $stat = Tblstat::find()->where(['ICNO' => $this->ICNO, 'table' => $this->tableName(), 'idval' => $this->id])->one();
        if ($stat == null)
            return true;

        $stat->delete();

        return true;
    }
    public function getStatusLantikan() {
        return $this->hasOne(StatusLantikan::className(), ['ApmtStatusCd' => 'ApmtStatusCd']);
    }
}
