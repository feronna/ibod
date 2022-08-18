<?php

use app\models\kehadiran\TblYears;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\keselamatan\TblRekodOt;
use yii\helpers\Url;
use app\models\keselamatan\TblOt;
use app\models\keselamatan\RefUnit;
use app\models\keselamatan\RefPosKawalan;
use app\widgets\TopMenuWidget;

?>
<?= $this->render('/keselamatan/_topmenu') ?>

<div class="row">
  
  
    <div class="col-xs-12 col-md-12 col-lg-12"> 
          <div class="x_panel">
            <div class="x_content"> 


                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <?php
                        $resume = \yiister\gentelella\widgets\StatsTile::widget(
                                        [
                                            'icon' => 'clock-o',
                                            'header' => 'Hakiki',
                                            'text' => '',
                                            'number' => 'Hakiki',
                                        ]
                        );
                        echo Html::a($resume, ['keselamatan/shift-setup']);
                        ?>

                    </div>

                    <div class="col-xs-12 col-md-3">
                        <?php
                        $jadual_temuduga = \yiister\gentelella\widgets\StatsTile::widget(
                                        [
                                            'icon' => 'clock-o',
                                            'header' => 'Lebih Masa',
                                            'text' => '',
                                            'number' => 'LM',
                                        ]
                        );
                        echo Html::a($jadual_temuduga, ['keselamatan/ot-setup']);
                        ?>
                    </div>
                    
                     <div class="col-xs-12 col-md-3">
                        <?php
                        $jadual= \yiister\gentelella\widgets\StatsTile::widget(
                                        [
                                             'icon' => 'clock-o',
                                            'header' => 'Penganti/LMT',
                                            'text' => '',
                                            'number' => 'LMT',
                                        ]
                        );
                        echo Html::a($jadual, ['keselamatan/lmt-setup']);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Carian </strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['ot-setup'], 'GET'); ?>


                <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::find()->all(), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::dropDownList('bulan', $bulan, 
                        ['01' => 'January', '02' => 'February', '03' => 'Mac', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br>        
                <br>
                <!-- <?= Html::dropDownList('units', $units, ArrayHelper::map(RefUnit::find()->where(['active' => 1])->all(), 'id', 'unit_name'), ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']);
                ?>

                <br>        
                <br> -->
                <?= Html::dropDownList('pos', $pos, ArrayHelper::map($query, 'id', 'pos_kawalan'), ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']);
                ?>
                <br>        
                <br>
                <br>
                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                <!--<a href="#" class ='btn btn-warning'><i class="fa fa-print"></i> Cetak Laporan</a>-->
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
                <h2><strong><i class="fa fa-calendar"></i>&nbsp; Tetapan Syif Kerja Lebih Masa(<?= TblRekodOt::viewBulan($bulan) . ' ' . $tahun ?>)</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="table-responsive">
                    <table style="font-size: 11px" class="table table-striped table-sm jambo_table table-bordered table-condensed">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">NO.</th>
                                <th class="text-center">NAMA</th>
                                <?php foreach ($var as $k => $v) { ?>
                                    <th class="text-center kv-align-middle"><?= $v ?></th>
                                <?php } ?>
                                <th class="text-center kv-align-middle">UPDATE</th>
                            </tr>
                        </thead>
                        <?php foreach ($staffs as $staff) { ?>
                            <tr>
                                <td class="text-center kv-align-middle"><?= $bil++ ?></td>
                                <td class="text-left"><?= $staff->staff->CONm ?></td>
                                <?php foreach ($var as $k => $v) { ?>
                                    <td class="text-center kv-align-middle">
                                    <?= TblOt::viewOt($staff->icno, "$tahun-$bulan-$v") ?></td>
                                <?php } ?>
                                <?php
                                $link = 'keselamatan/create-ot';
                                
                                if (TblOt::viewOt($staff->icno, "$tahun-$bulan-01")) {
                                    $link = 'keselamatan/update-shift-ot';
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