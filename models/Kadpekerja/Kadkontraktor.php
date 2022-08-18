<?php

namespace app\models\Kadpekerja;

use Yii;

/**
 * This is the model class for table "keselamatan.utils_tbl_kad_kontraktor".
 *
 * @property int $id
 * @property string $icno
 * @property string $card_owner
 * @property string $card_id
 * @property string $entry_date
 * @property string $card_type jenis permohonan kad
 * @property string $masa_ambil
 * @property string $payment
 * @property string $cur_stat status proses permohonan terkini
 * @property string $ver_stat
 * @property string $ver_by pegawai peraku
 * @property string $ver_date
 * @property string $ver_catatan
 * @property string $app_stat
 * @property string $app_by pegawai pelulus
 * @property string $app_date
 * @property string $app_catatan
 * @property string $dokumen surat tawaran
 * @property string $dokumen2 surat lantikan
 * @property string $dokumen3 gambar
 * @property int $isActive aktif/tidak aktif
 * @property int $status_semasa 1 = in process, 0 = complete
 * @property int $status_kad 1 = kad sedia diambil, 0 =  belum diambil
 * @property string $wakil_ICNO
 * @property string $wakil_nama
 */
class Kadkontraktor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.utils_tbl_kad_kontraktor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entry_date', 'masa_ambil', 'ver_date', 'app_date'], 'safe'],
            [['ver_catatan', 'app_catatan', 'dokumen', 'dokumen2', 'dokumen3'], 'string'],
            [['isActive', 'status_semasa', 'status_kad'], 'integer'],
            [['icno', 'ver_by', 'app_by', 'wakil_ICNO'], 'string', 'max' => 12],
            [['card_owner', 'card_type', 'wakil_nama'], 'string', 'max' => 300],
            [['card_id', 'payment', 'cur_stat', 'ver_stat', 'app_stat'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'card_owner' => 'Card Owner',
            'card_id' => 'Card ID',
            'entry_date' => 'Entry Date',
            'card_type' => 'Card Type',
            'masa_ambil' => 'Masa Ambil',
            'payment' => 'Payment',
            'cur_stat' => 'Cur Stat',
            'ver_stat' => 'Ver Stat',
            'ver_by' => 'Ver By',
            'ver_date' => 'Ver Date',
            'ver_catatan' => 'Ver Catatan',
            'app_stat' => 'App Stat',
            'app_by' => 'App By',
            'app_date' => 'App Date',
            'app_catatan' => 'App Catatan',
            'dokumen' => 'Dokumen',
            'dokumen2' => 'Dokumen 2',
            'dokumen3' => 'Dokumen 3',
            'isActive' => 'Is Active',
            'status_semasa' => 'Status Semasa',
            'status_kad' => 'Status Kad',
            'wakil_ICNO' => 'Wakil Icno',
            'wakil_nama' => 'Wakil Nama',
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
     public function getEntryDt() {
        if ($this->entry_date != '') {
            return $this->getTarikh($this->entry_date);
        }
    } 
}
