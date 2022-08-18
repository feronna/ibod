<?php

namespace app\models\Kemudahan;
use app\models\Kemudahan\Refrecords;
use app\models\kemudahan\Refaccess;
use app\models\hronline\Tblprcobiodata;



use Yii;

/**
 * This is the model class for table "onapp.tbl_tuntutan".
 *
 * @property int $id
 * @property string $icno
 * @property string $jeniskemudahan
 * @property string $kodAkaun
 * @property string $amount
 * @property string $syarat
 * @property string $total
 * @property int $status
 * @property string $entry_created
 */
class Kemudahan extends \yii\db\ActiveRecord
{
     // add the function below:
//    public static function getDb() {
//        return Yii::$app->get('db7'); // second database
//    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.fac_tbl_kemudahan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jeniskemudahan',  'status'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['status'], 'integer'],
            [['updated_date', 'startDate', 'endDate'], 'safe'],
            [['updated_by', 'kodAkaun'], 'string', 'max' => 20],
            [['jeniskemudahan'], 'string', 'max' => 50],
//            [['amount', 'total'], 'string', 'max' => 100],
            [['reason'], 'string', 'max' => 6000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'updated_by' => 'updated by',
            'jeniskemudahan' => 'Jeniskemudahan',
            'kodAkaun' => 'Kod Akaun',
//            'amount' => 'Amount',
            'reason' => 'reason',
//            'total' => 'Total',
            'status' => 'Status',
            'updated_date' => 'Updated Date',
            'startDate' => 'Tarikh Buka',
            'endDate' => 'Tarikh Tutup',
        ];
    }
     public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getDisplayjenis()
    {
        return $this->hasOne(Refjeniskemudahan::className(), ['kemudahancd' => 'jeniskemudahan']);
    }
    public function getDisplayakaun()
    {
        return $this->hasOne(Refakaun::className(), ['akauncd' => 'kodAkaun']);
    }
    public function getDisplayrekod() {
        return $this->hasMany(Refrecords::className(), ['kemudahan' => 'jeniskemudahan']);
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


    public function getUpdateddate() {
        if($this->updated_date!=''){
        return $this->getTarikh($this->updated_date);}
    }
    public function getStart() {
        if($this->startDate!=''){
        return $this->getTarikh($this->startDate);}
    }
      public function getEnd() {
        if($this->endDate!=''){
        return $this->getTarikh($this->endDate);}
    }
  
     public function getAdmin(){
       return $this->hasOne(Refaccess::className(), ['access_level' => 'admin_post']);
    }
    
    public function getOfficer(){
        return $this->hasOne(Tblprcobiodata::className(), ['icno' => 'updated_by']);
    }
}
