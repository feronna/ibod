<?php

namespace app\models\cbelajar;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\GredJawatan;

class TblLapordiri extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public $file, $file2, $file3, $file4, $file5, $file6;

    public static function tableName() {
        return 'hrd.cb_tbl_lapordiri';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['status_pengajian'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['dt_tesis', 'dt_viva', 'dt_nominal', 'nd_nominal', 'dt_endstudy', 'dt_result', 'dt_setuju', 'dt_ppuu', 'dt_iv', 'app_date', 'ver_date', 'dt_lapordiri', 'tarikh_mohon', 'dt_selesai'], 'safe'],
            [['dokumen', 'ulasan', 'kali_ke', 'lain', 'dokumen2', 'dokumen3', 'dokumen4', 'dokumen5', 'dokumen_6', 'ulasan_jfpiu'], 'safe'],
            [['dt_tesis', 'dt_viva', 'dt_nominal', 'nd_nominal', 'dt_endstudy', 'dt_result', 'dt_setuju', 'dt_ppuu', 'dt_iv', 'app_date', 'ver_date', 'dt_lapordiri', 'tarikh_mohon', 'dt_selesai'], 'safe'],
            [['dokumen', 'ulasan', 'kali_ke', 'lain', 'dokumen2', 'dokumen3', 'dokumen4', 'dokumen5', 'dokumen_6', 'ulasan_jfpiu'], 'string'],
//            [['ulasan_jfpiu'], 'required'],
            [['iklan_id', 'idBorang', 'tempoh', 'j_nd'], 'integer'],
            [['icno', 'app_by', 'ver_by'], 'string', 'max' => 12],
            [['status_pengajian', 'got', 'tahun'], 'string', 'max' => 20],
            [['correction', 'status_mesyuarat', 'status', 'status_jfpiu', 'status_bsm'], 'string', 'max' => 50],
            [['catatan', 'status_borang'], 'string', 'max' => 255],
            [['c_nd', 'c_ppuu'], 'string'],
            [['terima'], 'string', 'max' => 10],
            [['tarikh_mesyuarat'], 'string', 'max' => 122],
            [['agree', 'writing'], 'string', 'max' => 30],
            [['file', 'file2', 'file3', 'file4', 'file5', 'file6'], 'file', 'extensions' => 'pdf'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'laporID' => 'Lapor ID',
            'icno' => 'Icno',
            'status_pengajian' => 'Status Pengajian',
            'dt_tesis' => 'Dt Tesis',
            'dt_viva' => 'Dt Viva',
            'dt_endstudy' => 'Dt Endstudy',
            'dt_result' => 'Dt Result',
            'dt_iv' => 'Dt Iv',
            'dt_nominal' => 'Nominal Date',
            'nd_nominal' => 'End Nominal Date',
            'dt_setuju' => 'Date Setuju',
            'dokumen' => 'Dokumen',
            'correction' => 'Correction',
            'got' => 'Graduate On Time',
            'ulasan' => 'Ulasan',
            'app_by' => 'App By',
            'app_date' => 'App Date',
            'ver_by' => 'Ver By',
            'ver_date' => 'Var Date',
            'dt_lapordiri' => 'Dt Lapordiri',
            'catatan' => 'Catatan',
            'terima' => 'Terima',
            'kali_ke' => 'Kali Ke',
            'tarikh_mesyuarat' => 'Tarikh Mesyuarat',
            'status_mesyuarat' => 'Status Mesyuarat',
            'status_borang' => 'Status Borang',
            'tarikh_mohon' => 'Tarikh Mohon',
            'status' => 'Status',
            'status_jfpiu' => 'Status Jfpiu',
            'status_bsm' => 'Status Bsm',
            'agree' => '',
            'iklan_id' => 'Iklan ID',
            'writing' => 'Writing',
            'lain' => 'Lain',
            'dokumen2' => 'Dokumen2',
            'dokumen3' => 'Dokumen3',
            'dokumen4' => 'Dokumen4',
            'dokumen5' => 'Dokumen5',
            'dokumen_6' => 'Dokumen_6',
            'ulasan_jfpiu' => 'Ulasan Jfpiu',
            'idBorang' => 'Id Borang',
            'tempoh' => 'tempoh',
            'j_nd' => 'J ND',
            'tahun' => 'tahun'
        ];
    }

    public function getJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'icno']);
    }

    public function getDepartment() {
        return $this->hasOne(Department::className(), ['id' => 'DeptId']);
    }

    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public function getMaklumat() {
        return $this->hasOne(TblPermohonan::className(), ['icno' => 'icno']);
    }

    public function getStudy() {
        return $this->hasOne(RefStatus::className(), ['id' => 'status_pengajian']);
    }

    public function getCek() {
        return $this->hasOne(RefCorrection::className(), ['id' => 'correction']);
    }

    public function getPengajian() {

        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno', 'HighestEduLevelCd' => 'HighestEduLevelCd']);
    }

    public function perMonth($year, $month) {
        return TblLapordiri::find()->where(['YEAR(dt_lapordiri)' => $year])->andWhere(['MONTH(dt_lapordiri)' => $month])->count();
    }

    public function getTotal($year, $mth) {

        return TblLapordiri::find()->where(['YEAR(dt_lapordiri)' => $year])->andWhere(['MONTH(dt_lapordiri)' => $mth])->sum('jumlah');
    }

    public function getTotalYear($year) {

        return TblLapordiri::find()->where(['YEAR(dt_lapordiri)' => $year])->sum('jumlah');
    }

    public function getTotalCount($year, $mth) {

        return TblLapordiri::find()->where(['YEAR(dt_lapordiri)' => $year])->count();
    }

    public function getPendidikanTertinggi() {
        return $this->hasOne(Edulevel::className(), ['HighestEduLevelCd' => 'HighestEduLevelCd']);
    }

    public function getTempohKhidmat() {
        $model = $this->hasOne(\app\models\lppums\Tblprcobiodata::className(), ['icno' => 'icno'])->orderBy(['dt_lapordiri' => SORT_ASC])->one();
        if ($model) {
            $date1 = date_create($model->dt_lapordiri);
            $date2 = date_create(date('Y-m-d'));
            $tempoh = date_diff($date1, $date2)->format('%y Tahun, %m Bulan, %d Hari');
        } else {
            $tempoh = '-';
        }
        return $tempoh;
    }

    public function getUpload() {
        return $this->hasOne(TblLapordiri::className(), ['laporID' => 'laporID']);
    }

    public function getStatusjfpiu() {
        if ($this->status_jfpiu == 'Tunggu Perakuan') {
            return '<span class="label label-warning">DALAM TINDAKAN KJ</span>';
        }
        if ($this->status_jfpiu == 'Diperakukan') {
            return '<span class="label label-success">DIPERAKUKAN</span>';
        }
        if ($this->status_jfpiu == 'Tidak Diperakukan') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
    }

    public function getBorang() {
        return $this->hasOne(RefBorang::className(), ['id' => 'idBorang']);
    }

    public function getStatus() {
        return $this->hasOne(RefStatus::className(), ['status_pengajian' => 'status_pengajian']);
    }

    public function getStatusbsm() {
        if ($this->status_bsm == 'Tunggu Kelulusan') {
            return '<span class="label label-warning">DALAM TINDAKAN KJ</span>';
        }
        if ($this->status_bsm == 'Tunggu Kelulusan BSM') {
            return '<span class="label label-warning">DALAM TINDAKAN BSM</span>';
        }
        if ($this->status_bsm == 'Diluluskan') {
            return '<span class="label label-success">DILULUSKAN</span>';
        }
        if ($this->status_bsm == 'Tidak Diluluskan') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
        if ($this->status_bsm === NULL) {
            return '-';
        }
    }

    public function checkUpload($id) {
        $model = TblSurat::findOne(['icno' => Yii::$app->user->getId(), 'icno' => $id]);

        return $model;
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

    public function getDtlapor() {
        return $this->getTarikh($this->dt_lapordiri);
    }

    public function getDtkj() {
        return $this->getTarikh($this->app_date);
    }

    public function getDtselesai() {
        return $this->getTarikh($this->dt_selesai);
    }

    public function getDtnominal() {
        return $this->getTarikh($this->dt_nominal);
    }

    public function getDtsetuju() {
        if ($this->dt_setuju) {
            return $this->getTarikh($this->dt_setuju);
        } else {
            return "-";
        }
    }

    public function getDttesis() {
        return $this->getTarikh($this->dt_tesis);
    }

    public function getDtviva() {
        return $this->getTarikh($this->dt_viva);
    }

    public function getDtnstudy() {
        return $this->getTarikh($this->dt_endstudy);
    }

    public function getDtresult() {
        return $this->getTarikh($this->dt_result);
    }

    public function getDtiv() {
        return $this->getTarikh($this->dt_iv);
    }

    public function getTarikhnd() {
        return $this->getTarikh($this->dt_nominal);
    }

    public function getKetuajfpiu() {
        $pegawai = \app\models\hronline\Department::findOne(['id' => $this->kakitangan->DeptId]);
        if ($this->kakitangan->department->sub_of == '' || $this->kakitangan->department->sub_of == '12') {
            return $this->kakitangan->department->chiefBiodata->CONm; //kj 
        } else {
            $pegawaisub = \app\models\hronline\Department::findOne(['id' => $pegawai->sub_of]);
            return $pegawaisub->chiefBiodata->CONm; //kj
        }
    }

    public function getNamaapp() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'app_by']);
    }

    public function getJawatankj() {
        $pegawai = \app\models\hronline\Department::findOne(['id' => $this->kakitangan->DeptId]);
        if ($this->kakitangan->department->sub_of == '' || $this->kakitangan->department->sub_of == '12') {
            return $this->kakitangan->jawatan->nama; //kj 
        } else {
            $pegawaisub = \app\models\hronline\Department::findOne(['id' => $pegawai->sub_of]);
            return $pegawaisub->jawatan->nama; //kj
        }
    }

    public function getKetuajabatan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'app_by']);
    }

    public function getJawatanketua() {
        return $this->hasOne(\app\models\hronline\Tblrscoadminpost::className(), ['ICNO' => 'app_by'])->orderBy(['start_date' => SORT_DESC]);
    }

    public function getStud() {

        return TblPengajian::find()->where(['icno' => $this->icno, 'status' => [1, 2, 4]])->orderBy(['tarikh_mula' => SORT_DESC])->one();
    }

    public function getStudy2() {
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno', 'HighestEduLevelCd' => 'HighestEduLevelCd'])
                        ->orderBy(['tarikh_mula' => SORT_DESC]);
    }

    public function getStudysemasa() {
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno', 'HighestEduLevelCd' => 'HighestEduLevelCd'])
                        ->orderBy(['tarikh_mula' => SORT_DESC]);
    }

    public function getClaim() {
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno'])->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => [1, 20, 202]])
                        ->orderBy(['tarikh_mula' => SORT_DESC]);
    }

