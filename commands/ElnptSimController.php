<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

//simulation
use app\models\elnpt\simulation\RefAspekPemberat;
use app\models\elnpt\simulation\RefAspekPenilaian;
use app\models\elnpt\simulation\RefAspekSkor;
use app\models\elnpt\simulation\RefSkorPenyeliaan;
use app\models\elnpt\simulation\TblMrkhBhg;
use app\models\elnpt\simulation\TblMrkhAspek;

//elnpt2
use app\models\elnpt\elnpt2\RefAspekPeratus;
use app\models\elnpt\elnpt2\RefGred;
use app\models\elnpt\elnpt2\TblKumpDept;
use app\models\elnpt\elnpt2\RefPemberatSeluruh;
use app\models\elnpt\elnpt2\TblPersidangan;
use app\models\elnpt\elnpt2\TblTeknologiInovasi;
use app\models\elnpt\elnpt2\TblPnP;
use app\models\elnpt\elnpt2\PenilaianKursusPK07;
use app\models\elnpt\elnpt2\Tblrscoadminpost;
use app\models\elnpt\elnpt2\Model;
use app\models\elnpt\elnpt2\RefBahagian;
use app\models\elnpt\elnpt2\TblPenyeliaanManual;
use app\models\elnpt\elnpt2\TblPenyeliaan;
use app\models\elnpt\elnpt2\TblPengajaranPembelajaran;
use app\models\elnpt\elnpt2\PenilaianKursusPK07_FPSK;
use app\models\elnpt\elnpt2\TblDocuments;
use app\models\elnpt\elnpt2\TblSmartV3;
use app\models\elnpt\elnpt2\TblException2;

//elnpt
use app\models\elnpt\TblPengajaran;
use app\models\elnpt\TblRequest;
use app\models\elnpt\TblMain;
use app\models\elnpt\TblAlasanSemakan;

use app\models\elnpt\RefPeratusKategori;
use app\models\elnpt\TblMarkahKeseluruhan;
use app\models\elnpt\TblLppTahun;
use app\models\elnpt\perkhidmatan_klinikal\TblKlinikal;
use app\models\elnpt\TblPenyelidikan2;
use app\models\elnpt\TblPenyelidikanManual;
use app\models\elnpt\TblGrantApplication;
use app\models\elnpt\TblException;
use app\models\elnpt\penerbitan\TblLnptPublicationV2;
use app\models\elnpt\TblConference;
use app\models\elnpt\inovasi\TblPertandinganPereka;
use app\models\elnpt\inovasi\TblInovasi;
use app\models\elnpt\outreaching\TblOutreachingManual;
use app\models\elnpt\outreaching\TblConsultation;
use app\models\elnpt\perkhidmatan_klinikal\TblConsultationClinical;
use app\models\elnpt\TblConsultancy;
use app\models\elnpt\bahagian_7\TblPengurusanPentadbiran;
use app\models\elnpt\bahagian_9\TblMarkahKualiti;
use app\models\elnpt\simulation\TblMata;
use app\models\elnpt\simulation\TblSimulasiDec;
use app\models\elnpt\simulation\TblSimulasiJan;
use app\models\elnpt\testing\TblTestingAccess;
use app\models\elnpt\TblBlendedLearningFarm;
use app\models\elnpt\TblLnptClinical;

