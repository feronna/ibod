<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\TblRekod;
use app\models\kehadiran\TblYears;
use yii\helpers\Url;
use app\models\keselamatan\TblLmt;
use app\models\keselamatan\RefUnit;
use app\models\keselamatan\RefPosLmt;
use app\widgets\TopMenuWidget;
?>

<?= $this->render('/keselamatan/_topmenu') ?>

<?php
\Yii::$app->session->setFlash('info', 'Sekiranya Menggunakan Syif Biasa (A,B,C), Terus Ke Langkah 2');
?>
<div class="col-xs-12 col-md-12 col-lg-12"> 
    <div class="x_panel">
        <div class="x_content"> 
            <div class="row">
                <!-- <div class="col-xs-12 col-md-3">
                    <br>
                    <?php
                    $cr = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'plus-square',
                                        'header' => 'Tambah Syif',
                                        'text' => '',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($cr, ['keselamatan/lmt-keselamatan']);
                    ?>
                </div> -->
                <div class="col-xs-12 col-md-3">
                    <br>
                    <?php
                    $ck = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'plus-square',
                                        'header' => 'Tambah Anggota',
                                        'text' => '',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($ck, ['keselamatan/lmt-shift-list']);
                    ?>
                </div>
                <div style="background-color:lightblue" class="col-xs-12 col-md-3">
                    <br>
                    <?php
                    $c = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'clock-o',
                                        'header' => 'Tambah Syif',
                                        'text' => '',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($c, ['keselamatan/lmt-setup']);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Search</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['lmt-setup'], 'GET'); ?>


                <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::find()->all(), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::dropDownList('bulan', $bulan, 
                        ['01' => 'January', '02' => 'February', '03' => 'Mac', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br>        
                <br>
                <?= Html::dropDownList('units', $units, ArrayHelper::map(RefUnit::find()->where(['active' => 1])->all(), 'id', 'unit_name'), ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']);
                ?>

                <br>        
                <br>
                <?= Html::dropDownList('pos', $pos, ArrayHelper::map(RefPosLmt::find()->where(['active' => 1])->all(), 'id', 'pos_kawalan'), ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']);
                ?>
                <br>        
                <br>
                <br>
                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                <a href="#" class ='btn btn-warning'><i class="fa fa-print"></i> Cetak Laporan</a>
                <?= Html::a('<i class="fa fa-print"></i> Print', ['kehadiran/shift-setup', 'tahun' => $tahun, 'bulan' => $bulan, 'units' => $units], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                <?= Html::endForm(); ?>

            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-calendar"></i>&nbsp; Lebihan Masa Tambahan (<?= TblRekod::viewBulan($bulan) . ' ' . $tahun ?>)</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="table-responsive">
                    <table style="font-size: 11px" class="table table-striped table-sm jambo_table table-bordered table-condensed">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">NO.</th>
                                <th class="text-center">NAME</th>
                                <?php foreach ($var as $k => $v) { ?>
                                    <th class="text-center kv-align-middle"><?= $v ?></th>
                                <?php } ?>
                                <th class="text-center kv-align-middle">UPDATE</th>
                            </tr>
                        </thead>
                        <?php foreach ($staffs as $staff) { ?>
                       
                            <tr>
                                <td class="text-center kv-align-middle"><?=$bil++ ?></td>
                                <td class="text-left"><?= $staff->staff->CONm ?></td>
                                <?php foreach ($var as $k => $v) {?>
                                
                                    <td class="text-center kv-align-middle">
                                    <?= TblLmt::viewLmt($staff->staff_icno, "$tahun-$bulan-$v", "$bulan", $units, $pos) ?></td>
                                <?php } ?>
                                <?php
                                $link = 'keselamatan/create-lmt';

                                if (TblLmt::viewLmt($staff->staff_icno, "$tahun-$bulan-01","$bulan",$units,$pos)) {
                                    $link = 'keselamatan/update-lmt';
//                                    var_dump($link);die;
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