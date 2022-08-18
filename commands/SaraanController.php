<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii2tech\spreadsheet\Spreadsheet;

use yii\console\Controller;
use yii\console\ExitCode;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\base\Exception;

use app\models\Notification;

use app\models\hronline\Tblprcobiodata;
use app\models\gaji\RefJadualGaji;

use app\models\gaji\Tblrscolpg;
use app\models\gaji\Tblrscoelaun;
use app\models\gaji\TblrscolpgLama;
use app\models\gaji\Tblrscolpg161;
use app\models\gaji\TempPrevLpg;

use app\models\gaji\TblStaffRocBatchSmbu;
use app\models\gaji\TblStaffRocSmbu;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SaraanController extends Controller
{
    public function actionLpg($month, $year, $icnooo)
    {
        Tblrscolpg::deleteAll();
        Tblrscoelaun::deleteAll();
        TempPrevLpg::deleteAll();

        $monthName = date("M", mktime(0, 0, 0, $month, 1));

        $icno = Tblprcobiodata::find()
            ->select('`hronline`.`tblprcobiodata`.*')
            ->innerJoin('hronline.`v_latest_bln_gaji` a', 'a.`ICNO` = `hronline`.`tblprcobiodata`.`ICNO`')
            ->where(['!=', '`hronline`.`tblprcobiodata`.`Status`', 6])
            ->andWhere(['a.SalMoveMth' => $month])
            ->andWhere(['NOT LIKE', '`hronline`.`tblprcobiodata`.`COOldID`', substr($year, -2) . '%', false]);

        $icno1 = Tblprcobiodata::find()
            ->select('`hronline`.`tblprcobiodata`.ICNO')
            ->innerJoin('v_latest_bln_gaji a', 'a.`ICNO` = `hronline`.`tblprcobiodata`.`ICNO`')
            ->where(['!=', '`hronline`.`tblprcobiodata`.`Status`', 6])
            ->andWhere(['a.SalMoveMth' => $month])
            ->andWhere(['NOT LIKE', '`hronline`.`tblprcobiodata`.`COOldID`', substr($year, -2) . '%', false])
            ->asArray()
            ->all();

        $max_date = TblrscolpgLama::find()
            ->select('t_lpg_ICNO, MAX(t_lpg_date_start) as maax')
            ->where(['>=', 't_lpg_date_start', '2012-01-01'])
            ->andWhere(['or', ['t_lpg_ver_status' => null], ['!=', 't_lpg_ver_status', 'disprove']])
            ->andWhere(['>=', 't_lpg_amount', 0])
            ->groupBy('t_lpg_ICNO');

        $max_date1 = TblStaffRocBatchSmbu::find()
            ->select('*, ROW_NUMBER() over(partition by srb_staff_id order by srb_verify_date DESC) as rn')
            ->where(['>=', 'srb_verify_date', '2012-01-01'])
            ->andWhere(['srb_status' => 'APPROVE'])
            ->andWhere(['srb_change_reason' => '11']);

        $max_date2 = (new \yii\db\Query())
            ->select('*')
            ->from(['a' => $max_date1])
            ->where(['a.rn' => 1]);

        $temp = ArrayHelper::getColumn($icno1, 'ICNO');

        foreach ($temp as $tmp) {
            if ($tmp == 891103125554) {
                // echo '891103125554';
            }

            $this->GenerateLpg($tmp, $month);
            //            break;
            //            echo 'done';
        }

        $query1 = (new \yii\db\Query())
            ->select(new Expression("c.`CONm` AS 'nama', c.`icno`, f.`gred`, f.`nama` AS jawatan, c.`COOldID`,
                    'GAJI POKOK' AS 'Nama_Ringkas', 'B1000' AS 'Kod_Saga', a.`t_lpg_amount` AS 'amtt', g.kategori, f.`gred_no`"))
            ->from(['a' => '`hrm`.`gaji_tblrscolpg`'])
            ->innerJoin(['c' => $icno], 'a.`t_lpg_ICNO` = c.`icno`')
            ->leftJoin("hronline.`gredjawatan` f", 'c.`gredJawatan` = f.`id`')
            ->leftJoin("hronline.`jawatankategori` g", 'g.`id` = f.`job_category`');

        // echo 'Done';
        // echo ' ' . $query1->createCommand()->getRawSql() . ' ';

        $query2 = (new \yii\db\Query())
            ->select(new Expression("c.`CONm` AS 'nama', c.`icno`, f.`gred`, f.`nama` AS jawatan, c.`COOldID`,
                    g.`nama_ringkas` AS 'Nama_Ringkas', g.`kod_saga` AS 'Kod_Saga', e.`el_amount` AS 'amtt', h.kategori, f.`gred_no`"))
            ->from(['a' => '`hrm`.`gaji_tblrscolpg`'])
            ->innerJoin(['c' => $icno], 'a.`t_lpg_ICNO` = c.`icno`')
            ->leftJoin("hronline.`gredjawatan` f", 'c.`gredJawatan` = f.`id`')
            ->leftJoin("hrm.gaji_tblrscoelaun e", 'e.`el_lpg_id` = a.`t_lpg_id`')
            ->leftJoin("hrm.gaji_elaunname g", 'g.`id` = e.`el_elaun_cd`')
            ->leftJoin("hronline.`jawatankategori` h", 'h.`id` = f.`job_category`');

        // echo 'Done';
        // echo ' ' . $query2->createCommand()->getRawSql() . ' ';

        $umsper = ArrayHelper::getColumn($icno->asArray()->all(), 'COOldID');

        $query3 = TblStaffRocSmbu::find()
            ->select(new Expression("SR_STAFF_ID as COOldID, SR_ROC_TYPE as 'Kod_Saga', SR_NEW_VALUE as 'amt'"))
            ->innerJoin(['b' => $max_date2], 'b.srb_batch_code = SR_ENTRY_BATCH')
            //->indexBy('SR_STAFF_ID')
            ->where(['in', 'SR_STAFF_ID', array_unique($umsper)])
            ->orderBy(['SR_ENTRY_BATCH' => SORT_ASC]);

        // echo ' ' . $query3->createCommand()->getRawSql() . ' ';

        echo 'Done';

        // print_r($umsper);

        Yii::$app->db->createCommand()->truncateTable('hrm.gaji_temp_prev_lpg')->execute();

        foreach ($query3->asArray()->all() as $q) {
            $mod = new TempPrevLpg();
            $mod->staff_id = $q['COOldID'];
            $mod->kod_saga = $q['Kod_Saga'];
            $mod->amount = $q['amt'];
            $mod->save();
        }

        $gen = (new \yii\db\Query())
            ->select(new Expression("a.nama, a.icno, a.gred, a.jawatan, a.kategori, a.COOldID, a.Nama_Ringkas, a.Kod_Saga, a.amtt,"
                . "'01-" . strtoupper($monthName) . "-" . substr($year, -2) . "', IF(g.amount = a.amtt, 'NOCHANGE', 'CHANGE_AMOUNT'), 'PRORATE',"
                . "'Diberi Pergerakan Gaji BIASA bagi tahun " . $year . " sesuai dengan keputusan Mesyuarat Panel Pembangunan Sumber Manusia (Penyelarasan Penilaian Prestasi dan Pergerakan Gaji) Bil. 1/" . $year . " Universiti Malaysia Sabah.', g.amount, a.gred_no"))
            ->from(['a' => $query1->union($query2)])
            ->innerJoin(['g' => '`hrm`.gaji_temp_prev_lpg'], '`g`.staff_id = `a`.COOldID and `g`.kod_saga = `a`.Kod_Saga')
            //->indexBy('COOldID')
            //->orderBy(['nama' => SORT_ASC, 'Kod Saga' => SORT_ASC])
            ->orderBy(['COOldID' => SORT_ASC])
            ->all();

        // echo ' ' . $query1->union($query2)->createCommand()->getRawSql() . ' ';

        $file = \Yii::createObject([
            'class' => 'codemix\excelexport\ExcelFile',
            'sheets' => [

                'KGT' => [   // Name of the excel sheet
                    'data' => $gen,

                    // Set to `false` to suppress the title row
                    'titles' => [
                        'nama',
                        'icno',
                        'gred',
                        'jawatan',
                        'kategori',
                        'Staff ID',
                        'Allowance/Deduction',
                        'Allowance/Deduction Code',
                        'Amount (RM)',
                        'Date to',
                        'CHANGE AMOUNT',
                        'Calculation Type',
                        'Remarks',
                        'Prev Amount (RM)',
                        'gred_no'
                    ],

                    'formats' => [
                        // Either column name or 0-based column index can be used
                        //'C' => '#,##0.00',
                        1 => '0',
                        'N' => '#,##0.00',
                        'I' => '#,##0.00',
                        //'I' => 
                    ],

                    'callbacks' => [
                        // $cell is a PHPExcel_Cell object
                        'B' => function ($cell, $row, $column) {
                            $cell->getStyle()->applyFromArray([
                                'alignment' => [
                                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                                ],
                            ]);
                        },
                    ],
                ],
            ]
        ]);

        $file->getWorkbook()->getSheet(0)->getColumnDimension('A')->setAutoSize(true);
        $file->getWorkbook()->getSheet(0)->getColumnDimension('B')->setAutoSize(true);
        $file->getWorkbook()->getSheet(0)->getColumnDimension('D')->setAutoSize(true);
        $file->getWorkbook()->getSheet(0)->getColumnDimension('E')->setAutoSize(true);
        $file->getWorkbook()->getSheet(0)->getColumnDimension('F')->setAutoSize(true);
        $file->getWorkbook()->getSheet(0)->getColumnDimension('G')->setAutoSize(true);
        $file->getWorkbook()->getSheet(0)->getColumnDimension('H')->setAutoSize(true);
        $file->getWorkbook()->getSheet(0)->getColumnDimension('I')->setAutoSize(true);
        $file->getWorkbook()->getSheet(0)->getColumnDimension('J')->setAutoSize(true);
        $file->getWorkbook()->getSheet(0)->getColumnDimension('K')->setAutoSize(true);
        $file->getWorkbook()->getSheet(0)->getColumnDimension('L')->setAutoSize(true);
        $file->getWorkbook()->getSheet(0)->getColumnDimension('M')->setAutoSize(true);
        $file->getWorkbook()->getSheet(0)->getColumnDimension('N')->setAutoSize(true);

        // Save on disk
        $url = Yii::$app->basePath . '/web/files/lpg/lpg_' . $month . '_' . $year . '.xlsx';
        //    $url = '/web/files/lpg/lpg.xlsx';
        $file->saveAs($url);

        $ntf = new Notification();
        $ntf->icno = $icnooo;
        $ntf->title = 'Muat Turun LPG';
        //    $ntf->content = "Anda dilantik sebagai Penetap Penilai dalam Sistem LNPT Akademik. Setelah berbincang dengan Ketua Jabatan, mohon pihak tuan/puan membuat penetapan PPP, PPK dan PEER untuk semua kakitangan di Jabatan tuan/puan melalui ".Html::a('pautan ini', $url, []).".";
        $ntf->content = "Pergerakan gaji bagi kakitangan yang layak menerima KGT " . $month . " " . $year . " telah dijana. Sila muat turun fail tersebut melalui pautan ini " .
            Html::a("<b>LPG</b>", '/staff/web/files/lpg/lpg_' . $month . '_' . $year . '.xlsx', ['target' => '_blank']);
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save(false);

        echo 'Process Done';

        return ExitCode::OK;
    }

    public function GenerateLpg($icno, $month)
    {
        $cd = null;
        $remark = null;
        $i_amt = null;
        $i_amt_max = null;


        $bio = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $date = date("Y") . "-" . $month . "-01 00:01:00";

        // $umsPer = Umsper::findOne(['ICNO' => $icno]);

        if ($icno == 891103125554) {
            // echo ' ' . $umsPer->COOldID . ' ';
        }

        //$date = html_entity_decode($date);

        $max_date = TblStaffRocBatchSmbu::find()
            ->select(['MAX(srb_verify_date)'])
            ->where(['srb_staff_id' => $bio->COOldID])
            ->andWhere(['>=', 'srb_verify_date', '2012-01-01'])
            ->andWhere(['srb_status' => 'APPROVE'])
            ->andWhere(['srb_change_reason' => '11'])
            //->andWhere(['OR', ['t_lpg_ver_status' => NULL], ['!=', 't_lpg_ver_status', 'disprove']])
            //->andWhere(['>', 't_lpg_amount', 0])
            ->asArray()
            ->one();

        $cnt = TblStaffRocBatchSmbu::find()
            ->where(['srb_staff_id' =>  $bio->COOldID])
            ->andWhere(['>=', 'srb_verify_date', '2012-01-01'])
            //->andWhere(['OR', ['t_lpg_ver_status' => NULL], ['!=', 't_lpg_ver_status', 'disprove']])
            ->andWhere(['srb_status' => 'APPROVE'])
            ->andWhere(['srb_verify_date' => $max_date])
            ->andWhere(['srb_change_reason' => '11'])
            //->andWhere(['>', 't_lpg_amount', 0])
            ->count();

        if ($cnt == 1) {
            $old_lpg = TblStaffRocBatchSmbu::find()
                ->select(['MAX(srb_batch_code)'])
                ->where(['srb_staff_id' =>  $bio->COOldID])
                ->andWhere(['srb_status' => 'APPROVE'])
                ->andWhere(['srb_verify_date' => $max_date])
                ->andWhere(['srb_change_reason' => '11'])
                ->asArray()
                ->one();
        } else {
            $old_lpg = TblStaffRocBatchSmbu::find()
                ->select(['MAX(srb_batch_code)'])
                ->where(['srb_staff_id' =>  $bio->COOldID])
                ->andWhere(['srb_job_code' => $bio->jawatan->id])
                ->andWhere(['srb_status' => 'APPROVE'])
                ->andWhere(['srb_verify_date' => $max_date])
                ->andWhere(['srb_change_reason' => '11'])
                ->asArray()
                ->one();
        }

        if (is_null($old_lpg) == false) {

            if ($icno == 891103125554) {
                // echo ' ada ';
            }

            switch ($bio->Status) {
                case 1:
                    $remark = "Diberi Pergerakan Gaji BIASA bagi tahun " . date("Y") . " sesuai dengan keputusan Mesyuarat Panel Pembangunan Sumber Manusia (Penyelarasan Penilaian Prestasi dan Pergerakan Gaji) Bil. 1/2019 Universiti Malaysia Sabah.";
                    $cd = 11;
                    break;
                case 2:
                    $remark = "Diberi Pergerakan Gaji SEBENAR bagi tahun " . date("Y") . " sesuai dengan keputusan Mesyuarat Panel Pembangunan Sumber Manusia (Penyelarasan Penilaian Prestasi dan Pergerakan Gaji) Bil. 1/'" . date("Y") . "' Universiti Malaysia Sabah.";
                    $cd = 13;
                    break;
            }

            $peringkat = 1;

            $i_amt = TblStaffRocSmbu::find()
                ->select(['SR_NEW_VALUE'])
                ->where(['SR_ENTRY_BATCH' => $old_lpg])
                ->andWhere(['SR_ROC_TYPE' => 'B1000'])
                ->asArray()
                ->one();

            $i_amt_kgt_ex = RefJadualGaji::find()
                ->where(['LIKE', 'r_jg_gred', $bio->jawatan->gred])
                ->andWhere(['r_jg_peringkat' => $peringkat])
                ->count();

            $i_amt_kgt_per_ex = RefJadualGaji::find()
                ->where(['LIKE', 'r_jg_gred', $bio->jawatan->gred])
                //->andWhere(['>', 'r_jg_peratus', 0])
                //->count();
                ->asArray()
                ->one();

            $i_amt_kgt = 0;

            if ($i_amt_kgt_ex != 0) {
                $thth = RefJadualGaji::find()
                    ->select(['r_jg_kgt'])
                    ->where(['LIKE', 'r_jg_gred', $bio->jawatan->gred])
                    ->andWhere(['r_jg_peringkat' => $peringkat])
                    ->asArray()
                    ->one();

                $i_amt_max = RefJadualGaji::find()
                    ->select(['r_jg_maks'])
                    ->where(['LIKE', 'r_jg_gred', $bio->jawatan->gred])
                    ->andWhere(['r_jg_peringkat' => $peringkat])
                    ->asArray()
                    ->one();

                $i_amt_kgt = $thth['r_jg_kgt'];
            }

            if ($i_amt_kgt_per_ex['r_jg_peratus'] > 0) {
                $i_amt_kgt_per = RefJadualGaji::find()
                    ->select(['r_jg_peratus'])
                    ->where(['LIKE', 'r_jg_gred', $bio->jawatan->gred])
                    ->asArray()
                    ->one();

                $i_amt_max = RefJadualGaji::find()
                    ->select(['r_jg_maks'])
                    ->where(['LIKE', 'r_jg_gred', $bio->jawatan->gred])
                    ->asArray()
                    ->one();

                $i_amt_kgt = ($i_amt['SR_NEW_VALUE'] * 0.09);
            }

            $i_amt_baru = $i_amt['SR_NEW_VALUE'] + $i_amt_kgt;

            if ($i_amt_max['r_jg_maks'] == 0) {
                if ($i_amt_baru >= $i_amt_max['r_jg_maks']) {
                    $i_amt_baru = $i_amt_max['r_jg_maks'];

                    if ($i_amt === $i_amt_max['r_jg_maks']) {
                        $cd = 14;
                        //$i_tahun_lpg = \Yii::$app->formatter->asDate($date);
                        $remark = "TIADA diberi Pergerakan Gaji bagi tahun " . date("Y");
                    }
                }
            }

            //echo \yii\helpers\VarDumper::dump($i_amt_baru);

            //break;

            $model = new Tblrscolpg();

            $model->t_lpg_ICNO = $icno;
            $model->t_lpg_cd = $cd;
            $model->t_lpg_peringkat = $peringkat;
            $model->t_lpg_date_start = $date;
            $model->t_lpg_amount = $i_amt_baru;
            $model->t_lpg_remark = $remark;
            $model->t_lpg_jawatan_id = $bio->jawatan->id;
            $model->t_lpg_dept_id = $bio->department->id;
            $model->t_lpg_marital_cd = $bio->MrtlStatusCd;
            $model->t_lpg_app_by = '780810125615'; /* 780810125615 EN JUNIEZAM */ /* 820127045390 PN NURAZEAN*/
            $model->t_lpg_app_by_datetime = new \yii\db\Expression('NOW()');
            $model->t_lpg_app_status = 'approve';
            $model->t_lpg_ver_by = '780810125615'; /* 780810125615 EN JUNIEZAM */ /* 820127045390 PN NURAZEAN*/
            $model->t_lpg_ver_by_datetime = new \yii\db\Expression('NOW()');
            $model->t_lpg_ver_status = 'approve';

            $model->isNewRecord = true;
            $model->save(false);

            $insert_id = $model->t_lpg_id;

            $elaun = TblStaffRocSmbu::find()
                ->select(['[dbo].[staff_roc].*', '[dbo].[mig_Income_code_mapping].hronline_id'])
                ->joinWith('elaunn')
                //->leftJoin('[dbo].[mig_Income_code_mapping]', '[dbo].[mig_Income_code_mapping].[income_code] = [dbo].[staff_roc].[SR_ROC_TYPE]')
                ->where(['SR_STAFF_ID' =>  $bio->COOldID])
                //->andWhere(['OR', ['srb_batch_code' => $old_lpg], ['srb_change_reason' => '7']])
                ->andWhere(['SR_ENTRY_BATCH' => $old_lpg])
                //->groupBy(['[dbo].[staff_roc].SR_CHANGE_REASON'])
                //->orderby(['[dbo].[staff_roc_batch].srb_change_reason' => SORT_ASC, 'srb_enter_date' => SORT_ASC])
                ->asArray()
                ->all();

            //$ell = ArrayHelper::getColumn($elaun, '0','');
            $arryy = array();

            $arryy1 = array();

            foreach ($elaun as $aaa) {
                array_push($arryy, $aaa['hronline_id']);
            }

            foreach ($elaun as $aaa) {
                array_push($arryy1, $aaa['SR_NEW_VALUE']);
            }

            //echo \yii\helpers\VarDumper::dump($arryy, 10, true);

            foreach ($arryy as $key => $el) {
                if (is_null($el)) {
                    continue;
                }

                $elaun_amt = $this->JumlahElaun($insert_id, $el);

                if (is_null($elaun_amt)) {
                    $elaun_amt = $arryy1[$key];
                }

                $mod = new Tblrscoelaun();
                $mod->el_lpg_id = $insert_id;
                $mod->el_elaun_cd = $el;
                $mod->el_amount = $elaun_amt;
                $mod->el_created_by = null;
                $mod->el_bln_khidmat = 0;
                $mod->save(false);
            }
        }
    }

    public function JumlahElaun($lpg_id, $elaun_cd)
    {

        $ret_jum_el = null;

        $lpg_info = Tblrscolpg::find()
            ->select([
                't_lpg_cd', 't_lpg_ICNO', 't_lpg_dept_id', 't_lpg_jawatan_id', 't_lpg_amount', 'hronline.gredjawatan.nama as nama',
                'hronline.gredjawatan.job_group as job_group'
            ])
            ->joinWith('jawatan')
            ->where(['t_lpg_id' => $lpg_id])
            ->asArray()
            ->one();

        // echo $lpg_id . ' ';

        $bio = Tblprcobiodata::findOne(['ICNO' => $lpg_info['t_lpg_ICNO']]);

        $gred_chr = Tblrscolpg::find()
            ->select(['IF ( gred NOT LIKE "V%" AND (LENGTH(gred) <= 3 OR LENGTH(gred) >= 6), LEFT(gred,1),
                    IF ( LENGTH(gred) <= 4, LEFT(gred,2), NULL)) as chr'])
            ->joinWith('jawatan', false)
            ->where(['t_lpg_id' => $lpg_id])
            ->asArray()
            ->one();

        $gred_no = Tblrscolpg::find()
            ->select(['IF (gred LIKE \'V%\', (100 - RIGHT(gred,1)), 
                    (IF (LENGTH(gred) >= 3, IF( gred != \'DU51P\', RIGHT(gred,2), 51 ) , RIGHT(gred,1)

            ))) as gred'])
            ->joinWith('jawatan', false)
            ->where(['t_lpg_id' => $lpg_id])
            ->asArray()
            ->one();

        //echo \yii\helpers\VarDumper::dump($gred_no, 10, true);

        $elaun_dekan = Tblrscoelaun::find()
            ->where(['el_elaun_cd' => [13, 50]])
            ->andWhere(['el_lpg_id' => $lpg_id])
            ->asArray()
            ->one();

        $expression = new Expression('IF(COUNT(el_id) >= 1, 1, 0)');

        $elaun_timb_dekan = Tblrscoelaun::find()
            ->select($expression)
            ->where(['el_elaun_cd' => [14, 51]])
            ->andWhere(['el_lpg_id' => $lpg_id])
            ->asArray()
            ->one();

        // $umsPer = Umsper::findOne(['ICNO' => $lpg_info['t_lpg_ICNO']]);

        if ($elaun_cd == 1 or $elaun_cd == 3) {
            switch ($gred_no['gred']) {
                case 95:
                    $ret_jum_el = 2500;
                    break;
                case 94:
                    $ret_jum_el = 1500;
                    break;
                case 93:
                    $ret_jum_el = 1000;
                    break;
            }
        }

        if ($elaun_cd == 2 or $elaun_cd == 4) {
            switch ($gred_no['gred']) {
                case 95:
                    $ret_jum_el = 4000;
                    break;
                case 94:
                    $ret_jum_el = 3050;
                    break;
                case 93:
                    $ret_jum_el = 2500;
                    break;
            }
        }

        if ($elaun_cd == 5) {

            switch ($bio->jawatan->gred) {
                case 'DU51P':
                    $ret_jum_el = 750;
                    break;
                case 'UG43':
                    $ret_jum_el = 750;
                    break;
                case 'UG48':
                    $ret_jum_el = 750;
                    break;
                case 'UF43':
                    $ret_jum_el = 750;
                    break;
                case 'UD43':
                    $ret_jum_el = 750;
                    break;
                case 'UD47':
                    $ret_jum_el = 750;
                    break;
                case 'UD53':
                    $ret_jum_el = 750;
                    break;
                case 'U29':
                    if (($bio->jawatan->nama == 'Jururawat') or ($bio->jawatan->nama == 'Jururawat Kanan')) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.15);
                    }
                    break;
                case 'U32':
                    if (($bio->jawatan->nama == 'Jururawat') or ($bio->jawatan->nama == 'Jururawat Kanan')) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.15);
                    }
                    break;
                case 'DS45':
                    //if(($bio->jawatan->nama == 'Jururawat') or ($bio->jawatan->nama == 'Jururawat Kanan')){
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    //}
                    break;
                case 'DS48':
                    //if(($bio->jawatan->nama == 'Jururawat') or ($bio->jawatan->nama == 'Jururawat Kanan')){
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    //}
                    break;
                case 'DS51':
                    //if(($bio->jawatan->nama == 'Jururawat') or ($bio->jawatan->nama == 'Jururawat Kanan')){
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    //}
                    break;
                case 'DS52':
                    //if(($bio->jawatan->nama == 'Jururawat') or ($bio->jawatan->nama == 'Jururawat Kanan')){
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    //}
                    break;
                case 'DS53':
                    //if(($bio->jawatan->nama == 'Jururawat') or ($bio->jawatan->nama == 'Jururawat Kanan')){
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    //}
                    break;
                case 'DS54':
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    break;
                case 'J41':
                    //strpos($a, 'are') !== false
                    if (strpos($bio->jawatan->nama, 'Arkitek') !== false) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    }
                    if (strpos($bio->jawatan->nama, 'Jurutera') !== false) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    }
                    break;
                case 'J44':
                    if (strpos($bio->jawatan->nama, 'Arkitek') !== false) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    }
                    if (strpos($bio->jawatan->nama, 'Juruukur') !== false) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    }
                    break;
                case 'B19':
                    if (($bio->jawatan->nama == 'Penerbit Rancangan')) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    }
                    break;
                case 'B29':
                    if (($bio->jawatan->nama == 'Penerbit Rancangan')) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    }
                    break;
                case 'Q41':
                    if (($bio->jawatan->nama == 'Pegawai Penyelidik')) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    }
                    break;
                case 'G41':
                    if (($bio->jawatan->nama == 'Pegawai Pertanian')) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    }
                    break;
                case 'L48':
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    break;
                case 'L44':
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    break;
                case 'N44':
                    if (($bio->jawatan->nama == 'Penolong Pendaftar Kanan')) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    }
                    break;
            }
        }

        if ($elaun_cd == 6) {
            if ($gred_chr['chr'] == 'VU' or $gred_chr['chr'] == 'VK') {
                $ret_jum_el = 3100;
            }

            if ($gred_chr['chr'] == 'U' or $gred_chr['chr'] == 'UD' or $gred_chr['chr'] == 'DU' or $gred_chr['chr'] == 'DUG') {
                if ($gred_no['gred'] >= 55) {
                    $ret_jum_el = 3100;
                } else if ($gred_no['gred'] >= 53 and $gred_no['gred'] <= 54) {
                    $ret_jum_el = 2800;
                } else if ($gred_no['gred'] >= 51 and $gred_no['gred'] <= 52) {
                    $ret_jum_el = 2500;
                } else if ($gred_no['gred'] >= 47 and $gred_no['gred'] <= 48) {
                    $ret_jum_el = 2200;
                } else if ($gred_no['gred'] == 45) {
                    $ret_jum_el = 2000;
                } else if ($gred_no['gred'] >= 43 and $gred_no['gred'] <= 44) {
                    $ret_jum_el = 1900;
                } else if ($gred_no['gred'] == 41) {
                    $ret_jum_el = 1600;
                }
            }
        }

        if ($elaun_cd == 7) {
            if ($gred_chr['chr'] == 'VK' or $gred_chr['chr'] == 'DU') {
                if ($gred_no['gred'] >= 55) {
                    $ret_jum_el = 1200;
                } else if ($gred_no['gred'] >= 53 and $gred_no['gred'] <= 54) {
                    $ret_jum_el = 1000;
                } else if ($gred_no['gred'] >= 51 and $gred_no['gred'] <= 52) {
                    $ret_jum_el = 800;
                } else if ($gred_no['gred'] == 45) {
                    $ret_jum_el = 600;
                }
            }
        }

        if ($elaun_cd == 40) {
            if ($gred_chr['chr'] == 'VK' or $gred_chr['chr'] == 'DU') {
                if ($gred_no['gred'] >= 55) {
                    $ret_jum_el = 1000;
                } else if ($gred_no['gred'] >= 53 and $gred_no['gred'] <= 54) {
                    $ret_jum_el = 800;
                } else if ($gred_no['gred'] >= 51 and $gred_no['gred'] <= 52) {
                    $ret_jum_el = 600;
                } else if ($gred_no['gred'] == 45) {
                    $ret_jum_el = 400;
                }
            }
        }

        if ($elaun_cd == 8) {
            if ($lpg_info['job_group'] == 3) {
                if ($gred_no['gred'] >= 53 and $gred_no['gred'] <= 54) {
                    $ret_jum_el = 800;
                } else if ($gred_no['gred'] >= 51 and $gred_no['gred'] <= 52) {
                    $ret_jum_el = 600;
                } else if ($gred_no['gred'] == 46) {
                    $ret_jum_el = 550;
                } else if ($gred_no['gred'] == 45) {
                    $ret_jum_el = 500;
                } else if ($gred_no['gred'] == 44) {
                    $ret_jum_el = 400;
                }
            } else {
                if ($gred_no['gred'] >= 53 and $gred_no['gred'] <= 54) {
                    $ret_jum_el = 800;
                } else if ($gred_no['gred'] >= 51 and $gred_no['gred'] <= 52) {
                    $ret_jum_el = 600;
                } else if ($gred_no['gred'] >= 47 and $gred_no['gred'] <= 50) {
                    $ret_jum_el = 550;
                } else if ($gred_no['gred'] >= 43 and $gred_no['gred'] <= 44) {
                    $ret_jum_el = 400;
                }
            }
        }

        if ($elaun_cd == 9) {
            if ($lpg_info['job_group'] == 3) {
                if ($gred_no['gred'] <= 45) {
                    $ret_jum_el = 300;
                }
            } else {
                if ($gred_no['gred'] >= 41 and $gred_no['gred'] <= 42) {
                    $ret_jum_el = 300;
                } else if ($gred_no['gred'] >= 35 and $gred_no['gred'] <= 40) {
                    $ret_jum_el = 220;
                } else if ($gred_no['gred'] >= 27 and $gred_no['gred'] <= 34) {
                    $ret_jum_el = 160;
                } else if ($gred_no['gred'] >= 25 and $gred_no['gred'] <= 26) {
                    $ret_jum_el = 140;
                } else if ($gred_no['gred'] >= 17 and $gred_no['gred'] <= 24) {
                    $ret_jum_el = 115;
                } else if ($gred_no['gred'] >= 1 and $gred_no['gred'] <= 16) {
                    $ret_jum_el = 95;
                }
            }
        }

        if ($elaun_cd == 10) {
            if ($gred_no['gred'] == 95) {
                $ret_jum_el = 2000;
            } else if ($gred_no['gred'] == 94) {
                $ret_jum_el = 1600;
            } else if ($gred_no['gred'] >= 93) {
                $ret_jum_el = 1300;
            } else if ($gred_no['gred'] >= 53 and $gred_no['gred'] <= 54) {
                $ret_jum_el = 900;
            } else if ($gred_no['gred'] >= 51 and $gred_no['gred'] <= 52) {
                $ret_jum_el = 700;
            } else if ($gred_no['gred'] >= 45 and $gred_no['gred'] <= 50) {
                $ret_jum_el = 700;
            } else if ($gred_no['gred'] >= 43 and $gred_no['gred'] <= 44) {
                $ret_jum_el = 400;
            } else if ($gred_no['gred'] >= 41 and $gred_no['gred'] <= 42) {
                $ret_jum_el = 300;
            } else if ($gred_no['gred'] >= 1 and $gred_no['gred'] <= 40) {
                $ret_jum_el = 300;
            }
        }

        if ($elaun_cd == 11 and $lpg_info['t_lpg_cd'] == 29) {
            if ($bio->NatStatusCd == '1') {
                if ($lpg_info['t_lpg_amount'] >= 5565.61) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (12.5 / 100));
                } else if ($lpg_info['t_lpg_amount'] >= 3566.05 and $lpg_info['t_lpg_amount'] <= 5565.60) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (15 / 100));
                } else if ($lpg_info['t_lpg_amount'] >= 1783.84 and $lpg_info['t_lpg_amount'] <= 3566.04) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (17.5 / 100));
                } else if ($lpg_info['t_lpg_amount'] >= 1176.76 and $lpg_info['t_lpg_amount'] <= 1783.83) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (20 / 100));
                } else if ($lpg_info['t_lpg_amount'] >= 841.90 and $lpg_info['t_lpg_amount'] <= 1176.75) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (22.5 / 100));
                } else if ($lpg_info['t_lpg_amount'] <= 841.89) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (25 / 100));
                }
            }
        }

        if ($elaun_cd == 11 and $lpg_info['t_lpg_cd'] != 29) {
            if ($bio->NatStatusCd == '1' || $bio->NatStatusCd == '3') {
                if ($lpg_info['t_lpg_amount'] >= 6289.13) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.125);
                } else if ($lpg_info['t_lpg_amount'] >= 4029.64 and $lpg_info['t_lpg_amount'] <= 6289.13) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.15);
                } else if ($lpg_info['t_lpg_amount'] >= 2015.74 and $lpg_info['t_lpg_amount'] <= 4029.63) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.175);
                } else if ($lpg_info['t_lpg_amount'] >= 1329.74 and $lpg_info['t_lpg_amount'] <= 2015.13) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.2);
                } else if ($lpg_info['t_lpg_amount'] >= 951.35 and $lpg_info['t_lpg_amount'] <= 1329.73) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.225);
                } else if ($lpg_info['t_lpg_amount'] <= 951.34) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.25);
                }
            }
        }

        if ($elaun_cd == 12 and $lpg_info['t_lpg_cd'] == 29) {
            if ($bio->NatStatusCd == '2' or $bio->NatStatusCd == '2' or $bio->NatStatusCd == '9') {
                if ($lpg_info['t_lpg_amount'] >= 5565.61) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (12.5 / 100));
                } else if ($lpg_info['t_lpg_amount'] >= 3566.05 and $lpg_info['t_lpg_amount'] <= 5565.60) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (15 / 100));
                } else if ($lpg_info['t_lpg_amount'] >= 1783.84 and $lpg_info['t_lpg_amount'] <= 3566.04) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (17.5 / 100));
                } else if ($lpg_info['t_lpg_amount'] >= 1176.76 and $lpg_info['t_lpg_amount'] <= 1783.83) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (20 / 100));
                } else if ($lpg_info['t_lpg_amount'] >= 841.90 and $lpg_info['t_lpg_amount'] <= 1176.75) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (22.5 / 100));
                } else if ($lpg_info['t_lpg_amount'] <= 841.89) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (25 / 100));
                }
            }
        }

        if ($elaun_cd == 11 and $lpg_info['t_lpg_cd'] != 29) {
            if ($bio->NatStatusCd == '2' or $bio->NatStatusCd == '2' or $bio->NatStatusCd == '9') {
                if ($lpg_info['t_lpg_amount'] >= 6289.13) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.125);
                } else if ($lpg_info['t_lpg_amount'] >= 4029.64 and $lpg_info['t_lpg_amount'] <= 6289.13) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.15);
                } else if ($lpg_info['t_lpg_amount'] >= 2015.74 and $lpg_info['t_lpg_amount'] <= 4029.63) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.175);
                } else if ($lpg_info['t_lpg_amount'] >= 1329.74 and $lpg_info['t_lpg_amount'] <= 2015.13) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.2);
                } else if ($lpg_info['t_lpg_amount'] >= 951.35 and $lpg_info['t_lpg_amount'] <= 1329.73) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.225);
                } else if ($lpg_info['t_lpg_amount'] <= 951.34) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.25);
                }
            }
        }

        if ($elaun_cd == 13) {
            $ret_jum_el = 800;
        }

        if ($elaun_cd == 14) {
            $ret_jum_el = 700;
        }

        if ($elaun_cd == 15) {
            $ret_jum_el = 300;
        }

        if ($elaun_cd == 77) {
            $ret_jum_el = 300;
        }

        if ($elaun_cd == 22) {
            if ($gred_no['gred'] == 94) {
                $ret_jum_el = 1600;
            } else if ($gred_no['gred'] == 93) {
                $ret_jum_el = 1500;
            } else if ($gred_no['gred'] >= 53 and $gred_no['gred'] <= 54) {
                $ret_jum_el = 1300;
            } else if ($gred_no['gred'] >= 45 and $gred_no['gred'] <= 52) {
                $ret_jum_el = 1130;
            } else if ($gred_no['gred'] >= 41 and $gred_no['gred'] <= 44) {
                $ret_jum_el = 930;
            } else if ($gred_no['gred'] >= 27 and $gred_no['gred'] <= 40) {
                $ret_jum_el = 830;
            } else if ($gred_no['gred'] >= 1 and $gred_no['gred'] <= 26) {
                $ret_jum_el = 730;
            }
        }

        if ($elaun_cd == 44) {
            if ($gred_no['gred'] == 95) {
                $ret_jum_el = 2000;
            } else if ($gred_no['gred'] == 94) {
                $ret_jum_el = 1600;
            } else if ($gred_no['gred'] == 93) {
                $ret_jum_el = 1500;
            } else if ($gred_no['gred'] >= 53 and $gred_no['gred'] <= 54) {
                $ret_jum_el = 1250;
            } else if ($gred_no['gred'] >= 45 and $gred_no['gred'] <= 52) {
                $ret_jum_el = 1080;
            } else if ($gred_no['gred'] >= 41 and $gred_no['gred'] <= 44) {
                $ret_jum_el = 880;
            } else if ($gred_no['gred'] >= 27 and $gred_no['gred'] <= 40) {
                $ret_jum_el = 780;
            } else if ($gred_no['gred'] >= 1 and $gred_no['gred'] <= 26) {
                $ret_jum_el = 680;
            }
        }

        if ($elaun_cd == 45) {
            if ($gred_no['gred'] == 95) {
                $ret_jum_el = 2000;
            } else if ($gred_no['gred'] == 94) {
                $ret_jum_el = 1600;
            } else if ($gred_no['gred'] == 93) {
                $ret_jum_el = 1500;
            } else if ($gred_no['gred'] >= 53 and $gred_no['gred'] <= 54) {
                $ret_jum_el = 1200;
            } else if ($gred_no['gred'] >= 45 and $gred_no['gred'] <= 52) {
                $ret_jum_el = 1030;
            } else if ($gred_no['gred'] >= 41 and $gred_no['gred'] <= 44) {
                $ret_jum_el = 830;
            } else if ($gred_no['gred'] >= 27 and $gred_no['gred'] <= 40) {
                $ret_jum_el = 730;
            } else if ($gred_no['gred'] >= 1 and $gred_no['gred'] <= 26) {
                $ret_jum_el = 630;
            }
        }

        if ($elaun_cd == 42) {
            $ret_jum_el = 80;
        }

        if ($elaun_cd == 18) {
            $ret_jum_el = 40;
        }

        if ($elaun_cd == 42) {
            $ret_jum_el = 80;
        }

        if ($elaun_cd == 16) {
            if ($gred_chr['chr'] == 'N') {
                if ($gred_no['gred'] == 36) {
                    $ret_jum_el = 250;
                } else if ($gred_no['gred'] == 32) {
                    $ret_jum_el = 192;
                } else if ($gred_no['gred'] >= 27 and $gred_no['gred'] <= 28) {
                    $ret_jum_el = 150;
                } else if ($gred_no['gred'] >= 17 and $gred_no['gred'] <= 22) {
                    $ret_jum_el = 120;
                }

                if ($gred_no['gred'] == 28 and $lpg_id['t_lpg_dept_id'] == 9) {
                    $ret_jum_el = 190;
                }
            }
        }

        if ($elaun_cd == 17) {
            if ($gred_chr['chr'] == 'N' and ($gred_no['gred'] >= 17 and $gred_no['gred'] <= 36)) {
                $ret_jum_el = 85;
            }
        }

        if ($elaun_cd == 41) {
            if ($gred_chr['chr'] == 'N' and ($gred_no['gred'] >= 17 and $gred_no['gred'] <= 36)) {
                $ret_jum_el = 100;
            }
        }

        if ($elaun_cd == 19) {
            $ret_jum_el = 40;
        }

        if ($elaun_cd == 43) {
            $ret_jum_el = 80;
        }

        if ($elaun_cd == 61) {
            $ret_jum_el = 500;
        }

        if ($elaun_cd == 47) {
            $ret_jum_el = 100;

            if ($elaun_dekan == 1) {
                $ret_jum_el = 200;
            }

            if ($elaun_timb_dekan == 1) {
                $ret_jum_el = 100;
            }

            if ($gred_chr['chr'] == 'V') {
                $ret_jum_el = 350;
            }

            if (($gred_chr['chr'] == 'S' or $gred_chr['chr'] == 'W') and ($gred_no['gred'] == 54)) {
                $ret_jum_el = 350;
            }

            if (($gred_chr['chr'] == 'R' or $gred_chr['chr'] == 'H') and ($gred_no['gred'] == 3 or $gred_no['gred'] == 6 or $gred_no['gred'] == 11)) {
                $ret_jum_el = 50;
            }
        }

        if ($elaun_cd == 50) {
            $ret_jum_el = 800;
        }

        if ($elaun_cd == 51) {
            $ret_jum_el = 700;
        }

        if ($elaun_cd == 52) {
            $ret_jum_el = 300;
        }

        if ($elaun_cd == 53) {
            $ret_jum_el = 600;
        }

        if ($elaun_cd == 55) {
            $ret_jum_el = 150;
        }

        if ($elaun_cd == 56) {
            $ret_jum_el = 800;
        }

        if ($elaun_cd == 57) {
            $ret_jum_el = 400;
        }

        if ($elaun_cd == 58) {
            $ret_jum_el = 500;
        }

        if ($elaun_cd == 60) {
            $ret_jum_el = 500;
        }

        if ($elaun_cd == 65) {
            $ret_jum_el = 3;
        }

        if ($elaun_cd == 66) {
            $ret_jum_el = 5;
        }

        if ($elaun_cd == 72) {
            $jum_lpg_prev = TblStaffRocBatchSmbu::find()
                ->select(['TOP 1 *'])
                ->joinWith('staffRoc')
                ->where(['srb_staff_id' =>  $bio->COOldID, 'srb_change_reason' => 11, 'srb_effective_date'])
                ->sum('SR_NEW_VALUE');

            $ret_jum_el = $jum_lpg_prev;
        }

        return $ret_jum_el;
    }

    public function actionFarmGaji()
    {
        $result =  (new \yii\db\Query())->from('gaji.tblrscolpg');
        // echo $result->count();

        if ($result != null) {
            $flag = false;
            TblrscolpgLama::deleteAll();
            // Yii::$app->db->createCommand("ALTER TABLE hrm.tblrscolpg AUTO_INCREMENT = 1")->query();
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                foreach ($result->each(20, Yii::$app->db2) as $b) {
                    $bl = new TblrscolpgLama();
                    $bl->t_lpg_id = $b['t_lpg_id'];
                    $bl->setAttributes($b);
                    $flag = $bl->save(false);
                    if (!$flag) {
                        echo 'Process Rollback';
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
