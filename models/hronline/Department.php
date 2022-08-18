<?php

namespace app\models\hronline;

use Yii;
use app\models\myidp\RptStatistikIdpV2;
use app\models\cbelajar\LkkDean;
use app\models\portfolio\TblCartaOrgan;

/**
 * This is the model class for table "hronline.department".
 *
 * @property int $id
 * @property string $fullname
 * @property string $shortname
 * @property string $chief
 * @property string $mymohesCd
 * @property int $category_id
 * @property string $pp
 * @property string $bos
 * @property int $isActive 1=Aktif, 0=Tidak Aktif
 * @property string $idMM
 * @property int $cluster 1=science, 2=non-science
 * @property int $dept_cat_id rujuk dept_cat | added by miji 1/9/2015
 * @property int $sub_of Kod JFPIU Utama
 * @property string $address Alamat
 * @property string $fax_no No.Faks
 * @property string $tel_no No.Telefon
 * @property string $pa_email Emel PA
 */
class Department extends \yii\db\ActiveRecord {

    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hronline.department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['category_id', 'isActive', 'cluster', 'dept_cat_id', 'sub_of'], 'integer'],
            [['address'], 'string'],
            [['fullname'], 'string', 'max' => 300],
            [['shortname', 'chief'], 'string', 'max' => 60],
            [['mymohesCd'], 'string', 'max' => 4],
            [['pp', 'bos'], 'string', 'max' => 12],
            [['idMM'], 'string', 'max' => 20],
            [['fax_no', 'tel_no', 'pa_email'], 'string', 'max' => 50],
            [['chief', 'address', 'fax_no', 'tel_no', 'pa_email'], 'required', 'on' => 'update_department_info', 'message' => 'Ruang ini adalah mandatori'],
            [['fullname', 'shortname', 'chief', 'pp', 'address', 'fax_no', 'tel_no', 'pa_email', 'dept_cat_id', 'isActive', 'cluster'], 'required', 'on' => 'tk_jabatan', 'message' => 'Ruang ini adalah mandatori'],
            [['uc_no'], 'string', 'max' => 10],
            [['pa_email'], 'email', 'message'=>'Sila pastikan email adalah sah'],
            [['website'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'fullname' => 'JFPIU',
            'shortname' => 'JFPIU',
            'chief' => 'Chief',
            'mymohesCd' => 'Mymohes Cd',
            'category_id' => 'Category ID',
            'pp' => 'Pp',
            'bos' => 'Bos',
            'isActive' => 'Is Active',
            'idMM' => 'Id Mm',
            'cluster' => 'Cluster',
            'dept_cat_id' => 'Dept Cat ID',
            'sub_of' => 'Sub Of',
            'address' => 'Address',
            'fax_no' => 'Fax No',
            'tel_no' => 'Tel No',
            'uc_no' => 'UC No',
            'pa_email' => 'Pa Email',
            'website' => 'Laman Web',
        ];
    }

    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['DeptId' => 'id']);
    }

    public function getChiefBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'chief']);
    }

    public function getppBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pp']);
    }

    public function getK_jabatan() {
        if ($this->chief !== NULL) {
            return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'chief']);
        } else {
            return '<span class="label label-warning">Not Set</span>';
        }
    }

    public function getP_pendaftar() {

        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pp']);
    }

    public function getActive() {
        if ($this->isActive == 1) {
            return '<span ">Aktif</span>';
        } else {
            return '<span ">Tidak Aktif</span>';
        }
    }

    public function getDeptCat() {

        return $this->hasOne(DeptCat::className(), ['id' => 'dept_cat_id']);
    }

    public function getDeptSub() {

        return $this->hasOne(Department::className(), ['id' => 'sub_of']);
    }

    public function countStaffDept($kumpulan, $category) {

        $count = 0;

        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->where(['DeptId' => $kumpulan])
                    ->andWhere(['Status' => '1'])
                    ->count();
        } elseif ($category == 1) { //akademik
            $count = RptStatistikIdpV2::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['cpd_group' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1'])
                    ->count();
        } elseif ($category == 2) { //pentadbiran
            $count = RptStatistikIdpV2::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['cpd_group' => $kumpulan, 'job_category' => 2])
                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1'])
                    ->count();
        }


        return $count;
    }
