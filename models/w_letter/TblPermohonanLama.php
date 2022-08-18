<?php

namespace app\models\w_letter;

use Yii;
use app\models\w_letter\RefKenderaan;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use DateTime;
use DatePeriod;
use DateInterval;
use app\models\umsshield\SelfRisk;
use app\models\cuti\SetPegawai;

class TblPermohonanLama extends \yii\db\ActiveRecord {

    public $tarikh;
    public $file;
    public $date1,$date2,$date3,$date4,$date5;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hrm.wl_tbl_permohonan_02042020';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [

            [['tarikh_mohon', 'ICNO', 'tugas', 'kategori', 'StartDate', 'EndDate'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['date1','date2','date3','date4','date5','kategori', 'file', 'auto_desc', 'veh_status', 'veh_file', 'veh_ulasan', 'auto', 'tarikh', 'tarikh_notifikasi', 'isActive', 'approved_at', 'approved_by', 'approved_text', 'apply_type', 'approved_kj_at', 'approved_kj_by', 'approved_kj_ulasan', 'approved_kj_status', 'approved_bsm_at', 'approved_bsm_by', 'approved_bsm_ulasan', 'approved_bsm_status', 'StartDate', 'EndDate'], 'safe'],
            [['status_semasa', 'status_notifikasi'], 'integer'],
            [['ICNO', 'approved_kj_by', 'approved_bsm_by'], 'string', 'max' => 12],
            [['file'], 'file', 'extensions' => 'pdf'],];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'tarikh_mohon' => 'Tarikh Mohon',
            'status_semasa' => 'Status Semasa',
            'tarikh_notifikasi' => 'Tarikh Notifikasi',
        ];
    }

    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }

    public function getKekangan() {
        return $this->hasOne(RefKenderaan::className(), ['id' => 'veh_status']);
    }

    public function isChief() {
        return \app\models\hronline\Department::findOne(['chief' => $this->ICNO]);
    }

    public function totalPendingKj() {

        $count = TblPermohonan::find()
                        ->where(['wl_tbl_permohonan.status_semasa' => 1])
                        ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                        ->leftJoin('hronline.department', 'tblprcobiodata.DeptId = department.id')
                        ->andWhere(['department.chief' => Yii::$app->user->getId()])
                        ->andWhere(['!=', 'wl_tbl_permohonan.ICNO', Yii::$app->user->getId()])->count();
        if ($count) {
            return '&nbsp;<span class="badge bg-red">' . $count . '</span>';
        } else {
            return '';
        }
    }

    public function getSetpegawai() {
        return $this->hasOne(SetPegawai::className(), ['pemohon_icno' => 'ICNO'])->where(['pelulus_icno' => Yii::$app->user->getId()]);
    }

    public function totalPendingPelulus() {

        $count = TblPermohonan::find()
                        ->where(['wl_tbl_permohonan.status_semasa' => 1])
                        ->joinWith('setpegawai')
                        ->andWhere(['!=', 'wl_tbl_permohonan.ICNO', Yii::$app->user->getId()])->count();
        if ($count) {
            return '&nbsp;<span class="badge bg-red">' . $count . '</span>';
        } else {
            return '';
        }
    }

    public function totalPendingBsm() {
        $count = TblPermohonan::find()->where(['status_semasa' => 2])->count();
        if ($count) {
            return '&nbsp;<span class="badge bg-red">' . $count . '</span>';
        } else {
            return '';
        }
    }

    public function totalPendingVc() {
        $c = Department::find()->all();
        $chief = array();
        foreach ($c as $c) {
            if ($c->id != 34) { // temp for piums
                $chief[] = $c->chief;
            }
        }

        $count = TblPermohonan::find()
                        ->where(['wl_tbl_permohonan.status_semasa' => 1])
                        ->andWhere(['IN', 'wl_tbl_permohonan.ICNO', $chief])->count();
        if ($count) {
            return '&nbsp;<span class="badge bg-red">' . $count . '</span>';
        } else {
            return '';
        }
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

//    public function getTotalByDept($id) {
//
//        $count = TblPermohonan::find()
//                ->where(['wl_tbl_permohonan.status_semasa' => 3])
//                ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
//                ->andWhere(['tblprcobiodata.DeptId' => $id])
//                ->andWhere(['>=', 'wl_tbl_permohonan.StartDate', date('Y-m-d', strtotime("2020-09-28"))])//sini tukar
//                ->andWhere(['<=', 'wl_tbl_permohonan.EndDate', date('Y-m-d', strtotime("2020-09-30"))]) //sini tukar
//                ->count();
//
//        return $count;
//    }

    public function getTotalByMonth($dept, $month) {

        $data = TblPermohonan::find()
                ->where(['wl_tbl_permohonan.status_semasa' => 3])
                ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                ->andWhere(['tblprcobiodata.DeptId' => $dept])
                ->andWhere(['=', 'MONTH(wl_tbl_permohonan.StartDate)', $month])
                ->count();

        return $data;
    }

    public function getTotalByDeptDay($dept, $day, $month) {
        if (strlen($day) == 1) {
            $day = '0' . $day;
        }

        $data = TblPermohonan::find()
                ->where(['wl_tbl_permohonan.status_semasa' => 3])
                ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                ->andWhere(['tblprcobiodata.DeptId' => $dept])
                ->andWhere(['=', 'DATE(wl_tbl_permohonan.StartDate)', date("2020-" . $month . "-" . $day)])
                ->count();

        return $data;
    }

    public function getTotalByDeptDayNE($dept, $day, $month, $cat) {
        if (strlen($day) == 1) {
            $day = '0' . $day;
        }

        $data = TblPermohonan::find()
                ->where(['wl_tbl_permohonan.status_semasa' => 3])
                ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                ->andWhere(['tblprcobiodata.DeptId' => $dept])
                ->andWhere(['=', 'DATE(wl_tbl_permohonan.StartDate)', date("2020-" . $month . "-" . $day)])
                ->andWhere(['=', 'wl_tbl_permohonan.kategori', $cat])
                ->count();

        return $data;
    }

    public function getTotalByMonthNE($dept, $month, $cat) {

        $data = TblPermohonan::find()
                ->where(['wl_tbl_permohonan.status_semasa' => 3])
                ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                ->andWhere(['tblprcobiodata.DeptId' => $dept])
                ->andWhere(['=', 'MONTH(wl_tbl_permohonan.StartDate)', $month])
                ->andWhere(['=', 'wl_tbl_permohonan.kategori', $cat])
                ->count();

        return $data;
    }

    public function getTotalByDeptDayE($dept, $day, $month) {
        if (strlen($day) == 1) {
            $day = '0' . $day;
        }

        $data = TblPermohonan::find()
                ->where(['wl_tbl_permohonan.status_semasa' => 3])
                ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                ->leftJoin('hronline.department', 'tblprcobiodata.DeptId = department.id')
                ->andWhere(['department.shortname' => $dept])
                ->andWhere(['=', 'DATE(wl_tbl_permohonan.StartDate)', date("2020-" . $month . "-" . $day)]) 
                ->count();

        return $data;
    }

    public function getTotalByMonthE($dept, $month) {

        $data = TblPermohonan::find()
                ->where(['wl_tbl_permohonan.status_semasa' => 3])
                ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                ->leftJoin('hronline.department', 'tblprcobiodata.DeptId = department.id')
                ->andWhere(['department.shortname' => $dept])
                ->andWhere(['=', 'MONTH(wl_tbl_permohonan.StartDate)', $month]) 
                ->count();

        return $data;
    }
    
    public function getTotalByDeptDayUmskal($dept, $day, $month,$cat) {
        if (strlen($day) == 1) {
            $day = '0' . $day;
        }

        $data = TblPermohonan::find()
                ->where(['wl_tbl_permohonan.status_semasa' => 3])
                ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                ->leftJoin('hronline.department', 'tblprcobiodata.DeptId = department.id')
                ->andWhere(['department.shortname' => $dept])
                ->andWhere(['=', 'DATE(wl_tbl_permohonan.StartDate)', date("2020-" . $month . "-" . $day)]) 
                ->andWhere(['wl_tbl_permohonan.kategori' => $cat])
                ->count();

        return $data;
    }

    public function getTotalByMonthUmskal($dept, $month,$cat) {

        $data = TblPermohonan::find()
                ->where(['wl_tbl_permohonan.status_semasa' => 3])
                ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                ->leftJoin('hronline.department', 'tblprcobiodata.DeptId = department.id')
                ->andWhere(['department.shortname' => $dept])
                ->andWhere(['=', 'MONTH(wl_tbl_permohonan.StartDate)', $month]) 
                ->andWhere(['wl_tbl_permohonan.kategori' => $cat])
                ->count();

        return $data;
    }

//    public function getTotalByDay($day, $month) {
//        if (strlen($day) == 1) {
//            $day = '0' . $day;
//        }
//
//        $data = TblPermohonan::find()
//                ->where(['wl_tbl_permohonan.status_semasa' => 3])
//                ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
//                ->andWhere(['=', 'DATE(wl_tbl_permohonan.tarikh_mohon)', date("2020-" . $month . "-" . $day)])
//                ->count();
//
//        return $data;
//    }

    public function findCardColor($id) {

        $data = SelfRisk::find()->where(['icno' => $id])->orderBy(['assessmentTaken' => SORT_DESC])->One();
        if ($data) {
            if ($data->riskGroupId == 2 || $data->riskGroupId == 3) {
                return '<strong><span class="required" style="color:red;">MERAH</span></strong>';
            } elseif ($data->riskGroupId == 4) {
                return '<strong><span class="required" style="color:yello;">KUNING</span></strong>';
            } elseif ($data->riskGroupId == 6) {
                return '<strong><span class="required" style="color:green;">HIJAU</span></strong>';
            } else {
                return '-';
            }
        } else {
            return '-';
        }
    }

    public function getStatusWorking($user, $day) {
        if (strlen($day) == 1) {
            $day = '0' . $day;
        }

        $data = TblPermohonan::find()
                ->where(['wl_tbl_permohonan.ICNO' => $user])
                ->andWhere(['=', 'DATE(wl_tbl_permohonan.StartDate)', date("2020-" . date('m') . "-" . $day)])
                ->andWhere(['wl_tbl_permohonan.status_semasa' => 1])
                ->count();

        return $data ? '1' : '0';
    }

    public function getStatusWorkingReport($user, $day) {
        if (strlen($day) == 1) {
            $day = '0' . $day;
        }

        $data = TblPermohonan::find()
                ->where(['wl_tbl_permohonan.ICNO' => $user])
                ->andWhere(['=', 'DATE(wl_tbl_permohonan.StartDate)', date("2020-" . date('m') . "-" . $day)])
                ->andWhere(['wl_tbl_permohonan.status_semasa' => 3])
                ->count();

        return $data ? '1' : '0';
    }

    public function getWorkingbyDay($dept, $day) {
        if (strlen($day) == 1) {
            $day = '0' . $day;
        }

        $data = TblPermohonan::find()
                ->where(['wl_tbl_permohonan.status_semasa' => 3])
                ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                ->andWhere(['tblprcobiodata.DeptId' => $dept])
                ->andWhere(['=', 'DATE(wl_tbl_permohonan.StartDate)', date("2020-" . date('m') . "-" . $day)])
                ->count();

        return $data;
    }

    public function getWorkingPercent($dept, $day) {
        $user = Tblprcobiodata::find()->where(['DeptId' => $dept, 'Status' => 1])->groupBy(['CONm'])->count();

        if (strlen($day) == 1) {
            $day = '0' . $day;
        }

        $data = TblPermohonan::find()
                ->where(['wl_tbl_permohonan.status_semasa' => 3])
                ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                ->andWhere(['tblprcobiodata.DeptId' => $dept])
                ->andWhere(['=', 'DATE(wl_tbl_permohonan.StartDate)', date("2020-" . date('m') . "-" . $day)])
                ->count();

        return number_format(($data / $user) * 100, 2, '.', '');
    }

    public function getStatusWorkingReportBsm($user, $month, $day) {
        if (strlen($day) == 1) {
            $day = '0' . $day;
        }

        $data = TblPermohonan::find()
                ->where(['wl_tbl_permohonan.ICNO' => $user])
                ->andWhere(['=', 'DATE(wl_tbl_permohonan.StartDate)', date("2020-" . $month . "-" . $day)])
                ->andWhere(['wl_tbl_permohonan.status_semasa' => 3])
                ->count();

        return $data ? '1' : '0';
    }

    public function getWorkingbyDayBsm($dept, $day, $month) {
        if (strlen($day) == 1) {
            $day = '0' . $day;
        }

        $data = TblPermohonan::find()
                ->where(['wl_tbl_permohonan.status_semasa' => 3])
                ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                ->andWhere(['tblprcobiodata.DeptId' => $dept])
                ->andWhere(['=', 'DATE(wl_tbl_permohonan.StartDate)', date("2020-" . $month . "-" . $day)])
                ->count();

        return $data;
    }

    public function getWorkingPercentBsm($dept, $day, $month) {
        $user = Tblprcobiodata::find()->where(['DeptId' => $dept, 'Status' => 1])->groupBy(['CONm'])->count();

        if (strlen($day) == 1) {
            $day = '0' . $day;
        }

        $data = TblPermohonan::find()
                ->where(['wl_tbl_permohonan.status_semasa' => 3])
                ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                ->andWhere(['tblprcobiodata.DeptId' => $dept])
                ->andWhere(['=', 'DATE(wl_tbl_permohonan.StartDate)', date("2020-" . $month . "-" . $day)])
                ->count();

        return number_format(($data / $user) * 100, 2, '.', '');
    }

    public function getJumlahKakitangan($dept) {
        $user = Tblprcobiodata::find()->where(['DeptId' => $dept, 'Status' => 1])->groupBy(['CONm'])->count();

        return $user;
    }
    
    public function getJumlahKakitanganbyname($dept) {
        $user = Tblprcobiodata::find() 
                ->where(['tblprcobiodata.Status'=>1])
                ->leftJoin('hronline.department', 'tblprcobiodata.DeptId = department.id')
                ->andWhere(['department.shortname' => $dept])->count();

        return $user;
    }

    public function getTotalEssential($kategori, $day, $month) {
        if (strlen($day) == 1) {
            $day = '0' . $day;
        }

        $data = TblPermohonan::find()
                ->andWhere(['=', 'DATE(wl_tbl_permohonan.StartDate)', date("2020-" . $month . "-" . $day)])
                ->andWhere(['wl_tbl_permohonan.status_semasa' => 3])
                ->andWhere(['wl_tbl_permohonan.kategori' => $kategori])
                ->count();

        return $data ? $data : '0';
    }

    public function getTotalWFObyDay($date) {
        $data = TblPermohonan::find()
                ->andWhere(['=', 'DATE(wl_tbl_permohonan.StartDate)', date($date)])
                ->andWhere(['wl_tbl_permohonan.status_semasa' => 3])
                ->count();

        return $data ? $data : '0';
    }
    public function isChiefBsm() {
        $model = \app\models\hronline\Department::find()->where(['shortname' => 'BSM'])->one();

        return $model ? $model->chief : "";
    }
    
    public function Bsm() {
        return Tblprcobiodata::find()->joinWith('chiefDepartment')->andWhere(['department.shortname' => 'BSM'])->one();
    }

}
