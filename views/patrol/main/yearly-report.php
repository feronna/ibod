<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\keselamatan\TblRekod;
use yii\helpers\Url;
use app\models\kehadiran\TblYears;
use app\models\keselamatan\TblRollcall;
use app\models\keselamatan\TblShiftKeselamatan;
use app\models\patrol\PatrolRating;
use app\models\patrol\PatrolTblReport;
use kartik\date\DatePicker;
use app\models\patrol\Rekod;
use kartik\rating\StarRating;

?>
<?= $this->render('/patrol/_menu') ?>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_content">

                <?php
                Yii::$app->session->setFlash('info', 'Sila Pilih Dalam Lingkungan Setahun Sahaja. CTH :01-02-2019 - 31-01-2020.');
                ?>
                <?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>
                <?= Html::beginForm(['yearly-report', 'id' => Yii::$app->getRequest()->getQueryParam('id')], 'GET'); ?>



                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><strong><i class="fa fa-users"></i> Pilih Tarikh</strong></h2>
                                <div class="clearfix"></div>
                            </div>

                            <div class="x_content">


                                <div class="row text-center">

                                    <div class="col-lg-11 col-sm-9 col-xs-12">
                                        <div class="row">
                                            <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula:</b></div>
                                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 text-left">
                                                <?=
                                                DatePicker::widget([
                                                    'name' => 'start',
                                                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                                    'removeIcon' => '<i class="fa fa-trash text-danger"></i>',
                                                    'value' => Yii::$app->getRequest()->getQueryParam('date_start'),
                                                    'readonly' => true,
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'format' => 'yyyy-mm-dd'
                                                    ]
                                                ]);
                                                ?>
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>Tarikh Akhir:</b></div>
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 text-left ">
                                                <?=
                                                DatePicker::widget([
                                                    'name' => 'end',
                                                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                                    'removeIcon' => '<i class="fa fa-trash text-danger"></i>',
                                                    'value' => Yii::$app->getRequest()->getQueryParam('date_end'),
                                                    'readonly' => true,
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'format' => 'yyyy-mm-dd'
                                                    ]
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                </br>
                            </div>
                            <br>
                            <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6" align="right">

                                <?= Html::submitButton('<i class="fa fa-search"></i> Cari', ['class' => 'btn btn-primary']); ?>
                                <!--<a href="#" class ='btn btn-warning'><i class="fa fa-print"></i> Cetak Laporan</a>-->
                                <?= Html::endForm(); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">

                <div class="x_title">
                    <h2><strong><i class="fa fa-users"></i> Maklumat Anggota</strong></h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <div class="row text-center">
                        <div class="col-lg-1 col-sm-3 col-xs-12 text-center">
                            <div class="col-lg-1 col-md-1 col-xs-12 text-center" rowspan="6" valign="top"><span><img height='100px' width="80px" src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(hash('sha1', $biodata->ICNO)); ?>.jpeg"></span></div>
                        </div>
                        <div class="col-lg-11 col-sm-9 col-xs-12">
                            <div class="row">
                                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>Nama:</b></div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 text-left"><?= $biodata->gelaran->Title . " " . ucwords(strtolower($biodata->CONm)) ?></div>
                                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>No. KP / Paspot:</b></div>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 text-left "><?= $biodata->ICNO ?></div>
                            </div>
                            <div class="row ">
                                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jawatan:</b></div>
                                <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= ucwords($biodata->jawatan->fname) ?></div>
                                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Kampus Cawangan:</b></div>
                                <div class="col-lg-4 col-sm-6 col-xs-6 text-left "><?= ucwords(strtolower($biodata->kampus->campus_name)) ?></div>
                            </div>
                            <div class="row ">
                                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>No Pekerja:</b></div>
                                <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= ucwords($biodata->COOldID) ?></div>
                                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Sandangan:</b></div>
                                <div class="col-lg-4 col-sm-6 col-xs-6 text-left "><?= ucwords(strtolower($biodata->statusSandangan->sandangan_name)) ?></div>
                            </div>

                        </div>
                    </div>
                    </br>
                </div>
            </div>
        </div>
    </div>
<?php if ($var != null) { ?>


    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">

                <div class="x_title">
                    <h2><strong><i class="fa fa-list"></i> Laporan Tahunan </strong></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <br>
                    <div class="table-responsive">

                        <table class="table table-striped table-sm jambo_table table-bordered">

                            <thead>
                                <tr>
                                    <th colspan="5" class="text-center">KEHADIRAN</th>

                                </tr>
                                <tr class="headings">
                                    <th class="text-center">BULAN</th>
                                    <th class="text-center">JUMLAH RONDAAN HAKIKI</th>
                                    <th class="text-center">JUM RONDAAN LM</th>
                                    <th class="text-center">PERATUSAN Hakiki(%)</th>
                                    <th class="text-center">RATING</th>
                                </tr>
                            </thead>
                            <?php foreach ($var as $k => $v) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center"><?= $v ?></td>
                                    <td class="text-center" style="text-align:center">
                                    <?= PatrolRating::monthlyhakiki($icno, $v,$yearstart) ?></td>
                                    <td class="text-center" style="text-align:center">
                                    <?= PatrolRating::monthlylm($icno, $v,$yearstart) ?></td>
                                    <td class="text-center" style="text-align:center">
                                    <?= PatrolRating::monthlypercents($icno, $v,$yearend) ?></td>
                                    <td class="text-center" style="text-align:center">
                                    <?php
                                echo StarRating::widget([
                                    'name' => 'rating_21',
                                    'value' => PatrolRating::rating($icno,$yearstart,$v),
                                    'pluginOptions' => [
                                        'readonly' => true,
                                        'showClear' => false,
                                        'showCaption' => false,
                                    ],
                                ]); ?></td>
                                 
                                </tr>
                            <?php } ?>
                            <?php
                            if ($yearend != $yearstart) {
                                foreach ($var1 as $k => $v) {
                            ?>
                                    <tr>
                                        <td class="text-center" style="text-align:center"><?= $v ?></td>
                                        <td class="text-center" style="text-align:center">
                                        <?= PatrolRating::monthlyhakiki($icno, $v,$yearend) ?></td>
                                        <td class="text-center" style="text-align:center">
                                        <?= PatrolRating::monthlylm($icno, $v,$yearend) ?></td>
                                    <td class="text-center" style="text-align:center">
                                    <?= PatrolRating::monthlypercents($icno, $v,$yearend) ?></td>
                                    <td class="text-center" style="text-align:center">
                                    <?php
                                echo StarRating::widget([
                                    'name' => 'rating_21',
                                    'value' => PatrolRating::rating($icno,$yearend,$v),
                                    'pluginOptions' => [
                                        'readonly' => true,
                                        'showClear' => false,
                                        'showCaption' => false,
                                    ],
                                ]); ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php } ?>