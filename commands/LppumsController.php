<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;

use app\models\lppums\Tblprcobiodata;
use app\models\Notification;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;

use app\base\Model;
use yii\base\Exception;
use app\models\lppums\TblMain;
use app\models\lppums\TblQueryApc;
use app\models\lppums\TblMarkahKeseluruhan;
use app\models\lppums\TblLppMarkah;
use yii\db\Expression;
use app\models\lppums\TblMataAkhir;
use app\models\lppums\TblStatistikIdp;
use app\models\lppums\TblStaffProjek;
use app\models\myidp\RptStatistikIdpV2;

use kartik\mpdf\Pdf;
use yii2tech\spreadsheet\Spreadsheet;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LppumsController extends Controller
{

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionMohonLpp($tahun)
    {

        $pydList = Tblprcobiodata::find()
            //->select(['`hronline`.`tblprcobiodata`.ICNO', 'd.fullname'])
            ->leftJoin(['a' => '`hrm`.`lppums_lpp`'], '`hronline`.`tblprcobiodata`.ICNO = `a`.PYD and `a`.tahun = ' . $tahun . '')
            ->leftJoin(['b' => '`hronline`.`gredjawatan`'], '`b`.id = `hronline`.`tblprcobiodata`.gredJawatan')
            ->leftJoin(['c' => '`hronline`.`jawatankategori`'], '`b`.job_category = c.id')
            ->leftJoin(['d' => '`hronline`.`department`'], '`d`.id = `hronline`.`tblprcobiodata`.DeptId')
            ->where(['in', 'Status', [1, 2, 3, 4, 5]])
            ->andWhere(['in', 'statLantikan', [1, 2, 3, 6, 7, 51]])
            ->andWhere(['IS', '`a`.PYD', new \yii\db\Expression('null')])
            ->andWhere(['or', ['in', 'b.id', [2, 3, 4, 5]], ['`c`.id' => 2]])
            ->andWhere(['a.`PYD`' => null]);

        //$lpp = Model::createMultiple(TblMain::classname());

        if ($pydList->exists()) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                //if ($flag = $modelCustomer->save(false)) {
                foreach ($pydList->all() as $pyd) {
                    $lpp = new TblMain();
                    $lpp->PYD = $pyd->ICNO;
                    $lpp->tahun = $tahun;
                    $lpp->lpp_datetime = new \yii\db\Expression('NOW()');
                    $lpp->PYD_sts_lantikan = $pyd->statLantikan;
                    $lpp->gred_jawatan_id = $pyd->gredJawatan;
                    $lpp->jspiu = $pyd->DeptId;
                    $lpp->save(false);
                    if (!($flag = $lpp->save(false))) {
                        $transaction->rollBack();
                        break;
                    }
                }
                //}
                if ($flag) {
                    $transaction->commit();
                    echo 'Process Done';
                    return ExitCode::OK;
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        } else {
            echo 'Semua PYD suda memohon LPP.';
            return ExitCode::OK;
        }
    }

    public function actionMohonLppByInput(array $senaraiIc, $tahun)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $flag = false;
            //if ($flag = $modelCustomer->save(false)) {
            foreach ($senaraiIc as $ic) {
                if (TblMain::find()->where(['PYD' => $ic, 'tahun' => $tahun])->exists()) {
                    continue;
                }

                $lpp = new TblMain();
                $lpp->PYD = $ic;
                $lpp->tahun = $tahun;
                $lpp->lpp_datetime = new \yii\db\Expression('NOW()');

                if (($staff = Tblprcobiodata::find()->where(['ICNO' => $ic])->one()) == null) {
                    echo 'error ' . $ic . ' ';
                    continue;
                }

                $lpp->PYD_sts_lantikan = $staff->statLantikan;
                $lpp->gred_jawatan_id = $staff->gredJawatan;
                $lpp->jspiu = $staff->DeptId;
                $lpp->save(false);
                if (!($flag = $lpp->save(false))) {
                    $transaction->rollBack();
                    break;
                }
            }
            //}
            if ($flag) {
                $transaction->commit();
                echo 'Process Done';
                return ExitCode::OK;
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            echo 'Error jana borang' . $e;
            return ExitCode::OK;
        }

        echo 'Semua PYD suda memohon LPP.';
        return ExitCode::OK;
    }

    public function actionNotify()
    {
        //        $biodata = Tblprcobiodata::findAll(['Status' => 1]);
        //        
        //        $baru = Tblprcobiodata::find()
        //                ->where(['Status' => 1])
        //                ->andWhere(['LIKE', 'COOldID', substr(date('Y'), -2).'%', false]);

        //$month = date("m",strtotime("-1 month"));
        //        'DATEDIFF(m, startDateLantik, '.date("Y-m-d").')'

        //        $all = Tblprcobiodata::find()
        //                ->select(['`hronline`.`tblprcobiodata`.ICNO', 'd.fullname'])
        //                ->leftJoin(['a' => '`hrm`.`lppums_lpp`'], '`hronline`.`tblprcobiodata`.ICNO = `a`.PYD and `a`.tahun = '.date('y').'')
        //                ->leftJoin(['b' => '`hronline`.`gredjawatan`'], '`b`.id = `hronline`.`tblprcobiodata`.gredJawatan')
        //                ->leftJoin(['c' => '`hronline`.`jawatankategori`'], '`b`.job_category = c.id')
        //                ->leftJoin(['d' => '`hronline`.`department`'], '`d`.id = `hronline`.`tblprcobiodata`.DeptId')
        //                ->where(['in', 'Status', [1, 2, 3, 4, 5]])
        //                ->andWhere(['in', 'statLantikan', [1, 2, 3, 6, 7, 51]])
        //                ->andWhere(['IS', '`a`.PYD', new \yii\db\Expression('null')])
        //                //->andWhere(['`a`.PYD' => 801221125270])
        //                ->andWhere(['or', ['in', 'b.id', [2, 3, 4, 5]], ['`c`.id' => 2]]);


        $baru = Tblprcobiodata::find()
            ->select(['`hronline`.`tblprcobiodata`.ICNO', new \yii\db\Expression("(TIMESTAMPDIFF(MONTH, startDateLantik, curdate())) as diff")])
            ->leftJoin(['a' => '`hrm`.`lppums_lpp`'], '`hronline`.`tblprcobiodata`.ICNO = `a`.PYD and `a`.tahun = ' . date('y') . '')
            ->leftJoin(['b' => '`hronline`.`gredjawatan`'], '`b`.id = `hronline`.`tblprcobiodata`.gredJawatan')
            ->leftJoin(['c' => '`hronline`.`jawatankategori`'], '`b`.job_category = c.id')
            ->where(['in', 'Status', [1, 2, 3, 4, 5]])
            ->andWhere(['LIKE', 'COOldID', substr(date('Y'), -2) . '%', false])
            ->andWhere(['IS', '`a`.PYD', new \yii\db\Expression('null')])
            //->andWhere(['>', 'startDateLantik', new \yii\db\Expression('DateAdd(m, 6, GETDATE())')])
            //->andWhere(['=', '`a`.tahun', 2019])
            ->andWhere(['in', 'statLantikan', [1, 2, 3, 6, 7, 51]])
            ->andWhere(['or', ['in', 'b.id', [2, 3, 4, 5]], ['`c`.id' => 2]])
            ->having(['>', 'diff', 6]);


        $lama = Tblprcobiodata::find()
            ->select(['`hronline`.`tblprcobiodata`.ICNO', 'd.fullname'])
            ->leftJoin(['a' => '`hrm`.`lppums_lpp`'], '`hronline`.`tblprcobiodata`.ICNO = `a`.PYD and `a`.tahun = ' . date('y') . '')
            ->leftJoin(['b' => '`hronline`.`gredjawatan`'], '`b`.id = `hronline`.`tblprcobiodata`.gredJawatan')
            ->leftJoin(['c' => '`hronline`.`jawatankategori`'], '`b`.job_category = c.id')
            ->leftJoin(['d' => '`hronline`.`department`'], '`d`.id = `hronline`.`tblprcobiodata`.DeptId')
            ->where(['in', 'Status', [1, 2, 3, 4, 5]])
            ->andWhere(['NOT LIKE', 'COOldID', substr(date('Y'), -2) . '%', false])
            ->andWhere(['IS', '`a`.PYD', new \yii\db\Expression('null')])
            //->andWhere(['=', '`a`.tahun', 2019])
            ->andWhere(['in', 'statLantikan', [1, 2, 3, 6, 7, 51]])
            ->andWhere(['or', ['in', 'b.id', [2, 3, 4, 5]], ['`c`.id' => 2]]);
        //->andWhere(['a'])
        //->andWhere(['`c`.id' => 2]);

        if ($baru->exists()) {
            //            if($month > 6) {
            //echo $lama->count();
            foreach ($lama->all() as $lm) {
                $ntf = new Notification();
                $ntf->icno = $lm->ICNO;
                $ntf->title = 'Pengisian Lnpt';
                $ntf->content = "Teda Isi";
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                echo $lm->ICNO;
            }
            //}
        }

        //        foreach($baru as $br) {
        //            echo $br['diff'];
        //        }

        //        echo $lama->count();
        //echo print_r($lama->orderBy(['d.fullname' => SORT_ASC])->asArray()->all());

        //echo ' ';

        //echo sizeof($lama->orderBy(['d.fullname' => SORT_ASC])->asArray()->all());

        //echo $all->count();

        if ($lama->exists()) {
            $timestamp = time();
            if (date('n', $timestamp) === '7') {
                if (date('j', $timestamp) === '1') {
                    foreach ($lama->all() as $lm) {
                        $ntf = new Notification();
                        $ntf->icno = $lm->ICNO;
                        $ntf->title = 'Pengisian Lnpt';
                        $ntf->content = "Teda Isi";
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save();
                        //echo $lm->ICNO;
                    }
                }
            }
        }

        return ExitCode::OK;
    }

    public function actionTest()
    {
        echo 'test';

        return ExitCode::OK;
    }

    public function actionGenerateMarkah($tahun)
    {

        $lppp = TblMain::find()
            ->where(['tahun' => $tahun])
            ->all();

        //        $cnt = 0;

        foreach ($lppp as $lpp) {

            $mrkh_slrh = TblLppMarkah::find()
                ->select(new Expression('
                    (SUM(markah_PPP)/(COUNT(markah_PPP) * 10)) * b.`markah_bahagian` AS ppp, 
                    (SUM(markah_PPK)/(COUNT(markah_PPK) * 10)) * b.`markah_bahagian` AS ppk
                    '))
                ->leftJoin(['a' => 'hrm.lppums_bahagian_has_kriteria'], 'a.`bhk_id` = hrm.lppums_lpp_markah.`bhk_id`')
                ->leftJoin(['b' => 'hrm.lppums_markah_bahagian'], 'a.`bahagian_id` = b.`bahagian_id`')
                ->where(['lpp_id' => $lpp->lpp_id, 'b.`kump_khidmat`' => $lpp->gredJawatan->job_group])
                ->andWhere(['!=', 'b.`bahagian_id`', 5])
                ->groupBy('b.`bahagian_id`')
                ->asArray()
                ->all();

            $layak = 'layak' . $lpp->tahun;

            $jumlah = 'jum' . $lpp->tahun;

            if ($lpp->tahun >= 2020) {
                $summm = RptStatistikIdpV2::find()->where(['icno' => $lpp->PYD, 'tahun' => $lpp->tahun])->one();
                $jum_min = $summm->idp_mata_min;
                $jum_dikira = $summm->jum_mata_dikira;
            } else {
                $mataCpd2 = TblMataAkhir::find()
                    ->where(['icno' => $lpp->PYD])
                    ->one();

                $mataCpd = TblStatistikIdp::find()->where(['tahun' => $lpp->tahun, 'icno' => $lpp->PYD])->one();

                $jum_min = !is_null($mataCpd) ? (!isset($mataCpd2->{$layak}) ? '' : $mataCpd2->{$layak}) : (!isset($mataCpd->idp_mata_min) ? 0 : $mataCpd->idp_mata_min);

                $jum_dikira = !is_null($mataCpd) ? (!isset($mataCpd2->{$jumlah}) ? '' : $mataCpd2->{$jumlah}) : (!isset($mataCpd->jum_mata_dikira) ? 0 : $mataCpd->jum_mata_dikira);
            }

            $ppp = array_sum(ArrayHelper::getColumn($mrkh_slrh, 'ppp'));
            $ppk = array_sum(ArrayHelper::getColumn($mrkh_slrh, 'ppk'));

            if (($model = TblMarkahKeseluruhan::find()->where(['lpp_id' => $lpp->lpp_id])->one()) !== null) {
                $model = TblMarkahKeseluruhan::find()->where(['lpp_id' => $lpp->lpp_id])->one();
            } else {
                $model = new TblMarkahKeseluruhan();
            }

            if (($jum_min > 0) and ($jum_min >= $jum_dikira)) {
                $idp = 8;
            } else if ($jum_dikira > 0 and $jum_dikira < $jum_min) {
                $idp = 3;
            } else if ($jum_dikira == 0) {
                $idp = 0;
            }

            if ($lpp->tahun >= 2020) {
                $staf_projek = TblStaffProjek::find()->where(['icno' => $lpp->PYD])->exists();
                if ($staf_projek) {
                    $idp = 8;
                }
            }

            //        return \yii\helpers\VarDumper::dump($idp, 10, true);

            $model->lpp_id = $lpp->lpp_id;
            //$model->markah_PPP = array_sum(array_column($query, 'markah_PPP'));

            if ($lpp->PYD_sts_lantikan == 7) {
                $model->markah_PPP = (($ppp + $idp) / 100) * 100;
                $model->markah_PPK = (($ppk + $idp) / 100) * 100;
            } else {
                $model->markah_PPP = (($ppp + $idp) / 108) * 100;
                $model->markah_PPK = (($ppk + $idp) / 108) * 100;
            }

            //        return \yii\helpers\VarDumper::dump($model->markah_PPP, 10, true);

            if (!$lpp->PP_ALL) {
                $model->markah_PP = ($model->markah_PPP + $model->markah_PPK) / 2;
            } else {
                $model->markah_PPK = null;
                $model->markah_PP = $model->markah_PPP;
            }

            if ($lpp->tahun == $tahun) {
                $model->save(false);
                //                echo $lpp->tahun.' ';
                //                $cnt = $cnt + 1;
            }
        }

        echo 'Process Done untuk tahun penilaian ' . $tahun;
        return ExitCode::OK;
    }

    protected function findLpp($lpp_id)
    {
        if (($model = TblMain::findOne($lpp_id)) !== null) {
            return $model;
        }

        throw new yii\base\UserException('The requested page does not exist.');
    }

    public function actionPrintBorangPyd($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        $content = $this->renderPartial('_lpp_borang_pyd', [
            'lpp' => $lpp,
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // 'filename' => $biodata->ICNO.'_'.$biodata->jawatan->job_category.' ('.date('Y', strtotime($lpg->srb_effective_date)).').pdf',
            'filename' => '1.pdf',
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_FILE,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => "lpgreport"],
            // call mPDF methods on the fly
            'methods' => [
                // 'SetHeader' => ["Attendance Report"],
                // 'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                //'SetFooter' => [' {PAGENO}'],
                //'SetFooter' => [' '],
            ]
        ]);

        $pdf->render();

        return ExitCode::OK;
    }

    public function actionGenerateLaporan($jfpiu = null, $tahun = null, $range = null, $purata = null, $icno)
    {
        if ($range == null or empty($range)) {
            $query = TblMain::find()
                ->andFilterWhere(['jspiu' => $jfpiu])
                ->andFilterWhere(['tahun' => $tahun]);
        } else {
            $query = TblMain::find()
                ->leftJoin(['a' => 'hrm.lppums_markah_keseluruhan'], 'a.lpp_id = hrm.lppums_lpp.lpp_id')
                ->andFilterWhere(['jspiu' => $jfpiu])
                ->andFilterWhere(['tahun' => $tahun])
                ->andFilterWhere([$range, 'a.markah_PP', $purata]);
        }

        $exporter = new Spreadsheet([
            //            'dataProvider' => new ActiveDataProvider([
            //                'query' => TblMain::find(),
            //                
            //            ]),
            'query' => $query,
            'batchSize' => 200,
            'columns' => [
                [
                    'label' => 'NAMA',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->pyd) ? '' : $model->pyd->CONm;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'UMSPER',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->pyd) ? '' : $model->pyd->COOldID;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'GRED',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->pyd) ? '' : $model->pyd->jawatan->gred;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'JAWATAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->pyd) ? '' : $model->pyd->jawatan->nama;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'JFPIU',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->pyd) ? '' : $model->pyd->department->fullname;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'KUMPULAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->pyd) ? '' : $model->pyd->jawatan->skimPerkhidmatan->name;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'STATUS',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->pyd) ? '' : $model->pyd->serviceStatus->ServStatusNm;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'LANTIKAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->pyd) ? '' : $model->pyd->statusLantikan->ApmtStatusNm;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'TARIKH LANTIKAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->pyd) ? '' : $model->pyd->startDateLantik;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'TARIKH SANDANGAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->pyd) ? '' : $model->pyd->startDateSandangan;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'TARIKH STATUS',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->pyd) ? '' : $model->pyd->startDateStatus;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'NAMA PPP',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->ppp) ? null : $model->ppp->CONm;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'NAMA PPK',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->ppk) ? null : $model->ppk->CONm;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'TARIKH SAH DATETIME',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->PYD_sah_datetime;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'MARKAH PPP',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return (is_null($model->markahSeluruh)) ? '0' : $model->markahSeluruh->markah_PPP;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'MARKAH PPK',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return (is_null($model->markahSeluruh)) ? '0' : $model->markahSeluruh->markah_PPK;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'MARKAH PURATA',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return (is_null($model->markahSeluruh)) ? '0' : $model->markahSeluruh->markah_PP;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'BULAN PGT',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->bulanPgt) ? '' : $model->bulanPgt->SalMoveMth;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'CATATAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->catatan;
                    },
                    'format' => 'html',
                ],
            ],

        ]);

        $exporter->save('web/files/reports/laporan_pentadbiran_' . date("Y_m_d") . '_' . $icno . '.xlsx');

        $doc = new \app\models\system_core\TblDocuments();
        $uapi = new \app\components\UAPI;
        $file = $uapi->UploadFile('laporan_pentadbiran_' . date("Y_m_d") . '_' . $icno . '.xlsx', 'web/files/reports/laporan_pentadbiran_' . date("Y_m_d") . '_' . $icno . '.xlsx', '04', 'hrv4_reports/', $icno);

        if ($file->status == true) {
            $doc->filehash = $file->file_name_hashcode;
            $doc->file_name = 'laporan_pentadbiran_' . date("Y_m_d") . '_' . $icno . '.xlsx';
            $doc->module = 'lppums';
            $doc->created_by = $icno;
            $doc->created_dt = new \yii\db\Expression('NOW()');
            $doc->save(false);

            unlink('web/files/reports/laporan_pentadbiran_' . date("Y_m_d") . '_' . $icno . '.xlsx');
        }
        return ExitCode::OK;
    }

    public function actionGenerateLaporanApc($query, $tahun = null, $icno)
    {

        // $connection = Yii::$app->getDb();
        // $command = $connection->createCommand("SELECT `hrm.`elnpt_tbl_main`.* FROM `hrm.`elnpt_tbl_main` INNER JOIN `hronline`.`tblprcobiodata` `g` ON `hrm.`elnpt_tbl_main`.`PYD` = `g`.`ICNO` LEFT JOIN `hrm.`elnpt_tbl_mrkh_keseluruhan` `m` ON `hrm.`elnpt_tbl_main`.`lpp_id` = `m`.`lpp_id` WHERE `m`.`markah` >= 85 ORDER BY `g`.`CONm`");

        // $query1 = $command->query();

        $exporter = new Spreadsheet([
            // 'query' => $query1,
            // 'batchSize' => 200,
            'dataProvider' => new ActiveDataProvider([
                'query' => TblMain::findBySql($query),
                'pagination' => [
                    'pageSize' => 200, // export batch size
                ],
            ]),
            'columns' => [
                [
                    'label' => 'PYD',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->pyd->CONm;
                    },
                ],
                [
                    'label' => 'ICNO',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->PYD;
                    },
                ],
                [
                    'label' => 'UMSPER',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->pyd->COOldID;
                    },
                ],
                [
                    'label' => 'JSPIU',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->department->shortname;
                    },
                ],
                [
                    'label' => 'GRED',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->gredJawatan->gred;
                    },
                ],
                [
                    'label' => 'JAWATAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->gredJawatan->nama;
                    },
                ],
                [
                    'label' => 'MARKAH LNPT',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->markahSeluruh) ? '' : $model->markahSeluruh->markah_PP;
                    },
                ],
                [
                    'label' => 'TARIKH LANTIKAN KE JAWATAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        // return is_null($model->sandangan2) ? '' : $model->sandangan2->start_date;
                        return $model->pyd->startDateSandangan;
                    },
                ],
                [
                    'label' => 'TARIKH NAIK PANGKAT',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->sandangan) ? '' : $model->sandangan->latest_start_date;
                    },
                ],
                [
                    'label' => 'APC',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->apc) ? '' : date('Y', strtotime($model->apc->last_date_awd));
                    },
                ],
                [
                    'label' => 'APT',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->apt) ? '' : date('Y', strtotime($model->apt->last_date_awd));
                    },
                ],
                [
                    'label' => 'CATATAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        if (is_null($model->cdg)) {
                            return '';
                        } else {
                            $arr = [];
                            if ($model->cdg->cadang == 2)
                                array_push($arr, 'Cadangan APC ' . $model->tahun . '');
                            if ($model->cdg->cadang == 3)
                                array_push($arr, 'Cadangan Panel ' . $model->tahun . '');

                            return join(' ', $arr);
                        }
                    },
                ],
            ],

        ]);

        $exporter->save('web/files/reports/laporan_pentadbiran_apc_' . date("Y_m_d") . '_' . $icno . '.xlsx');

        $doc = new \app\models\system_core\TblDocuments();
        $uapi = new \app\components\UAPI;
        $file = $uapi->UploadFile('laporan_pentadbiran_apc_' . date("Y_m_d") . '_' . $icno . '.xlsx', 'web/files/reports/laporan_pentadbiran_apc_' . date("Y_m_d") . '_' . $icno . '.xlsx', '04', 'hrv4_reports/', $icno);

        if ($file->status == true) {
            $doc->filehash = $file->file_name_hashcode;
            $doc->file_name = 'laporan_pentadbiran_apc_' . date("Y_m_d") . '_' . $icno . '.xlsx';
            $doc->module = 'lppums';
            $doc->created_by = $icno;
            $doc->created_dt = new \yii\db\Expression('NOW()');
            $doc->save(false);

            unlink('web/files/reports/laporan_pentadbiran_apc_' . date("Y_m_d") . '_' . $icno . '.xlsx');
        }
        return ExitCode::OK;
    }

    public function actionBulkResetBorangPenilai($tahun, $dept)
    {
        $lpps = TblMain::findAll(['tahun' => $tahun, 'jspiu' => $dept]);

        $cnt = 0;
        $flag = false;
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            foreach ($lpps as $lpp) {
                $skt = \app\models\lppums\TblSktTandatangan::findOne(['lpp_id' => $lpp->lpp_id]);
                $skt_ulas = \app\models\lppums\TblSktUlasan::findOne(['lpp_id' => $lpp->lpp_id]);
                $ulas = \app\models\lppums\TblUlasan::findOne(['lpp_id' => $lpp->lpp_id]);

                $lpp->PPP_sah = 0;
                $lpp->PPP_sah_datetime = null;

                if ($skt) {
                    $skt->skt_tt_ppp = null;
                    $skt->skt_tt_ppp_datetime = null;
                    $skt->save(false);
                }

                if ($skt_ulas) {
                    $skt_ulas->su_tt_ppp_datetime = null;
                    $skt_ulas->skt_ulasan_tt_ppp = null;
                    $skt_ulas->save(false);
                }

                if ($ulas) {
                    $ulas->ulasan_PPP_tt = null;
                    $ulas->ulasan_PPP_tt_datetime = null;
                    $ulas->save(false);
                }

                $lpp->PPK_sah = 0;
                $lpp->PPK_sah_datetime = null;

                if ($ulas) {
                    $ulas->ulasan_PPK_tt = null;
                    $ulas->ulasan_PPK_tt_datetime = null;
                    $ulas->save(false);
                }

                $lpp->save(false);
                $flag = true;
                $cnt++;

                if (!$flag) {
                    $transaction->rollBack();
                    break;
                }
            }
            if ($flag) {
                $transaction->commit();
                echo 'Process Done: ' . $cnt . ' record(s) reset successfully';
                return ExitCode::OK;
            }
        } catch (Exception $e) {
            $transaction->rollBack();
        }
    }

    public function actionResetPenilaianPpp($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        $skt = \app\models\lppums\TblSktTandatangan::findOne(['lpp_id' => $lpp->lpp_id]);
        $skt_ulas = \app\models\lppums\TblSktUlasan::findOne(['lpp_id' => $lpp->lpp_id]);
        $ulas = \app\models\lppums\TblUlasan::findOne(['lpp_id' => $lpp->lpp_id]);

        if ($skt) {
            $skt->skt_tt_ppp = null;
            $skt->skt_tt_ppp_datetime = null;
            $skt->save(false);
        }

        if ($skt_ulas) {
            $skt_ulas->su_tt_ppp_datetime = null;
            $skt_ulas->skt_ulasan_tt_ppp = null;
            $skt_ulas->save(false);
        }

        if ($ulas) {
            $ulas->ulasan_PPP_tt = null;
            $ulas->ulasan_PPP_tt_datetime = null;
            $ulas->save(false);
        }

        $lpp->PPP_sah = 0;
        $lpp->PPP_sah_datetime = null;
        $lpp->save(false);
    }

    public function actionResetPenilaianPpk($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        $ulas = \app\models\lppums\TblUlasan::findOne(['lpp_id' => $lpp->lpp_id]);

        if ($ulas) {
            $ulas->ulasan_PPK_tt = null;
            $ulas->ulasan_PPK_tt_datetime = null;
            $ulas->save(false);
        }

        $lpp->PPK_sah = 0;
        $lpp->PPK_sah_datetime = null;
        $lpp->save(false);
    }

    public function actionBulkResetBorangPenilai2()
    {
        $pyds = [
            761228125421,
            700829125153,
            650808125995,
            740617125983,
            701005125737,
            650925125679,
            860818495522,
            850801125569,
            650207125471,
            881116125909,
            640616125537,
            891018126173,
            780131125197,
            820214125639,
            761212126059,
            750116125175,
            680812125741,
            780806125495,
            890509125891,
            881023125045,
            680519125777,
            830207125453,
            661019125347,
            881222125961,
            760225086645,
            950603125339,
            900511125977,
            911225126649,
            881112126007,
            921013125221,
            840327125465,
            861111496163,
            931122126687,
            880802125787,
            911210125061,
            900428125351,
            910412125065,
            910121125225,
            750111125897,
            880705125013,
            901105126135,
            910424125740,
            791005125667,
            840508135849,
            880319125429,
            840814125067,
            870629495952,
            890718495012,
            821226125067,
            890510125143,
            911102125611,
            871010496251,
            921225126541,
            730528125309,
            821014125655,
            870526496143,
            881103125387,
            920722125369,
            890329125819,
            880301495990,
            910519125372,
            770329045433,
            900509125142,
            961122125163,
            890220125890,
            931120126763,
            901024125704,
            910724125814,
            880210125660
        ];

        $lpps = TblMain::findAll(['PYD' => $pyds, 'tahun' => 2021]);

        $cnt = 0;
        $flag = false;
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            foreach ($lpps as $lpp) {
                $skt = \app\models\lppums\TblSktTandatangan::findOne(['lpp_id' => $lpp->lpp_id]);
                $skt_ulas = \app\models\lppums\TblSktUlasan::findOne(['lpp_id' => $lpp->lpp_id]);
                $ulas = \app\models\lppums\TblUlasan::findOne(['lpp_id' => $lpp->lpp_id]);

                $lpp->PPP_sah = 0;
                $lpp->PPP_sah_datetime = null;

                if ($skt) {
                    $skt->skt_tt_ppp = null;
                    $skt->skt_tt_ppp_datetime = null;
                    $skt->save(false);
                }

                if ($skt_ulas) {
                    $skt_ulas->su_tt_ppp_datetime = null;
                    $skt_ulas->skt_ulasan_tt_ppp = null;
                    $skt_ulas->save(false);
                }

                if ($ulas) {
                    $ulas->ulasan_PPP_tt = null;
                    $ulas->ulasan_PPP_tt_datetime = null;
                    $ulas->save(false);
                }

                $lpp->save(false);
                $flag = true;
                $cnt++;

                if (!$flag) {
                    $transaction->rollBack();
                    break;
                }
            }
            if ($flag) {
                $transaction->commit();
                echo 'Process Done: ' . $cnt . ' record(s) reset successfully';
                return ExitCode::OK;
            }
        } catch (Exception $e) {
            $transaction->rollBack();
        }
    }
}
