<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//yii\helpers\VarDumper::dump($jenis_cuti,10,true);

use app\models\cuti\Layak;
use app\models\cuti\TblRecords;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

$this->title = 'Leave Statement';


?>

<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-search"></i>&nbsp;<strong>Carian/<i>Search</i></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?= Html::beginForm(['statement'], 'GET'); ?>

        <?php echo Html::dropDownList('year', $year, ArrayHelper::map(Layak::find()->select('YEAR(layak_mula) AS tahun')->where(['layak_icno'=>'890426495037'])->asArray()->all(), 'tahun', 'tahun'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
        <br>
        <br>
        <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
       <?= Html::endForm(); ?>
    </div>
</div>


<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-plane"></i>&nbsp;<strong>Penyata Cuti/<i><?= Html::encode($this->title) ?></i></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <!-- <h4 class="text-center">Entitlement</h4> -->
        <?php foreach ($layak as $v) { ?>
            <div class="tile-stats" style="padding:10px">
                <table class="table table-bordered table-condensed table-striped table-sm jambo_table">
                    <thead>
                        <tr class="headings">
                            <th class="column-title text-center">START</th>
                            <th class="column-title text-center">END</th>
                            <th class="column-title text-center">BCTL</th>
                            <th class="column-title text-center">ENTITLEMENT</th>
                            <th class="column-title text-center">TOTAL</th>
                            <th class="column-title text-center">CBTH</th>
                            <th class="column-title text-center">GCR</th>
                            <th class="column-title text-center">DISCARDED</th>
                        </tr>
                    </thead>
                    <tr class='text-center'>
                        <td><?= $v->layakMulaDmy ?></td>
                        <td><?= $v->layakTamatDmy ?></td>
                        <td><?= $v->layak_bawa_lepas ?></td>
                        <td><?= $v->layak_cuti ?></td>
                        <td><?= $v->layak_bawa_lepas + $v->layak_cuti + $v->layak_selaras?></td>
                        <td><?= $v->layak_bawa_depan ?></td>
                        <td><?= $v->layak_gcr ?></td>
                        <td><?= $v->layak_hapus ?></td>
                    </tr>

                    <table class="table table-bordered table-condensed jambo_table table-striped table-sm">
                        <thead>
                            <tr class="headings">
                                <th class="column-title text-center">LEAVE DATE</th>
                                <th class="column-title text-center">PERIOD (DAYS)</th>
                                <th class="column-title text-center">CUMULATIVE</th>
                                <th class="column-title text-center">BALANCE</th>
                                <th class="column-title text-center">LEAVE TYPE</th>
                            </tr>
                        </thead>
                        <?php $cum = 0; ?>
                        <?php foreach (TblRecords::PenyataCuti($icno, $v->layak_mula, $v->layak_tamat) as $c) { ?>
                            
                            <tr class='text-center'>
                                <td><?= $c->full_date ?></td>
                                <td><?= $c->tempoh ?></td>
                                <td><?= ($c->jenis_cuti_id == 1 || $c->jenis_cuti_id == 2) ? $cum = $cum + $c->tempoh : $cum; ?></td>
                                <td><?= ($c->jenis_cuti_id == 1 || $c->jenis_cuti_id == 2) ? $v->layak_bawa_lepas + $v->layak_cuti + $v->layak_selaras - $cum : $v->layak_bawa_lepas + $v->layak_cuti + $v->layak_selaras - $cum; ?></td>
                                <td><?= $c->jenisCuti->jenis_cuti_nama ?></td>
                            </tr>
                        <?php } ?>
                    </table>

                </table>
            </div>
        <?php } ?>
        <!-- <h4 class="text-center">Leave Records</h4> -->

    </div>
</div>