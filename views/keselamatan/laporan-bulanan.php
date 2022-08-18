<?php

use yii\helpers\Html;
use app\models\keselamatan\TblRekod;
use app\models\keselamatan\TblRollcall;
use app\widgets\TopMenuWidget;
use yii\helpers\Url;
use app\models\kehadiran\TblYears;
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

                <?= Html::beginForm(['laporan-bulanan', 'id' => Yii::$app->getRequest()->getQueryParam('id')], 'GET'); ?>


                <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::find()->all(), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::dropDownList('bulan', $bulan, ['01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
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
                <?= Html::a('<i class="fa fa-print"></i> Kehadiran Hakiki', ['keselamatan/report', 'id' => $icno, 'tahun' => $tahun, 'bulan' => $bulan], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                <?= Html::a('<i class="fa fa-print"></i> Kehadiran Lebih Masa Jadual', ['keselamatan/report-ot', 'id' => $icno, 'tahun' => $tahun, 'bulan' => $bulan], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>

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
                            <div class="row ">
                                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tahun:</b></div>
                                <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $tahun ?></div>
                                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Bulan:</b></div>
                                <div class="col-lg-4 col-sm-6 col-xs-6 text-left "><?= TblRekod::viewBulan($bulan) ?></div>
                            </div>
                            <div class="row ">
                                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Warna Kad:</b></div>
                                <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><input type="text" id="tblrekod-tarikh" style="background-color:<?= $warna_kad; ?>;" class="form-control col-md-2 col-sm-2 col-xs-12" name="TblRekod[tarikh]" value="<?= $warna_kad; ?>" disabled=""></div>
                                <!--                                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Pos Kawalan:</b></div>
                                <div class="col-lg-4 col-sm-6 col-xs-6 text-left " ><?= TblRekod::viewBulan($bulan) ?></div>-->
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
                    <h2><strong><i class="fa fa-list"></i> Laporan Bulanan</strong></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="2" class="text-center"></th>
                                    <th colspan="4" class="text-center">Syif</th>
                                    <th colspan="4" class="text-center">Catatan/KeHadiran</th>
                                    <th colspan="2" class="text-center"></th>
                                </tr>
                                <tr class="headings">
                                    <th class="text-center">Hari</th>
                                    <th class="text-center">Tarikh</th>
                                    <th class="text-center">Hakiki</th>
                                    <th class="text-center">LMJ</th>
                                    <th class="text-center">LMT</th>
                                    <th class="text-center">Kawalan</th>
                                    <th class="text-center">Hakiki</th>
                                    <th class="text-center">LMJ</th>
                                    <th class="text-center">LMT</th>
                                    <th class="text-center">Kawalan</th>
                                    <th colspan="2" class="text-center">Catatan</th>

                                </tr>
                            </thead>
                            <?php foreach ($var as $k => $v) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::DisplayDay($v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= date("d/m/Y", strtotime($v)); ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::DisplayHakiki($icno, $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::DisplayLmj($icno, $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::DisplayLmt($icno, $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::DisplayKawalan($icno, $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::StatusHakiki($icno, $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::StatusLmj($icno, $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::StatusLmt($icno, $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::StatusKawalan($icno, $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::catatan($icno, $v) ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th colspan="5" class="text-center">Jumlah</th>
                                <th colspan="1" class="text-center">H</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'THBH', '0') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'THBLMJ', '0') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'THBLMT', '0') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'THBKWLN', '0') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">THB</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'THBH', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'THBLMJ', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'THBLMT', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'THBKWLN', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">THTC</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'THTC', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'THTC', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'THTC', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'THTC', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <!--                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">THTC</th>
                                <td class="text-center"  style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'THTC', '1') ?></td>
                                <td class="text-center"  style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'THTC', '1') ?></td>
                                <td class="text-center"  style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'THTC', '1') ?></td>
                                <td class="text-center"  style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'THTC', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>-->
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">CR</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'CR', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'CR', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'CR', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'CR', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">CS</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'CS', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'CS', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'CS', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">CK</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'CK', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'CK', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'CK', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'CK', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">CTR</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'CTR', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'CTR', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'CTR', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'CTR', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">CGKA</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'CGKA', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'CGKA', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'CGKA', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'CGKA', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">CKA</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'CKA', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'CKA', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'CKA', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'CKA', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">CG</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'CG', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'CG', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'CG', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'CG', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">CSG</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'CSG', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'CSG', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'CSG', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'CSG', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">CTG</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'CTG', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'CTG', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'CTG', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'CTG', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">STS
                                    <?= Html::button('', ['id' => 'modalButton', 'value' => Url::to(['list-sts', 'id' => Yii::$app->getRequest()->getQueryParam('id'), 'month' => Yii::$app->getRequest()->getQueryParam('bulan'), 'year' => Yii::$app->getRequest()->getQueryParam('tahun')]), 'class' => 'fa fa-eye mapBtn']); ?></th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'status', 'STS') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'status', 'STS') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'status', 'STS') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'status', 'STS') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                        </table>
                    </div>

                    <?= Html::a('<i class="fa fa-print"></i> Print', ['keselamatan/report-bulanan', 'id' => Yii::$app->getRequest()->getQueryParam('id'), 'tahun' => Yii::$app->getRequest()->getQueryParam('tahun'), 'bulan' => Yii::$app->getRequest()->getQueryParam('bulan')], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>