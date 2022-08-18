<?php

namespace app\models\cv;

use app\models\cv\GredJawatan;
use Yii;

class TblPermohonan extends \yii\db\ActiveRecord {

    public $status_pakar;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hrm.cv_tbl_permohonan';
    }

    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['kj_datetime', 'submit_datetime', 'admin_datetime', 'status_pakar', 'status_kepakaran'], 'safe'],
            [['gred_hakiki', 'dept_hakiki', 'kj_status', 'admin_status', 'ads_id', 'current_gred', 'current_dept', 'status_id', 'isActive'], 'integer'],
            [['ICNO'], 'string', 'max' => 20],
            [['kj_ICNO', 'admin_ICNO'], 'string', 'max' => 12],
            [['kj_ulasan'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ICNO' => 'ICNO',
            'kj_ICNO' => 'Kj Icno',
            'kj_datetime' => 'Kj Datetime',
            'kj_status' => 'Kj Status',
            'kj_ulasan' => 'Kj Ulasan',
            'submit_datetime' => 'Submit Datetime',
            'ads_id' => 'Gred Apply',
            'current_gred' => 'Current Gred',
            'current_dept' => 'Current Dept',
            'status_id' => 'Status ID',
            'isActive' => 'Is Active',
        ];
    }

    public function getAppInfo() {
        return $this->hasOne(\app\models\cv\TblAppinfo::className(), ['ICNO' => 'ICNO']);
    }

    public function getSetpegawai() {
        return $this->hasOne(\app\models\cuti\SetPegawai::className(), ['pemohon_icno' => 'ICNO'])->where(['pelulus_icno' => Yii::$app->user->getId()]);
    }

    public function getUser() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }

    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }

    public function getBiodataBsm() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'admin_ICNO']);
    }

    public function getBiodataChief() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'kj_ICNO']);
    }

    public function getDepartment() {
        return $this->hasOne(\app\models\hronline\Department::className(), ['id' => 'current_dept']);
    }

    public function getDepartmentChief() {
        return $this->hasOne(\app\models\hronline\Department::className(), ['chief' => 'ICNO']);
    }

    public static function findJawatan($id) {
        $jawatan = GredJawatan::findOne(['id' => $id]);
        return $jawatan->fname;
    }

    public function getKepakaranStatus() {
        if (!empty($this->status_kepakaran)) {
            if ($this->status_kepakaran == 1) {
                return '<br/><span class="label label-info">PAKAR</span>';
            } else {
                return '<br/><span class="label label-warning">BUKAN PAKAR</span>';
            }
        }
    }

    public function getJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'ads_id']);
    }

    public function getOldJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'current_gred']);
    }

    public function getAds() {
        return $this->hasOne(TblAds::className(), ['id' => 'ads_id']);
    }

    public function isChief($ICNO) {
        return \app\models\hronline\Department::findOne(['chief' => $ICNO]);
    }

    public static function isAdminAcademic() {
        return TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['access' => 2])->exists();
    }

    public static function isAdminPentadbiran() {
        return TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['access' => 5])->exists();
    }

    public function checkJd($icno) {
        return \app\models\myportfolio\TblPortfolio::find()->where(['icno' => $icno])->andWhere(['status_hantar' => 1])->one();
    }

    public static function KjView($id) {
        $academic = TblPermohonan::find()
                        ->where(['IN', 'cv_tbl_permohonan.kj_status', $id])
                        ->joinWith('biodata.departmentHakiki')
                        ->joinWith('biodata.jawatan')
                        ->andWhere(['gredjawatan.job_category' => 1])
                        ->andWhere(['department.chief' => Yii::$app->user->getId()])
                        ->andWhere(['cv_tbl_permohonan.isActive' => 1])
                        ->andWhere(['!=', 'tblprcobiodata.ICNO', Yii::$app->user->getId()])->all();
        $admin = TblPermohonan::find()
                        ->where(['IN', 'cv_tbl_permohonan.kj_status', $id])
                        ->joinWith('biodata.jawatan')
                        ->andWhere(['gredjawatan.job_category' => 2])
                        ->andWhere(['cv_tbl_permohonan.kj_ICNO' => Yii::$app->user->getId()])
                        ->andWhere(['cv_tbl_permohonan.isActive' => 1])
                        ->andWhere(['!=', 'tblprcobiodata.ICNO', Yii::$app->user->getId()])->all();

        $candidate = array();
        $n = 0;
        foreach ($academic as $model) {
            $candidate[] = $model->ICNO;
            $n++;
        }
        $j = count($candidate);
        foreach ($admin as $model) {
            $candidate[] = $model->ICNO;
            $j++;
        }

        return TblPermohonan::find()
                        ->where(['IN', 'cv_tbl_permohonan.kj_status', $id])
                        ->andWhere(['IN', 'cv_tbl_permohonan.ICNO', $candidate])
                        ->andWhere(['cv_tbl_permohonan.isActive' => 1])
                        ->joinWith('biodata.jawatan')
                        ->andWhere(['!=', 'tblprcobiodata.ICNO', Yii::$app->user->getId()])
                        ->orderBy(['gredjawatan.job_category' => SORT_ASC]);
    }

    public function OfficerView($id) {

        return TblPermohonan::find()
                        ->where(['IN', 'cv_tbl_permohonan.kj_status', $id])
                        ->joinWith('biodata.jawatan')
                        ->andWhere(['gredjawatan.job_category' => 2])
                        ->andWhere(['cv_tbl_permohonan.kj_ICNO' => Yii::$app->user->getId()])
                        ->andWhere(['cv_tbl_permohonan.isActive' => 1])
                        ->andWhere(['!=', 'tblprcobiodata.ICNO', Yii::$app->user->getId()]);
    }

    public static function DeanView($id) {

        $model = \app\models\hronline\Tblprcobiodata::find()->joinWith('chiefDepartment')->where(['Status' => 1])->all();

        $chief = array();
        $i = 0;
        foreach ($model as $model) {
            if ($model->DeptId == $model->DeptId_hakiki) {
                $chief[] = $model->ICNO;
                $i++;
            }
        }
        $academic = TblPermohonan::find()
                        ->joinWith('biodata.jawatan')
                        ->where(['gredjawatan.job_category' => 1])
                        ->andWhere(['IN', 'cv_tbl_permohonan.kj_status', $id])
                        ->andWhere(['IN', 'cv_tbl_permohonan.ICNO', $chief])
                        ->andWhere(['cv_tbl_permohonan.isActive' => 1])
                        ->andWhere(['!=', 'cv_tbl_permohonan.ICNO', Yii::$app->user->getId()])->all();

        $admin = TblPermohonan::find()
                        ->joinWith('biodata.jawatan')
                        ->where(['gredjawatan.job_category' => 2])
                        ->andWhere(['IN', 'cv_tbl_permohonan.kj_status', $id])
                        ->andWhere(['cv_tbl_permohonan.isActive' => 1])
                        ->andWhere(['cv_tbl_permohonan.kj_ICNO' => Yii::$app->user->getId()])
                        ->andWhere(['!=', 'cv_tbl_permohonan.ICNO', Yii::$app->user->getId()])->all();

        $candidate = array();
        $n = 0;
        if ($academic) {
            foreach ($academic as $model) {
                $candidate[] = $model->ICNO;
                $n++;
            }
        }

        $j = count($candidate);
        if ($admin) {
            foreach ($admin as $model) {
                $candidate[] = $model->ICNO;
                $j++;
            }
        }

        return TblPermohonan::find()
                        ->where(['IN', 'cv_tbl_permohonan.kj_status', $id])
                        ->andWhere(['IN', 'cv_tbl_permohonan.ICNO', $candidate])
                        ->andWhere(['cv_tbl_permohonan.isActive' => 1])
                        ->joinWith('biodata.jawatan')
                        ->andWhere(['!=', 'tblprcobiodata.ICNO', Yii::$app->user->getId()])
                        ->orderBy(['gredjawatan.job_category' => SORT_ASC]);
    }

    public static function KjVerified($id, $status) {
        return TblPermohonan::find()
                        ->where(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['is not', 'cv_tbl_permohonan.kj_datetime', null])
                        ->andWhere(['cv_tbl_permohonan.kj_status' => $status])
                        ->orderBy(['admin_status' => SORT_ASC]);
    }

    public static function DataSaringan($id, $status) {
        return TblPermohonan::find()
                        ->where(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['is not', 'cv_tbl_permohonan.kj_datetime', null])
                        ->andWhere(['cv_tbl_permohonan.kj_status' => $status])
                        ->andWhere(['NOT IN', 'cv_tbl_permohonan.admin_status', [2, 3]])
                        ->orderBy(['admin_status' => SORT_ASC]);
    }

    public static function AdminView($status, $id, $kj) {
        return TblPermohonan::find()
                ->joinWith('biodata')
                        ->where(['cv_tbl_permohonan.status_id' => $status])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['cv_tbl_permohonan.kj_status' => $kj])
                        ->andWhere(['is', 'cv_tbl_permohonan.admin_ICNO', null])
                 ->andWhere(['=', 'tblprcobiodata.statLantikan', 1]);;
    }
    
    public static function AdminViewContract($status, $id, $kj) {
        return TblPermohonan::find()
                ->joinWith('biodata')
                        ->where(['cv_tbl_permohonan.status_id' => $status])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['cv_tbl_permohonan.kj_status' => $kj])
                        ->andWhere(['is', 'cv_tbl_permohonan.admin_ICNO', null])
                 ->andWhere(['!=', 'tblprcobiodata.statLantikan', 1]);;
    }

    public static function AdminViewWait($status, $id) {
        return TblPermohonan::find()
                ->joinWith('biodata')
                        ->where(['cv_tbl_permohonan.status_id' => $status])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['is', 'cv_tbl_permohonan.admin_ICNO', null])
                ->andWhere(['=', 'tblprcobiodata.statLantikan', 1]);
    }
    
    public static function AdminViewWaitContract($status, $id) {
        return TblPermohonan::find()
                ->joinWith('biodata')
                        ->where(['cv_tbl_permohonan.status_id' => $status])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['is', 'cv_tbl_permohonan.admin_ICNO', null])
                ->andWhere(['!=', 'tblprcobiodata.statLantikan', 1]);
    }

    public static function AdminViewPass($id) {
        return TblPermohonan::find()->where(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['cv_tbl_permohonan.admin_status' => 1]);
    }

    public static function AdminViewIv($status, $id) {
        return TblPermohonan::find()
                ->joinWith('biodata')
                        ->where(['cv_tbl_permohonan.status_id' => $status])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                ->andWhere(['=', 'tblprcobiodata.statLantikan', 1]);
    }
    
    public static function AdminViewIvContract($status, $id) {
        return TblPermohonan::find()
                ->joinWith('biodata')
                        ->where(['cv_tbl_permohonan.status_id' => $status])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                ->andWhere(['!=', 'tblprcobiodata.statLantikan', 1]);
    }

    public function AdminList($id, $status) {
        return TblPermohonan::find()
                        ->where(['cv_tbl_permohonan.status_id' => 3])
                        ->andWhere(['or',
                            ['cv_tbl_permohonan.admin_status' => $status],
                            ['cv_tbl_permohonan.kj_status' => $status]
                        ])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->leftJoin('hronline.tblprcobiodata', 'cv_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                        ->andWhere(['!=', 'tblprcobiodata.ICNO', Yii::$app->user->getId()]);
    }

    public function getStatusKj($id) {
        $model = TblPermohonan::find()->where(['id' => $id])->one();

        if ($model->kj_status == 1) {
            return '<span class="label label-success">Approved</span>';
        } else if ($model->kj_status == 2) {
            return '<span class="label label-danger">Failed</span>';
        } else {
            return;
        }
    }

    public function getStatusAdminPentadbiran($id) {
        $model = TblPermohonan::find()->where(['id' => $id])->one();

        if ($model->admin_status == 1) {
            return '<span class="label label-info">Offer Iv</span>';
        } else if ($model->admin_status == 2) {
            return '<span class="label label-danger">Failed (Tapisan)</span>';
        } else if ($model->admin_status == 3) {
            return '<span class="label label-danger">Failed (Tapisan)</span>';
        } else {
            return;
        }
    }

    public function getStatusAdmin($id) {
        $model = TblPermohonan::find()->where(['id' => $id])->one();

        if ($model->admin_status == 1) {
            return '<span class="label label-success">Success</span>';
        } else if ($model->admin_status == 2) {
            return '<span class="label label-danger">Failed</span>';
        } else {
            return;
        }
    }

    public function category($id) {

        $cat = GredJawatan::findOne(['id' => $id]);

        if ($cat->svc == 1) {
            return '<span class="label label-warning">Academic</span>';
        } else {
            return '<span class="label label-info">Non-Academic</span>';
        }
    }

    public function svc($current_gred) {
        $cat = GredJawatan::findOne(['id' => $current_gred]);

        return $cat->svc;
    }

    public static function findActiveApplication() {
        return TblPermohonan::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['isActive' => 1])->one();
    }

    public static function findAppAc() {
        return TblPermohonan::find()
                        ->joinWith('jawatan')
                        ->joinWith('biodata')
                        ->where(['cv_gredjawatan.svc' => 1])
                        ->andWhere(['tblprcobiodata.statLantikan' => 1])
                        ->select('cv_tbl_permohonan.ads_id')
                        ->distinct();
    }

    public static function findAppAcContract() {
        return TblPermohonan::find()
                        ->joinWith('jawatan')
                        ->joinWith('biodata')
                        ->where(['cv_gredjawatan.svc' => 1])
                        ->andWhere(['!=', 'tblprcobiodata.statLantikan', 1])
                        ->select('cv_tbl_permohonan.ads_id')
                        ->distinct();
    }

    public static function findAppAcPanel($ads) {
        return TblPermohonan::find()
                        ->joinWith('jawatan')
                        ->where(['cv_gredjawatan.svc' => 1])
                        ->select('cv_tbl_permohonan.ads_id')
                        ->andWhere(['IN', 'cv_tbl_permohonan.ads_id', $ads])//TEMP PANEL VK7/DS52
                        ->distinct();
    }

    public function findAppAcRecord() {
        return TblPermohonan::find()
                        ->joinWith('jawatan')
                        ->where(['cv_gredjawatan.svc' => 1])
                        ->select('cv_tbl_permohonan.ads_id')
                        ->distinct()
                        ->all();
    }

    public function Total($id) {
        return TblPermohonan::find()
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->leftJoin('hronline.tblprcobiodata', 'cv_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
//                        ->andWhere(['!=', 'tblprcobiodata.ICNO', Yii::$app->user->getId()])
                        ->count();
    }

    public function TotalAc($id) {
        return TblPermohonan::find()
                        ->joinWith('biodata')
                        ->where(['NOT IN', 'cv_tbl_permohonan.status_id', [4, 5]])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['=', 'tblprcobiodata.statLantikan', 1])
                        ->count();
    }

    public function TotalAcContract($id) {
        return TblPermohonan::find()
                        ->joinWith('biodata')
                        ->where(['NOT IN', 'cv_tbl_permohonan.status_id', [4, 5]])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['!=', 'tblprcobiodata.statLantikan', 1])
                        ->count();
    }

    public function TotalWaiting($id) {
        return TblPermohonan::find()
                        ->joinWith('biodata')
                        ->where(['cv_tbl_permohonan.status_id' => 1])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['is', 'cv_tbl_permohonan.admin_ICNO', null])
                        ->andWhere(['=', 'tblprcobiodata.statLantikan', 1])
                        ->count();
    }

    public function TotalWaitingContract($id) {
        return TblPermohonan::find()
                        ->joinWith('biodata')
                        ->where(['cv_tbl_permohonan.status_id' => 1])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['is', 'cv_tbl_permohonan.admin_ICNO', null])
                        ->andWhere(['!=', 'tblprcobiodata.statLantikan', 1])
                        ->count();
    }

    public function TotalVerify($status, $id, $peraku) {
        return TblPermohonan::find()
                        ->joinWith('biodata')
                        ->where(['cv_tbl_permohonan.status_id' => $status])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['cv_tbl_permohonan.kj_status' => $peraku])
                        ->andWhere(['is', 'cv_tbl_permohonan.admin_ICNO', null])
                        ->andWhere(['=', 'tblprcobiodata.statLantikan', 1])
                        ->count();
    }

    public function TotalVerifyContract($status, $id, $peraku) {
        return TblPermohonan::find()
                        ->joinWith('biodata')
                        ->where(['cv_tbl_permohonan.status_id' => $status])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['cv_tbl_permohonan.kj_status' => $peraku])
                        ->andWhere(['is', 'cv_tbl_permohonan.admin_ICNO', null])
                        ->andWhere(['!=', 'tblprcobiodata.statLantikan', 1])
                        ->count();
    }

    public function TotalIv($status, $id) {
        return TblPermohonan::find()
                        ->joinWith('biodata')
                        ->where(['cv_tbl_permohonan.status_id' => $status])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['=', 'tblprcobiodata.statLantikan', 1])
                        ->count();
    }

    public function TotalIvContract($status, $id) {
        return TblPermohonan::find()
                        ->joinWith('biodata')
                        ->where(['cv_tbl_permohonan.status_id' => $status])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['!=', 'tblprcobiodata.statLantikan', 1])
                        ->count();
    }

    public static function TotalVerifyKiv($id) {
        return TblCandidateKiv::find()
                        ->where(['jawatan_id' => $id, 'active' => 1])
                        ->count();
    }

    public static function WaitingList($id) {
        return TblPermohonan::find()
                        ->where(['cv_tbl_permohonan.status_id' => 1])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->leftJoin('hronline.tblprcobiodata', 'cv_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                        ->andWhere(['is', 'cv_tbl_permohonan.admin_ICNO', null])
                        ->all();
    }

    public static function VerifyList($id) {
        return TblPermohonan::find()
                        ->where(['cv_tbl_permohonan.status_id' => 2])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['cv_tbl_permohonan.kj_status' => 1])
                        ->andWhere(['is', 'cv_tbl_permohonan.admin_ICNO', null])
                        ->all();
    }

    public static function VerifyKivList($id) {
        return TblCandidateKiv::find()
                        ->where(['jawatan_id' => $id, 'active' => 1])
                        ->all();
    }

    public static function TotalPending($icno, $type) {
        $academic = TblPermohonan::find()
                        ->where(['IN', 'cv_tbl_permohonan.status_id', 1])
                        ->joinWith('biodata.departmentHakiki')
                        ->joinWith('biodata.jawatan')
                        ->andWhere(['gredjawatan.job_category' => 1])
                        ->andWhere(['department.chief' => $icno])
                        ->andWhere(['cv_tbl_permohonan.isActive' => 1])
                        ->andWhere(['!=', 'tblprcobiodata.ICNO', $icno])->all();
        $admin = TblPermohonan::find()
                        ->where(['IN', 'cv_tbl_permohonan.status_id', 1])
                        ->joinWith('biodata.jawatan')
                        ->andWhere(['gredjawatan.job_category' => 2])
                        ->andWhere(['cv_tbl_permohonan.kj_ICNO' => $icno])
                        ->andWhere(['cv_tbl_permohonan.isActive' => 1])
                        ->andWhere(['!=', 'tblprcobiodata.ICNO', $icno])->all();

        $candidate = array();
        $n = 0;
        foreach ($academic as $model) {
            $candidate[] = $model->ICNO;
            $n++;
        }
        $j = count($candidate);
        foreach ($admin as $model) {
            $candidate[] = $model->ICNO;
            $j++;
        }

        $count = TblPermohonan::find()
                        ->where(['IN', 'cv_tbl_permohonan.status_id', 1])
                        ->andWhere(['IN', 'cv_tbl_permohonan.ICNO', $candidate])
                        ->andWhere(['cv_tbl_permohonan.isActive' => 1])
                        ->joinWith('biodata')
                        ->andWhere(['!=', 'tblprcobiodata.ICNO', $icno])->count();

        if ($type == 1) {
            return '&nbsp;<span class="badge bg-red">' . $count . '</span>';
        } else {
            return $count;
        }
    }

    public static function TotalPendingDean($icno, $type) {
        $model = \app\models\hronline\Tblprcobiodata::find()->joinWith('chiefDepartment')->where(['Status' => 1])->all();

        $chief = array();
        $i = 0;
        foreach ($model as $model) {
            if ($model->DeptId == $model->DeptId_hakiki) {
                $chief[] = $model->ICNO;
                $i++;
            }
        }
        $academic = TblPermohonan::find()
                        ->joinWith('biodata.jawatan')
                        ->where(['gredjawatan.job_category' => 1])
                        ->andWhere(['IN', 'cv_tbl_permohonan.kj_status', 0])
                        ->andWhere(['IN', 'cv_tbl_permohonan.ICNO', $chief])
                        ->andWhere(['cv_tbl_permohonan.isActive' => 1])
                        ->andWhere(['!=', 'cv_tbl_permohonan.ICNO', $icno])->all();

        $admin = TblPermohonan::find()
                        ->joinWith('biodata.jawatan')
                        ->where(['gredjawatan.job_category' => 2])
                        ->andWhere(['IN', 'cv_tbl_permohonan.kj_status', 0])
                        ->andWhere(['cv_tbl_permohonan.isActive' => 1])
                        ->andWhere(['cv_tbl_permohonan.kj_ICNO' => $icno])
                        ->andWhere(['!=', 'cv_tbl_permohonan.ICNO', $icno])->all();

        $candidate = array();
        $n = 0;
        if ($academic) {
            foreach ($academic as $model) {
                $candidate[] = $model->ICNO;
                $n++;
            }
        }

        $j = count($candidate);
        if ($admin) {
            foreach ($admin as $model) {
                $candidate[] = $model->ICNO;
                $j++;
            }
        }

        $count = TblPermohonan::find()
                        ->where(['IN', 'cv_tbl_permohonan.kj_status', 0])
                        ->andWhere(['IN', 'cv_tbl_permohonan.ICNO', $candidate])
                        ->andWhere(['cv_tbl_permohonan.isActive' => 1])
                        ->joinWith('biodata')
                        ->andWhere(['!=', 'tblprcobiodata.ICNO', $icno])->count();

        if ($type == 1) {
            return '&nbsp;<span class="badge bg-red">' . $count . '</span>';
        } else {
            return $count;
        }
    }

    public static function TotalPendingPeraku($icno, $type) {
        $count = TblPermohonan::find()
                ->where(['IN', 'cv_tbl_permohonan.status_id', [1]])
                ->andWhere(['IN', 'cv_tbl_permohonan.kj_ICNO', $icno])
                ->andWhere(['is', 'cv_tbl_permohonan.kj_datetime', null])
                ->andWhere(['cv_tbl_permohonan.isActive' => 1])
                ->andWhere(['!=', 'cv_tbl_permohonan.ICNO', $icno])
                ->count();

        if ($type == 1) {
            return '&nbsp;<span class="badge bg-red">' . $count . '</span>';
        } else {
            return $count;
        }
    }

}
