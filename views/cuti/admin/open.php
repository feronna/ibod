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
?>
<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-plane"></i>&nbsp;<strong>Buka Permohonan GCR dan CBTH</i></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>
        <?= $form->errorSummary($model); ?>

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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan / <i><?= Html::activeLabel($model, 'remark'); ?></i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'remark')->textarea(['rows' => 4])->label(false); ?>
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