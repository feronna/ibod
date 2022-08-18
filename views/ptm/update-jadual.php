<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;

error_reporting(0);

$this->title = 'Tetapan Jadual PTM';
?>
<style>
    fieldset.scheduler-border {
        border: 1px groove #1F9935 !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow: 0px 0px 0px 0px #000;
        box-shadow: 0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        width: inherit;
        /* Or auto */
        padding: 0 10px;
        /* To give a bit of padding on the left and right */
        border-bottom: none;
    }

    .table td,
    .table th {
        font-size: 12px;
    }
</style>
<?php echo $this->render('a_menu_admin') ?>
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

        <p>
            <?= Html::a('Kembali', ['tetapan-jadual'], ['class' => 'btn btn-primary']) ?>
        </p>

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
        <?= $form->errorSummary($model); ?>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'siri'); ?>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan / Sebab / Sila Letakkan nama anak jika PML ditutup"></i>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-10">
                <?= $form->field($model, 'siri')->textarea(['rows' => '1'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;<?php echo Html::activeLabel($model, 'full_dt'); ?>
            </label>

            <div class="col-md-4 col-sm-4 col-xs-10">
                <?php
                echo $form->field($model, 'full_dt', [
                    'addon' => ['prepend' => ['content' => '<i class="fa fa-calendar"></i>']],
                    'options' => ['class' => 'drp-container'],
                    'showLabels' => false,
                ])->widget(DateRangePicker::classname(), [
                    'useWithAddon' => true,
                    'startAttribute' => 'start_dt',
                    'endAttribute' => 'end_dt',
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'tempat'); ?>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top"></i>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-10">
                <?= $form->field($model, 'tempat')->textarea(['rows' => '3'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'entry_by'); ?>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top"></i>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-10">
                <?= $form->field($model->entry, 'CONm')->textarea(['disabled' => TRUE])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'entry_dt'); ?>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top"></i>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-10">
                <?= $form->field($model, 'entry_dt')->textarea(['disabled' => TRUE])->label(false); ?>
            </div>
        </div>

        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::a('Padam', ['delete-jadual', 'id' => $model->siri_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Anda pasti ingin memadam rekod ini?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Kemaskini', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>




</div>