// PORTFOLIO
     public function countAllStaff($kumpulan, $category) {

        $count = 0;

        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->where(['DeptId' => $kumpulan])
                    ->andWhere(['Status' => '1'])
                    ->count();
        } 


        return $count;
    }
    // CUTI BELAJAR  
    public function countStaffDeptCb($kumpulan, $category) {

        $count = 0;
        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1])->all();
        foreach ($pengajian as $p) {
            $ICNO[] = $p->icno;
        }
        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['DeptId' => $kumpulan, 'job_category' => 1])
//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
                    ->count();
        } elseif ($category == 1) { //pentadbiran
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['DeptId' => $kumpulan, 'job_category' => 2])
//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
                    ->count();
        }

        return $count;
    }

    public function countAllStaffDeptCb($category) {

        $count = 0;
        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1])->all();
        foreach ($pengajian as $p) {
            $ICNO[] = $p->icno;
        }
        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere([ 'job_category' => 1])
//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
                    ->count();
        }
        if ($category == 1) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere([ 'job_category' => 2])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->count();
        }


        return $count;
    }

    public function countProposalDefense($kumpulan, $category) {

        $count = 0;
        $lkk = \app\models\cbelajar\TblLkk::find()->joinWith('got')
                        ->where(['cb_tbl_dean.result' => 1])->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])->all();

        foreach ($lkk as $l) {
            $i[] = $l->got->icno;
        }

        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1, 'HighestEduLevelCd' => [1, 200, 201, 20]])->all();
        foreach ($pengajian as $p) {
            $ICNO[] = $p->icno;
        }
       $mod = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1, 'modeID' => [1,2,4]])->all();
 foreach ($mod as $p) {
            $ICNO[] = $mod->icno;
        }
        
        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
//                    ->joinWith('lkp.got')
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['in', "tblprcobiodata.ICNO", $i])
                    ->andWhere(['DeptId' => $kumpulan, 'job_category' => 1])

//                    ->andWhere(['cb_tbl_dean.result' => 1])
//                    ->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])
//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
//                    ->andWhere(['<>','cb_tbl_pengajian.HighestEduLevelCd','202',])
                    ->groupBy('icno')
                    ->count();
        }
        return $count;
    }

    public function countAllPd($category) {

        $count = 0;
        $lkk = \app\models\cbelajar\TblLkk::find()->joinWith('got')
                        ->where(['cb_tbl_dean.result' => 1])->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])->all();

        foreach ($lkk as $l) {
            $i[] = $l->got->icno;
        }

        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1, 'modeID' => [1,2,4]])->all();
        foreach ($pengajian as $p) {
            $ICNO[] = $p->icno;
        }
        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
//                    ->joinWith('pengajianLulus')
//                    ->joinWith('lkp.got')
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['in', "tblprcobiodata.ICNO", $i])
                    ->andWhere([ 'job_category' => 1])
//                    ->andWhere(['cb_tbl_dean.result' => 1])
//                    ->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])
//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
//                    ->andWhere(['<>','cb_tbl_pengajian.HighestEduLevelCd','202',])
//                    ->groupBy('cb_tbl_dean.icno')
                    ->count();
        }
        return $count;
    }

//    public function countSabatikal($kumpulan, $category) {
//
//        $count = 0;
//
//        if ($category == 0) { //keseluruhan
//            $count = Tblprcobiodata::find()
//                    ->joinWith('pengajianLulus')
//                    ->joinWith('jawatan')
//                    ->where(['DeptId' => $kumpulan, 'job_category' => 1])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 99])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
//                    ->count();
//        }
//        return $count;
//    }
    public function countSabatikal($kumpulan, $category) {

        $count = 0;

        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1,
                ])->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 99])->all();
        if ($pengajian) {
            foreach ($pengajian as $p) {
                $ICNO[] = $p->icno;
            }
        } else {
            return '0';
        }
        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['DeptId' => $kumpulan, 'job_category' => 1])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 210])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
                    ->count();
        } elseif ($category == 1) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere([ 'job_category' => 1])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 210])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
                    ->count();
        }
        return $count;
    }

    public function countPhd($kumpulan, $category) {

        $count = 0;
        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1, 'HighestEduLevelCd' => [1]])->all();
        if ($pengajian) {
            foreach ($pengajian as $p) {
                $ICNO[] = $p->icno;
            }
        } else {
            return '0';
        }
        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
