<?php

use yii\helpers\Html;

use app\models\kehadiran\TblYears;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\kehadiran\RefWp;
use dosamigos\datepicker\DatePicker;
use app\models\keselamatan\TblRekodOt;
use app\models\keselamatan\TblRekodPegMedan;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
?>

<?=
TopMenuWidget::widget(['top_menu' => [61,67,208,209,210], 'vars' => [
        ['label' => ''],
//    ['label' => app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId())]
]]);
?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Search</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['laporan-pegawai', 'id' => $icno], 'GET'); ?>


                <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::find()->all(), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::dropDownList('bulan', $bulan, ['01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                <!--<a href="#" class ='btn btn-warning'><i class="fa fa-print"></i> Cetak Laporan</a>-->
                <?= Html::a('<i class="fa fa-print"></i> Print', ['keselamatan/report', 'id' => $icno, 'tahun' => $tahun, 'bulan' => $bulan], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
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
                                <div class="form-group field-tblrekodot-tarikh">

                                    <input type="text" id="tblrekodot-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekodOt[tarikh]" value="<?= TblRekodOt::viewBulan($bulan) ?>" disabled="">


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
                            Working day(Completed) : <strong><?php echo TblRekodPegMedan::TotalWorkingHours($icno, $bulan, 2) ?></strong>&nbsp;
                            Working Hours : <strong><?php echo TblRekodPegMedan::TotalWorkingHours($icno, $bulan) ?></strong>&nbsp;
                            Late In : <strong><?= TblRekodPegMedan::countKetidakpatuhan($icno, $bulan, 1) ?></strong>&nbsp;
                            Early Out : <strong><?= TblRekodPegMedan::countKetidakpatuhan($icno, $bulan, 2) ?></strong>&nbsp;
                            Incomplete : <strong><?= TblRekodPegMedan::countKetidakpatuhan($icno, $bulan, 3) ?></strong>&nbsp;
                            Absent : <strong><?= TblRekodPegMedan::countKetidakpatuhan($icno, $bulan, 4) ?></strong>&nbsp;
                            External : <strong><?= TblRekodPegMedan::countKetidakpatuhan($icno, $bulan, 5) ?></strong>&nbsp;
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
<!--                                    <th class="text-center">WBB</th>-->
                                    <th class="text-center">In</th>
                                    <th class="text-center">Out</th>
                                    <th class="text-center">Non-compliance status</th>
                                    <th class="text-center">Leave/Outstation</th>
                                    <th class="text-center">Working Hours<br>[h:m]</th>
                                    <th class="text-center">Remark ?</th>
                                    <th class="text-center">Location</th>
                                    <!--<th class="text-center">Details</th>-->
                                </tr>
                            </thead>
                            <?php foreach ($var as $k => $v) { ?>
                                <tr>
                                    <td class="text-center"  style="text-align:center"><?= date("d/m/Y", strtotime($v)); ?></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekodPegMedan::DisplayDay($v) ?></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekodPegMedan::DisplayTime($icno, $v, 1) ?></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekodPegMedan::DisplayTime($icno, $v, 2) ?></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekodPegMedan::DisplayTime($icno, $v, 5) ?></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekodPegMedan::DisplayCuti($icno, $v) ?></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekodPegMedan::DisplayHours($icno, $v) ?></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekodPegMedan::RemarkStatus($icno, $v) ?></td>
                                    <td class="text-center"  style="text-align:center"><?= TblRekodPegMedan::DisplayLoc($icno, $v) ?></td>
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
