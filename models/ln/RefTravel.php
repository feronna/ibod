<?php

namespace app\models\ln;
use app\models\ln\Ln;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "hrm.ln_ref_travel".
 *
 * @property int $id
 * @property string $name
 * @property string $icno
 * @property string $date_from
 * @property string $date_to
 * @property string $nama_lawatan
 * @property string $tujuan
 * @property string $nama_tempat
 * @property string $kod_peruntukan_cn
 * @property string $created_by
 * @property string $created_at
 * @property int $status
 */
class RefTravel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.ln_ref_travel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_from', 'date_to', 'created_at'], 'safe'],
            [['nama_lawatan', 'tujuan', 'nama_tempat', 'kod_peruntukan_cn'], 'string'],
            [['isActive'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['icno', 'created_by', 'status'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'icno' => 'Icno',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'nama_lawatan' => 'Nama Lawatan',
            'tujuan' => 'Tujuan',
            'nama_tempat' => 'Nama Tempat',
            'kod_peruntukan_cn' => 'Kod Peruntukan Cn',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'status' => 'Status',
            'isActive' => 'Active',
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
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getPerjalnan() {
        return $this->hasOne(ln::className(), ['icno' => 'icno']);
    }
    public function getDatefrom() {
        if($this->date_from!=''){
        return  $this->getTarikh($this->date_from);}
        else { return '-';}
   }
   
   public function getDateto() {
       return  $this->getTarikh($this->date_to);
   }

   public function getRecord() {
    return $this->hasOne(\app\models\ln\ln::className(), ['icno' => 'icno']);
}
}
