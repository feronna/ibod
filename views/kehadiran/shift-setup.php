<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\kehadiran\RefWp;
use dosamigos\datepicker\DatePicker;
use app\models\kehadiran\TblRekod;
use yii\helpers\Url;
use app\models\kehadiran\Tblshift;
use app\models\kehadiran\TblYears;
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Search</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['shift-setup'], 'GET'); ?>


                <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::findAll(['status'=>1]), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::dropDownList('bulan', $bulan, ['01' => 'January', '02' => 'February', '03' => 'Mac', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                <!--<a href="#" class ='btn btn-warning'><i class="fa fa-print"></i> Cetak Laporan</a>-->
                <?= Html::a('<i class="fa fa-print"></i> Print', ['kehadiran/print-shift-setup', 'tahun' => $tahun, 'bulan' => $bulan], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                <?= Html::endForm(); ?>

            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-calendar"></i>&nbsp; Monthly Shift Setup (<?= TblRekod::viewBulan($bulan) . ' ' . $tahun ?>)</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="table-responsive">
                    <table style="font-size: 11px" class="table table-striped table-sm jambo_table table-bordered table-condensed">
                        <thead>
                            <tr class="headings">
                                <th class="text-center" rowspan="2">NO.</th>
                                <th class="text-center">DAYS</th>
                                <?php foreach ($var as $k => $v) { ?>
                                    <th class="text-center kv-align-middle"><?= $v ?></th>
                                <?php } ?>
                                <th class="text-center kv-align-middle">UPDATE</th>
                            </tr>
                        </thead>
                        <tr>
                            <td class="text-center kv-align-middle">#</td>
                            <td class="text-center">NAME</td>
                            <?php foreach ($day as $k => $v) { ?>
                                <th class="text-center kv-align-middle"><?= $v ?></th>
                            <?php } ?>
                            <th class="text-center kv-align-middle">&nbsp;</th>
                        </tr>
                        <?php foreach ($staffs as $staff) { ?>
                            <tr>
                                <td class="text-center kv-align-middle"><?= $bil++ ?></td>
                                <td class="text-left"><?= $staff->staff->CONm ?></td>
                                <?php foreach ($var as $k => $v) { ?>
                                    <?php $shift = Tblshift::viewShift($staff->staff_icno, "$tahun-$bulan-$v") ?>
                                    <td class="text-center kv-align-middle" style="background-color: <?= ($shift == 'REST' ? 'YELLOW' : ''); ?>;"><?= $shift; ?></td>
                                <?php } ?>
                                <?php
                                $link = 'kehadiran/create-shift';
                                if (Tblshift::viewShift($staff->staff_icno, "$tahun-$bulan-01")) {
                                    $link = 'kehadiran/update-shift';
                                }
                                ?>
                                <td class="text-center kv-align-middle"><?= Html::button('<i class="fa fa-edit"></i>', ['value' => Url::to([$link, 'id' => $staff->staff_icno, 'tahun' => $tahun, 'bulan' => $bulan]), 'class' => 'mapBtn', 'id' => 'modalButton']); ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>