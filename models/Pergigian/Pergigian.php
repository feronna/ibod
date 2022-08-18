<?php

namespace app\models\Pergigian;

use app\models\hronline\Tblprcobiodata;
use app\models\hronline\GredJawatan;
use app\models\hronline\Tblkeluarga;
use app\models\hronline\Department;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "pergigian.tbl_tuntutan_gigi".
 *
 * @property int $tuntutan_gigi_id
 * @property string $icno
 * @property int $klinik_gigi_id
 * @property int $gred_id
 * @property int $dept_id
 * @property string $used_dt
 * @property string $check_by
 * @property string $check_dt
 * @property string $app_by
 * @property string $app_dt
 * @property string $jumlah_tuntutan
 * @property string $catatan
 * @property string $datetime_record_entry
 * @property string $status_check
 * @property string $status_app
 */
class Pergigian extends \yii\db\ActiveRecord
{
    
    
    public $file;
    public $jenis_carian = '0';
    public $carian_data;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.gigi_tbl_tuntutan_gigi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_tuntutan_id','klinik_gigi_id', 'gred_id', 'dept_id'], 'integer'],
            [['used_dt', 'check_dt', 'app_dt','bayar_dt', 'entry_dt','print_dt'], 'safe'],
            [['catatan','status_check','catatan_check','catatan_app','catatan_bayar','status_app','status_bayar','status','dokumen_sokongan','lain','kacamata','used_by'], 'string'],
            [['icno', 'check_by', 'app_by','bayar_by','used_by'], 'string', 'max' => 15],
            [['jumlah_tuntutan','jumlah_lulus'], 'double', 'max' => 300],
            [['file'], 'file','extensions'=>'pdf'],
            [['carian_data', 'jenis_carian','id_status'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tuntutan_gigi_id' => 'Tuntutan Gigi ID',
            'icno' => 'ICNO',
            'klinik_gigi_id' => 'Klinik Gigi ID',
            'gred_id' => 'Gred Jawatan',
            'dept_id' => 'Dept ID',
            'used_dt' => 'Tarikh Rawatan',
            'check_by' => 'Disemak oleh',
            'check_dt' => 'Disemak pada',
            'app_by' => 'Diluluskan oleh',
            'app_dt' => 'Diluluskan pada',
            'bayar_by' => 'Dibayar',
            'bayar_dt' => 'Bayar Dt',
            'jumlah_tuntutan' => 'Jumlah Tuntutan (RM)',
            'catatan' => 'Catatan/No.Bil/Resit',
            'entry_dt' => 'Entry Date',
            'status_check' => 'Status Semak',
            'status_app' => 'Status Lulus',
            'lain' => 'Lain-Lain',
            'kacamata' => 'Kedai Kacamata',
            'used_by' => 'Digunakan oleh',
        ];
    }
    
    public function getKlinik() {
        return $this->hasOne(Klinik::className(), ['klinik_gigi_id' => 'klinik_gigi_id']);
    }
    
    public function getKlinikname(){
        if($this->klinik){
            return $this->klinik->klinik_nama;
        }
        return '-';
    }
    
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
    public function getAkses() {
        return $this->hasOne(Pergigian::className(), ['icno' => 'icno']);
    }

     public function getKeluarga() {
        return $this->hasOne(Tblkeluarga::className(), ['FamilyId' => 'used_by']);
    }
    
     public function getHubungan() {
        return $this->hasOne(Tblkeluarga::className(), ['ICNO' => 'icno']);
    }

