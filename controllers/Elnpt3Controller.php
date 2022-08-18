<?php

namespace app\controllers;

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
use app\models\elnpt\penerbitan\TblLnptPublicationV3;
use app\models\elnpt\TblConference;
use app\models\elnpt\inovasi\TblPertandinganPereka;
use app\models\elnpt\inovasi\TblInovasi;
use app\models\elnpt\outreaching\TblOutreachingManual;
use app\models\elnpt\outreaching\TblConsultation;
use app\models\elnpt\perkhidmatan_klinikal\TblConsultationClinical;
use app\models\elnpt\TblConsultancy;
use app\models\elnpt\bahagian_7\TblPengurusanPentadbiran;
use app\models\elnpt\bahagian_9\TblMarkahKualiti;
use app\models\elnpt\simulation\RefPeribadiPelajar;
use app\models\elnpt\simulation\RefSasaranSetahun;
use app\models\elnpt\simulation\TblAktivitiLain;
use app\models\elnpt\simulation\TblManualKeyIn;
use app\models\elnpt\simulation\TblPelajarManual;
use app\models\elnpt\simulation\TblRingkasanMarkah;
use app\models\elnpt\simulation\TblWriterStatusbyQuartile;
use app\models\elnpt\support\TblTicket;
use app\models\elnpt\support\TblTicketContent;
use app\models\elnpt\support\TblTicketSearch;
use app\models\elnpt\testing\TblTestingAccess;
use app\models\elnpt\TblBlendedLearningFarm;
use app\models\elnpt\TblLnptClinical;

use app\models\Notification;

//extension
use yii\web\UploadedFile;
use kartik\mpdf\Pdf;

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

error_reporting(0);

