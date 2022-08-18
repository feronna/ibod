<?php

namespace app\models\lppums;

use Yii;
use yii\base\Model;

use app\models\hronline\Tblprcobiodata;
use app\models\hronline\GredJawatan;
use app\models\hronline\Department;

use app\models\lppums\TblSkt;
use app\models\lppums\TblSktTandatangan;
use app\models\lppums\TblSktUlasan;
use app\models\lppums\TblRequestLog;
use app\models\lppums\TblMarkahKeseluruhan;
use app\models\lppums\TblSumbanganTt;
use app\models\elnpt\TblBulanPgt;
use app\models\elnpt\TblSandangan;
use app\models\elnpt\TblSandangan2;
use app\models\elnpt\TblSandangan3;
use app\models\elnpt\TblApc;
use app\models\elnpt\TblApt;
use app\models\system_core\ExternalUser;

/**
 * This is the model class for table "hrm.lppums_tbl_main".
 *
 * @property string $lpp_id
 * @property string $lpp_datetime
 * @property string $PYD
 * @property int $PYD_sts_lantikan
 * @property int $gred_jawatan_id
 * @property string $tahun
 * @property int $jspiu
 * @property string $PPP
 * @property int $gred_jawatan_id_PPP
 * @property int $jspiu_PPP
 * @property string $PPK
 * @property int $gred_jawatan_id_PPK
 * @property int $jspiu_PPK
 * @property string $PP_ALL
 * @property int $PYD_sah
 * @property string $PYD_sah_datetime
 * @property int $PPP_sah
 * @property string $PPP_sah_datetime
 * @property int $PPK_sah
 * @property string $PPK_sah_datetime
 * @property string $KJ_sah
 * @property string $KJ_sah_datetime
 */
