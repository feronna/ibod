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
use app\models\patrol\RefBit;
use app\models\patrol\Rekod;
use kartik\rating\StarRating;


?>
<?= $this->render('/patrol/_menu') ?>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Carian</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['monthly-report', 'id' => $icno], 'GET'); ?>


                <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::findAll(['status' => 1]), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::dropDownList('bulan', $bulan, ['01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                <!--<a href="#" class ='btn btn-warning'><i class="fa fa-print"></i> Cetak Laporan</a>-->
                <?= Html::a('<i class="fa fa-print"></i> Print', ['kehadiran/report', 'id' => $icno, 'tahun' => $tahun, 'bulan' => $bulan], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
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
                                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Rating:</b></div>
                                <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?php echo StarRating::widget([
                                    'name' => 'rating_21',
                                    'value' => PatrolRating::rating($icno, $tahun,$bulan),
                                    'pluginOptions' => [
                                        'readonly' => true,
                                        'showClear' => false,
                                        'showCaption' => false,
                                    ],
                                ]); ?></div>

                                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tempoh Lantikan:</b></div>
                                <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $biodata->tblrscoapmtstatus->ApmtStatusStDt ?> hingga <?= $biodata->tblrscoapmtstatus->ApmtStatusEndDt ?></div>

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
                                    <th colspan="4" class="text-center"></th>
                                    <th colspan="3" class="text-center">Syif</th>
                                    <th colspan="3" class="text-center">Jumlah Rondaan</th>
                                </tr>
                                <tr class="headings">
                                    <th class="text-center">Tarikh</th>
                                    <th class="text-center">Hari</th>
                                    <th class="text-center">Status Cuti</th>
                                    <th class="text-center">Pos Bertugas</th>
                                    <th class="text-center">Hakiki</th>
                                    <th class="text-center">LMJ</th>
                                    <th class="text-center">LMT</th>
                                    <th class="text-center">Hakiki</th>
                                    <th class="text-center">LMJ</th>
                                    <th class="text-center">LMT</th>
                                </tr>
                            </thead>
                            <?php foreach ($var as $k => $v) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center"><?= date("d/m/Y", strtotime($v)); ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRekod::DisplayDay($v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRekod::DisplayCuti($icno, $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblShiftKeselamatan::viewPos($icno, $v) ?></td>

                                    <td class="text-center" style="text-align:center"><?= TblRollcall::DisplayHakiki($icno, $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::DisplayLmj($icno, $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::DisplayLmt($icno, $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= Rekod::countpatrol($icno, $v, Rekod::getSyif($icno, $v)) ?></td>
                                    <td class="text-center" style="text-align:center"><?= Rekod::countpatrol($icno, $v, Rekod::getSyifLmj($icno, $v)) ?></td>
                                    <td class="text-center" style="text-align:center"><?= Rekod::countpatrol($icno, $v, Rekod::getSyifLmt($icno, $v)) ?></td>

                                </tr>

                            <?php } ?>
                            <tr>
                                <td class="text-center" colspan="7" style="text-align:center">Jumlah Rondaan</td>
                                <td class="text-center" style="text-align:center"><?= Rekod::countpatrolmonthlyhakiki($icno, $bulan, $tahun) ?></td>
                                <td class="text-center" style="text-align:center"><?= Rekod::countpatrolmonthlylmj($icno, $bulan, $tahun) ?></td>
                                <td class="text-center" style="text-align:center"><?= Rekod::countpatrolmonthlylmt($icno, $bulan, $tahun) ?></td>
                            </tr>
                            <td class="text-center" colspan="7" style="text-align:center">Jumlah Penuh Rondaan</td>
                            <td class="text-center" style="text-align:center"><?= Rekod::patroltotalmonthly($icno, $var) ?></td>
                            <td class="text-center" style="text-align:center"><?= Rekod::patroltotalmonthlyLmj($icno, $var) ?></td>
                            <td class="text-center" style="text-align:center"><?= Rekod::patroltotalmonthlyLmt($icno, $var) ?></td>

                            </tr>
                            <tr>
                                <td class="text-center" colspan="7" style="text-align:center">Peratusan (%)</td>
                                <td class="text-center" colspan="1" style="text-align:center"><?= Rekod::percents($icno, $var, 3) ?></td>
                                <td class="text-center" colspan="1" style="text-align:center"><?= Rekod::percents($icno, $var, 2) ?></td>
                                <td class="text-center" colspan="1" style="text-align:center"><?= Rekod::percents($icno, $var, 1) ?></td>

                            </tr>
                        </table>
                    </div>

                    <?= Html::a('<i class="fa fa-print"></i> Print', ['kehadiran/report', 'id' => $icno, 'tahun' => $tahun, 'bulan' => $bulan], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>