//    public function getLanjut() {
//       
//        return $this->hasMany(TblLanjutan::className(), ['icno' => 'icno','HighestEduLevelCd'=>'HighestEduLevelCd'])
//                ->orderBy(['cb_tbl_pengajian.tarikh_mula'
//            => SORT_ASC])->ONE();
//       
//   }
    public function getYearsList() {
        $currentYear = date('Y');
        $yearAdvance = date("Y", strtotime("+1 year"));
        $yearsRange = range('1998', $currentYear);
        return array_combine($yearsRange, $yearsRange);
    }

    public function getStudy3() {

        return TblPengajian::find()->where(['icno' => $this->icno, 'laporID' => 'laporID'])->one();
    }

//    public function getNd() {
//       
////       return TblNd::find()->where(['icno'=>$this->icno,'laporID'=>laporID])->all();
////               return $this->hasOne(TblNd::className(), ['icno'=>$this->icno]);
//        return $this->hasOne(TblNd::className(), ['icno' => 'icno','laporID'=>'laporID']);
//
//   }
    public function getNd() {

        return $this->hasOne(TblNd::className(), ['icno' => 'icno', 'HighestEduLevelCd' => 'HighestEduLevelCd']);
    }

    public function getNegara() {
        return $this->hasOne(Negara::className(), ['CountryCd' => 'CountryCd']);
    }

    public function getTempohpengajian() {

        $date1 = TblPengajian::find()->where(['ICNO' => $this->icno])->min('tarikh_mula');
        $date2 = TblPengajian::find()->where(['ICNO' => $this->icno])->min('tarikh_tamat');

        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $months = 0;

        while (strtotime('+1 MONTH', $ts1) < $ts2) {
            $months++;
            $ts1 = strtotime('+1 MONTH', $ts1);
        }

        return $months . ' Bulan ' . ($ts2 - $ts1) / (60 * 60 * 24) . ' Hari'; // 120 month, 26 days
    }

    public function getBiasiswa() {
        return $this->hasOne(TblBiasiswa::className(), ['icno' => 'icno']);
    }

    public function getNominal() {
        return $this->hasOne(TblNd::className(), ['icno' => 'icno']);
    }

    public function getBiasiswa2() {

        return TblBiasiswa::find()->where(['icno' => 'icno', 'status' => [1, 4]])->orderBy(['created_dt' => SORT_DESC])->one();
    }

