<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\TblYears;
use app\models\keselamatan\TblRekod;
use yii\helpers\Url;
use app\models\keselamatan\TblshiftKeselamatan;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\RefUnit;
use app\models\keselamatan\TblOt;
use app\models\keselamatan\TblLmt;

?>
<?= $this->render('/keselamatan/_topmenu') ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Search</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['monthly-report'], 'GET'); ?>


                <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::find()->all(), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::dropDownList('bulan', $bulan, ['01' => 'January', '02' => 'February', '03' => 'Mac', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br>        
                <br>
                <?= Html::dropDownList('units', $units, ArrayHelper::map(RefUnit::find()->where(['active' => 1])->all(), 'id', 'unit_name'), ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']);
                ?>

                <br>        
                <br>
                <?= Html::dropDownList('pos', $pos, ArrayHelper::map(RefPosKawalan::find()->where(['active' => 1])->all(), 'id', 'pos_kawalan'), ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']);
                ?>
                <br>        
                <br>
                <br>
                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                <!--<a href="#" class ='btn btn-warning'><i class="fa fa-print"></i> Cetak Laporan</a>-->
                <?= Html::a('<i class="fa fa-print"></i> Print', ['keselamatan/report','tahun' => $tahun, 'bulan' => $bulan, 'units' => $units,'pos'=>$pos], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                <?= Html::endForm(); ?>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-calendar"></i>&nbsp; Jadual Penugasan Bulanan BKUMS (<?= TblRekod::viewBulan($bulan) . ' ' . $tahun ?>)</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="table-responsive">
                    <table style="font-size: 11px" class="table table-striped table-sm jambo_table table-bordered table-condensed">
                        <thead>
                            <tr class="headings">
                                <th class="text-center" rowspan="2">UMSPER</th>
                                <th class="text-center">DAYS</th>
                                <th class="text-center"> KP/PKP</th>

                                <?php foreach ($var as $k => $v) { ?>
                                    <th class="text-center kv-align-middle"><?= $v ?></th>
                                <?php } ?>

                            </tr>
                        </thead>
                        <tr>
                            <td class="text-center kv-align-middle">#</td>
                            <td class="text-center">NAME</td>
                            <td class="text-center"> </td>
                            <?php foreach ($day as $k => $v) { ?>
                                <th class="text-center kv-align-middle"><?= $v ?></th>
                            <?php } ?>
<!--<th class="text-center kv-align-middle">&nbsp;</th>-->
                        </tr>

                        <?php foreach ($staffs as $staff) { ?>
                            <tr>
                                <td class="text-center kv-align-middle"><?= $staff->staff->COOldID ?></td>
                                <td class="text-left"><?= $staff->staff->CONm ?></td>
                                <td class="text-left"><?= $staff->kp ?></td>

                                <?php foreach ($var as $k => $v) { ?>
                                    <td class="text-center kv-align-middle"><?= TblshiftKeselamatan::viewShift($staff->staff_icno, "$tahun-$bulan-$v") ?></td>
                                <?php } ?>
                                <?php
                                if (TblshiftKeselamatan::viewShift($staff->staff_icno, "$tahun-$bulan-01")) {
                                    $link = 'keselamatan/update-shift';
//                                    var_dump('link');die;
                                }
                                ?>

                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <h2><strong><i class="fa fa-calendar"></i>&nbsp; Jadual Lebihan Masa Bulanan BKUMS (<?= TblRekod::viewBulan($bulan) . ' ' . $tahun ?>)</strong></h2>

            <div class="clearfix"></div>

            <div class="x_content">

                <div class="table-responsive">
                    <table style="font-size: 11px" class="table table-striped table-sm jambo_table table-bordered table-condensed">
                        <thead>
                            <tr class="headings">
                                <th class="text-center" rowspan="2">UMSPER</th>
                                <th class="text-center">DAYS</th>
                                <th class="text-center"> KP/PKP</th>

                                <?php foreach ($var as $k => $v) { ?>
                                    <th class="text-center kv-align-middle"><?= $v ?></th>
                                <?php } ?>
                                <td class="text-left">Jumlah OT</td>
                                <td class="text-left">Jumlah Jam</td>

                            </tr>
                        </thead>
                        <tr>
                            <td class="text-center kv-align-middle">#</td>
                            <td class="text-center">NAME</td>
                            <td class="text-center"> </td>

                            <?php foreach ($day as $k => $v) { ?>

                                <th class="text-center kv-align-middle"><?= $v ?></th>

                            <?php } ?>
                            <th class="text-center kv-align-middle">&nbsp;</th>
                            <th class="text-center kv-align-middle">&nbsp;</th>
                        </tr>

                        <?php foreach ($staffs as $staff) { ?>
                            <tr>
                                <td class="text-center kv-align-middle"><?= $staff->staff->COOldID ?></td>
                                <td class="text-left"><?= $staff->staff->CONm ?></td>
                                <td class="text-left"><?= $staff->kp ?></td>

                                <?php foreach ($var as $k => $v) { ?>
                                    <td class="text-center kv-align-middle"><?= TblOt::viewOt($staff->staff_icno, "$tahun-$bulan-$v", "$bulan", $units, $pos) ?></td>
                                <?php } ?>
                                <td class="text-center kv-align-middle"><b><?= TblOt::countOt($staff->staff_icno, "$bulan", $tahun) ?></td>
                                <td class="text-center kv-align-middle"><b><?= TblOt::countJumlahOt($staff->staff_icno, "$bulan", $tahun) ?></td>

                                <?php
                                if (TblOt::viewOt($staff->staff_icno, "$tahun-$bulan-01","$bulan", $units, $pos)) {
                                    $link = 'keselamatan/update-shift';
//                                    var_dump('link');die;
                                }
                                ?>

                            </tr>

                        <?php } ?>
                        <th colspan = "3" class="text-center kv-align-middle"><b>JUMLAH</b></th>
                        <?php foreach ($var as $k => $v) { ?>

                            <th class="text-center kv-align-middle">&nbsp;</th>
                        <?php } ?>
                        <?php if ($staffs) { ?>
                            <td class="text-center kv-align-middle"><b><?= TblOt::countJumlah($staff->staff_icno, "$bulan", $tahun, $units, $pos) ?></td>
                            <td class="text-center kv-align-middle"><b><?= TblOt::countJumlahJam($staff->staff_icno, "$bulan", $tahun, $units, $pos) ?></td>

                        <?php } ?>
                    </table>
                    
                    
                    <h2><strong><i class="fa fa-calendar"></i>&nbsp; Jadual Lebihan Tambahan/Penganti(<?= TblRekod::viewBulan($bulan) . ' ' . $tahun ?>)</strong></h2>

                    <table style="font-size: 11px" class="table table-striped table-sm jambo_table table-bordered table-condensed">
                        <thead>
                            <tr class="headings">
                                <th class="text-center" rowspan="2">UMSPER</th>
                                <th class="text-center">DAYS</th>
                                <th class="text-center"> KP/PKP</th>

                                <?php foreach ($var as $k => $v) { ?>
                                    <th class="text-center kv-align-middle"><?= $v ?></th>
                                <?php } ?>
<!--                                <td class="text-left">Jumlah OT</td>
                                <td class="text-left">Jumlah Jam</td>-->

                            </tr>
                        </thead>
                        <tr>
                            <td class="text-center kv-align-middle">#</td>
                            <td class="text-center">NAME</td>
                            <td class="text-center"> </td>

                            <?php foreach ($day as $k => $v) { ?>

                                <th class="text-center kv-align-middle"><?= $v ?></th>

                            <?php } ?>
    <!--                            <th class="text-center kv-align-middle">&nbsp;</th>
                                <th class="text-center kv-align-middle">&nbsp;</th>-->
                        </tr>

                        <?php foreach ($lmt as $staff) { ?>
                            <tr>
                                <td class="text-center kv-align-middle"><?= $staff->staff->COOldID ?></td>
                                <td class="text-left"><?= $staff->staff->CONm ?></td>
                                <td class="text-left"></td>

                                <?php foreach ($var as $k => $v) { ?>
                                <?php // var_dump($pos);die;?>
                                    <td class="text-center kv-align-middle"><?= TblLmt::viewLmt($staff->staff_icno, "$tahun-$bulan-$v", "$bulan", $units, $pos) ?></td>
                                <?php } ?>
<!--                               
                                <?php
                                if (TblLmt::viewLmt($staff->staff_icno, "$tahun-$bulan-01","$bulan", $units, $pos)) {
                                    $link = 'keselamatan/update-shift';
//                                    var_dump('link');die;
                                }
                                ?>

                            </tr>

                        <?php } ?>
                      
                    
                    </table>

                    <!--kekuatan angora-->
                    <div class="table-responsive">
              
                        <table style="font-size: 11px" class="table table-striped table-sm jambo_table table-bordered table-condensed">
                            <thead>
                                <tr class="headings">
                                    <th colspan="3" class="text-center" rowspan="2"> </th>
<!--                                    <th class="text-center"> </th>
<th class="text-center"> </th>-->

                                    <?php foreach ($var as $k => $v) { ?>
                                        <th class="text-center kv-align-middle"><?= $v ?></th>
                                    <?php } ?>

                                </tr>
                            </thead>
                            <tr>
                                <td colspan="3"class="text-center kv-align-middle">&nbsp;</td>
<!--                                <td class="text-center"></td>
                                <td class="text-center"> </td>-->
                                <?php foreach ($day as $k => $v) { ?>
                                    <th class="text-center kv-align-middle"><?= $v ?></th>
                                <?php } ?>
<!--<th class="text-center kv-align-middle">&nbsp;</th>-->
                            </tr>

                            <?php foreach ($syifs as $staff) { ?>
                                <tr>
                                    <!--<td colspan="2" class="text-center kv-align-middle">&nbsp;</td>-->
                                    <td colspan="3" class="text-left"><?= $staff->details ?></td>

                                    <?php foreach ($var as $k => $v) { ?>


                                        <td class="text-center kv-align-middle"><?= \app\models\keselamatan\TblShiftKeselamatan::countSyif($staff->id, $pos, $units, "$tahun-$bulan-$v") ?></td>
                                    <?php } ?>
                                    <?php
//                                if (TblshiftKeselamatan::viewShift($staff->staff_icno, "$tahun-$bulan-01")) {
//                                    $link = 'keselamatan/update-shift';
////                                    var_dump('link');die;
//                                }
                                    ?>

                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>  
