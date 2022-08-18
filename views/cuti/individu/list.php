<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

$this->title = 'Leave Application List';

?>

<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-search"></i>&nbsp;<strong>Carian/<i>Search</i></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php //var_dump($jenis_cuti); 
        ?>

        <?php $form = ActiveForm::begin(['action' => ['list'], 'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => 1]]); ?>


        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Cuti/<i><?php echo Html::activeLabel($model, 'jenis_cuti_id'); ?></i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Leave Type"></i>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12">


                <?= Html::dropDownList('year', $year, ArrayHelper::map($jenis_cuti, 'jenis_cuti_id', 'jenis_cuti_catatan'), ['class' => 'form-control col-md-1 col-sm-1 col-xs-12', 'id' => 'tahun']); ?>

            </div>

        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun/<i>Year</i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Year"></i>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12">

                <?= Html::dropDownList('year', $year, ArrayHelper::map($group_tahun, 'year', 'year'), ['class' => 'form-control col-md-1 col-sm-1 col-xs-12', 'id' => 'tahun']); ?>

            </div>

        </div>
        <div class="ln_solid"></div>

        <div class="form-group">
            <?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;Search', ['class' => 'btn btn-success']) ?>

        </div>

        <?php ActiveForm::end(); ?>


    </div>
</div>


<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-list"></i>&nbsp;<strong>Senarai Permohonan Cuti/<i><?= Html::encode($this->title) ?></i></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <table class="table table-bordered table-info table-condensed table-hover table-striped jambo_table">
            <thead>
                <tr class="headings">
                    <th>Bil</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Period</th>
                    <th class="text-center">Remark</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Details</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">File</th>
                    <th class="text-center">Upload</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($model1 as $rows) { ?>
                    <tr>
                        <td class="text-center"><?= $bil++ ?></td>
                        <td class="text-center"><?= $rows->jenisCuti->jenis_cuti_nama; ?></td>
                        <td class="text-center"><?= $rows->full_date; ?></td>
                        <td class="text-center"><?= $rows->tempoh; ?></td>
                        <td class="text-center"><?= $rows->remark; ?></td>
                        <td class="text-center"><?= $rows->status; ?></td>
                        <td class="text-center"><?= Html::button('<i class="fa fa-eye"></i>', ['value' => Url::to(['cuti/individu/leave-detail', 'id' => $rows->id]), 'class' => 'mapBtn', 'id' => 'modalButton']); ?></td>
                        <td class="text-center"> <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Sila Berhubung Dengan Penyelia Cuti Bagi Cuti Yang Telah Diperakukan atau Diluluskan / Please Contact Your Leave Supervisor For Leave Application That Has Been Verified Or Approved"></i></td>
                        <?php if ($rows->jenis_cuti_id == 28 && $rows->status == "APPROVED") { ?>
                            <td><?php echo Html::a('<i class="fa fa-download" aria-hidden="true"></i> SURAT', [
                                    'surat',
                                    // 'title' => 'Maternity',
                                    'id' => $rows->id
                                ], [
                                    'class' => 'btn btn-default',
                                    'target' => '_blank',
                                ]) . '<br/>'; ?></td>
                            <td> <a href="<?= Url::to(['cuti/individu/upload', 'id' => $rows->id]); ?>" class="fa fa-calendar-check-o"></a>
                            </td>
                        <?php } else { ?>
                            <td></td>
                            <td></td>
                        <?php } ?>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>