<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\TblRekod;
use yii\helpers\Url;
use app\models\kehadiran\TblYears;
?>


<!--<div class="col-md-12">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['site/index']) ?></li>
        <li><?= Html::a('Tindakan Individu', ['site/index']) ?></li>
        <li><?= Html::a('Kehadiran', ['kehadiran/index']) ?></li>
        <li><?= Html::a('Senarai Staf Seliaan', ['kehadiran/senarai_kakitangan']) ?></li>
        <li>Laporan Kehadiran</li>
    </ol>
</div>-->

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Search</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['laporan_kehadiran', 'id' => $icno], 'GET'); ?>


                <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::findAll(['status'=>1]), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
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
                    <h2><strong><i class="fa fa-users"></i> Staff's detail</strong></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form id="w0" class="form-horizontal form-label-left" action="/basic/web/index.php?r=kehadiran%2Fremark&amp;id=51" method="post">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group field-tblrekod-tarikh">

                                    <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $biodata->CONm ?>" disabled="">

                                    <div class="help-block"></div>
                                </div>                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Position
                            </label>
                            <div class="col-md-5 col-sm-6 col-xs-12">
                                <div class="form-group field-tblrekod-tarikh">

                                    <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $biodata->jawatan->fname ?>" disabled="">


                                    <div class="help-block"></div>
                                </div>                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">J / F / P / I / U
                            </label>
                            <div class="col-md-5 col-sm-6 col-xs-12">
                                <div class="form-group field-tblrekod-tarikh">

                                    <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $biodata->department->fullname ?>" disabled="">


                                    <div class="help-block"></div>
                                </div>                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Year
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group field-tblrekod-tarikh">

                                    <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $tahun ?>" disabled="">


                                    <div class="help-block"></div>
                                </div>                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Month
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group field-tblrekod-tarikh">

                                    <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= TblRekod::viewBulan($bulan) ?>" disabled="">


                                    <div class="help-block"></div>
                                </div>                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Card Colour Status
                            </label>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <div class="form-group field-tblrekod-tarikh">

                                    <input type="text" id="tblrekod-tarikh" style="background-color:<?= $warna_kad; ?>;" class="form-control col-md-2 col-sm-2 col-xs-12" name="TblRekod[tarikh]" value="<?= $warna_kad; ?>" disabled="">


                                    <div class="help-block"></div>
                                </div>                
                            </div>
                        </div>

                    </form>



                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-list"></i> Attendance Report</strong></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">



                    <div style='border: solid red; border-style: dashed; padding-left: 15px'>
                        <h5><strong>Monthly Summary</strong></h5>
                        <p>
                            Working day(Completed) : <strong><?php echo TblRekod::TotalWorkingHours($icno, $bulan,$tahun, 2) ?></strong>&nbsp;
                            Working Hours : <strong><?php echo TblRekod::TotalWorkingHours($icno, $bulan, $tahun) ?></strong>&nbsp;
                            Late In : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan, $tahun, 1) ?></strong>&nbsp;
                            Early Out : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan,$tahun, 2) ?></strong>&nbsp;
                            Incomplete : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan, $tahun,3) ?></strong>&nbsp;
                            Absent : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan, $tahun,4) ?></strong>&nbsp;
                            External : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan,$tahun, 5) ?></strong>&nbsp;
                        </p>
                    </div>
                    <br>
                    <div style='padding: 15px;' class="table-bordered">
                        <font>[ &#10004; ]</font> : Remarked&nbsp;&nbsp;&nbsp;&nbsp;
                        <font color="white" style="background-color:green;">[ &#10004; ]</font> : Remark has been Approved &nbsp;&nbsp;&nbsp;&nbsp;
                        <font style="color:red">[ &#x2716; ]</font> : No Remark / Remark not approved
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Day</th>
                                    <th class="text-center">WBB</th>
                                    <th class="text-center">In</th>
                                    <th class="text-center">Out</th>
                                    <th class="text-center">Non-compliance status</th>
                                    <th class="text-center">Leave/Outstation</th>
                                    <th class="text-center">Working Hours<br>[h:m]</th>
                                    <th class="text-center">Remark ?</th>
                                    <th class="text-center">Location</th>
                                    <th class="text-center">Details</th>
                                </tr>
                            </thead>
                            <?php foreach ($var as $k => $v) { ?>
                                <tr>
                                    <td class="text-center"  style="text-align:center"><?= date("d/m/Y", strtotime($v)); ?></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayDay($v) ?></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayWbb($icno, $v) ?></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayTime($icno, $v, 1) ?></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayTime($icno, $v, 2) ?></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayTime($icno, $v, 5) ?></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayCuti($icno, $v) ?></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayHours($icno, $v) ?></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekod::RemarkStatus($icno, $v) ?></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayLoc($icno, $v) ?></td>
                                    <td class="text-center"  style="text-align:center"><?= (TblRekod::DisplayWbb($icno, $v) != '-') ? Html::button('<i class="fa fa-eye"></i>', ['value' => Url::to(['kehadiran/detailrekod', 'icno' => $icno, 'tarikh' => $v]), 'class' => 'mapBtn', 'id' => 'modalButton']) : ''; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>

                    <?= Html::a('<i class="fa fa-print"></i> Print', ['kehadiran/report', 'id' => $icno, 'tahun' => $tahun, 'bulan' => $bulan], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