class Elnpt3Controller extends \yii\web\Controller
{
    public function init()
    {
        parent::init();
        $this->viewPath = '@app/views/elnpt/elnpt3';
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'name-list',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => [
                            'borang', 'maklumat-guru', 'pengajaran-penyeliaan', 'penyelidikan-penerbitan', 'perkhidmatan', 'klinikal', 'ringkasan-markah', 'sahsiah',
                            'update-pengajaran', 'create-pnp', 'delete-pnp',
                            'create-urus-tadbir', 'delete-urus-tadbir', 'update-urus-tadbir',
                            'pjax-data-k1', 'pjax-result-k1',
                            'pjax-result-k2',
                            'pjax-data-k5', 'pjax-result-k5',
                            'update-penyeliaan',
                            'update-sahsiah',
                            'view-file',
                            'data-kategori3', 'data-kategori4', 'data-kategori2',
                            'manual-key-in',
                            'aktiviti-lain', 'tambah-aktiviti-lain', 'padam-aktiviti-lain', 'pjax-aktiviti-lain',

                            'tambah-pelajar',

                            'my-tickets', 'add-support-ticket', 'pjax-tickets', 'my-contents-by-ticket', 'add-content', 'pjax-ticket-timeline'

                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (!is_null($admin = TblTestingAccess::findOne(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1]))) {
                                $u = TblMain::findOne(['lpp_id' => Yii::$app->request->get('lppid')]);
                                $this->LoginAsUser($u->PYD, Yii::$app->request->get('lppid'));
                            }
                            $query = TblMain::find()
                                ->where(['lpp_id' => Yii::$app->request->get('lppid')])
                                ->andWhere(['PYD' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']])
                                ->andWhere(['tahun' => 2022])
                                ->exists();

                            if ($query) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'data-kategori1', 'data-kategori2', 'data-kategori3', 'data-kategori4', 'data-kategori5', 'data-kategori6',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query1 = TblTestingAccess::find()
                                ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => [1, 2]])
                                ->exists();
                            if ($query1) {
                                $penilai = Yii::$app->session->get('user.penilai');
                                if ($penilai) {
                                    Yii::$app->session->remove('user.penilai');
                                }
                                return true;
                            } else {
                                throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'ticket-list', 'view-ticket-admin', 'view-ticket-content-admin', 'add-content-admin',
                            'pjax-ticket-list',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query1 = TblTestingAccess::find()
                                ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])
                                ->exists();
                            if ($query1) {
                                $penilai = Yii::$app->session->get('user.penilai');
                                if ($penilai) {
                                    Yii::$app->session->remove('user.penilai');
                                }
                                return true;
                            } else {
                                throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                            }
                        }
                    ],
                ]
            ]
        ];
    }

    public function actionBorang($lppid)
    {
        $lpp = $this->findLpp($lppid);
        // $this->dataFapi($lpp)['saiz_kelas']

        return $this->render('index', ['lpp' => $lpp]);
    }

    public function actionMaklumatGuru($lppid)
    {
        $lpp = $this->findLpp($lppid);
        $summary = $this->dataFapi($lpp);

        return $this->renderAjax('_info_guru', [
            'lpp' => $lpp,
            'summary' => $summary,
        ]);
    }

    public function actionPengajaranPenyeliaan($lppid)
    {
        $json =  $this->dataKategori1($lppid, $list);
        $json2 =  $this->dataKategori2($lppid, $list2, $data);

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $json,
            'pagination' => false,
        ]);

        $dataProvider2 = new \yii\data\ArrayDataProvider([
            'allModels' => $list,
            'pagination' => false,
        ]);

        $dataProvider3 = new \yii\data\ArrayDataProvider([
            'allModels' => $json2,
            'pagination' => false,
        ]);

        $dataProvider4 = new ActiveDataProvider([
            'query' => $data,
            'pagination' => false,
        ]);

        // return VarDumper::dump($data, $depth = 10, $highlight = true);

        $lpp = $this->findLpp($lppid);
        $result = ArrayHelper::index(array_merge($json, $json2), null, 'kategori');
        $this->kategori1_2($result, $lpp->gredGuru->gred, $peratusPemberatk12, $this->dataFapi($lpp)['k1_k2'], $this->dataFapi($lpp)['limpahan'], $arryminik1_2);
        $summary = $this->findSummaryMrkh($lppid);
        $summary->lpp_id = $lppid;
        $summary->k1_k2 = $peratusPemberatk12;
        $summary->save(false);

        return $this->renderAjax('_1_2', [
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
            'dataProvider3' => $dataProvider3,
            'dataProvider4' => $dataProvider4,
            'data' => $list2,
            'lpp' => $lpp,
            'miniSummary' => $arryminik1_2,
        ]);
    }

    public function actionPenyelidikanPenerbitan($lppid)
    {
        $json =  $this->dataKategori3($lppid, $list);
        $json2 =  $this->dataKategori4($lppid, $list2);

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $json,
            'pagination' => false,
        ]);

        $dataProvider2 = new \yii\data\ArrayDataProvider([
            'allModels' => $list,
            'pagination' => false,
        ]);

        $dataProvider3 = new \yii\data\ArrayDataProvider([
            'allModels' => $json2,
            'pagination' => false,
        ]);

        $dataProvider4 = new \yii\data\ArrayDataProvider([
            'allModels' => $list2,
            'pagination' => false,
        ]);

        $lpp = $this->findLpp($lppid);
        $result = ArrayHelper::index(array_merge($json, $json2), null, 'kategori');
        $this->kategori3_4($result, $lpp->gredGuru->gred, $peratusPemberatk12, $this->dataFapi($lpp)['k3_k4'], $this->dataFapi($lpp)['limpahan'], $arryminik3_4);
        $summary = $this->findSummaryMrkh($lppid);
        $summary->lpp_id = $lppid;
        $summary->k3_k4 = $peratusPemberatk12;
        $summary->save(false);

        return $this->renderAjax('_3_4', [
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
            'dataProvider3' => $dataProvider3,
            'dataProvider4' => $dataProvider4,
            'miniSummary' => $arryminik3_4,
            'lpp' => $lpp,
        ]);
    }

    public function actionPerkhidmatan($lppid)
    {
        $json =  $this->dataKategori5($lppid, $list);
        // $json2 =  $this->dataKategori4($lppid, $list2);

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $json,
            'pagination' => false,
        ]);

        $dataProvider2 = new \yii\data\ArrayDataProvider([
            'allModels' => $list,
            'pagination' => false,
        ]);

        // $dataProvider3 = new \yii\data\ArrayDataProvider([
        //     'allModels' => $json2,
        //     'pagination' => false,
        // ]);

        // $dataProvider4 = new \yii\data\ArrayDataProvider([
        //     'allModels' => $list2,
        //     'pagination' => false,
        // ]);

        $lpp = $this->findLpp($lppid);
        $result = ArrayHelper::index(array_merge($json), null, 'kategori');
        $this->kategori5($result, (empty($this->currentJawatanTadbir($lpp)) ? 0 : 1), $lpp->gredGuru->gred, $peratusPemberatk12, $this->dataFapi($lpp)['k5'], $this->dataFapi($lpp)['limpahan'], $arryminik5);
        $summary = $this->findSummaryMrkh($lppid);
        $summary->lpp_id = $lppid;
        $summary->k5 = $peratusPemberatk12;
        $summary->save(false);

        return $this->renderAjax('_5', [
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
            // 'dataProvider3' => $dataProvider3,
            // 'dataProvider4' => $dataProvider4,
            'lpp' => $lpp,
            'miniSummary' => $arryminik5,
        ]);
    }

    public function actionKlinikal($lppid)
    {
        $json =  $this->dataKategori6($lppid, $clinical);
        // $json2 =  $this->dataKategori4($lppid, $list2);

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $json,
            'pagination' => false,
        ]);

        $dataProvider2 = new \yii\data\ArrayDataProvider([
            'allModels' => $clinical,
            'pagination' => false,
        ]);

        // $dataProvider3 = new \yii\data\ArrayDataProvider([
        //     'allModels' => $json2,
        //     'pagination' => false,
        // ]);

        // $dataProvider4 = new \yii\data\ArrayDataProvider([
        //     'allModels' => $list2,
        //     'pagination' => false,
        // ]);

        $lpp = $this->findLpp($lppid);
        $result = ArrayHelper::index(array_merge($json), null, 'kategori');
        $this->kategori6($result, $lpp->gredGuru->gred, $peratusPemberatk12, $this->dataFapi($lpp)['k6'], $this->dataFapi($lpp)['limpahan'], $arryminik6);
        $summary = $this->findSummaryMrkh($lppid);
        $summary->lpp_id = $lppid;
        $summary->k6 = $peratusPemberatk12;
        $summary->save(false);

        return $this->renderAjax('_6', [
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
            // 'dataProvider3' => $dataProvider3,
            // 'dataProvider4' => $dataProvider4,
            'miniSummary' => $arryminik6,
            'lpp' => $lpp,
        ]);
    }

    public function actionRingkasanMarkah($lppid)
    {
        $lpp = $this->findLpp($lppid);
        $summary = $this->findSummaryMrkh($lppid);
        $kategori = $this->getJulatPeratus(((($summary->k1_k2 + $summary->k3_k4 + $summary->k5 + $summary->k6) / 100 * 90) + 0));
        $fapi = $this->dataFapi($lpp);

        return $this->renderAjax('_summary', [
            'lpp' => $lpp,
            'summary' => $summary,
            'kategori' => $kategori,
            'fapi' => $fapi,
        ]);
    }

    public function actionSahsiah($lppid)
    {
        $lpp = $this->findLpp($lppid);

        $mrkhKualiti = TblMarkahKualiti::find()
            ->alias('a')
            ->select('a.*, b.id as ref_id, b.*')
            ->rightJoin(['b' => 'hrm.`elnpt_v2_ref_aspek_penilaian`'], 'a.`ref_kualiti_id` = b.`id` and a.`lpp_id` = ' . $lppid)
            ->where(['b.`bhg_no`' => 10])
            ->orderBy(['ref_id' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $mrkhKualiti,
            'pagination' => false,
        ]);

        $late = \app\models\kehadiran\TblRekod::find()
            ->where(['icno' => $lpp->PYD, 'YEAR(tarikh)' => $lpp->tahun, 'late_in' => 1])
            ->andWhere(['!=', 'remark_status', 'APPROVED'])
            ->count();

        $absent = \app\models\kehadiran\TblRekod::find()
            ->where(['icno' => $lpp->PYD, 'YEAR(tarikh)' => $lpp->tahun, 'absent' => 1])
            ->andWhere(['!=', 'remark_status', 'APPROVED'])
            ->count();

        $arry = clone $mrkhKualiti;
        $arry = $arry->asArray()->all();
        $sumPPP =  ((array_sum(array_column($arry, 'markah_ppp'))) / 600 * 100) * ($this->isInstitute($lpp->jfpiu) ? 0.6 : 0.4);
        $sumPPK =  ((array_sum(array_column($arry, 'markah_ppk'))) / 600 * 100) * ($this->isInstitute($lpp->jfpiu) ? 0.6 : 0.4);
        $sumPEER =  ((array_sum(array_column($arry, 'markah_peer'))) / 600 * 100) * ($this->isInstitute($lpp->jfpiu) ? 0.3 : 0.2);
        $totalMrkhKualiti =  $sumPPP +  $sumPPK + $sumPEER;

        $summary = $this->findSummaryMrkh($lppid);
        $summary->lpp_id = $lppid;
        $summary->sahsiah = $totalMrkhKualiti;
        $summary->save(false);

        return $this->renderAjax('_sahsiah', [
            'dataProvider' => $dataProvider,
            'lpp' => $lpp,
            'late' => $late,
            'absent' => $absent,
            // 'fapi' => $fapi,
        ]);
    }

    protected function isInstitute($dept_id)
    {
        if (in_array($dept_id, [5, 6, 7])) {
            return true;
        }

        return false;
    }

    public function actionUpdateSahsiah($lppid)
    {
        // Check if there is an Editable ajax request
        if (isset($_POST['hasEditable'])) {
            if (($model = TblMarkahKualiti::find()->where(['lpp_id' => $lppid, 'ref_kualiti_id' => $_POST['editableKey']])->one()) == null) {
                $model = new TblMarkahKualiti(); // your model can be loaded here
                $model->lpp_id = $lppid;
                $model->ref_kualiti_id = $_POST['editableKey'];
            }

            $val = $_POST['TblMarkahKualiti'][$_POST['editableIndex']][$_POST['editableAttribute']];
            $model->{$_POST['editableAttribute']} = $val ?? 0;

            // use Yii's response format to encode output as JSON
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            // read your posted model attributes
            if ($model->validate()) {
                $model->save(false);
                // // read or convert your posted information

                // return JSON encoded output in the below format
                return ['output' => $val ?? 0, 'message' =>  ''];

                // alternatively you can return a validation error
                // return ['output'=>'', 'message'=>'Validation error'];
            }
            // else if nothing to do always return an empty JSON encoded output
            else {
                return ['output' => '', 'message' => 'Invalid input'];
            }
        }
    }

    protected function findLpp($lppid)
    {
        if (($model = TblMain::find()->where(['lpp_id' => $lppid])->one()) !== null) {
            return $model;
        }
        throw new UserException('The requested data does not exist.');
    }

    // public function actionDataKategori1($lppid)
    protected function dataKategori1($lppid, &$list)
    {
        // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $inputs = \app\models\elnpt\simulation\RefAktivitiv2::find()->where(['kategori' => 1])->orderBy(['kategori' => SORT_ASC, 'kategori' => SORT_ASC, 'order_no' => SORT_ASC, 'isHakiki' => SORT_ASC])->indexBy('id')->asArray()->all();

        $lpp = $this->findLpp($lppid);

        $semester = [
            '2-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '' => '2-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '',
            '3-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '' => '3-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '',
            '1-' . ($lpp->tahun) . '/' . ($lpp->tahun + 1) . '' => '1-' . ($lpp->tahun) . '/' . ($lpp->tahun + 1) . '',
        ];

        $pengajaran = TblPengajaranPembelajaran::find()
            ->select(new Expression('a.id as AutoId, \'1\' as manual, \'Fail\' as status, a.*, b.filehash as file_hash, b.verified_by as ver_by, b.verified_dt as ver_dt, \'0\' as pk07, c.semester as semester, c.status_fail, c.seksyen as seksyen, c.bil_pelajar as bil_pelajar'))
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
            SEKSYEN as seksyen, SESI as semester, JAMKREDIT, \'0\' as DISPLAY, \'-\' as skop_tugas, 
            \'-\' as status_pengendalian, \'-\' as penglibatan, \'Fail\' as status, \'\' as file_hash, \'SMP UMS\' as ver_by, \'SMP UMS\' as ver_dt, \'0\' as pk07, \'0\' as status_fail'))
            ->where(['NOKP' => $lpp->PYD])
            ->andWhere(['SESI' => array_keys($semester)])
            ->orderBy(['AutoId' => SORT_ASC])
            ->indexBy('AutoId')
            ->asArray()
            ->all();

        $list = $pengajaran + $pengajaran2;

        $pnp = TblPnP::find()->where(['lpp_id' => $lpp->lpp_id, 'id_pnp' => ArrayHelper::getColumn($list, 'AutoId')])->indexBy('id_pnp')->asArray()->all();

        foreach ($pnp as $ind => $pp) {
            // $list[$ind]['skop_tugas'] = ($pp['skop_tugas'] == 'Pensyarah_Penyelaras') ?  'Pensyarah & Penyelaras' :  $pp['skop_tugas'];
            $list[$ind]['hasTech'] = $pp['hasTech'] ? 'Yes' : 'No';
            $list[$ind]['semester'] = $pp['semester'];
            $list[$ind]['jam_syarahan'] = $pp['jam_syarahan'];
            $list[$ind]['jam_tutorial'] = $pp['jam_tutorial'];
            $list[$ind]['jam_amali'] = $pp['jam_amali'];
        }

        // return $list;

        //pengajaran-3
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
        $tets = array_merge($pk07, $pk07_fpsk);

        foreach ($pengajaran as $ind1 => $p2) {
            foreach ($tets as $ind2 => $b2) {
                if ((str_replace(' ', '', $p2['semester']) == $b2['KodSesi']) && ($p2['kod_kursus'] == $b2['KodKursus']) && ($p2['SEKSYEN'] == $b2['Seksyen'])) {
                    $pengajaran[$ind1]['pk07'] = $b2['FinalMean'];
                    unset($tets[$ind2]);
                    break;
                } else {
                    // $pengajaran[$ind1]['pk07'] = $this->statusPK07($lpp->jfpiu, $lpp->tahun) ? 4.5 : 0;
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
                    // $pengajaran2[$ind1]['pk07'] = $this->statusPK07($lpp->jfpiu, $lpp->tahun) ? 4.5 : 0;
                }
            }
        }
        $input3 = (count($pengajaran2) != 0) ? array_sum(ArrayHelper::getColumn($pengajaran2, 'pk07')) / count($pengajaran2) : 0;
        $inputs['3']['auto'] = 1;
        $inputs['3']['input'] = is_nan($input3) ? 0 : $input3;

        //pengajaran-4,5,7
        $pass = 0;
        $lengkap = 0;
        $bil_pelajar = 0;
        $pbl = 0;

        $smartv33 = TblSmartV3::find()
            ->select(['id', new Expression('\'\' as username_ic_pasportNo'), 'fullname', 'status', 'name', 'email', new Expression('\'SmartV3\' as sumber')])
            ->where(['LIKE', 'name', $lpp->guru->CONm])
            ->orFilterWhere(['LIKE', 'email', $lpp->guru->COEmail])
            ->orFilterWhere(['LIKE', 'email', $lpp->guru->COEmail2])
            ->andWhere(['NOT LIKE', 'fullname', new Expression('\'%PEPERIKSAAN %\'')])
            ->orderBy(['status' => SORT_ASC]);
        $smartv3 = $smartv33->asArray()->all();

        $inputs['1']['lain'] = 1;
        $inputs['1']['input'] = 0;
        $inputs['2']['lain'] = 1;
        $inputs['2']['input'] = 0;

        $subjek = [];
        foreach ($list as $ind1 => $p2) {
            if ($list[$ind1]['status_fail'] == 'Ada - Lengkap') {
                $lengkap++;
            }

            if ($list[$ind1]['hasTech'] == 'Yes') {
                $pbl++;
            }

            if (substr($list[$ind1]['semester'], 0, 1) == '1') {
                $inputs['1']['input'] += $list[$ind1]['jam_syarahan'] + $list[$ind1]['jam_tutorial'] + $list[$ind1]['jam_amali'];
            }

            if (substr($list[$ind1]['semester'], 0, 1) == '2') {
                $inputs['2']['input'] += $list[$ind1]['jam_syarahan'] + $list[$ind1]['jam_tutorial'] + $list[$ind1]['jam_amali'];
            }

            $bil_pelajar = $list[$ind1]['bil_pelajar'] + $bil_pelajar;

            if (in_array($list[$ind1]['kod_kursus'], $subjek)) {
                $pass++;
                $list[$ind1]['status'] = 'Pass';
                continue;
            }
            foreach ($smartv3 as $b2) {
                if ((stripos($b2['fullname'], $list[$ind1]['kod_kursus']) !== false) && (stripos($b2['fullname'], $list[$ind1]['semester']) !== false)) {
                    if ($b2['status'] == 'Pass') {
                        $pass++;
                        $list[$ind1]['status'] = $b2['status'];
                        break;
                    }
                }
            }
        }

        $inputs['4']['auto'] = 1;
        $inputs['4']['input'] = $pass ?? 0;
        $inputs['5']['lain'] = 1;
        $inputs['5']['input'] = $lengkap ?? 0;

        //pengajaran-6 on hold
        $inputs['6']['auto'] = 1;
        $inputs['6']['input'] = 1;

        //pengajaran-7
        $inputs['7']['auto'] = 1;
        $inputs['7']['input'] = $bil_pelajar ?? 0;

        //pengajaran-8 tiada data
        $inputs['8']['lain'] = 1;
        $inputs['8']['input'] = $pbl ?? 0;

        //pengajaran-9 tiada data
        $inputs['9']['auto'] = 1;
        $inputs['9']['input'] = 0;

        //pengajaran-9 tiada data
        $inputs['10']['auto'] = 1;
        $inputs['10']['input'] = 0;

        //pengajaran-9 tiada data
        $inputs['11']['auto'] = 1;
        $inputs['11']['input'] = 0;

        //pengajaran-9 tiada data
        $inputs['12']['auto'] = 1;
        $inputs['12']['input'] = 0;

        //pengajaran-9 tiada data
        $inputs['13']['modal'] = 1;
        $inputs['13']['lain'] = 1;
        $inputs['13']['input'] = 0;

        $this->calcKategori1($inputs, $this->dataFapi($lpp)['saiz_kelas'], strtoupper($this->currentJawatanTadbir($lpp)));

        return $inputs;
    }

    protected function calcKategori1(&$inputsKategori1, $bil_pelajar = 50, $jawatan)
    {
        foreach ($inputsKategori1 as $ind => $ik1) {
            if ($ik1['kategori'] == 1) {
                ArrayHelper::setValue($inputKomponen1, ($ind), ['skor' => $ik1['input'], 'nilai_mata' => $ik1['nilai_mata_id'], 'order_no' => $ik1['order_no'], 'kategori' => $ik1['kategori']]);
            }
        }

        $mataKomponen1 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 1, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();

        foreach ($inputKomponen1 as $ind => $ik) {
            ArrayHelper::setValue($skorKomponen1, $ind, (($ind == 7) ? (((1 / $bil_pelajar) * $ik['skor'])) : (($mataKomponen1[$ik['order_no']]['nilai_mata'] * $ik['skor']))));
        }

        foreach ($inputsKategori1 as $ind => $sett) {
            if ($sett['kategori'] == 1) {
                if ($ind == 1) {
                    $inputsKategori1[$ind]['mata'] = $skorKomponen1[$ind] * \app\models\elnpt\simulation\TblCalcInput::jawatanPentadbiran()[$jawatan];
                    continue;
                }

                $inputsKategori1[$ind]['mata'] = $skorKomponen1[$ind];
            }
        }
    }

    protected function manualKategori1(&$pnp, $lpp, $list)
    {
        if (($pnp = TblPnP::find()->where(['lpp_id' => $lpp->lpp_id])->indexBy('id_pnp')->all()) != null) {
            $pnp = TblPnP::find()->where(['lpp_id' => $lpp->lpp_id, 'id_pnp' => ArrayHelper::getColumn($list, 'AutoId')])->indexBy('id_pnp')->all();
        } else {
            $pnp = [new TblPnP()];
            // for ($i = 0; $i < sizeof($list); $i++) {
            //     $pnp = new TblPnP();
            //     $pnp->id_pnp = $list[$i]['AutoId'];
            //     $pnp->lpp_id = $lpp->lpp_id;
            //     $pnp->save(false);
            // }
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
    }

    public function actionUpdatePengajaran($lppid)
    {
        // Check if there is an Editable ajax request
        if (isset($_POST['hasEditable'])) {
            if (($model = TblPnp::find()->where(['lpp_id' => $lppid, 'id_pnp' => $_POST['editableKey']])->one()) == null) {
                $model = new TblPnp(); // your model can be loaded here
            }

            $model->{$_POST['editableAttribute']} = $_POST[$_POST['editableAttribute']] ?? 0;

            // use Yii's response format to encode output as JSON
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            // read your posted model attributes
            if ($model->validate()) {
                $model->save(false);
                // // read or convert your posted information
                // $value = $model->skop_tugas;
                // if ($_POST['editableAttribute'] == 'hasTech') {
                //     if ($_POST[$_POST['editableAttribute']] == null) {
                //         $_POST[$_POST['editableAttribute']] = 0;
                //     }
                // }

                // return JSON encoded output in the below format
                return ['output' => $_POST[$_POST['editableAttribute']] ?? 0, 'message' => ''];

                // alternatively you can return a validation error
                // return ['output'=>'', 'message'=>'Validation error'];
            }
            // else if nothing to do always return an empty JSON encoded output
            else {
                return ['output' => '', 'message' => 'Invalid input'];
            }
        }
    }

    public function actionCreatePnp($lppid)
    {
        $pnp = new TblPengajaranPembelajaran();
        $tblPnp = new TblPnP();
        $doc = new TblDocuments();
        $lpp = $this->findLpp($lppid);
        if ($pnp->load(Yii::$app->request->post())) {
            $pnp->lpp_id = $lppid;
            $tblPnp->load(Yii::$app->request->post());
            if ($pnp->validate() && $pnp->save(false)) {
                $tblPnp->id_pnp = $pnp->id;
                $tblPnp->lpp_id = $lppid;
                $tblPnp->save(false);
                $doc->file = UploadedFile::getInstance($doc, 'file');
                $this->addDocument($doc, $lppid, 1, $pnp->id);
                return $this->renderAjax('_success-insert');
            }
        }
        return $this->renderAjax('create_bhg1', [
            'pnp' => $pnp,
            'doc' => $doc,
            'tblPnp' => $tblPnp,
            'lpp' => $lpp
        ]);
    }

    public function actionDeletePnp($id, $lppid)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $pnp = TblPengajaranPembelajaran::findOne($id);
        $tblPnp = TblPnP::find()->where(['id_pnp' => $id, 'lpp_id' => $lppid])->one();
        if (!$pnp) {
            throw new NotFoundHttpException("The requested page does not exist.");
            return ['success' => false];
        }
        $pnp->delete();
        $tblPnp->delete();
        $this->delDocument($lppid, 1, $id);

        return ['success' => true];
    }

    public function actionPjaxDataK1($lppid)
    {
        $json =  $this->dataKategori1($lppid, $list);

        $dataProvider2 = new \yii\data\ArrayDataProvider([
            'allModels' => $list,
            'pagination' => false,
        ]);

        return $this->renderAjax('_test', [
            'dataProvider2' => $dataProvider2,
            'lpp' => $this->findLpp($lppid),
        ]);
    }

    public function actionPjaxResultK1($lppid)
    {
        $json =  $this->dataKategori1($lppid, $list);
        $json2 =  $this->dataKategori2($lppid, $list2, $data);

        $lpp = $this->findLpp($lppid);
        $result = ArrayHelper::index(array_merge($json, $json2), null, 'kategori');
        $this->kategori1_2($result, $lpp->gredGuru->gred, $peratusPemberatk12, $this->dataFapi($lpp)['k1_k2'], $this->dataFapi($lpp)['limpahan'], $arryminik1_2);
        $summary = $this->findSummaryMrkh($lppid);
        $summary->lpp_id = $lppid;
        $summary->k1_k2 = $peratusPemberatk12;
        $summary->save(false);

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $json,
            'pagination' => false,
        ]);

        return $this->renderAjax('_test_1', [
            'dataProvider' => $dataProvider,
            'lpp' => $lpp,
        ]);
    }

    public function actionPjaxResultK2($lppid)
    {
        $json =  $this->dataKategori1($lppid, $list);
        $json2 =  $this->dataKategori2($lppid, $list2, $data);

        $lpp = $this->findLpp($lppid);
        $result = ArrayHelper::index(array_merge($json, $json2), null, 'kategori');
        $this->kategori1_2($result, $lpp->gredGuru->gred, $peratusPemberatk12, $this->dataFapi($lpp)['k1_k2'], $this->dataFapi($lpp)['limpahan'], $arryminik1_2);
        $summary = $this->findSummaryMrkh($lppid);
        $summary->lpp_id = $lppid;
        $summary->k1_k2 = $peratusPemberatk12;
        $summary->save(false);

        $dataProvider3 = new \yii\data\ArrayDataProvider([
            'allModels' => $json2,
            'pagination' => false,
        ]);

        return $this->renderAjax('_test_2', [
            'dataProvider3' => $dataProvider3,
            'lpp' => $lpp,
        ]);
    }


    public function actionUpdatePenyeliaan($lppid, $id = '', $tahap)
    {
        // Check if there is an Editable ajax request
        if (isset($_POST['hasEditable'])) {
            if (($model = TblPenyeliaanManual::find()->where(['lpp_id' => $lppid, 'tahap_penyeliaan' => $tahap,])->orWhere(['id' => $id])->one()) == null) {
                $model = new TblPenyeliaanManual(); // your model can be loaded here
                $model->lpp_id = $lppid;
                $model->tahap_penyeliaan = $tahap;
                $model->save();
                $model->refresh();
            }

            // use Yii's response format to encode output as JSON
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if (isset($_FILES['file'])) {
                if (($doc = TblDocuments::find()->where(['lpp_id' => $lppid, 'bhg_no' => 2, 'id_table' => $id])->one()) == null) {
                    $doc = new TblDocuments();
                }

                $tmp = UploadedFile::getInstanceByName('file');

                if ($doc->filehash) {
                    Yii::$app->FileManager->DeleteFile($doc->filehash);
                }

                $file = Yii::$app->FileManager->UploadFile($tmp->name, $tmp->tempName, '04', 'LNPT/Akademik/' . $this->getTahun($lppid) . '/bhg_' . 2 . '');
                if ($file->status == true) {
                    $doc->lpp_id = $lppid;
                    $doc->bhg_no = 2;
                    $doc->id_table = $id;
                    $doc->filehash = $file->file_name_hashcode;
                    $doc->file_name = $tmp->name;
                    $doc->created_dt = new \yii\db\Expression('NOW()');
                    $doc->save(false);

                    return ['output' => $file->file_name_hashcode, 'message' => ''];
                }
                return ['output' => '', 'message' => 'Invalid file'];
            }

            $model->{array_key_last($_POST)} = end($_POST) ?? 0;

            // read your posted model attributes
            if ($model->validate()) {
                // read or convert your posted information
                $model->save();

                // return JSON encoded output in the below format
                return ['output' => end($_POST), 'message' => ''];

                // alternatively you can return a validation error
                // return ['output'=>'', 'message'=>'Validation error'];
            }
            // else if nothing to do always return an empty JSON encoded output
            else {
                return ['output' => '', 'message' => 'Invalid input'];
            }
        }
    }

    // public function actionDataKategori2($lppid)
    protected function dataKategori2($lppid, &$tmpP, &$data)
    {
        // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $inputs = \app\models\elnpt\simulation\RefAktivitiv2::find()->where(['kategori' => 2])->orderBy(['kategori' => SORT_ASC, 'kategori' => SORT_ASC, 'order_no' => SORT_ASC, 'isHakiki' => SORT_ASC])->indexBy('id')->asArray()->all();

        $lpp = $this->findLpp($lppid);

        // $penyeliaan_manual = TblPenyeliaanManual::find()
        //     ->alias('a')
        //     ->select([
        //         'a.id as id', 'a.lpp_id as lpp_id', 'b.id as tahap_penyeliaan', 'a.utama_belum', 'a.utama_telah_sem', 'a.utama_telah', 'a.sama_belum',
        //         'a.sama_telah_sem', 'a.sama_telah', 'a.verified_by', 'a.verified_dt', 'a.bil_pelajar'
        //     ])
        //     ->rightJoin(['b' => '`hrm`.`elnpt_v3_ref_penyeliaan`'], '`a`.`tahap_penyeliaan` = `b`.`id` AND `a`.`lpp_id`=' . $lppid)
        //     ->where(['b.id' => [4, 5, 6, 7, 8]])
        //     ->orderBy(['b.`id`' => 'SORT_ASC'])
        //     ->all();

        // if ($penyeliaan_manual == null) {
        //     $penyeliaan_manual = [new TblPenyeliaanManual()];
        //     for ($i = 1; $i <= 5; $i++) {
        //         $penyeliaan_manual[] = new TblPenyeliaanManual();
        //         $penyeliaan_manual[$i]->lpp_id = $lppid;
        //         $penyeliaan_manual[$i]->tahap_penyeliaan = 3 + $i;
        //     }
        //     unset($penyeliaan_manual[0]);
        // }

        // return $penyeliaan_manual;

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

        $tmp = array_merge_recursive($utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);

        $init2 = [
            '4' => [
                'utama_belum' => 0,
                'utama_telah_sem' => 0,
                'utama_telah' => 0,
                'sama_belum' => 0,
                'sama_telah_sem' => 0,
                'sama_telah' => 0,
            ],
            '5' => [
                'utama_belum' => 0,
                'utama_telah_sem' => 0,
                'utama_telah' => 0,
                'sama_belum' => 0,
                'sama_telah_sem' => 0,
                'sama_telah' => 0,
            ],
            '6' => [
                'utama_belum' => 0,
                'utama_telah_sem' => 0,
                'utama_telah' => 0,
                'sama_belum' => 0,
                'sama_telah_sem' => 0,
                'sama_telah' => 0,
            ],
            '7' => [
                'utama_belum' => 0,
                'utama_telah_sem' => 0,
                'utama_telah' => 0,
                'sama_belum' => 0,
                'sama_telah_sem' => 0,
                'sama_telah' => 0,
            ],
            '5' => [
                'utama_belum' => 0,
                'utama_telah_sem' => 0,
                'utama_telah' => 0,
                'sama_belum' => 0,
                'sama_telah_sem' => 0,
                'sama_telah' => 0,
            ],
        ];

        $tst = [];

        $tmpp = TblPelajarManual::find()
            // ->alias('a')
            // ->select('a.*, b.*')
            // ->rightJoin(['b' => 'hrm.elnpt_v3_ref_penyeliaan'], 'a.`level_pengajian` = b.`id` and a.`lpp_id` = ' . $lppid . '')
            // ->where(['>', 'b.`id`', 3])
            ->where(['lpp_id' => $lppid])
            ->asArray()
            ->all();

        foreach ($tmpp as $tp) {
            if (in_array($tp['tahap_penyeliaan'], [1, 4, 2])) {
                if (in_array($tp['status_penyeliaan'], [01, 31, 32, 33, 06, 16])) {
                    $tst[$tp['level_pengajian']]['utama_belum'] += 1;
                }
                if (in_array($tp['status_penyeliaan'], [51, 52])) {
                    $tst[$tp['level_pengajian']]['utama_telah_sem'] += 1;
                }
                if (in_array($tp['status_penyeliaan'], [53, 54, 56, 57])) {
                    $tst[$tp['level_pengajian']]['utama_telah'] += 1;
                }
            }

            if (in_array($tp['tahap_penyeliaan'], [3, 5])) {
                if (in_array($tp['status_penyeliaan'], [01, 31, 32, 33, 06, 16])) {
                    $tst[$tp['level_pengajian']]['sama_belum'] += 1;
                }
                if (in_array($tp['status_penyeliaan'], [51, 52])) {
                    $tst[$tp['level_pengajian']]['sama_telah_sem'] += 1;
                }
                if (in_array($tp['status_penyeliaan'], [53, 54, 56, 57])) {
                    $tst[$tp['level_pengajian']]['sama_telah'] += 1;
                }
            }
        }

        $tst = array_replace_recursive($init2, $tst);

        // return VarDumper::dump(array_replace_recursive($init2, $tst), $depth = 10, $highlight = true);

        foreach ($tmp as $id => $t) {
            ArrayHelper::setValue($tmpP, [$id, 'utama_belum'], is_array($tmp[$id]['utama_belum']) ? array_sum($tmp[$id]['utama_belum']) : $tmp[$id]['utama_belum']);
            ArrayHelper::setValue($tmpP, [$id, 'utama_telah_sem'], is_array($tmp[$id]['utama_telah_sem']) ? array_sum($tmp[$id]['utama_telah_sem']) : $tmp[$id]['utama_telah_sem']);
            ArrayHelper::setValue($tmpP, [$id, 'utama_telah'], is_array($tmp[$id]['utama_telah']) ? array_sum($tmp[$id]['utama_telah']) : $tmp[$id]['utama_telah']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_belum'], is_array($tmp[$id]['sama_belum']) ? array_sum($tmp[$id]['sama_belum']) : $tmp[$id]['sama_belum']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_telah_sem'], is_array($tmp[$id]['sama_telah_sem']) ? array_sum($tmp[$id]['sama_telah_sem']) : $tmp[$id]['sama_telah_sem']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_telah'], is_array($tmp[$id]['sama_telah']) ? array_sum($tmp[$id]['sama_telah']) : $tmp[$id]['sama_telah']);
        }

        foreach ($tst as $id => $pm) {
            if ($id == 4) {
                $tmpP['kerja_kursus']['utama_belum'] = $pm['utama_belum'] ?? 0;
                $tmpP['kerja_kursus']['utama_telah_sem'] = $pm['utama_telah_sem'] ?? 0;
                $tmpP['kerja_kursus']['utama_telah'] = $pm['utama_telah'] ?? 0;
                $tmpP['kerja_kursus']['sama_belum'] = $pm['sama_belum'] ?? 0;
                $tmpP['kerja_kursus']['sama_telah_sem'] = $pm['sama_telah_sem'] ?? 0;
                $tmpP['kerja_kursus']['sama_telah'] = $pm['sama_telah'] ?? 0;
            } elseif ($id == 5) {
                $tmpP['sarjana_muda']['utama_belum'] = $pm['utama_belum'] ?? 0;
                $tmpP['sarjana_muda']['utama_telah_sem'] = $pm['utama_telah_sem'] ?? 0;
                $tmpP['sarjana_muda']['utama_telah'] = $pm['utama_telah'] ?? 0;
                $tmpP['sarjana_muda']['sama_belum'] = $pm['sama_belum'] ?? 0;
                $tmpP['sarjana_muda']['sama_telah_sem'] = $pm['sama_telah_sem'] ?? 0;
                $tmpP['sarjana_muda']['sama_telah'] = $pm['sama_telah'] ?? 0;
            } elseif ($id == 6) {
                $tmpP['sarjana_muda_2']['utama_belum'] = $pm['utama_belum'] ?? 0;
                $tmpP['sarjana_muda_2']['utama_telah_sem'] = $pm['utama_telah_sem'] ?? 0;
                $tmpP['sarjana_muda_2']['utama_telah'] = $pm['utama_telah'] ?? 0;
                $tmpP['sarjana_muda_2']['sama_belum'] = $pm['sama_belum'] ?? 0;
                $tmpP['sarjana_muda_2']['sama_telah_sem'] = $pm['sama_telah_sem'] ?? 0;
                $tmpP['sarjana_muda_2']['sama_telah'] = $pm['sama_telah'] ?? 0;
            } elseif ($id == 7) {
                $tmpP['sarjana_muda_klinikal']['utama_belum'] = $pm['utama_belum'] ?? 0;
                $tmpP['sarjana_muda_klinikal']['utama_telah_sem'] = $pm['utama_telah_sem'] ?? 0;
                $tmpP['sarjana_muda_klinikal']['utama_telah'] = $pm['utama_telah'] ?? 0;
                $tmpP['sarjana_muda_klinikal']['sama_belum'] = $pm['sama_belum'] ?? 0;
                $tmpP['sarjana_muda_klinikal']['sama_telah_sem'] = $pm['sama_telah_sem'] ?? 0;
                $tmpP['sarjana_muda_klinikal']['sama_telah'] = $pm['sama_telah'] ?? 0;
            } else {
                $tmpP['pasca']['utama_belum'] = $pm['utama_belum'] ?? 0;
                $tmpP['pasca']['utama_telah_sem'] = $pm['utama_telah_sem'] ?? 0;
                $tmpP['pasca']['utama_telah'] = $pm['utama_telah'] ?? 0;
                $tmpP['pasca']['sama_belum'] = $pm['sama_belum'] ?? 0;
                $tmpP['pasca']['sama_telah_sem'] = $pm['sama_telah_sem'] ?? 0;
                $tmpP['pasca']['sama_telah'] = $pm['sama_telah'] ?? 0;
            }
        }

        // return VarDumper::dump($tmpP, $depth = 10, $highlight = true);
        // return $tmpP;

        $selia_arry = [];

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

        // foreach ($selia_arry as $sa) {
        //     // foreach ($skor as $s) {
        //     if (($sa['tahap_penyeliaan'] ?? -1) == $s['id']) {
        //         $sum = ($sa['utama_belum']) + ($sa['utama_telah_sem']) + ($sa['utama_telah']) + ($sa['sama_belum']) + ($sa['sama_telah_sem']) + ($sa['sama_telah']);
        //         ArrayHelper::setValue($mrkhbhg, $sa['tahap_penyeliaan'], ['skor' => $sum]);
        //         break;
        //     }
        //     // }
        // }

        //penyeliaan-14
        $inputs['14']['auto'] = 1;
        $inputs['14']['input'] =  $selia_arry[0]['utama_belum'] + $selia_arry[1]['utama_telah_sem'] + $selia_arry[0]['utama_telah'];
        //penyeliaan-15
        $inputs['15']['auto'] = 1;
        $inputs['15']['input'] =  $selia_arry[0]['sama_belum'] + $selia_arry[1]['sama_telah_sem'] + $selia_arry[0]['sama_telah'];
        //penyeliaan-16
        $inputs['16']['auto'] = 1;
        $inputs['16']['input'] =  $selia_arry[1]['utama_belum'] + $selia_arry[0]['utama_telah_sem'] + $selia_arry[1]['utama_telah'];
        //penyeliaan-17
        $inputs['17']['auto'] = 1;
        $inputs['17']['input'] =  $selia_arry[1]['sama_belum'] + $selia_arry[0]['sama_telah_sem'] + $selia_arry[1]['sama_telah'];
        //penyeliaan-18
        $inputs['18']['auto'] = 1;
        $inputs['18']['input'] =  $selia_arry[2]['utama_belum'] + $selia_arry[2]['utama_telah_sem'] + $selia_arry[2]['utama_telah'];
        //penyeliaan-19
        $inputs['19']['auto'] = 1;
        $inputs['19']['input'] =  $selia_arry[2]['sama_belum'] + $selia_arry[2]['sama_telah_sem'] + $selia_arry[2]['sama_telah'];

        //penyeliaan-20
        $inputs['24']['lain'] = 1;
        $inputs['24']['input'] = $selia_arry[3]['utama_belum'] + $selia_arry[3]['utama_telah_sem'] + $selia_arry[3]['utama_telah'];
        //penyeliaan-21
        $inputs['25']['lain'] = 1;
        $inputs['25']['input'] = $selia_arry[3]['sama_belum'] + $selia_arry[3]['sama_telah_sem'] + $selia_arry[3]['sama_telah'];
        //penyeliaan-22
        $inputs['22']['lain'] = 1;
        $inputs['22']['input'] = $selia_arry[4]['utama_belum'] + $selia_arry[4]['utama_telah_sem'] + $selia_arry[4]['utama_telah'];
        //penyeliaan-23
        $inputs['23']['lain'] = 1;
        $inputs['23']['input'] = $selia_arry[4]['sama_belum'] + $selia_arry[4]['sama_telah_sem'] + $selia_arry[4]['sama_telah'];
        //penyeliaan-24
        $inputs['224']['lain'] = 1;
        $inputs['224']['input'] = $selia_arry[5]['utama_belum'] + $selia_arry[5]['utama_telah_sem'] + $selia_arry[5]['utama_telah'];
        //penyeliaan-25
        $inputs['225']['lain'] = 1;
        $inputs['225']['input'] = $selia_arry[5]['sama_belum'] + $selia_arry[5]['sama_telah_sem'] + $selia_arry[5]['sama_telah'];
        //penyeliaan-20
        $inputs['20']['lain'] = 1;
        $inputs['20']['input'] = $selia_arry[6]['utama_belum'] + $selia_arry[6]['utama_telah_sem'] + $selia_arry[6]['utama_telah'];
        //penyeliaan-21
        $inputs['21']['lain'] = 1;
        $inputs['21']['input'] = $selia_arry[6]['sama_belum'] + $selia_arry[6]['sama_telah_sem'] + $selia_arry[6]['sama_telah'];

        //penyeliaan-26
        $inputs['26']['auto'] = 1;
        $inputs['26']['input'] = $selia_arry[7]['utama_belum'] + $selia_arry[7]['utama_telah_sem'] + $selia_arry[7]['utama_telah'];
        //penyeliaan-27
        $inputs['27']['auto'] = 1;
        $inputs['27']['input'] = $selia_arry[7]['sama_belum'] + $selia_arry[7]['sama_telah_sem'] + $selia_arry[7]['sama_telah'];

        //penyeliaan-28
        $inputs['28']['lain'] = 1;
        $inputs['28']['input'] = 0;
        //penyeliaan-29;
        $inputs['29']['lain'] = 1;
        $inputs['29']['input'] = 0;
        //penyeliaan-30
        $inputs['30']['lain'] = 1;
        $inputs['30']['input'] = 0;
        //penyeliaan-31
        $inputs['31']['lain'] = 1;
        $inputs['31']['input'] = 0;

        //penyeliaan-32
        $inputs['32']['auto'] = 1;
        $inputs['32']['input'] = 0;
        //penyeliaan-33
        $inputs['33']['auto'] = 1;
        $inputs['33']['input'] = 0;
        //penyeliaan-34
        $inputs['34']['auto'] = 1;
        $inputs['34']['input'] = 0;
        //penyeliaan-35
        $inputs['35']['auto'] = 1;
        $inputs['35']['input'] = 0;

        // //penyeliaan-35
        // $inputs['35']['input'] = null;
        //penyeliaan-36
        $inputs['36']['lain'] = 1;
        $inputs['36']['input'] = 0;
        //penyeliaan-37
        $inputs['37']['lain'] = 1;
        $inputs['37']['input'] = 0;
        //penyeliaan-38
        $inputs['38']['lain'] = 1;
        $inputs['38']['input'] = 0;

        //penyeliaan-39
        $inputs['39']['lain'] = 1;
        $inputs['39']['input'] = 0;
        //penyeliaan-40
        $inputs['40']['lain'] = 1;
        $inputs['40']['input'] = 0;
        //penyeliaan-41
        $inputs['41']['lain'] = 1;
        $inputs['41']['input'] = 0;

        //penyeliaan-223
        $inputs['223']['modal'] = 1;
        $inputs['223']['lain'] = 1;
        $inputs['223']['input'] = 0;

        $this->calcKategori2($inputs);

        return $inputs;
    }

    protected function calcKategori2(&$inputsKategori2)
    {
        foreach ($inputsKategori2 as $ind => $ik1) {
            if ($ik1['kategori'] == 2) {
                ArrayHelper::setValue($inputKomponen1, ($ind), ['skor' => $ik1['input'], 'nilai_mata' => $ik1['nilai_mata_id'], 'order_no' => $ik1['order_no'], 'kategori' => $ik1['kategori']]);
            }
        }

        $mataKomponen1 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 2, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();
        $mataKomponen2 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 2, 'nilai_mata_id' => 2])->indexBy(['aktiviti_id'])->asArray()->all();

        foreach ($inputKomponen1 as $ind => $ik) {
            ArrayHelper::setValue($skorKomponen2, $ind, (($ik['nilai_mata'] == 1) ? (($mataKomponen1[$ik['order_no']]['nilai_mata'] * $ik['skor'])) : (($mataKomponen2[$ik['order_no']]['nilai_mata'] * $ik['skor']))));
        }

        foreach ($inputsKategori2 as $ind => $sett) {
            if ($sett['kategori'] == 2) {
                $inputsKategori2[$ind]['mata'] = $skorKomponen2[$ind];
            }
        }
    }

    // public function actionDataKategori3($lppid)
    protected function dataKategori3($lppid, &$penyelidikan)
    {
        // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $inputs = \app\models\elnpt\simulation\RefAktivitiv2::find()->where(['kategori' => 3])->orderBy(['kategori' => SORT_ASC, 'kategori' => SORT_ASC, 'order_no' => SORT_ASC, 'isHakiki' => SORT_ASC])->indexBy('id')->asArray()->all();

        $lpp = $this->findLpp($lppid);
        $penyelidikan1 = TblPenyelidikan2::find()
            ->select(new Expression('ID, ProjectID, Title, MIN(Membership) as Peranan, AgencyName, GrantLevelID as Tahap_geran, Amount, StartDate, EndDate, ResearchStatus as Status_geran, ExtensionNo as ExtraDuration, \'0\' as Display, \'\' as file_hash, \'SMP UMS\' as ver_by, \'SMP UMS\' as ver_dt'))
            ->where(['IC' => $lpp->PYD])
            ->andWhere(['AND', ['AND', ['<=', 'StartYear', $lpp->tahun], ['>=', 'EndYear', $lpp->tahun]], ['ResearchStatus' => ['Sedang Berjalan', 'Selesai']]])
            ->groupBy('ID, ProjectID, Title, AgencyName, GrantLevelID, Amount, StartDate, EndDate, ResearchStatus, ExtensionNo')
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
        $penyelidikan = $penyelidikan1 + $penyelidikan2;

        $grant = TblGrantApplication::find()
            ->where(['UserIC' => $lpp->PYD, 'tahun' => $lpp->tahun])
            ->count();

        $conf = TblConference::find()
            ->select(['TajukPersidangan', 'Peranan', 'Peringkat', 'StatusConference'])
            ->where(['=', 'IC', $lpp->PYD])
            // ->andWhere(['StatusConference' => 'Verified'])
            // ->andWhere(['StartYear' => $lpp->tahun])
            ->andWhere(['or', ['StartYear' => $lpp->tahun], ['SUBSTRING(Tamat, 7, 4)' => $lpp->tahun]])
            ->asArray()
            ->all();

        $amountOver1m = 0;

        $inputs['42']['auto'] = 1;
        $inputs['42']['input'] = 0;
        $inputs['43']['auto'] = 1;
        $inputs['43']['input'] = 0;

        $inputs['45']['auto'] = 1;
        $inputs['45']['input'] = 0;
        $inputs['46']['auto'] = 1;
        $inputs['46']['input'] = 0;
        $inputs['47']['auto'] = 1;
        $inputs['47']['input'] = 0;
        $inputs['48']['auto'] = 1;
        $inputs['48']['input'] = 0;
        $inputs['49']['auto'] = 1;
        $inputs['49']['input'] = 0;
        $inputs['50']['auto'] = 1;
        $inputs['50']['input'] = 0;
        $inputs['51']['auto'] = 1;
        $inputs['51']['input'] = 0;
        $inputs['52']['auto'] = 1;
        $inputs['52']['input'] = 0;
        $inputs['53']['auto'] = 1;
        $inputs['53']['input'] = 0;

        $inputs['60']['input'] = 0;
        $inputs['60']['auto'] = 1;
        $inputs['61']['input'] = 0;
        $inputs['61']['auto'] = 1;
        $inputs['62']['input'] = 0;
        $inputs['62']['auto'] = 1;

        $inputs['54']['auto'] = 1;
        $inputs['54']['input'] = 0;
        $inputs['55']['auto'] = 1;
        $inputs['55']['input'] = 0;
        $inputs['57']['auto'] = 1;
        $inputs['57']['input'] = 0;
        $inputs['58']['auto'] = 1;
        $inputs['58']['input'] = 0;
        $inputs['63']['auto'] = 1;
        $inputs['63']['input'] = 0;
        $inputs['64']['auto'] = 1;
        $inputs['64']['input'] = 0;
        $inputs['185']['auto'] = 1;
        $inputs['185']['input'] = 0;

        $inputs['179']['lain'] = 1;
        $inputs['179']['input'] = 0;
        $inputs['180']['lain'] = 1;
        $inputs['180']['input'] = 0;
        $inputs['181']['lain'] = 1;
        $inputs['181']['input'] = 0;
        $inputs['182']['lain'] = 1;
        $inputs['182']['input'] = 0;
        $inputs['183']['lain'] = 1;
        $inputs['183']['input'] = 0;
        $inputs['184']['lain'] = 1;
        $inputs['184']['input'] = 0;

        foreach ($penyelidikan as $p) {
            //penyelidikan-42
            if (($p['Peranan'] == 'Leader') && ($p['Tahap_geran'] == 1)) {
                $inputs['42']['input']++;
            }
            //penyelidikan-43
            if (($p['Peranan'] == 'Member') && ($p['Tahap_geran'] == 1)) {
                $inputs['43']['input']++;
            }
            //penyelidikan-44
            $inputs['44']['auto'] = 1;
            $inputs['44']['input'] = $inputs['42']['input'] + $inputs['43']['input'];

            // //penyelidikan-45
            // if (($p['Peranan'] == 'Leader') && ($p['Tahap_geran'] == 2)) {
            //     $inputs['45']['input']++;
            // }
            // //penyelidikan-46
            // if (($p['Peranan'] == 'Member') && ($p['Tahap_geran'] == 2)) {
            //     $inputs['46']['input']++;
            // }
            //penyelidikan-47
            // $inputs['47']['input'] = null;

            // //penyelidikan-48
            // if (($p['Peranan'] == 'Leader') && ($p['Tahap_geran'] == 2)) {
            //     $inputs['48']['input']++;
            // }
            // //penyelidikan-49
            // if (($p['Peranan'] == 'Member') && ($p['Tahap_geran'] == 2)) {
            //     $inputs['49']['input']++;
            // }
            //penyelidikan-50
            // $inputs['50']['input'] = null;

            // //penyelidikan-51
            // if (($p['Peranan'] == 'Leader') && ($p['Tahap_geran'] == 2)) {
            //     $inputs['51']['input']++;
            // }
            // //penyelidikan-52
            // if (($p['Peranan'] == 'Member') && ($p['Tahap_geran'] == 2)) {
            //     $inputs['52']['input']++;
            // }
            //penyelidikan-53
            // $inputs['53']['input'] = null;

            //penyelidikan-54
            if (($p['Peranan'] == 'Leader') && ($p['Tahap_geran'] == 3)) {
                $inputs['54']['input']++;
            }
            //penyelidikan-55
            if (($p['Peranan'] == 'Member') && ($p['Tahap_geran'] == 3)) {
                $inputs['55']['input']++;
            }
            //penyelidikan-56
            $inputs['56']['auto'] = 1;
            $inputs['56']['input'] =  $inputs['54']['input'] + $inputs['55']['input'];

            //penyelidikan-57
            if (($p['Peranan'] == 'Leader') && ($p['Tahap_geran'] == 1)) {
                $inputs['57']['input'] = $inputs['57']['input'] + $this->amountResearch($p['Amount'], $lpp);
            }
            //penyelidikan-58
            if (($p['Peranan'] == 'Member') && ($p['Tahap_geran'] == 1)) {
                $inputs['58']['input'] = $inputs['58']['input'] + $this->amountResearch($p['Amount'], $lpp);
            }
            //penyelidikan-59
            $inputs['59']['auto'] = 1;
            $inputs['59']['input'] = $inputs['57']['input'] + $inputs['58']['input'];

            //penyelidikan-63
            if (($p['Peranan'] == 'Leader') && ($p['Tahap_geran'] == 3)) {
                $inputs['63']['input'] = $inputs['63']['input'] + $this->amountResearch($p['Amount'], $lpp);
            }
            //penyelidikan-64
            if (($p['Peranan'] == 'Member') && ($p['Tahap_geran'] == 3)) {
                $inputs['64']['input'] = $inputs['64']['input'] + $this->amountResearch($p['Amount'], $lpp);
            }
            //penyelidikan-65
            $inputs['65']['auto'] = 1;
            $inputs['65']['input'] = $inputs['63']['input'] + $inputs['64']['input'];

            //penyelidikan-185
            if (($p['Amount'] > 1000000)) {
                $inputs['185']['input']++;
            }
        }

        $inputs['66']['auto'] = 1;
        $inputs['66']['input'] = 0;
        $inputs['67']['auto'] = 1;
        $inputs['67']['input'] = 0;
        $inputs['68']['auto'] = 1;
        $inputs['68']['input'] = 0;
        $inputs['69']['auto'] = 1;
        $inputs['69']['input'] = 0;

        $inputs['70']['auto'] = 1;
        $inputs['70']['input'] = 0;
        $inputs['71']['auto'] = 1;
        $inputs['71']['input'] = 0;
        foreach ($conf as $cn) {
            //penyelidikan-70
            if (($cn['Peringkat'] == 'Kebangsaan') && ($cn['Peranan'] == 'Pembentang') && ($cn['StatusConference'] == 'Verified')) {
                $inputs['70']['input']++;
            }

            //penyelidikan-71
            if (($cn['Peringkat'] == 'Antarabangsa') && ($cn['Peranan'] == 'Pembentang') && ($cn['StatusConference'] == 'Verified')) {
                $inputs['71']['input']++;
            }
        }

        $inputs['227']['modal'] = 1;
        $inputs['227']['lain'] = 1;
        $inputs['227']['input'] = 0;

        $this->calcKategori3($inputs);

        return $inputs;
    }

    protected function amountResearch($amount, $lpp)
    {
        if ($lpp->deptGuru->cluster) {
            if ($amount >= 5000) {
                return $amount;
            }
        } else {
            if ($amount >= 20000) {
                return $amount;
            }
        }

        return 0;
    }

    protected function calcKategori3(&$inputsKategori3)
    {
        foreach ($inputsKategori3 as $ind => $ik1) {
            if ($ik1['kategori'] == 3) {
                ArrayHelper::setValue($inputKomponen1, ($ind), ['skor' => $ik1['input'], 'nilai_mata' => $ik1['nilai_mata_id'], 'order_no' => $ik1['order_no'], 'kategori' => $ik1['kategori']]);
            }
        }

        $mataKomponen1 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 3, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();
        $mataKomponen2 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 3, 'nilai_mata_id' => 2])->indexBy(['aktiviti_id'])->asArray()->all();

        $base = 10000;

        foreach ($inputKomponen1 as $ind => $ik) {
            if (($ik['order_no'] == 6) || ($ik['order_no'] == 7) || ($ik['order_no'] == 8)) {
                ArrayHelper::setValue($skorKomponen2, $ind, $ik['nilai_mata'] ? (($ik['nilai_mata'] == 1) ? (($mataKomponen1[$ik['order_no']]['nilai_mata'] * ($ik['skor'] / $base))) : (($mataKomponen2[$ik['order_no']]['nilai_mata'] * ($ik['skor'] / $base)))) : ((($mataKomponen2[$ik['order_no']]['nilai_mata'] / 2) * ($ik['skor'] / $base))));
                continue;
            }

            ArrayHelper::setValue($skorKomponen2, $ind, $ik['nilai_mata'] ? (($ik['nilai_mata'] == 1) ? (($mataKomponen1[$ik['order_no']]['nilai_mata'] * $ik['skor'])) : (($mataKomponen2[$ik['order_no']]['nilai_mata'] * $ik['skor']))) : ((($mataKomponen2[$ik['order_no']]['nilai_mata'] / 2) * $ik['skor'])));
        }

        foreach ($inputsKategori3 as $ind => $sett) {
            if ($sett['kategori'] == 3) {
                $inputsKategori3[$ind]['mata'] = $skorKomponen2[$ind];
            }
        }
    }

    // public function actionDataKategori4($lppid)
    protected function dataKategori4($lppid, &$publication)
    {
        // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $inputs = \app\models\elnpt\simulation\RefAktivitiv2::find()->where(['kategori' => 4])->orderBy(['kategori' => SORT_ASC, 'kategori' => SORT_ASC, 'order_no' => SORT_ASC, 'isHakiki' => SORT_ASC])->indexBy('id')->asArray()->all();

        $contId = 203;
        $contBil = 19;
        $contOrder = 30;
        $tmp = [];

        $lpp = $this->findLpp($lppid);
        $except = TblException::find()->select('tahun')->where(['lpp_id' => $lppid])->asArray()->all();
        $publication = TblLnptPublicationV3::find()
            ->select(new Expression('PubID, Keterangan_PublicationTypeID as Bilangan_penerbitan, Title, PublicationYear, PublicationMonth, SubmissionYear, KeteranganBI_WriterStatus as Status_penulis, IndexingDesc as Status_indeks, Keterangan_PublicationStatus as Status_penerbitan, FullAuthorName, SubCategory'))
            ->from('SMP_PPI.dbo.vw_LNPT_PublicationV2')
            ->where(['User_Ic' => $lpp->PYD])
            ->andWhere(['or', ['PublicationYear' => (empty($except) ? $lpp->tahun : ArrayHelper::getColumn($except, 'tahun', $keepKeys = true))], ['SubmissionYear' => (empty($except) ? $lpp->tahun : ArrayHelper::getColumn($except, 'tahun', $keepKeys = true))], ['AcceptanceYear' => (empty($except) ? $lpp->tahun : ArrayHelper::getColumn($except, 'tahun', $keepKeys = true))]])
            ->andWhere([
                'or', ['ApproveStatus' => 'V', 'Keterangan_PublicationStatus' => 'Published'],
                ['Keterangan_PublicationStatus' => [
                    'Paper Accepted'
                    // , 'Paper Submitted'
                ]]
            ])
            ->asArray()
            ->all();

        $quartile =  $this->writerStatusQuartile($lpp->PYD);

        // return VarDumper::dump($quartile, $depth = 10, $highlight = true);

        $inputs['72']['auto'] = 1;
        $inputs['72']['input'] = 0;
        $inputs['73']['auto'] = 1;
        $inputs['73']['input'] = 0;

        $inputs['74']['auto'] = 1;
        $inputs['74']['input'] = $quartile['Main Q1'] + $quartile['Corresponding Q1'];
        $inputs['75']['auto'] = 1;
        $inputs['75']['input'] = $quartile['Main Q2'] + $quartile['Corresponding Q2'];
        $inputs['76']['auto'] = 1;
        $inputs['76']['input'] = $quartile['Main Q3'] + $quartile['Corresponding Q3'];
        $inputs['77']['auto'] = 1;
        $inputs['77']['input'] = $quartile['Main Q4'] + $quartile['Corresponding Q4'];

        $inputs['78']['auto'] = 1;
        $inputs['78']['input'] = 0;
        $inputs['79']['auto'] = 1;
        $inputs['79']['input'] = 0;
        $inputs['80']['auto'] = 1;
        $inputs['80']['input'] = 0;
        $inputs['81']['auto'] = 1;
        $inputs['81']['input'] = 0;
        $inputs['82']['auto'] = 1;
        $inputs['82']['input'] = 0;
        $inputs['83']['auto'] = 1;
        $inputs['83']['input'] = 0;
        $inputs['94']['auto'] = 1;
        $inputs['94']['input'] = 0;
        $inputs['95']['auto'] = 1;
        $inputs['95']['input'] = 0;
        $inputs['96']['auto'] = 1;
        $inputs['96']['input'] = 0;
        $inputs['97']['auto'] = 1;
        $inputs['97']['input'] = 0;

        $inputs['98']['lain'] = 1;
        $inputs['98']['input'] = 0;
        $inputs['99']['lain'] = 1;
        $inputs['99']['input'] = 0;
        $inputs['100']['lain'] = 1;
        $inputs['100']['input'] = 0;

        $inputs['101']['auto'] = 1;
        $inputs['101']['input'] = 0;
        $inputs['102']['auto'] = 1;
        $inputs['102']['input'] = 0;
        $inputs['103']['auto'] = 1;
        $inputs['103']['input'] = 0;

        $inputs['104']['auto'] = 1;
        $inputs['104']['input'] = 0;
        $inputs['105']['auto'] = 1;
        $inputs['105']['input'] = 0;
        $inputs['106']['auto'] = 1;
        $inputs['106']['input'] = 0;

        $inputs['107']['auto'] = 1;
        $inputs['107']['input'] = 0;
        $inputs['108']['auto'] = 1;
        $inputs['108']['input'] = 0;
        $inputs['109']['auto'] = 1;
        $inputs['109']['input'] = 0;

        $inputs['235']['auto'] = 1;
        $inputs['235']['input'] = $quartile['Collaborating Q1'];
        $inputs['236']['auto'] = 1;
        $inputs['236']['input'] = $quartile['Collaborating Q2'];
        $inputs['237']['auto'] = 1;
        $inputs['237']['input'] = $quartile['Collaborating Q3'];
        $inputs['238']['auto'] = 1;
        $inputs['238']['input'] = $quartile['Collaborating Q4'];

        //penyeliaan-202
        $inputs['202']['modal'] = 1;
        $inputs['202']['lain'] = 1;
        $inputs['202']['input'] = 0;

        foreach ($publication as $ind => $p) {

            if (($p['Bilangan_penerbitan'] == 'Scientific Book') && ($p['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)') && (($p['Status_penulis'] == 'First Author') || ($p['Status_penulis'] == 'Corresponding Author'))) {
                //penyeliaan-72
                $inputs['72']['input']++;
            }
            if (($p['Bilangan_penerbitan'] == 'Scientific Book') && ($p['Status_indeks'] == 'Non-indexed') && (($p['Status_penulis'] == 'First Author') || ($p['Status_penulis'] == 'Corresponding Author'))) {
                //penyeliaan-73
                $inputs['73']['input']++;
            }

            if (($p['Bilangan_penerbitan'] == 'Article') && (($p['Status_penulis'] == 'First Author') || ($p['Status_penulis'] == 'Corresponding Author') || ($p['Status_penulis'] == 'Collaborative Author'))) {
                if ($p['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)') {
                    if ($publication[$ind]['suku'] == 1) {
                        $inputs['74']['input']++;
                    }
                    if ($publication[$ind]['suku'] == 2) {
                        $inputs['75']['input']++;
                    }
                    if ($publication[$ind]['suku'] == 3) {
                        $inputs['76']['input']++;
                    }
                    if ($publication[$ind]['suku'] == 4) {
                        $inputs['77']['input']++;
                    }
                }
            }

            if (($p['Bilangan_penerbitan'] == 'Chapter(s) in Book') && ($p['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)') && (($p['Status_penulis'] == 'First Author') || ($p['Status_penulis'] == 'Corresponding Author'))) {
                //penyeliaan-78
                $inputs['78']['input']++;
            }
            if (($p['Bilangan_penerbitan'] == 'Chapter(s) in Book') && ($p['Status_indeks'] == 'Non-indexed') && (($p['Status_penulis'] == 'First Author') || ($p['Status_penulis'] == 'Corresponding Author'))) {
                //penyeliaan-79
                $inputs['79']['input']++;
            }

            if (($p['Bilangan_penerbitan'] == 'Article') && ($p['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)') && (($p['Status_penulis'] == 'First Author') || ($p['Status_penulis'] == 'Corresponding Author'))) {
                //penyeliaan-80
                $inputs['80']['input']++;
            }
            if (($p['Bilangan_penerbitan'] == 'Article') && ($p['Status_indeks'] == 'Indexing (Mycite)') && (($p['Status_penulis'] == 'First Author') || ($p['Status_penulis'] == 'Corresponding Author'))) {
                //penyeliaan-81
                $inputs['81']['input']++;
            }

            if ((($p['Bilangan_penerbitan'] == 'Proceeding: Abstract') || ($p['Bilangan_penerbitan'] == 'Proceeding: Full Paper')) && ($p['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)') && ($p['Status_penulis'] == 'First Author')) {
                //penyeliaan-81
                $inputs['82']['input']++;
            }

            if (!in_array($p['Bilangan_penerbitan'], ['Scientific Book', 'Chapter(s) in Book', 'Article']) && (($p['Status_penulis'] == 'First Author') || ($p['Status_penulis'] == 'Corresponding Author'))) {
                //penyeliaan-83
                $inputs['83']['input']++;
            }

            if (($p['Bilangan_penerbitan'] == 'Policy Paper')) {
                //penyeliaan-95
                $inputs['95']['input']++;
            }

            // if (($p['Subcategory'] == 'Kreatif')) {
            //     //penyeliaan-95
            //     $inputs['96']['input']++;
            // }

            if (($p['Bilangan_penerbitan'] == 'Article') && ($p['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)') && ($p['Status_penulis'] == 'Ketua Editor')) {
                //penyeliaan-102
                $inputs['101']['input']++;
            }
            if (($p['Bilangan_penerbitan'] == 'Article') && ($p['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)') && ($p['Status_penulis'] == 'Editor')) {
                //penyeliaan-102
                $inputs['102']['input']++;
            }
            if (($p['Bilangan_penerbitan'] == 'Article') && ($p['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)') && ($p['Status_penulis'] == 'Pewasit')) {
                //penyeliaan-102
                $inputs['103']['input']++;
            }

            if (($p['Bilangan_penerbitan'] == 'Article') && ($p['Status_indeks'] == 'Non-indexed') && ($p['Status_penulis'] == 'Ketua Editor')) {
                //penyeliaan-108
                $inputs['107']['input']++;
            }
            if (($p['Bilangan_penerbitan'] == 'Article') && ($p['Status_indeks'] == 'Non-indexed') && ($p['Status_penulis'] == 'Editor')) {
                //penyeliaan-108
                $inputs['108']['input']++;
            }
            if (($p['Bilangan_penerbitan'] == 'Article') && ($p['Status_indeks'] == 'Non-indexed') && ($p['Status_penulis'] == 'Pewasit')) {
                //penyeliaan-108
                $inputs['109']['input']++;
            }

            $publication[$ind]['bil_penulis'] = $this->bilPenulis($p['PubID']);

            // if ($p['Status_penulis'] == 'Collaborative Author') {
            //     array_push($tmp, [
            //         'id' => $contId,
            //         'bil' => $contBil,
            //         'title' => null,
            //         'kategori' => 4,
            //         'order_no' => $contOrder,
            //         'aktiviti' => $p['Title'],
            //         'Status_indeks' => $p['Status_indeks'],
            //         'nilai_mata_id' => null,
            //         'isHakiki' => 0,
            //         'unit' => null,
            //         'jenis' => $this->pubType($p['Bilangan_penerbitan'], $p['Status_indeks']),
            //         'input' => $this->bilPenulis($p['PubID']),
            //     ]);
            //     $contId++;
            //     $contBil++;
            //     $contOrder++;
            // }
        }

        // $inputs = array_merge(array_slice($inputs, 0, 29), $tmp);
        $inputs = array_slice($inputs, 0, 33);
        $inputs = ArrayHelper::index($inputs, 'id');

        $this->calcKategori4($inputs, $lpp->deptGuru->cluster);

        return $inputs;
    }

    protected function writerStatusQuartile($icno)
    {
        // if (($model = TblWriterStatusbyQuartile::find()->where(['ic_no' => $icno])->one()) !== null) {
        //     return $model;
        // }
        // throw new UserException('The requested data does not exist.');

        $connection = Yii::$app->db12;
        $command = $connection->createCommand(new Expression("
        with 

        /****** Tahun Berhenti staf yang tidak aktif  ******/
        academicStaffs as (
            select ic_no, staff_name
            from StaffDW.D2_Staff_Warehouse d2
                left join StaffDW.D8_Job_title_Warehouse d8 on d8.job_title_code = d2.current_job_title_code
            where staff_status_id IN (1,2,3,4,5,7,9,15,17,18) and job_category=1
        )

        , BERHENTI_ALL AS (SELECT [ICNO]
            ,[ServStatusStDt]
            ,ROW_NUMBER() OVER(PARTITION BY [ICNO]
            ORDER BY ServStatusStDt DESC) AS Row
        FROM [staging_area].[StaffDW].[D2_Staff_Warehouse] a
            left join [StaffDW].[D8_Job_title_Warehouse] c on a.job_title_code=c.job_title_code
            left join [staging_area].[Staff].[servis_status] b on a.ic_no=b.ICNO
        WHERE staff_status_id NOT IN (1,2,3,4,5,7,9,15,17,18) and job_category=1
            and b.ServStatusCd = 6)

        , BERHENTI AS (SELECT [ICNO]
            ,YEAR([ServStatusStDt]) AS 'Tahun Berhenti'
        FROM BERHENTI_ALL
        WHERE [Row]=1)
        
        /** Quartile thingy **/
        , QUARTILE AS (
            SELECT 
                (select 'Q1' )as quart
                union
                (select 'Q2' as quart)
                union
                (select 'Q3' as quart)
                union
                (select 'Q4' as quart)
                union
                (select '-' as quart)
            ) 

        /****** Main Author Scopus ******/
        , mainA as (
            select distinct A.EID ,F.Title
                ,case when main_author = 1 then 'Main Author' end as 'writer status'
                ,c.ic_no
                ,c.staff_name
                ,H.SJR_Best_Quartile
            FROM [staging_area].Scopus.Author_Article A
                LEFT JOIN staging_area.Scopus.Author_Detail B ON B.author_id = A.author_id
                LEFT JOIN [staging_area].[StaffDW].[D2_Staff_Warehouse] C ON C.ic_no=B.ic_no
        --		LEFT JOIN [staging_area].[StaffDW].[D7_Department_Warehouse] D ON D.dept_code= C.dept_code
                LEFT JOIN [staging_area].[StaffDW].[D8_Job_title_Warehouse] E ON E.job_title_code=C.job_title_code
                LEFT JOIN staging_area.Scopus.Articles F ON F.EID = A.EID
                LEFT JOIN BERHENTI G ON C.ic_no=G.ICNO
                JOIN Scopus.Journal_List H on H.Sourceid = F.source_id and H.Article_year = F.Year
            WHERE A.[is_exist]=1 AND F.is_exist = 1
                AND ((C.[staff_name] IS NOT NULL AND E.[job_category]=1
                and E.job_title_long not in ('Pensyarah Pelawat')
                and E.job_title_long not like '%adjung%')
                and E.job_title_long not in ('Postdoktoral'))
                and F.ums_affiliation = 1
                and A.EID not in (SELECT Excluded_Article.EID FROM Scopus.Excluded_Article)
                AND ([Tahun Berhenti] IS NULL OR CAST([Tahun Berhenti] AS INT)>=CAST(F.Year AS INT)) --compare tahun penerbitan dan tahun tamat perkhidmatan
                and A.main_author = 1 )

        , num_mainA as (
            Select ic_no, staff_name
                ,COUNT(EID) AS 'Total Main'
                ,COUNT(DISTINCT CASE WHEN SJR_Best_Quartile = 'Q1' THEN EID END) AS 'Main Q1'
                ,COUNT(DISTINCT CASE WHEN SJR_Best_Quartile = 'Q2' THEN EID END) AS 'Main Q2'
                ,COUNT(DISTINCT CASE WHEN SJR_Best_Quartile = 'Q3' THEN EID END) AS 'Main Q3'
                ,COUNT(DISTINCT CASE WHEN SJR_Best_Quartile = 'Q4' THEN EID END) AS 'Main Q4'
                ,COUNT(DISTINCT CASE WHEN SJR_Best_Quartile = '-' THEN EID END) AS 'Main -'
            from mainA
                join QUARTILE on QUARTILE.quart = mainA.SJR_Best_Quartile
            GROUP BY ic_no, staff_name )

        /****** Corresponding Author Scopus ******/
        , correspondingA as (
            select distinct A.EID ,F.Title
                ,case when corresponding_author = 1 then 'Corresponding Author' end as 'writer status'
                ,c.ic_no
                ,c.staff_name
                ,H.SJR_Best_Quartile
            FROM [staging_area].Scopus.Author_Article A
                LEFT JOIN staging_area.Scopus.Author_Detail B ON B.author_id = A.author_id
                LEFT JOIN [staging_area].[StaffDW].[D2_Staff_Warehouse] C ON C.ic_no=B.ic_no
        --		LEFT JOIN [staging_area].[StaffDW].[D7_Department_Warehouse] D ON D.dept_code= C.dept_code
                LEFT JOIN [staging_area].[StaffDW].[D8_Job_title_Warehouse] E ON E.job_title_code=C.job_title_code
                LEFT JOIN staging_area.Scopus.Articles F ON F.EID = A.EID
                LEFT JOIN BERHENTI G ON C.ic_no=G.ICNO
                JOIN Scopus.Journal_List H on H.Sourceid = F.source_id and H.Article_year = F.Year
            WHERE A.[is_exist]=1 AND F.is_exist = 1
                AND ((C.[staff_name] IS NOT NULL AND E.[job_category]=1
                and E.job_title_long not in ('Pensyarah Pelawat')
                and E.job_title_long not like '%adjung%')
                and E.job_title_long not in ('Postdoktoral'))
                and F.ums_affiliation = 1
                and A.EID not in (SELECT Excluded_Article.EID FROM Scopus.Excluded_Article)
                AND ([Tahun Berhenti] IS NULL OR CAST([Tahun Berhenti] AS INT)>=CAST(F.Year AS INT)) --compare tahun penerbitan dan tahun tamat perkhidmatan
                and A.corresponding_author = 1 )

        , num_correspondingA as (
            Select ic_no, staff_name
                ,COUNT(EID) AS 'Total Corresponding'
                ,COUNT(DISTINCT CASE WHEN SJR_Best_Quartile = 'Q1' THEN EID END) AS 'Corresponding Q1'
                ,COUNT(DISTINCT CASE WHEN SJR_Best_Quartile = 'Q2' THEN EID END) AS 'Corresponding Q2'
                ,COUNT(DISTINCT CASE WHEN SJR_Best_Quartile = 'Q3' THEN EID END) AS 'Corresponding Q3'
                ,COUNT(DISTINCT CASE WHEN SJR_Best_Quartile = 'Q4' THEN EID END) AS 'Corresponding Q4'
                ,COUNT(DISTINCT CASE WHEN SJR_Best_Quartile = '-' THEN EID END) AS 'Corresponding -'
            from correspondingA
                join QUARTILE on QUARTILE.quart = correspondingA.SJR_Best_Quartile
            GROUP BY ic_no, staff_name )

        /****** Single Collaborating Author Scopus (Q1, Q2 only) ******/
        , singlecollaboratingAQ1Q2 as (
            select distinct A.EID, F.title, SJR_Best_Quartile
                , count(A.EID) as 'Count'
            FROM [staging_area].Scopus.Author_Article A
                LEFT JOIN staging_area.Scopus.Author_Detail B ON B.author_id = A.author_id
                LEFT JOIN [staging_area].[StaffDW].[D2_Staff_Warehouse] C ON C.ic_no=B.ic_no
        --		LEFT JOIN [staging_area].[StaffDW].[D7_Department_Warehouse] D ON D.dept_code= C.dept_code
                LEFT JOIN [staging_area].[StaffDW].[D8_Job_title_Warehouse] E ON E.job_title_code=C.job_title_code
                LEFT JOIN staging_area.Scopus.Articles F ON F.EID = A.EID
                LEFT JOIN BERHENTI G ON C.ic_no=G.ICNO
                JOIN Scopus.Journal_List H on H.Sourceid = F.source_id and H.Article_year = F.Year
            WHERE A.[is_exist]=1 AND F.is_exist = 1
                AND ((C.[staff_name] IS NOT NULL AND E.[job_category]=1
                and E.job_title_long not in ('Pensyarah Pelawat')
                and E.job_title_long not like '%adjung%')
                and E.job_title_long not in ('Postdoktoral'))
                and F.ums_affiliation = 1
                and A.EID not in (SELECT Excluded_Article.EID FROM Scopus.Excluded_Article)
                and A.EID not in (select EID from mainA)
                and A.EID not in (select EID from correspondingA)
                AND ([Tahun Berhenti] IS NULL OR CAST([Tahun Berhenti] AS INT)>=CAST(F.Year AS INT)) --compare tahun penerbitan dan tahun tamat perkhidmatan
                and A.main_author = 0 and A.corresponding_author = 0
                and H.SJR_Best_Quartile in ('Q1', 'Q2')
                group by A.EID, F.Title, SJR_Best_Quartile
                    having count(A.EID) = 1 )

        /** used to check the details of single collaborating author in Q1, Q2 **/
        , detail_singleCollaboraringAQ1Q2 as (
            select singlecollaboratingAQ1Q2.EID, singlecollaboratingAQ1Q2.Title, d2.ic_no, d2.staff_name, SJR_Best_Quartile
            from singlecollaboratingAQ1Q2
                join Scopus.Author_Article autArt on autArt.EID = singlecollaboratingAQ1Q2.EID
                join Scopus.Author_Detail autDet on autDet.author_id = autArt.author_id
                join StaffDW.D2_Staff_Warehouse d2 on d2.ic_no = autDet.ic_no )

        , num_singlecollaboratingAQ1Q2 as (
            Select ic_no, staff_name
                ,COUNT(EID) AS 'Total Collaborating'
                ,COUNT(DISTINCT CASE WHEN SJR_Best_Quartile = 'Q1' THEN EID END) AS 'Collaborating Q1'
                ,COUNT(DISTINCT CASE WHEN SJR_Best_Quartile = 'Q2' THEN EID END) AS 'Collaborating Q2'
                ,COUNT(DISTINCT CASE WHEN SJR_Best_Quartile = 'Q3' THEN EID END) AS 'Collaborating Q3'
                ,COUNT(DISTINCT CASE WHEN SJR_Best_Quartile = 'Q4' THEN EID END) AS 'Collaborating Q4'
                ,COUNT(DISTINCT CASE WHEN SJR_Best_Quartile = '-' THEN EID END) AS 'Collaborating -'
            from detail_singleCollaboraringAQ1Q2
                join QUARTILE on QUARTILE.quart = detail_singleCollaboraringAQ1Q2.SJR_Best_Quartile
            GROUP BY ic_no, staff_name )

        , compiled as (
            select academicStaffs.ic_no, academicStaffs.staff_name 
                ,case when num_mainA.[Total Main] is null then '0' else num_mainA.[Total Main] end as 'Total Main'
                ,case when num_mainA.[Main Q1] is null then '0' else num_mainA.[Main Q1] end as 'Main Q1'
                ,case when num_mainA.[Main Q2] is null then '0' else num_mainA.[Main Q2] end as 'Main Q2'
                ,case when num_mainA.[Main Q3] is null then '0' else num_mainA.[Main Q3] end as 'Main Q3'
                ,case when num_mainA.[Main Q4] is null then '0' else num_mainA.[Main Q4] end as 'Main Q4'
                ,case when num_mainA.[Main -] is null then '0' else num_mainA.[Main -] end as 'Main -'

                ,case when num_correspondingA.[Total Corresponding] is null then '0' else num_correspondingA.[Total Corresponding] end as 'Total Corresponding'
                ,case when num_correspondingA.[Corresponding Q1] is null then '0' else num_correspondingA.[Corresponding Q1] end as 'Corresponding Q1'
                ,case when num_correspondingA.[Corresponding Q2] is null then '0' else num_correspondingA.[Corresponding Q2] end as 'Corresponding Q2'
                ,case when num_correspondingA.[Corresponding Q3] is null then '0' else num_correspondingA.[Corresponding Q3] end as 'Corresponding Q3'
                ,case when num_correspondingA.[Corresponding Q4] is null then '0' else num_correspondingA.[Corresponding Q4] end as 'Corresponding Q4'
                ,case when num_correspondingA.[Corresponding -] is null then '0' else num_correspondingA.[Corresponding -] end as 'Corresponding -'

                ,case when num_singlecollaboratingAQ1Q2.[Total Collaborating] is null then '0' else num_singlecollaboratingAQ1Q2.[Total Collaborating] end as 'Total Collaborating'
                ,case when num_singlecollaboratingAQ1Q2.[Collaborating Q1] is null then '0' else num_singlecollaboratingAQ1Q2.[Collaborating Q1] end as 'Collaborating Q1'
                ,case when num_singlecollaboratingAQ1Q2.[Collaborating Q2] is null then '0' else num_singlecollaboratingAQ1Q2.[Collaborating Q2] end as 'Collaborating Q2'
                ,case when num_singlecollaboratingAQ1Q2.[Collaborating Q3] is null then '0' else num_singlecollaboratingAQ1Q2.[Collaborating Q3] end as 'Collaborating Q3'
                ,case when num_singlecollaboratingAQ1Q2.[Collaborating Q4] is null then '0' else num_singlecollaboratingAQ1Q2.[Collaborating Q4] end as 'Collaborating Q4'
                ,case when num_singlecollaboratingAQ1Q2.[Collaborating -] is null then '0' else num_singlecollaboratingAQ1Q2.[Collaborating -] end as 'Collaborating -'
            from academicStaffs
                left join num_mainA on num_mainA.ic_no = academicStaffs.ic_no
                left join num_correspondingA on num_correspondingA.ic_no = academicStaffs.ic_no
                left join num_singlecollaboratingAQ1Q2 on num_singlecollaboratingAQ1Q2.ic_no = academicStaffs.ic_no )

        select *
            , [Main Q1] + [Corresponding Q1] + [Collaborating Q1] as 'Total Q1'
            , [Main Q2] + [Corresponding Q2] + [Collaborating Q2] as 'Total Q2'
            , [Main Q3] + [Corresponding Q3] + [Collaborating Q3] as 'Total Q3'
            , [Main Q4] + [Corresponding Q4] + [Collaborating Q4] as 'Total Q4'
            , [Main -] + [Corresponding -] + [Collaborating -] as 'Total -'
            , [Total Main] + [Total Corresponding] + [Total Collaborating] as 'Grand Total'
        from compiled
        where ic_no = '" . $icno . "'
        order by staff_name 
        "));
        $result = $command->queryAll();

        return empty($result) ? [] :  $result[0];
    }

    protected function calcKategori4(&$inputsKategori4, $gugusann)
    {
        foreach ($inputsKategori4 as $ind => $ik1) {
            if ($ik1['kategori'] == 4) {
                ArrayHelper::setValue($inputKomponen1, ($ind), ['skor' => $ik1['input'], 'nilai_mata' => $gugusann, 'order_no' => $ik1['order_no'], 'kategori' => $ik1['kategori'],  'jenis' => $ik1['jenis']]);
            }
        }

        $mataKomponen1 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 4, 'nilai_mata_id' => $gugusann])->indexBy(['aktiviti_id'])->asArray()->all();

        foreach ($inputKomponen1 as $ind => $ik) {
            if (!empty($ik['jenis']) || !is_null($ik['jenis'])) {
                $abc = $this->skorArtikel($ik['jenis'], $gugusann) / $ik['skor'];
                ArrayHelper::setValue($skorKomponen2, $ind, is_nan($abc) ? 0 : $abc);
                continue;
            }

            ArrayHelper::setValue($skorKomponen2, $ind, (($mataKomponen1[$ik['order_no']]['nilai_mata'] * $ik['skor'])));
        }

        foreach ($inputsKategori4 as $ind => $sett) {
            if ($sett['kategori'] == 4) {
                $inputsKategori4[$ind]['mata'] = is_finite($skorKomponen2[$ind]) ?  $skorKomponen2[$ind] : 0;
            }
        }
    }

    // public function actionDataKategori5($lppid)
    protected function dataKategori5($lppid, &$list)
    {
        // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $inputs = \app\models\elnpt\simulation\RefAktivitiv2::find()->where(['kategori' => 5])->orderBy(['kategori' => SORT_ASC, 'kategori' => SORT_ASC, 'order_no' => SORT_ASC, 'isHakiki' => SORT_ASC])->indexBy('id')->asArray()->all();

        $lpp = $this->findLpp($lppid);

        $lain2 = true;

        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);
        $tamat_dt = '2022/12/31';
        $urus_tadbir = TblPengurusanPentadbiran::find()
            ->select(new Expression('a.id, kategori as Bilangan_jawatankuasa, nama_jawatan, peranan as Peranan_jawatankuasa, isElaun AS berelaun, tahap_lantikan as Tahap_jawatankuasa, b.filehash as file_hash, b.verified_by as ver_by, b.verified_dt as ver_dt'))
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
                    `b`.`position_name` as name,
          `a`.`description`   AS `nama_jawatan`,
          `b`.`position_name` AS `Peranan_jawatankuasa`,
          'Ya' AS `berelaun`,
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
        ((`a`.`ICNO` = '" . $lpp->PYD . "') AND (`a`.`paymentStatus`=1)
        and (`a`.`flag` <> 3)
        ) AND ((TIMESTAMPDIFF(MONTH, `a`.`start_date`, '" . $tamat_dt . "') > 6) AND (YEAR(`a`.`end_date`) >= '" . $lpp->tahun . "')) ORDER BY end_date DESC LIMIT 1");
        $result = $command->queryAll();

        $list = array_merge($urus_tadbir, $result);

        $inputs['110']['auto'] = 1;
        $inputs['110']['input'] = 0;
        $inputs['111']['auto'] = 1;
        $inputs['111']['input'] = 0;
        $inputs['112']['auto'] = 1;
        $inputs['112']['input'] = 0;
        $inputs['113']['auto'] = 1;
        $inputs['113']['input'] = 0;
        $inputs['114']['auto'] = 1;
        $inputs['114']['input'] = 0;

        $inputs['115']['auto'] = 1;
        $inputs['115']['input'] = 0;
        $inputs['116']['auto'] = 1;
        $inputs['116']['input'] = 0;
        $inputs['117']['auto'] = 1;
        $inputs['117']['input'] = 0;

        $inputs['118']['lain'] = 1;
        $inputs['118']['input'] = 0;
        $inputs['119']['lain'] = 1;
        $inputs['119']['input'] = 0;
        $inputs['120']['lain'] = 1;
        $inputs['120']['input'] = 0;
        $inputs['121']['lain'] = 1;
        $inputs['121']['input'] = 0;
        $inputs['122']['lain'] = 1;
        $inputs['122']['input'] = 0;
        $inputs['123']['lain'] = 1;
        $inputs['123']['input'] = 0;
        $inputs['124']['lain'] = 1;
        $inputs['124']['input'] = 0;
        $inputs['125']['lain'] = 1;
        $inputs['125']['input'] = 0;
        $inputs['126']['lain'] = 1;
        $inputs['126']['input'] = 0;
        $inputs['127']['lain'] = 1;
        $inputs['127']['input'] = 0;
        $inputs['128']['lain'] = 1;
        $inputs['128']['input'] = 0;
        $inputs['129']['lain'] = 1;
        $inputs['129']['input'] = 0;
        $inputs['130']['lain'] = 1;
        $inputs['130']['input'] = 0;
        $inputs['131']['lain'] = 1;
        $inputs['131']['input'] = 0;
        $inputs['132']['lain'] = 1;
        $inputs['132']['input'] = 0;
        $inputs['133']['lain'] = 1;
        $inputs['133']['input'] = 0;
        $inputs['134']['lain'] = 1;
        $inputs['134']['input'] = 0;
        $inputs['135']['lain'] = 1;
        $inputs['135']['input'] = 0;
        $inputs['136']['lain'] = 1;
        $inputs['136']['input'] = 0;
        $inputs['137']['lain'] = 1;
        $inputs['137']['input'] = 0;
        $inputs['138']['lain'] = 1;
        $inputs['138']['input'] = 0;
        $inputs['139']['lain'] = 1;
        $inputs['139']['input'] = 0;
        $inputs['140']['lain'] = 1;
        $inputs['140']['input'] = 0;
        $inputs['141']['lain'] = 1;
        $inputs['141']['input'] = 0;
        $inputs['142']['lain'] = 1;
        $inputs['142']['input'] = 0;
        $inputs['143']['lain'] = 1;
        $inputs['143']['input'] = 0;
        $inputs['144']['lain'] = 1;
        $inputs['144']['input'] = 0;
        $inputs['145']['lain'] = 1;
        $inputs['145']['input'] = 0;
        $inputs['146']['lain'] = 1;
        $inputs['146']['input'] = 0;
        $inputs['147']['lain'] = 1;
        $inputs['147']['input'] = 0;
        $inputs['148']['lain'] = 1;
        $inputs['148']['input'] = 0;
        $inputs['149']['lain'] = 1;
        $inputs['149']['input'] = 0;

        $inputs['150']['lain'] = 1;
        $inputs['150']['input'] = 0;
        $inputs['151']['lain'] = 1;
        $inputs['151']['input'] = 0;
        $inputs['152']['lain'] = 1;
        $inputs['152']['input'] = 0;
        $inputs['153']['lain'] = 1;
        $inputs['153']['input'] = 0;
        $inputs['154']['lain'] = 1;
        $inputs['154']['input'] = 0;
        $inputs['155']['lain'] = 1;
        $inputs['155']['input'] = 0;
        $inputs['156']['lain'] = 1;
        $inputs['156']['input'] = 0;
        $inputs['157']['lain'] = 1;
        $inputs['157']['input'] = 0;
        $inputs['158']['lain'] = 1;
        $inputs['158']['input'] = 0;
        $inputs['159']['lain'] = 1;
        $inputs['159']['input'] = 0;

        $inputs['160']['lain'] = 1;
        $inputs['160']['input'] = 0;
        $inputs['161']['lain'] = 1;
        $inputs['161']['input'] = 0;
        $inputs['162']['lain'] = 1;
        $inputs['162']['input'] = 0;
        $inputs['163']['lain'] = 1;
        $inputs['163']['input'] = 0;
        $inputs['164']['lain'] = 1;
        $inputs['164']['input'] = 0;
        $inputs['165']['lain'] = 1;
        $inputs['165']['input'] = 0;
        $inputs['166']['lain'] = 1;
        $inputs['166']['input'] = 0;
        $inputs['167']['lain'] = 1;
        $inputs['167']['input'] = 0;
        $inputs['168']['lain'] = 1;
        $inputs['168']['input'] = 0;
        $inputs['169']['lain'] = 1;
        $inputs['169']['input'] = 0;

        $inputs['170']['lain'] = 1;
        $inputs['170']['input'] = 0;
        $inputs['171']['lain'] = 1;
        $inputs['171']['input'] = 0;
        $inputs['172']['lain'] = 1;
        $inputs['172']['input'] = 0;
        $inputs['173']['lain'] = 1;
        $inputs['173']['input'] = 0;
        $inputs['174']['lain'] = 1;
        $inputs['174']['input'] = 0;
        $inputs['175']['lain'] = 1;
        $inputs['175']['input'] = 0;
        $inputs['176']['lain'] = 1;
        $inputs['176']['input'] = 0;
        $inputs['177']['lain'] = 1;
        $inputs['177']['input'] = 0;
        $inputs['178']['lain'] = 1;
        $inputs['178']['input'] = 0;


        foreach ($list as $p) {
            if (($p['Bilangan_jawatankuasa'] == 'Pentadbiran (Lantikan NC & ke atas)') && $p['berelaun'] && (($p['Peranan_jawatankuasa'] == 'Naib Canselor'))) {
                //perkhidmatan-110
                $inputs['110']['input']++;
                $lain2 = false;
            }

            if (($p['Bilangan_jawatankuasa'] == 'Pentadbiran (Lantikan NC & ke atas)') && $p['berelaun'] && (($p['Peranan_jawatankuasa'] == 'Pengarah') || ($p['Peranan_jawatankuasa'] == 'Dekan') || ($p['Peranan_jawatankuasa'] == 'Timbalan Pengarah') || ($p['Peranan_jawatankuasa'] == 'Timbalan Dekan'))) {
                //perkhidmatan-111
                $inputs['111']['input']++;
                $lain2 = false;
            }

            if (($p['Bilangan_jawatankuasa'] == 'Pentadbiran (Lantikan NC & ke atas)') && $p['berelaun'] && (($p['Peranan_jawatankuasa'] == 'Penyelaras Gugusan') || ($p['Peranan_jawatankuasa'] == 'Ketua Program'))) {
                //perkhidmatan-112
                $inputs['112']['input']++;
                $lain2 = false;
            }

            if (($p['Bilangan_jawatankuasa'] == 'Pentadbiran (Lantikan NC & ke atas)') && $p['berelaun'] && (($p['Peranan_jawatankuasa'] == 'Ketua Jabatan') || ($p['Peranan_jawatankuasa'] == 'Ketua Unit'))) {
                //perkhidmatan-113
                $inputs['113']['input']++;
                $lain2 = false;
            }

            if ($lain2 && ($p['Bilangan_jawatankuasa'] == 'Pentadbiran (Lantikan NC & ke atas)') && $p['berelaun']) {
                $inputs['114']['input']++;
            }

            if (($p['Bilangan_jawatankuasa'] == 'Pentadbiran (Lantikan NC & ke atas)') && !$p['berelaun'] && ($p['Tahap_jawatankuasa'] == 'Universiti')) {
                if ((strpos($p['Peranan_jawatankuasa'], 'Ketua') !== false)) {
                    //perkhidmatan-113
                    $inputs['115']['input']++;
                }

                if ((strpos($p['Peranan_jawatankuasa'], 'Exco') !== false)) {
                    //perkhidmatan-113
                    $inputs['116']['input']++;
                }

                if ((strpos($p['Peranan_jawatankuasa'], 'Ahli') !== false)) {
                    //perkhidmatan-113
                    $inputs['117']['input']++;
                }
            }

            $lain2 = true;
        }

        $inputs['231']['modal'] = 1;
        $inputs['231']['lain'] = 1;
        $inputs['231']['input'] = 0;

        $this->calcKategori5($inputs);

        return $inputs;
    }

    protected function calcKategori5(&$inputsKategori5)
    {
        foreach ($inputsKategori5 as $ind => $ik1) {
            if ($ik1['kategori'] == 5) {
                ArrayHelper::setValue($inputKomponen1, ($ind), ['skor' => $ik1['input'], 'nilai_mata' => $ik1['nilai_mata_id'], 'order_no' => $ik1['order_no'], 'kategori' => $ik1['kategori']]);
            }
        }

        $mataKomponen1 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 5, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();
        $mataKomponen2 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 5, 'nilai_mata_id' => 2])->indexBy(['aktiviti_id'])->asArray()->all();
        $mataKomponen3 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 5, 'nilai_mata_id' => 3])->indexBy(['aktiviti_id'])->asArray()->all();

        $base = 10000;
        $ahli = 0;

        foreach ($inputKomponen1 as $ind => $ik) {
            $tmpp = 0;

            if (($ik['aktiviti'] == 137)) {
                $amaun = $ik['skor'];
                ArrayHelper::setValue($skorKomponen2, $ind, $ik['skor'] ? ($ik['skor'] / $base * $mataKomponen1[14]['nilai_mata']) : 0);
                continue;
            }

            if (($ik['aktiviti'] == 138)) {
                ArrayHelper::setValue($skorKomponen2, $ind, 0);
                $ahli = $ik['skor'];
                continue;
            }

            if (($ik['aktiviti'] == 139)) {
                ArrayHelper::setValue($skorKomponen2, $ind, $ik['skor'] ? ($ahli / $base * $mataKomponen1[14]['nilai_mata'] / $ik['skor']) : 0);
                continue;
            }

            switch ($ik['nilai_mata']) {
                case 1:
                    $tmpp = (($mataKomponen1[$ik['order_no']]['nilai_mata'] * $ik['skor']));
                    break;
                case 2:
                    $tmpp = (($mataKomponen2[$ik['order_no']]['nilai_mata'] * $ik['skor']));
                    break;
                case 3:
                    $tmpp = (($mataKomponen3[$ik['order_no']]['nilai_mata'] * $ik['skor']));
                    break;
            }

            ArrayHelper::setValue($skorKomponen2, $ind, $tmpp);
        }

        foreach ($inputsKategori5 as $ind => $sett) {
            if ($sett['kategori'] == 5) {
                $inputsKategori5[$ind]['mata'] = $skorKomponen2[$ind];
            }
        }
    }

    public function actionCreateUrusTadbir($lppid)
    {
        $addon = new TblPengurusanPentadbiran();
        $doc = new TblDocuments();
        if ($addon->load(Yii::$app->request->post())) {
            $addon->lpp_id = $lppid;
            if ($addon->validate() && $addon->save(false)) {
                $this->addDocument($doc, $lppid, 7, $addon->id);
                return $this->renderAjax('_success-insert');
            }
        }
        return $this->renderAjax('create_bhg7', [
            'pnp' => $addon,
            'doc' => $doc
        ]);
    }

    public function actionDeleteUrusTadbir($id, $lppid)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $addon = TblPengurusanPentadbiran::findOne($id);
        if (!$addon) {
            throw new NotFoundHttpException("The requested page does not exist.");
            return ['success' => false];
        }
        $addon->delete();
        $this->delDocument($lppid, 7, $id);

        return ['success' => true];
    }

    public function actionUpdateUrusTadbir($lppid)
    {
        // Check if there is an Editable ajax request
        if (isset($_POST['hasEditable'])) {
            if (($model = TblPengurusanPentadbiran::find()->where(['lpp_id' => $lppid, 'id' => $_POST['editableKey']])->one()) == null) {
                $model = new TblPengurusanPentadbiran(); // your model can be loaded here
            }

            $atts = '';
            switch ($_POST['editableAttribute']) {
                case 'Bilangan_jawatankuasa':
                    $atts = 'kategori';
                    break;
                case 'Peranan_jawatankuasa':
                    $atts = 'peranan';
                    break;
                case 'Tahap_jawatankuasa':
                    $atts = 'tahap_lantikan';
                    break;
                case 'berelaun':
                    $atts = 'isElaun';
                    break;
                case 'nama_jawatan':
                    $atts = 'nama_jawatan';
                    break;
            }

            $model->{$atts} = $_POST[$_POST['editableAttribute']] ?? 0;

            // use Yii's response format to encode output as JSON
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            // read your posted model attributes
            if ($model->validate()) {
                $model->save(false);
                // // read or convert your posted information
                // $value = $model->skop_tugas;
                // if ($_POST['editableAttribute'] == 'hasTech') {
                //     if ($_POST[$_POST['editableAttribute']] == null) {
                //         $_POST[$_POST['editableAttribute']] = 0;
                //     }
                // }

                // return JSON encoded output in the below format
                return ['output' => $_POST[$_POST['editableAttribute']] ?? 0, 'message' => ''];

                // alternatively you can return a validation error
                // return ['output'=>'', 'message'=>'Validation error'];
            }
            // else if nothing to do always return an empty JSON encoded output
            else {
                return ['output' => '', 'message' => 'Invalid input'];
            }
        }
    }

    public function actionPjaxDataK5($lppid)
    {
        $json =  $this->dataKategori5($lppid, $list);

        $dataProvider2 = new \yii\data\ArrayDataProvider([
            'allModels' => $list,
            'pagination' => false,
        ]);

        return $this->renderAjax('_test5', [
            'dataProvider2' => $dataProvider2,
            'lpp' => $this->findLpp($lppid),
        ]);
    }

    public function actionPjaxResultK5($lppid)
    {
        $json =  $this->dataKategori5($lppid, $list);

        $lpp = $this->findLpp($lppid);
        $result = ArrayHelper::index(array_merge($json), null, 'kategori');
        $this->kategori5($result, (empty($this->currentJawatanTadbir($lpp)) ? 0 : 1), $lpp->gredGuru->gred, $peratusPemberatk12, $this->dataFapi($lpp)['k5'], $this->dataFapi($lpp)['limpahan'], $arryminik5);
        $summary = $this->findSummaryMrkh($lppid);
        $summary->lpp_id = $lppid;
        $summary->k5 = $peratusPemberatk12;
        $summary->save(false);

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $json,
            'pagination' => false,
        ]);

        return $this->renderAjax('_test_5', [
            'dataProvider' => $dataProvider,
            'lpp' => $lpp,
        ]);
    }

    // public function actionDataKategori6($lppid)
    protected function dataKategori6($lppid, &$clinical)
    {
        // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $inputs = \app\models\elnpt\simulation\RefAktivitiv2::find()->where(['kategori' => 6])->orderBy(['kategori' => SORT_ASC, 'kategori' => SORT_ASC, 'order_no' => SORT_ASC, 'isHakiki' => SORT_ASC])->indexBy('id')->asArray()->all();

        $lpp = $this->findLpp($lppid);

        $clinical = TblConsultationClinical::find()
            ->where(['ICKakitangan' => $lpp->PYD])
            // ->andWhere(['OR', ['>=', 'YEAR(TarikhMula)', $lpp->tahun], ['>=', 'YEAR(TarikhAkhir)', $lpp->tahun]])
            // ->andWhere(['ApproveStatus' => 'V'])
            ->asArray()
            ->all();

        $inputs['186']['auto'] = 1;
        $inputs['186']['input'] = 0;
        $inputs['187']['auto'] = 1;
        $inputs['187']['input'] = 0;
        $inputs['188']['auto'] = 1;
        $inputs['188']['input'] = 0;
        $inputs['189']['auto'] = 1;
        $inputs['189']['input'] = 0;
        $inputs['190']['auto'] = 1;
        $inputs['190']['input'] = 0;
        $inputs['191']['auto'] = 1;
        $inputs['191']['input'] = 0;
        $inputs['192']['auto'] = 1;
        $inputs['192']['input'] = 0;
        $inputs['193']['auto'] = 1;
        $inputs['193']['input'] = 0;
        $inputs['194']['auto'] = 1;
        $inputs['194']['input'] = 0;

        $inputs['195']['auto'] = 1;
        $inputs['195']['input'] = 0;
        $inputs['196']['auto'] = 1;
        $inputs['196']['input'] = 0;
        $inputs['197']['auto'] = 1;
        $inputs['197']['input'] = 0;
        $inputs['198']['auto'] = 1;
        $inputs['198']['input'] = 0;
        $inputs['199']['auto'] = 1;
        $inputs['199']['input'] = 0;

        $inputs['200']['auto'] = 1;
        $inputs['200']['input'] = 0;
        $inputs['201']['auto'] = 1;
        $inputs['201']['input'] = 0;

        foreach ($clinical as $k) {
            if ($k['ApproveStatus'] == 'V') {
                if ($k['JenisRawatan'] == 'Clinic sessions') {
                    $inputs['186']['input'] += ($k['JamTamat'] + 12) - $k['JamMula'];
                }

                if ($k['JenisRawatan'] == 'Clinical ward work/rounds') {
                    $inputs['187']['input'] += ($k['JamTamat'] + 12) - $k['JamMula'];
                }

                if (($k['JenisRawatan'] == 'Passive oncall') || ($k['JenisRawatan'] == 'Active oncall')) {
                    $inputs['188']['input'] += ($k['JamTamat'] + 12) - $k['JamMula'];
                }

                if ($k['JenisRawatan'] == 'Surgical procedures') {
                    $inputs['189']['input'] += ($k['JamTamat'] + 12) - $k['JamMula'];
                }

                if ($k['JenisRawatan'] == 'Medical laboratory services') {
                    $inputs['190']['input'] += ($k['JamTamat'] + 12) - $k['JamMula'];
                }

                if (strpos($k['Rawatan'], 'apc') !== false) {
                    $inputs['194']['input'] = 1;
                }
            }
        }

        $inputs['234']['modal'] = 1;
        $inputs['234']['lain'] = 1;
        $inputs['234']['input'] = 0;

        $this->calcKategori6($inputs);

        return $inputs;
    }

    protected function calcKategori6(&$inputsKategori6)
    {
        foreach ($inputsKategori6 as $ind => $ik1) {
            if ($ik1['kategori'] == 6) {
                ArrayHelper::setValue($inputKomponen1, ($ind), ['skor' => $ik1['input'], 'nilai_mata' => $ik1['nilai_mata_id'], 'order_no' => $ik1['order_no'], 'kategori' => $ik1['kategori'], 'aktiviti' => $ik1['kategori']]);
            }
        }

        $mataKomponen1 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 6, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();

        foreach ($inputKomponen1 as $ind => $ik) {
            ArrayHelper::setValue($skorKomponen2, $ind, (($mataKomponen1[$ik['order_no']]['nilai_mata'] * $ik['skor'])));
        }

        foreach ($inputsKategori6 as $ind => $sett) {
            if ($sett['kategori'] == 6) {
                $inputsKategori6[$ind]['mata'] = $skorKomponen2[$ind];
            }
        }
    }

    protected function skorArtikel($jenis, $gred)
    {
        switch ($jenis) {
            case 1:
                if ($gred == 1) return 5;
                return 2.5;
                break;
            case 2:
                if ($gred == 1) return 1.5;
                return 0.75;
                break;
            case 3:
                if ($gred == 1) return 2.5;
                return 5;
                break;
            case 4:
                if ($gred == 1) return 2;
                return 4;
                break;
            case 5:
                if ($gred == 1) return 1.5;
                return 3;
                break;
            case 6:
                if ($gred == 1) return 1;
                return 2;
                break;
            case 7:
                if ($gred == 1) return 1;
                return 0.5;
                break;
            case 8:
                if ($gred == 1) return 0.5;
                return 0.25;
                break;
            case 9:
                if ($gred == 1) return 0.625;
                return 1.25;
                break;
            case 10:
                if ($gred == 1) return 0.5;
                return 0.5;
                break;
            case 11:
                if ($gred == 1) return 0.5;
                return 0.5;
                break;
            case 12:
                if ($gred == 1) return 0.25;
                return 0.25;
                break;
            default:
                return 0;
                break;
        }
    }

    protected function currentJawatanTadbir($lpp)
    {
        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);
        // $tamat_dt = $tahun->pengisian_PYD_tamat;
        $tamat_dt = '2022/12/31';
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
                    SELECT
                    '0'              AS `id`,
                    'Pentadbiran (Lantikan NC & ke atas)' as `Bilangan_jawatankuasa`,
          `a`.`description`   AS `nama_jawatan`,
          'Jawatan Berelaun di Universiti' AS `Peranan_jawatankuasa`,
          'Universiti' AS `Tahap_jawatankuasa`,
          `a`.`flag`            AS `flag`,
          '' as file_hash, 'SMP UMS' as ver_by, 'SMP UMS' as ver_dt,
          `b`.`position_name` as name
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
        ((`a`.`ICNO` = '" . $lpp->PYD . "') AND (`a`.`paymentStatus`=1)
        and (`a`.`flag` <> 3)
        ) AND ((TIMESTAMPDIFF(MONTH, `a`.`start_date`, '" . $tamat_dt . "') > 6) AND (YEAR(`a`.`end_date`) >= '" . $lpp->tahun . "')) ORDER BY end_date DESC LIMIT 1");
        $result = $command->queryAll();
        return $result[0]['name'];
    }

    protected function bilPenulis($pub_id)
    {
        return intval(TblLnptPublicationV3::find()->where(['PubID' => $pub_id])->count());
    }

    protected function pubType($pub_type, $pub_ind)
    {
        $pubTypeList = [
            'Scientific Book' => [
                'High-Indexed (SCOPUS, WOS, ERA)' => 1,
                'Non-indexed' => 2,
            ],
            'Chapter(s) in Book' => [
                'High-Indexed (SCOPUS, WOS, ERA)' => 7,
                'Non-indexed' => 8,
            ],
            'Article' => [
                'High-Indexed (SCOPUS, WOS, ERA)' => 9,
                'Indexing (Mycite)' => 10,
            ],
        ];

        return $pubTypeList[$pub_type][$pub_ind];
    }

    protected function LoginAsUser($id, $ori)
    {
        $initialId =  Yii::$app->user->identity->ICNO;
        if ($id == $initialId) {
        } else {
            $user =  \app\models\User::findIdentity($id);
            Yii::$app->user->setIdentity($user);
            Yii::$app->session->set('user.penilai', $user);
        }
    }

    public function kategori1_2($settings, $gred, &$peratusPemberat, $pemberatFapi = 40, $peratus, &$arryminik1_2)
    {
        $merge = array_merge($settings[1], $settings[2]);
        $tmp = ArrayHelper::getColumn($merge, 'mata');

        $sasaranSetahun = $this->sasaranSetahun(1, $gred);

        $sasaranHakiki = (70 / 100) * $sasaranSetahun->sasaran;
        $sasaranNonHakiki = (30 / 100) * $sasaranSetahun->sasaran;

        $totalMata1 = array_sum(array_slice($tmp, 0, 6))  + array_sum(array_slice($tmp, 13, 10));
        $sasaran1 = $sasaranHakiki;
        $sasaran1 = round($sasaran1, 2);
        $mataHakiki = min($totalMata1, $sasaran1);
        $limpahanHakiki = $totalMata1 - $mataHakiki;

        $test = min($limpahanHakiki, ((($peratus ?? (1 / 3)) * 100) / 100) *  $sasaranNonHakiki);
        $totalMata2 = array_sum(array_slice($tmp, 6, 7)) +  array_sum(array_slice($tmp, 23)) + $test;
        $sasaran2 =  $sasaranNonHakiki;
        $sasaran2 = round($sasaran2, 2);
        $mataNonHakiki = min($totalMata2, $sasaran2);

        $jumlah = round($mataHakiki + $mataNonHakiki, 2);
        $peratus = round(($jumlah / ($sasaran1 + $sasaran2)) * 100, 2);
        $peratusPemberat = round(($peratus * $pemberatFapi) / 100);
        // return VarDumper::dump($jumlah, $depth = 10, $highlight = true);

        $arryminik1_2 = [
            'sasaranSetahun' => $sasaranSetahun->sasaran,
            'mataHakiki' => round($mataHakiki, 2),
            'limpahanHakiki' => round($limpahanHakiki, 2),
            'mataNonHakiki' => round($mataNonHakiki, 2),
            'jumlahHakiki' =>  round($jumlah, 2),
            'sasaranHakiki' => $sasaran1,
            'sasaranNonHakiki' => $sasaran2,
            'peratus' => round($peratus, 2),
            'peratusPemberat' => round($peratusPemberat, 2),
        ];
    }

    public function kategori3_4($settings, $gred, &$peratusPemberat, $pemberatFapi = 40, $peratus, &$arryminik3_4)
    {
        $merge = array_merge($settings[3], $settings[4]);
        $tmp = ArrayHelper::getColumn($merge, 'mata');

        $sasaranSetahun = $this->sasaranSetahun(3, $gred);

        $sasaranHakiki = (70 / 100) * $sasaranSetahun->sasaran;
        $sasaranNonHakiki = (30 / 100) * $sasaranSetahun->sasaran;

        $totalMata1 = array_sum(array_slice($tmp, 0, 24))  + array_sum(array_slice($tmp, 37, 12));
        $sasaran1 = $sasaranHakiki;
        $sasaran1 = round($sasaran1, 2);
        $mataHakiki = min($totalMata1, $sasaran1);
        $limpahanHakiki = $totalMata1 - $mataHakiki;

        $test = min($limpahanHakiki, ((($peratus ?? (1 / 3)) * 100) / 100) *  $sasaranNonHakiki);
        $totalMata2 = round(array_sum(array_slice($tmp, 24, 12)) +  array_sum(array_slice($tmp, 49))) + $test;
        $sasaran2 =  $sasaranNonHakiki;
        $sasaran2 = round($sasaran2, 2);
        $mataNonHakiki = min($totalMata2, $sasaran2);

        $jumlah = round($mataHakiki + $mataNonHakiki, 2);
        $peratus = round(($jumlah / ($sasaran1 + $sasaran2)) * 100, 2);
        $peratusPemberat = round(($peratus * $pemberatFapi) / 100);
        // return VarDumper::dump($peratusPemberat, $depth = 10, $highlight = true);

        $arryminik3_4 = [
            'sasaranSetahun' => $sasaranSetahun->sasaran,
            'mataHakiki' => round($mataHakiki, 2),
            'limpahanHakiki' => round($limpahanHakiki, 2),
            'mataNonHakiki' => round($mataNonHakiki, 2),
            'jumlahHakiki' =>  round($jumlah, 2),
            'sasaranHakiki' => $sasaran1,
            'sasaranNonHakiki' => $sasaran2,
            'peratus' => round($peratus, 2),
            'peratusPemberat' => round($peratusPemberat, 2),
        ];
    }

    public function kategori5($settings, $statusElaun, $gred, &$peratusPemberat, $pemberatFapi = 20, $peratus, &$arryminik5)
    {
        $sasaranSetahun = $this->sasaranSetahun(5, $gred);

        $sasaranHakiki = (70 / 100) * $sasaranSetahun->sasaran;
        $sasaranNonHakiki = (30 / 100) * $sasaranSetahun->sasaran;

        $sasaranHakikiElaun = $sasaranHakiki;
        $sasaranNonHakikiElaun = $sasaranNonHakiki;

        $sasaranHakikiNonElaun = $sasaranHakiki;
        $sasaranNonHakikiNonElaun = $sasaranNonHakiki;

        $totalMata1 = array_sum(array_slice(ArrayHelper::getColumn($settings[5], 'mata'), 0, 17, true));
        $sasaran1 = ($statusElaun ? $sasaranHakikiElaun : $sasaranHakikiNonElaun);
        $sasaran1 = round($sasaran1, 2);
        $mataHakiki = min($totalMata1, $sasaran1);
        $limpahanHakiki = $totalMata1 - $mataHakiki;

        $test = min($limpahanHakiki, ((($peratus ?? (1 / 3)) * 100) / 100) * ($statusElaun ? $sasaranNonHakikiElaun : $sasaranNonHakikiNonElaun));
        $totalMata2 = array_sum(array_slice(ArrayHelper::getColumn($settings[5], 'mata'), 17)) + $test;
        $sasaran2 = ($statusElaun ? $sasaranNonHakikiElaun : $sasaranNonHakikiNonElaun);
        $sasaran2 = round($sasaran2, 2);
        $mataNonHakiki = min($totalMata2, $sasaran2);

        $jumlah = round($mataHakiki + $mataNonHakiki, 2);
        $peratus = round(($jumlah / ($sasaran1 + $sasaran2)) * 100, 2);
        $peratusPemberat = round(($peratus * $pemberatFapi) / 100);

        $arryminik5 = [
            'sasaranSetahun' => $sasaranSetahun->sasaran,
            'mataHakiki' => round($mataHakiki, 2),
            'limpahanHakiki' => round($limpahanHakiki, 2),
            'mataNonHakiki' => round($mataNonHakiki, 2),
            'jumlahHakiki' =>  round($jumlah, 2),
            'sasaranHakiki' => $sasaran1,
            'sasaranNonHakiki' => $sasaran2,
            'peratus' => round($peratus, 2),
            'peratusPemberat' => round($peratusPemberat, 2),
        ];
    }

    public function kategori6($settings, $gred, &$peratusPemberat, $pemberatFapi = 0, $peratus, &$arryminik6)
    {
        $merge = array_merge($settings[6]);
        $tmp = ArrayHelper::getColumn($merge, 'mata');

        $sasaranSetahun = $this->sasaranSetahun(6, $gred);

        $sasaranHakiki = (70 / 100) * $sasaranSetahun->sasaran;
        $sasaranNonHakiki = (30 / 100) * $sasaranSetahun->sasaran;

        $totalMata1 = array_sum(array_slice($tmp, 0, 9, true));
        $sasaran1 = $sasaranHakiki;
        $sasaran1 = round($sasaran1, 2);
        $mataHakiki = min($totalMata1, $sasaran1);
        $limpahanHakiki = $totalMata1 - $mataHakiki;

        $test = min($limpahanHakiki, ((($peratus ?? (1 / 3)) * 100) / 100) * $sasaranNonHakiki);
        $totalMata2 = array_sum(array_slice($tmp, 9)) + $test;
        $sasaran2 =  $sasaranNonHakiki;
        $sasaran2 = round($sasaran2, 2);
        $mataNonHakiki = min($totalMata2, $sasaran2);

        $jumlah = round($mataHakiki + $mataNonHakiki, 2);
        $peratus = $sasaranHakiki ? round(($jumlah / ($sasaran1 + $sasaran2)) * 100, 2) : 0;
        $peratusPemberat = round(($peratus * $pemberatFapi) / 100);

        $arryminik6 = [
            'sasaranSetahun' => $sasaranSetahun->sasaran,
            'mataHakiki' => round($mataHakiki, 2),
            'limpahanHakiki' => round($limpahanHakiki, 2),
            'mataNonHakiki' => round($mataNonHakiki, 2),
            'jumlahHakiki' =>  round($jumlah, 2),
            'sasaranHakiki' => $sasaran1,
            'sasaranNonHakiki' => $sasaran2,
            'peratus' => round($peratus, 2),
            'peratusPemberat' => round($peratusPemberat, 2),
        ];

        // return VarDumper::dump($peratusPemberat, $depth = 10, $highlight = true);
    }

    protected function dataFapi($lpp)
    {
        $currJawatan = strtoupper($this->currentJawatanTadbir($lpp));

        if (($model = \app\models\elnpt\simulation\RefCalcFapi::find()
            ->where(['dept_id' => $lpp->jfpiu, 'isTadbir' => (empty($currJawatan) ? 0 : 1)])
            ->andWhere([
                'or',
                ['gred_skim' => $lpp->gredGuru->gred_skim],
                ['isJawatan' => (empty($currJawatan) ? null : (empty(\app\models\elnpt\simulation\TblCalcInput::jawatanPentadbiran()[$currJawatan]) ? null : 1))]
            ])
            ->one()
        ) !== null) {
            return ArrayHelper::toArray($model, [
                'app\models\elnpt\simulation\RefCalcFapi' => [
                    'label' => function ($model) {
                        return $model->label;
                    },
                    'k1_k2' => function ($model) {
                        return $model->k1_k2;
                    },
                    'k3_k4' => function ($model) {
                        return $model->k3_k4;
                    },
                    'k5' => function ($model) {
                        return $model->k5;
                    },
                    'k6' => function ($model) {
                        return $model->k6;
                    },
                    'limpahan' => function ($model) {
                        return $model->limpahan;
                    },
                    'saiz_kelas' => function ($model) {
                        return $model->saiz_kelas;
                    },
                ],
            ]);
        }
        return [
            'label' => 'DEFAULT',
            'k1_k2' => 40,
            'k3_k4' => 40,
            'k5' => 20,
            'k6' => (strpos($lpp->gredGuru->gred, 'DU') !== false) ? 20 : 0,
            'limpahan' => 33.33,
            'saiz_kelas' => 50,
        ];
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
            case 'DG41':
                return 1;
                break;
            case 'DG44':
                return 1;
                break;
            case 'DG48':
                return 1.2;
                break;
            case 'DG52':
                return 1.4;
                break;
            case 'DG54':
                return 1.6;
                break;
            default:
                return 1;
                break;
        }
    }

    protected function sasaranSetahun($kategori, $gred)
    {
        if (($model = RefSasaranSetahun::find()->where(['kategori' => $kategori, 'gred' => $gred])->one()) !== null) {
            return $model;
        }
        throw new UserException('The requested data does not exist.');
    }

    protected function findSummaryMrkh($lppid)
    {
        if (($model = TblRingkasanMarkah::find()->where(['lpp_id' => $lppid])->one()) !== null) {
            return $model;
        }
        // throw new UserException('The requested data does not exist.');
        return new TblRingkasanMarkah();
    }

    protected function getJulatPeratus($markah)
    {
        switch (true) {
            case ($markah > 0 && $markah < 50):
                return 'LEMAH';
                break;
            case ($markah >= 50 && $markah < 60):
                return 'KURANG MEMUASKAN';
                break;
            case ($markah >= 60 && $markah < 80):
                return 'SEDERHANA';
                break;
            case ($markah >= 80 && $markah < 90):
                return 'BAIK';
                break;
            case ($markah >= 90):
                return 'CEMERLANG';
                break;
            default:
                return 'TIADA MAKLUMAT/ BELUM ISI';
                break;
        }
    }

    public function getTahun($lpp_id)
    {
        if (($lpp = TblMain::findOne(['lpp_id' => $lpp_id])) != null) {
            $lpp = TblMain::findOne(['lpp_id' => $lpp_id]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $lpp->tahun;
    }

    public function addDocument($doc, $lppid, $bhg_no, $id_table)
    {
        $doc->file = UploadedFile::getInstance($doc, 'file');
        // $tmp = $doc->filehash;
        if ($doc->file) {
            $file = Yii::$app->FileManager->UploadFile($doc->file->name, $doc->file->tempName, '04', 'LNPT/Akademik/' . $this->getTahun($lppid) . '/bhg_' . $bhg_no . '');
            if ($file->status == true) {
                $doc->lpp_id = $lppid;
                $doc->bhg_no = $bhg_no;
                $doc->id_table = $id_table;
                $doc->filehash = $file->file_name_hashcode;
                $doc->file_name = $doc->file->name;
                $doc->created_dt = new \yii\db\Expression('NOW()');
                $doc->save(false);
            }
        }
    }

    public function delDocument($lppid, $bhg_no, $id_table)
    {
        $doc = TblDocuments::find()->where(['lpp_id' => $lppid, 'bhg_no' => $bhg_no, 'id_table' => $id_table])->one();
        Yii::$app->FileManager->DeleteFile($doc->filehash);
        $doc->delete();
    }

    public function actionVerifyDocument($lppid, $filehash)
    {

        if (isset($_POST['hasEditable'])) {
            // use Yii's response format to encode output as JSON
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if (($doc = TblDocuments::find()->where(['lpp_id' => $lppid, 'filehash' => $filehash])->one()) === null) {
                return ['output' => '', 'message' => 'Invalid input'];
            }

            if ($_POST['ver_by'] == 1) {
                $doc->verified_by = Yii::$app->user->identity->ICNO;
                $doc->verified_dt = new \yii\db\Expression('NOW()');
                $doc->ulasan = '';
            } else {
                $doc->verified_by = null;
                $doc->verified_dt = null;
                $doc->ulasan = null;
            }

            // read your posted model attributes
            if ($doc->save(false)) {
                // // read or convert your posted information

                // return JSON encoded output in the below format
                return ['output' => $_POST['ver_by'] ?? 0, 'message' => ''];

                // alternatively you can return a validation error
                // return ['output'=>'', 'message'=>'Validation error'];
            }
            // else if nothing to do always return an empty JSON encoded output
            else {
                return ['output' => '', 'message' => 'Invalid input'];
            }
        }
    }

    public function actionViewFile($hashfile, $lppid)
    {
        if ($hashfile == null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->redirect(Yii::$app->FileManager->DisplayFile($hashfile));
    }

    public function actionManualKeyIn($lppid, $activity_id)
    {
        $refAktiviti = \app\models\elnpt\simulation\RefAktivitiv2::find()->where(['id' => $activity_id])->one();

        if (($model = TblManualKeyIn::find()->where(['lpp_id' => $lppid, 'aktiviti_id' => $activity_id])->one()) == null) {
            $model = new TblManualKeyIn();
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file) {
                $file = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'LNPT/Akademik/' . $this->getTahun($lppid) . '/kategori_' . $refAktiviti->kategori . '');
                if ($file->status == true) {
                    $model->lpp_id = $lppid;
                    $model->activity_id = $activity_id;
                    $model->filehash = $file->file_name_hashcode;
                    $model->file_name = $model->file->name;
                    $model->verified_dt = new \yii\db\Expression('NOW()');
                    $model->verified_by = Yii::$app->user->identity->ICNO;

                    if ($model->validate() && $model->save()) {
                        return $this->renderAjax('_success-insert');
                    }
                }
            }
        }
        return $this->renderAjax('manual_keyin', [
            'model' => $model,
            'label' => $refAktiviti->aktiviti,
        ]);
    }

    public function actionAktivitiLain($lppid, $kategori)
    {
        $model = new TblAktivitiLain();

        $query = TblAktivitiLain::find()->where(['lpp_id' => $lppid, 'kategori' => $kategori]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        return $this->renderAjax('aktiviti_lain', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'lppid' => $lppid,
            'kategori' => $kategori,
        ]);
    }

    public function actionTambahAktivitiLain($lppid, $kategori)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new TblAktivitiLain();

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file) {
                $file = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'LNPT/Akademik/' . $this->getTahun($lppid) . '/kategori_' . $kategori . '/aktiviti_lain//');
                if ($file->status == true) {
                    $model->lpp_id = $lppid;
                    $model->kategori = $kategori;
                    $model->filehash = $file->file_name_hashcode;
                    $model->file_name = $model->file->name;

                    if ($model->validate(false) && $model->save(false)) {
                        // \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya ditambah!']);
                        // return $this->renderAjax('_grid_lain_aktiviti');
                        return ['success' => true];
                    }
                }
            }
        }

        return ['success' => false];
    }

    public function actionPadamAktivitiLain($id, $lppid)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $act = TblAktivitiLain::findOne($id);
        if (!$act) {
            throw new NotFoundHttpException("The requested page does not exist.");
            return ['success' => false];
        }
        $act->delete();
        Yii::$app->FileManager->DeleteFile($act->filehash);

        return ['success' => true];
    }

    public function actionPjaxAktivitiLain($lppid, $kategori)
    {
        $query = TblAktivitiLain::find()->where(['lpp_id' => $lppid, 'kategori' => $kategori]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        return $this->renderAjax('_aktiviti_lain', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTambahPelajar($lppid)
    {
        $model = new TblPelajarManual();

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                $file = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'LNPT/Akademik/' . $this->getTahun($lppid) . '/list_pelajar//');
                if ($file->status == true) {
                    $model->lpp_id = $lppid;
                    $model->filehash = $file->file_name_hashcode;
                    $model->filename = $model->file->name;

                    if ($model->validate(false) && $model->save(false)) {
                        return $this->renderAjax('_success-insert');
                    }
                }
            }
        }

        return $this->renderAjax('tmbh_pljr', [
            'model' => $model,
        ]);
    }

    public function actionNameList($page, $q = null, $id = null)
    {
        $limit = 5;
        $offset = ($page - 1) * $limit;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $data = RefPeribadiPelajar::find()
                ->select(new Expression('SMP01_Nomatrik as id, (SMP01_Nomatrik + \' - \' + SMP01_Nama) as text'))
                ->where(['like', 'SMP01_Nama', $q])
                ->offset($offset)
                ->limit($limit)
                ->asArray()->all();
            $out['results'] = array_values($data);
            $out['pagination'] = ['more' => !empty($data) ? true : false];
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => RefPeribadiPelajar::find($id)->SMP01_Nama];
        }
        return $out;
    }

    //ticket subsystem
    public function actionMyTickets($lppid)
    {
        $tickets = TblTicket::find()
            ->where(['lpp_id' => $lppid])
            ->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $tickets,
        ]);

        return $this->renderAjax('_tickets', [
            'dataProvider' => $dataProvider,
            'lpp' => $this->findLpp($lppid),
        ]);
    }

    public function actionAddSupportTicket($lppid)
    {
        $model = new TblTicket();

        if ($model->load(Yii::$app->request->post())) {
            $model->lpp_id = $lppid;
            $model->status = 0;
            $model->priority = 0;
            $model->created_at = new \yii\db\Expression('NOW()');
            if ($model->validate() && $model->save()) {
                return $this->renderAjax('_success-insert');
            }
        }

        return $this->renderAjax('add_ticket', [
            'model' => $model,
            'lpp' => $this->findLpp($lppid),
        ]);
    }

    public function actionPjaxTickets($lppid)
    {
        $tickets = TblTicket::find()
            ->where(['lpp_id' => $lppid])
            ->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $tickets,
        ]);

        return $this->renderAjax('_pjax_tickets', [
            'dataProvider' => $dataProvider,
            'lpp' => $this->findLpp($lppid),
        ]);
    }

    public function actionMyContentsByTicket($lppid, $ticket_id)
    {
        $model = new TblTicketContent();

        $ticket = TblTicket::findOne(['id' => $ticket_id]);

        $timeline = TblTicketContent::find()
            ->alias('a')
            ->select('a.title, a.created_at as byline, b.CONm, a.content, a.filehash')
            ->leftJoin(['b' => 'hronline.tblprcobiodata'], 'a.ICNO = b.ICNO')
            ->where(['a.ticket_id' => $ticket_id])
            ->orderBy(['.created_at' => SORT_ASC, '.updated_at' => SORT_ASC])
            ->asArray()
            ->all();

        foreach ($timeline as $ind => $t) {
            $timeline[$ind]['byline'] = Yii::$app->formatter->asDateTime($t['byline'], "php:d/m/Y  h:i A") . ' by ' . $t['CONm'];
        }

        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        //     'pagination' => false,
        // ]);

        return $this->renderAjax('_contents', [
            'model' => $model,
            // 'dataProvider' => $dataProvider,
            'timeline' => $timeline,
            'ticket' => $ticket,
        ]);
    }

    public function actionAddContent($lppid, $ticket_id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new TblTicketContent();

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            $model->ticket_id = $ticket_id;
            $model->ICNO = Yii::$app->user->identity->ICNO;
            $model->created_at = new \yii\db\Expression('NOW()');

            if ($model->file) {
                $file = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'LNPT/Akademik/helpdesk//');
                if ($file->status == true) {
                    $model->filehash = $file->file_name_hashcode;
                    $model->filename = $model->file->name;
                }
            }

            if ($model->validate(false) && $model->save(false)) {
                $ticket = TblTicket::findOne(['id' => $ticket_id]);
                $ticket->status = 0;
                $ticket->save(false);

                // \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya ditambah!']);
                // return $this->renderAjax('_grid_lain_aktiviti');
                return ['success' => true];
            }
        }

        return ['success' => false];
    }

    public function actionPjaxTicketTimeline($lppid, $ticket_id)
    {
        $timeline = TblTicketContent::find()
            ->alias('a')
            ->select('a.title, a.created_at as byline, b.CONm, a.content, a.filehash')
            ->leftJoin(['b' => 'hronline.tblprcobiodata'], 'a.ICNO = b.ICNO')
            ->where(['a.ticket_id' => $ticket_id])
            ->orderBy(['.created_at' => SORT_ASC, '.updated_at' => SORT_ASC])
            ->asArray()
            ->all();

        foreach ($timeline as $ind => $t) {
            $timeline[$ind]['byline'] = Yii::$app->formatter->asDateTime($t['byline'], "php:d/m/Y  h:i A") . ' by ' . $t['CONm'];
        }

        return $this->renderAjax('_ticket_timeline', [
            'timeline' => $timeline,
            'lppid' => $lppid,
        ]);
    }

    public function actionTicketList()
    {
        \yii\helpers\Url::remember();
        $searchModel = new TblTicketSearch();
        $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
            'query' => TblTicket::find()->andFilterWhere([
                'category_id' => Yii::$app->request->get('category_id'),
                'status' => Yii::$app->request->get('status'),
                'priority' => Yii::$app->request->get('priority'),
                'ICNO' => Yii::$app->request->get('ICNO'),
            ]),
            'pagination' => false,
        ]);

        $totalOpen = TblTicket::find()->where(['status' => 0])->count();
        $totalWaiting = TblTicket::find()->where(['status' => 10])->count();
        $totalClose = TblTicket::find()->where(['status' => 100])->count();

        return $this->render('all_tickets_list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalOpen' => $totalOpen,
            'totalWaiting' => $totalWaiting,
            'totalClose' => $totalClose,
        ]);
    }

    public function actionPjaxTicketList()
    {
        // $searchModel = new TblTicketSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider = new ActiveDataProvider([
            'query' => TblTicket::find()->andFilterWhere([
                'category_id' => Yii::$app->request->get('category_id'),
                'status' => Yii::$app->request->get('status'),
                'priority' => Yii::$app->request->get('priority'),
                'ICNO' => Yii::$app->request->get('ICNO'),
            ]),
            'pagination' => false,
        ]);

        $totalOpen = TblTicket::find()->where(['status' => 0])->count();
        $totalWaiting = TblTicket::find()->where(['status' => 10])->count();
        $totalClose = TblTicket::find()->where(['status' => 100])->count();

        return $this->render('_all_tickets_list', [
            'dataProvider' => $dataProvider,
            'totalOpen' => $totalOpen,
            'totalWaiting' => $totalWaiting,
            'totalClose' => $totalClose,
        ]);
    }

    public function actionViewTicketAdmin($lppid, $ticket_id)
    {
        $ticket = TblTicket::findOne(['id' => $ticket_id]);

        if ($ticket->load(Yii::$app->request->post())) {
            if ($ticket->validate() && $ticket->save()) {

                if ($ticket->status == 100) {
                    $model = new TblTicketContent();
                    $model->ticket_id = $ticket_id;
                    $model->title = 'Ticket closed';
                    $model->content = 'This ticket has been closed. If you wish to reopen this ticket, please contact with BSM.';
                    $model->ICNO = Yii::$app->user->identity->ICNO;
                    $model->created_at = new \yii\db\Expression('NOW()');
                    $model->save();
                }

                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Ticket berjaya dikemaskini!']);
                return $this->redirect(['elnpt3/ticket-list']);
                // return $this->renderAjax('_success-insert');
            }
        }

        return $this->renderAjax('view_ticket_admin', [
            'ticket' => $ticket,
            'lpp' => $this->findLpp($lppid),
        ]);
    }

    public function actionViewTicketContentAdmin($lppid, $ticket_id)
    {
        $model = new TblTicketContent();

        $ticket = TblTicket::findOne(['id' => $ticket_id]);

        $timeline = TblTicketContent::find()
            ->alias('a')
            ->select('a.title, a.created_at as byline, b.CONm, a.content, a.filehash')
            ->leftJoin(['b' => 'hronline.tblprcobiodata'], 'a.ICNO = b.ICNO')
            ->where(['a.ticket_id' => $ticket_id])
            ->orderBy(['.created_at' => SORT_ASC, '.updated_at' => SORT_ASC])
            ->asArray()
            ->all();

        foreach ($timeline as $ind => $t) {
            $timeline[$ind]['byline'] = Yii::$app->formatter->asDateTime($t['byline'], "php:d/m/Y  h:i A") . ' by ' . $t['CONm'];
        }

        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        //     'pagination' => false,
        // ]);

        return $this->renderAjax('_contents_admin', [
            'model' => $model,
            // 'dataProvider' => $dataProvider,
            'timeline' => $timeline,
            'ticket' => $ticket,
        ]);
    }

    public function actionAddContentAdmin($lppid, $ticket_id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new TblTicketContent();

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            $model->ticket_id = $ticket_id;
            $model->ICNO = Yii::$app->user->identity->ICNO;
            $model->created_at = new \yii\db\Expression('NOW()');

            if ($model->file) {
                $file = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'LNPT/Akademik/helpdesk//');
                if ($file->status == true) {
                    $model->filehash = $file->file_name_hashcode;
                    $model->filename = $model->file->name;
                }
            }

            if ($model->validate(false) && $model->save(false)) {
                $ticket = TblTicket::findOne(['id' => $ticket_id]);
                $ticket->status = 10;
                $ticket->save(false);

                // \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya ditambah!']);
                // return $this->renderAjax('_grid_lain_aktiviti');
                return ['success' => true];
            }
        }

        return ['success' => false];
    }
}
