<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use app\models\cuti\Layak;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\cuti\SetPegawai;
use yii\bootstrap\Modal;
use yii\helpers\Url;

//english title
$this->title = $model_jenis->jenis_cuti_catatan . ' (' . $model_jenis->jenis_cuti_nama . ')';
?>
<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-plane"></i>&nbsp;<strong>(<?= $model_jenis->jenis_cuti_nama ?>)&nbsp;<?= $model_jenis->jenis_cuti_catatan ?>/<i><?= $model_jenis->jenis_cuti_catatan_bi ?></i></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>
        <?= $form->errorSummary($model); ?>
        <p style="color: green">*Sila berhubung dengan <strong>Penyelia Cuti</strong> jabatan anda sekiranya anda mengalami sebarang masalah untuk memohon cuti / <i>Please contact your department's <strong>Leave Supervisor</strong> if your experience any difficulties </i></p>

        <div class="form-group">
            <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Tarikh Bercuti (Mula - Tamat) / <i><?php echo Html::activeLabel($model, 'full_date'); ?></i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Bercuti start_date to end_date"></i>
            </label>

            <div class="col-md-4 col-sm-4 col-xs-10">
                <?php
                echo $form->field($model, 'full_date', [
                    'addon' => ['prepend' => ['content' => '<i class="fa fa-calendar"></i>']],
                    'options' => [
                        'class' => 'drp-container',
                        'autocomplete' => 'off'
                    ],
                    'showLabels' => false,
                ])->widget(DateRangePicker::classname(), [
                    'useWithAddon' => true,
                    'startAttribute' => 'start_date',
                    'endAttribute' => 'end_date',
                    'convertFormat' => true,
                    'readonly' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'd/m/Y',
                            'separator' => ' to '
                        ],
                        // 'ranges' => [ Yii::t('kvdrp', "Today") => ["moment().utc().startOf('day')", "moment().utc().endOf('day')"]],
                        'opens' => 'left',
                    ],
                    'pluginEvents' => [
                        'apply.daterangepicker' => 'function(ev, picker) {
                            if($(this).val() == "") {
                                picker.callback(picker.startDate.clone(), picker.endDate.clone(), picker.chosenLabel);
                            }
                        }',
                    ]

                ]);
                ?>


            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <?= Html::button('<i class="fa fa-search"></i>  ', ['value' => Url::to(['cuti/individu/leave-list']), 'class' => 'mapBtn btn btn-success']); ?> </div>

        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Pengganti/<i><?= Html::activeLabel($model, 'ganti_by'); ?></i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pengganti"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                $form->field($model, 'ganti_by')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map($staff_list, 'ICNO', 'CONm'),
                    'options' => ['placeholder' => 'Pilih Pengganti', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>

        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan / <i><?= Html::activeLabel($model, 'remark'); ?></i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'remark')->textarea(['rows' => 4])->label(false); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Peraku /<i><?= Html::activeLabel($model, 'peraku_by'); ?></i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pengawai Memperaku Cuti"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo SetPegawai::DisplayPeraku($icno) ?>" disabled="true">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Pelulus /<?= Html::activeLabel($model, 'lulus_by'); ?></i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pegawai Meluluskan Cuti"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo SetPegawai::DisplayPelulus($icno) ?>" disabled="true">
                <p style="color: green">*Sila berhubung dengan <strong>Penyelia Cuti</strong> anda jika terdapat perubahan bagi pegawai <strong>memperaku/melulus</strong></p>
                <span><u><a href="<?php echo Url::to('@web/'.'uploads/Borang Permohonan Cuti Rehat Melebihi 14 Hari Berterusan.pdf', true); ?>" target="_blank" ></u><i class="fa fa-download">   Borang Permohonan Cuti Rehat Melebihi 14 Hari Berterusan</i></span>

            </div>
        </div>
        <div class="form-group">

        </div>

        <div class="ln_solid"></div>


        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Back', ['cuti/individu/pilih'], ['class' => 'btn btn-warning']) ?>
                <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>