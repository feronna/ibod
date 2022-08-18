<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use app\models\elnpt\elnpt2\RefAspekPemberat;
use app\models\elnpt\elnpt2\RefAspekPenilaian;
use app\models\elnpt\elnpt2\RefAspekPeratus;
use app\models\elnpt\elnpt2\RefAspekSkor;
use app\models\elnpt\elnpt2\RefSkorF2f;
use app\models\elnpt\elnpt2\RefSkorPenyeliaan;
use app\models\elnpt\elnpt2\RefGred;
use app\models\elnpt\elnpt2\TblKumpDept;
use app\models\elnpt\elnpt2\RefPemberatSeluruh;
use app\models\elnpt\elnpt2\TblPersidangan;
use app\models\elnpt\elnpt2\TblTeknologiInovasi;
use app\models\elnpt\elnpt2\TblPnP;
use app\models\elnpt\elnpt2\PenilaianKursusPK07;
use app\models\elnpt\TblPengajaran;
use app\models\elnpt\elnpt2\Tblrscoadminpost;
use app\models\elnpt\TblRequest;
use app\models\elnpt\elnpt2\RefBahagian;
use app\models\elnpt\TblMain;
use app\models\elnpt\TblAlasanSemakan;
use app\models\elnpt\TblMrkhBhg;
use app\models\elnpt\RefPeratusKategori;
use app\models\elnpt\TblMarkahKeseluruhan;
use app\models\elnpt\TblLppTahun;
use app\models\elnpt\elnpt2\TblPengajaranPembelajaran;
use app\models\elnpt\TblMrkhAspek;
use app\models\elnpt\elnpt2\TblPenyeliaanManual;
use app\models\elnpt\elnpt2\TblPenyeliaan;
use app\models\elnpt\perkhidmatan_klinikal\TblKlinikal;
use app\models\elnpt\TblPenyelidikan2;
use app\models\elnpt\TblPenyelidikanManual;
use app\models\elnpt\TblGrantApplication;
use app\models\elnpt\TblException;
use app\models\elnpt\elnpt2\TblException2;
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
use app\models\elnpt\elnpt2\PenilaianKursusPK07_FPSK;
use app\models\elnpt\elnpt2\TblDocuments;
use app\models\elnpt\elnpt2\TblSmartV3;
use app\models\elnpt\TblBlendedLearning;
use app\models\elnpt\testing\TblTestingAccess;
use app\models\elnpt\TblBlendedLearningFarm;
use app\models\elnpt\TblLnptClinical;
use app\models\elnpt\TblPenyeliaanPPST;
use yii\helpers\Url;

use yii\base\Exception;

class Elnpt2Controller extends Controller
{
    public function actionStartProcess()
    {
        // $lpps = TblMain::find()->where(['and', ['jfpiu' => 104], ['>=', 'tahun', 2020]])->asArray()->all();
        $lpps = TblMain::find()->where(['and', ['gred_jawatan_id' => 15], ['tahun' => [2020, 2021]]])->asArray()->all();

        foreach ($lpps as $lpp) {
            try {
                $this->bahagian2($lpp['lpp_id']);
                echo $lpp['lpp_id'] . ', ';
            } catch (\Exception $e) {
                echo $lpp['lpp_id'] . ' error, ';
                continue;
            }
        }
        return ExitCode::OK;
    }

    public function bahagian2($lppid)
    {
        $bhg = RefBahagian::findOne(2);
        $lpp = $this->findLpp($lppid);
        // $this->checkBahagian($lpp, $bhg->id);
        $this->dataBahagian2($lppid, $data, $penyeliaan, $utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);
        $tmp = array_merge_recursive($utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);
        // $tmp = $utama_belum + $utama_telah_sem + $utama_telah + $sama_belum + $sama_telah_sem + $sama_telah;
        // ArrayHelper::setValue($tmpP, , ['skor' => floatval($as['skor'])]);
        // return VarDumper::dump($tmp, $depth = 10, $highlight = true);
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
        $seliaArry = ArrayHelper::index($selia_arry, 'tahap_penyeliaan');
        if (($tblselia = TblPenyeliaanPPST::findOne(['lpp_id' => $lppid])) == null) {
            $tblselia = new TblPenyeliaanPPST();
        }

        $tblselia->lpp_id = $lppid;
        $tblselia->phd_utama = $seliaArry['1']['utama_belum'] + $seliaArry['1']['utama_telah_sem'] + $seliaArry['1']['utama_telah'];
        $tblselia->phd_sama = $seliaArry['1']['sama_belum'] + $seliaArry['1']['sama_telah_sem'] + $seliaArry['1']['sama_telah'];

        $tblselia->sarjana_utama = $seliaArry['2']['utama_belum'] + $seliaArry['2']['utama_telah_sem'] + $seliaArry['2']['utama_telah'];
        $tblselia->sarjana_sama = $seliaArry['2']['sama_belum'] + $seliaArry['2']['sama_telah_sem'] + $seliaArry['2']['sama_telah'];

        $tblselia->s_muda_utama = isset($seliaArry['5']['utama_belum']) ? ($seliaArry['5']['utama_belum'] + $seliaArry['5']['utama_telah_sem'] + $seliaArry['5']['utama_telah']) : 0;
        $tblselia->s_muda_sama = isset($seliaArry['5']['sama_belum']) ? ($seliaArry['5']['sama_belum'] + $seliaArry['5']['sama_telah_sem'] + $seliaArry['5']['sama_telah']) : 0;

        $tblselia->save(false);
    }

