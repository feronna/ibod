<?php

use yii\helpers\Html;
use app\models\keselamatan\TblRekod;
use app\models\keselamatan\TblRollcall;
use app\models\kehadiran\TblYears;
use app\widgets\TopMenuWidget;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
?>


<?= $this->render('/keselamatan/_topmenu') ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Search</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['laporan', 'id' => Yii::$app->getRequest()->getQueryParam('id')], 'GET'); ?>


                <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::find()->where(['status'=>'1'])->orderBy(['id'=>SORT_DESC])->all(), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::dropDownList('camp', $camp, ['1' => 'Kota Kinabalu', '2' => 'Labuan', '3' => 'Sandakan'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                <!--<a href="#" class ='btn btn-warning'><i class="fa fa-print"></i> Cetak Laporan</a>-->
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
                    <h2><strong><i class="fa fa-list"></i> Laporan Ringkasan Kehadiran Anggota Tahun <?=Yii::$app->getRequest()->getQueryParam('tahun')?></strong></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <br>
                    <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                            <tr>
                            <th rowspan = "2" colspan = '1' class="text-center">BIL</th>
                            <th rowspan = "2" colspan = '1' class="text-center">PERKARA</th>
                            <th colspan = '12' class="text-center">BULAN</th>
                        </tr>
                        <tr>
                         
                            <th class="text-center">JAN</th>
                            <th class="text-center">FEB</th>
                            <th class="text-center">MAC</th>
                            <th class="text-center">APR</th>
                            <th class="text-center">MEI</th>
                            <th class="text-center">JUN</th>
                            <th class="text-center">JUL</th>
                            <th class="text-center">OGOS</th>
                            <th class="text-center">SEPT</th>
                            <th class="text-center">OKT</th>
                            <th class="text-center">NOV</th>
                            <th class="text-center">DIS</th>
                          
                        </tr>
                        </thead>

                        <?php for ($var;$var <= 15;$var++) { ?>
                                <tr>
                                <td class="text-center" style="text-align:center"><?= $bil++ ?></td>
                                <td class="text-center" style="text-align:center"><?= $arr[$var] ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(1, $arr[$var], Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(2, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(3, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(4, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(5, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(6, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(7, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(8, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(9, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(10, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(11, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(12, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>

                                </tr>
                                
                            <?php } ?>
                        </table>
                    </div>

                    <?= Html::a('<i class="fa fa-print"></i> Print', ['keselamatan/short-report', 'tahun' => Yii::$app->getRequest()->getQueryParam('tahun'),'camp' => Yii::$app->getRequest()->getQueryParam('camp')], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>