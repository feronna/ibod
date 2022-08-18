<?php

namespace app\models\hronline;

use Yii;
use app\models\hronline\Updatestatus;
use app\models\hronline\Tblstat;
/**
 * This is the model class for table "hronline.tblpenempatan".
 *
 * @property string $id
 * @property string $ICNO
 * @property string $date_start
 * @property string $date_update
 * @property int $dept_id
 * @property int $campus_id
 * @property int $reason_id
 * @property string $remark
 * @property string $letter_order_refno
 * @property string $date_letter_order
 * @property string $letter_refno
 * @property string $update_by
 */
class TblPenempatan extends \yii\db\ActiveRecord
{
    public $_action = null;

    
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public $files;
    public static function tableName()
    {
        return 'hronline.tblpenempatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'dept_id', 'campus_id', 'reason_id', 'remark', 'letter_order_refno', 'date_start', 'date_letter_order'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['date_start', 'date_update', 'date_letter_order'], 'safe'],
            [['dept_id', 'campus_id', 'reason_id'], 'integer'],
            [['ICNO', 'update_by'], 'string', 'max' => 12],
            [['remark'], 'string', 'max' => 200],
            [['letter_order_refno'], 'string', 'max' => 100],
            [['letter_refno'], 'string', 'max' => 30],
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
            'date_start' => 'Date Start',
            'date_update' => 'Date Update',
            'dept_id' => 'Dept ID',
            'campus_id' => 'Campus ID',
            'reason_id' => 'Reason ID',
            'remark' => 'Remark',
            'letter_order_refno' => 'Letter Order Refno',
            'date_letter_order' => 'Date Letter Order',
            'letter_refno' => 'Letter Refno',
            'update_by' => 'Update By',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }

    public function getCampus()
    {
        return $this->hasOne(Campus::className(), ['campus_id' => 'campus_id']);
    }

    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'dept_id']);
    }
    
    public function getPelulus(){
        return $this->hasOne(Recommendation::className(), ['application_id' => 'id'])->where(['type' => 3]);      
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
    
    public function getTarikhh($bulan){
        
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
          
       return date_format(date_create($bulan), "d").' '.$m.' '.date_format(date_create($bulan), "Y H:i:s A");
    }
    
    public function getTarikhKemaskini() {
        return  $this->getTarikhh($this->date_update);
    }
    
     public function getTarikhMula() {
        return  $this->getTarikh($this->date_start);
    }
    
         public function getTarikhSurat() {
        return  $this->getTarikh($this->date_letter_order);
    }
    
    public function getKampus() {
        return $this->hasOne(Kampus::className(), ['campus_id' => 'campus_id']);
    }
    
     public function getReasonPenempatan() {
        return $this->hasOne(RefReasonPenempatan::className(), ['reason_id' => 'reason_id']);
    }
    
    public function getUpdate()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'update_by']);
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

             //insert to penamatan akses//
            $_actionLantikan = ['lantikstafbaru','lantikphs','lantikkhas','lantikpli'];
            if(!in_array($this->_action,$_actionLantikan)){
              $pa = new TblPapSenaraiStaf();
              $pa->icno = $this->ICNO;
              $pa->nama = $this->biodata->CONm;
              $pa->jfpib = $this->biodata->department->fullname;
              $pa->sebab_perubahan = 'Perubahan Penempatan';
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
