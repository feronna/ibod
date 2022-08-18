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
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h3 class="text-center"><strong><i class="fa fa-calendar"></i>&nbsp; Shift <?= TblRekod::viewBulan($bulan) . ' ' . $tahun ?></strong></h3>
                <h5>Supervisor : <strong><?php echo $sup->CONm; ?><strong></h5>
                <h5>J/F/P/I/B : <strong><?php echo $sup->department->fullname; ?><strong></h5>
                <h5>Campus : <strong><?php echo $sup->kampus->campus_name; ?><strong></h5>
                <hr>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="table-responsive">
                    <table style="font-size: 13px;" class="table table-striped table-sm jambo_table table-bordered table-condensed">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">NO.</th>
                                <th class="text-center">DAYS</th>
                                <?php foreach ($var as $k => $v) { ?>
                                    <th class="text-center kv-align-middle"><?= $v ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tr>
                            <td class="text-center kv-align-middle">#</td>
                            <td class="text-center" style="width:150px; margin: 35px"><strong>NAME</strong></td>
                            <?php foreach ($day as $k => $v) { ?>
                                <th class="text-center kv-align-middle"><?= $v ?></th>
                            <?php } ?>
                        </tr>
                        <?php foreach ($staffs as $staff) { ?>
                            <tr>
                                <td class="text-center kv-align-middle"><?= $bil++ ?></td>
                                <td class="text-left"><?= $staff->staff->CONm ?></td>
                                <?php foreach ($var as $k => $v) { ?>
                                    <?php $shift = Tblshift::viewShift($staff->staff_icno, "$tahun-$bulan-$v") ?>
                                    <td class="text-center kv-align-middle" style="background-color: <?= ($shift == 'REST' ? 'YELLOW' : ''); ?>;"><?= $shift; ?></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>