//                    ->joinWith('pengajianLulus')
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['DeptId' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->count();
        } elseif ($category == 1) { //admin by
            $count = Tblprcobiodata::find()
//                    ->joinWith('pengajianLulus')
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['DeptId' => $kumpulan, 'job_category' => 2])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->count();
        } elseif ($category == 2) { //keseluruhan
            $count = Tblprcobiodata::find()
//                    ->joinWith('pengajianLulus')
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->count();
        } elseif ($category == 3) { //admin
            $count = Tblprcobiodata::find()
//                    ->joinWith('pengajianLulus')
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['job_category' => 2])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->count();
        }
        return $count;
    }

    public function countAllPhd($category) {

        $count = 0;
        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1, 'HighestEduLevelCd' => [1]])->all();
        if ($pengajian) {
            foreach ($pengajian as $p) {
                $ICNO[] = $p->icno;
            }
        } else {
            return '0';
        }
        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
//                    ->joinWith('pengajianLulus')
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere([ 'job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->count();
        }
        return $count;
    }

    public function countPos($kumpulan, $category) {

        $count = 0;
        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1, 'HighestEduLevelCd' => [200]])->all();
        foreach ($pengajian as $p) {
            $ICNO[] = $p->icno;
        }
        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['=', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['DeptId' => $kumpulan, 'job_category' => 1])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 200])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
                    ->count();
        } elseif ($category == 2) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['=', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['job_category' => 1])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 200])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
                    ->count();
        }
        return $count;
    }

    public function countBasik($kumpulan, $category) {

        $count = 0;
        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1, 'HighestEduLevelCd' => [201]])->all();
        if ($pengajian) {
            foreach ($pengajian as $p) {
                $ICNO[] = $p->icno;
            }
        } else {
            return '0';
        }
        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['DeptId' => $kumpulan, 'job_category' => 1])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 201])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
                    ->count();
        } elseif ($category == 1) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['DeptId' => $kumpulan, 'job_category' => 2])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 201])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
                    ->count();
        } elseif ($category == 4) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere([ 'job_category' => 1])
                                        ->andWhere(['tblprcobiodata.Status' => [1,2]])


//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 201])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
                    ->count();
        } elseif ($category == 3) { //admin
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere([ 'job_category' => 2])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])

//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 201])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
                    ->count();
        }
        return $count;
    }

    public function countIndustri($kumpulan, $category) {

        $count = 0;

        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1,
                ])->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 210])->all();
        if ($pengajian) {
            foreach ($pengajian as $p) {
                $ICNO[] = $p->icno;
            }
        } else {
            return '0';
        }
        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['DeptId' => $kumpulan, 'job_category' => 1])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 210])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
                    ->count();
        } elseif ($category == 1) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere([ 'job_category' => 1])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 210])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
                    ->count();
        }
        return $count;
    }

    public function countKepakaran($kumpulan = null, $category) {

        $count = 0;

        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1,
                ])->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 202])->all();
        if ($pengajian) {
            foreach ($pengajian as $p) {
                $ICNO[] = $p->icno;
            }
        } else {
            return '0';
        }
        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['DeptId' => $kumpulan, 'job_category' => 1])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 210])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
                    ->count();
        } elseif ($category == 2) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere([ 'job_category' => 1])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 210])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
                    ->count();
        }
        return $count;
    }

