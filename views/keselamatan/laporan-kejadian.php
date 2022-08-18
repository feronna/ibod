<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use dosamigos\datepicker\DatePicker;
use kartik\widgets\DatePicker;
?>


<!--<div class="col-md-12"> -->
<div class="x_panel">
    <div class="x_title">
        <h2><strong>Ringkasan Laporan Harian</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
        <div class="form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="date">Tarikh <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
              DatePicker::widget([
                'name' => 'check_date',
                'value' => Yii::$app->getRequest()->getQueryParam('tarikh'),
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12">Pilih Syif :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                $form->field($model, 'syif')->label(false)->widget(Select2::classname(), [
                    'data' => ['A' => 'Syif A', 'B' => 'Syif B', 'C' => 'Syif C'],
                    'options' => ['placeholder' => 'Pilih Syif', 'class' => 'form-control col-md-7 col-xs-12',
                        'onchange' => 'javascript:if ($(this).val() == "Dipersetujui"){
                        $("#tempoh").show();
                        }
                        else{
                        $("#tempoh").hide();
                        }'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12">Ulasan DO:
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'laporan')->textarea(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Hantar', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please Wait.. ']]) ?>
                <button class="btn btn-primary" type="reset">Reset</button>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

        <br>

    </div>
</div>
<!--</div>-->
