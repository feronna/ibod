<?php

namespace app\models\ln;

use Yii;
use app\models\hronline\Tblprcobiodata;
/**
 * This is the model class for table "hrm.ln_tbl_ln2".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $date_from
 * @property string $date_to
 * @property string $lulus_date
 * @property string $jfpib
 * @property string $nama
 * @property string $tujuan_lawatan
 * @property string $tempat
 * @property string $pembiayaan
 * @property string $kod_peruntukan
 * @property int $days
 * @property int $bil_peserta
 * @property string $program_lawatan
 * @property string $implikasi_lawatan
 * @property string $cadangan
 * @property string $kos_perbelanjaan
 * @property string $catatan
 * @property string $catatan_penyelarasan
 * @property string $penyelarasan
 * @property string $tambang
 * @property string $elaun_makan
 * @property string $elaun_hotel
 * @property string $yuran
 * @property string $transport
 * @property string $dll
 * @property string $jumlah
 */
class Ln2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file5;
    public static function tableName()
    {
        return 'hrm.ln_tbl_ln2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'tujuan_lawatan', 'tempat', 'date_from', 'date_to', 'bil_peserta', 'program_lawatan', 'implikasi_lawatan', 'cadangan','catatan', 'catatan_penyelarasan', 'tambang3' , 'elaun_makan3', 'elaun_hotel3', 'yuran3', 'transport3', 'dll3'], 'required', 'message' => 'Ruang ini adalah mandatori'],
//            [['ICNO', 'tujuan', 'tempat', 'date_from', 'date_to', 'bil_peserta', 'pembiayaan', 'kod_peruntukan', 'program', 'implikasi', 'cadangan', 'kos_perbelanjaan', 'catatan'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['date_from', 'date_to', 'lulus_date', 'entry_date'], 'safe'],
            [['tujuan_lawatan', 'tempat', 'pembiayaan', 'kod_peruntukan', 'program_lawatan', 'implikasi_lawatan', 'cadangan', 'catatan', 'catatan_penyelarasan', 'penyelarasan'], 'string'],
            [['parent_id', 'days', 'bil_peserta'], 'integer'],
            [['tambang3', 'elaun_makan3', 'elaun_hotel3', 'yuran3', 'transport3', 'dll3', 'jumlah3'],  'string', 'message' => 'Ruang ini mesti diisi dalam nombor sahaja'],
            [['ICNO'], 'string', 'max' => 12],
            [['jfpib'], 'string', 'max' => 60],
            [['nama'], 'string', 'max' => 255],
            [['file5'],'safe'],
            [['file5'], 'file','extensions'=>'pdf'], 
            [['dokumen_ln2'], 'required', 'message' => 'Sila Lampirkan Dokumen Sokongan'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'ICNO' => 'Icno',
            'parent_id' => 'Parent ID',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'lulus_date' => 'Lulus Date',
            'jfpib' => 'Jfpib',
            'nama' => 'Nama',
            'tujuan_lawatan' => 'Tujuan Lawatan',
            'tempat' => 'Tempat',
            'pembiayaan' => 'Pembiayaan',
            'kod_peruntukan' => 'Kod Peruntukan',
            'days' => 'Days',
            'bil_peserta' => 'Bil Peserta',
            'program_lawatan' => 'Program Lawatan',
            'implikasi_lawatan' => 'Implikasi Lawatan',
            'cadangan' => 'Cadangan',
            'catatan' => 'Catatan',
            'catatan_penyelarasan' => 'Catatan Penyelarasan',
            'tambang3' => 'Tambang',
            'elaun_makan3' => 'Elaun Makan',
            'elaun_hotel3' => 'Elaun Hotel',
            'yuran3' => 'Yuran',
            'transport3' => 'Transport',
            'dll3' => 'Dll',
            'jumlah3' => 'Jumlah',
            'entry_date' => 'Tarikh Mohon',
            'dokumen_ln2' => 'Dokumen Ln2',
        ];
    }
    
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
    
        public function getLn() {
        return $this->hasOne(Ln::className(), ['icno' => 'icno']);
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
    
        public function getLulusdate() {
        return  $this->getTarikh($this->lulus_date);
    }
    
//    public function getDatefrom() {
//         if($this->date_from!=''){
//         return  $this->getTarikh($this->date_from);}
//         else { return '-';}
//    }
}