//    public function countKepakaran($kumpulan, $category) {
//
//        $count = 0;
//
//        if ($category == 0) { //keseluruhan
//            $count = Tblprcobiodata::find()
//                    ->joinWith('pengajianLulus')
//                    ->joinWith('jawatan')
//                    ->where(['DeptId' => $kumpulan, 'job_category' => 1])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 202])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
//                    ->count();
//        }
//        return $count;
//    }
//    public function countSarjana($kumpulan, $category) {
//
//        $count = 0;
//
//        if ($category == 0) { //keseluruhan
//            $count = Tblprcobiodata::find()
//                    ->joinWith('pengajianLulus')
//                    ->joinWith('jawatan')
//                    ->where(['DeptId' => $kumpulan, 'job_category' => 1])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 20])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
//                    ->count();
//        }
//        return $count;
//    }
    public function countSarjana($kumpulan, $category) {

        $count = 0;

        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1,
                ])->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 20])->all();
        if ($pengajian) {
            foreach ($pengajian as $p) {
                $ICNO[] = $p->icno;
            }
        } else {
            return '0';
        }
        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['DeptId' => $kumpulan, 'job_category' => 1])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 210])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
                    ->count();
        } elseif ($category == 1) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['DeptId' => $kumpulan, 'job_category' => 2])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 210])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
                    ->count();
        } elseif ($category == 2) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere([ 'job_category' => 1])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 210])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
                    ->count();
        } elseif ($category == 3) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere([ 'job_category' => 2])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 210])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
                    ->count();
        }
        return $count;
    }

    public function countSarjanamuda($kumpulan, $category) {

        $count = 0;

        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1,
                ])->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 8])->all();
        if ($pengajian) {
            foreach ($pengajian as $p) {
                $ICNO[] = $p->icno;
            }
        } else {
            return '0';
        }
        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['DeptId' => $kumpulan, 'job_category' => 2])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 210])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
                    ->count();
        } elseif ($category == 3) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere([ 'job_category' => 2])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 210])
                    ->andWhere(['tblprcobiodata.Status' => 1])
                    ->count();
        }
        return $count;
    }

    public function countDiploma($kumpulan, $category) {

        $count = 0;

        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1,
                ])->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 11])->all();
        if ($pengajian) {
            foreach ($pengajian as $p) {
                $ICNO[] = $p->icno;
            }
        } else {
            return '0';
        }
        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['DeptId' => $kumpulan, 'job_category' => 2])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 210])
//                    ->andWhere(['cb_tbl_pengajian.status' => 1])
                    ->count();
        } elseif ($category == 3) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere([ 'job_category' => 2])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 210])
                    ->andWhere(['tblprcobiodata.Status' => 1])
                    ->count();
        }
        return $count;
    }

    public function countNoProposalDefense($kumpulan, $category) {

        $count = 0;
        $lkk = \app\models\cbelajar\TblLkk::find()->joinWith('got')
                        ->where(['cb_tbl_dean.result' => 2, 'cb_tbl_lkk.semester' => 4])->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])->all();

        foreach ($lkk as $l) {
            $i[] = $l->got->icno;
        }

        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1, 'HighestEduLevelCd' => [1, 200, 201, 20, 202]])->all();
        foreach ($pengajian as $p) {
            $ICNO[] = $p->icno;
        }
        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
//                    ->joinWith('pengajian')
//                    ->joinWith('lkp.got')
                    ->joinWith('jawatan')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['in', "tblprcobiodata.ICNO", $i])
                    ->andWhere(['DeptId' => $kumpulan, 'job_category' => 1])

//                    ->andWhere(['cb_tbl_dean.result' => 1])
//                    ->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])
//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
//                    ->andWhere(['<>','cb_tbl_pengajian.HighestEduLevelCd','202',])
//                    ->groupBy('cb_tbl_dean.icno')
                    ->count();
        }
        return $count;
    }

    public function countNoDefense($category) {

        $count = 0;
        $lkk = \app\models\cbelajar\TblLkk::find()->joinWith('got')
                        ->where(['cb_tbl_dean.result' => 2, 'cb_tbl_lkk.semester' => 4])->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])->all();

        foreach ($lkk as $l) {
            $i[] = $l->got->icno;
        }
  $pd = LkkDean::find()->select('icno')->where(['result'=>1,'dokumen'=>[58,16]])->asArray()->all();
        $icno_array = [];
        foreach($pd as $pd){
            array_push($icno_array,$pd['icno']);
        }
        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1, 'modeID' => [1, 2,4]])->all();
        foreach ($pengajian as $p) {
            $ICNO[] = $p->icno;
        }
        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
//                    ->joinWith('pengajianLulus')
//                    ->joinWith('lkp.got')
                    ->joinWith('jawatan')
//                      ->joinWith('lkp')
//                    ->joinWith('pengajian')

//                    ->joinWith('lkp.got')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['in', "tblprcobiodata.ICNO", $i])
                    
                    ->andWhere([ 'job_category' => 1])
