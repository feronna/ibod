<?php

use app\models\kehadiran\TblYears;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\keselamatan\TblRekod;
use yii\helpers\Url;
use app\models\keselamatan\TblshiftKeselamatan;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\RefUnit;
use app\models\keselamatan\TblJadualDoPm;
use app\widgets\TopMenuWidget;
?>

<?= $this->render('/keselamatan/_topmenu') ?>
<?php if($admin) { ?>

    <div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Carian</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['do-setup'], 'GET'); ?>


                <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::find()->all(), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::dropDownList('bulan', $bulan, ['01' => 'January', '02' => 'February', '03' => 'Mac', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::dropDownList('camp', $camp, ['1' => 'Kota Kinabalu', '2' => 'Labuan', '3' => 'Sandakan'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                <?= Html::endForm(); ?>

            </div>
        </div>
    </div>
</div>
<?php }else{?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Carian</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['do-setup'], 'GET'); ?>


                <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::find()->all(), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::dropDownList('bulan', $bulan, ['01' => 'January', '02' => 'February', '03' => 'Mac', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                <?= Html::endForm(); ?>

            </div>
        </div>
    </div>
</div>
<?php }?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-calendar"></i>&nbsp; Tetapan Syif Penyelia Bertugas (<?= TblRekod::viewBulan($bulan) . ' ' . $tahun ?>)</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="table-responsive">
                    <table style="font-size: 11px" class="table table-striped table-sm jambo_table table-bordered table-condensed">
                        <thead>
                            <tr class="headings">
                                <th class="text-center" rowspan="2">NO.</th>
                                <th class="text-center">DAYS</th>
                                <!-- <th class="text-center"> KP/PKP</th> -->

                                <?php foreach ($var as $k => $v) { ?>
                                    <th class="text-center kv-align-middle"><?= $v ?></th>
                                <?php } ?>
                                <th class="text-center kv-align-middle">UPDATE</th>
                            </tr>
                        </thead>
                        <tr>
                            <td class="text-center kv-align-middle">#</td>
                            <td class="text-center">NAMA</td>
                            <!-- <td class="text-center"> </td> -->
                            <?php foreach ($day as $k => $v) { ?>
                                <th class="text-center kv-align-middle"><?= $v ?></th>
                            <?php } ?>
                            <th class="text-center kv-align-middle">&nbsp;</th>
                        </tr>

                        <?php foreach ($staffs as $staff) { ?>
                            <tr>
                                <td class="text-center kv-align-middle"><?= $bil++ ?></td>
                                <td class="text-left"><?= $staff->kakitangan->CONm ?></td>

                                <?php foreach ($var as $k => $v) { ?>
                                    <td class="text-center kv-align-middle"><?= TblJadualDoPm::viewShift($staff->icno, "$tahun-$bulan-$v") ?></td>
                                <?php } ?>
                                <?php
                                $link = 'keselamatan/create-do';

                                if (TblJadualDoPm::viewShift($staff->icno, "$tahun-$bulan-01")) {
                                    $link = 'keselamatan/update-do';
//                                    var_dump('link');die;
                                }
                                ?>

                                <td class="text-center kv-align-middle"><?= Html::button('<i class="fa fa-edit"></i>', ['value' => Url::to([$link, 'id' => $staff->icno, 'tahun' => $tahun, 'bulan' => $bulan]), 'class' => 'mapBtn', 'id' => 'modalButton']); ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>