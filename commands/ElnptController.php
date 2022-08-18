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
use yii\db\Expression;
use yii2tech\spreadsheet\Spreadsheet;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

use app\models\elnpt\Tblprcobiodata;
use app\models\Notification;
use yii\base\Exception;

use app\models\elnpt\TblMain;
use app\models\elnpt\TblMarkahKeseluruhan;
use app\models\elnpt\TblMrkhBhg;
use app\models\elnpt\TblLppTahun;
use app\models\elnpt\TblKumpGred;
use app\models\elnpt\TblKumpDept;
use app\models\elnpt\TblKumpRubrik;
use app\models\elnpt\TblMrkhAspek;
use app\models\elnpt\TblBlendedLearning;
use app\models\elnpt\TblBlendedLearningFarm;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ElnptController extends Controller
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

        //        $pydList = Tblprcobiodata::find()
        //                //->select(['`hronline`.`tblprcobiodata`.ICNO', 'd.fullname'])
        //                ->leftJoin(['a' => '`hrm`.`elnpt_tbl_main`'], '`hronline`.`tblprcobiodata`.ICNO = `a`.PYD and `a`.tahun = '.date('y').'')
        //                ->leftJoin(['b' => '`hronline`.`gredjawatan`'], '`b`.id = `hronline`.`tblprcobiodata`.gredJawatan')
        //                ->leftJoin(['c' => '`hronline`.`jawatankategori`'], '`b`.job_category = c.id')
        //                ->leftJoin(['d' => '`hronline`.`department`'], '`d`.id = `hronline`.`tblprcobiodata`.DeptId')
        //                ->where(['in', 'Status', [1, 2, 3, 4, 5]])
        //                ->andWhere(['in', 'statLantikan', [1, 2, 3, 6, 7, 51]])
        //                ->andWhere(['IS', '`a`.PYD', new \yii\db\Expression('null')])
        //                ->andWhere(['or', ['in', 'b.id', [2, 3, 4, 5]], ['`c`.id' => 1]]);

        $pydList = Tblprcobiodata::find()
            ->leftJoin(['a' => '`hrm`.`elnpt_tbl_main`'], '`hronline`.`tblprcobiodata`.ICNO = `a`.PYD and `a`.tahun = ' . $tahun . ' and `a`.is_deleted = 0')
            ->rightJoin(['b' => '`hrm`.`elnpt_v2_tbl_kump_dept`'], '`hronline`.`tblprcobiodata`.`DeptId` = b.`dept_id`')
            ->rightJoin(['e' => '`hronline`.`gredjawatan`'], '`hronline`.`tblprcobiodata`.`gredJawatan` = e.`id`')
            ->rightJoin(['c' => '`hrm`.`elnpt_v2_ref_gred`'], 'e.`gred` = c.`kump_gred`')
            ->leftJoin(['d' => '`hrm`.`elnpt_tbl_kump_rubrik`'], 'd.`kump_dept_id` = b.`id` and d.`kump_gred_id` = c.`id`')
            ->where(['`hronline`.`tblprcobiodata`.Status' => [1, 2, 3, 4, 5]])
            ->andWhere(['a.`PYD`' => null]);
        //        ->andWhere(['or', ['a.`PYD`' => null, 'a.`is_deleted`' => 0]]);

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
                    $lpp->jfpiu = $pyd->DeptId;
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

        echo $pydList;
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
        //                ->leftJoin(['a' => '`lppums`.`lpp`'], '`hronline`.`tblprcobiodata`.ICNO = `a`.PYD and `a`.tahun = '.date('y').'')
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
            ->leftJoin(['a' => '`lppums`.`lpp`'], '`hronline`.`tblprcobiodata`.ICNO = `a`.PYD and `a`.tahun = ' . date('y') . '')
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
            ->leftJoin(['a' => '`lppums`.`lpp`'], '`hronline`.`tblprcobiodata`.ICNO = `a`.PYD and `a`.tahun = ' . date('y') . '')
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

    public function actionGenerateMarkah($tahun)
    {
        $tahun = TblLppTahun::find()
            ->where(['lpp_tahun' => $tahun])
            ->one();

        $mrkh_bhg = TblMrkhBhg::find()
            ->select(new Expression('elnpt_tbl_mrkh_bhg.lpp_id, SUM(elnpt_tbl_mrkh_bhg.markah) as markah'))
            ->leftJoin(['a' => 'hrm.elnpt_tbl_main'], 'a.lpp_id = elnpt_tbl_mrkh_bhg.lpp_id')
            ->where(['a.tahun' => $tahun])
            ->groupBy('elnpt_tbl_mrkh_bhg.lpp_id')
            ->asArray()
            ->all();

        if (($tahun->lpp_aktif == 'Y') and ((date('Y-m-d H:i:s') <= $tahun->penilaian_PEER_tamat)
                or (date('Y-m-d H:i:s') <= $tahun->penilaian_PPK_tamat))
        ) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $flag = false;
                foreach ($mrkh_bhg as $mb) {
                    //                $mrkh = new TblMarkahKeseluruhan();

                    if (($mrkh = TblMarkahKeseluruhan::find()->where(['lpp_id' => $mb['lpp_id']])->one()) !== null) {
                        $mrkh = TblMarkahKeseluruhan::find()->where(['lpp_id' => $mb['lpp_id']])->one();
                    } else {
                        $mrkh = new TblMarkahKeseluruhan();
                    }

                    $lpp = TblMain::findOne(['lpp_id' => $mb['lpp_id']]);

                    $gred = TblKumpGred::find()->where(['gred_id' => $lpp->gred_jawatan_id])->one();

                    $dept = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->one();

                    //                    $dept1 = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->max('ref_kump_dept_id');

                    $rubric = TblKumpRubrik::find()->where([
                        'kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id),
                        'kump_gred_id' => $gred->ref_kump_gred_id
                    ])->one();

                    $mrkh1 = TblMrkhAspek::find()
                        ->select('bhg_no, (sum(markah_ppp) * (pemberat/100)) as ppp, '
                            . '(sum(markah_ppk) * (pemberat/100)) as ppk, '
                            . '(sum(markah_peer) * (pemberat/100)) as peer')
                        ->rightJoin('`hrm`.`elnpt_tbl_pemberat_bhg`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = bhg_no AND kump_dept_id = ' . (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id) . ' AND kump_gred_id = ' . $gred->ref_kump_gred_id)
                        //                ->where(['lpp_id' => $lppid])
                        ->rightJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = `hrm`.`elnpt_tbl_bhg_kump`.bhg_id')
                        ->where(['lpp_id' => $mb['lpp_id']])
                        ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
                        //                ->andWhere(['!=', 'bhg_no', 9])
                        ->groupBy('bhg_no')
                        ->orderBy('bhg_no')
                        ->indexBy('bhg_no')
                        ->asArray()
                        ->all();

                    $mrkh->lpp_id = $mb['lpp_id'];
                    $mrkh->markah_ppp = array_sum(ArrayHelper::getColumn($mrkh1, 'ppp'));
                    $mrkh->markah_ppk = array_sum(ArrayHelper::getColumn($mrkh1, 'ppk'));
                    $mrkh->markah_peer = array_sum(ArrayHelper::getColumn($mrkh1, 'peer'));
                    $mrkh->markah = $mb['markah'];
                    $mrkh->tarikh_kemaskini = new \yii\db\Expression('NOW()');

                    if (!($flag = $mrkh->save(false))) {
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
                echo 'Process Fail';
                return ExitCode::OK;
            }
        } else {
            echo 'Action Denied';
            return ExitCode::OK;
        }

        echo 'Process Exit';
        return ExitCode::OK;
    }

    public function actionFixMarkahBhg($tahun)
    {
        $subQuery = TblMrkhBhg::find()
            ->alias('a')
            ->select('a.`lpp_id`, a.`bhg_id`, COUNT(*)')
            ->leftJoin(['b' => 'hrm.`elnpt_tbl_main`'], 'a.`lpp_id` = b.`lpp_id`')
            ->where(['b.tahun' => $tahun])
            ->groupBy('a.`lpp_id`, a.`bhg_id`')
            ->having('COUNT(*) > 1');

        $results = TblMrkhBhg::find()
            ->alias('a')
            ->rightJoin(['b' => $subQuery], 'a.`lpp_id` = b.`lpp_id` AND a.`bhg_id` = b.`bhg_id`')
            ->orderBy(' a.`lpp_id` ASC');

        $cnt = $results->count();

        if ($cnt == 0) {
            echo 'No duplicates found.';
        } else {
            // echo $results->createCommand()->sql;
            foreach ($results->all() as $model) {
                $model->delete();
            }
        }

        echo 'Process Exit';
        return ExitCode::OK;
    }

    public function actionGenerateLaporan($jfpiu = null, $tahun = null, $range = null, $purata = null, $icno)
    {
        if ($range == null or empty($range)) {
            $query = TblMain::find()
                ->andFilterWhere(['jfpiu' => $jfpiu])
                ->andFilterWhere(['tahun' => $tahun]);
        } else {
            $query = TblMain::find()
                ->leftJoin(['a' => 'hrm.elnpt_tbl_mrkh_keseluruhan'], 'a.lpp_id = hrm.elnpt_tbl_main.lpp_id')
                ->andFilterWhere(['jfpiu' => $jfpiu])
                ->andFilterWhere(['tahun' => $tahun])
                ->andFilterWhere([$range, 'a.markah', $purata]);
        }

        echo $tahun;

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
                        return is_null($model->guru) ? '' : $model->guru->CONm;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'UMSPER',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->guru) ? '' : $model->guru->COOldID;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'GRED',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->guru) ? '' : $model->guru->jawatan->gred;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'JAWATAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->guru) ? '' : $model->guru->jawatan->nama;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'JFPIU',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->guru) ? '' : $model->guru->department->fullname;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'KUMPULAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->guru) ? '' : $model->guru->jawatan->skimPerkhidmatan->name;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'STATUS',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->guru) ? '' : $model->guru->serviceStatus->ServStatusNm;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'LANTIKAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->guru) ? '' : $model->guru->statusLantikan->ApmtStatusNm;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'TARIKH LANTIKAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->guru) ? '' : $model->guru->startDateLantik;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'TARIKH SANDANGAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->guru) ? '' : $model->guru->startDateSandangan;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'TARIKH STATUS',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->guru) ? '' : $model->guru->startDateStatus;
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
                    'label' => 'NAMA PEER',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->peer) ? null : $model->peer->CONm;
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
                        return (is_null($model->markahAll)) ? '0' : $model->markahAll->markah_ppp;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'MARKAH PPK',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return (is_null($model->markahAll)) ? '0' : $model->markahAll->markah_ppk;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'MARKAH PEER',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return (is_null($model->markahAll)) ? '0' : $model->markahAll->markah_peer;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'MARKAH PURATA',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return (is_null($model->markahAll)) ? '0' : $model->markahAll->markah;
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
                [
                    'label' => 'PPP SAH',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->PPP_sah;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'PPK SAH',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->PPK_sah;
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'PEER SAH',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->PEER_sah;
                    },
                    'format' => 'html',
                ],
            ],

        ]);

        $exporter->save('web/files/reports/laporan_akademik_' . date("Y_m_d") . '_' . $icno . '.xlsx');

        $doc = new \app\models\system_core\TblDocuments();
        $uapi = new \app\components\UAPI;
        $file = $uapi->UploadFile('laporan_akademik_' . date("Y_m_d") . '_' . $icno . '.xlsx', 'web/files/reports/laporan_akademik_' . date("Y_m_d") . '_' . $icno . '.xlsx', '04', 'hrv4_reports/', $icno);

        if ($file->status == true) {
            $doc->filehash = $file->file_name_hashcode;
            $doc->file_name = 'laporan_akademik_' . date("Y_m_d") . '_' . $icno . '.xlsx';
            $doc->module = 'elnpt';
            $doc->created_by = $icno;
            $doc->created_dt = new \yii\db\Expression('NOW()');
            $doc->save(false);

            unlink('web/files/reports/laporan_akademik_' . date("Y_m_d") . '_' . $icno . '.xlsx');
        }

        return ExitCode::OK;
    }

    public function actionFarmBlendedLearning()
    {

        $blended = TblBlendedLearning::find()
            ->select('username_ic_pasportNo, fullname, status, lastname')
            //                ->where(['or', ['username_ic_pasportNo' => $icno], ['LIKE', 'lastname', $lpp->guru->CONm]])
            ->asArray()
            ->all();

        if (!empty($blended)) {
            $transaction = \Yii::$app->db->beginTransaction();
            TblBlendedLearningFarm::deleteAll();
            try {
                //if ($flag = $modelCustomer->save(false)) {
                foreach ($blended as $b) {

                    $bl = new TblBlendedLearningFarm();
                    $bl->username_ic_pasportNo = $b['username_ic_pasportNo'];
                    $bl->fullname = $b['fullname'];
                    $bl->status = $b['status'];
                    $bl->lastname = $b['lastname'];
                    $bl->save(false);
                    if (!($flag = $bl->save(false))) {
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
                echo 'Process Halt';
                return ExitCode::OK;
            }
        } else {
            echo 'No data';
            return ExitCode::OK;
        }

        return ExitCode::OK;
    }

    public function actionGenerateLaporanApc($query, $tahun = null, $icno)
    {

        // $connection = Yii::$app->getDb();
        // $command = $connection->createCommand("SELECT `hrm`.`elnpt_tbl_main`.* FROM `hrm`.`elnpt_tbl_main` INNER JOIN `hronline`.`tblprcobiodata` `g` ON `hrm`.`elnpt_tbl_main`.`PYD` = `g`.`ICNO` LEFT JOIN `hrm`.`elnpt_tbl_mrkh_keseluruhan` `m` ON `hrm`.`elnpt_tbl_main`.`lpp_id` = `m`.`lpp_id` WHERE `m`.`markah` >= 85 ORDER BY `g`.`CONm`");

        // $query1 = $command->query();

        $exporter = new Spreadsheet([
            // 'query' => $query1,
            // 'batchSize' => 200,
            'dataProvider' => new ActiveDataProvider([
                'query' => TblMain::findBySql($query),
            ]),
            'columns' => [
                [
                    'label' => 'NAMA STAFF',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->guru->CONm;
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
                    'label' => 'GRED',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->gredGuru->gred;
                    },
                ],
                [
                    'label' => 'JAWATAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->gredGuru->nama;
                    },
                ],
                [
                    'label' => 'JFPIU',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->deptGuru->shortname;
                    },
                ],
                [
                    'label' => 'MARKAH LNPT',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->markahAll) ? '' : $model->markahAll->markah;
                    },
                ],
                [
                    'label' => 'TARIKH LANTIKAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return is_null($model->sandangan2) ? '' : $model->sandangan2->start_date;
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
                            if ($model->cdg->cadang == 1)
                                array_push($arr, 'Cadangan APC ' . $model->tahun);
                            if ($model->cdg->panel == 1)
                                array_push($arr, 'Cadangan Panel ' . $model->tahun);

                            return join(' ', $arr);
                        }
                    },
                ],
            ],

        ]);

        $exporter->save('web/files/reports/laporan_akademik_apc_' . date("Y_m_d") . '_' . $icno . '.xlsx');

        $doc = new \app\models\system_core\TblDocuments();
        $uapi = new \app\components\UAPI;
        $file = $uapi->UploadFile('laporan_akademik_apc_' . date("Y_m_d") . '_' . $icno . '.xlsx', 'web/files/reports/laporan_akademik_apc_' . date("Y_m_d") . '_' . $icno . '.xlsx', '04', 'hrv4_reports/', $icno);

        if ($file->status == true) {
            $doc->filehash = $file->file_name_hashcode;
            $doc->file_name = 'laporan_akademik_apc_' . date("Y_m_d") . '_' . $icno . '.xlsx';
            $doc->module = 'elnpt';
            $doc->created_by = $icno;
            $doc->created_dt = new \yii\db\Expression('NOW()');
            $doc->save(false);

            unlink('web/files/reports/laporan_akademik_apc_' . date("Y_m_d") . '_' . $icno . '.xlsx');
        }

        return ExitCode::OK;
    }
}
