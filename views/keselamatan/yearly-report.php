<?php

// use Yii;
use yii\helpers\Html;
use yii\helpers\Url;;

use app\models\cuti\Layak;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;
use app\models\cuti\CutiRekod;
use app\widgets\TopMenuWidget;
use app\models\cuti\TblRecords;
use app\models\keselamatan\cuti;
use kartik\datetime\DateTimePicker;
use app\models\keselamatan\TblRekod;
use kartik\daterange\DateRangePicker;
use app\models\keselamatan\TblRollcall;
use app\models\keselamatan\TblTindakanBertulisLisan;

?>
<?= $this->render('/keselamatan/_topmenu') ?>

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
                                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 text-left"><?=
                                                                                                        DatePicker::widget([
                                                                                                            'name' => 'date_start',
                                                                                                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                                                                                            'removeIcon' => '<i class="fa fa-trash text-danger"></i>',
                                                                                                            'value' => Yii::$app->getRequest()->getQueryParam('date_start'),
                                                                                                            'readonly' => true,
                                                                                                            'pluginOptions' => [
                                                                                                                'autoclose' => true,
                                                                                                                'format' => 'yyyy-mm-dd'
                                                                                                            ]
                                                                                                        ]);
                                                                                                        $date = Yii::$app->getRequest()->getQueryParam('date_start');
                                                                                                        ?>
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>Tarikh Akhir:</b></div>
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 text-left "><?=
                                                                                                        DatePicker::widget([
                                                                                                            'name' => 'date_end',
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
<?php if ($var != null) { ?>
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
                                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>UMSPER:</b></div>
                                <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= ucwords($biodata->COOldID) ?></div>
                                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Sandangan:</b></div>
                                <div class="col-lg-4 col-sm-6 col-xs-6 text-left "><?= ucwords(strtolower($biodata->statusSandangan->sandangan_name)) ?></div>
                            </div>
                            <div class="row ">
                                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh:</b></div>
                                <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= TblRekod::viewBulan($monthstart), '-', $yearstart, '            ', 'Hingga', '            ', TblRekod::viewBulan($monthend), '-', $yearend ?></div>
                                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tempoh Lantikan:</b></div>
                                <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $biodata->tblrscoapmtstatus->ApmtStatusStDt ?> hingga <?= $biodata->tblrscoapmtstatus->ApmtStatusEndDt?></div>

                            </div>

                        </div>
                    </div>
                    </br>
                </div>
            </div>
        </div>
    </div>


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

                                <tr class="headings">
                                    <th class="text-center"></th>
                                    <th class="text-center">Lambat Masuk</th>
                                    <th class="text-center">Keluar Awal</th>
                                    <th class="text-center">Tidak Lengkap</th>
                                    <th class="text-center">Tidak Hadir</th>
                                    <th class="text-center">Luar Kawasan</th>

                                </tr>
                            </thead>
                    
                                <th colspan="1" class="text-center">Jum</th>
                                <td class="text-center" style="text-align:center"><?= TblRekod::CountIncompliance($icno, Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRekod::CountIncompliance($icno, Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), '2') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRekod::CountIncompliance($icno, Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), '3') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRekod::CountIncompliance($icno, Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), '4') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRekod::CountIncompliance($icno, Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), '5') ?></td>


                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php } ?>