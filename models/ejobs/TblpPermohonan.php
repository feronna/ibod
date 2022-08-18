<?php

namespace app\models\ejobs;

use app\models\ejobs\JenisUser;
use app\models\ejobs\StatusPermohonan;
use app\models\ejobs\StatusPermohonanDalaman;
use app\models\ejobs\Iklan;
use app\models\ejobs\TblpBiodata;
use app\models\ejobs\GredJawatan;
use app\models\hronline\Kampus;
use app\models\hronline\Tblprcobiodata;
use app\models\ejobs\Penempatan;
use app\models\ejobs\TblpSbbSaringanFail;
use app\models\hronline\Department;
use app\models\ejobs\UserSpecial;
use Yii;

/**
 * This is the model class for table "ejobs.iklan_permohonan".
 *
 * @property int $id
 * @property int $iklan_id
 * @property string $ICNO
 * @property int $jenis_user_id
 */
class TblpPermohonan extends \yii\db\ActiveRecord {

    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }

    public $agree;

    public static function tableName() {
        return 'ejobs.tbl_permohonan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['agree', 'iklan_id', 'ICNO', 'jenis_user_id', 'pengakuanTxt', 'tarikh_mohon', 'tarikh_tutup'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['iklan_id', 'jenis_user_id', 'dustBstatus', 'status_id', 'status_saringan_id'], 'integer'],
            [['ICNO'], 'string', 'max' => 12],
            [['pengakuanTxt'], 'string', 'max' => 2000],
            [['pp', 'kj', 'noti_permohonan'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'iklan_id' => 'Iklan ID',
            'ICNO' => 'Icno',
            'jenis_user_id' => 'Jenis User ID',
            'pengakuanTxt' => 'Pengakuan',
        ];
    }

    public function getJenisUser() {
        return $this->hasOne(JenisUser::className(), ['id' => 'jenis_user_id']);
    }

//    public function getCheckPermohonan(){
//        return $this->hasOne(Iklan::className(), ['id' => 'iklan_id','ICNO' => 'ICNO']);
//    }

    public function getStatus() {
        return $this->hasOne(StatusPermohonan::className(), ['id' => 'status_id']);
    }

    public function getStatusDalaman() {
        return $this->hasOne(StatusPermohonanDalaman::className(), ['id' => 'status_id']);
    }

    public function getIklan() {
        return $this->hasOne(Iklan::className(), ['id' => 'iklan_id']);
    }

    public function Jawatan($id) {
        $model = GredJawatan::findOne(['id' => $id]);

        return $model->fname;
    }

    public function Penempatan($id) {
        $model = Kampus::findOne(['campus_id' => $id]);

        return $model->campus_name;
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

    public function getBiodata() {
        return $this->hasOne(\app\models\ejobs\TblprcobiodataTemp::className(), ['ICNO' => 'ICNO']);
    }

    public function getPpBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'pp']);
    }

    public function getKjBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'kj']);
    }

    public function getBiodataOrgAwam() {
        return $this->hasOne(TblpBiodata::className(), ['ICNO' => 'ICNO']);
    }

    public function getBiodataStaff() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }

    public function allPenempatan($iklan_id) {
        return Penempatan::find()->where(['iklan_id' => $iklan_id])->all();
    }

    public function getSbbFail() {
        return $this->hasOne(TblpSbbSaringanFail::className(), ['permohonan_id' => 'id']);
    }

    public function getStatusPp() {
        if ($this->status_saringan_id == 2) {
            return '<span class="label label-warning">Menunggu</span>';
        } elseif ($this->status_saringan_id == 4) {
            return '<span class="label label-success">Dipersetujui</span>';
        } elseif ($this->status_saringan_id == 5) {
            return '<span class="label label-danger">Ditolak</span>';
        }
    }

    public function getStatusKj() {
        if ($this->status_saringan_id == 4) {
            return '<span class="label label-warning">Menunggu</span>';
        } elseif ($this->status_saringan_id == 6) {
            return '<span class="label label-success">Dipersetujui</span>';
        } elseif (in_array($this->status_saringan_id, [5, 7])) {
            return '<span class="label label-danger">Ditolak</span>';
        }
    }

    public function getStatusPpNull() {
        if ($this->status_saringan_id == 2) {
            return '<span class="label label-warning">Menunggu</span>';
        } elseif ($this->status_saringan_id == 6) {
            return '<span class="label label-success">Dipersetujui</span>';
        } elseif ($this->status_saringan_id == 7) {
            return '<span class="label label-danger">Ditolak</span>';
        }
    }

    public static function isPp($icno) {
        return Department::find()->where(['pp' => $icno])->andWhere(['isActive' => 1])->exists();
    }

    public static function PpDetails() {
        return Department::find()->where(['pp' => Yii::$app->user->getId()])->andWhere(['isActive' => 1])->one();
    }

    public static function checkPp($icno) {
        $model = Department::find()->where(['chief' => $icno])->andWhere(['isActive' => 1])->one();

        if ($model->pp) {
            return 1;
        }
    }

    public static function idPp($icno) {
        $model = Department::find()->where(['chief' => $icno])->andWhere(['isActive' => 1])->one();

        if ($model->pp) {
            return $model->pp;
        }
    }

    public static function isKj($icno) {
        return Department::find()->where(['chief' => $icno])->andWhere(['isActive' => 1])->exists();
    }

    public static function KjDetails() {
        return Department::find()->where(['chief' => Yii::$app->user->getId()])->andWhere(['isActive' => 1])->one();
    }

    public static function isPPKontrak() {
        return UserSpecial::find()->where(['ICNO' => Yii::$app->user->getId()])->exists();
    }

    public static function findPP() {
        $model = Department::find()->joinWith('biodata')->where(['tblprcobiodata.ICNO' => Yii::$app->user->getId()])->one();

        return $model->pp ? 1 : NULL;
    }

    public static function totalPending($icno, $type) {
        $count = 0;
        if (TblpPermohonan::isPp($icno)) {
            $count = TblpPermohonan::find()
                    ->where(['tbl_permohonan.status_saringan_id' => 2])
                    ->andWhere(['tbl_permohonan.pp' => $icno])
                    ->andWhere(['!=', 'tbl_permohonan.ICNO', $icno])
                    ->andWhere(['tbl_permohonan.jenis_user_id' => 1])
                    ->joinWith('iklan')
                    ->joinWith('biodata')
                    ->andWhere(['tblprcobiodata.Status' => 1])
                    ->andWhere(['!=', 'iklan.status', 3])
                    ->count();
        } elseif (TblpPermohonan::isKj($icno)) {
            if (TblpPermohonan::checkPP($icno) == 1) {
                $staff = TblpPermohonan::find()
                        ->where(['IN', 'tbl_permohonan.status_saringan_id', [4, 5]])
                        ->andWhere(['tbl_permohonan.kj' => $icno])
                        ->andWhere(['tbl_permohonan.jenis_user_id' => 1])
                        ->joinWith('iklan')
                        ->joinWith('biodata')
                        ->andWhere(['tblprcobiodata.Status' => 1])
                        ->andWhere(['!=', 'iklan.status', 3])
                        ->count();

                $pp = TblpPermohonan::find()
                        ->where(['tbl_permohonan.ICNO' => TblpPermohonan::idPP($icno)])
                        ->andWhere(['tbl_permohonan.status_saringan_id' => 2])
                        ->andWhere(['tbl_permohonan.kj' => $icno])
                        ->andWhere(['tbl_permohonan.jenis_user_id' => 1])
                        ->joinWith('iklan')
                        ->joinWith('biodata')
                        ->andWhere(['tblprcobiodata.Status' => 1])
                        ->andWhere(['!=', 'iklan.status', 3])
                        ->count();

                $count = $staff + $pp;
            } else {
                $count = TblpPermohonan::find()
                        ->where(['tbl_permohonan.status_saringan_id' => 2])
                        ->andWhere(['tbl_permohonan.kj' => $icno])
                        ->andWhere(['tbl_permohonan.jenis_user_id' => 1])
                        ->joinWith('iklan')
                        ->joinWith('biodata')
                        ->andWhere(['tblprcobiodata.Status' => 1])
                        ->andWhere(['!=', 'iklan.status', 3])
                        ->count();
            }
        }

        if ($type == 1) {
            return '&nbsp;<span class="badge bg-red">' . $count . '</span>';
        } else { //pending task
            return $count;
        }
    }
    
    public static function findActiveApplication() {
        $gredExist = TblpPermohonan::find()
                                ->where(['tbl_permohonan.ICNO' => Yii::$app->user->getId()])
                                ->joinWith('iklan')
                                ->andWhere(['iklan.status' => 1])
                                ->select('iklan.jawatan_id')->distinct();

        return $gredExist;
    }

}
