<?php

use app\models\cuti\CutiUmum;
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
                <h2><strong><i class="fa fa-search"></i> Kalender / <i>Calender</i> : <?= $dept_name->fullname ?></strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['calender'], 'GET'); ?>


                <?= Html::dropDownList('dept', $dept, ArrayHelper::map($department, 'id', 'fullname'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::dropDownList('month', $month, ['01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                <?= Html::a('<i class="fa fa-print"></i> Print', ['cuti/supervisor/print-calender', 'dept' => $dept, 'month' => $month, 'year' => $year], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                <?= Html::endForm(); ?>

            </div>


            <div class="clearfix">
             
                <table class="table">
                    <tr>
                        <td class="text-center" style="font-weight:bold; color:black; background-color:#00FF00">CUTI REHAT KAKITANGAN</td>
                        <td class="text-center" style="font-weight:bold; color:black; background-color:#0abcff">CUTI UMUM</td>
                        <td class="text-center" style="font-weight:bold; color:black; background-color:#808080">SABTU / AHAD</td>
                    </tr>
                </table>
                <h5>There are <?= $total ?> Staff That Taken Leave This Month</th></h5>
                <table class="table table-bordered table-condensed table-striped table-sm jambo_table">

                    <thead>
                        <tr>

                            <th class="column-title">Bil</th>
                            <th class="column-title text-center">Name</th>
                            <!-- <th class="column-title ">Leave Type</th> -->
                            <?php for ($i = 1; $days >= $i; $i++) { ?>
                                <?php if ($i < 10) { ?>

                                    <th class="column-title text-center"><?php echo '0' . $i ?></th>

                                <?php  } else { ?>
                                    <th class="column-title text-center"><?php echo $i ?></th>

                                <?php  } ?>
                            <?php  } ?>

                        </tr>
                    </thead>
                    <?php foreach ($baki as $data) { ?>
                        <tr>
                            <td class="text-left"><?= $bil++ ?></td>
                            <td class="text-left"><?= $data->kakitangan->CONm ?></td>
                            <?php for ($i = 1; $days >= $i; $i++) { ?>

                                <?php
                                if($i < 10){ #ni pun sama 2x5 10 juta.. buddduhh!
                                    $day = "0{$i}";
                               } else {
                                   $day = $i;
                               }
                                $cuti = TblRecords::getLeaveRecord($data->icno, $year, $month, $day);
                                $public_h = CutiUmum::getCutiUmum("$year-$month-$day");

                                if ($public_h) { ?>
                                    <td class="text-left" style="background-color:#0abcff"></td>
                                <?php } else if (date("l", strtotime("$year-$month-$day")) == 'Sunday' || date("l", strtotime("$year-$month-$day")) == 'Saturday') { ?>
                                    <td class="text-left" style="background-color:#808080"></td>
                                <?php  } elseif ($cuti) { ?>
                                    <td class="text-left" style="background-color:#00FF00"></td>
                                <?php  } else { ?>
                                    <td class="text-left"></td>
                                <?php  } ?>
                            <?php  } ?>
                        </tr>
                    <?php  } ?>
                </table>
            </div>