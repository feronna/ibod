<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWfhReason;
use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;

$this->title = 'Permohonan Bekerja dari Rumah / Work from Home';
?>
<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-home"></i>&nbsp;<strong><?= Html::encode($this->title) ?></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
        <?= $form->errorSummary($model); ?>


        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'wfh_reason_id'); ?>
                <!-- <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Lokasi Aduan/Kejadian"></i> -->
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12">
                <?php // Usage with ActiveForm and model
                echo $form->field($model, 'wfh_reason_id')->widget(Select2::class, [
                    'data' => ArrayHelper::map(RefWfhReason::find()->all(), 'id', 'reason'),
                    'options' => ['placeholder' => '-- PILIH SEBAB / ALASAN --'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);

                ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;<?php echo Html::activeLabel($model, 'full_date'); ?>
                <!-- <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Bercuti start_date to end_date"></i> -->
            </label>

            <div class="col-md-4 col-sm-4 col-xs-10">
                <?php
                echo $form->field($model, 'full_date', [
                    'addon' => ['prepend' => ['content' => '<i class="fa fa-calendar"></i>']],
                    'options' => ['class' => 'drp-container'],
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
                        'opens' => 'left',
                    ],
                    'pluginEvents' => [
                        'apply.daterangepicker' => 'function(ev, picker) {
                            if($(this).val() == "") {
                                picker.callback(picker.startDate.clone(), picker.endDate.clone(), picker.chosenLabel);
                            }
                        }',
                    ],
                ]);
                ?>

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'remark'); ?>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan / Sebab / Sila Letakkan nama anak jika PML ditutup"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'remark')->textarea(['rows' => '6'])->label(false); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'file'); ?></label>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                echo $form->field($model, 'file', ['enableAjaxValidation' => false])->label(false)->widget(FileInput::class, [
                    'options' => [
                        'accept' => ['image/*'],
                    ],
                    'pluginOptions' => [
                        'showUpload' => false
                    ],

                ]);
                ?>
            </div>
            <?= Html::error($model, 'file'); ?>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
            <p>Attachment *Only images (jpg, jpeg, png) is allowed (Max upload: 2MB)</p>
            <div class="col-md-4 col-sm-4 col-xs-12">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'app_by'); ?>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Sila Pastikan Ketua Jabatan adalah terkini, sila berhubung dengan penyelia rekod sekiranya ketua jabatan belum dikemaskini"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo ($model_department->chief == $icno) ? $model_set_pegawai->pelulus->CONm : $model_department->k_jabatan->CONm ?>" disabled="true">
                <?= $form->field($model, 'app_by')->hiddenInput(['value' => $kj_icno])->label(false); ?>
            </div>
        </div>

        <div class="ln_solid"></div>


        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>