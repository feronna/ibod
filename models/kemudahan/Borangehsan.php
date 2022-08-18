<?php

namespace app\models\kemudahan;
use app\models\hronline\Tblprcobiodata;
use app\models\kemudahan\Reftujuan;
use app\models\hronline\Tblkeluarga;
use app\models\hronline\HubunganKeluarga;

use Yii;

/**
 * This is the model class for table "facility.borang_ehsan".
 *
 * @property int $id
 * @property string $icno
 * @property int $jeniskemudahan nama kemudahan yang dipohon
 * @property string $pohon jumlah kemudahan yg dipohon
 * @property string $tujuan tujuan kemudahan digunakan
 * @property string $tarikh_mohon
 * @property string $status_pt status olh pembantu tadbir
 * @property string $catatan_pt
 * @property string $semakan_pt tarikh semakan pembantu tadbir
 * @property string $status_pp status olh pegawai perakuan
 * @property string $catatan_pp
 * @property string $ver_date tarikh perakuan pegawai perakuan
 * @property string $status_kj status olh ketua Bsm
 * @property string $catatan_kj
 * @property string $app_date tarikh kelulusan olh ketua Bsm
 * @property string $tarikh_terima
 * @property string $pengakuan pengakuan pegawai memohon
 * @property int $isActive status permohonan
 */