//
    public function getTempoh1() {

        $date1 = TblLapordiri::find()->where(['icno' => $this->icno, 'HighestEduLevelCd' => $this->HighestEduLevelCd])->max('dt_nominal');

        $date2 = date("Y-m-d");

//
//        $ts1 = strtotime($date1);
//        $ts2 = strtotime($date2);
//
//        $months = 0;
//
//        while (strtotime('+1 MONTH', $ts1) < $ts2) {
//            $months++;
//            $ts1 = strtotime('+1 MONTH', $ts1);
//        }
//
//        return $months. ' Bulan '. ($ts2 - $ts1) / (60*60*24). ' Hari'; // 120 month, 26 days

        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        return $diff = (($year2 - $year1) * 12) + ($month2 - $month1) . ' BULAN';
    }

    public function getTempohh() {

        $date1 = TblLapordiri::find()->where(['icno' => $this->icno, 'HighestEduLevelCd' => $this->HighestEduLevelCd])->max('dt_nominal');
        $date2 = TblLapordiri::find()->where(['icno' => $this->icno, 'HighestEduLevelCd' => $this->HighestEduLevelCd])->max('nd_nominal');

//        $date2 = date("Y-m-d");
//
//        $ts1 = strtotime($date1);
//        $ts2 = strtotime($date2);
//
//        $months = 0;
//
//        while (strtotime('+1 MONTH', $ts1) < $ts2) {
//            $months++;
//            $ts1 = strtotime('+1 MONTH', $ts1);
//        }
//
//        return $months. ' Bulan '. ($ts2 - $ts1) / (60*60*24). ' Hari'; // 120 month, 26 days

        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        return $diff = 1 + (($year2 - $year1) * 12) + ($month2 - $month1) . ' BULAN';
    }

    public function getTempohhh() {

        $date1 = TblLapordiri::find()->where(['icno' => $this->icno, 'HighestEduLevelCd' => $this->HighestEduLevelCd])->max('dt_setuju');
//        $date2 = TblLapordiri::find()->where(['icno' => $this->icno, 'HighestEduLevelCd'=>$this->HighestEduLevelCd])->max('nd_nominal');

        $date2 = date("Y-m-d");

//
//        $ts1 = strtotime($date1);
//        $ts2 = strtotime($date2);
//
//        $months = 0;
//
//        while (strtotime('+1 MONTH', $ts1) < $ts2) {
//            $months++;
//            $ts1 = strtotime('+1 MONTH', $ts1);
//        }
//
//        return $months. ' Bulan '. ($ts2 - $ts1) / (60*60*24). ' Hari'; // 120 month, 26 days

        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        return $diff = (($year2 - $year1) * 12) + ($month2 - $month1) . ' BULAN';
    }

    public function getTajaan() {
        return $this->hasOne(TblBiasiswa::className(), ['icno' => 'icno', 'HighestEduLevelCd' => 'HighestEduLevelCd']);
    }

    public static function totalPendingReview($icno) {

        $total = 0;
//    if(TblAccess::find()->where( ['icno'=> $icno, 'level'=>[1,2]] )->exists()){
//     $model = TblPermohonan::find()->where([ 'status' => 'DALAM TINDAKAN KETUA JABATAN' ])->all();
// }
//        if ($model) {
//            $total = count($model);
//        }
//         else{
        $total = count($model = TblLapordiri::find()->where(['app_by' => $icno, 'status' => 'DALAM TINDAKAN KETUA JABATAN'])->all());
//        }
        if ($total > 0) {
            return $total;
        } else {
            return '';
        }
    }

    public static function totalPendingTaskAdmin($icno) {

        $total = 0;
//    if(TblAccess::find()->where( ['icno'=> $icno, 'level'=>[1,2]] )->exists()){
//     $model = TblPermohonan::find()->where([ 'status' => 'DALAM TINDAKAN KETUA JABATAN' ])->all();
// }
//        if ($model) {
//            $total = count($model);
//        }
//         else{
        if ($icno == "870818495847") {
            $total = count($model = TblLapordiri::find()->where(['ver_by' => $icno, 'status_jfpiu' => 'Diperakukan', 'status_bsm' => "Tunggu Kelulusan BSM"])->all());

            if ($total > 0) {
                return $total;
            } else {
                return '';
            }
        }
    }

}
