<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
?>


<!--<div class="col-md-12"> -->
<div class="x_panel">
    <div class="x_title">
        <h2><strong>Masukkan Odometer</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

        <div class="form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12">No. Plate Kenderaan:
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'num_plate')->textInput()->input('num_plate', ['placeholder' => "Nombor Plate Tanpa Jarak CTH: SAB1234C"])->label(false); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12">Model Kenderaan:
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              
            <?=
                    $form->field($model, 'model_kenderaan')->label(false)->widget(Select2::classname(), [
                        'data' => ['1' => 'Administrator', '2' => 'Penyelia Unit', '3' => 'Pegawai', '4' => 'Penyelia Cuti', '5' => 'Penyelia Jadual','6'=>'KP/PKP','7'=>'Tadbir'],
                        'options' => ['placeholder' => 'Pilih Akses', 'class' => 'form-control col-md-7 col-xs-12',
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
            <label class="control-label col-md-4 col-sm-6 col-xs-12">Akhir Odometer:
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'end_odo')->textInput(['maxlength' => true, 'rows' => 4,'style'=>'text-transform:capitalize'])->label(false); ?>
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
