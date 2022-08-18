<?php

namespace app\models\hronline;

use Yii;
use app\models\hronline\Updatestatus;
use app\models\hronline\Tblstat;
use app\models\hronline\Tblprcobiodata;
use app\models\myidp\RptStatistikIdpV2;

/**
 * This is the model class for table "hronline.tblrscosandangan".
 *
 * @property int $id
 * @property string $ICNO
 * @property int $gredjawatan
 * @property int $sandangan_id
 * @property string $ApmtTypeCd
 * @property string $start_date
 */
class Tblrscosandangan extends \yii\db\ActiveRecord
{

    public $_action = null;

    
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.tblrscosandangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['gredjawatan', 'sandangan_id'], 'integer'],
            [['start_date'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
            [['ApmtTypeCd'], 'string', 'max' => 2],
            [['gredjawatan', 'sandangan_id', 'ApmtTypeCd', 'start_date'], 'required', 'message' => "Wajib Diisi"],
            [['gredjawatan', 'sandangan_id', 'ApmtTypeCd', 'start_date'], 'required', 'message' => 'Ruangan ini adalah mandatori', 'on'=>'lantikan baru'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'gredjawatan' => 'Gredjawatan',
            'sandangan_id' => 'Sandangan ID',
            'ApmtTypeCd' => 'Apmt Type Cd',
            'start_date' => 'Start Date',
        ];
    }
    
    //myIdp
    public function getStatistik(){
        return $this->hasMany(RptStatistikIdpV2::className(), ['icno' => 'ICNO']);
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
    
    public function getTarikhMulaSandangan() {
        return  $this->getTarikh($this->start_date);
    }
    
    public function getStatusSandangan() {
        return $this->hasOne(Sandangan::className(), ['sandangan_id' => 'sandangan_id']);
    }
    public function getGredJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gredjawatan']);
    }
    //myIDP
    public function getJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gredjawatan']);
    }
    public function getJenisLantikan() {
        return $this->hasOne(Appointmenttype::className(), ['ApmtTypeCd' => 'ApmtTypeCd']);
    }
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
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
            $log->COUpdateIP = Yii::$app->request->getRemoteIP();
            $log->COUpdateComp = Yii::$app->request->getUserHost() ? Yii::$app->request->getUserHost() : Yii::$app->request->getRemoteIP();
            $log->COUpdateCompUser = Yii::$app->user->getId();
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
            $log->COUpdateIP = Yii::$app->request->getRemoteIP();
            $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            $log->COUpdateCompUser = Yii::$app->user->getId();
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);

            // insert to penamatan akses//
            $_actionLantikan = ['lantikstafbaru','lantikphs','lantikkhas','lantikpli'];
            if(!in_array($this->_action,$_actionLantikan)){
                $pa = new TblPapSenaraiStaf();
                $pa->icno = $this->ICNO;
                $pa->nama = $this->biodata->CONm;
                $pa->jfpib = $this->biodata->department->fullname;
                $pa->sebab_perubahan = 'Perubahan Sandangan';
                $pa->tarikh_ubah = date('Y-m-d H:i:s');
                $pa->tarikh_kuatkuasa = date('Y-m-d H:i:s');
                $pa->save(false);
            }
            
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
}
