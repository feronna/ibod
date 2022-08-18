<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\kehadiran\TblYears;
use yii\helpers\ArrayHelper;
?>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-search"></i>&nbsp;Search Criteria</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['action' => ['color-rpt'], 'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => 1]]); ?>



                <div class="form-group nama">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Year
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::findAll(['status' => 1]), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                    </div>
                </div>


                <div class="form-group nama">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Month
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= Html::dropDownList('month', $month, ['01' => 'January', '02' => 'February', '03' => 'Mac', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12', 'id' => 'bulan']); ?>
                    </div>
                </div>
                <div class="form-group nama">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Color Card
                    </label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?= Html::dropDownList('color', $color, ['YELLOW' => 'Yellow', 'GREEN' => 'Green', 'RED' => 'Red'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-6', 'id' => 'color']); ?>

                    </div>
                </div>

                <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="pull-right">
                        <?= Html::a('<i class="fa fa-print"></i> Print', ['kehadiran/color-rpt-print', 'color' => $color, 'month' => $month, 'tahun' => $tahun], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                        <?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;Search', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Search Results : <?= $total ?> records </h2>
                <div class="pull-right" style="margin : 0px ;width:50px; height: 30px; background-color:  <?= $color; ?>"></div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-bordered table-info table-condensed table-hover table-striped jambo_table">
                        <thead>
                            <tr class="headings">
                                <th>#</th>
                                <th>Name</th>
                                <th>Lanitkan</th>
                                <th>JFPIB</th>
                                <th>Position</th>
                                <th>Kategori</th>
                                <th>Ketidakpatuhan</th>
                                <th>Approved</th>
                                <th>Disapproved</th>
                                <!--                                <th>Month</th>
                                <th>Color</th>-->
                                <th>Surat</th>
                                <th>Lampiran</th>
                                <th>Laporan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($model as $rows) { ?>
                                <tr>
                                    <td><?= $bil++ ?></td>
                                    <td><?= $rows->kakitangan->CONm; ?></td>
                                    <td><?= str_replace("Lantikan", "", $rows->kakitangan->statusLantikan->ApmtStatusNm); ?></td>
                                    <td class="text-center"><?= $rows->kakitangan->department->shortname; ?></td>
                                    <td><?= $rows->kakitangan->jawatan->fname; ?></td>
                                    <td><?= $rows->kakitangan->jawatan->shortCat; ?></td>
                                    <td class="text-center"><?= $rows->ketidakpatuhan; ?></td>
                                    <td class="text-center"><?= $rows->approved; ?></td>
                                    <td class="text-center"><?= $rows->disapproved; ?></td>
                                    <td class="text-center"><?= Html::a('<i class="fa fa-envelope">', ["kehadiran/letter", 'id' => md5($rows->icno), 'tahun' => 2019, 'bulan' => $month, 'color' => $color], ['target' => '_blank']); ?></td>
                                    <td class="text-center"><?= Html::a('<i class="fa fa-file-text-o">', ["kehadiran/print-lampiran", 'id' => md5($rows->icno), 'tahun' => 2019, 'bulan' => $monthBefore], ['target' => '_blank']); ?></td>
                                    <td class="text-center"><?= Html::a('<i class="fa fa-flag">', ["kehadiran/report", 'id' => $rows->icno, 'tahun' => 2019, 'bulan' => $monthBefore], ['target' => '_blank']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>