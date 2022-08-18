<?php

use yii\helpers\Html;
use app\models\kehadiran\TblWarnaKad;
use app\models\keselamatan\TblRekod;
use app\models\kehadiran\TblWp;
use app\models\keselamatan\TblRekod as KeselamatanTblRekod;
use app\models\keselamatan\TblStaffKeselamatan;
use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
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
                            'id' => 'kj-monitor',
                            'options' => ['class' => 'form-horizontal'],
                            'action' => ['keselamatan/kj-monitor'],
                            'method' => 'get',
                        ])
                ?>
                <div class="col-xs-12 col-md-5 col-lg-3"> 
                    <?=
                    DatePicker::widget([
                        'name' => 'date',
                        'value' => $today,
                        'template' => '{input}{addon}',
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                    <?= Html::dropDownList('camp', $camp, ['1' => 'Kota Kinabalu', '2' => 'Labuan', '3' => 'Sandakan'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>

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
                <h2><strong><i class="fa fa-list"></i>&nbsp;Senarai kakitangan dibawah Seliaan Anda.</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Bil</th>
                                <th class="text-center">Nama Kakitangan</th>
                                <th class="text-center">Gred Jawatan</th>
                                <th class="text-center">Syif Hakiki</th>
                                <th class="text-center">Masa Masuk Hakiki</th>
                                <th class="text-center">Masa Keluar Hakiki</th>
                                <th class="text-center">Syif LMJ</th>
                                <th class="text-center">Masa Masuk LMJ</th>
                                <th class="text-center">Masa Keluar LMJ</th>
                                <th class="text-center">Cuti/Outstation</th>
                                <th class="text-center">Ketidakpatuhan</th>
                                <th class="text-center">Lokasi</th>
                                <th class="text-center">Perincian</th>
                                <th class="text-center">Laporan<br>Kehadiran</th>
                                <th class="text-center">Senarai<br>Kesalahan</th>
                            </tr>
                        </thead>
                        <?php if ($list_staff) { ?>
                            <?php foreach ($list_staff as $senarai) { ?>
                                <tr>
                                    <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                    <td><?php echo $senarai->staff->CONm; ?></td>
                                    <td class="text-center"><?= TblStaffKeselamatan::jawatan($senarai->staff_icno) ?></td>
                                    <td class="text-center"  style="text-align:center"><?= KeselamatanTblRekod::DisplayShift($senarai->staff_icno,$today) ?></td>
                                    <td class="text-center"><?= TblRekod::DisplayTime($senarai->staff_icno, $today, 1); ?></td>
                                    <td class="text-center"><?= TblRekod::DisplayTime($senarai->staff_icno, $today, 2); ?></td>
                                    <td class="text-center"><?= TblRekod::DisplayTime($senarai->staff_icno, $today, 5); ?></td>
                                
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="11" class="align-center text-center"><i>Tiada Kakitangan Untuk Dipantau</i></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
