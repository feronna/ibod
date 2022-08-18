<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use app\models\kehadiran\TblPpv;
use yii\helpers\Html;

use yii\helpers\ArrayHelper;
use app\models\kehadiran\TblRekod;
use app\models\kehadiran\TblYears;
use app\models\kehadiran\TblWfh;
use yii\helpers\Url;

$bln = TblRekod::viewBulanBm($bulan);

$this->title = "Senarai Bekerja Dari Rumah(WFH) - $bln $tahun";
?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-search"></i>&nbsp;<strong>Carian Senarai Bulanan</strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['wfh-by-mth'], 'GET', ['class' => 'form-horizontal form-label-left']); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">TAHUN&nbsp;
                    </label>

                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::findAll(['status' => 1]), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">BULAN&nbsp;
                    </label>

                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <?= Html::dropDownList('bulan', $bulan, ['01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-3 col-sm-3 col-xs-3']); ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                        <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                    </div>
                </div>
                <?= Html::endForm(); ?>
            </div>
        </div>
    </div>
</div>
<?php if ($var != null) { ?>
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-list"></i>&nbsp;<strong><?= Html::encode($this->title) ?></strong></h2>
                    <ul class="nav navbar-right panel_toolbox ">
                        <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Day</th>
                                    <th class="text-center">Jumlah Staff<br> Bekerja Dari Rumah (WFH)</th>
                                    <th class="text-center">Jumlah Staff<br> Bekerja Di Pejabat (WFO)</th>
                                    <th class="text-center">Kemaskini Staff<br>WFH/WFO</th>
                                    <th class="text-center">Staff<br>Bertugas di PPV</th>
                                </tr>
                            </thead>
                            <?php foreach ($var as $k => $v) { ?>
                                <tr>
                                    <?php //if(TblRekod::DisplayDay($v) != 'Sun' && TblRekod::DisplayDay($v) != 'Sat'){ ?>
                                    <td class="text-center" style="text-align:center"><strong><?= date("d/m/Y", strtotime($v)); ?></strong></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayDay($v) ?></td>
                                    <td class="text-center" style="text-align:center"><strong><?= $totalWfh = TblWfh::wfhByDay($v,$icno) ?> (<?=($totalWfh != 0 ? round($totalWfh / $totalStaff * 100,2) : 0 ) ?> %)</strong></td>
                                    <td class="text-center" style="text-align:center"><strong><?= $totalWfo = $totalStaff - $totalWfh?>  (<?=($totalWfh != 0 ? round($totalWfo / $totalStaff * 100,2) : 0) ?> %)</strong>&nbsp;<?= Html::button('<i class="fa fa-eye"></i>', ['value' => Url::to(['kehadiran/wfo-list', 'date' => $v]), 'class' => 'mapBtn', 'id' => 'modalButton']); ?></td>
                                    <td class="text-center" style="text-align:center"><?= Html::a('<i class="fa fa-pencil"></i>', ['kehadiran/wfh-edit-day', 'date' => date("Y-m-d", strtotime($v))], ['class' => '']) ?></td>
                                    <td class="text-center" style="text-align:center"><strong><?= $totalPpv = TblPpv::ppvByDay($v,$icno) ?> (<?=($totalPpv != 0 ? round($totalPpv / $totalStaff * 100,2) : 0) ?> %)</strong>&nbsp;<?= Html::a('<i class="fa fa-heartbeat"></i>', ['kehadiran/ppv-edit-day', 'date' => date("Y-m-d", strtotime($v))], ['class' => 'btn btn-sm btn-success']) ?></td>
                                    <?php //} ?>
                                </tr>
                            <?php } ?>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>