<?php

namespace app\models\e_perkhidmatan;

use Yii;
use app\models\hronline\Tblprcobiodata;
class TblEvent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%keselamatan.utils_tbl_event}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_name', 'location', 'date_start', 'date_end', 'time_start', 'time_end'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['date_start', 'date_end', 'time_start', 'time_end', 'entry_date'], 'safe'],
            [['active_status', 'dept_id', 'parkir_status', 'kawalan_status', 'anggaran_peserta'], 'integer'],
            [['event_name', 'location', 'user_id'], 'string', 'max' => 255],
            [['staff_id'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'event_id' => 'Event ID',
            'event_name' => 'Event Name',
            'location' => 'Location',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'time_start' => 'Time Start',
            'time_end' => 'Time End',
            'active_status' => 'Active Status',
            'entry_date' => 'Entry Date',
            'user_id' => 'User ID',
            'staff_id' => 'Staff ID',
            'dept_id' => 'Dept ID',
            'parkir_status' => 'Parkir Status',
            'kawalan_status' => 'Kawalan Status',
            'anggaran_peserta' => 'Anggaran Peserta'
        ];
    }

    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'staff_id']);
    }

    public function getApplication() {
        return $this->hasOne(PermitApplication::className(), ['event_id' => 'event_id']);
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
    
    public function getEntrydatee() {
        if($this->entry_date!=''){
        return $this->getTarikh($this->entry_date);}
    }
    
     public function getDatestart() {
        if($this->date_start!=''){
        return $this->getTarikh($this->date_start);}
    }
    
     public function getDateend() {
        if($this->date_end!=''){
        return $this->getTarikh($this->date_end);}
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
    
    public function getEntrydate() {
        if($this->entry_date!=''){
        return $this->getTarikhh($this->entry_date);}
    }

    public function getTarikhPohon()
    {
        $date = \Yii::$app->formatter->asDate($this->entry_date, 'php:d-m-Y');
        return $date;
    }

    public function getStatusPermohonan()
    {
        $a = " - ";

        if ($this->active_status == '1') {
            $a = '<span class="label label-primary">PERMOHONAN BARU</span>';
        } elseif ($this->active_status == '2') {
            $a = '<span class="label label-warning">PERMOHONAN DISEMAK</span>';
        } elseif ($this->active_status == '3') {
            $a = '<span class="label label-info">PERMOHONAN DITERIMA</span>';
        } elseif ($this->active_status == '4') {
            $a = '<span class="label label-danger">PERMOHONAN DITOLAK</span>';
        } elseif ($this->active_status == '5') {
            $a = '<span class="label label-success">PERMOHONAN BERJAYA</span>';
        }

        return $a;
    }
}
