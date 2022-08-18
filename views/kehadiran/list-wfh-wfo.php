<?php

use app\models\kehadiran\TblWfh;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\TblRekod;
use yii\helpers\Url;
use app\models\kehadiran\TblYears;
?>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Search</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['list-wfh-wfo', 'id' => $icno], 'GET'); ?>


                <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::findAll(['status'=>1]), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::dropDownList('bulan', $bulan, ['01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                <!--<a href="#" class ='btn btn-warning'><i class="fa fa-print"></i> Cetak Laporan</a>-->
                <?= Html::a('<i class="fa fa-print"></i> Print', ['kehadiran/list-wfh-wfo-print', 'id' => $icno, 'tahun' => $tahun, 'bulan' => $bulan], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
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

                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Day</th>
                                    <th class="text-center">WFO / WFH</th>
                                </tr>
                            </thead>
                            <?php foreach ($var as $k => $v) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center"><?= date("d/m/Y", strtotime($v)); ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRekod::DisplayDay($v, 'l') ?></td>
                                    <?php if (TblRekod::DisplayCuti($icno, $v)) { ?>
                                        <td class="text-center"
                                            style="text-align:center;background-color:"><?php echo TblRekod::DisplayCuti($icno, $v) ?>
                                        </td>

                                    <?php } else { ?>
                                        <td class="text-center"
                                            style="text-align:center;background-color:<?php echo (TblWfh::isWfh(date("Y-m-d", strtotime($v)), $icno) == 1) ? '#73D2BE' : '#73D2BE' ?>"><?php echo (TblWfh::isWfh(date("Y-m-d", strtotime($v)), $icno) == 1) ? 'WFH' : 'WFO' ?></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>

                    <?= Html::a('<i class="fa fa-print"></i> Print', ['kehadiran/list-wfh-wfo-print', 'id' => $icno, 'tahun' => $tahun, 'bulan' => $bulan], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
