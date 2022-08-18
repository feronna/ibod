<?php

namespace app\models\kemudahan;
use app\models\hronline\Tblprcobiodata;
 
use Yii;

/**
 * This is the model class for table "facility.tbl_lesen".
 *
 * @property int $id
 * @property string $icno
 * @property string $jeniskemudahan nama kemudahan yang dipohon
 * @property string $tujuan tujuan kemudahan digunakan
 * @property string $used_dt
 * @property string $entry_date tarikh permohonan dibuat
 * @property string $resit
 * @property string $status_pt status olh pembantu tadbir
 * @property string $catatan_pt
 * @property string $semakan_pt tarikh semakan pembantu tadbir
 * @property string $status_pp status olh pegawai perakuan
 * @property string $catatan_pp
 * @property string $ver_date tarikh perakuan pegawai perakuan
 * @property string $tarikh_hantar
 * @property string $status_kj status olh ketua Bsm
 * @property string $catatan_kj
 * @property string $app_date tarikh kelulusan olh ketua Bsm
 * @property string $stat_bendahari
 * @property string $catatan_bendahari
 * @property string $bendahari_date
 * @property string $pengakuan 0 = tidak setuju, 1= setuju
 * @property int $mohon
 * @property int $isActive2 status permohonan
 * @property string $jumlah
 * @property string $dokumen_sokongan resit tiket penerbangan
 * @property string $dokumen_sokongan2 sijil kematian
 * @property int $status_semasa 0 = inprogress 1 = complete
 */
