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
                <?= Html::beginForm(['laporan-tahunan', 'id' => Yii::$app->getRequest()->getQueryParam('id')], 'GET'); ?>



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
                <?= Html::button('<i class="fa fa-list"></i>&nbsp;Senarai Kesalahan Hakiki', ['value' => Url::to(['keselamatan/record', 'icno' => $icno, 'id' => 1]), 'class' => 'mapBtn btn btn-warning', 'id' => 'modalButton']) ?>
                <?= Html::button('<i class="fa fa-list"></i>&nbsp;Senarai Kesalahan LMJ', ['value' => Url::to(['keselamatan/record', 'icno' => $icno, 'id' => 2]), 'class' => 'mapBtn btn btn-warning', 'id' => 'modalButton']) ?>
                <?= Html::button('<i class="fa fa-list"></i>&nbsp;Senarai Kesalahan Rollcall', ['value' => Url::to(['keselamatan/record-rollcall', 'icno' => $icno]), 'class' => 'mapBtn btn btn-warning', 'id' => 'modalButton']) ?>
                <?= Html::button('<i class="fa fa-list"></i>&nbsp;Senarai Teguran', ['value' => Url::to(['keselamatan/record-warning', 'icno' => $icno]), 'class' => 'mapBtn btn btn-warning', 'id' => 'modalButton']) ?>

                <div class="x_title">
                    <h2><strong><i class="fa fa-list"></i> Laporan Tahunan </strong></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            
                            <tr>
                
                                <td class="text-center" style="text-align:center">BCTL</td>
                                <th colspan="1" class="text-center"><?= Layak::getBakiOld($icno, Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end')) ?></th>
                            </tr>
                            <tr>
                                <td class="text-center" style="text-align:center">Cuti Tahunan</td>
                                <th colspan="7" class="text-center"><?= cuti::totalLayak($icno); ?></th>
                            </tr>
                            <tr>
                                <td class="text-center" style="text-align:center">Jumlah Cuti Tahunan</td>
                                <th colspan="7" class="text-center"><?= TblRecords::getIncrement($icno, Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end')) ?></th>
                            </tr>
                            <tr>
                                <td class="text-center" style="text-align:center">Baki Cuti Tahunan</td>
                                <th colspan="7" class="text-center"><?= cuti::totalLayak($icno) - TblRecords::getIncrement($icno, Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end')); ?></th>
                            </tr>
                        </table>
                        <table class="table table-striped table-sm jambo_table table-bordered">

                            <thead>
                                <tr>
                                    <th colspan="5" class="text-center"></th>
                                    <th colspan="4" class="text-center">THB</th>
                                    <th colspan="7" class="text-center">THH</th>
                                    <th colspan="3" class="text-center"></th>
                                    <th colspan="2" class="text-center"></th>
                                    <th colspan="3" class="text-center">TINDAKAN DIAMBIL</th>
                                    <th colspan="2" class="text-center"></th>
                                </tr>
                                <tr class="headings">
                                    <th class="text-center">Perkara</th>
                                    <th class="text-center">HH</th>
                                    <th class="text-center">HLMJ</th>
                                    <th class="text-center">HLMT</th>
                                    <th class="text-center">HKWLN</th>
                                    <th class="text-center">THBH</th>
                                    <th class="text-center">THBLMJ</th>
                                    <th class="text-center">THBLMT</th>
                                    <th class="text-center">THBKWLN</th>
                                    <th class="text-center">CR</th>
                                    <th class="text-center">CS</th>
                                    <th class="text-center">CTR</th>
                                    <th class="text-center">CGKA</th>
                                    <th class="text-center">CKA</th>
                                    <th class="text-center">CG</th>
                                    <th class="text-center">THTC</th>
                                    <th class="text-center">THH</th>
                                    <th class="text-center">THLMJ</th>
                                    <th class="text-center">THLMT</th>
                                    <th class="text-center">THKWLN</th>
                                    <th class="text-center">CSG</th>
                                    <th class="text-center">CTG</th>
                                    <th class="text-center">T/LISAN</th>
                                    <th class="text-center">T/BERTULIS</th>
                                    <th class="text-center">STS(J/A/R)</th>
                                    <th class="text-center">CATATAN</th>

                                </tr>
                            </thead>
                            <?php foreach ($var as $k => $v) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center"><?= $v ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearstart, $yearend, 'H', $icno, 'HH', '1') ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearstart, $yearend, 'LMJ', $icno, 'HLMJ', '1') ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearstart, $yearend, 'LMT', $icno, 'HLMT', '1') ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearstart, $yearend, 'KWLN', $icno, 'HKWLN', '1') ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearstart, $yearend, 'H', $icno, 'THBH', '1') ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearstart, $yearend, 'LMJ', $icno, 'THBLMJ', '1') ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearstart, $yearend, 'LMT', $icno, 'THBLMT', '1') ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearstart, $yearend, 'KWLN', $icno, 'THBKWLN', '1') ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::CountCutiRehat($icno, $v, $yearstart) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::countCSakit1($icno, $v, $yearstart) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::countCtr($icno, $v, $yearstart) ?></td>
                                    <td class="text-center" style="text-align:center">0</td>
                                    <!--Cuti gka -->
                                    <td class="text-center" style="text-align:center">0</td>
                                    <!--Cuti ka -->
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::countGanti($icno, $v, $yearstart) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearlySpecific($v, $yearstart, 'LMJ', $icno, 'THTC', '1') ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearstart, $yearend, 'H', $icno, 'THH', '1') ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearstart, $yearend, 'LMJ', $icno, 'THLMJ', '1') ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearstart, $yearend, 'LMT', $icno, 'THLMT', '1') ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearstart, $yearend, 'KWLN', $icno, 'THKWLN', '1') ?></td>
                                    <td class="text-center" style="text-align:center">0</td>
                                    <!--Cuti separuh gaji -->
                                    <td class="text-center" style="text-align:center">0</td>
                                    <!--Cuti tanpa gaji -->
                                    <td class="text-center" style="text-align:center"><?= TblTindakanBertulisLisan::CountTl($v, $yearstart, $icno) ?></td>
                                    <!--TB -->
                                    <td class="text-center" style="text-align:center"><?= TblTindakanBertulisLisan::CountTb($v, $yearstart, $icno) ?></td>
                                    <!--TB -->
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::CountStartYearlySts($v, $yearstart, $icno) ?></td>
                                    <td class="text-center" style="text-align:center">-</td>

                                </tr>
                            <?php } ?>
                            <?php
                            if ($yearend != $yearstart) {
                                foreach ($var1 as $k => $v) {
                            ?>
                                    <tr>
                                        <td class="text-center" style="text-align:center"><?= $v ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearend, $yearend, 'H', $icno, 'HH', '1') ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearend, $yearend, 'LMJ', $icno, 'HLMJ', '1') ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearend, $yearend, 'LMT', $icno, 'HLMT', '1') ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearend, $yearend, 'KWLN', $icno, 'HKWLN', '1') ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearend, $yearend, 'H', $icno, 'THBH', '1') ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearend, $yearend, 'LMJ', $icno, 'THBLMJ', '1') ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearend, $yearend, 'LMT', $icno, 'THBLMT', '1') ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearend, $yearend, 'KWLN', $icno, 'THBKWLN', '1') ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::CountCutiRehat($icno, $v, $yearend) ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::countCSakit1($icno, $v, $yearend) ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::countCtr($icno, $v, $yearend) ?></td>
                                        <td class="text-center" style="text-align:center">0</td>
                                        <td class="text-center" style="text-align:center">0</td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::countGanti($icno, $v, $yearend) ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearlySpecific($v, $yearend, 'LMJ', $icno, 'THTC', '1') ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearend, $yearend, 'H', $icno, 'THH', '1') ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearend, $yearend, 'LMJ', $icno, 'THLMJ', '1') ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearend, $yearend, 'LMT', $icno, 'THLMT', '1') ?></td>
                                        <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadirYearly($v, $yearend, $yearend, 'KWLN', $icno, 'THKWLN', '1') ?></td>
                                        <td class="text-center" style="text-align:center">0</td>
                                        <td class="text-center" style="text-align:center">0</td>
                                        <td class="text-center" style="text-align:center"><?= TblTindakanBertulisLisan::CountTl($v, $yearend, $icno) ?></td>
                                        <!--TB -->
                                        <td class="text-center" style="text-align:center"><?= TblTindakanBertulisLisan::CountTb($v, $yearend, $icno) ?></td>
                                        <!--TB -->

                                        <td class="text-center" style="text-align:center"><?= TblRollcall::CountStartYearlySts($v, $yearend, $icno) ?></td>
                                        <td class="text-center" style="text-align:center">-</td>

                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            <tr>
                                <th colspan="1" class="text-center">Jum</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountTotal(Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), $icno, 'HH', '1', 'H') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountTotal(Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), $icno, 'HLMJ', '1', 'LMJ') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountTotal(Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), $icno, 'HLMT', '1', 'LMT') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountTotal(Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), $icno, 'HKWLN', '1', 'KWLN') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountTotal(Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), $icno, 'THBH', '1', 'H') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountTotal(Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), $icno, 'THBLMJ', '1', 'LMJ') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountTotal(Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), $icno, 'THBLMT', '1', 'LMT') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountTotal(Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), $icno, 'THBKWLN', '1', 'KWLN') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountCutiRehat($icno, $v, $yearend) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countCSakit1($icno, $v, $yearend) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountTotalTHTC(Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), $icno, 'CTR', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountTotalTHTC(Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), $icno, 'CGKA', '1') ?></td>
                                <th colspan="1" class="text-center"></th>
                                <th colspan="1" class="text-center"><?= TblRollcall::totalCGanti($icno, Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end')) ?></th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountTotalTHTC(Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), $icno, 'THTC', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountTotal(Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), $icno, 'THH', '1', 'H') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountTotal(Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), $icno, 'THLMJ', '1', 'LMJ') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountTotal(Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), $icno, 'THLMT', '1', 'LMT') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountTotal(Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end'), $icno, 'THKWLN', '1', 'KWLN') ?></td>
                                <th colspan="1" class="text-center"></th>
                                <th colspan="1" class="text-center"></th>

                                <td class="text-center" style="text-align:center"><?= TblTindakanBertulisLisan::CountTotalTl($icno, Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblTindakanBertulisLisan::CountTotalTb($icno, Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end')) ?></td>

                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountTotalSts($icno, Yii::$app->getRequest()->getQueryParam('date_start'), Yii::$app->getRequest()->getQueryParam('date_end')) ?></td>
                                <th colspan="1" class="text-center">-</th>


                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php } ?>