//                     ->andWhere(['cb_tbl_pengajian.status' => [1]])
//                    ->andWhere(['cb_tbl_pengajian.modeID' => [1,2,4]])
//                    ->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])
//                    ->andWhere([ 'cb_tbl_lkk.semester' => [2, 3, 4]])
//                    ->andWhere(['NOT IN','cb_tbl_dean.icno',$icno_array])

//                    ->andWhere(['cb_tbl_dean.result' => 1])
//                    ->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])
//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
//                    ->andWhere(['<>','cb_tbl_pengajian.HighestEduLevelCd','202',])
//                    ->groupBy($icno_array)
                    ->count();
        }
        return $count;
    }

//    public function countNoProposalDefense($kumpulan, $category) {
//
//        $count = 0;
//
//        if ($category == 0) { //keseluruhan
//            $count = Tblprcobiodata::find()
//                    ->joinWith('pengajianLulus')
//                    ->joinWith('lkp.got')
//                    ->joinWith('jawatan')
//                    ->where(['DeptId' => $kumpulan, 'job_category' => 1])
//                    ->andWhere(['cb_tbl_dean.result' => 2])
//                    ->andWhere(['cb_tbl_lkk.semester' => 4])
//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
//                    ->andWhere(['<>', 'cb_tbl_pengajian.HighestEduLevelCd', '202'])
//                    ->groupBy('cb_tbl_dean.icno')
//                    ->count();
//        }
//        return $count;
//    }

    public function countNoPD($kumpulan, $category) {

        $count = 0;

        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('pengajianLulus')
                    ->joinWith('lkp.got')
                    ->joinWith('jawatan')
                    ->where(['DeptId' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['cb_tbl_dean.result' => 2])
//                    ->andWhere(['<>','cb_tbl_lkk.status',"MANUAL"])
                    ->andWhere(['is', 'cb_tbl_lkk.status', null])
                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
                    ->andWhere(['<>', 'cb_tbl_pengajian.HighestEduLevelCd', '202'])
                    ->groupBy('cb_tbl_dean.icno')
                    ->count();
        }
        return $count;
    }

    public function countLulusKerjaKursus($kumpulan, $category) {

        $count = 0;

        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('pengajianLulus')
                    ->joinWith('lkp')
                    ->joinWith('jawatan')
                    ->where(['DeptId' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
                    ->andWhere(['cb_tbl_lkk.cw_gpa' => 'PASS'])
                    ->groupBy('cb_tbl_lkk.icno')
                    ->count();
        }
        return $count;
    }

    public function countStaffDeptLayak($kumpulan, $category, $year) {

        $count = 0;

        if ($category == 0) { //keseluruhan
            $count = RptStatistikIdpV2::find()
                    ->joinWith('biodata')
                    ->where(['DeptId' => $kumpulan])
                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $year])
                    ->count();
        } elseif ($category == 1) { //akademik
            $count = RptStatistikIdpV2::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['cpd_group' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $year])
                    ->count();
        } elseif ($category == 2) { //pentadbiran
            $count = RptStatistikIdpV2::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['cpd_group' => $kumpulan, 'job_category' => 2])
                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $year])
                    ->count();
        }

        return $count;
    }

    public function countStaffDeptXlayak($kumpulan, $category) {

        $count = 0;

        if ($category == 0) { //keseluruhan
            $count = Department::countStaffDept($kumpulan, $category) - Department::countStaffDeptLayak($kumpulan, $category);
        } elseif ($category == 1) { //akademik
            $count = RptStatistikIdpV2::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['cpd_group' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1'])
                    ->count();
        } elseif ($category == 2) { //pentadbiran
            $count = RptStatistikIdpV2::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['cpd_group' => $kumpulan, 'job_category' => 2])
                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1'])
                    ->count();
        }

        return $count;
    }

    // statistik

    public function countStaffUms($category) {
        $count = 0;
        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['<>', 'tblprcobiodata.Status', '6'])
                    ->groupBy('ICNO')
                    ->count();
        } elseif ($category == 1) { //akademik
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where([ 'job_category' => 1])
                    ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                    ->count();
        } elseif ($category == 2) { //pentadbiran
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where([ 'job_category' => 2])
                    ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                    ->count();
        }
        elseif ($category == 3) { //kk
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->joinWith('kampus')
                    ->andWhere(['<>', 'tblprcobiodata.Status', '6,2,4,5,3'])
                    ->andWhere(['campus.campus_id'=>1])
                    ->count();
        }
         elseif ($category == 4) { //fpl
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->joinWith('kampus')
                    ->andWhere(['<>', 'tblprcobiodata.Status', '6,2,4,5,3'])
                    ->andWhere(['campus.campus_id'=>3])
                    ->count();
        }
        elseif ($category == 5) { //lbu
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->joinWith('kampus')
                    ->andWhere(['<>', 'tblprcobiodata.Status', '6,2,4,5,3'])
                    ->andWhere(['campus.campus_id'=>2])
                    ->count();
        }
        elseif ($category == 6) { //kudat
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->joinWith('kampus')
                    ->andWhere(['<>', 'tblprcobiodata.Status', '6,2,4,5,3'])
                    ->andWhere(['campus.campus_id'=>4])
                    ->count();
        }

        return $count;
    }
    
    public function countStaffKampus($category) {
        $count = 0;
       
   if ($category == 3) { //kk
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->joinWith('kampus')
                    ->andWhere(['<>', 'tblprcobiodata.Status', '6,2,4,5,3'])
                    ->andWhere(['campus.campus_id'=>1])
                    ->count();
        }
         elseif ($category == 7) { //kk cb
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->joinWith('kampus')
                    ->andWhere(['<>', 'tblprcobiodata.Status', '6,2,4,5,3'])
                    ->andWhere(['tblprcobiodata.Status' => 2])
                    ->andWhere(['campus.campus_id'=>1])
                    ->count();
        }
         elseif ($category == 4) { //fpl
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->joinWith('kampus')
                    ->andWhere(['<>', 'tblprcobiodata.Status', '6,2,4,5,3'])
                    ->andWhere(['campus.campus_id'=>3])
                    ->count();
        }
        elseif ($category == 8) { //fpl cb
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->joinWith('kampus')
                    ->andWhere(['<>', 'tblprcobiodata.Status', '6,2,4,5,3'])
                    ->andWhere(['tblprcobiodata.Status' => 2])
                    ->andWhere(['campus.campus_id'=>3])
                    ->count();
        }
        elseif ($category == 5) { //lbu
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->joinWith('kampus')
                    ->andWhere(['<>', 'tblprcobiodata.Status', '6,2,4,5,3'])
                    ->andWhere(['campus.campus_id'=>2])
                    ->count();
        }
        elseif ($category == 9) { //lbu cb
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->joinWith('kampus')
                    ->andWhere(['<>', 'tblprcobiodata.Status', '6,2,4,5,3'])
                    ->andWhere(['tblprcobiodata.Status' => 2])
                    ->andWhere(['campus.campus_id'=>2])
                    ->count();
        }
        elseif ($category == 6) { //kudat
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->joinWith('kampus')
                    ->andWhere(['<>', 'tblprcobiodata.Status', '6,2,4,5,3'])
                    ->andWhere(['campus.campus_id'=>4])
                    ->count();
        }
        elseif ($category == 10) { //kudat cb
            $count = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->joinWith('kampus')
                    ->andWhere(['<>', 'tblprcobiodata.Status', '6,2,4,5,3'])
                    ->andWhere(['tblprcobiodata.Status' => 2])
                    ->andWhere(['campus.campus_id'=>4])
                    ->count();
        }

        return $count;
    }
    public static function campus($id, $date, $jfpib) {
        $biodata = $jfpib? Tblprcobiodata::find()->where(['DeptId' => $jfpib, 'Status' => 1, 'Campus_id' => $id]) : Tblprcobiodata::find()->where(['Status' => 1, 'Campus_id' => $id]);
        
        return TblSelfhealth::find()->where(['like', 'date', date_format(date_create($date), 'Y-m-d')])->andWhere(['icno' => $biodata->select(['ICNO'])])->all();
    }
    
    public static function totalWfh($date, $campus, $jfpiu) {
        $staff = $campus? Tblprcobiodata::find()->where(['Status'=>1, 'campus_id' => $campus]): Tblprcobiodata::find()->where(['Status'=>1]);  
        $staff = $jfpiu? $staff->andWhere(['DeptId' => $jfpiu]): $staff; 
        
        $count = TblWfh::find()->where(['start_date' => $date])->andWhere(['icno' => $staff->select(['ICNO']), 'status' => 'APPROVED'])->count(); 
   
        return $count;
    }
    
         public function getAdmin() {
        return $this->hasOne(Tblrscoadminpost::className(), ['ICNO' => 'chief']);
    }

    //log for Create, update or delete data.
    // public function beforeSave1($insert)
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $changes = [];
        $tempObj = self::findOne(['id' => $this->id]);
        $attrib = $this->activeAttributes();

        switch ($insert) {
            case (false):
                $activity = 1;
                for ($i = 0; $i < count($attrib); $i++) {

                    if ($tempObj->{$attrib[$i]} != $this->{$attrib[$i]}) {
                        array_push($changes, [$attrib[$i], $tempObj->{$attrib[$i]}, $this->{$attrib[$i]}]);
                    }
                }
                break;

            default:
                //aftersave will handle it
                break;
        }
        if (count($changes) > 0) {
            //log activity to updatestatus table
            $log = new LogActivity();
            $log->usern = yii::$app->controller->id; //Yii::$app->user->getId();
            $log->COTableName = $this->tableName();
            $log->COActivity = $activity;
            $log->COUpadteDate = date('Y-m-d H:i:s');
            if (Yii::$app->user->getId()) {
                $log->COUpdateIP = Yii::$app->request->getRemoteIP();
                $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            } else {
                $log->COUpdateIP = yii::$app->controller->id;
                $log->COUpdateComp = yii::$app->controller->id;
            }
            $log->COUpdateCompUser = Yii::$app->user->getId() ? Yii::$app->user->getId() : yii::$app->controller->id;
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);

        }

        return true;
    }

    // public function afterSave1($insert, $changedAttributes)
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {

            $changes = [];
            //$tempObj = self::findOne(['id' => $this->id]);
            $attrib = $this->activeAttributes();
            $activity = 0;

            for ($i = 0; $i < count($attrib); $i++) {
                array_push($changes, [$attrib[$i], $this->{$attrib[$i]}]);
            }

            $log = new LogActivity();
            $log->usern = yii::$app->controller->id; //Yii::$app->user->getId();
            $log->COTableName = $this->tableName();
            $log->COActivity = $activity;
            $log->COUpadteDate = date('Y-m-d H:i:s');
            if (Yii::$app->user->getId()) {
                $log->COUpdateIP = Yii::$app->request->getRemoteIP();
                $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            } else {
                $log->COUpdateIP = yii::$app->controller->id;
                $log->COUpdateComp = yii::$app->controller->id;
            }
            $log->COUpdateCompUser = Yii::$app->user->getId() ? Yii::$app->user->getId() : yii::$app->controller->id;
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);
            
        }

        return true;
    }

    // public function beforeDelete1()
    public function beforeDelete() {
        if (!parent::beforeDelete()) {
            return false;
        }

        $changes = [];

        //get list of attributes
        $attrib = $this->activeAttributes();

        for ($i = 0; $i < count($attrib); $i++) {
            array_push($changes, array($attrib[$i], $this->{$attrib[$i]}));
        }
        //log activity to updatestatus table
        $log = new LogActivity();
        $log->usern = yii::$app->controller->id;
        $log->COTableName = $this->tableName();
        $log->COActivity = 2;
        $log->COUpadteDate = date('Y-m-d H:i:s');
        if (Yii::$app->user->getId()) {
            $log->COUpdateIP = Yii::$app->request->getRemoteIP();
            $log->COUpdateComp = Yii::$app->request->getRemoteIP();
        } else {
            $log->COUpdateIP = yii::$app->controller->id;
            $log->COUpdateComp = yii::$app->controller->id;
        }
        $log->COUpdateCompUser = Yii::$app->user->getId() ? Yii::$app->user->getId() : yii::$app->controller->id;
        $log->COUpdateSQL = serialize($changes);
        $log->idval = $this->id;
        $log->save(false);

        return true;
    }
    
    
      public function getCartaOrgan() {
        return $this->hasOne(\app\models\portfolio\TblCartaOrgan::className(), ['dept_id' => 'id']);
    }
    
      public function checkUpload($id){
        $model = TblCartaOrgan::findOne(['dept_id' => $id]); 
        
        return $model;
    } 

    


}