class Boranglesen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file;
    public $file2;
    public static function tableName()
    {
        return 'utilities.fac_tbl_lesen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['used_dt','resit', 'jumlah', 'file', 'file2'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['used_dt', 'entry_date', 'semakan_pt', 'ver_date', 'tarikh_hantar', 'app_date', 'bendahari_date'], 'safe'],
            [['mohon', 'isActive2', 'status_semasa', 'entry_type'], 'integer'],
            [['jumlah'], 'number'],
            [['dokumen_sokongan', 'dokumen_sokongan2'], 'string'],
            [['icno', 'semakan_by', 'peraku_by', 'pelulus_by'], 'string', 'max' => 12],
            [['jeniskemudahan'], 'string', 'max' => 50],
            [['catatan_pt', 'catatan_pp', 'catatan_kj', 'catatan_bendahari'], 'string', 'max' => 500],
            [['resit', 'status_pt', 'status_pp', 'status_kj', 'stat_bendahari'], 'string', 'max' => 20],
            [['pengakuan'], 'string', 'max' => 30],
            [['file', 'file2'], 'file','extensions'=>'pdf','maxSize' => 5000000], 
            [['file', 'file2'],'safe'], 
            
            
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
            'jeniskemudahan' => 'Jeniskemudahan',
            'used_dt' => 'Used Dt',
            'entry_date' => 'Entry Date',
            'resit' => 'Resit',
            'status_pt' => 'Status Pt',
            'catatan_pt' => 'Catatan Pt',
            'semakan_pt' => 'Semakan Pt',
            'status_pp' => 'Status Pp',
            'catatan_pp' => 'Catatan Pp',
            'ver_date' => 'Ver Date',
            'tarikh_hantar' => 'Tarikh Hantar',
            'status_kj' => 'Status Kj',
            'catatan_kj' => 'Catatan Kj',
            'app_date' => 'App Date',
            'stat_bendahari' => 'Stat Bendahari',
            'catatan_bendahari' => 'Catatan Bendahari',
            'bendahari_date' => 'Bendahari Date',
            'pengakuan' => '',
            'mohon' => 'Mohon',
            'isActive2' => 'Is Active2',
            'jumlah' => 'Jumlah',
            'dokumen_sokongan' => 'Dokumen Sokongan',
            'dokumen_sokongan2' => 'Dokumen Sokongan2',
            'status_semasa' => 'Status Semasa',
            'semakan_by' => 'Semakan Oleh',
            'peraku_by' => 'Peraku Oleh',
            'pelulus_by' => 'Pelulus Oleh',
            'entry_type' => 'Jenis permohonan',
        ];
    }
    public function getTarikh($bulan) {
        $m = date_format(date_create($bulan), "m");
        if ($m == 01) {
            $m = "Januari";
        } elseif ($m == 02) {
            $m = "Februari";
        } elseif ($m == 03) {
            $m = "Mac";
        } elseif ($m == 04) {
            $m = "April";
        } elseif ($m == 05) {
            $m = "Mei";
        } elseif ($m == 06) {
            $m = "Jun";
        } elseif ($m == 07) {
            $m = "Julai";
        } elseif ($m == '08') {
            $m = "Ogos";
        } elseif ($m == '09') {
            $m = "September";
        } elseif ($m == '10') {
            $m = "Oktober";
        } elseif ($m == '11') {
            $m = "November";
        } elseif ($m == '12') {
            $m = "Disember";
        }
        return date_format(date_create($bulan), "d") . ' ' . $m . ' ' . date_format(date_create($bulan), "Y");
    }
    public function getEntrydate() { 
            return $this->getTarikh($this->entry_date); 
    }
    public function getDate_pt() { 
            return $this->getTarikh($this->semakan_pt); 
    }
    public function getUsed() { 
            return $this->getTarikh($this->used_dt); 
    }
     public function getVerdate() {
        
            return $this->getTarikh($this->ver_date);
       
    }
    public function getAppdate() {
        
            return $this->getTarikh($this->app_date);
       
    }
    public function getBendahariD() {
         
            return $this->getTarikh($this->bendahari_date);
        
    }
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getDisplayjenis() {
        return $this->hasOne(Refjeniskemudahan::className(), ['kemudahancd' => 'jeniskemudahan']);
    }
   
    public function getDisplayakaun() {
        return $this->hasOne(Refakaun::className(), ['akauncd' => 'kodAkaun']);
    }
     public function getVtujuan() {
        return $this->hasOne(Reftujuan::className(), ['id' => 'tujuan']);
    }
     public function getPegTadbir() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'semakan_by']);
    }
     public function getPegBsm() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'peraku_by']);
    }
     public function getKjBsm() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pelulus_by']);
    } 
    public function getStatusLabel() {
        if ($this->status_pt == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-warning">BARU</span>';
        }
        if ($this->status_pt == 'DIPERAKUI') {
            return '<span class="label label-primary">DISEMAK</span>';
        }
        if ($this->status_pt == 'SEMAKAN LAYAK') {
            return '<span class="label label-success">BERJAYA </span>';
        }
        if ($this->status_pt == 'SEMAKAN TIDAK LAYAK') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
    }
    public function getStatuspp() {
        if ($this->status_pp == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-warning">BARU</span>';
        }
        if ($this->status_pp == 'MENUNGGU KELULUSAN') {
            return '<span class="label label-primary">Menunggu Tindakan Pegawai BSM </span>';
        }
        if ($this->status_pp == 'DIPERAKUI') {
            return '<span class="label label-success">BERJAYA</span>';
        }
        if ($this->status_pp == 'TIDAK DIPERAKUI') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
    }
    public function getStatuskj() {
        if ($this->status_kj == 'NEW') {
            return '<span class="label label-warning">BARU</span>';
        }
        if ($this->status_kj == 'ENTRY') {
            return '<span class="label label-primary">Menunggu Tindakan Pegawai BSM</span>';
        }
        if ($this->status_kj == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-info">DALAM TINDAKAN KJ</span>';
        }
        if ($this->status_kj == 'DILULUSKAN') {
            return '<span class="label label-success">BERJAYA</span>';
        }
        if ($this->status_kj == 'TIDAK DILULUSKAN') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
    }
    public function getStatuss() {
        if ($this->status_pp == 'MENUNGGU KELULUSAN') {
            return '<span class="label label-primary">Menunggu Tindakan Pegawai BSM</span>';
        }
        if ($this->stat_bendahari == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-default">ARAHAN BAYARAN KEPADA BENDAHARI </span>';
        }
        if ($this->stat_bendahari == 'DALAM PROSES BAYARAN' || $this->stat_bendahari == 'MENUNGGU KELULUSAN') {
            return '<span class="label label-default">ARAHAN BAYARAN KEPADA BENDAHARI</span>';
        }
        if ($this->stat_bendahari == 'EFT') {
            return '<span class="label label-success">BERJAYA / EFT</span>';
        }
    }
    public function perMonth($year,$mth) {
        
        return Boranglesen::find()->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['mohon' => 1])->count();
    }
    public function getTotal($year,$mth) {
        
        return Boranglesen::find()->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['mohon' => 1])->sum('jumlah');
    }
     public function getTotalYear($year) {
        
        return Boranglesen::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->sum('jumlah');
    }
    public function getTotalCount($year,$mth) {
        
        return Boranglesen::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->count();
    }
     public static function totalPendingTask($icno) {
         

        $total = 0;
 
            $total = count($model = Boranglesen::find()->where(['semakan_by' => $icno, 'status_pt' => 'MENUNGGU TINDAKAN'])->all());
 
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
    }
}
