<?php

use yii\helpers\Html;
use app\models\kehadiran\TblWarnaKad;
use yii\bootstrap\ActiveForm;
use app\models\kehadiran\TblYears;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-search"></i>&nbsp;Search Criteria</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['action' => ['senarai-warna-kad'], 'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => 1]]); ?>
                <?php if ($isAdmin) { ?>
                    <div class="form-group nama">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">JFPIB
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <?= Select2::widget([
                                'name' => 'dept_id',
                                'value' => $dept_id,
                                // 'attribute' => 'state_2',
                                'data' => ArrayHelper::map($model_dept, 'id', 'fullname'),
                                'options' => ['placeholder' => 'SELECT JFPIB'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>

                        </div>
                    </div>
                <?php } ?>


                <div class="form-group nama">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Year
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= Html::dropDownList('year', $year, ArrayHelper::map(TblYears::findAll(['status' => 1]), 'year', 'year'), ['class' => 'form-control col-md-1 col-sm-1 col-xs-12', 'id' => 'tahun']); ?>
                    </div>
                </div>
                <div class="form-group nama">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Month
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= Html::dropDownList('month', $month, ['01' => 'January', '02' => 'February', '03' => 'Mac', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12', 'id' => 'bulan']); ?>
                    </div>
                </div>

                <div class="ln_solid"></div>

                <div class="form-group">
                    <!--<div class="pull-right">-->
                    <?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;Search', ['class' => 'btn btn-success']) ?>
                    <?= Html::a('<i class="fa fa-print"></i> Print', ['kehadiran/senarai-warna-kad-print', 'year' => $year, 'month' => $month], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                    <!--</div>-->
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
                <h2><strong>Senarai Kakitangan Dibawah Seliaan Anda.</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th class="text-center">Bil</th>
                            <th class="text-center">Nama Kakitangan</th>
                            <th class="text-center">Gred Jawatan</th>
                            <th class="text-center">Ketidakpatuhan</th>
                            <th class="text-center">Diterima</th>
                            <th class="text-center">Tidak Diterima</th>
                            <th class="text-center">Warna Kad</th>
                        </tr>
                        <?php if ($warnakad_model) { ?>
                            <?php foreach ($warnakad_model as $senarai) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center"><?php echo $bil++ ?></td>
                                    <td><?php echo $senarai->kakitangan->CONm; ?></td>
                                    <td><?php echo $senarai->kakitangan->jawatan->fname; ?></td>
                                    <td class="text-center"><?php echo $senarai->ketidakpatuhan; ?></td>
                                    <td class="text-center"><?php echo $senarai->approved; ?></td>
                                    <td class="text-center"><?php echo $senarai->disapproved; ?></td>
                                    <td class="text-center">
                                        <div class="tile-stats" style="width:auto; height: 25px; padding:0px;background-color:  <?= $senarai->color ?>">
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="7" class="align-center text-center"><i>-- Tiada rekod --</i></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>