    public function getKakitanganCheck() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'check_by']);
    }
    
    public function getKakitanganApp() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'app_by']);
    }
    public function getKakitanganBayar() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'bayar_by']);
    }
    
    public function getBakisemasa() {
        $query = Pergigian::find()->where(['icno'=>$this->icno, 'YEAR(used_dt)' => date('Y')])->sum('jumlah_tuntutan');
        
        return 300 - $query;
    }
    public function getBaki() {
        $query = Pergigian::find()->where(['icno'=>$this->icno, 'YEAR(used_dt)' => date('Y')])->sum('jumlah_tuntutan');
        
        return 300 - $query;
    }
    
    public function getJumlah() {
        $query = Pergigian::find()->where(['icno'=>$this->icno, 'YEAR(used_dt)' => date('Y')])->sum('jumlah_tuntutan');
        if (!empty($query)){
            return $query;
        }
        return '0';
    }
    
    public function getJumlahK() {
        $query = Pergigian::find()->where(['icno'=>$this->icno, 'YEAR(used_dt)' => date('Y')])->sum('jumlah_tuntutan');
        if (!empty($query)){
            return $query;
        }
        return '0';
    }   
    
    public function getJawatan(){
        return $this->hasOne(GredJawatan::className(), ['id'=> 'gred_id']);
    }
    
    public function getDepartment(){
        return $this->hasOne(Department::className(), ['id'=> 'dept_id']);
    }   
    //NORNI
   public function getStatusS() {
        if ($this->status_check == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-warning">BARU</span>';
        }

        if ($this->status_check == 'DITOLAK') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
        if ($this->status_check == 'DISEMAK') {
            return '<span class="label label-primary">DISEMAK</span>';
        }
    }
    //SHARIFAH
       public function getStatusL() {
        if ($this->status_app == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-warning">BARU</span>';
        }

        if ($this->status_app == 'MENUNGGU KELULUSAN') {
            return '<span class="label label-primary">DALAM TINDAKAN PELULUS </span>';
        }
        
        if ($this->status_app == 'DILULUSKAN') {
            return '<span class="label label-info">DILULUSKAN </span>';
        }

        if ($this->status_app == 'TIDAK DILULUSKAN') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
        
    }
//BENDAHARI
       public function getStatusB() {
        if ($this->status_bayar == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-warning">BARU</span>';
        }

        if ($this->status_bayar == 'DILULUSKAN') {
            return '<span class="label label-default">ARAHAN BAYARAN KEPADA BENDAHARI </span>';
        }

        if ($this->status_bayar == 'DITOLAK') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
        
        if ($this->status_bayar == 'BERJAYA') {
            return '<span class="label label-success">DISEMAK / DILULUSKAN / EFT</span>';
        }
    }
    
       public function getStatusK() {
        if ($this->status == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-warning">BARU</span>';
        }
        
        if ($this->status == 'DILULUSKAN') {
            return '<span class="label label-default">ARAHAN BAYARAN KEPADA BENDAHARI </span>';
        
        }
        
        // if ($this->status_check == 'DISEMAK') {
        //     return '<span class="label label-primary">DISEMAK</span>';
        // }

        if ($this->status == 'DILULUSKAN') {
            return '<span class="label label-info">DILULUSKAN </span>';
        }

        if ($this->status == 'DITOLAK') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
        
        if ($this->status == 'BERJAYA') {
            return '<span class="label label-success">DISEMAK / DILULUSKAN / EFT</span>';
        }
    }
    
    public function perMonth($year,$mth) {
        
        return Pergigian::find()->where(['YEAR(used_dt)' => $year])->andWhere(['MONTH(used_dt)' => $mth])->count();
    }
    
    public function getTotalCount($year,$mth) {
        
        return Pergigian::find()->where(['YEAR(used_dt)' => $year])->count();
    }
    
    public function carian($params) {
    $query = Pergigian::find();

    $dataProvider = new ActiveDataProvider([
    'query' => $query,
    ]);

    $this->load($params);

    if (!$this->validate()) {
            return $dataProvider;
        }
        switch ($this->jenis_carian) {
            case '1':
                $query->andFilterWhere(['like', 'kakitangan.CONm', $this->nama]);
                break;
            default:
                $query->andFilterWhere(['like', 'icno', $this->carian_data]);
                break;
        }
                   
        return $dataProvider;
    }
    
}
