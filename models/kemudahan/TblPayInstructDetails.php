<?php

namespace app\models\kemudahan;
use app\models\hronline\Tblprcobiodata;
use app\models\Kemudahan\TblPayinstruct;
use Yii;

/**
 * This is the model class for table "utilities.fac_tbl_pay_instruct_details".
 *
 * @property int $id
 * @property string $icno
 * @property string $elaun_kemudahan
 * @property string $elaun
 * @property string $jumlah_sebelum
 * @property string $jumlah
 * @property string $jenis_kiraan
 * @property string $kod_projek
 * @property string $pusat_kos
 * @property string $from
 * @property string $until
 * @property string $no_akaun
 * @property string $akaun_no
 * @property string $jenis
 * @property string $jenis_perubahan
 * @property int $parent_id
 */
class TblPayInstructDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.fac_tbl_pay_instruct_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jumlah_sebelum', 'jumlah'], 'number'],
            [['from', 'until', 'approver_date'], 'safe'],
            [['parent_id', 'entry_type'], 'integer'],
            [['icno'], 'string', 'max' => 12],
            [['elaun_kemudahan', 'elaun', 'approver_remark'], 'string', 'max' => 300],
            [['jenis_kiraan', 'kod_projek', 'pusat_kos', 'no_akaun', 'akaun_no', 'jenis', 'jenis_perubahan', 'approver_status'], 'string', 'max' => 30],
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
            'elaun_kemudahan' => 'Elaun Kemudahan',
            'elaun' => 'Elaun',
            'jumlah_sebelum' => 'Jumlah Sebelum',
            'jumlah' => 'Jumlah',
            'jenis_kiraan' => 'Jenis Kiraan',
            'kod_projek' => 'Kod Projek',
            'pusat_kos' => 'Pusat Kos',
            'from' => 'From',
            'until' => 'Until',
            'no_akaun' => 'No Akaun',
            'akaun_no' => 'Akaun No',
            'jenis' => 'Jenis',
            'jenis_perubahan' => 'Jenis Perubahan',
            'parent_id' => 'Parent ID',
            'approver_status' => 'App Status',
            'approver_date' => 'App Date',
            'approver_remark' => 'App Remark',
            'entry_type' => 'Application By',
        ];
    }
    public function getTarikh($bulan){
        
        $m = date_format(date_create($bulan), "m");
        if($m == 01){
            $m = "01";}
        elseif ($m == 02){
          $m = "02";}
        elseif ($m == 03){
          $m = "03";}
        elseif ($m == 04){
          $m = "04";}
        elseif ($m == 05){
          $m = "05";}
        elseif ($m == 06){
          $m = "06";}
        elseif ($m == 07){
          $m = "07";}
        elseif ($m == '08'){
          $m = "08";}
        elseif ($m == '09'){
          $m = "09";}
        elseif ($m == '10'){
          $m = "10";}
        elseif ($m == '11'){
          $m = "11";}
        elseif ($m == '12'){
          $m = "12";}
          
        return date_format(date_create($bulan), "d-").' '.$m.' '.date_format(date_create($bulan), "-Y");
    }
     public function getDatefrom() {
        if ($this->from != '') {
            return $this->getTarikh($this->from);
        }
    }
    public function getDateuntil() {
        if ($this->until != '') {
            return $this->getTarikh($this->until);
        }
    }
    public function getAppDt() {
        if ($this->approver_date != '') {
            return $this->getTarikh($this->approver_date);
        }
    }
     public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    } 
    public function getElaunPakaian() {
        return $this->hasOne(Refjeniskemudahan::className(), ['kemudahancd' => 'elaun_kemudahan']);
    }
     public function getStatuskj() {
        if ($this->approver_status == 'NEW') {
            return '<span class="label label-warning">BARU</span>';
        }
        if ($this->approver_status == 'ENTRY') {
            return '<span class="label label-primary">Menunggu Tindakan</span>';
        }
        if ($this->approver_status == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-info">DALAM TINDAKAN KJ</span>';
        }
        if ($this->approver_status == 'DILULUSKAN') {
            return '<span class="label label-success">BERJAYA</span>';
        }
        if ($this->approver_status == 'TIDAK DILULUSKAN') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
    }
    public function getPayDetails() {
        return $this->hasOne(TblPayinstruct::className(), ['PAY_PARENT_ID' => 'parent_id']);
    } 
}
