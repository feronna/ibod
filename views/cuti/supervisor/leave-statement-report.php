<?php

use app\models\cuti\Layak;
use app\models\cuti\SetPegawai;
use app\models\cuti\TblRecords;
use app\models\hronline\Tblprcobiodata;
use yii\helpers\Html;
use app\models\keselamatan\TblRekod;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
use yii\widgets\DetailView;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\daterange\DateRangePicker;
use yii\bootstrap\Modal;


?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Laporan Bulanan / <i>Monthly Leave Report </i> <?= $dept_name->fullname ?></strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['leave-statement-report'], 'GET'); ?>


                <?= Html::dropDownList('dept', $dept, $query, ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::dropDownList('jenis_cuti', $jenis_cuti, ArrayHelper::map($jenis, 'jenis_cuti_id', 'jenis_cuti_catatan'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::dropDownList('year', $year, $data, ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::dropDownList('month', $month, ['0' => 'Until Current Month', '01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br>
                <br>
                <span style="background-color :pink"><u>*To Show All Leave Taken until Current Month, Please Select Show All and Until Current Month*</u></span>
                <br>
                <br>

                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                <?= Html::a('<i class="fa fa-print"></i> Print', ['cuti/supervisor/print-statement-report', 'year' => $year, 'month' => $month], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                <?= Html::a('<i class="fa fa-print"></i> Print Statement Until Current Month', ['cuti/supervisor/print-statements', 'dept' => $dept, 'year' => $year], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                <?= Html::endForm(); ?>

            </div>


            <div class="clearfix">
                <!-- <span class="badge" style="background-color :pink"><u><?= Html::a('[Manual Leave Application]', ["cuti/supervisor/manual-leave-application", 'id' =>  $id]) ?>
                    </u></span> -->
                <table class="table table-bordered table-condensed table-striped table-sm jambo_table">

                    <tr>

                        <thead>
                            <th class="column-title text-right" colspan="4">There are <?= $total ?> Staff That Taken Leave For <?= TblRecords::viewBulan($month) ?> <?= $year ?></th>

                        </thead>
                    </tr>
                    <?php foreach ($staff_list as $data) { ?>
                        <tr>

                            <thead>
                                <td class="text-left" colspan=" 4">(<?= $count++ ?>) <?= $data->CONm ?></td>
                                <tr>

                                    <th class="column-title text-center">Start - End</th>
                                    <th class="column-title text-center">Duration</th>
                                    <th class="column-title text-center">Leave Type</th>

                            </thead>
                            <?php foreach (TblRecords::getRecord($data->ICNO, "$year", "$month") as $test) { ?>
                        <tr>

                            <td class="text-center"><?= $test->full_date ?></td>
                            <td class="text-center"><?= $test->tempoh ?></td>
                            <td class="text-center"><?= $test->jenisCuti->jenis_cuti_catatan ?></td>


                        </tr>
                    <?php  } ?>

                    </thead>
                    </tr>

                <?php  } ?>




                </table>
            </div>
        </div>
    </div>
</div>