class Borangehsan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file;
    public $file2;
    public static function tableName()
    {
        return 'utilities.fac_tbl_ehsan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [ 
            [['pohon', ], 'required', 'message' => 'Ruang ini adalah mandatori'],
//            [['file', 'file2' ], 'required', 'message' => 'Please Upload a file'],
            [['tujuan'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['used_dt', 'entry_date', 'semakan_pt', 'ver_date', 'app_date', 'bendahari_date', 'tarikh_hantar'], 'safe'],
            [['jeniskemudahan'], 'string', 'max' => 50],
            [['icno', 'semakan_by', 'peraku_by', 'pelulus_by'], 'string', 'max' => 12],
            [['pohon'], 'string', 'max' => 20],
            [['tujuan', 'catatan_pt', 'catatan_pp', 'catatan_kj', 'catatan_bendahari'], 'string', 'max' => 500],
            [['status_pt', 'status_pp', 'status_kj', 'stat_bendahari', 'resit'], 'string', 'max' => 20],
            [['pengakuan'], 'string', 'max' => 200],
            [['jumlah'], 'string', 'max' => 100],
            [['mohon', 'isActive2', 'status_semasa', 'entry_type'], 'integer'],
            [['file', 'file2'], 'file','extensions'=>'pdf','maxSize' => 5000000], 
            [['file', 'file2'],'safe'], 
            [['dokumen_sokongan'], 'required', 'message' => 'Muat Naik Dokumen!'],
            [['dokumen_sokongan2'], 'required', 'message' => 'Muat Naik Dokumen!'],

            
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'ICNO',
            'jeniskemudahan' => 'Jeniskemudahan',
            'pohon' => 'Pohon',
            'tujuan' => 'Tujuan',
            'resit' => 'No.Resit',
            'used_dt' => 'Tarikh',
            'entry_date' => 'Tarikh Mohon',
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
            'stat_bendahari' => 'Status Bendahari',
            'catatan_bendahari' => 'Catatan Bendahari',
            'bendahari_date' => 'Tarikh Bendahari',
            'pengakuan' => '',
            'jumlah' => 'Jumlah',
            'isActive2' => 'Is Active',
            'mohon' => 'mohon',
            'file' => 'Resit Tiket :',
            'file' => 'Sijil Kematian :',
            'status_semasa' => 'Status semasa',
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
     public function getFamily() {
        return $this->hasOne(Tblkeluarga::className(), ['ICNO' => 'icno']);
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
     
     public function getHubunganKeluarga() {
         
        return $this->hasMany(HubunganKeluarga::className(), ['RelCd' => 'RelCd']);
    }
     public function getHubkeluarga() {
        if ($this->hubunganKeluarga) {
            return $this->hubunganKeluarga->RelNm;
        }
        return '-';
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

//    public static function totalPending($icno) { 
//        
//        $total = 0; 
//         
//        $model = Borangehsan::find()->where(['status_pt' => $icno, 'status_pt' => 'MENUNGGU TINDAKAN' ])->andWhere(['jeniskemudahan' => 5])->all();
//       
//        if ($model) {
//            $total = count($model);
//        }
//        
//        else{
//            $total = count( $model = Borangehsan::find()->where(['status_pt' => $icno, 'status_pt' => 'MENUNGGU TINDAKAN' ])->andWhere(['jeniskemudahan' => 5])->all());
//        }
//        
//        if ($total > 0) {
//                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
//            }
//        else {
//                return '';
//        }
//         
//        
//    }
//     public static function totalPendingEhsan($icno) { 
//        
//        $total = 0; 
//       if(Borangehsan::find()->where( ['status_pt' => $icno] )){ 
//       $model = Borangehsan::find()->where(['status_pt' => $icno, 'status_pt' => 'MENUNGGU TINDAKAN'])->andWhere(['jeniskemudahan' => 5])->all();
//   //  $model = Borangehsan::find()->where(['status_pt' => $icno, 'status_pt' => 'MENUNGGU TINDAKAN' ])->andWhere(['jeniskemudahan' => 5])->all();
//       
//        if ($model) {
//            $total = count($model);
//        }
//        
//        else{
//            $total = count( $model = Borangehsan::find()->where(['status_pt' => $icno, 'status_pt' => 'MENUNGGU TINDAKAN'])->andWhere(['jeniskemudahan' => 5])->all());
//        }
//        
//        if ($total > 0) {
//                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
//            }
//        else {
//                return '';
//        }
//       }
//    }
//   
//     public static function totalPending2($icno) {
//
//       $total = 0;
//       
//       $model = Borangehsan::find()->where(['status_pp' => $icno, 'status_pp' => 'MENUNGGU KELULUSAN'])->all();
//        if ($model) {
//            $total = count($model);
//        }
//        
//         else{
//            $total = count($model = Borangehsan::find()->where(['status_pp' => $icno, 'status_pp' => 'MENUNGGU KELULUSAN']) ->all());
//        }
//        if ($total > 0) {
//                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
//            }
//        else {
//                return '';
//        }
//     }
//     
//      public static function totalPending3($icno) {
//
//       $total = 0;
//         
//       $model = Borangehsan::find()->where(['status_kj' => $icno, 'status_kj' => 'MENUNGGU TINDAKAN'])->all();
//        if ($model) {
//            $total = count($model);
//        }
//        
//         else{
//            $total = count($model = Borangehsan::find()->where(['status_kj' => $icno, 'status_kj' => 'MENUNGGU TINDAKAN'])->all());
//        }
//        if ($total > 0) {
//                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
//            }
//        else {
//                return '';
//        }
//     }
//     public static function totalPending4($icno) {
//
//       $total = 0;
//         
//       $model = Borangehsan::find()->where(['status_pp' => $icno, 'stat_bendahari' => 'MENUNGGU KELULUSAN'])->all();
//        if ($model) {
//            $total = count($model);
//        }
//        
//         else{
//            $total = count($model = Borangehsan::find()->where(['stat_bendahari' => $icno, 'stat_bendahari' => 'MENUNGGU KELULUSAN'])->all());
//        }
//        if ($total > 0) {
//                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
//            }
//        else {
//                return '';
//        }
//     }
//     public static function totalPending5($icno) {
//
//       $total = 0;
//         
//       $model = Borangehsan::find()->where(['stat_bendahari' => $icno, 'stat_bendahari' => 'DALAM PROSES BAYARAN'])->all();
//        if ($model) {
//            $total = count($model);
//        }
//        
//         else{
//            $total = count($model = Borangehsan::find()->where(['stat_bendahari' => $icno, 'stat_bendahari' => 'DALAM PROSES BAYARAN'])->all());
//        }
//        if ($total > 0) {
//                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
//            }
//        else {
//                return '';
//        }
//     }
        
     public function perMonth($year,$mth) {
        
        return Borangehsan::find()->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['mohon' => 1])->count();
    }
     public function getTotalCount($year,$mth) {
        
        return Borangehsan::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->count();
    }
    public function getTotal($year,$mth) {
        
        return Borangehsan::find()->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['mohon' => 1]) ;
    }
}