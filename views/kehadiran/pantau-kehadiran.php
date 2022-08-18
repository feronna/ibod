<?php

use yii\helpers\Html;
use app\models\kehadiran\TblWarnaKad;
use app\models\kehadiran\TblRekod;
use app\models\kehadiran\TblWp;
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
                            'id' => 'pantau-kehadiran',
                            'options' => ['class' => 'form-horizontal'],
                            'action' => ['kehadiran/pantau_kehadiran'],
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
                                <th class="text-center">WBB</th>
                                <th class="text-center">Masa Masuk</th>
                                <th class="text-center">Masa Keluar</th>
                                <th class="text-center">Cuti/Outstation</th>
                                <th class="text-center">Ketidakpatuhan</th>
                                <th class="text-center">Lokasi</th>
                                <th class="text-center">Perincian</th>
                                <th class="text-center">Laporan<br>Kehadiran</th>
                                <th class="text-center">Senarai<br>Kesalahan</th>
                            </tr>
                        </thead>
                        <?php if ($model) { ?>
                            <?php foreach ($model as $senarai) { ?>
                                <tr>
                                    <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                    <td><?php echo $senarai->pemohon->CONm; ?></td>
                                    <td><?php echo $senarai->pemohon->jawatan->fname; ?></td>
                                    <td class="text-center"><?= TblWp::curr_wp($senarai->pemohon_icno, 1) ?></td>
                                    <td class="text-center"><?= TblRekod::DisplayTime($senarai->pemohon_icno, $today, 1); ?></td>
                                    <td class="text-center"><?= TblRekod::DisplayTime($senarai->pemohon_icno, $today, 2); ?></td>
                                    <td class="text-center"><?= TblRekod::DisplayCuti($senarai->pemohon_icno, $today) ?></td>
                                    <td class="text-center"><?= TblRekod::DisplayTime($senarai->pemohon_icno, $today, 5); ?></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayLoc($senarai->pemohon_icno, $today) ?></td>
                                    <td class="text-center"  style="text-align:center"><?= (TblRekod::DisplayWbb($senarai->pemohon_icno, $today) != '-') ? Html::button('<i class="fa fa-eye"></i>', ['value' => Url::to(['kehadiran/detailrekod', 'icno'=>$senarai->pemohon_icno, 'tarikh'=>$today]), 'class' => 'mapBtn', 'id' => 'modalButton'] ) : ''; ?></td>
                                    <td class="text-center"  style="text-align:center"> <?=Html::a('<i class="fa fa-bar-chart"></i>', ['kehadiran/laporan_kehadiran', 'id' => $senarai->pemohon_icno], ['class' => 'btn btn-primary btn-sm', 'target'=>'_blank']);?></td>
                                    <td class="text-center"  style="text-align:center"> <?=Html::button('<i class="fa fa-list"></i>', ['value' => Url::to(['kehadiran/staff_history', 'icno'=>$senarai->pemohon_icno]), 'class' => 'mapBtn', 'id' => 'modalButton'] )?></td>
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