    public function actionGenerateData()
    {
        $lpp = TblMain::find()
            ->alias('lpp')
            ->innerJoinWith('guru guru', true)
            ->joinWith('markahAll markah', true, 'LEFT JOIN')
            ->where(['lpp.tahun' => 2020])
            ->andWhere(['lpp.gred_jawatan_id' => 15])
            ->andWhere(['lpp.is_deleted' => 0])
            ->limit(1)->all();
        foreach ($lpp as $l) {
            $this->dataBahagian1($l->lpp_id, $pengajaran, $pengajaran2, $pnp, $all);
            $arryPnp = ArrayHelper::toArray($pnp, []);
            $dataBhg1 = array_replace_recursive(($pengajaran + $pengajaran2), $arryPnp);
            $mrkhBhg1 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(1, $l->lpp_id), [], false);
            $this->dataBahagian2($l->lpp_id, $data, $penyeliaan, $utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);
            $tmp = array_merge_recursive($utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);
            foreach ($tmp as $id => $t) {
                ArrayHelper::setValue($tmpP, [$id, 'utama_belum'], is_array($tmp[$id]['utama_belum']) ? array_sum($tmp[$id]['utama_belum']) : $tmp[$id]['utama_belum']);
                ArrayHelper::setValue($tmpP, [$id, 'utama_telah_sem'], is_array($tmp[$id]['utama_telah_sem']) ? array_sum($tmp[$id]['utama_telah_sem']) : $tmp[$id]['utama_telah_sem']);
                ArrayHelper::setValue($tmpP, [$id, 'utama_telah'], is_array($tmp[$id]['utama_telah']) ? array_sum($tmp[$id]['utama_telah']) : $tmp[$id]['utama_telah']);
                ArrayHelper::setValue($tmpP, [$id, 'sama_belum'], is_array($tmp[$id]['sama_belum']) ? array_sum($tmp[$id]['sama_belum']) : $tmp[$id]['sama_belum']);
                ArrayHelper::setValue($tmpP, [$id, 'sama_telah_sem'], is_array($tmp[$id]['sama_telah_sem']) ? array_sum($tmp[$id]['sama_telah_sem']) : $tmp[$id]['sama_telah_sem']);
                ArrayHelper::setValue($tmpP, [$id, 'sama_telah'], is_array($tmp[$id]['sama_telah']) ? array_sum($tmp[$id]['sama_telah']) : $tmp[$id]['sama_telah']);
                ArrayHelper::setValue($tmpP, [$id, 'verified_by'], 'SYSTEM');
            }
            $mrkhBhg2 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(2, $l->lpp_id), [], false);
            $dataBhg2 = ArrayHelper::toArray($penyeliaan);
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
                array_push($dataBhg2, $tP);
            }
            usort($dataBhg2, function ($a, $b) {
                return $a['tahap_penyeliaan'] <=> $b['tahap_penyeliaan'];
            });
            print_r($dataBhg2);
        }
        return ExitCode::OK;
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

    public function dataBahagian2($lppid, &$data, &$penyeliaan, &$utama_belum, &$utama_telah_sem, &$utama_telah, &$sama_belum, &$sama_telah_sem, &$sama_telah, &$init)
    {
        $lpp = $this->findLpp($lppid);
        $penyeliaan = TblPenyeliaanManual::find()
            ->where(['lpp_id' => $lppid])
            ->orderBy(['tahap_penyeliaan' => 'SORT_ASC'])
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
                }
            }
        }
        usort($penyeliaan, function ($a, $b) {
            return $a->tahap_penyeliaan <=> $b->tahap_penyeliaan;
        });
        $init = TblPenyeliaan::find()
            ->select(new Expression('DISTINCT(LevelPengajian), \'0\' as utama_belum, \'0\' as utama_telah_sem,  \'0\' as utama_telah, \'0\' as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->where(['!=', 'LevelPengajian', 'CERT'])
            ->indexBy('LevelPengajian')
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
        $sama_belum = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_belum, \'0\' as utama_telah_sem,  \'0\' as utama_telah, COUNT(*) as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [3, 5]])
            ->andWhere(['KodStatusPengajian' => [01, 31, 32, 33, 06, 16]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')
            ->all();
        $sama_belum = ArrayHelper::toArray($sama_belum);
        $sama_telah_sem = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_belum, \'0\' as utama_telah_sem,  \'0\' as utama_telah,\'0\' as sama_belum,  COUNT(*) as sama_telah_sem,  \'0\' as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [3, 5]])
            ->andWhere(['KodStatusPengajian' => [51, 52]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')
            ->all();
        $sama_telah_sem = ArrayHelper::toArray($sama_telah_sem);
        $sama_telah = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_belum, \'0\' as utama_telah_sem,  \'0\' as utama_telah,\'0\' as sama_belum,  \'0\' as sama_telah_sem,  COUNT(*) as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [3, 5]])
            ->andWhere(['KodStatusPengajian' => [53, 54, 56, 57]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')
            ->all();
        $sama_telah = ArrayHelper::toArray($sama_telah);
    }

    protected function findLpp($lppid)
    {
        if (($model = TblMain::findOne($lppid)) !== null) {
            return $model;
        }
    }

    public function findMarkahBahagian($bhg_no, $lppid, $pemberat = null)
    {
        $query = RefAspekPenilaian::find()
            ->select(['`hrm`.`elnpt_v2_ref_aspek_penilaian`.`id`, `hrm`.`elnpt_v2_ref_aspek_penilaian`.`desc`, `hrm`.`elnpt_v2_ref_aspek_penilaian`.`aspek`, coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`skor`, 0) as skor, 
                    coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_pyd`, 0) * 100 as markah_pyd,coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppp`, 0) * 100 as markah_ppp, 
                    coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppk`, 0) * 100 as markah_ppk, coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_peer`, 0) * 100 as markah_peer, `hrm`.`elnpt_v2_ref_aspek_pemberat`.pemberat * 100 AS pemberat'])
            ->leftJoin('`hrm`.`elnpt_tbl_mrkh_aspek`', '`hrm`.`elnpt_tbl_mrkh_aspek`.aspek_id = `hrm`.`elnpt_v2_ref_aspek_penilaian`.id and `hrm`.`elnpt_tbl_mrkh_aspek`.`lpp_id` = ' . $lppid . '')
            ->leftJoin('`hrm`.`elnpt_v2_ref_aspek_pemberat`', '`hrm`.`elnpt_v2_ref_aspek_pemberat`.aspek_id = `hrm`.`elnpt_v2_ref_aspek_penilaian`.id')
            ->andWhere(['`hrm`.`elnpt_v2_ref_aspek_penilaian`.`bhg_no`' => $bhg_no])
            ->asArray()
            ->all();
        if (isset($pemberat)) {
            foreach ($query as $ind => $mn) {
                $query[$ind]['pemberat'] = $pemberat[$ind]['pemberat'] * 100;
            }
        }
        return $query;
    }

    public function actionFarmSmartv3()
    {
        $result = \app\models\cv\TblBlendedLearning::findBySql("
        SELECT (@cnt := @cnt + 1) AS id, t.*
        from
        (SELECT * FROM moodlev3.`db_view_hr02_smartv3`) t
        CROSS JOIN (SELECT @cnt := 0) AS dummy")->all();
        // echo $result->count();

        if ($result != null) {
            TblSmartV3::deleteAll();
            Yii::$app->db->createCommand("ALTER TABLE hrm.elnpt_v2_tbl_smartv3 AUTO_INCREMENT = 1")->query();
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                foreach ($result as $b) {
                    $data = $b->attributes;
                    $bl = new TblSmartV3();
                    $bl->setAttributes($data);
                    $bl->save();
                    if (!($flag = $bl->save())) {
                        $transaction->rollBack();
                        break;
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    echo 'Process Done';
                    return ExitCode::OK;
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                echo $e->getMessage();
                echo 'Process Halt';
                return ExitCode::OK;
            }
        }

        return ExitCode::OK;
    }
}