use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\base\UserException;
use yii\db\Expression;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
use yii\base\Exception;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ElnptSimController extends Controller
{
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionStartProcess()
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
        SELECT * FROM (

            SELECT a.`lpp_id`, b.`ref_kump_dept_id`, d.gred, ROW_NUMBER() OVER (PARTITION BY b.`ref_kump_dept_id` ORDER BY b.`ref_kump_dept_id` ASC) AS country_rank 
            FROM hrm.`elnpt_tbl_main` a
            INNER JOIN hrm.`elnpt_v2_tbl_kump_dept` b ON a.`jfpiu` = b.`dept_id`
            LEFT JOIN hronline.`gredjawatan` d ON d.id = a.gred_jawatan_id
            WHERE a.`tahun` = 2020 AND a.`PYD_sah` = 1 AND a.`PPK_sah` = 1 AND a.`PEER_sah` = 1 AND a.`PPP_sah` = 1
            AND a.`gred_jawatan_id` IN (15, 13, 11, 7, 10, 18, 224, 391, 392, 419)
            ) ranks
            WHERE country_rank <= 15;
        ");

        $result = $command->queryAll();

        //sederhana
        // $result = [
        //     21714, 21723, 21748, 21912, 21963, 21970, 21971, 22004, 22078, 22118, 22129, 22239, 22309, 22337, 22354, 22367
        // ];
        // $result = [
        //     21638, 21678, 21729, 21778, 21956, 21971, 21972, 22034, 22036, 22072, 22078, 22085, 22093, 22129, 22227, 22309, 22443
        // ];

        //cemerlang
        // $result = [
        //     21566, 21650, 21722, 21783, 21818, 21898, 21918, 21924, 21949, 21979, 21983, 22015, 22049, 22057, 22070, 22307
        // ];

        //lemah
        // $result = [
        //     21529, 21533, 21551, 21669, 21776, 21862, 21985, 22056, 22127, 22179, 22192, 22304, 22307, 22430, 22528
        // ];
        // $result = [
        //     21533, 21548, 21596, 21624, 21669, 21714, 21776, 21784, 21854, 21862, 21912, 21946, 21963, 22100, 22152, 22176, 22192, 22214, 22245, 22249, 22270, 22398, 22507, 22528, 22556, 22557
        // ];


        //     $result = [21746,21747,21748, 22838, 22894, 22895, //ds45
        //     21769, 21770, 21771, 22723, 22761, 22813, //ds52
        //     21779, 21780, 21781, 22715, 22793, 22848 //ds54
        // ];

        $result = [
            21768, 22690, 21772, 22883
        ];

        // echo sizeof($result);

        // $lpps = TblMain::find()
        //     ->alias('a')
        //     ->innerJoin(['b' => 'hrm.elnpt_v2_tbl_kump_dept'], 'a.jfpiu = b.dept_id')
        //     ->where(['tahun' => 2020, 'PYD_sah' => 1, 'PPP_sah' => 1, 'PPK_sah' => 1, 'PEER_sah' => 1])
        //     ->andWhere(['a.gred_jawatan_id' => [15, 13, 11, 7, 10, 18, 224, 391, 392, 419]]);

        // print($lpps->count()."\r\n");

        foreach ($result as $lpp) {
            try {
                $this->actionSimulateKategori($lpp);
                echo $lpp . ', ';
            } catch (\Exception $e) {
                echo $lpp . ' error, ';
                continue;
            }
        }
        return ExitCode::OK;
    }

    public function actionSimulateBorang($lppid)
    {
        $this->bahagian1($lppid);
        $this->bahagian2($lppid);
        $this->bahagian3($lppid);
        $this->bahagian4($lppid);
        $this->bahagian5($lppid);
        $this->bahagian6($lppid);
        $this->bahagian7($lppid);
        $this->bahagian8($lppid);
        $this->bahagian9($lppid);
    }

    public function bahagian1($lppid)
    {
        $bhg = RefBahagian::findOne(1);

        $lpp = $this->findLpp($lppid);

        $this->checkBahagian($lpp, $bhg->id);

        $this->dataBahagian1($lppid, $pengajaran, $pengajaran2, $pnp, $all);

        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 1])->asArray()->all();
        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 1])->asArray()->all();

        $data1 = ArrayHelper::toArray($pnp, []);
        $listt = $pengajaran + $pengajaran2;

        $syarahan = 0;
        $tutorial = 0;
        $amali = 0;

        foreach ($data1 as $ind => $p) {
            if (($p['status_kursus'] ?? '') >= 'HAKIKI') {
                if ($p['bil_pelajar'] <= 50) {
                    $syarahan = $p['jam_syarahan'] * 1.0;
                } else if ($p['bil_pelajar'] <= 100) {
                    $syarahan = $p['jam_syarahan'] * 1.5;
                } else {
                    $syarahan = $p['jam_syarahan'] * 2.0;
                }
            }

            $tutorial = $p['jam_tutorial'] * ($p['bil_pelajar'] > 0 ? 1 : 0);
            $amali = $p['jam_amali'] * ($p['bil_pelajar'] > 0 ? 1 : 0);

            ArrayHelper::setValue($bks_arry, $ind, ['syarahan' => $syarahan, 'tutorial' => $tutorial, 'amali' => $amali, 'bks' => (($syarahan + $amali + $tutorial))]);
        }

        foreach ($listt as $ind => $p) {
            foreach ($aspek_skor as $as) {
                if ($as['aspek_id'] == 3) {
                    if (strcasecmp($p['status'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
            }
            foreach (array_reverse($aspek_skor) as $as) {
                if ($as['aspek_id'] == 2) {

                    if ($p['pk07'] >= floatval($as['desc'])) {

                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => $p['pk07'] * floatval($as['skor'])]);
                        break;
                    }
                }
            }
            foreach (array_reverse($aspek_skor) as $as) {
                if ($as['aspek_id'] == 4) {
                    if (strcasecmp($p['status_fail'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
            }
        }

        $bks = isset($bks_arry) ? array_sum(ArrayHelper::getColumn($bks_arry, 'bks')) : 0;

        // return \yii\helpers\VarDumper::dump($bks / 14, 500, true);

        ArrayHelper::setValue($tmp, 1, $bks / 14);
        ArrayHelper::setValue($tmp, 2, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['2', 'skor'], $keepKeys = true)) : 0);

        ArrayHelper::setValue($tmp, 3, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['3', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 4, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['4', 'skor'], $keepKeys = true)) : 0);

        foreach ($pemberat as $p) {

            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $tmp[$p['aspek_id']], 'markah_pyd' => (min($tmp[$p['aspek_id']] / $this->getSasaran($bhg->id, $p['aspek_id'], $lpp->deptGuru->sub_of ?? $lpp->jfpiu, $lpp->gred_jawatan_id) * 70, 100) * ($p['pemberat'])) / 100]);
        }

        // return \yii\helpers\VarDumper::dump($this->getSasaran($bhg->id, 1, $lpp->deptGuru->sub_of ?? $lpp->jfpiu,$lpp->gred_jawatan_id), 500, true);

        $this->setMarkahAspek($lppid, array_keys($tmp), $mrkh_bhg, 1);

        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(1, $lppid), [], false);

        $this->calcOverallMark($lppid);
    }

    public function dataBahagian1($lppid, &$pengajaran, &$pengajaran2, &$pnp, &$all)
    {
        $lpp = $this->findLpp($lppid);

        $semester = [

            '2-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '' => '2-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '',
            '3-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '' => '3-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '',
            '1-' . ($lpp->tahun) . '/' . ($lpp->tahun + 1) . '' => '1-' . ($lpp->tahun) . '/' . ($lpp->tahun + 1) . '',

        ];

        $pengajaran = TblPengajaranPembelajaran::find()
            ->select(new Expression('a.id as AutoId, \'1\' as manual, \'Fail\' as status, a.*, b.filehash as file_hash, b.verified_by as ver_by, b.verified_dt as ver_dt, \'0\' as pk07, c.semester as semester, c.status_fail, c.seksyen as SEKSYEN'))
            ->alias('a')
            ->leftJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 1')
            ->leftJoin(['c' => 'hrm.elnpt_v2_tbl_pnp'], 'c.id_pnp = a.id and c.lpp_id = a.lpp_id')
            ->where(['a.lpp_id' => $lppid])
            ->orderBy(['id' => SORT_ASC])
            ->indexBy('AutoId')
            ->asArray()
            ->all();

        $pengajaran2 = TblPengajaran::find()
            ->select(new Expression('AutoId, \'0\' as manual, SMP07_KodMP as kod_kursus, NAMAKURSUS as nama_kursus, BILPELAJAR as bil_pelajar, 
            SEKSYEN, SESI as semester, JAMKREDIT, \'0\' as DISPLAY, \'-\' as skop_tugas, 
            \'-\' as status_pengendalian, \'-\' as penglibatan, \'Fail\' as status, \'\' as file_hash, \'SMP UMS\' as ver_by, \'SMP UMS\' as ver_dt, \'0\' as pk07, \'0\' as status_fail'))

            ->where(['NOKP' => $lpp->PYD])
            ->andWhere(['SESI' => array_keys($semester)])
            ->orderBy(['AutoId' => SORT_ASC])
            ->indexBy('AutoId')
            ->asArray()
            ->all();

        $list = $pengajaran + $pengajaran2;

        if (($pnp = TblPnP::find()->where(['lpp_id' => $lpp->lpp_id])->indexBy('id_pnp')->all()) != null) {
            $pnp = TblPnP::find()->where(['lpp_id' => $lpp->lpp_id, 'id_pnp' => ArrayHelper::getColumn($list, 'AutoId')])->indexBy('id_pnp')->all();
        } else {
            $pnp = [new TblPnP()];
            $cnt = 0;
            foreach ($list as $ind => $l) {
                $pnp[$cnt] = new TblPnP();
                $pnp[$cnt]->id_pnp = $l['AutoId'];
                $pnp[$cnt]->lpp_id = $lpp->lpp_id;
                $pnp[$cnt]->seksyen = 0;
                $pnp[$cnt]->bil_pelajar = 0;
                $pnp[$cnt]->status_kursus = 'BERBAYAR';
                $pnp[$cnt]->jam_syarahan = 0;
                $pnp[$cnt]->jam_tutorial = 0;
                $pnp[$cnt]->jam_amali = 0;
                $pnp[$cnt]->save(false);
                $cnt++;
            }
            $pnp = TblPnP::find()->where(['lpp_id' => $lpp->lpp_id])->indexBy('id_pnp')->all();
        }

        $data1 = ArrayHelper::toArray($pnp, []);

        foreach ($pengajaran2 as $ind => $p2) {
            foreach ($data1 as $dt1) {
                if ($p2['AutoId'] == $dt1['id_pnp']) {
                    $pengajaran2[$ind]['status_fail'] = $dt1['status_fail'];
                    break;
                }
            }
        }

        $blended = TblBlendedLearningFarm::find()
            ->select(['id', 'username_ic_pasportNo', 'fullname', 'status', new Expression('lastname as name'), new Expression('\'\' as email'), new Expression('\'SmartV2\' as sumber')])
            ->where(['or', ['username_ic_pasportNo' => $lpp->PYD], ['LIKE', 'lastname', $lpp->guru->CONm]])
            ->andWhere(['LIKE', 'fullname', new Expression('\'%' . $lpp->tahun . '%\'')])
            ->andWhere(['NOT LIKE', 'fullname', new Expression('\'%PEPERIKSAAN %\'')])
            ->orderBy(['status' => SORT_ASC])
            ->asArray()
            ->all();

        $smartv33 = TblSmartV3::find()
            ->select(['id', new Expression('\'\' as username_ic_pasportNo'), 'fullname', 'status', 'name', 'email', new Expression('\'SmartV3\' as sumber')])
            ->where(['LIKE', 'name', $lpp->guru->CONm])
            ->orFilterWhere(['LIKE', 'email', $lpp->guru->COEmail])
            ->orFilterWhere(['LIKE', 'email', $lpp->guru->COEmail2])
            ->andWhere(['NOT LIKE', 'fullname', new Expression('\'%PEPERIKSAAN %\'')])
            ->orderBy(['status' => SORT_ASC]);

        $smartv3 = $smartv33->asArray()->all();

        $all = array_merge($blended, $smartv3);
        $subjek = ['KK24303', 'KP24303', 'KP24203', 'KP34603', 'KP44403', 'KP34803'];

        foreach ($pengajaran as $ind1 => $p2) {

            if (in_array($pengajaran[$ind1]['kod_kursus'], $subjek)) {
                $pengajaran[$ind1]['status'] = 'Pass';
                continue;
            }
            foreach ($all as $b2) {

                if ((stripos($b2['fullname'], $pengajaran[$ind1]['kod_kursus']) !== false) && (stripos($b2['fullname'], $pengajaran[$ind1]['semester']) !== false)) {

                    if ($b2['status'] == 'Pass') {
                        $pengajaran[$ind1]['status'] = $b2['status'];
                        break;
                    }
                }
            }
        }

        foreach ($pengajaran2 as $ind1 => $p3) {

            if (in_array($pengajaran2[$ind1]['kod_kursus'], $subjek)) {
                $pengajaran2[$ind1]['status'] = 'Pass';
                continue;
            }
            foreach ($all as $b3) {

                if ((stripos($b3['fullname'], $pengajaran2[$ind1]['kod_kursus']) !== false) && (stripos($b3['fullname'], $pengajaran2[$ind1]['semester']) !== false)) {

                    if ($b3['status'] == 'Pass') {
                        $pengajaran2[$ind1]['status'] = $b3['status'];
                        break;
                    }
                }
            }
        }
        $pk07 = PenilaianKursusPK07::find()
            ->select('KodKursus, KodSesi, NoIC, LNPT_Mean as FinalMean, Seksyen')
            ->where(['NoIC' => $lpp->PYD])
            ->asArray()
            ->all();

        $pk07_fpsk = PenilaianKursusPK07_FPSK::find()
            ->select('KodSubjek as KodKursus, SesiSem as KodSesi, NoIC, FinalMean, Seksyen')
            ->where(['NoIC' => $lpp->PYD])
            ->asArray()
            ->all();

        $ppnp = TblPengajaranPembelajaran::find()
            ->alias('a')

            ->select(new Expression('\'1-2020/2021\' as semester, a.kod_kursus, a.id, b.seksyen'))
            ->innerJoin(['b' => 'hrm.elnpt_v2_tbl_pnp'], 'a.id = b.id_pnp')
            ->where(['a.lpp_id' => $lpp->lpp_id])
            ->indexBy('id')
            ->asArray()
            ->all();
        $tets = array_merge($pk07, $pk07_fpsk);

        foreach ($pengajaran as $ind1 => $p2) {
            foreach ($tets as $ind2 => $b2) {
                if ((str_replace(' ', '', $p2['semester']) == $b2['KodSesi']) && ($p2['kod_kursus'] == $b2['KodKursus']) && ($p2['SEKSYEN'] == $b2['Seksyen'])) {
                    $pengajaran[$ind1]['pk07'] = $b2['FinalMean'];
                    unset($tets[$ind2]);
                    break;
                } else {
                    $pengajaran[$ind1]['pk07'] = 0;
                }
            }
        }

        foreach ($pengajaran2 as $ind1 => $p3) {
            foreach ($tets as $ind2 => $b3) {
                if ((str_replace(' ', '', $p3['semester']) == $b3['KodSesi']) && ($p3['kod_kursus'] == $b3['KodKursus']) && ($p3['SEKSYEN'] == $b3['Seksyen'])) {
                    $pengajaran2[$ind1]['pk07'] = $b3['FinalMean'];
                    unset($tets[$ind2]);
                    break;
                } else {
                    $pengajaran2[$ind1]['pk07'] = 0;
                }
            }
        }
    }

    public function setMarkahAspek($lppid, $my_id, $mrkh_bhg, $bhg_no)
    {
        $lpp = $this->findLpp($lppid);

        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);

        ksort($mrkh_bhg);

        if (
            TblMrkhAspek::find()
            ->where(['bhg_no' => $bhg_no, 'lpp_id' => $lppid])
            ->all() != null
        ) {
            $models = TblMrkhAspek::find()
                ->select('`hrm`.`elnpt_v3_tbl_mrkh_aspek`.*, `hrm`.`elnpt_v3_ref_aspek_penilaian`.`id` as aspek_id')
                ->rightJoin('`hrm`.`elnpt_v3_ref_aspek_penilaian`', '`hrm`.`elnpt_v3_ref_aspek_penilaian`.`id` =  `hrm`.`elnpt_v3_tbl_mrkh_aspek`.`aspek_id`'
                    . ' and `lpp_id` = ' . $lppid)
                ->where(['`hrm`.`elnpt_v3_ref_aspek_penilaian`.`bhg_no`' => $bhg_no])
                ->indexBy('aspek_id')

                ->all();
        } else {

            for ($i = 0; $i < count($mrkh_bhg); $i++) {
                $models[$my_id[$i]] = new TblMrkhAspek();
            }
        }
        // $req = $this->checkRequest($lppid);
        $cnt = 0;

        foreach ($mrkh_bhg as $ind => $mb) {
            $models[$my_id[$cnt]]->lpp_id = $lppid;
            $models[$my_id[$cnt]]->bhg_no = $bhg_no;
            $models[$my_id[$cnt]]->aspek_id = $ind;
            $models[$my_id[$cnt]]->skor = $mb['skor'] ?? 0;
            // if ($lpp->PYD == Yii::$app->user->identity->ICNO) {
            $models[$my_id[$cnt]]->markah_pyd = $mb['markah_pyd'] ?? 0;
            // }
            $models[$my_id[$cnt]]->markah_ppp = ($bhg_no >= 3 && $bhg_no <= 5) ? ($mb['markah_pyd'] ?? 0) : ($mb['markah_ppp'] ?? ($models[$my_id[$cnt]]->markah_ppp ?? 0));
            $models[$my_id[$cnt]]->markah_ppk = ($bhg_no >= 3 && $bhg_no <= 5) ? ($mb['markah_pyd'] ?? 0) : ($mb['markah_ppk'] ?? ($models[$my_id[$cnt]]->markah_ppk ?? 0));
            $models[$my_id[$cnt]]->markah_peer = ($bhg_no >= 3 && $bhg_no <= 5) ? ($mb['markah_pyd'] ?? 0) : ($mb['markah_peer'] ?? ($models[$my_id[$cnt]]->markah_peer ?? 0));
            $models[$my_id[$cnt]]->save(false);
            $cnt++;
        }
    }

    protected function findLpp($lppid)
    {
        if (($model = TblMain::findOne($lppid)) !== null) {
            return $model;
        }

        throw new UserException('The requested page does not exist.');
    }

    public function checkBahagian($lpp, $bhg_no)
    {
        $dept = TblKumpDept::find()->where(['dept_id' => $lpp->deptGuru->sub_of ?? $lpp->jfpiu])->asArray()->all();
        $dept1 = ArrayHelper::getColumn($dept, 'ref_kump_dept_id');
        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);
        $tamat_dt = $tahun->pengisian_PYD_tamat;
        $hasJawatan = Tblrscoadminpost::find()->where(['ICNO' => $lpp->PYD, 'paymentStatus' => 1, 'flag' => 1])->andWhere(['or', ['>', new Expression('TIMESTAMPDIFF(MONTH, start_date, \'' . \Yii::$app->formatter->asDate($tamat_dt, 'yyyy-MM-dd') . '\')'), 6], [
            'renew' => 1
        ]])->exists();
        $gred = RefGred::find()->where(['kump_gred' => ($hasJawatan && (in_array('1', $dept1) || in_array('2', $dept1) || in_array('6', $dept1) || in_array('3', $dept1) || in_array('5', $dept1))) ? $this->checkJawatanDeptKump($lpp->gredGuru->gred, $lpp->jfpiu, $lpp->gredGuru->gred_skim) : $lpp->gredGuru->gred])->one();

        $ex = TblException2::findOne([$lpp->lpp_id]);
        if (!is_null($ex)) {
            $dept = TblKumpDept::find()->where(['id' => $ex->tbl_kump_dept_id])->asArray()->all();
            $gred = RefGred::findOne([$ex->ref_gred_id]);
        }
        try {
            $check = RefPemberatSeluruh::find()->where(['tbl_kump_dept_id' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), 'ref_gred_id' => $gred->id, 'bahagian' => $bhg_no])->exists();
            if (!$check) {
                throw new HttpException(403, "You don't have permission to view this page.");
            }
        } catch (\Exception $e) {
            throw new HttpException(403, "You don't have permission to view this page.");
        }
    }

    public function getSasaran(int $bhg, int $aspek, int $dept_no, String $gred_no): float
    {
        $kump_dept = \app\models\elnpt\elnpt2\TblKumpDept::find()->where(['dept_id' => $dept_no])->one();
        $gred_cat = \app\models\hronline\GredJawatan::find()->where(['id' => $gred_no])->one();
        switch ($bhg) {
            case 1:
                if ($aspek == 1) {
                    if ($gred_cat->skimPerkhidmatan->id == 3) {
                        if ($kump_dept->id == 1 or $kump_dept->id == 2 or $kump_dept->id == 5) {
                            switch (true) {
                                case $gred_cat->gred == 'DS45':
                                    return 12.0;
                                case $gred_cat->gred == 'DS51':
                                case $gred_cat->gred == 'DS52':
                                    return 9.0;
                                case $gred_cat->gred == 'DS53':
                                case $gred_cat->gred == 'DS54':
                                    return 9.0;
                                case $gred_cat->gred == 'VK7':
                                case $gred_cat->gred == 'VK6':
                                case $gred_cat->gred == 'VK5':
                                    return 9.0;
                            }
                        } else if ($kump_dept->id == 4) {
                            switch (true) {
                                case $gred_cat->gred == 'DG41':
                                case $gred_cat->gred == 'DG44':
                                    return 12.0;
                                case $gred_cat->gred == 'DG48':
                                case $gred_cat->gred == 'DG52':
                                    return 9.0;
                                case $gred_cat->gred == 'DG54':
                                    return 9.0;
                                case $gred_cat->gred == 'VK7':
                                case $gred_cat->gred == 'VK6':
                                case $gred_cat->gred == 'VK5':
                                    return 9.0;
                            }
                        } else if ($kump_dept->id == 6) {
                            switch (true) {
                                case $gred_cat->gred == 'DU51':
                                case $gred_cat->gred == 'DU52':
                                    return 9.0;
                                case $gred_cat->gred == 'DU54':
                                case $gred_cat->gred == 'DU56':
                                    return 9.0;
                                case $gred_cat->gred == 'VK7':
                                case $gred_cat->gred == 'VK6':
                                case $gred_cat->gred == 'VK5':
                                    return 9.0;
                            }
                        } else if ($kump_dept->id == 3) {
                            switch (true) {
                                case $gred_cat->gred == 'DS45':
                                    return 12.0;
                                case $gred_cat->gred == 'DS51':
                                case $gred_cat->gred == 'DS52':
                                    return 9.0;
                                case $gred_cat->gred == 'DS53':
                                case $gred_cat->gred == 'DS54':
                                    return 9.0;
                                case $gred_cat->gred == 'VK7':
                                case $gred_cat->gred == 'VK6':
                                case $gred_cat->gred == 'VK5':
                                    return 9.0;
                            }
                        }
                    } else if ($gred_cat->skimPerkhidmatan->id == 4) {
                        return 6.0;
                    }
                } else if ($aspek == 2) {
                    return 4.0;
                } else if ($aspek == 3 or $aspek == 4) {
                    return 1.0;
                }
                break;
            case 2:
                if ($aspek == 5) {
                    if ($kump_dept->id == 1 or $kump_dept->id == 2 or $kump_dept->id == 5) {
                        switch (true) {
                            case $gred_cat->gred == 'DS45':
                                return 1.0;
                            case $gred_cat->gred == 'DS51':
                            case $gred_cat->gred == 'DS52':
                                return 2.0;
                            case $gred_cat->gred == 'DS53':
                            case $gred_cat->gred == 'DS54':
                                return 3.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 4.0;
                        }
                    } else if ($kump_dept->id == 4) {
                        switch (true) {
                            case $gred_cat->gred == 'DG41':
                            case $gred_cat->gred == 'DG44':
                                return 0.0;
                            case $gred_cat->gred == 'DG48':

                                return 0.0;
                            case $gred_cat->gred == 'DG52':
                            case $gred_cat->gred == 'DG54':
                                return 3.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 4.0;
                        }
                    } else if ($kump_dept->id == 6) {
                        switch (true) {
                            case $gred_cat->gred == 'DU51':
                            case $gred_cat->gred == 'DU52':
                                return 2.0;
                            case $gred_cat->gred == 'DU54':
                            case $gred_cat->gred == 'DU56':
                                return 3.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 4.0;
                        }
                    } else if ($kump_dept->id == 3) {
                        switch (true) {
                            case $gred_cat->gred == 'DS45':
                                return 1.0;
                            case $gred_cat->gred == 'DS51':
                            case $gred_cat->gred == 'DS52':
                                return 2.0;
                            case $gred_cat->gred == 'DS53':
                            case $gred_cat->gred == 'DS54':
                                return 3.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 4.0;
                        }
                    }
                } else if ($aspek == 46) {
                    return 4.0;
                }
                break;
            case 3:
                if ($aspek == 6 || $aspek == 7 || $aspek == 8) {
                    if ($kump_dept->id == 1 or $kump_dept->id == 2 or $kump_dept->id == 5) {
                        switch (true) {
                            case $gred_cat->gred == 'DS45':
                                return 1.0;
                            case $gred_cat->gred == 'DS51':
                            case $gred_cat->gred == 'DS52':
                                return 2.0;
                            case $gred_cat->gred == 'DS53':
                            case $gred_cat->gred == 'DS54':
                                return 2.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 3.0;
                        }
                    } else if ($kump_dept->id == 4) {
                        switch (true) {
                            case $gred_cat->gred == 'DG41':
                            case $gred_cat->gred == 'DG44':
                                return 1.0;
                            case $gred_cat->gred == 'DG48':
                            case $gred_cat->gred == 'DG52':
                                return 2.0;

                            case $gred_cat->gred == 'DG54':
                                return 2.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 3.0;
                        }
                    } else if ($kump_dept->id == 6) {
                        switch (true) {
                            case $gred_cat->gred == 'DU51':
                            case $gred_cat->gred == 'DU52':
                                return 2.0;
                            case $gred_cat->gred == 'DU54':
                            case $gred_cat->gred == 'DU56':
                                return 2.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 3.0;
                        }
                    } else if ($kump_dept->id == 3) {
                        switch (true) {
                            case $gred_cat->gred == 'DS45':
                                return 1.0;
                            case $gred_cat->gred == 'DS51':
                            case $gred_cat->gred == 'DS52':
                                return 2.0;
                            case $gred_cat->gred == 'DS53':
                            case $gred_cat->gred == 'DS54':
                                return 2.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 3.0;
                        }
                    }
                } else if ($aspek == 9) {
                    return 300000.0;
                } else if ($aspek == 10) {
                    return 10.0;
                }
                break;
            case 4:
                if ($aspek == 11 || $aspek == 12 || $aspek == 13) {
                    if ($kump_dept->id == 1 or $kump_dept->id == 2 or $kump_dept->id == 5) {
                        switch (true) {
                            case $gred_cat->gred == 'DS45':
                                return 1.0;
                            case $gred_cat->gred == 'DS51':
                            case $gred_cat->gred == 'DS52':
                                return 2.0;
                            case $gred_cat->gred == 'DS53':
                            case $gred_cat->gred == 'DS54':
                                return 3.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 3.0;
                        }
                    } else if ($kump_dept->id == 4) {
                        switch (true) {
                            case $gred_cat->gred == 'DG41':
                            case $gred_cat->gred == 'DG44':
                                return 1.0;
                            case $gred_cat->gred == 'DG48':
                            case $gred_cat->gred == 'DG52':
                                return 2.0;

                            case $gred_cat->gred == 'DG54':
                                return 3.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 3.0;
                        }
                    } else if ($kump_dept->id == 6) {
                        switch (true) {
                            case $gred_cat->gred == 'DU51':
                            case $gred_cat->gred == 'DU52':
                                return 2.0;
                            case $gred_cat->gred == 'DU54':
                            case $gred_cat->gred == 'DU56':
                                return 3.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 3.0;
                        }
                    } else if ($kump_dept->id == 3) {
                        switch (true) {
                            case $gred_cat->gred == 'DS45':
                                return 2.0;
                            case $gred_cat->gred == 'DS51':
                            case $gred_cat->gred == 'DS52':
                                return 3.0;
                            case $gred_cat->gred == 'DS53':
                            case $gred_cat->gred == 'DS54':
                                return 4.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 4.0;
                        }
                    }
                }
                break;
            case 5:
                if ($aspek == 15 || $aspek == 16 || $aspek == 17) {
                    if ($kump_dept->id == 1 or $kump_dept->id == 2 or $kump_dept->id == 5) {
                        switch (true) {
                            case $gred_cat->gred == 'DS45':
                                return 1.0;
                            case $gred_cat->gred == 'DS51':
                            case $gred_cat->gred == 'DS52':
                                return 2.0;
                            case $gred_cat->gred == 'DS53':
                            case $gred_cat->gred == 'DS54':
                                return 2.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 3.0;
                        }
                    } else if ($kump_dept->id == 4) {
                        switch (true) {
                            case $gred_cat->gred == 'DG41':
                            case $gred_cat->gred == 'DG44':
                                return 1.0;
                            case $gred_cat->gred == 'DG48':
                            case $gred_cat->gred == 'DG52':
                                return 2.0;

                            case $gred_cat->gred == 'DG54':
                                return 2.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 3.0;
                        }
                    } else if ($kump_dept->id == 6) {
                        switch (true) {
                            case $gred_cat->gred == 'DU51':
                            case $gred_cat->gred == 'DU52':
                                return 2.0;
                            case $gred_cat->gred == 'DU54':
                            case $gred_cat->gred == 'DU56':
                                return 2.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 3.0;
                        }
                    } else if ($kump_dept->id == 3) {
                        switch (true) {
                            case $gred_cat->gred == 'DS45':
                                return 1.0;
                            case $gred_cat->gred == 'DS51':
                            case $gred_cat->gred == 'DS52':
                                return 2.0;
                            case $gred_cat->gred == 'DS53':
                            case $gred_cat->gred == 'DS54':
                                return 2.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 3.0;
                        }
                    }
                }
                break;
            case 6:
                if ($aspek == 18 || $aspek == 19 || $aspek == 20) {
                    switch (true) {
                        case $gred_cat->gred == 'DS45':
                        case $gred_cat->gred == 'DG41':
                        case $gred_cat->gred == 'DG44':
                            return 1.0;
                        case $gred_cat->gred == 'DS51':
                        case $gred_cat->gred == 'DS52':
                        case $gred_cat->gred == 'DG48':
                        case $gred_cat->gred == 'DG52':
                        case $gred_cat->gred == 'DU51':
                        case $gred_cat->gred == 'DU52':
                            return 2.0;
                        case $gred_cat->gred == 'DS53':
                        case $gred_cat->gred == 'DS54':
                        case $gred_cat->gred == 'DG54':
                        case $gred_cat->gred == 'DU54':
                        case $gred_cat->gred == 'DU56':
                            return 3.0;
                        case $gred_cat->gred == 'VK7':
                        case $gred_cat->gred == 'VK6':
                        case $gred_cat->gred == 'VK5':
                            return 4.0;
                    }
                } else {
                    return 25000.0;
                }
                break;
            case 7:
                if ($aspek == 22 || $aspek == 23 || $aspek == 24) {
                    switch (true) {
                        case $gred_cat->gred == 'DS45':
                        case $gred_cat->gred == 'DG41':
                        case $gred_cat->gred == 'DG44':
                            return 1.0;
                        case $gred_cat->gred == 'DS51':
                        case $gred_cat->gred == 'DS52':
                        case $gred_cat->gred == 'DG48':
                        case $gred_cat->gred == 'DG52':
                        case $gred_cat->gred == 'DU51':
                        case $gred_cat->gred == 'DU52':
                            return 2.0;
                        case $gred_cat->gred == 'DS53':
                        case $gred_cat->gred == 'DS54':
                        case $gred_cat->gred == 'DG54':
                        case $gred_cat->gred == 'DU54':
                        case $gred_cat->gred == 'DU56':
                            return 3.0;
                        case $gred_cat->gred == 'VK7':
                        case $gred_cat->gred == 'VK6':
                        case $gred_cat->gred == 'VK5':
                            return 4.0;
                    }
                } else {
                    return 25000.0;
                }
                break;
            case 8:
                return 1;
                break;
            case 9:
                if ($aspek == 31 || $aspek == 32 || $aspek == 33 || $aspek == 34 || $aspek == 35 || $aspek == 36 || $aspek == 37) {
                    if ($kump_dept->id == 1 or $kump_dept->id == 2 or $kump_dept->id == 5) {
                        switch (true) {
                            case $gred_cat->gred == 'DS45':
                                return 1.0;
                            case $gred_cat->gred == 'DS51':
                            case $gred_cat->gred == 'DS52':
                                return 2.0;
                            case $gred_cat->gred == 'DS53':
                            case $gred_cat->gred == 'DS54':
                                return 2.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 3.0;
                        }
                    } else if ($kump_dept->id == 4) {
                        switch (true) {
                            case $gred_cat->gred == 'DG41':
                            case $gred_cat->gred == 'DG44':
                                return 1.0;
                            case $gred_cat->gred == 'DG48':
                            case $gred_cat->gred == 'DG52':
                                return 2.0;
                            case $gred_cat->gred == 'DG54':
                                return 2.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 3.0;
                        }
                    } else if ($kump_dept->id == 6) {
                        switch (true) {
                            case $gred_cat->gred == 'DU51':
                            case $gred_cat->gred == 'DU52':
                                return 2.0;
                            case $gred_cat->gred == 'DU54':
                            case $gred_cat->gred == 'DU56':
                                return 2.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 3.0;
                        }
                    } else if ($kump_dept->id == 3) {
                        switch (true) {
                            case $gred_cat->gred == 'DS45':
                                return 1.0;
                            case $gred_cat->gred == 'DS51':
                            case $gred_cat->gred == 'DS52':
                                return 2.0;
                            case $gred_cat->gred == 'DS53':
                            case $gred_cat->gred == 'DS54':
                                return 2.0;
                            case $gred_cat->gred == 'VK7':
                            case $gred_cat->gred == 'VK6':
                            case $gred_cat->gred == 'VK5':
                                return 3.0;
                        }
                    }
                }
                break;
            case 11:
                if ($aspek == 43) {
                    return 300.0;
                } else if ($aspek == 45) {
                    return 1.0;
                }
                break;
        }
        return 1.0;
    }

    public function findMarkahBahagian($bhg_no, $lppid, $pemberat = null)
    {
        $lpp = TblMain::findOne(['lpp_id' => $lppid]);

        $query = RefAspekPenilaian::find()
            ->select(['`hrm`.`elnpt_v3_ref_aspek_penilaian`.`id`, `hrm`.`elnpt_v3_ref_aspek_penilaian`.`desc`, `hrm`.`elnpt_v3_ref_aspek_penilaian`.`aspek`, coalesce(`hrm`.`elnpt_v3_tbl_mrkh_aspek`.`skor`, 0) as skor, 
                    coalesce(`hrm`.`elnpt_v3_tbl_mrkh_aspek`.`markah_pyd`, 0) * 100 as markah_pyd,coalesce(`hrm`.`elnpt_v3_tbl_mrkh_aspek`.`markah_ppp`, 0) * 100 as markah_ppp, 
                    coalesce(`hrm`.`elnpt_v3_tbl_mrkh_aspek`.`markah_ppk`, 0) * 100 as markah_ppk, coalesce(`hrm`.`elnpt_v3_tbl_mrkh_aspek`.`markah_peer`, 0) * 100 as markah_peer, `hrm`.`elnpt_v3_ref_aspek_pemberat`.pemberat * 100 AS pemberat'])
            ->leftJoin('`hrm`.`elnpt_v3_tbl_mrkh_aspek`', '`hrm`.`elnpt_v3_tbl_mrkh_aspek`.aspek_id = `hrm`.`elnpt_v3_ref_aspek_penilaian`.id and `hrm`.`elnpt_v3_tbl_mrkh_aspek`.`lpp_id` = ' . $lppid . '')
            ->leftJoin('`hrm`.`elnpt_v3_ref_aspek_pemberat`', '`hrm`.`elnpt_v3_ref_aspek_pemberat`.aspek_id = `hrm`.`elnpt_v3_ref_aspek_penilaian`.id')
            ->andWhere(['`hrm`.`elnpt_v3_ref_aspek_penilaian`.`bhg_no`' => $bhg_no])
            ->orderBy('`hrm`.`elnpt_v3_ref_aspek_penilaian`.`id`')

            ->asArray()
            ->all();

        if (isset($pemberat)) {
            foreach ($query as $ind => $mn) {
                $query[$ind]['pemberat'] = $pemberat[$ind]['pemberat'];
            }
        }

        return $query;
    }

    public function calcOverallMark($lppid)
    {
        if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
            $lpp = TblMain::findOne(['lpp_id' => $lppid]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);

        $dept = TblKumpDept::find()->where(['dept_id' => $lpp->deptGuru->sub_of ?? $lpp->jfpiu])->asArray()->all();
        $dept1 = ArrayHelper::getColumn($dept, 'ref_kump_dept_id');
        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);
        $tamat_dt = $tahun->pengisian_PYD_tamat;
        $hasJawatan = Tblrscoadminpost::find()->where(['ICNO' => $lpp->PYD, 'paymentStatus' => 1, 'flag' => 1])->andWhere(['or', ['>', new Expression('TIMESTAMPDIFF(MONTH, start_date, \'' . \Yii::$app->formatter->asDate($tamat_dt, 'yyyy-MM-dd') . '\')'), 6], [
            'renew' => 1
        ]])->exists();
        $gred = RefGred::find()->where(['kump_gred' => ($hasJawatan && (in_array('1', $dept1) || in_array('2', $dept1) || in_array('6', $dept1) || in_array('3', $dept1) || in_array('5', $dept1))) ? $this->checkJawatanDeptKump($lpp->gredGuru->gred, $lpp->jfpiu, $lpp->gredGuru->gred_skim) : $lpp->gredGuru->gred])->one();

        $ex = TblException2::findOne([$lpp->lpp_id]);
        if (!is_null($ex)) {
            $dept = TblKumpDept::find()->where(['id' => $ex->tbl_kump_dept_id])->asArray()->all();
            $gred = RefGred::findOne([$ex->ref_gred_id]);
        }

        $bhgMrkh = TblMrkhAspek::find()
            ->select(['a.bhg_no, ROUND(CAST(SUM(markah_pyd) * (pemberat/100) AS DECIMAL(8, 5)), 4) as mrkh_bhg'])
            ->alias('a')
            ->rightJoin(['c' => 'hrm.elnpt_v3_ref_aspek_penilaian'], 'c.id = a.aspek_id')
            ->leftJoin(['b' => 'hrm.elnpt_v2_ref_pemberat_keseluruhan'], 'b.bahagian = a.bhg_no and a.lpp_id = ' . $lppid)
            ->where(['b.tbl_kump_dept_id' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), 'b.ref_gred_id' => $gred->id, 'b.`year`' => $lpp->tahun])
            ->groupBy('a.bhg_no');

        // $req = $this->checkRequest($lppid);

        if ((!is_null($bhgMrkh))) {

            $arry = $bhgMrkh->asArray()->all();
            $arry = ArrayHelper::index($arry, 'bhg_no');
            $this->getMarkahKualiti($lppid, $mrkh_ppp, $mrkh_ppk, $mrkh_peer, $lpp, $gred, $dept, $fin);
            ArrayHelper::setValue($arry, [10], ['bhg_no' => '10', 'mrkh_bhg' => strval($fin)]);
            ksort($arry);

            if (TblMrkhBhg::find()->where(['lpp_id' => $lppid])->all() != null) {
                $models = TblMrkhBhg::find()
                    ->alias('a')
                    ->rightJoin(['b' => 'hrm.elnpt_v2_ref_pemberat_keseluruhan'], 'b.bahagian = a.bhg_id and a.lpp_id = ' . $lppid)
                    ->where([
                        'b.tbl_kump_dept_id' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), 'b.ref_gred_id' => $gred->id, 'b.`year`' => $lpp->tahun
                    ])
                    ->indexBy('bhg_id')
                    ->all();
            } else {
                $models = [new TblMrkhBhg()];
                for ($i = 0; $i < sizeof($arry); $i++) {
                    $models[] = new TblMrkhBhg();
                }
            }
            $cnt = 0;
            $cnt = array_key_first($arry);

            // print_r($arry);

            foreach ($arry as $ind => $mb) {
                if (!isset($models[$cnt])) {
                    continue;
                    // $models[$cnt] = new TblMrkhBhg();
                }
                $models[$cnt]->lpp_id = $lppid;
                $models[$cnt]->bhg_id = $mb['bhg_no'];
                $models[$cnt]->markah = $mb['mrkh_bhg'];
                $models[$cnt]->save(false);
                $cnt++;
            }
        }
    }

    public function getMarkahKualiti($lppid, &$mrkh_ppp, &$mrkh_ppk, &$mrkh_peer, $lpp, $gred, $dept, &$final)
    {
        if ($waktu2 = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->all() != null) {
            $waktu2 = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->asArray()->all();

            $sum_ppp = 0;
            $sum_ppk = 0;
            $sum_peer = 0;

            foreach ($waktu2 as $ind => $wk) {
                $sum_ppp += $waktu2[$ind]['markah_ppp'];
                $sum_ppk += $waktu2[$ind]['markah_ppk'];
                $sum_peer += $waktu2[$ind]['markah_peer'];
            }

            $sum_ppp = $sum_ppp / 600 * 100;
            $sum_ppk = $sum_ppk / 600 * 100;
            $sum_peer = $sum_peer / 600 * 100;

            $pmberat_bhg9 = RefPemberatSeluruh::find()
                ->where(['tbl_kump_dept_id' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), 'ref_gred_id' => $gred->id, 'bahagian' => 10, 'year' => $lpp->tahun])
                ->one();

            $mrkh_ppp = ($sum_ppp * (($pmberat_bhg9->tbl_kump_dept_id == 3) ? 0.6 : 0.4));
            $mrkh_ppk = ($sum_ppk * (($pmberat_bhg9->tbl_kump_dept_id == 3) ? 0.6 : 0.4));
            $mrkh_peer = ($sum_peer * (($pmberat_bhg9->tbl_kump_dept_id == 3) ? 0.3 : 0.2));

            $total =  $mrkh_ppp +  $mrkh_ppk + $mrkh_peer;

            $final = ($pmberat_bhg9->tbl_kump_dept_id == 3) ? ((($total * 100) / ($pmberat_bhg9->pemberat * 100)) / 100) : (($total / 100) * $pmberat_bhg9->pemberat / 100);
        }
    }

    public function bahagian2($lppid)
    {
        $bhg = RefBahagian::findOne(2);
        $skor = RefSkorPenyeliaan::find()->asArray()->all();
        $aspek = RefAspekPenilaian::findAll(['bhg_no' => 2]);
        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 2])->asArray()->all();
        $mrkh_bhg = array();
        $mrkhbhg = array();
        $peratus = array();

        $lpp = $this->findLpp($lppid);

        $this->checkBahagian($lpp, $bhg->id);

        $this->dataBahagian2($lppid, $data, $penyeliaan, $utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);

        $tmp = array_merge_recursive($utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);

        foreach ($tmp as $id => $t) {
            ArrayHelper::setValue($tmpP, [$id, 'utama_belum'], is_array($tmp[$id]['utama_belum']) ? array_sum($tmp[$id]['utama_belum']) : $tmp[$id]['utama_belum']);
            ArrayHelper::setValue($tmpP, [$id, 'utama_telah_sem'], is_array($tmp[$id]['utama_telah_sem']) ? array_sum($tmp[$id]['utama_telah_sem']) : $tmp[$id]['utama_telah_sem']);
            ArrayHelper::setValue($tmpP, [$id, 'utama_telah'], is_array($tmp[$id]['utama_telah']) ? array_sum($tmp[$id]['utama_telah']) : $tmp[$id]['utama_telah']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_belum'], is_array($tmp[$id]['sama_belum']) ? array_sum($tmp[$id]['sama_belum']) : $tmp[$id]['sama_belum']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_telah_sem'], is_array($tmp[$id]['sama_telah_sem']) ? array_sum($tmp[$id]['sama_telah_sem']) : $tmp[$id]['sama_telah_sem']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_telah'], is_array($tmp[$id]['sama_telah']) ? array_sum($tmp[$id]['sama_telah']) : $tmp[$id]['sama_telah']);
        }

        $selia_arry = ArrayHelper::toArray($penyeliaan);

        foreach ($tmpP as $id => $tP) {
            switch ($id) {
                case 'MASTER':
                    $tP['tahap_penyeliaan'] = 2;
                    break;
                case 'PHD':
                    $tP['tahap_penyeliaan'] = 1;
                    break;
                case 'M.Phil.':
                    $tP['tahap_penyeliaan'] = 3;
                    break;
            }
            array_push($selia_arry, $tP);
        }

        // print_r($selia_arry);

        foreach ($selia_arry as $sa) {
            $sum = ($sa['utama_belum'] * $skor[$sa['tahap_penyeliaan'] - 1]['belum_utama']) + ($sa['utama_telah_sem'] * $skor[$sa['tahap_penyeliaan'] - 1]['telah_utama_sem']) + ($sa['utama_telah'] * $skor[$sa['tahap_penyeliaan'] - 1]['telah_utama']) + ($sa['sama_belum'] * $skor[$sa['tahap_penyeliaan'] - 1]['belum_sama']) + ($sa['sama_telah_sem'] * $skor[$sa['tahap_penyeliaan'] - 1]['telah_sama_sem']) + ($sa['sama_telah'] * $skor[$sa['tahap_penyeliaan'] - 1]['telah_sama']);
            ArrayHelper::setValue($mrkhbhg, $sa['tahap_penyeliaan'], ['skor' => $sum]);
        }

        ArrayHelper::setValue($tmppp, 5, array_sum(ArrayHelper::getColumn($mrkhbhg, 'skor')));
        ArrayHelper::setValue($tmppp, 46, 16.0);

        foreach ($pemberat as $p) {

            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $tmppp[$p['aspek_id']], 'markah_pyd' => (min($tmppp[$p['aspek_id']] / $this->getSasaran($bhg->id, $p['aspek_id'], $lpp->deptGuru->sub_of ?? $lpp->jfpiu, $lpp->gred_jawatan_id) * 70, 100) * ($p['pemberat'])) / 100]);
        }

        $this->setMarkahAspek($lppid, array_keys($tmppp), $mrkh_bhg, 2);

        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(2, $lppid), [], false);

        $this->calcOverallMark($lppid);
    }

    public function dataBahagian2($lppid, &$data, &$penyeliaan, &$utama_belum, &$utama_telah_sem, &$utama_telah, &$sama_belum, &$sama_telah_sem, &$sama_telah, &$init)
    {
        $lpp = $this->findLpp($lppid);
        $penyeliaan = TblPenyeliaanManual::find()
            // ->select(new Expression('id as AutoId, kod_kursus as SMP07_KodMP, nama_kursus as NAMAKURSUS, bil_pelajar as BILPELAJAR, sesi as SESI, jam_kredit as JAMKREDIT, \'1\' as DISPLAY, seksyen as SEKSYEN'))
            ->where(['lpp_id' => $lppid])
            ->orderBy(['tahap_penyeliaan' => 'SORT_ASC'])
            // ->indexBy('tahap_penyeliaan')
            // ->asArray()
            ->all();
        if ($penyeliaan == null) {
            $penyeliaan = [new TblPenyeliaanManual()];
            for ($i = 1; $i <= 2; $i++) {
                $penyeliaan[] = new TblPenyeliaanManual();
                $penyeliaan[$i]->lpp_id = $lppid;
                $penyeliaan[$i]->tahap_penyeliaan = 3 + $i;
            }
            unset($penyeliaan[0]);
        } else {
            if ($penyeliaan[0]->tahap_penyeliaan >= 6) {
                for ($i = 1; $i <= 2; $i++) {
                    $penyeliaan[] = new TblPenyeliaanManual();
                    $penyeliaan[$i]->lpp_id = $lppid;
                    $penyeliaan[$i]->tahap_penyeliaan = 3 + $i;
                    // $penyeliaan[$i]->tahap_penyeliaan = 3 + $i;
                }
            }
        }
        usort($penyeliaan, function ($a, $b) {
            return $a->tahap_penyeliaan <=> $b->tahap_penyeliaan;
        });
        // return VarDumper::dump($penyeliaan, $depth = 10, $highlight = true);
        $init = TblPenyeliaan::find()
            ->select(new Expression('DISTINCT(LevelPengajian), \'0\' as utama_belum, \'0\' as utama_telah_sem,  \'0\' as utama_telah, \'0\' as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->where(['!=', 'LevelPengajian', 'CERT'])
            ->indexBy('LevelPengajian')
            // ->asArray()
            ->all();
        $init = ArrayHelper::toArray($init);
        $filter = TblPenyeliaan::find()
            ->where(['NoKpPenyelia' => $lpp->PYD])
            ->orFilterWhere(['SMP28_NoStaf' => $lpp->guru->COOldID])
            ->orFilterWhere(['SMP20_Nama' => $lpp->guru->CONm])
            ->andWhere(['not in', '[KodStatusPengajian]', [24, 04, 58, 05, 59, 22]])
            ->andWhere(['like', '[KodSesi_Sem]', $lpp->tahun]);
        $max = TblPenyeliaan::find()
            ->select(['[Nomatrik] as aaa, [NamaPelajar] as fvfv, [NoKpPenyelia] as ccc, MAX(SUBSTRING(KodSesi_Sem, 8, 4)) AS [Kod],'
                . 'MAX(SUBSTRING(KodSesi_Sem, 8, 4) + SUBSTRING(KodSesi_Sem, 1, 1)) as asd'])
            ->from($filter)
            ->where(['NoKpPenyelia' => $lpp->PYD])
            ->orFilterWhere(['SMP28_NoStaf' => $lpp->guru->COOldID])
            ->orFilterWhere(['SMP20_Nama' => $lpp->guru->CONm])
            ->groupBy(['Nomatrik', 'NamaPelajar', 'NoKpPenyelia'])
            ->having(['OR', ['=', 'MAX(SUBSTRING(KodSesi_Sem, 8, 4))', $lpp->tahun], ['=', 'MAX(SUBSTRING(KodSesi_Sem, 3, 4))', $lpp->tahun]]);
        $data = TblPenyeliaan::find()
            ->innerJoin(['b' => $max], 'b.aaa = [dbo].[Ext_HR02_Penyeliaan].[Nomatrik] and b.ccc = [dbo].[Ext_HR02_Penyeliaan].[NoKpPenyelia]')
            ->andWhere(new Expression('b.asd = (SUBSTRING(KodSesi_Sem, 8, 4) + SUBSTRING(KodSesi_Sem, 1, 1))'))
            ->andWhere(['[dbo].[Ext_HR02_Penyeliaan].[KodTahapPenyeliaan]' => [1, 3, 5, 4, 2]])
            ->andWhere(['[dbo].[Ext_HR02_Penyeliaan].[KodStatusPengajian]' => [51, 52, 53, 54, 56, 57, 01, 31, 32, 33, 06, 16]])
            ->andWhere(['!=', 'LevelPengajian', 'CERT'])
            ->distinct();
        $utama_belum = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, COUNT(*) as utama_belum, \'0\' as utama_telah_sem,  \'0\' as utama_telah, \'0\' as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [1, 4, 2]])
            ->andWhere(['KodStatusPengajian' => [01, 31, 32, 33, 06, 16]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')
            // ->asArray()
            ->all();
        $utama_belum = ArrayHelper::toArray($utama_belum);
        $utama_telah_sem = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_belum, COUNT(*) as utama_telah_sem,  \'0\' as utama_telah, \'0\' as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [1, 4, 2]])
            ->andWhere(['KodStatusPengajian' => [51, 52]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')
            // ->asArray()
            ->all();
        $utama_telah_sem = ArrayHelper::toArray($utama_telah_sem);
        $utama_telah = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_belum, \'0\' as utama_telah_sem,  COUNT(*) as utama_telah, \'0\' as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [1, 4, 2]])
            ->andWhere(['KodStatusPengajian' => [53, 54, 56, 57]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')
            // ->asArray()
            ->all();
        $utama_telah = ArrayHelper::toArray($utama_telah);
        $sama_belum = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_belum, \'0\' as utama_telah_sem,  \'0\' as utama_telah, COUNT(*) as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [3, 5]])
            ->andWhere(['KodStatusPengajian' => [01, 31, 32, 33, 06, 16]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')
            // ->asArray()
            ->all();
        $sama_belum = ArrayHelper::toArray($sama_belum);
        $sama_telah_sem = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_belum, \'0\' as utama_telah_sem,  \'0\' as utama_telah,\'0\' as sama_belum,  COUNT(*) as sama_telah_sem,  \'0\' as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [3, 5]])
            ->andWhere(['KodStatusPengajian' => [51, 52]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')
            // ->asArray()
            ->all();
        $sama_telah_sem = ArrayHelper::toArray($sama_telah_sem);
        $sama_telah = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_belum, \'0\' as utama_telah_sem,  \'0\' as utama_telah,\'0\' as sama_belum,  \'0\' as sama_telah_sem,  COUNT(*) as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [3, 5]])
            ->andWhere(['KodStatusPengajian' => [53, 54, 56, 57]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')
            // ->asArray()
            ->all();
        $sama_telah = ArrayHelper::toArray($sama_telah);
    }

    public function bahagian3($lppid)
    {
        $bhg = RefBahagian::findOne(3);

        $lpp = $this->findLpp($lppid);

        $this->checkBahagian($lpp, $bhg->id);

        $this->dataBahagian3($lppid, $penyelidikan, $penyelidikan2, $grant);

        $total_penyelidikan = array_merge($penyelidikan, $penyelidikan2);

        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 3])->asArray()->all();

        $aspek = RefAspekPenilaian::findAll(['bhg_no' => 3]);

        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 3])->asArray()->all();

        $amount = array_sum(ArrayHelper::getColumn(array_filter($total_penyelidikan, function ($var) {
            return ($var['ver_by'] != '');
        }), 'Amount', $keepKeys = true));

        foreach (array_filter($total_penyelidikan, function ($var) {
            return ($var['ver_by'] != '');
        }) as $ind => $tp) {
            foreach (array_reverse($aspek_skor) as $as) {
                if ($as['aspek_id'] == 6) {
                    if (strcasecmp($tp['Peranan'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 7) {
                    if (strcasecmp($tp['Tahap_geran'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 8) {
                    if (($tp['Status_geran'] == 'Sedang Berjalan') || ($tp['Status_geran'] == 'Diberhentikan/Ditamatkan')) {
                        if ($tp['ExtraDuration'] > 0) {

                            ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => 0.5]);
                        } else {
                            ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => 1]);
                        }
                    }
                }
            }
        }

        ArrayHelper::setValue($tmp, 6, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['6', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 7, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['7', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 8, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['8', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 9, $amount);
        ArrayHelper::setValue($tmp, 10, $grant);

        foreach ($pemberat as $p) {
            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $tmp[$p['aspek_id']], 'markah_pyd' => (min($tmp[$p['aspek_id']] / $this->getSasaran($bhg->id, $p['aspek_id'], $lpp->deptGuru->sub_of ?? $lpp->jfpiu, $lpp->gred_jawatan_id) * 70, 100) * ($p['pemberat'])) / 100]);
        }

        $this->setMarkahAspek($lppid, array_keys($mrkh_bhg), $mrkh_bhg, 3);

        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(3, $lppid), [], false);

        $this->calcOverallMark($lppid);
    }

    public function dataBahagian3($lppid, &$penyelidikan, &$penyelidikan2, &$grant)
    {
        $lpp = $this->findLpp($lppid);

        $penyelidikan1 = TblPenyelidikan2::find()
            ->select(new Expression('ID, ProjectID, Title, Membership as Peranan, AgencyName, GrantLevelID as Tahap_geran, Amount, StartDate, EndDate, ResearchStatus as Status_geran, ExtensionNo as ExtraDuration, \'0\' as Display, \'\' as file_hash, \'SMP UMS\' as ver_by, \'SMP UMS\' as ver_dt'))
            ->where(['IC' => $lpp->PYD])
            ->andWhere(['AND', ['AND', ['<=', 'StartYear', $lpp->tahun], ['>=', 'EndYear', $lpp->tahun]], ['ResearchStatus' => ['Sedang Berjalan', 'Selesai']]])
            ->distinct()
            ->asArray()
            ->indexBy('ID')
            ->all();

        $penyelidikan2 = TblPenyelidikan2::find()
            ->select(new Expression('ID, ProjectID, Title, Membership as Peranan, AgencyName, GrantLevelID as Tahap_geran, Amount, StartDate, EndDate, ResearchStatus as Status_geran, ExtensionNo as ExtraDuration, \'0\' as Display, \'\' as file_hash, \'SMP UMS\' as ver_by, \'SMP UMS\' as ver_dt'))
            ->where(['AND', ['LIKE', 'Researchers', $lpp->guru->CONm], ['!=', 'Membership', 'Leader']])
            ->andWhere(['AND', ['AND', ['<=', 'StartYear', $lpp->tahun], ['>=', 'EndYear', $lpp->tahun]], ['ResearchStatus' => ['Sedang Berjalan', 'Selesai']]])
            ->distinct()
            ->asArray()
            ->indexBy('ID')
            ->all();

        $penyelidikan =  $penyelidikan1 + $penyelidikan2;

        $penyelidikan2 = TblPenyelidikanManual::find()
            ->select(new Expression('a.id as ID, projek_id as ProjectID, tajuk_projek as Title, peranan as Peranan, pembiaya as AgencyName, kategori_pembiaya as Tahap_geran, jumlah_biaya as Amount, mula as StartDate, tamat as EndDate, status as Status_geran, \'0\' as ExtraDuration, \'1\' as Display, b.filehash as file_hash, b.verified_by as ver_by, b.verified_dt as ver_dt'))
            ->alias('a')
            ->leftJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 3')
            ->where(['a.lpp_id' => $lppid])
            ->andWhere(['OR', ['YEAR(mula)' => $lpp->tahun], ['status' => 'Sedang Berjalan']])
            ->asArray()
            ->all();

        $grant = TblGrantApplication::find()
            ->where(['UserIC' => $lpp->PYD, 'tahun' => $lpp->tahun])
            ->count();
    }

    public function bahagian4($lppid)
    {
        $bhg = RefBahagian::findOne(4);

        $lpp = $this->findLpp($lppid);

        $this->checkBahagian($lpp, $bhg->id);

        $this->dataBahagian4($lppid, $publication);

        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 4])->asArray()->all();

        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 4])->asArray()->all();

        foreach ($publication as $ind => $tp) {
            foreach ($aspek_skor as $as) {
                if ($as['aspek_id'] == 11) {
                    if ((strcasecmp($tp['Bilangan_penerbitan'], 'Article') == 0)) {
                        if (strcasecmp($tp['Status_indeks'], 'Non-indexed') == 0) {
                            $publication[$ind]['Bilangan_penerbitan'] = 'Article (Non-Indexed)';
                        } else {
                            $publication[$ind]['Bilangan_penerbitan'] = 'Article (Indexed)';
                        }
                    }
                    if (strcasecmp($publication[$ind]['Bilangan_penerbitan'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 12) {
                    if (strcasecmp($tp['Status_penulis'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 13) {
                    if (strcasecmp($tp['Status_indeks'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 14) {
                    if (strcasecmp($tp['Status_penerbitan'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
            }
        }

        ArrayHelper::setValue($tmp, 11, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['11', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 12, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['12', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 13, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['13', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 14, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['14', 'skor'], $keepKeys = true)) : 0);



        foreach ($pemberat as $p) {
            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $tmp[$p['aspek_id']], 'markah_pyd' => (min($tmp[$p['aspek_id']] / $this->getSasaran($bhg->id, $p['aspek_id'], $lpp->deptGuru->sub_of ?? $lpp->jfpiu, $lpp->gred_jawatan_id) * 70, 100) * ($p['pemberat'])) / 100]);
        }

        $this->setMarkahAspek($lppid, array_keys($tmp), $mrkh_bhg, 4);

        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(4, $lppid), [], false);

        $this->calcOverallMark($lppid);
    }

    public function dataBahagian4($lppid, &$publication)
    {
        $lpp = $this->findLpp($lppid);

        $except = TblException::find()->select('tahun')->where(['lpp_id' => $lppid])->asArray()->all();

        // $except = [];

        $publication = TblLnptPublicationV2::find()
            ->select(new Expression('Keterangan_PublicationTypeID as Bilangan_penerbitan, Title, PublicationYear, KeteranganBI_WriterStatus as Status_penulis, IndexingDesc as Status_indeks, Keterangan_PublicationStatus as Status_penerbitan, PublicationMonth'))
            ->from('SMP_PPI.dbo.vw_LNPT_PublicationV2')
            ->where(['User_Ic' => $lpp->PYD])
            ->andWhere(['or', ['PublicationYear' => (empty($except) ? $lpp->tahun : ArrayHelper::getColumn($except, 'tahun', $keepKeys = true))], ['SubmissionYear' => (empty($except) ? $lpp->tahun : ArrayHelper::getColumn($except, 'tahun', $keepKeys = true))], ['AcceptanceYear' => (empty($except) ? $lpp->tahun : ArrayHelper::getColumn($except, 'tahun', $keepKeys = true))]])
            ->andWhere([
                'or', ['ApproveStatus' => 'V', 'Keterangan_PublicationStatus' => 'Published'],
                ['Keterangan_PublicationStatus' => [
                    'Paper Accepted'

                ]]
            ])
            ->asArray()
            ->all();
    }

    public function bahagian5($lppid)
    {
        $bhg = RefBahagian::findOne(5);

        $lpp = $this->findLpp($lppid);

        $this->checkBahagian($lpp, $bhg->id);

        $this->dataBahagian5($lppid, $conference, $persidangan);

        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 5])->asArray()->all();

        $aspek = RefAspekPenilaian::findAll(['bhg_no' => 5]);

        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 5])->asArray()->all();

        foreach (array_filter($conference, function ($var) {
            return (($var['ver_by'] != '') && ($var['StatusConference'] == 'Verified'));
        })  as $ind => $tp) {
            foreach ($aspek_skor as $as) {
                if ($as['aspek_id'] == 15) {
                    if (strcasecmp($tp['Bilangan_Persidangan_dan_Inovasi'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 16) {
                    if (strcasecmp($tp['Peranan_dalam_projek_Inovasi'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 17) {
                    if (strcasecmp($tp['Tahap_penyertaan'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
            }
        }

        ArrayHelper::setValue($tmp, 15, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['15', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 16, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['16', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 17, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['17', 'skor'], $keepKeys = true)) : 0);

        // print_r($tmp);

        foreach ($pemberat as $p) {
            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $tmp[$p['aspek_id']], 'markah_pyd' => (min($tmp[$p['aspek_id']] / $this->getSasaran($bhg->id, $p['aspek_id'], $lpp->deptGuru->sub_of ?? $lpp->jfpiu, $lpp->gred_jawatan_id) * 70, 100) * ($p['pemberat'])) / 100]);
        }

        $this->setMarkahAspek($lppid, array_keys($tmp), $mrkh_bhg, 5);

        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(5, $lppid), [], false);

        $this->calcOverallMark($lppid);
    }

    public function dataBahagian5($lppid, &$conference, &$persidangan)
    {
        $lpp = $this->findLpp($lppid);

        $conf = TblConference::find()
            ->select(['TajukPersidangan', 'Peranan', 'Peringkat', 'StatusConference'])
            ->where(['=', 'IC', $lpp->PYD])
            ->andWhere(['or', ['StartYear' => $lpp->tahun], ['SUBSTRING(Tamat, 7, 4)' => $lpp->tahun]])

            ->all();
        $conference = ArrayHelper::toArray($conf, [
            'app\models\elnpt\TblConference' => [
                'Bilangan_Persidangan_dan_Inovasi' => function () {
                    return 'PERSIDANGAN';
                },
                'ConferenceTitle' => function ($conf) {
                    return $conf->TajukPersidangan;
                },

                'Peranan_dalam_projek_Inovasi' => function ($conf) {
                    return $conf->Peranan;
                },

                'Tahap_penyertaan' => function ($conf) {
                    return $conf->Peringkat;
                },
                'Amaun_pengkomersialan' => function ($conf) {
                    return 0;
                },
                'id' => function ($conf) {
                    return 0;
                },
                'file_hash' => function ($conf) {
                    return '';
                },
                'ver_by' => function ($conf) {
                    return 'SMP UMS';
                },
                'ver_dt' => function ($conf) {
                    return 'SMP UMS';
                },
                'StatusConference'
            ],
        ]);

        $persidangan = TblPersidangan::find()
            ->select(new Expression('a.id, kategori as Bilangan_Persidangan_dan_Inovasi, nama_projek as ConferenceTitle,  peranan as Peranan_dalam_projek_Inovasi, tahap as Tahap_penyertaan, 0 as Amaun_pengkomersialan, b.filehash as file_hash, b.verified_by as ver_by, b.verified_dt as ver_dt'))
            ->alias('a')
            ->leftJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 5')
            ->where(['a.lpp_id' => $lppid])
            ->asArray()
            ->all();
    }

    public function bahagian6($lppid)
    {
        set_time_limit(800);
        $bhg = RefBahagian::findOne(6);

        $lpp = $this->findLpp($lppid);

        $this->checkBahagian($lpp, $bhg->id);

        $this->dataBahagian6($lppid, $conference, $manual, $manual2);

        $list = array_merge($conference, $manual2);

        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 6])->asArray()->all();

        $aspek = RefAspekPenilaian::findAll(['bhg_no' => 6]);

        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 6])->asArray()->all();

        foreach ($list  as $ind => $tp) {
            foreach ($aspek_skor as $as) {
                if ($as['aspek_id'] == 18) {
                    if (strcasecmp($tp['Bilangan_outreaching'], $as['desc']) == 0) {

                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 19) {
                    if (strcasecmp($tp['Peranan_outreaching'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 20) {
                    if (strcasecmp($tp['Tahap_outreaching'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
            }
        }

        ArrayHelper::setValue($tmp, 18, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['18', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 19, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['19', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 20, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['20', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 21, array_sum(ArrayHelper::getColumn($list, 'Amaun_outreaching')));



        foreach ($pemberat as $p) {
            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $tmp[$p['aspek_id']], 'markah_pyd' => (min($tmp[$p['aspek_id']] / $this->getSasaran($bhg->id, $p['aspek_id'], $lpp->deptGuru->sub_of ?? $lpp->jfpiu, $lpp->gred_jawatan_id) * 70, 100) * ($p['pemberat'])) / 100]);
        }

        $this->setMarkahAspek($lppid, array_keys($tmp), $mrkh_bhg, 6);

        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(6, $lppid), [], false);

        $this->calcOverallMark($lppid);
    }

    public function dataBahagian6($lppid, &$conference, &$manual, &$manual2)
    {
        $lpp = $this->findLpp($lppid);

        $perundingan = TblConsultation::find()
            ->where(['NoStaf' => $lpp->guru->COOldID])
            ->andwhere(['!=', '[ConsultationType]', 'Medical Consultation'])
            ->andWhere(['OR', ['>=', 'YEAR(TarikhMula)', $lpp->tahun], ['>=', 'YEAR(TarikhAkhit)', $lpp->tahun]])
            ->all();

        $conference = ArrayHelper::toArray($perundingan, [
            'app\models\elnpt\outreaching\TblConsultation' => [
                'Bilangan_outreaching' => function ($conf) {
                    return $conf->ConsultationType;
                },
                'Title' => function ($conf) {
                    return $conf->Tajuk;
                },

                'Peranan_outreaching' => function ($conf) {
                    return $conf->Keahlian;
                },

                'Tahap_outreaching' => function ($conf) {
                    return $conf->Peringkat;
                },
                'Amaun_outreaching' => function ($conf) {
                    return $conf->Jumlah;
                },
                'id' => function ($conf) {
                    return '0';
                },
                'file_hash' => function ($conf) {
                    return '';
                },
                'ver_by' => function ($conf) {
                    return 'SMP UMS';
                },
                'ver_dt' => function ($conf) {
                    return 'SMP UMS';
                },
            ],
        ]);

        $manual = TblOutreachingManual::find()
            ->select(new Expression('a.id, kategori as Bilangan_outreaching, nama_projek as Title, peranan as Peranan_outreaching, tahap_penyertaan as Tahap_outreaching'
                . ', amaun as Amaun_outreaching, b.filehash as file_hash, b.verified_by as ver_by, b.verified_dt as ver_dt'))
            ->alias('a')
            ->leftJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 6')
            ->where(['a.lpp_id' => $lppid])

            ->asArray()
            ->all();

        $manual2 = $manual;

        foreach ($manual as $ind => $mn) {
            switch ($mn['Amaun_outreaching']) {
                case 1:
                    $manual[$ind]['Amaun_outreaching'] = 'RM 1 - RM 5,000';
                    break;
                case 5001:
                    $manual[$ind]['Amaun_outreaching'] = 'RM 5 - RM 25,000';
                    break;
                case 25001:
                    $manual[$ind]['Amaun_outreaching'] = 'RM 21,001 dan ke atas';
                    break;
            }
        }
    }

    public function bahagian7($lppid)
    {
        $bhg = RefBahagian::findOne(7);

        $lpp = $this->findLpp($lppid);

        $this->checkBahagian($lpp, $bhg->id);

        $this->dataBahagian7($lppid, $urus_tadbir, $result);

        $list = array_merge($urus_tadbir, $result);

        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 7])->asArray()->all();

        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 7])->asArray()->all();

        foreach ($list  as $ind => $tp) {
            foreach ($aspek_skor as $as) {
                if ($as['aspek_id'] == 22) {
                    if (strcasecmp($tp['Bilangan_jawatankuasa'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 23) {
                    if (strcasecmp($tp['Peranan_jawatankuasa'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 24) {
                    if (strcasecmp($tp['Tahap_jawatankuasa'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
            }
        }

        ArrayHelper::setValue($tmp, 22, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['22', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 23, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['23', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 24, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['24', 'skor'], $keepKeys = true)) : 0);

        foreach ($pemberat as $p) {
            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $tmp[$p['aspek_id']], 'markah_pyd' => (min($tmp[$p['aspek_id']] / $this->getSasaran($bhg->id, $p['aspek_id'], $lpp->deptGuru->sub_of ?? $lpp->jfpiu, $lpp->gred_jawatan_id) * 70, 100) * ($p['pemberat'])) / 100]);
        }

        $this->setMarkahAspek($lppid, array_keys($tmp), $mrkh_bhg, 7);

        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(7, $lppid), [], false);

        $this->calcOverallMark($lppid);
    }

    public function dataBahagian7($lppid, &$urus_tadbir, &$result)
    {
        $lpp = $this->findLpp($lppid);
        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);
        $tamat_dt = $tahun->pengisian_PYD_tamat;
        $urus_tadbir = TblPengurusanPentadbiran::find()
            ->select(new Expression('a.id, kategori as Bilangan_jawatankuasa, nama_jawatan, peranan as Peranan_jawatankuasa, tahap_lantikan as Tahap_jawatankuasa, b.filehash as file_hash, b.verified_by as ver_by, b.verified_dt as ver_dt'))
            ->alias('a')
            ->rightJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 7')
            ->where(['a.lpp_id' => $lppid])
            ->asArray()
            ->all();
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
                    SELECT
                    '0'              AS `id`,
                    'Pentadbiran (Lantikan NC & ke atas)' as `Bilangan_jawatankuasa`,
          `a`.`description`   AS `nama_jawatan`,
          'Jawatan Berelaun di Universiti' AS `Peranan_jawatankuasa`,
          'Universiti' AS `Tahap_jawatankuasa`,
          `a`.`flag`            AS `flag`,
          '' as file_hash, 'SMP UMS' as ver_by, 'SMP UMS' as ver_dt
        FROM ((((`hronline`.`tblrscoadminpost` `a`
            LEFT JOIN `hronline`.`adminposition` `b`
                ON ((`a`.`adminpos_id` = `b`.`id`)))
            LEFT JOIN `hronline`.`jawatankategori` `c`
                ON ((`b`.`position_type` = `c`.`id`)))
            LEFT JOIN `hronline`.`department` `d`
                ON ((`a`.`dept_id` = `d`.`id`)))
            LEFT JOIN `hronline`.`campus` `e`
                ON ((`a`.`campus_id` = `e`.`campus_id`))
            LEFT JOIN `hronline`.`dept_cat` `f`
                ON ((`d`.`category_id` = `f`.`id`))) 
        WHERE 
        ((`a`.`ICNO` = '" . $lpp->PYD . "') AND (`a`.`paymentStatus`=1)) AND ((TIMESTAMPDIFF(MONTH, `a`.`start_date`, '" . $tamat_dt . "') > 6) AND (YEAR(`a`.`end_date`) >= '" . $lpp->tahun . "')) ORDER BY end_date DESC LIMIT 1");
        $result = $command->queryAll();
    }

    public function bahagian8($lppid)
    {
        $bhg = RefBahagian::findOne(8);

        $lpp = $this->findLpp($lppid);

        $this->checkBahagian($lpp, $bhg->id);

        $this->dataBahagian8($lppid, $pereka, $inovasi, $teknologi);

        $list = array_merge($pereka, $inovasi, $teknologi);

        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 8])->asArray()->all();

        $aspek = RefAspekPenilaian::findAll(['bhg_no' => 8]);

        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 8])->asArray()->all();

        foreach ($list as $ind => $tp) {
            foreach ($aspek_skor as $as) {
                if ($as['aspek_id'] == 25) {
                    if (strcasecmp($tp['Bilangan_Persidangan_dan_Inovasi'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 26) {
                    if (strcasecmp($tp['Peranan_dalam_projek_Inovasi'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 27) {
                    if (strcasecmp($tp['Tahap_penyertaan'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
            }
        }

        $arryGroup = ArrayHelper::index($aspek_skor, null, 'aspek_id');

        foreach (array_reverse($arryGroup['28']) as $as) {
            if (array_sum(ArrayHelper::getColumn($list, 'Bilangan_individu')) >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                break;
            }
        }

        foreach (array_reverse($arryGroup['29']) as $as) {
            if (array_sum(ArrayHelper::getColumn($list, 'Julat_amaun')) >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                break;
            }
        }

        ArrayHelper::setValue($tmp, 25, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['25', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 26, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['26', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 27, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['27', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 28, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['28', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 29, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['29', 'skor'], $keepKeys = true)) : 0);

        foreach ($pemberat as $p) {
            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $tmp[$p['aspek_id']], 'markah_pyd' => (min($tmp[$p['aspek_id']] / $this->getSasaran($bhg->id, $p['aspek_id'], $lpp->deptGuru->sub_of ?? $lpp->jfpiu, $lpp->gred_jawatan_id) * 70, 100) * ($p['pemberat'])) / 100]);
        }

        $this->setMarkahAspek($lppid, array_keys($tmp), $mrkh_bhg, 8);

        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(8, $lppid), [], false);

        $this->calcOverallMark($lppid);
    }

    public function dataBahagian8($lppid, &$pereka, &$inovasi, &$teknologi)
    {
        $lpp = $this->findLpp($lppid);

        $pereka = TblPertandinganPereka::find()
            ->select(new Expression('\'0\' as id, \'PERTANDINGAN INOVASI\' as Bilangan_Persidangan_dan_Inovasi, KodPereka as ConferenceTitle, Peranan as Peranan_dalam_projek_Inovasi, '
                . 'Tahap as Tahap_penyertaan, ISNULL(BilPenerimaImpak, 0) as Bilangan_individu, ISNULL(AmaunProjek, 0) as Julat_amaun, \'\' as file_hash, \'SMP UMS\' as ver_by, \'SMP UMS\' as ver_dt'))
            ->where(['NoIC' => $lpp->PYD, 'Tahun' => $lpp->tahun])
            ->asArray()
            ->all();

        $inovasi = TblInovasi::find()
            ->select(new Expression('\'0\' as id, ConsultationType as Bilangan_Persidangan_dan_Inovasi, Tajuk as ConferenceTitle, Keahlian as Peranan_dalam_projek_Inovasi, '
                . 'Peringkat as Tahap_penyertaan, ISNULL(BilPenerimaImpak, 0) as Bilangan_individu, ISNULL(Jumlah, 0) as Julat_amaun, \'\' as file_hash, \'SMP UMS\' as ver_by, \'SMP UMS\' as ver_dt'))
            ->where(['NoStaf' => $lpp->guru->COOldID])
            ->andWhere(['OR', ['>=', 'YEAR(TarikhMula)', $lpp->tahun], ['>=', 'YEAR(TarikhAkhit)', $lpp->tahun]])
            ->asArray()
            ->all();

        $teknologi = TblTeknologiInovasi::find()
            ->select(new Expression('a.id, kategori as Bilangan_Persidangan_dan_Inovasi, nama_projek as ConferenceTitle,  peranan as Peranan_dalam_projek_Inovasi, tahap_penyertaan as Tahap_penyertaan, bil_impak as Bilangan_individu, amaun as Julat_amaun, b.filehash as file_hash, b.verified_by as ver_by, b.verified_dt as ver_dt'))
            ->alias('a')
            ->leftJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 8')
            ->where(['a.lpp_id' => $lppid])
            ->asArray()
            ->all();
    }

    public function bahagian9($lppid)
    {
        $bhg = RefBahagian::findOne(9);

        $lpp = $this->findLpp($lppid);

        $this->checkBahagian($lpp, $bhg->id);

        $this->dataBahagian9($lppid, $bil_bhg2, $bil_bhg3, $bil_bhg4, $bil_bhg5, $bil_bhg6, $bil_bhg8);

        $bil_mentoring = ($bil_bhg2 * 0.3) + ($bil_bhg3 * 0.3) + ($bil_bhg4 * 0.4);

        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 9])->asArray()->all();

        $aspek = RefAspekPenilaian::find()->where(['bhg_no' => 9])->asArray()->indexBy('id')->all();

        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 9])->asArray()->all();
        switch (true) {
            case $lpp->gredGuru->gred == 'DG41':
            case $lpp->gredGuru->gred == 'DG44':
                $pemberat[0]['pemberat'] = 0;
                $pemberat[1]['pemberat'] = 0;
                $pemberat[2]['pemberat'] = 0.0;
                $pemberat[3]['pemberat'] = 0.5;
                $pemberat[4]['pemberat'] = 0.5;
                $pemberat[5]['pemberat'] = 0.05;
                $pemberat[6]['pemberat'] = 0.05;
                break;
            case $lpp->gredGuru->gred == 'DG48':
                $pemberat[0]['pemberat'] = 0;
                $pemberat[1]['pemberat'] = 0.0;
                $pemberat[2]['pemberat'] = 0.4;
                $pemberat[3]['pemberat'] = 0.3;
                $pemberat[4]['pemberat'] = 0.3;
                $pemberat[5]['pemberat'] = 0.05;
                $pemberat[6]['pemberat'] = 0.05;
                break;
            case $lpp->gredGuru->gred == 'DG52':
            case $lpp->gredGuru->gred == 'DG54':
                $pemberat[0]['pemberat'] = 0;
                $pemberat[1]['pemberat'] = 0.25;
                $pemberat[2]['pemberat'] = 0.25;
                $pemberat[3]['pemberat'] = 0.25;
                $pemberat[4]['pemberat'] = 0.25;
                $pemberat[5]['pemberat'] = 0.05;
                $pemberat[6]['pemberat'] = 0.05;
                break;
        }

        switch (true) {
            case $lpp->gredGuru->gred == 'DS45':
                $peratusGred = 20;
                $terpakai = false;
                break;
            case $lpp->gredGuru->gred == 'DG41':
            case $lpp->gredGuru->gred == 'DG44':
                $peratusGred = 20;
                $terpakai = false;
                break;
            case $lpp->gredGuru->gred == 'DG48':
                $peratusGred = 10;
                $terpakai = false;
                break;
            case $lpp->gredGuru->gred == 'DS51':
            case $lpp->gredGuru->gred == 'DS52':
            case $lpp->gredGuru->gred == 'DG52':
            case $lpp->gredGuru->gred == 'DU51':
            case $lpp->gredGuru->gred == 'DU52':
                $peratusGred = 10;
                $terpakai = false;
                break;
            case $lpp->gredGuru->gred == 'DS53':
            case $lpp->gredGuru->gred == 'DS54':
            case $lpp->gredGuru->gred == 'DG54':
            case $lpp->gredGuru->gred == 'DU54':
            case $lpp->gredGuru->gred == 'DU56':
            case $lpp->gredGuru->gred == 'UMSDF8':
            case $lpp->gredGuru->gred == 'VK7':
            case $lpp->gredGuru->gred == 'VK6':
            case $lpp->gredGuru->gred == 'VK5':
            case $lpp->gredGuru->gred == 'VU7':
            case $lpp->gredGuru->gred == 'VU6':
            case $lpp->gredGuru->gred == 'VU5':
                $peratusGred = 10;
                $terpakai = true;
                break;
            default:
                $peratusGred = 0;
                $terpakai = true;
        }

        $arryGroup = ArrayHelper::index($aspek_skor, null, 'aspek_id');

        foreach (array_reverse($arryGroup['30']) as $as) {
            if ($bil_bhg2 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }

        foreach (array_reverse($arryGroup['31']) as $as) {
            if ($bil_bhg3 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }

        foreach (array_reverse($arryGroup['32']) as $as) {
            if ($bil_bhg4 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }

        foreach (array_reverse($arryGroup['33']) as $as) {
            if ($bil_bhg5 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }

        foreach (array_reverse($arryGroup['34']) as $as) {
            if ($bil_bhg6 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }

        foreach (array_reverse($arryGroup['35']) as $as) {
            if ($bil_bhg8 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }

        foreach (array_reverse($arryGroup['36']) as $as) {
            if ($bil_mentoring >= intval($as['desc'])) {
                ($terpakai) ? ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]) : ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => 0]);
                break;
            }
        }

        ArrayHelper::setValue($tmp, 30, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['30', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg2, 'desc' => $aspek[30]['desc'], 'sumber' => 'Bahagian 2']);
        ArrayHelper::setValue($tmp, 31, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['31', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg3, 'desc' => $aspek[31]['desc'], 'sumber' => 'Bahagian 3']);
        ArrayHelper::setValue($tmp, 32, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['32', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg4, 'desc' => $aspek[32]['desc'], 'sumber' => 'Bahagian 4']);
        ArrayHelper::setValue($tmp, 33, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['33', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg5, 'desc' => $aspek[33]['desc'], 'sumber' => 'Bahagian 5']);
        ArrayHelper::setValue($tmp, 34, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['34', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg6, 'desc' => $aspek[34]['desc'], 'sumber' => 'Bahagian 6']);
        ArrayHelper::setValue($tmp, 35, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['35', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg8, 'desc' => $aspek[35]['desc'], 'sumber' => 'Bahagian 8']);
        ArrayHelper::setValue($tmp, 36, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['36', 'skor'], $keepKeys = true)) : 0, 'bilangan' => (round($bil_mentoring)), 'desc' => $aspek[36]['desc'], 'sumber' => 'Bahagian 2, 3 & 4']);

        foreach ($pemberat as $p) {
            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $tmp[$p['aspek_id']]['skor'], 'markah_pyd' => (min($tmp[$p['aspek_id']]['bilangan'] / $this->getSasaran($bhg->id, $p['aspek_id'], $lpp->deptGuru->sub_of ?? $lpp->jfpiu, $lpp->gred_jawatan_id) * 70, 100) * ($p['pemberat'])) / 100]);
        }

        $this->setMarkahAspek($lppid, array_keys($tmp), $mrkh_bhg, 9);

        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(9, $lppid, $pemberat), [], false);

        foreach ($mrkhBhg as $ind => $mb) {
            $mrkhBhg[$ind]['pemberat'] =  number_format($pemberat[$ind]['pemberat'] * 100, 2);
        }

        $this->calcOverallMark($lppid);
    }

    public function dataBahagian9(
        $lppid,
        &$bil_bhg2,
        &$bil_bhg3,
        &$bil_bhg4,
        &$bil_bhg5,
        &$bil_bhg6,
        &$bil_bhg8
    ) {
        $lpp = $this->findLpp($lppid);

        $tmp1 = TblPenyeliaanManual::find()->select(new Expression('SUM(utama_belum+utama_telah_sem+utama_telah) AS total'))->where(['lpp_id' => $lppid]);

        // if ($lpp->PYD != Yii::$app->user->identity->ICNO) {
        //     $tmp1->andWhere(['and', ['IS NOT', 'verified_by', null], ['IS NOT', 'verified_dt', null]]);
        // }

        $bil_penyeliaan_manual = intval($tmp1->asArray()->one()['total']);

        $init = TblPenyeliaan::find()
            ->select(new Expression('DISTINCT(LevelPengajian), \'0\' as utama_belum, \'0\' as utama_telah_sem,  \'0\' as utama_telah, \'0\' as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->where(['!=', 'LevelPengajian', 'CERT'])
            ->indexBy('LevelPengajian')

            ->all();

        $max = TblPenyeliaan::find()
            ->select(['[Nomatrik] as aaa, [NamaPelajar] as fvfv, [NoKpPenyelia] as ccc, MAX(SUBSTRING(KodSesi_Sem, 8, 4)) AS [Kod],'
                . 'MAX(SUBSTRING(KodSesi_Sem, 8, 4) + SUBSTRING(KodSesi_Sem, 1, 1)) as asd'])
            ->where(['NoKpPenyelia' => $lpp->PYD])
            ->groupBy(['Nomatrik', 'NamaPelajar', 'NoKpPenyelia'])
            ->having(['OR', ['=', 'MAX(SUBSTRING(KodSesi_Sem, 8, 4))', $lpp->tahun], ['=', 'MAX(SUBSTRING(KodSesi_Sem, 3, 4))', $lpp->tahun]]);

        $data = TblPenyeliaan::find()
            ->innerJoin(['b' => $max], 'b.aaa = [dbo].[Ext_HR02_Penyeliaan].[Nomatrik] and b.ccc = [dbo].[Ext_HR02_Penyeliaan].[NoKpPenyelia]')
            ->andWhere(new Expression('b.asd = (SUBSTRING(KodSesi_Sem, 8, 4) + SUBSTRING(KodSesi_Sem, 1, 1))'))
            ->andWhere(['[dbo].[Ext_HR02_Penyeliaan].[KodTahapPenyeliaan]' => [1, 3, 5, 4, 2]])
            ->andWhere(['[dbo].[Ext_HR02_Penyeliaan].[KodStatusPengajian]' => [51, 52, 53, 54, 56, 57, 01, 31, 32, 33, 06, 16]])
            ->andWhere(['!=', 'LevelPengajian', 'CERT'])
            ->distinct();

        $utama_belum = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, COUNT(*) as utama_belum, \'0\' as utama_telah_sem,  \'0\' as utama_telah, \'0\' as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [1, 4, 2]])
            ->andWhere(['KodStatusPengajian' => [01, 31, 32, 33, 06, 16]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')

            ->all();

        $utama_belum = ArrayHelper::toArray($utama_belum);

        $utama_telah_sem = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_belum, COUNT(*) as utama_telah_sem,  \'0\' as utama_telah, \'0\' as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [1, 4, 2]])
            ->andWhere(['KodStatusPengajian' => [51, 52]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')

            ->all();

        $utama_telah_sem = ArrayHelper::toArray($utama_telah_sem);

        $utama_telah = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_belum, \'0\' as utama_telah_sem,  COUNT(*) as utama_telah, \'0\' as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [1, 4, 2]])
            ->andWhere(['KodStatusPengajian' => [53, 54, 56, 57]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')

            ->all();

        $utama_telah = ArrayHelper::toArray($utama_telah);

        $tmp = array_merge_recursive($utama_belum, $utama_telah_sem, $utama_telah, $init);

        foreach ($tmp as $id => $t) {
            ArrayHelper::setValue($tmpP, [$id, 'utama_belum'], is_array($tmp[$id]['utama_belum']) ? array_sum($tmp[$id]['utama_belum']) : $tmp[$id]['utama_belum']);
            ArrayHelper::setValue($tmpP, [$id, 'utama_telah_sem'], is_array($tmp[$id]['utama_telah_sem']) ? array_sum($tmp[$id]['utama_telah_sem']) : $tmp[$id]['utama_telah_sem']);
            ArrayHelper::setValue($tmpP, [$id, 'utama_telah'], is_array($tmp[$id]['utama_telah']) ? array_sum($tmp[$id]['utama_telah']) : $tmp[$id]['utama_telah']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_belum'], is_array($tmp[$id]['sama_belum']) ? array_sum($tmp[$id]['sama_belum']) : $tmp[$id]['sama_belum']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_telah_sem'], is_array($tmp[$id]['sama_telah_sem']) ? array_sum($tmp[$id]['sama_telah_sem']) : $tmp[$id]['sama_telah_sem']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_telah'], is_array($tmp[$id]['sama_telah']) ? array_sum($tmp[$id]['sama_telah']) : $tmp[$id]['sama_telah']);
        }

        $bil_penyeliaan  = 0;

        foreach ($tmpP as $tP) {
            $bil_penyeliaan += $tP['utama_belum'] + $tP['utama_telah_sem'] + $tP['utama_telah'];
        }

        $bil_bhg2 = $bil_penyeliaan + $bil_penyeliaan_manual;

        $penyelidikan = TblPenyelidikan2::find()
            ->where(['IC' => $lpp->PYD])
            ->andWhere(['AND', ['AND', ['<=', 'StartYear', $lpp->tahun], ['>=', 'EndYear', $lpp->tahun]], ['ResearchStatus' => ['Sedang Berjalan', 'Selesai']]])
            ->andWhere(['Membership' => ['Ketua', 'Leader']])
            ->count();

        $tmp2 = TblPenyelidikanManual::find()
            ->alias('a')
            ->leftJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 3')
            ->where(['a.lpp_id' => $lppid])
            ->andWhere(['OR', ['YEAR(mula)' => $lpp->tahun], ['status' => 'Sedang Berjalan']])
            ->andWhere(['peranan' => ['Ketua', 'Leader']]);

        // if ($lpp->PYD != Yii::$app->user->identity->ICNO) {
        //     $tmp2->andWhere(['and', ['not', ['b.verified_by' => null]], ['not', ['b.verified_dt' => null]]]);
        // }

        $penyelidikan2 = $tmp2->count();

        $bil_bhg3 = $penyelidikan + $penyelidikan2;

        $except = TblException::find()->select('tahun')->where(['lpp_id' => $lppid])->asArray()->all();

        $bil_bhg4 = TblLnptPublicationV2::find()
            ->where(['User_Ic' => $lpp->PYD])
            ->andWhere(['or', ['PublicationYear' => (empty($except) ? $lpp->tahun : ArrayHelper::getColumn($except, 'tahun', $keepKeys = true))], ['SubmissionYear' => (empty($except) ? $lpp->tahun : ArrayHelper::getColumn($except, 'tahun', $keepKeys = true))], ['AcceptanceYear' => (empty($except) ? $lpp->tahun : ArrayHelper::getColumn($except, 'tahun', $keepKeys = true))]])
            ->andWhere([
                'or', ['ApproveStatus' => 'V', 'Keterangan_PublicationStatus' => 'Published'],
                ['Keterangan_PublicationStatus' => [
                    'Paper Accepted'

                ]]
            ])
            ->andWhere(['KeteranganBI_WriterStatus' => ['Chief Editor', 'First Author', 'Corresponding Author']])
            ->count();

        $confer = TblConference::find()
            ->where(['IC' => $lpp->PYD])
            ->andWhere(['StatusConference' => 'Verified'])
            ->andWhere(['or', ['StartYear' => $lpp->tahun], ['SUBSTRING(Tamat, 7, 4)' => $lpp->tahun]])
            ->andWhere(['Peranan' => ['Ketua', 'Pembentang', 'Pengerusi Sesi', 'Keynote Speaker', 'Panel', 'Ketua Sesi', 'Pembentang Poster', 'Pembentang Jemputan', 'Pengerusi']])
            ->count();

        $persidangan = TblPersidangan::find()
            ->select(new Expression('a.id, kategori as Bilangan_Persidangan_dan_Inovasi, nama_projek as ConferenceTitle,  peranan as Peranan_dalam_projek_Inovasi, tahap as Tahap_penyertaan, 0 as Amaun_pengkomersialan, b.filehash as file_hash, b.verified_by as ver_by, b.verified_dt as ver_dt'))
            ->alias('a')
            ->leftJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 5')
            ->where(['a.lpp_id' => $lppid])
            ->andWhere(['Peranan' => ['Ketua', 'Pembentang', 'Pengerusi Sesi', 'Keynote Speaker', 'Panel', 'Ketua Sesi', 'Pembentang Poster', 'Pembentang Jemputan', 'Pengerusi']])
            ->andWhere(['and', ['not', ['b.verified_by' => null]], ['not', ['b.verified_dt' => null]]])
            ->count();

        $bil_bhg5 = $confer + $persidangan;

        $perundingan = TblConsultation::find()
            ->where(['NoStaf' => $lpp->guru->COOldID])
            ->andwhere(['!=', '[ConsultationType]', 'Medical Consultation'])
            ->andWhere(['OR', ['>=', 'YEAR(TarikhMula)', $lpp->tahun], ['>=', 'YEAR(TarikhAkhit)', $lpp->tahun]])
            ->andWhere(['Keahlian' => [
                'Ketua',
                'Pengerusi Jawatankuasa',
                'Pengerusi Viva Voce (PASCASISWAZAH)',
                'Leader',

            ]])
            ->count();

        $tmp3 = TblOutreachingManual::find()
            ->alias('a')
            ->select(new Expression('id, kategori as Bilangan_outreaching, nama_projek as Title, peranan as Peranan_outreaching, tahap_penyertaan as Tahap_outreaching'
                . ', amaun as Amaun_outreaching'))

            ->leftJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 6')
            ->where(['a.lpp_id' => $lppid])
            ->andWhere(['peranan' => [
                'Ketua',
                'Pengerusi Jawatankuasa',
                'Pengerusi Viva Voce (PASCASISWAZAH)',
                'Leader',

            ]]);

        // if ($lpp->PYD != Yii::$app->user->identity->ICNO) {
        //     $tmp3->andWhere(['and', ['not', ['b.verified_by' => null]], ['not', ['b.verified_dt' => null]]]);
        // }

        $manual = $tmp3->count();

        $bil_bhg6 = $perundingan + $manual;

        $pereka = TblPertandinganPereka::find()
            ->where(['NoIC' => $lpp->PYD, 'Tahun' => $lpp->tahun])
            ->andWhere(['Peranan' => ['Ketua', 'Leader']])
            ->count();

        $inovasi = TblInovasi::find()
            ->where(['NoStaf' => $lpp->guru->COOldID])
            ->andWhere(['OR', ['>=', 'YEAR(TarikhMula)', $lpp->tahun], ['>=', 'YEAR(TarikhAkhit)', $lpp->tahun]])
            ->andWhere(['Keahlian' => ['Ketua', 'Leader']])
            ->count();

        $tmp4 = TblTeknologiInovasi::find()
            ->select(new Expression('a.id, kategori as Bilangan_Persidangan_dan_Inovasi, nama_projek as ConferenceTitle,  peranan as Peranan_dalam_projek_Inovasi, tahap_penyertaan as Tahap_penyertaan, bil_impak as Bilangan_individu, amaun as Julat_amaun, b.filehash as file_hash, b.verified_by as ver_by, b.verified_dt as ver_dt'))
            ->alias('a')
            ->leftJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 8')
            ->where(['a.lpp_id' => $lppid]);

        // if ($lpp->PYD != Yii::$app->user->identity->ICNO) {
        //     $tmp4->andWhere(['and', ['not', ['b.verified_by' => null]], ['not', ['b.verified_dt' => null]]]);
        // }

        $teknologi = $tmp4->count();

        $bil_bhg8 = $pereka + $inovasi + $teknologi;
    }

    public function checkJawatanDeptKump($gred, $dept_id, $gred_skim)
    {
        $dept = TblKumpDept::find()->where(['ref_kump_dept_id' => 6])->asArray()->all();
        $dept1 = ArrayHelper::getColumn($dept, 'dept_id');
        if (in_array($dept_id, $dept1)) {
            switch ($gred) {
                case $gred->gred == 'VK7':
                case $gred->gred == 'VK6':
                case $gred->gred == 'VK5':
                    return 'JAWATAN-VK';
            }
            if ($gred_skim == 'DU') {
                return 'JAWATAN-VK';
            }
        }
        return 'JAWATAN';
    }

    public function actionSimulateKategori($lppid)
    {
        // $this->kategori1($lppid);
        // $this->kategori2($lppid);
        // $this->kategori3($lppid);
        // $this->kategori4($lppid);
        // $this->kategori5($lppid);
        $this->kategori1_2($lppid);
        $this->kategori3_4($lppid);
        $this->kategori5_5($lppid);
        $lpp = TblMain::findOne(['lpp_id' => $lppid]);
        if ($this->isClinical($lpp->jfpiu)) {
        }
    }

    public function kategori1($lppid)
    {
        $sasaranHakiki = 22.75;
        $sasaranNonHakiki = 9.75;

        $lpp = $this->findLpp($lppid);

        $this->dataBahagian1($lppid, $pengajaran, $pengajaran2, $pnp, $all);

        $listt = $pengajaran + $pengajaran2;

        foreach ($listt as $ind => $p) {
            ArrayHelper::setValue($dataKomponen1, [$ind, 1], ['skor' => floatval($p['JAMKREDIT'] ?? 0)]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 2], ['skor' => floatval($p['pk07'])]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 3], ['skor' => $p['status'] == 'Pass' ? 1 : 0]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 4], ['skor' => $p['status_fail'] == 'Ada - Lengkap' ? 1 : 0]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 5], ['skor' => 0]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 6], ['skor' => floatval($p['bil_pelajar'] ?? 0)]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 7], ['skor' => 0]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 8], ['skor' => 0]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 9], ['skor' => 0]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 10], ['skor' => 0]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 11], ['skor' => 0]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 12], ['skor' => 0]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 13], ['skor' => 0]);
        }

        $mataKomponen1 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 1, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();

        foreach ($mataKomponen1 as $ind => $mk1) {
            $tmp = ArrayHelper::getColumn($dataKomponen1, [$ind, 'skor'], $keepKeys = true);
            if ($ind == 2) {
                ArrayHelper::setValue($inputKomponen1, $ind, number_format(array_sum($tmp) / count($tmp), 1));
                continue;
            }
            ArrayHelper::setValue($inputKomponen1, $ind,  number_format(array_sum($tmp), 1));
        }

        $n = 50;

        foreach ($mataKomponen1 as $ind => $mk1) {
            if ($ind == 6) {
                ArrayHelper::setValue($skorKomponen1, $ind, ($inputKomponen1[$ind] / $n) * $mk1['nilai_mata']);
                continue;
            }
            ArrayHelper::setValue($skorKomponen1, $ind, $inputKomponen1[$ind] * $mk1['nilai_mata']);
        }

        $totalMata1 = array_sum(array_slice($skorKomponen1, 0, 5, true));
        $sasaran1 = $sasaranHakiki * $this->multiplier($lpp->gredGuru->gred);
        $mataHakiki = min($totalMata1, $sasaran1);
        $limpahanHakiki = $totalMata1 - $mataHakiki;

        $skorKomponen1[sizeof($mataKomponen1)] = min($limpahanHakiki, 1 / 3 * $sasaranNonHakiki);
        $totalMata2 = array_sum(array_slice($skorKomponen1, (6 - 1), sizeof($skorKomponen1), true));
        $sasaran2 = $sasaranNonHakiki * $this->multiplier($lpp->gredGuru->gred);
        $mataNonHakiki = min($totalMata2, $sasaran2);

        $sim = $this->findSimulasi($lppid, 1);
        $sim->lpp_id = $lppid;
        $sim->kategori_id = 1;
        $sim->mata_1 = $totalMata1;
        $sim->mata_2 = $totalMata2;
        $sim->sasaran_1 = $sasaran1;
        $sim->sasaran_2 = $sasaran2;
        $sim->mata_hakiki = $mataHakiki;
        $sim->mata_non_hakiki = $mataNonHakiki;
        $sim->limpahan_hakiki = $limpahanHakiki;
        $sim->sub_jumlah = $mataHakiki + $mataNonHakiki;
        $sim->isElaun = 0;
        $sim->save(false);
        return;
    }

    public function kategori2($lppid)
    {
        $sasaranHakiki = 12.5;
        $sasaranNonHakiki = 5.36;

        $lpp = $this->findLpp($lppid);

        $this->dataBahagian2($lppid, $data, $penyeliaan, $utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);
        $tmp = array_merge_recursive($utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);
        foreach ($tmp as $id => $t) {
            ArrayHelper::setValue($tmp2, [$id, 'utama_belum'], is_array($tmp[$id]['utama_belum']) ? array_sum($tmp[$id]['utama_belum']) : $tmp[$id]['utama_belum']);
            ArrayHelper::setValue($tmp2, [$id, 'utama_telah_sem'], is_array($tmp[$id]['utama_telah_sem']) ? array_sum($tmp[$id]['utama_telah_sem']) : $tmp[$id]['utama_telah_sem']);
            ArrayHelper::setValue($tmp2, [$id, 'utama_telah'], is_array($tmp[$id]['utama_telah']) ? array_sum($tmp[$id]['utama_telah']) : $tmp[$id]['utama_telah']);
            ArrayHelper::setValue($tmp2, [$id, 'sama_belum'], is_array($tmp[$id]['sama_belum']) ? array_sum($tmp[$id]['sama_belum']) : $tmp[$id]['sama_belum']);
            ArrayHelper::setValue($tmp2, [$id, 'sama_telah_sem'], is_array($tmp[$id]['sama_telah_sem']) ? array_sum($tmp[$id]['sama_telah_sem']) : $tmp[$id]['sama_telah_sem']);
            ArrayHelper::setValue($tmp2, [$id, 'sama_telah'], is_array($tmp[$id]['sama_telah']) ? array_sum($tmp[$id]['sama_telah']) : $tmp[$id]['sama_telah']);
        }
        $selia = ArrayHelper::toArray($penyeliaan,  [
            'app\models\elnpt\elnpt2\TblPenyeliaanManual' => [
                'utama_belum',
                'utama_telah_sem',
                'utama_telah',
                'sama_belum',
                'sama_telah_sem',
                'sama_telah',
                'tahap_penyeliaan',
            ],
        ]);
        foreach ($tmp2 as $id => $_tmp2) {
            switch ($id) {
                case 'MASTER':
                    $_tmp2['tahap_penyeliaan'] = 2;
                    break;
                case 'PHD':
                    $_tmp2['tahap_penyeliaan'] = 1;
                    break;
                case 'M.Phil.':
                    $_tmp2['tahap_penyeliaan'] = 3;
                    break;
            }
            array_push($selia, $_tmp2);
        }
        $selia = ArrayHelper::index($selia, 'tahap_penyeliaan');

        ArrayHelper::setValue($inputKomponen1, [1, 1], ['skor' => $selia[1]['utama_belum'] + $selia[1]['utama_telah_sem'] + $selia[1]['utama_telah']]);
        ArrayHelper::setValue($inputKomponen1, [1, 2], ['skor' => $selia[1]['sama_belum'] + $selia[1]['sama_telah_sem'] + $selia[1]['sama_telah']]);
        ArrayHelper::setValue($inputKomponen1, [2, 1], ['skor' => $selia[3]['utama_belum'] + $selia[3]['utama_telah_sem'] + $selia[3]['utama_telah']]);
        ArrayHelper::setValue($inputKomponen1, [2, 2], ['skor' => $selia[3]['sama_belum'] + $selia[3]['sama_telah_sem'] + $selia[3]['sama_telah']]);
        ArrayHelper::setValue($inputKomponen1, [5, 1], ['skor' => $selia[5]['utama_belum'] + $selia[5]['utama_telah_sem'] + $selia[5]['utama_telah']]);
        ArrayHelper::setValue($inputKomponen1, [5, 2], ['skor' => $selia[5]['sama_belum'] + $selia[5]['sama_telah_sem'] + $selia[5]['sama_telah']]);

        ArrayHelper::setValue($inputKomponen1, [6, 1], ['skor' => $selia[4]['utama_belum'] + $selia[4]['utama_telah_sem'] + $selia[4]['utama_telah']]);
        ArrayHelper::setValue($inputKomponen1, [6, 2], ['skor' => $selia[4]['sama_belum'] + $selia[4]['sama_telah_sem'] + $selia[4]['sama_telah']]);

        $mataKomponen1 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 2, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();
        $mataKomponen2 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 2, 'nilai_mata_id' => 2])->indexBy(['aktiviti_id'])->asArray()->all();

        ArrayHelper::setValue($skorKomponen1, 1,  $inputKomponen1[1][1]['skor'] * $mataKomponen1[1]['nilai_mata'] + $inputKomponen1[1][2]['skor'] * $mataKomponen2[1]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 2,  $inputKomponen1[2][1]['skor'] * $mataKomponen1[2]['nilai_mata'] + $inputKomponen1[2][2]['skor'] * $mataKomponen2[2]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 3,  $inputKomponen1[5][1]['skor'] * $mataKomponen1[5]['nilai_mata'] + $inputKomponen1[5][2]['skor'] * $mataKomponen2[5]['nilai_mata']);

        ArrayHelper::setValue($skorKomponen1, 6,  $inputKomponen1[6][1]['skor'] * $mataKomponen1[6]['nilai_mata'] + $inputKomponen1[6][2]['skor'] * $mataKomponen2[6]['nilai_mata']);

        $skorKomponen1 = $this->fillMissingKeys($skorKomponen1, $mataKomponen2);

        $totalMata1 = array_sum(array_slice($skorKomponen1, 0, 5, true));
        $sasaran1 = $sasaranHakiki * $this->multiplier($lpp->gredGuru->gred);
        $mataHakiki = min($totalMata1, $sasaran1);
        $limpahanHakiki = $totalMata1 - $mataHakiki;

        $skorKomponen1[sizeof($mataKomponen1)] = min($limpahanHakiki, 1 / 3 * $sasaranNonHakiki);
        $totalMata2 = array_sum(array_slice($skorKomponen1, (6 - 1), sizeof($skorKomponen1), true));
        $sasaran2 = $sasaranNonHakiki * $this->multiplier($lpp->gredGuru->gred);
        $mataNonHakiki = min($totalMata2, $sasaran2);

        $sim = $this->findSimulasi($lppid, 2);
        $sim->lpp_id = $lppid;
        $sim->kategori_id = 2;
        $sim->mata_1 = $totalMata1;
        $sim->mata_2 = $totalMata2;
        $sim->sasaran_1 = $sasaran1;
        $sim->sasaran_2 = $sasaran2;
        $sim->mata_hakiki = $mataHakiki;
        $sim->mata_non_hakiki = $mataNonHakiki;
        $sim->limpahan_hakiki = $limpahanHakiki;
        $sim->sub_jumlah = $mataHakiki + $mataNonHakiki;
        $sim->isElaun = 0;
        $sim->save(false);
        return;
    }

    public function kategori3($lppid)
    {
        $sasaranHakiki = 12;
        $sasaranNonHakiki = 5;

        $lpp = $this->findLpp($lppid);

        $this->dataBahagian3($lppid, $penyelidikan, $penyelidikan2, $grant);
        $list = array_merge($penyelidikan, $penyelidikan2);

        /*
        tahap_geran: 1(uni)
        */
        ArrayHelper::setValue($inputKomponen1, [1, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Tahap_geran'] == 1 && $element['Peranan'] == 'Leader';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [1, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Tahap_geran'] == 1 && $element['Peranan'] == 'Member';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [2, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Tahap_geran'] == 2 && $element['Peranan'] == 'Leader';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [2, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Tahap_geran'] == 2 && $element['Peranan'] == 'Member';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [3, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Tahap_geran'] == 3 && $element['Peranan'] == 'Leader';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [3, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Tahap_geran'] == 3 && $element['Peranan'] == 'Member';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [4, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                if ($element['Tahap_geran'] == 1 && $element['Peranan'] == 'Leader') {
                    return $element['Amount'];
                }
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [4, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                if ($element['Tahap_geran'] == 1 && $element['Peranan'] == 'Member') {
                    return $element['Amount'];
                }
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [5, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                if ($element['Tahap_geran'] == 2 && $element['Peranan'] == 'Leader') {
                    return $element['Amount'];
                }
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [5, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                if ($element['Tahap_geran'] == 2 && $element['Peranan'] == 'Member') {
                    return $element['Amount'];
                }
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [6, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                if ($element['Tahap_geran'] == 3 && $element['Peranan'] == 'Leader') {
                    return $element['Amount'];
                }
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [6, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                if ($element['Tahap_geran'] == 3 && $element['Peranan'] == 'Member') {
                    return $element['Amount'];
                }
            })
        )]);

        $mataKomponen1 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 3, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();
        $mataKomponen2 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 3, 'nilai_mata_id' => 2])->indexBy(['aktiviti_id'])->asArray()->all();

        $base = 10000;

        ArrayHelper::setValue($skorKomponen1, 1,  $inputKomponen1[1][1]['skor'] * $mataKomponen1[1]['nilai_mata'] + $inputKomponen1[1][2]['skor'] * $mataKomponen2[1]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 2,  $inputKomponen1[2][1]['skor'] * $mataKomponen1[2]['nilai_mata'] + $inputKomponen1[2][2]['skor'] * $mataKomponen2[2]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 3,  $inputKomponen1[3][1]['skor'] * $mataKomponen1[3]['nilai_mata'] + $inputKomponen1[3][2]['skor'] * $mataKomponen2[3]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 4, ($inputKomponen1[4][1]['skor'] / $base) * $mataKomponen1[4]['nilai_mata'] + ($inputKomponen1[4][2]['skor'] / $base) * $mataKomponen2[4]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 5, ($inputKomponen1[5][1]['skor'] / $base) * $mataKomponen1[5]['nilai_mata'] + ($inputKomponen1[5][2]['skor'] / $base) * $mataKomponen2[5]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 6, ($inputKomponen1[6][1]['skor'] / $base) * $mataKomponen1[6]['nilai_mata'] + ($inputKomponen1[6][2]['skor'] / $base) * $mataKomponen2[6]['nilai_mata']);

        $totalMata1 = array_sum($skorKomponen1);
        $sasaran1 = $sasaranHakiki * $this->multiplier($lpp->gredGuru->gred);
        $mataHakiki = min($totalMata1, $sasaran1);
        $limpahanHakiki = $totalMata1 - $mataHakiki;

        $skorKomponen2[8] = min($limpahanHakiki, 1 / 3 * $sasaranNonHakiki);
        $totalMata2 = array_sum($skorKomponen2);
        $sasaran2 = $sasaranNonHakiki * $this->multiplier($lpp->gredGuru->gred);
        $mataNonHakiki = min($totalMata2, $sasaran2);

        $sim = $this->findSimulasi($lppid, 3);
        $sim->lpp_id = $lppid;
        $sim->kategori_id = 3;
        $sim->mata_1 = $totalMata1;
        $sim->mata_2 = $totalMata2;
        $sim->sasaran_1 = $sasaran1;
        $sim->sasaran_2 = $sasaran2;
        $sim->mata_hakiki = $mataHakiki;
        $sim->mata_non_hakiki = $mataNonHakiki;
        $sim->limpahan_hakiki = $limpahanHakiki;
        $sim->sub_jumlah = $mataHakiki + $mataNonHakiki;
        $sim->isElaun = 0;
        $sim->save(false);
        return;
    }

    public function kategori4($lppid)
    {
        $sasaranHakiki = 11;
        $sasaranNonHakiki = 5;

        $lpp = $this->findLpp($lppid);

        $this->dataBahagian4($lppid, $publication);

        ArrayHelper::setValue($inputKomponen1, [2, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                $q1 = [1, 2, 3];
                return ($element['Status_penulis'] == 'Corresponding Author' || $element['Status_penulis'] == 'First Author') && in_array($element['PublicationMonth'],  $q1) && $element['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [3, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                $q1 = [4, 5, 6];
                return ($element['Status_penulis'] == 'Corresponding Author' || $element['Status_penulis'] == 'First Author') && in_array($element['PublicationMonth'],  $q1) && $element['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [4, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                $q1 = [7, 8, 9];
                return ($element['Status_penulis'] == 'Corresponding Author' || $element['Status_penulis'] == 'First Author') && in_array($element['PublicationMonth'],  $q1) && $element['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [5, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                $q1 = [10, 11, 12];
                return ($element['Status_penulis'] == 'Corresponding Author' || $element['Status_penulis'] == 'First Author') && in_array($element['PublicationMonth'],  $q1) && $element['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)';
            })
        )]);

        ArrayHelper::setValue($inputKomponen1, [10, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                return $element['Status_indeks'] != 'High-Indexed (SCOPUS, WOS, ERA)';
            })
        )]);

        //selain hakiki
        ArrayHelper::setValue($inputKomponen1, [13, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                $q1 = [1, 2, 3];
                return $element['Status_penulis'] == 'Collaborative Author' && in_array($element['PublicationMonth'],  $q1) && $element['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [14, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                $q1 = [4, 5, 6];
                return $element['Status_penulis'] == 'Collaborative Author' && in_array($element['PublicationMonth'],  $q1) && $element['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [15, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                $q1 = [7, 8, 9];
                return $element['Status_penulis'] == 'Collaborative Author' && in_array($element['PublicationMonth'],  $q1) && $element['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [16, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                $q1 = [10, 11, 12];
                return $element['Status_penulis'] == 'Collaborative Author' && in_array($element['PublicationMonth'],  $q1) && $element['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)';
            })
        )]);

        ArrayHelper::setValue($inputKomponen1, [20, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                return $element['Status_indeks'] == 'Indexing (Mycite)';
            })
        )]);

        $mataKomponen1 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 4, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();
        $mataKomponen2 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 4, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();

        ArrayHelper::setValue($skorKomponen1, 2,  $inputKomponen1[2][1]['skor'] * $mataKomponen1[2]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 3,  $inputKomponen1[3][1]['skor'] * $mataKomponen1[3]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 4,  $inputKomponen1[4][1]['skor'] * $mataKomponen1[4]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 5, $inputKomponen1[5][1]['skor'] * $mataKomponen1[5]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 10, $inputKomponen1[10][1]['skor'] * $mataKomponen1[10]['nilai_mata']);

        ArrayHelper::setValue($skorKomponen1, 13,  $inputKomponen1[13][1]['skor'] * 2.5 / 2);
        ArrayHelper::setValue($skorKomponen1, 14,  $inputKomponen1[14][1]['skor'] * 2.5 / 1);
        ArrayHelper::setValue($skorKomponen1, 15,  $inputKomponen1[15][1]['skor'] * 2.5 / 2);
        ArrayHelper::setValue($skorKomponen1, 16, $inputKomponen1[16][1]['skor'] * 2.5 / 2);

        ArrayHelper::setValue($skorKomponen1, 20, $inputKomponen1[16][1]['skor'] * 0.5 / 2);

        $skorKomponen1 = $this->fillMissingKeys($skorKomponen1, $mataKomponen1);

        // print_r($inputKomponen1[2]);
        // return;

        $totalMata1 = array_sum(array_slice($skorKomponen1, 0, 11, true));
        $sasaran1 = $sasaranHakiki * $this->multiplier($lpp->gredGuru->gred);
        $mataHakiki = min($totalMata1, $sasaran1);
        $limpahanHakiki = $totalMata1 - $mataHakiki;

        $skorKomponen2[8] = min($limpahanHakiki, 1 / 3 * $sasaranNonHakiki);
        $totalMata2 = array_sum(array_slice($skorKomponen1, 11, sizeof($skorKomponen1), true));
        $sasaran2 = $sasaranNonHakiki * $this->multiplier($lpp->gredGuru->gred);
        $mataNonHakiki = min($totalMata2, $sasaran2);

        $sim = $this->findSimulasi($lppid, 4);
        $sim->lpp_id = $lppid;
        $sim->kategori_id = 4;
        $sim->mata_1 = $totalMata1;
        $sim->mata_2 = $totalMata2;
        $sim->sasaran_1 = $sasaran1;
        $sim->sasaran_2 = $sasaran2;
        $sim->mata_hakiki = $mataHakiki;
        $sim->mata_non_hakiki = $mataNonHakiki;
        $sim->limpahan_hakiki = $limpahanHakiki;
        $sim->sub_jumlah = $mataHakiki + $mataNonHakiki;
        $sim->isElaun = 0;
        $sim->save(false);
        return;
    }

    public function kategori5($lppid)
    {
        $sasaranHakikiElaun = 42;
        $sasaranNonHakikiElaun = 18;
        $sasaranHakikiNonElaun = 9;
        $sasaranNonHakikiNonElaun = 4;

        $lpp = $this->findLpp($lppid);

        $this->dataBahagian7($lppid, $urus_tadbir, $result);
        $list = array_merge($urus_tadbir, $result);

        $this->dataBahagian6($lppid, $conference, $manual, $manual2);
        $list2 = array_merge($conference, $manual2);

        $statusElaun = false;

        ArrayHelper::setValue($inputKomponen1, [1, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) use (&$statusElaun) {
                $statusElaun = true;
                return $element['Peranan_jawatankuasa'] == 'Jawatan Berelaun di Universiti' && (str_contains($element['nama_jawatan'], 'Canselor'));
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [2, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element)  use (&$statusElaun) {
                $statusElaun = true;
                return $element['Peranan_jawatankuasa'] == 'Jawatan Berelaun di Universiti' && (str_contains($element['nama_jawatan'], 'Dekan') || str_contains($element['nama_jawatan'], 'Pengarah'));
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [3, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) use (&$statusElaun) {
                $statusElaun = true;
                return $element['Peranan_jawatankuasa'] == 'Jawatan Berelaun di Universiti' && (str_contains($element['nama_jawatan'], 'Program') || str_contains($element['nama_jawatan'], 'Penyelaras'));
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [4, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element)  use (&$statusElaun) {
                $statusElaun = true;
                return $element['Peranan_jawatankuasa'] == 'Jawatan Berelaun di Universiti' && (str_contains($element['nama_jawatan'], 'Jabatan') || str_contains($element['nama_jawatan'], 'Unit'));
            })
        )]);

        //
        ArrayHelper::setValue($inputKomponen2, [17, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Bilangan_jawatankuasa'] == 'Badan Professional (Akademik)' && $element['Tahap_jawatankuasa'] == 'Kebangsaan' && $element['Peranan_jawatankuasa'] == 'Ketua';
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [17, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Bilangan_jawatankuasa'] == 'Badan Professional (Akademik)' && $element['Tahap_jawatankuasa'] == 'Kebangsaan' && $element['Peranan_jawatankuasa'] == 'Penyelaras';
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [17, 3], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Bilangan_jawatankuasa'] == 'Badan Professional (Akademik)' && $element['Tahap_jawatankuasa'] == 'Kebangsaan' && $element['Peranan_jawatankuasa'] == 'Ahli';
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [18, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Bilangan_jawatankuasa'] == 'Badan Professional (Akademik)' && $element['Tahap_jawatankuasa'] == 'Antarabangsa' && $element['Peranan_jawatankuasa'] == 'Ketua';
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [18, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Bilangan_jawatankuasa'] == 'Badan Professional (Akademik)' && $element['Tahap_jawatankuasa'] == 'Antarabangsa'  && $element['Peranan_jawatankuasa'] == 'Penyelaras';
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [18, 3], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Bilangan_jawatankuasa'] == 'Badan Professional (Akademik)' && $element['Tahap_jawatankuasa'] == 'Antarabangsa' && $element['Peranan_jawatankuasa'] == 'Ahli';
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [19, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list2, function ($element) {
                return $element['Bilangan_outreaching'] == 'Consultation' && ($element['Tahap_outreaching'] == 'National' || $element['Tahap_outreaching'] == 'Kebangsaan') && ($element['Peranan_outreaching'] == 'Leader' || $element['Peranan_outreaching'] == 'Professional Service');
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [19, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list2, function ($element) {
                return $element['Bilangan_outreaching'] == 'Consultation' && ($element['Tahap_outreaching'] == 'National' || $element['Tahap_outreaching'] == 'Kebangsaan') && ($element['Peranan_outreaching'] == '1');
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [19, 3], ['skor' => array_sum(
            ArrayHelper::getColumn($list2, function ($element) {
                return $element['Bilangan_outreaching'] == 'Consultation' && ($element['Tahap_outreaching'] == 'National' || $element['Tahap_outreaching'] == 'Kebangsaan') && ($element['Peranan_outreaching'] == 'Member');
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [20, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list2, function ($element) {
                return $element['Bilangan_outreaching'] == 'Consultation' && ($element['Tahap_outreaching'] == 'International' || $element['Tahap_outreaching'] == 'Antarabangsa') && ($element['Peranan_outreaching'] == 'Leader' || $element['Peranan_outreaching'] == 'Professional Service');
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [20, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list2, function ($element) {
                return $element['Bilangan_outreaching'] == 'Consultation' && ($element['Tahap_outreaching'] == 'International' || $element['Tahap_outreaching'] == 'Antarabangsa') && ($element['Peranan_outreaching'] == '1');
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [20, 3], ['skor' => array_sum(
            ArrayHelper::getColumn($list2, function ($element) {
                return $element['Bilangan_outreaching'] == 'Consultation' && ($element['Tahap_outreaching'] == 'International' || $element['Tahap_outreaching'] == 'Antarabangsa') && ($element['Peranan_outreaching'] == 'Member');
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [27, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return ($element['Bilangan_jawatankuasa'] == 'Badan Professional (Akademik)' || $element['Bilangan_jawatankuasa'] == 'Badan Bukan Kerajaan (Akademik)') && $element['Peranan_jawatankuasa'] == 'Ketua';
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [27, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return ($element['Bilangan_jawatankuasa'] == 'Badan Professional (Akademik)' || $element['Bilangan_jawatankuasa'] == 'Badan Bukan Kerajaan (Akademik)') && $element['Peranan_jawatankuasa'] == 'Penyelaras';
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [27, 3], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return ($element['Bilangan_jawatankuasa'] == 'Badan Professional (Akademik)' || $element['Bilangan_jawatankuasa'] == 'Badan Bukan Kerajaan (Akademik)') && $element['Peranan_jawatankuasa'] == 'Ahli';
            })
        )]);

        $mataKomponen2_1 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 5, 'nilai_mata_id' => 1])->asArray()->indexBy('aktiviti_id')->all();
        $mataKomponen2_2 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 5, 'nilai_mata_id' => 2])->asArray()->indexBy('aktiviti_id')->all();
        $mataKomponen2_3 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 5, 'nilai_mata_id' => 3])->asArray()->indexBy('aktiviti_id')->all();

        ArrayHelper::setValue($skorKomponen1, 1,  $inputKomponen1[1][1]['skor'] * $mataKomponen2_1[1]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 2,  $inputKomponen1[2][1]['skor'] * $mataKomponen2_1[2]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 3,  $inputKomponen1[3][1]['skor'] * $mataKomponen2_1[3]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 4, $inputKomponen1[4][1]['skor'] * $mataKomponen2_1[4]['nilai_mata']);

        ArrayHelper::setValue($skorKomponen1, 17,  $inputKomponen2[17][1]['skor'] * $mataKomponen2_1[17]['nilai_mata'] + $inputKomponen2[17][2]['skor'] * $mataKomponen2_2[17]['nilai_mata'] + $inputKomponen2[17][3]['skor'] * $mataKomponen2_3[17]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 18,  $inputKomponen2[18][1]['skor'] * $mataKomponen2_1[18]['nilai_mata'] + $inputKomponen2[18][2]['skor'] * $mataKomponen2_2[18]['nilai_mata'] + $inputKomponen2[18][3]['skor'] * $mataKomponen2_3[18]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 19,  $inputKomponen2[19][1]['skor'] * $mataKomponen2_1[19]['nilai_mata'] + $inputKomponen2[19][2]['skor'] * $mataKomponen2_2[19]['nilai_mata'] + $inputKomponen2[19][3]['skor'] * $mataKomponen2_3[19]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 20,  $inputKomponen2[20][1]['skor'] * $mataKomponen2_1[20]['nilai_mata'] + $inputKomponen2[20][2]['skor'] * $mataKomponen2_2[20]['nilai_mata'] + $inputKomponen2[20][3]['skor'] * $mataKomponen2_3[20]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 27,  $inputKomponen2[27][1]['skor'] * $mataKomponen2_1[27]['nilai_mata'] + $inputKomponen2[27][2]['skor'] * $mataKomponen2_2[27]['nilai_mata'] + $inputKomponen2[27][3]['skor'] * $mataKomponen2_3[27]['nilai_mata']);

        $skorKomponen1 = $this->fillMissingKeys($skorKomponen1, $mataKomponen2_1);

        $totalMata1 = array_sum(array_slice($skorKomponen1, 0, 9, true));
        $sasaran1 = ($statusElaun ? $sasaranHakikiElaun : $sasaranHakikiNonElaun) * $this->multiplier($lpp->gredGuru->gred);
        $mataHakiki = min($totalMata1, $sasaran1);
        $limpahanHakiki = $totalMata1 - $mataHakiki;

        $skorKomponen1[8] = min($limpahanHakiki, 1 / 3 * $statusElaun ? $sasaranNonHakikiElaun : $sasaranNonHakikiNonElaun);
        $totalMata2 = array_sum(array_slice($skorKomponen1, 9, sizeof($skorKomponen1), true));
        $sasaran2 = ($statusElaun ? $sasaranNonHakikiElaun : $sasaranNonHakikiNonElaun) * $this->multiplier($lpp->gredGuru->gred);
        $mataNonHakiki = min($totalMata2, $sasaran2);

        $sim = $this->findSimulasi($lppid, 5);
        $sim->lpp_id = $lppid;
        $sim->kategori_id = 5;
        $sim->mata_1 = $totalMata1;
        $sim->mata_2 = $totalMata2;
        $sim->sasaran_1 = $sasaran1;
        $sim->sasaran_2 = $sasaran2;
        $sim->mata_hakiki = $mataHakiki;
        $sim->mata_non_hakiki = $mataNonHakiki;
        $sim->limpahan_hakiki = $limpahanHakiki;
        $sim->sub_jumlah = $mataHakiki + $mataNonHakiki;
        $sim->isElaun = $statusElaun;
        $sim->save(false);

        TblSimulasiDec::updateAll(['isElaun' => $statusElaun], 'lpp_id = ' . $lppid . ' and kategori_id in (1,2,3,4)');
        TblSimulasiDec::updateAll(['jumlah_1' => $this->totalJumlah5Kategori($lppid, $lpp->gredGuru->gred, $statusElaun)], 'lpp_id = ' . $lppid . ' and kategori_id in (1,2,3,4,5)');
        return;
    }

    protected function multiplier($gred)
    {
        switch ($gred) {
            case 'DS45':
                return 1;
                break;
            case 'DS52':
                return 1.2;
                break;
            case 'DS51':
                return 1.2;
                break;
            case 'DU51':
                return 1.2;
                break;
            case 'DU52':
                return 1.2;
                break;
            case 'DS54':
                return 1.4;
                break;
            case 'DS53':
                return 1.4;
                break;
            case 'DU53':
                return 1.4;
                break;
            case 'DU54':
                return 1.4;
                break;
            case 'DU55':
                return 1.4;
                break;
            case 'DU56':
                return 1.4;
                break;
            case 'VK7':
                return 1.6;
                break;
            case 'VK6':
                return 1.8;
                break;
            case 'VK5':
                return 2;
                break;

            default:
                return 1;
                break;
        }
    }

    protected function findSimulasi($lppid, $kategori_id)
    {
        if (($model = TblSimulasiDec::findOne(['lpp_id' => $lppid, 'kategori_id' => $kategori_id])) !== null) {
            return $model;
        }

        return $model = new TblSimulasiDec();
    }

    protected function findSimulasiJan($lppid, $kategori_id)
    {
        if (($model = TblSimulasiJan::findOne(['lpp_id' => $lppid, 'kategori_id' => $kategori_id])) !== null) {
            return $model;
        }

        return $model = new TblSimulasiJan();
    }

    protected function fillMissingKeys($skor, $mata)
    {
        $u = $skor + array_fill_keys(
            range(
                min(array_keys($skor), 1),
                max(array_keys($mata))
            ),
            ''
        );
        ksort($u);
        return $u;
    }

    public function kategori1_2($lppid)
    {
        $sasaranHakiki = 35.25;
        $sasaranNonHakiki = 15.11;

        $lpp = $this->findLpp($lppid);

        $this->calcKategori1($lppid, $lpp, $skorKomponen1Kat1, $mataKomponen1Kat1);
        $this->calcKategori2($lppid, $lpp, $skorKomponen1Kat2, $mataKomponen1Kat2);

        $totalMata1 = array_sum(array_slice($skorKomponen1Kat1, 0, 5, true)) + array_sum(array_slice($skorKomponen1Kat2, 0, 5, true));
        $sasaran1 = $sasaranHakiki * $this->multiplier($lpp->gredGuru->gred);
        $mataHakiki = min($totalMata1, $sasaran1);
        $limpahanHakiki = $totalMata1 - $mataHakiki;

        $skorKomponen1Kat2[sizeof($mataKomponen1Kat2)] = min($limpahanHakiki, 1 / 3 * $sasaranNonHakiki);
        $totalMata2 = array_sum(array_slice($skorKomponen1Kat1, (6 - 1), sizeof($skorKomponen1Kat1), true)) + array_sum(array_slice($skorKomponen1Kat2, (6 - 1), sizeof($skorKomponen1Kat2), true));

        $sasaran2 = $sasaranNonHakiki * $this->multiplier($lpp->gredGuru->gred);
        $mataNonHakiki = min($totalMata2, $sasaran2);

        $sim = $this->findSimulasiJan($lppid, 2);
        $sim->lpp_id = $lppid;
        $sim->kategori_id = 2;
        $sim->mata_1 = $totalMata1;
        $sim->mata_2 = $totalMata2;
        $sim->sasaran_1 = $sasaran1;
        $sim->sasaran_2 = $sasaran2;
        $sim->mata_hakiki = $mataHakiki;
        $sim->mata_non_hakiki = $mataNonHakiki;
        $sim->limpahan_hakiki = $limpahanHakiki;
        $sim->sub_jumlah = $mataHakiki + $mataNonHakiki;
        $sim->isElaun = 0;
        $sim->save(false);
        return;
    }

    public function kategori3_4($lppid)
    {
        $sasaranHakiki = 23;
        $sasaranNonHakiki = 10;

        $lpp = $this->findLpp($lppid);

        $this->calcKategori3($lppid, $lpp, $skorKomponen1Kat1, $mataKomponen1Kat1);
        $this->calcKategori4($lppid, $lpp, $skorKomponen1Kat2, $mataKomponen1Kat2);

        $totalMata1 = array_sum($skorKomponen1Kat1) + array_sum(array_slice($skorKomponen1Kat2, 0, 11, true));
        $sasaran1 = $sasaranHakiki * $this->multiplier($lpp->gredGuru->gred);
        $mataHakiki = min($totalMata1, $sasaran1);
        $limpahanHakiki = $totalMata1 - $mataHakiki;

        // print_r($skorKomponen1Kat1);
        // return;

        $skorKomponen1Kat2[8] = min($limpahanHakiki, 1 / 3 * $sasaranNonHakiki);
        $totalMata2 =  array_sum($skorKomponen1Kat1) + array_sum(array_slice($skorKomponen1Kat2, 11, sizeof($skorKomponen1Kat2), true));

        $sasaran2 = $sasaranNonHakiki * $this->multiplier($lpp->gredGuru->gred);
        $mataNonHakiki = min($totalMata2, $sasaran2);

        $sim = $this->findSimulasiJan($lppid, 4);
        $sim->lpp_id = $lppid;
        $sim->kategori_id = 4;
        $sim->mata_1 = $totalMata1;
        $sim->mata_2 = $totalMata2;
        $sim->sasaran_1 = $sasaran1;
        $sim->sasaran_2 = $sasaran2;
        $sim->mata_hakiki = $mataHakiki;
        $sim->mata_non_hakiki = $mataNonHakiki;
        $sim->limpahan_hakiki = $limpahanHakiki;
        $sim->sub_jumlah = $mataHakiki + $mataNonHakiki;
        $sim->isElaun = 0;
        $sim->save(false);
        return;
    }

    public function kategori5_5($lppid)
    {
        $sasaranHakikiElaun = 42;
        $sasaranNonHakikiElaun = 18;
        $sasaranHakikiNonElaun = 9;
        $sasaranNonHakikiNonElaun = 4;

        $lpp = $this->findLpp($lppid);

        $this->dataBahagian7($lppid, $urus_tadbir, $result);
        $list = array_merge($urus_tadbir, $result);

        $this->dataBahagian6($lppid, $conference, $manual, $manual2);
        $list2 = array_merge($conference, $manual2);

        $statusElaun = false;

        ArrayHelper::setValue($inputKomponen1, [1, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) use (&$statusElaun) {
                $statusElaun = true;
                return $element['Peranan_jawatankuasa'] == 'Jawatan Berelaun di Universiti' && (str_contains($element['nama_jawatan'], 'Canselor'));
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [2, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element)  use (&$statusElaun) {
                $statusElaun = true;
                return $element['Peranan_jawatankuasa'] == 'Jawatan Berelaun di Universiti' && (str_contains($element['nama_jawatan'], 'Dekan') || str_contains($element['nama_jawatan'], 'Pengarah'));
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [3, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) use (&$statusElaun) {
                $statusElaun = true;
                return $element['Peranan_jawatankuasa'] == 'Jawatan Berelaun di Universiti' && (str_contains($element['nama_jawatan'], 'Program') || str_contains($element['nama_jawatan'], 'Penyelaras'));
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [4, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element)  use (&$statusElaun) {
                $statusElaun = true;
                return $element['Peranan_jawatankuasa'] == 'Jawatan Berelaun di Universiti' && (str_contains($element['nama_jawatan'], 'Jabatan') || str_contains($element['nama_jawatan'], 'Unit'));
            })
        )]);

        //
        ArrayHelper::setValue($inputKomponen2, [17, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Bilangan_jawatankuasa'] == 'Badan Professional (Akademik)' && $element['Tahap_jawatankuasa'] == 'Kebangsaan' && $element['Peranan_jawatankuasa'] == 'Ketua';
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [17, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Bilangan_jawatankuasa'] == 'Badan Professional (Akademik)' && $element['Tahap_jawatankuasa'] == 'Kebangsaan' && $element['Peranan_jawatankuasa'] == 'Penyelaras';
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [17, 3], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Bilangan_jawatankuasa'] == 'Badan Professional (Akademik)' && $element['Tahap_jawatankuasa'] == 'Kebangsaan' && $element['Peranan_jawatankuasa'] == 'Ahli';
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [18, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Bilangan_jawatankuasa'] == 'Badan Professional (Akademik)' && $element['Tahap_jawatankuasa'] == 'Antarabangsa' && $element['Peranan_jawatankuasa'] == 'Ketua';
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [18, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Bilangan_jawatankuasa'] == 'Badan Professional (Akademik)' && $element['Tahap_jawatankuasa'] == 'Antarabangsa'  && $element['Peranan_jawatankuasa'] == 'Penyelaras';
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [18, 3], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Bilangan_jawatankuasa'] == 'Badan Professional (Akademik)' && $element['Tahap_jawatankuasa'] == 'Antarabangsa' && $element['Peranan_jawatankuasa'] == 'Ahli';
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [19, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list2, function ($element) {
                return $element['Bilangan_outreaching'] == 'Consultation' && ($element['Tahap_outreaching'] == 'National' || $element['Tahap_outreaching'] == 'Kebangsaan') && ($element['Peranan_outreaching'] == 'Leader' || $element['Peranan_outreaching'] == 'Professional Service');
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [19, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list2, function ($element) {
                return $element['Bilangan_outreaching'] == 'Consultation' && ($element['Tahap_outreaching'] == 'National' || $element['Tahap_outreaching'] == 'Kebangsaan') && ($element['Peranan_outreaching'] == '1');
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [19, 3], ['skor' => array_sum(
            ArrayHelper::getColumn($list2, function ($element) {
                return $element['Bilangan_outreaching'] == 'Consultation' && ($element['Tahap_outreaching'] == 'National' || $element['Tahap_outreaching'] == 'Kebangsaan') && ($element['Peranan_outreaching'] == 'Member');
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [20, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list2, function ($element) {
                return $element['Bilangan_outreaching'] == 'Consultation' && ($element['Tahap_outreaching'] == 'International' || $element['Tahap_outreaching'] == 'Antarabangsa') && ($element['Peranan_outreaching'] == 'Leader' || $element['Peranan_outreaching'] == 'Professional Service');
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [20, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list2, function ($element) {
                return $element['Bilangan_outreaching'] == 'Consultation' && ($element['Tahap_outreaching'] == 'International' || $element['Tahap_outreaching'] == 'Antarabangsa') && ($element['Peranan_outreaching'] == '1');
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [20, 3], ['skor' => array_sum(
            ArrayHelper::getColumn($list2, function ($element) {
                return $element['Bilangan_outreaching'] == 'Consultation' && ($element['Tahap_outreaching'] == 'International' || $element['Tahap_outreaching'] == 'Antarabangsa') && ($element['Peranan_outreaching'] == 'Member');
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [27, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return ($element['Bilangan_jawatankuasa'] == 'Badan Professional (Akademik)' || $element['Bilangan_jawatankuasa'] == 'Badan Bukan Kerajaan (Akademik)') && $element['Peranan_jawatankuasa'] == 'Ketua';
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [27, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return ($element['Bilangan_jawatankuasa'] == 'Badan Professional (Akademik)' || $element['Bilangan_jawatankuasa'] == 'Badan Bukan Kerajaan (Akademik)') && $element['Peranan_jawatankuasa'] == 'Penyelaras';
            })
        )]);
        ArrayHelper::setValue($inputKomponen2, [27, 3], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return ($element['Bilangan_jawatankuasa'] == 'Badan Professional (Akademik)' || $element['Bilangan_jawatankuasa'] == 'Badan Bukan Kerajaan (Akademik)') && $element['Peranan_jawatankuasa'] == 'Ahli';
            })
        )]);

        $mataKomponen2_1 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 5, 'nilai_mata_id' => 1])->asArray()->indexBy('aktiviti_id')->all();
        $mataKomponen2_2 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 5, 'nilai_mata_id' => 2])->asArray()->indexBy('aktiviti_id')->all();
        $mataKomponen2_3 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 5, 'nilai_mata_id' => 3])->asArray()->indexBy('aktiviti_id')->all();

        ArrayHelper::setValue($skorKomponen1, 1,  $inputKomponen1[1][1]['skor'] * $mataKomponen2_1[1]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 2,  $inputKomponen1[2][1]['skor'] * $mataKomponen2_1[2]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 3,  $inputKomponen1[3][1]['skor'] * $mataKomponen2_1[3]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 4, $inputKomponen1[4][1]['skor'] * $mataKomponen2_1[4]['nilai_mata']);

        ArrayHelper::setValue($skorKomponen1, 17,  $inputKomponen2[17][1]['skor'] * $mataKomponen2_1[17]['nilai_mata'] + $inputKomponen2[17][2]['skor'] * $mataKomponen2_2[17]['nilai_mata'] + $inputKomponen2[17][3]['skor'] * $mataKomponen2_3[17]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 18,  $inputKomponen2[18][1]['skor'] * $mataKomponen2_1[18]['nilai_mata'] + $inputKomponen2[18][2]['skor'] * $mataKomponen2_2[18]['nilai_mata'] + $inputKomponen2[18][3]['skor'] * $mataKomponen2_3[18]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 19,  $inputKomponen2[19][1]['skor'] * $mataKomponen2_1[19]['nilai_mata'] + $inputKomponen2[19][2]['skor'] * $mataKomponen2_2[19]['nilai_mata'] + $inputKomponen2[19][3]['skor'] * $mataKomponen2_3[19]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 20,  $inputKomponen2[20][1]['skor'] * $mataKomponen2_1[20]['nilai_mata'] + $inputKomponen2[20][2]['skor'] * $mataKomponen2_2[20]['nilai_mata'] + $inputKomponen2[20][3]['skor'] * $mataKomponen2_3[20]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 27,  $inputKomponen2[27][1]['skor'] * $mataKomponen2_1[27]['nilai_mata'] + $inputKomponen2[27][2]['skor'] * $mataKomponen2_2[27]['nilai_mata'] + $inputKomponen2[27][3]['skor'] * $mataKomponen2_3[27]['nilai_mata']);

        $skorKomponen1 = $this->fillMissingKeys($skorKomponen1, $mataKomponen2_1);

        $totalMata1 = array_sum(array_slice($skorKomponen1, 0, 9, true));
        $sasaran1 = ($statusElaun ? $sasaranHakikiElaun : $sasaranHakikiNonElaun) * $this->multiplier($lpp->gredGuru->gred);
        $mataHakiki = min($totalMata1, $sasaran1);
        $limpahanHakiki = $totalMata1 - $mataHakiki;

        $skorKomponen1[8] = min($limpahanHakiki, 1 / 3 * $statusElaun ? $sasaranNonHakikiElaun : $sasaranNonHakikiNonElaun);
        $totalMata2 = array_sum(array_slice($skorKomponen1, 9, sizeof($skorKomponen1), true));
        $sasaran2 = ($statusElaun ? $sasaranNonHakikiElaun : $sasaranNonHakikiNonElaun) * $this->multiplier($lpp->gredGuru->gred);
        $mataNonHakiki = min($totalMata2, $sasaran2);

        $sim = $this->findSimulasiJan($lppid, 5);
        $sim->lpp_id = $lppid;
        $sim->kategori_id = 5;
        $sim->mata_1 = $totalMata1;
        $sim->mata_2 = $totalMata2;
        $sim->sasaran_1 = $sasaran1;
        $sim->sasaran_2 = $sasaran2;
        $sim->mata_hakiki = $mataHakiki;
        $sim->mata_non_hakiki = $mataNonHakiki;
        $sim->limpahan_hakiki = $limpahanHakiki;
        $sim->sub_jumlah = $mataHakiki + $mataNonHakiki;
        $sim->isElaun = $statusElaun;
        $sim->save(false);

        TblSimulasiJan::updateAll(['isElaun' => $statusElaun], 'lpp_id = ' . $lppid . ' and kategori_id in (1,2,3,4)');
        TblSimulasiJan::updateAll(['jumlah_1' => $this->totalJumlah($lppid, $lpp->gredGuru->gred, $statusElaun)], 'lpp_id = ' . $lppid . ' and kategori_id in (1,2,3,4,5)');
        return;
    }

    protected function calcKategori1($lppid, $lpp, &$skorKomponen1, &$mataKomponen1)
    {
        $this->dataBahagian1($lppid, $pengajaran, $pengajaran2, $pnp, $all);

        $listt = $pengajaran + $pengajaran2;

        foreach ($listt as $ind => $p) {
            ArrayHelper::setValue($dataKomponen1, [$ind, 1], ['skor' => floatval($p['JAMKREDIT'] ?? 0)]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 2], ['skor' => floatval($p['pk07'])]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 3], ['skor' => $p['status'] == 'Pass' ? 1 : 0]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 4], ['skor' => $p['status_fail'] == 'Ada - Lengkap' ? 1 : 0]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 5], ['skor' => 0]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 6], ['skor' => floatval($p['bil_pelajar'] ?? 0)]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 7], ['skor' => 0]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 8], ['skor' => 0]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 9], ['skor' => 0]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 10], ['skor' => 0]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 11], ['skor' => 0]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 12], ['skor' => 0]);
            ArrayHelper::setValue($dataKomponen1, [$ind, 13], ['skor' => 0]);
        }

        $mataKomponen1 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 1, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();

        foreach ($mataKomponen1 as $ind => $mk1) {
            $tmp = ArrayHelper::getColumn($dataKomponen1, [$ind, 'skor'], $keepKeys = true);
            if ($ind == 2) {
                ArrayHelper::setValue($inputKomponen1, $ind, number_format(array_sum($tmp) / count($tmp), 1));
                continue;
            }
            ArrayHelper::setValue($inputKomponen1, $ind,  number_format(array_sum($tmp), 1));
        }

        $n = 50;

        foreach ($mataKomponen1 as $ind => $mk1) {
            if ($ind == 6) {
                // ArrayHelper::setValue($skorKomponen1, $ind, ($inputKomponen1[$ind] / $n) * $mk1['nilai_mata']);
                // echo $inputKomponen1[$ind];
                ArrayHelper::setValue($skorKomponen1, $ind, (float)$inputKomponen1[$ind] * (1 / $n));
                continue;
            }
            ArrayHelper::setValue($skorKomponen1, $ind, $inputKomponen1[$ind] * $mk1['nilai_mata']);
        }
    }

    protected function calcKategori2($lppid, $lpp, &$skorKomponen1, &$mataKomponen1)
    {
        $this->dataBahagian2($lppid, $data, $penyeliaan, $utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);
        $tmp = array_merge_recursive($utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);
        foreach ($tmp as $id => $t) {
            ArrayHelper::setValue($tmp2, [$id, 'utama_belum'], is_array($tmp[$id]['utama_belum']) ? array_sum($tmp[$id]['utama_belum']) : $tmp[$id]['utama_belum']);
            ArrayHelper::setValue($tmp2, [$id, 'utama_telah_sem'], is_array($tmp[$id]['utama_telah_sem']) ? array_sum($tmp[$id]['utama_telah_sem']) : $tmp[$id]['utama_telah_sem']);
            ArrayHelper::setValue($tmp2, [$id, 'utama_telah'], is_array($tmp[$id]['utama_telah']) ? array_sum($tmp[$id]['utama_telah']) : $tmp[$id]['utama_telah']);
            ArrayHelper::setValue($tmp2, [$id, 'sama_belum'], is_array($tmp[$id]['sama_belum']) ? array_sum($tmp[$id]['sama_belum']) : $tmp[$id]['sama_belum']);
            ArrayHelper::setValue($tmp2, [$id, 'sama_telah_sem'], is_array($tmp[$id]['sama_telah_sem']) ? array_sum($tmp[$id]['sama_telah_sem']) : $tmp[$id]['sama_telah_sem']);
            ArrayHelper::setValue($tmp2, [$id, 'sama_telah'], is_array($tmp[$id]['sama_telah']) ? array_sum($tmp[$id]['sama_telah']) : $tmp[$id]['sama_telah']);
        }
        $selia = ArrayHelper::toArray($penyeliaan,  [
            'app\models\elnpt\elnpt2\TblPenyeliaanManual' => [
                'utama_belum',
                'utama_telah_sem',
                'utama_telah',
                'sama_belum',
                'sama_telah_sem',
                'sama_telah',
                'tahap_penyeliaan',
            ],
        ]);
        foreach ($tmp2 as $id => $_tmp2) {
            switch ($id) {
                case 'MASTER':
                    $_tmp2['tahap_penyeliaan'] = 2;
                    break;
                case 'PHD':
                    $_tmp2['tahap_penyeliaan'] = 1;
                    break;
                case 'M.Phil.':
                    $_tmp2['tahap_penyeliaan'] = 3;
                    break;
            }
            array_push($selia, $_tmp2);
        }
        $selia = ArrayHelper::index($selia, 'tahap_penyeliaan');

        ArrayHelper::setValue($inputKomponen1, [1, 1], ['skor' => $selia[1]['utama_belum'] + $selia[1]['utama_telah_sem'] + $selia[1]['utama_telah']]);
        ArrayHelper::setValue($inputKomponen1, [1, 2], ['skor' => $selia[1]['sama_belum'] + $selia[1]['sama_telah_sem'] + $selia[1]['sama_telah']]);
        ArrayHelper::setValue($inputKomponen1, [2, 1], ['skor' => $selia[3]['utama_belum'] + $selia[3]['utama_telah_sem'] + $selia[3]['utama_telah']]);
        ArrayHelper::setValue($inputKomponen1, [2, 2], ['skor' => $selia[3]['sama_belum'] + $selia[3]['sama_telah_sem'] + $selia[3]['sama_telah']]);
        ArrayHelper::setValue($inputKomponen1, [5, 1], ['skor' => $selia[5]['utama_belum'] + $selia[5]['utama_telah_sem'] + $selia[5]['utama_telah']]);
        ArrayHelper::setValue($inputKomponen1, [5, 2], ['skor' => $selia[5]['sama_belum'] + $selia[5]['sama_telah_sem'] + $selia[5]['sama_telah']]);

        ArrayHelper::setValue($inputKomponen1, [6, 1], ['skor' => $selia[4]['utama_belum'] + $selia[4]['utama_telah_sem'] + $selia[4]['utama_telah']]);
        ArrayHelper::setValue($inputKomponen1, [6, 2], ['skor' => $selia[4]['sama_belum'] + $selia[4]['sama_telah_sem'] + $selia[4]['sama_telah']]);

        $mataKomponen1 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 2, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();
        $mataKomponen2 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 2, 'nilai_mata_id' => 2])->indexBy(['aktiviti_id'])->asArray()->all();

        ArrayHelper::setValue($skorKomponen1, 1,  $inputKomponen1[1][1]['skor'] * $mataKomponen1[1]['nilai_mata'] + $inputKomponen1[1][2]['skor'] * $mataKomponen2[1]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 2,  $inputKomponen1[2][1]['skor'] * $mataKomponen1[2]['nilai_mata'] + $inputKomponen1[2][2]['skor'] * $mataKomponen2[2]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 3,  $inputKomponen1[5][1]['skor'] * $mataKomponen1[5]['nilai_mata'] + $inputKomponen1[5][2]['skor'] * $mataKomponen2[5]['nilai_mata']);

        ArrayHelper::setValue($skorKomponen1, 6,  $inputKomponen1[6][1]['skor'] * $mataKomponen1[6]['nilai_mata'] + $inputKomponen1[6][2]['skor'] * $mataKomponen2[6]['nilai_mata']);

        $skorKomponen1 = $this->fillMissingKeys($skorKomponen1, $mataKomponen2);
    }

    protected function calcKategori3($lppid, $lpp, &$skorKomponen1, &$mataKomponen1)
    {
        $this->dataBahagian3($lppid, $penyelidikan, $penyelidikan2, $grant);
        $list = array_merge($penyelidikan, $penyelidikan2);

        /*
        tahap_geran: 1(uni)
        */
        ArrayHelper::setValue($inputKomponen1, [1, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Tahap_geran'] == 1 && $element['Peranan'] == 'Leader';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [1, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Tahap_geran'] == 1 && $element['Peranan'] == 'Member';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [2, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Tahap_geran'] == 2 && $element['Peranan'] == 'Leader';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [2, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Tahap_geran'] == 2 && $element['Peranan'] == 'Member';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [3, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Tahap_geran'] == 3 && $element['Peranan'] == 'Leader';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [3, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                return $element['Tahap_geran'] == 3 && $element['Peranan'] == 'Member';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [4, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                if ($element['Tahap_geran'] == 1 && $element['Peranan'] == 'Leader') {
                    return $element['Amount'];
                }
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [4, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                if ($element['Tahap_geran'] == 1 && $element['Peranan'] == 'Member') {
                    return $element['Amount'];
                }
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [5, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                if ($element['Tahap_geran'] == 2 && $element['Peranan'] == 'Leader') {
                    return $element['Amount'];
                }
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [5, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                if ($element['Tahap_geran'] == 2 && $element['Peranan'] == 'Member') {
                    return $element['Amount'];
                }
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [6, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                if ($element['Tahap_geran'] == 3 && $element['Peranan'] == 'Leader') {
                    return $element['Amount'];
                }
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [6, 2], ['skor' => array_sum(
            ArrayHelper::getColumn($list, function ($element) {
                if ($element['Tahap_geran'] == 3 && $element['Peranan'] == 'Member') {
                    return $element['Amount'];
                }
            })
        )]);

        $mataKomponen1 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 3, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();
        $mataKomponen2 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 3, 'nilai_mata_id' => 2])->indexBy(['aktiviti_id'])->asArray()->all();

        $base = 10000;

        ArrayHelper::setValue($skorKomponen1, 1,  $inputKomponen1[1][1]['skor'] * $mataKomponen1[1]['nilai_mata'] + $inputKomponen1[1][2]['skor'] * $mataKomponen2[1]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 2,  $inputKomponen1[2][1]['skor'] * $mataKomponen1[2]['nilai_mata'] + $inputKomponen1[2][2]['skor'] * $mataKomponen2[2]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 3,  $inputKomponen1[3][1]['skor'] * $mataKomponen1[3]['nilai_mata'] + $inputKomponen1[3][2]['skor'] * $mataKomponen2[3]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 4, ($inputKomponen1[4][1]['skor'] / $base) * $mataKomponen1[4]['nilai_mata'] + ($inputKomponen1[4][2]['skor'] / $base) * $mataKomponen2[4]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 5, ($inputKomponen1[5][1]['skor'] / $base) * $mataKomponen1[5]['nilai_mata'] + ($inputKomponen1[5][2]['skor'] / $base) * $mataKomponen2[5]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 6, ($inputKomponen1[6][1]['skor'] / $base) * $mataKomponen1[6]['nilai_mata'] + ($inputKomponen1[6][2]['skor'] / $base) * $mataKomponen2[6]['nilai_mata']);
    }

    protected function calcKategori4($lppid, $lpp, &$skorKomponen1, &$mataKomponen1)
    {
        $this->dataBahagian4($lppid, $publication);

        ArrayHelper::setValue($inputKomponen1, [2, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                $q1 = [1, 2, 3];
                return ($element['Status_penulis'] == 'Corresponding Author' || $element['Status_penulis'] == 'First Author') && in_array($element['PublicationMonth'],  $q1) && $element['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [3, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                $q1 = [4, 5, 6];
                return ($element['Status_penulis'] == 'Corresponding Author' || $element['Status_penulis'] == 'First Author') && in_array($element['PublicationMonth'],  $q1) && $element['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [4, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                $q1 = [7, 8, 9];
                return ($element['Status_penulis'] == 'Corresponding Author' || $element['Status_penulis'] == 'First Author') && in_array($element['PublicationMonth'],  $q1) && $element['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [5, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                $q1 = [10, 11, 12];
                return ($element['Status_penulis'] == 'Corresponding Author' || $element['Status_penulis'] == 'First Author') && in_array($element['PublicationMonth'],  $q1) && $element['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)';
            })
        )]);

        ArrayHelper::setValue($inputKomponen1, [10, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                return $element['Status_indeks'] != 'High-Indexed (SCOPUS, WOS, ERA)';
            })
        )]);

        //selain hakiki
        ArrayHelper::setValue($inputKomponen1, [13, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                $q1 = [1, 2, 3];
                return $element['Status_penulis'] == 'Collaborative Author' && in_array($element['PublicationMonth'],  $q1) && $element['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [14, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                $q1 = [4, 5, 6];
                return $element['Status_penulis'] == 'Collaborative Author' && in_array($element['PublicationMonth'],  $q1) && $element['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [15, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                $q1 = [7, 8, 9];
                return $element['Status_penulis'] == 'Collaborative Author' && in_array($element['PublicationMonth'],  $q1) && $element['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)';
            })
        )]);
        ArrayHelper::setValue($inputKomponen1, [16, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                $q1 = [10, 11, 12];
                return $element['Status_penulis'] == 'Collaborative Author' && in_array($element['PublicationMonth'],  $q1) && $element['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)';
            })
        )]);

        ArrayHelper::setValue($inputKomponen1, [20, 1], ['skor' => array_sum(
            ArrayHelper::getColumn($publication, function ($element) {
                return $element['Status_indeks'] == 'Indexing (Mycite)';
            })
        )]);

        $mataKomponen1 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 4, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();
        $mataKomponen2 = TblMata::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 4, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();

        ArrayHelper::setValue($skorKomponen1, 2,  $inputKomponen1[2][1]['skor'] * $mataKomponen1[2]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 3,  $inputKomponen1[3][1]['skor'] * $mataKomponen1[3]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 4,  $inputKomponen1[4][1]['skor'] * $mataKomponen1[4]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 5, $inputKomponen1[5][1]['skor'] * $mataKomponen1[5]['nilai_mata']);
        ArrayHelper::setValue($skorKomponen1, 10, $inputKomponen1[10][1]['skor'] * $mataKomponen1[10]['nilai_mata']);

        ArrayHelper::setValue($skorKomponen1, 13,  $inputKomponen1[13][1]['skor'] * 2.5 / 2);
        ArrayHelper::setValue($skorKomponen1, 14,  $inputKomponen1[14][1]['skor'] * 2.5 / 1);
        ArrayHelper::setValue($skorKomponen1, 15,  $inputKomponen1[15][1]['skor'] * 2.5 / 2);
        ArrayHelper::setValue($skorKomponen1, 16, $inputKomponen1[16][1]['skor'] * 2.5 / 2);

        ArrayHelper::setValue($skorKomponen1, 20, $inputKomponen1[16][1]['skor'] * 0.5 / 2);

        $skorKomponen1 = $this->fillMissingKeys($skorKomponen1, $mataKomponen1);
    }

    protected function totalSasaran($gred, $isElaun)
    {
        switch ($gred) {
            case 'DS45':
                return $isElaun ? 144 : 96;
                break;
            case 'DS52':
                return $isElaun ? 172 : 116;
                break;
            case 'DS54':
                return $isElaun ? 201 : 135;
                break;
            case 'VK7':
                return $isElaun ? 230 : 154;
                break;
            case 'VK6':
                return $isElaun ? 258 : 174;
                break;
            case 'VK5':
                return $isElaun ? 287 : 193;
                break;

            default:
                return $isElaun ? 144 : 96;
                break;
        }
    }

    protected function totalSasaranKlinikal($gred, $isElaun)
    {
        switch ($gred) {
            case 'DU51':
                return $isElaun ? 195 : 139;
                break;
            case 'DU52':
                return $isElaun ? 195 : 139;
                break;
            case 'DU53':
                return $isElaun ? 224 : 158;
                break;
            case 'DU54':
                return $isElaun ? 224 : 158;
                break;
            case 'DU55':
                return $isElaun ? 224 : 158;
                break;
            case 'DU56':
                return $isElaun ? 224 : 158;
                break;
            case 'VK7':
                return $isElaun ? 253 : 177;
                break;
            case 'VK6':
                return $isElaun ? 281 : 196;
                break;
            case 'VK5':
                return $isElaun ? 310 : 216;
                break;

            default:
                return $isElaun ? 100 : 100;
                break;
        }
    }

    protected function totalJumlah($lppid, $gred, $isElaun)
    {
        $sum = TblSimulasiJan::find()->where(['lpp_id' => $lppid])->sum('sub_jumlah');

        return ($sum / $this->totalSasaran($gred, $isElaun)) * 100;
    }

    protected function totalJumlah5Kategori($lppid, $gred, $isElaun)
    {
        $sum = TblSimulasiDec::find()->where(['lpp_id' => $lppid])->sum('sub_jumlah');

        return ($sum / $this->totalSasaran($gred, $isElaun)) * 100;
    }


    public function dataBahagian11(&$lppid, &$klinikal, &$clinical)
    {
        if (($klinikal = TblKlinikal::findOne(['lpp_id' => $lppid])) != null) {
            $klinikal = TblKlinikal::find()->where(['lpp_id' => $lppid])->one();
        } else {
            $klinikal = new TblKlinikal();
        }
        $lpp = $this->findLpp($lppid);
        switch (true) {
            case $clinical1 = TblConsultation::find()
                ->where(['NoStaf' => $lpp->guru->COOldID])
                ->andwhere(['=', '[ConsultationType]', 'Recognition'])
                ->andWhere(['OR', ['>=', 'Tajuk', 'APC'], ['>=', 'Tajuk', 'annual']])
                ->andWhere(['OR', ['>=', 'YEAR(TarikhMula)', $lpp->tahun], ['>=', 'YEAR(TarikhAkhit)', $lpp->tahun]])
                ->exists():
                $clinical = $clinical1;
                break;
            case $clinical4 = TblLnptClinical::find()
                ->where(['CreateBy' => $lpp->PYD])
                ->andWhere(['or', ['like', 'Activity', 'annual'], ['like', 'Activity', 'apc']])
                // ->andWhere(['and', ['YEAR(StartDate)' => $lpp->tahun], ['>=', 'YEAR(EndDate)', $lpp->tahun]])
                // ->andWhere(['Type' => ['Clinic sessions', 'Clinical ward work/rounds', 'Surgical procedures']])
                // ->asArray()
                // ->all();
                ->exists():
                $clinical = $clinical4;
                break;
            case $clinical2 = TblConsultationClinical::find()
                ->where(['ICKakitangan' => $lpp->PYD])
                ->andWhere(['OR', ['>=', 'Rawatan', 'APC'], ['>=', 'Rawatan', 'annual']])
                ->andWhere(['OR', ['>=', 'YEAR(TarikhMula)', $lpp->tahun], ['>=', 'YEAR(TarikhAkhir)', $lpp->tahun]])
                ->exists():
                $clinical = $clinical2;
                break;
            case $clinical3 = TblConsultancy::find()
                ->where(['ICNo' => $lpp->PYD])
                ->andWhere(['OR', ['>=', 'Title', 'APC'], ['>=', 'Title', 'annual']])
                ->andWhere(['OR', ['>=', 'YEAR(StartDate)', $lpp->tahun], ['>=', 'YEAR(EndDate)', $lpp->tahun]])
                ->exists():
                $clinical = $clinical3;
                break;
            default:
                $clinical = false;
        }
        // return VarDumper::dump($clinical, $depth = 10, $highlight = true);
    }

    public function actionKategori6($lppid)
    {
        $sasaranHakiki = 16;
        $sasaranNonHakiki = 7;

        $lpp = $this->findLpp($lppid);

        $this->dataBahagian11($lppid, $klinikal, $clinic);

        $k = ArrayHelper::toArray($klinikal, [
            'app\models\elnpt\perkhidmatan_klinikal\TblKlinikal' => [
                'cbt' => function ($klinikal) {
                    return $klinikal->cbt ?? 0;
                },
                // 'apc' => function ($klinikal) {
                //     return $klinikal->apc ?? 0;
                // },
                'apc' => function ($klinikal) use ($clinic) {
                    return $clinic ? 1 : 0;
                },
                'clinic_consult' => function ($klinikal) {
                    return $klinikal->clinic_consult ?? 0;
                }
            ],
        ]);

        print_r($k);
        return;

        // $totalMata1 = array_sum(array_slice($skorKomponen1, 0, 5, true));
        // $sasaran1 = $sasaranHakiki * $this->multiplier($lpp->gredGuru->gred);
        // $mataHakiki = min($totalMata1, $sasaran1);
        // $limpahanHakiki = $totalMata1 - $mataHakiki;

        // $skorKomponen1[sizeof($mataKomponen1)] = min($limpahanHakiki, 1 / 3 * $sasaranNonHakiki);
        // $totalMata2 = array_sum(array_slice($skorKomponen1, (6 - 1), sizeof($skorKomponen1), true));
        // $sasaran2 = $sasaranNonHakiki * $this->multiplier($lpp->gredGuru->gred);
        // $mataNonHakiki = min($totalMata2, $sasaran2);

        // $sim = $this->findSimulasi($lppid, 1);
        // $sim->lpp_id = $lppid;
        // $sim->kategori_id = 1;
        // $sim->mata_1 = $totalMata1;
        // $sim->mata_2 = $totalMata2;
        // $sim->sasaran_1 = $sasaran1;
        // $sim->sasaran_2 = $sasaran2;
        // $sim->mata_hakiki = $mataHakiki;
        // $sim->mata_non_hakiki = $mataNonHakiki;
        // $sim->limpahan_hakiki = $limpahanHakiki;
        // $sim->sub_jumlah = $mataHakiki + $mataNonHakiki;
        // $sim->isElaun = 0;
        // $sim->save(false);
        // return;
    }

    protected function isClinical($dept)
    {
        if ($dept != 138) {
            return false;
        }

        return false;
    }
}
