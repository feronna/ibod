<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;

use yii\helpers\ArrayHelper;
use app\models\kehadiran\TblRekod;
use app\models\kehadiran\TblYears;
use app\models\kehadiran\TblWfh;
use app\models\hronline\Tblprcobiodata;

$bln = TblRekod::viewBulanBm($bulan);

$this->title = "Jadual Bekerja Dari Rumah(WFH) - $bln $tahun";
?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-search"></i>&nbsp;<strong>Carian Jadual</strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['wfh-jadual'], 'GET', ['class' => 'form-horizontal form-label-left']); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">TAHUN&nbsp;
                    </label>

                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::findAll(['status' => 1]), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">BULAN&nbsp;
                    </label>

                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <?= Html::dropDownList('bulan', $bulan, ['01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-3 col-sm-3 col-xs-3']); ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                        <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                        <?= Html::a('<i class="fa fa-print"></i> Print', ['kehadiran/print-wfh-jadual', 'tahun' => $tahun, 'bulan' => $bulan], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                    </div>
                </div>
                <?= Html::endForm(); ?>
            </div>
        </div>
    </div>
</div>
<?php if ($var != null) { ?>
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-list"></i>&nbsp;<strong><?= Html::encode($this->title) ?></strong></h2>
                    <ul class="nav navbar-right panel_toolbox ">
                        <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-sm jambo_table">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center">Bil</th>
                                    <th class="text-center">Nama Kakitangan</th>
                                    <th class="text-center">Gred</th>
                                    <?php foreach ($var as $k => $v) { ?>
                                        <th class="text-center" style="text-align:center"><strong><?= date("d", strtotime($v)); ?></strong></th>
                                    <?php } ?>

                                </tr>
                            </thead>

                            <?php foreach (Tblprcobiodata::find()->where(['DeptId' => $bio->DeptId, 'Status' => 1])->batch(10) as $staff) { ?>
                                <?php foreach ($staff as $staffs) { ?>

                                    <tr>
                                        <td class="text-center" style="text-align:center;width:1px;white-space:nowrap"><?= $bil++ ?></td>
                                        <td style="width:1px;white-space:nowrap"><?= $staffs->CONm; ?></td>
                                        <td style="width:1px;white-space:nowrap"><?= $staffs->jawatan->gred; ?></td>
                                        <?php foreach ($var as $k => $v) { ?>
                                            <?php $is_wfh = TblWfh::isWfh(date("Y-m-d", strtotime($v)), $staffs->ICNO); ?>


                                            <td class="text-center" style="text-align:center;background-color:<?php echo ($is_wfh == 1) ? '#286090' : '#E6E9ED' ?>"><?php echo (TblWfh::isWfh(date("Y-m-d", strtotime($v)), $staffs->ICNO) == 1) ? 'H' : 'O' ?></td>

                                        <?php } ?>
                                    </tr>
                                <?php } ?>

                            <?php } ?>
                            <tr class="">
                                <td class="text-right" colspan="3"><strong>PERATUS BEKERJA DARI RUMAH (WFH)</strong></td>
                                <?php foreach ($var as $k => $v) { ?>

                                    <td class="text-center" style="text-align:center"><strong><?php echo round(TblWfh::wfhByDay($v, $icno) / $totalStaff * 100, 2); ?>%</strong></td>

                                <?php } ?>
                            </tr>
                            <!-- <tr class="">
                                <td class="text-right" colspan="3"><strong>PERATUS BEKERJA DI PEJABAT (WFO)</strong></td>
                                <?php //foreach ($var as $k => $v) { ?>

                                    <td class="text-center" style="text-align:center"><strong><?php //round(($totalStaff - TblWfh::wfhByDay($v, $icno)) / $totalStaff * 100, 2); ?>%</strong></td>

                                <?php //} ?>
                            </tr> -->
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>