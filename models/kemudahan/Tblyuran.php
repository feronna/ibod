<?php

namespace app\models\kemudahan;
use app\models\hronline\TblBadanProfesional;
use app\models\hronline\BadanProfesional;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "facility.tbl_yuran".
 *
 * @property int $id
 * @property string $icno
 * @property int $jeniskemudahan
 * @property string $badan_prof nama badan professional
 * @property string $jumlah
 * @property string $payment jenis bayaran
 * @property string $used_dt tarikh digunakan
 * @property string $entry_date
 * @property string $status_pt
 * @property string $catatan_pt
 * @property string $semakan_pt
 * @property string $status_pp
 * @property string $catatan_pp
 * @property string $ver_date
 * @property string $tarikh_hantar
 * @property string $status_kj
 * @property string $catatan_kj
 * @property string $app_date
 * @property string $stat_bendahari
 * @property string $catatan_bendahari
 * @property string $bendahari_date
 * @property string $pengakuan
 * @property int $mohon
 * @property int $isActive2
 * @property string $dokumen_sokongan
 * @property string $dokumen_sokongan2
 */
class Tblyuran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file;
    public $file2;
    public static function tableName()
    {
        return 'utilities.fac_tbl_yuran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['badan_prof', 'jumlah', 'resit', 'payment', 'file', 'file2'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['jeniskemudahan', 'mohon', 'isActive2', 'status_semasa', 'entry_type'], 'integer'],
            [['jumlah'], 'number'],
            [['used_dt', 'entry_date', 'semakan_pt', 'ver_date', 'tarikh_hantar', 'app_date', 'bendahari_date'], 'safe'],
            [['dokumen_sokongan', 'dokumen_sokongan2'], 'string'],
            [['icno', 'semakan_by', 'peraku_by', 'pelulus_by'], 'string', 'max' => 12],
            [['badan_prof'], 'string', 'max' => 300],
            [['payment', 'catatan_pt', 'catatan_pp', 'catatan_kj', 'catatan_bendahari'], 'string', 'max' => 500],
            [['status_pt', 'status_pp', 'status_kj', 'stat_bendahari', 'pengakuan', 'resit'], 'string', 'max' => 20],
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
            'badan_prof' => 'Badan Prof',
            'jumlah' => 'Jumlah',
            'payment' => 'Payment',
            'resit' => 'Resit',
            'used_dt' => 'Used Dt',
            'entry_date' => 'Entry Date',
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
            'dokumen_sokongan' => 'Dokumen Sokongan',
            'dokumen_sokongan2' => 'Dokumen Sokongan2',
            'status_semasa' => 'status_semasas',
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
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
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
    public function getDisplayjenis() {
        return $this->hasOne(Refjeniskemudahan::className(), ['kemudahancd' => 'jeniskemudahan']);
    }
     public function getVerdate() {
        if ($this->ver_date != '') {
            return $this->getTarikh($this->ver_date);
        }
    }
    public function getAppdate() {
        if ($this->app_date != '') {
            return $this->getTarikh($this->app_date);
        }
    }
    public function getBendahariD() {
        if ($this->bendahari_date != '') {
            return $this->getTarikh($this->bendahari_date);
        }
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
        
        return Tblyuran::find()->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['mohon' => 1])->count();
    }
     public function getTotalCount($year,$mth) {
        
        return Tblyuran::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->count();
    }
    public function getTotal($year,$mth) {
        
        return Tblyuran::find()->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['mohon' => 1])->sum('jumlah');
    }

     public static function feesList($icno)
    {

        $model = self::find()->where(['icno' => $icno])->all();

        $arr = [];

        if ($model) {
            $arr = ArrayHelper::map($model, 'ProfBodyCd', 'ProfBodyOther');
        }

        return $arr;
    }
   public function getTranslate()
    {
        return $this->hasOne(BadanProfesional::class, ['ProfBodyCd' => 'ProfBody']);
    }


}