class TblMain extends \yii\db\ActiveRecord
{
    public $flag_pyd;
    public $reset_pyd_sah;
    public $reset_ppp_sah;
    public $reset_ppk_sah;
    public $reset_pyd_skt_sah;
    public $reset_ppp_skt_sah;
    public $reset_pyd_skt_ulas_sah;
    public $reset_ppp_skt_ulas_sah;
    public $tidak_setuju;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_lpp';
    }

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['flag_pyd'], 'required', 'requiredValue' => 1, 'message' => 'Sila pangkah sebelum hantar pengesahan.'],
            [['lpp_datetime', 'tahun', 'PYD_sah_datetime', 'PPP_sah_datetime', 'PPK_sah_datetime', 'KJ_sah_datetime', 'tidak_setuju'], 'safe'],
            [[
                'reset_pyd_sah', 'reset_ppp_sah', 'reset_ppk_sah',
                'PYD_sts_lantikan', 'gred_jawatan_id', 'jspiu', 'gred_jawatan_id_PPP',
                'jspiu_PPP', 'gred_jawatan_id_PPK', 'jspiu_PPK', 'PYD_sah', 'PPP_sah', 'PPK_sah'
            ], 'integer'],
            [['PYD', 'PPP', 'PPK', 'PP_ALL', 'KJ_sah'], 'string', 'max' => 12],
            [['catatan'], 'string', 'max' => 255],
            ['PYD_sah', 'validatePengesahanPyd', 'on' => 'sah_pyd'],
            ['tidak_setuju', 'validatePengesahanMarkahPyd', 'on' => 'sah_pyd_markah'],
            //['PYD_sah', 'required', 'on' => 'sah_pyd'],
            ['PPP_sah', 'validatePengesahanPpp', 'on' => 'sah_ppp'],
            ['PPK_sah', 'validatePengesahanPpk', 'on' => 'sah_ppk'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['sah_ppk'] = ['PPK_sah'];
        $scenarios['sah_ppp'] = ['PPP_sah'];
        $scenarios['sah_pyd'] = ['PYD_sah'];
        $scenarios['sah_pyd_markah'] = ['tidak_setuju'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lpp_id' => 'Lpp ID',
            'lpp_datetime' => 'Lpp Datetime',
            'PYD' => 'Pyd',
            'PYD_sts_lantikan' => 'Pyd Sts Lantikan',
            'gred_jawatan_id' => 'Gred Jawatan ID',
            'tahun' => 'Tahun',
            'jspiu' => 'Jspiu',
            'PPP' => 'Ppp',
            'gred_jawatan_id_PPP' => 'Gred Jawatan Id Ppp',
            'jspiu_PPP' => 'Jspiu Ppp',
            'PPK' => 'Ppk',
            'gred_jawatan_id_PPK' => 'Gred Jawatan Id Ppk',
            'jspiu_PPK' => 'Jspiu Ppk',
            'PP_ALL' => 'Pp All',
            'PYD_sah' => 'Pyd Sah',
            'PYD_sah_datetime' => 'Pyd Sah Datetime',
            'PPP_sah' => 'Ppp Sah',
            'PPP_sah_datetime' => 'Ppp Sah Datetime',
            'PPK_sah' => 'Ppk Sah',
            'PPK_sah_datetime' => 'Ppk Sah Datetime',
            'KJ_sah' => 'Kj Sah',
            'KJ_sah_datetime' => 'Kj Sah Datetime',
        ];
    }

    public function getPyd()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'PYD']);
    }

    public function getPpp()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'PPP']);
    }

    public function getPpk()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'PPK']);
    }

    public function getPpAll()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'PP_ALL']);
    }

    public function getKj()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'KJ_sah']);
    }

    public function getExternalUser()
    {
        return $this->hasOne(ExternalUser::className(), ['user_id' => 'PPP']);
    }

    public function getKjDetails()
    {
        if ($this->kj) {
            return $this->kj->CONm . ' ' . $this->KJ_sah_datetime;
        }


        if ($this->externalUser) {
            return $this->externalUser->name . ' ' . $this->KJ_sah_datetime;
        }
    }

    public function getPppName()
    {
        if ($this->ppp) {
            return $this->ppp->CONm;
        }


        if ($this->externalUser) {
            return $this->externalUser->name;
        }
    }

    public function getPppGredJawatan()
    {
        if ($this->ppp) {
            return $this->gredJawatanPpp->nama;
        }


        if ($this->externalUser) {
            // return $this->externalUser->name;
            return 'External';
        }
    }

    public function getPppDept()
    {
        if ($this->ppp) {
            return $this->departmentPpp->fullname;
        }


        if ($this->externalUser) {
            // return $this->externalUser->name;
            return 'External';
        }
    }

    public function getGredJawatan()
    {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gred_jawatan_id']);
    }

    public function getGredJawatanPpp()
    {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gred_jawatan_id_PPP']);
    }

    public function getGredJawatanPpk()
    {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gred_jawatan_id_PPK']);
    }

    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'jspiu']);
    }

    public function getDepartmentPpp()
    {
        return $this->hasOne(Department::className(), ['id' => 'jspiu_PPP']);
    }

    public function getDepartmentPpk()
    {
        return $this->hasOne(Department::className(), ['id' => 'jspiu_PPK']);
    }

    public function validatePengesahanMarkahPyd($attribute, $params, $validator)
    {
        if (!$this->tidak_setuju) {
            $this->addError($attribute, 'Sila pangkah sebelum hantar pengesahan.');
        }

        $this->addErrors($this->getErrors($attribute));
    }

    public function validatePengesahanPyd($attribute, $params, $validator)
    {
        $list = [];

        $sumbangan = TblSumbanganTt::find()->where(['lpp_id' => $this->lpp_id, 'sumbangan_tt' => $this->PYD])->exists();
        $skt = TblSkt::find()->where(['lpp_id' => $this->lpp_id])->exists();
        $skt_tt = TblSktTandatangan::find()->where(['lpp_id' => $this->lpp_id, 'skt_tt_pyd' => $this->PYD])->exists();
        $ulasan = TblSktUlasan::find()->where(['lpp_id' => $this->lpp_id])->exists();
        $ulasan_tt = TblSktUlasan::find()->where(['lpp_id' => $this->lpp_id, 'skt_ulasan_tt_pyd' => $this->PYD])->exists();

        if (!$this->PYD_sah) {
            $this->addError($attribute, 'Sila pangkah sebelum hantar pengesahan.');
        }
        if ($sumbangan == false) {
            $this->addError($attribute, 'Anda belum menandatangan laporan kegiatan dan sumbangan di luar tugas rasmi.');
        }
        if ($ulasan_tt == false) {
            $this->addError($attribute, 'Anda belum menandatangan laporan dan ulasan keseluruhan pencapaian Sasaran Kerja Tahunan');
        }
        if ($ulasan == false) {
            $this->addError($attribute, 'Anda belum memberi sebarang laporan dan ulasan keseluruhan pencapaian Sasaran Kerja Tahunan');
        }
        if ($skt_tt == false) {
            $this->addError($attribute, 'Anda belum menandatangan penetapan Sasaran Kerja Tahunan');
        }
        if ($skt == false) {
            $this->addError($attribute, 'Anda belum menyatakan penetapan Sasaran Kerja Tahunan');
        }

        $this->addErrors($this->getErrors($attribute));
    }

    public function validatePengesahanPpp($attribute, $params, $validator)
    {
        $list = [];

        $lpp = TblMain::findOne(['lpp_id' => $this->lpp_id]);
        $tahun = TblLppTahun::findOne(['lpp_tahun' => $lpp->tahun]);

        $ulasann = TblSktUlasan::find()
            ->where(['lpp_id' => $this->lpp_id])
            ->andWhere(['IS NOT', 'skt_ulasan_ppp', null])
            ->exists();
        $ulasan_ttn = TblSktUlasan::find()->where(['lpp_id' => $this->lpp_id, 'skt_ulasan_tt_ppp' => $this->PPP])->exists();

        if ($ulasan_ttn == false) {
            $this->addError($attribute, 'Anda belum menandatangan laporan dan ulasan keseluruhan pencapaian Sasaran Kerja Tahunan');
        }
        if ($ulasann == false) {
            $this->addError($attribute, 'Anda belum memberi sebarang laporan dan ulasan keseluruhan pencapaian Sasaran Kerja Tahunan');
        }

        $mrkh_bhg1 = TblLppMarkah::find()
            ->leftJoin('`hrm`.`lppums_bahagian_has_kriteria`', '`hrm`.`lppums_bahagian_has_kriteria`.`bhk_id` = `hrm`.`lppums_lpp_markah`.`bhk_id`')
            ->where(['lpp_id' => $this->lpp_id, 'bahagian_id' => 1])
            ->andWhere(['IS NOT', 'markah_PPP_', null])
            ->exists();

        $mrkh_bhg2 = TblLppMarkah::find()
            ->leftJoin('`hrm`.`lppums_bahagian_has_kriteria`', '`hrm`.`lppums_bahagian_has_kriteria`.`bhk_id` = `hrm`.`lppums_lpp_markah`.`bhk_id`')
            ->where(['lpp_id' => $this->lpp_id, 'bahagian_id' => 2])
            ->andWhere(['IS NOT', 'markah_PPP_', null])
            ->exists();

        $mrkh_bhg3 = TblLppMarkah::find()
            ->leftJoin('`hrm`.`lppums_bahagian_has_kriteria`', '`hrm`.`lppums_bahagian_has_kriteria`.`bhk_id` = `hrm`.`lppums_lpp_markah`.`bhk_id`')
            ->where(['lpp_id' => $this->lpp_id, 'bahagian_id' => 3])
            ->andWhere(['IS NOT', 'markah_PPP_', null])
            ->exists();

        $mrkh_bhg4 = TblLppMarkah::find()
            ->leftJoin('`hrm`.`lppums_bahagian_has_kriteria`', '`hrm`.`lppums_bahagian_has_kriteria`.`bhk_id` = `hrm`.`lppums_lpp_markah`.`bhk_id`')
            ->where(['lpp_id' => $this->lpp_id, 'bahagian_id' => 4])
            ->andWhere(['IS NOT', 'markah_PPP_', null])
            ->exists();

        $mrkh_slrh = TblMarkahKeseluruhan::find()
            ->where(['lpp_id' => $this->lpp_id])
            ->andWhere(['markah_PPP' => null])
            ->exists();

        $ulasan = TblUlasan::find()
            ->where(['lpp_id' => $this->lpp_id])
            ->andWhere(['IS NOT', 'ulasan_PPP_tt', null])
            ->exists();

        if (!$this->PPP_sah) {
            $this->addError($attribute, 'Sila pangkah sebelum hantar pengesahan.');
        }
        if ($mrkh_bhg1 == false) {
            $this->addError($attribute, 'Anda belum menyemak Bahagian III');
        }
        //        if($mrkh_bhg3 == false) {
        //            $this->addError($attribute, 'Anda belum menyemak Bahagian 4');
        //        }
        if ($mrkh_bhg2 == false) {
            $this->addError($attribute, 'Anda belum menyemak Bahagian V');
        }
        if ($mrkh_bhg4 == false) {
            $this->addError($attribute, 'Anda belum menyemak Bahagian VI');
        }
        if ($mrkh_slrh == true) {
            $this->addError($attribute, 'Anda belum memberi markah dalam Bahagian VII');
        }
        if ($ulasan == false) {
            $this->addError($attribute, 'Anda belum menandatangan laporan dan ulasan Bahagian VIII');
        }

        $req = TblRequest::findOne(['lpp_id' => $lpp->lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);
        if (isset($req)) {
            if (date('Y-m-d H:i:s') > $tahun->penilaian_PPP_tamat and date('Y-m-d H:i:s') > $req->close_date && $this->checkKeselamatan2021($lpp)) {
                $this->addError($attribute, 'Tempoh penilaian PPP sudah tamat');
            }
        } else {
            if (date('Y-m-d H:i:s') > $tahun->penilaian_PPP_tamat && $this->checkKeselamatan2021($lpp)) {
                $this->addError($attribute, 'Tempoh penilaian PPP sudah tamat');
            }
        }

        $this->addErrors($this->getErrors($attribute));
    }

    public function validatePengesahanPpk($attribute, $params, $validator)
    {
        $list = [];

        $lpp = TblMain::findOne(['lpp_id' => $this->lpp_id]);
        $tahun = TblLppTahun::findOne(['lpp_tahun' => $lpp->tahun]);

        $mrkh_bhg1 = TblLppMarkah::find()
            ->leftJoin('`hrm`.`lppums_bahagian_has_kriteria`', '`hrm`.`lppums_bahagian_has_kriteria`.`bhk_id` = `hrm`.`lppums_lpp_markah`.`bhk_id`')
            ->where(['lpp_id' => $this->lpp_id, 'bahagian_id' => 1])
            ->andWhere(['IS NOT', 'markah_PPK_', null])
            ->exists();

        $mrkh_bhg2 = TblLppMarkah::find()
            ->leftJoin('`hrm`.`lppums_bahagian_has_kriteria`', '`hrm`.`lppums_bahagian_has_kriteria`.`bhk_id` = `hrm`.`lppums_lpp_markah`.`bhk_id`')
            ->where(['lpp_id' => $this->lpp_id, 'bahagian_id' => 2])
            ->andWhere(['IS NOT', 'markah_PPK_', null])
            ->exists();

        $mrkh_bhg3 = TblLppMarkah::find()
            ->leftJoin('`hrm`.`lppums_bahagian_has_kriteria`', '`hrm`.`lppums_bahagian_has_kriteria`.`bhk_id` = `hrm`.`lppums_lpp_markah`.`bhk_id`')
            ->where(['lpp_id' => $this->lpp_id, 'bahagian_id' => 3])
            ->andWhere(['IS NOT', 'markah_PPK_', null])
            ->exists();

        $mrkh_bhg4 = TblLppMarkah::find()
            ->leftJoin('`hrm`.`lppums_bahagian_has_kriteria`', '`hrm`.`lppums_bahagian_has_kriteria`.`bhk_id` = `hrm`.`lppums_lpp_markah`.`bhk_id`')
            ->where(['lpp_id' => $this->lpp_id, 'bahagian_id' => 4])
            ->andWhere(['IS NOT', 'markah_PPK_', null])
            ->exists();

        $mrkh_slrh = TblMarkahKeseluruhan::find()
            ->where(['lpp_id' => $this->lpp_id])
            ->andWhere(['markah_PPK' => null])
            ->exists();

        $ulasan = TblUlasan::find()
            ->where(['lpp_id' => $this->lpp_id])
            ->andWhere(['IS NOT', 'ulasan_PPK_tt', null])
            ->exists();

        if (!$this->PPK_sah) {
            $this->addError($attribute, 'Sila pangkah sebelum hantar pengesahan.');
        }
        if ($mrkh_bhg1 == false) {
            $this->addError($attribute, 'Anda belum menyemak Bahagian III');
        }
        //        if($mrkh_bhg3 == false) {
        //            $this->addError($attribute, 'Anda belum menyemak Bahagian 4');
        //        }
        if ($mrkh_bhg2 == false) {
            $this->addError($attribute, 'Anda belum menyemak Bahagian V');
        }
        if ($mrkh_bhg4 == false) {
            $this->addError($attribute, 'Anda belum menyemak Bahagian VI');
        }
        if ($mrkh_slrh == true) {
            $this->addError($attribute, 'Anda belum memberi markah dalam Bahagian VII');
        }
        if ($ulasan == false) {
            $this->addError($attribute, 'Anda belum menandatangan laporan dan ulasan Bahagian IX');
        }

        $req = TblRequest::findOne(['lpp_id' => $lpp->lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);
        if (isset($req)) {
            if (date('Y-m-d H:i:s') > $tahun->penilaian_PPK_tamat and date('Y-m-d H:i:s') > $req->close_date && $this->checkKeselamatan2021($lpp)) {
                $this->addError($attribute, 'Tempoh penilaian PPK sudah tamat');
            }
        } else {
            if (date('Y-m-d H:i:s') > $tahun->penilaian_PPK_tamat && $this->checkKeselamatan2021($lpp)) {
                $this->addError($attribute, 'Tempoh penilaian PPK sudah tamat');
            }
        }

        $this->addErrors($this->getErrors($attribute));
    }

    public function getTandatanganBhg1()
    {
        return $this->hasMany(TblTandatangan::className(), ['lpp_id' => 'lpp_id'])->orderBy(['skt_tt_id' => SORT_ASC]);
    }

    public function getTandatanganBhg2()
    {
        $cnt = TblTandatangan::find()->where(['lpp_id' => $this->lpp_id])->count();

        if ($cnt == 2) {
            return $this->hasMany(TblTandatangan::className(), ['lpp_id' => 'lpp_id'])->orderBy(['skt_tt_id' => SORT_DESC]);
        } else {
            return null;
        }
    }

    public function getTandatanganBhg3()
    {
        return $this->hasOne(TblSktUlasan::className(), ['lpp_id' => 'lpp_id']);
    }

    public function getRequestLog()
    {
        return $this->hasOne(TblRequestLog::className(), ['lpp_id' => 'lpp_id']);
    }

    public function getMarkahSeluruh()
    {
        return $this->hasOne(TblMarkahKeseluruhan::className(), ['lpp_id' => 'lpp_id']);
    }

    public function getAvgMark()
    {
        return $this->hasOne(TblAvgMark::className(), ['ICNO' => 'PYD', 'YEAR' => 'tahun']);
    }

    public function getTahunLpp()
    {
        return $this->hasOne(TblLppTahun::className(), ['lpp_tahun' => 'tahun']);
    }

    public function getBulanPgt()
    {
        return $this->hasOne(TblBulanPgt::className(), ['ICNO' => 'PYD']);

        //        $connection = Yii::$app->getDb();
        //        $command = $connection->createCommand("
        //            SELECT `a`.`ICNO` AS `ICNO`,`a`.`SalMoveMth` AS `SalMoveMth`,`a`.`SalMoveMthType` 
        //            AS `SalMoveMthType`,`a`.`SalMoveMthStDt` AS `SalMoveMthStDt`,`a`.`id` AS `id` 
        //            FROM `hronline`.`tblrscosalmovemth` `a` WHERE (`a`.`SalMoveMthStDt` = (SELECT MAX(`temp`.`SalMoveMthStDt`) 
        //            AS `MAX(temp.``SalMoveMthStDt``)` FROM `hronline`.`tblrscosalmovemth` `temp` WHERE (`temp`.`ICNO` = `a`.`ICNO`))) 
        //            AND	 icno = :icno
        //            GROUP BY `a`.`ICNO`", [':icno' => $this->PYD]);
        //
        //        $result = $command->queryOne();
        //        
        //        return $result['SalMoveMth'];

    }

    public function getSandangan()
    {
        return $this->hasOne(TblSandangan::className(), ['icno' => 'PYD']);
    }

    public function getSandangan2()
    {
        return $this->hasOne(TblSandangan2::className(), ['icno' => 'PYD']);
    }

    public function getSandangan3()
    {
        return $this->hasOne(TblSandangan3::className(), ['icno' => 'PYD']);
    }

    public function getCdg()
    {
        return $this->hasOne(TblCadanganApc::className(), ['lpp_id' => 'lpp_id']);
    }

    public function getApc()
    {
        return $this->hasOne(TblApc::className(), ['ICNO' => 'PYD']);
    }

    public function getApt()
    {
        return $this->hasOne(TblApt::className(), ['ICNO' => 'PYD']);
    }

    public function getAlasan()
    {
        return $this->hasMany(TblAlasanSemakan::className(), ['lpp_id' => 'lpp_id']);
    }

    public function getPrevMarks()
    {
        return $this->hasMany(TblMarkahKeseluruhanView::className(), ['ICNO' => 'PYD'])->orderBy(['TAHUN' => SORT_DESC])->limit(2);
    }

    protected function checkKeselamatan2021($lpp)
    {
        if (date('Y/m/d') <= '2022/05/25' && $lpp->jspiu == 2)
            return false;

        return true;
    }
}
