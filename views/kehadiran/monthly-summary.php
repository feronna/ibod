<?php

use yii\helpers\Html;
use app\models\kehadiran\TblRekod;
use yii\widgets\ActiveForm;
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i>&nbsp;Carian</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $form = ActiveForm::begin([
                            'id' => 'pantau-kehadiran',
//                            'options' => ['class' => 'form-horizontal'],
                            'action' => ['kehadiran/monthly-summary'],
                            'method' => 'get',
                        ])
                ?>

                <div class="col-xs-12 col-md-5 col-lg-3"> 
                    <?= Html::dropDownList('bulan', $today, ['01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-4 col-sm-4 col-xs-12']); ?>
                    <br><br>
                    <?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;Search', ['class' => 'btn btn-primary']) ?>

                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-line-chart"></i>&nbsp;Rumusan kehadiran staf dibawah seliaan anda.</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="text-right">
                    <h4>Bulan : <strong><?= TblRekod::viewBulan($today) ?></strong></h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Bil</th>
                                <th class="text-center">Nama Kakitangan</th>
                                <th class="text-center">Jam bekerja<br>[Jam:Minit]</th>
                                <th class="text-center">Hari bekerja<br>[Completed]</th>
                                <th class="text-center">Late In</th>
                                <th class="text-center">Early Out</th>
                                <th class="text-center">Incomplete</th>
                                <th class="text-center">Absent</th>
                                <th class="text-center">external</th>
                            </tr>
                        </thead>
                        <?php if ($model) { ?>
                            <?php foreach ($model as $senarai) { ?>
                                <tr>
                                    <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                    <td><?php echo $senarai->pemohon->CONm; ?></td>
                                    <td class="text-center"><?= TblRekod::TotalWorkingHours($senarai->pemohon_icno, $today, $tahun, 1) ?></td>
                                    <td class="text-center"><?= TblRekod::TotalWorkingHours($senarai->pemohon_icno, $today, $tahun, 2) ?></td>
                                    <td class="text-center"><?= TblRekod::countKetidakpatuhan($senarai->pemohon_icno, $today, $tahun, 1) ?></td>
                                    <td class="text-center"><?= TblRekod::countKetidakpatuhan($senarai->pemohon_icno, $today, $tahun, 2) ?></td>
                                    <td class="text-center"><?= TblRekod::countKetidakpatuhan($senarai->pemohon_icno, $today, $tahun, 3) ?></td>
                                    <td class="text-center"><?= TblRekod::countKetidakpatuhan($senarai->pemohon_icno, $today, $tahun, 4) ?></td>
                                    <td class="text-center"><?= TblRekod::countKetidakpatuhan($senarai->pemohon_icno, $today, $tahun, 5) ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="9" class="align-center text-center"><i>Tiada Kakitangan Untuk Dipantau</i></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
