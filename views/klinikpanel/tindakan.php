<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\number\NumberControl;
?>

<?php $form = ActiveForm::begin(['id' => 'tindakan','options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="form-group">

    <div class="form-group">
        <label class="control-label col-md-6 col-sm-6 col-xs-12"><h3>TINDAKAN</h3>
        </label>
    </div>    
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">ENKUIRI<span class="required">*</span>
        </label>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <?= $form->field($model, 'enquiry')->textArea(['maxlength' => true, 'rows' => 2, 'disabled' => true])->label(false); ?>
            </div>
    </div>
    <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">STATUS ENKUIRI <span class="required">*</span>
    </label>
    <div class="col-md-4 col-sm-6 col-xs-12">
            <?=
        $form->field($model, 'status')->label(false)->widget(Select2::classname(), [
            'data' => ['1' => 'SELESAI', '2' => 'DALAM TINDAKAN SEMAKAN'],
            'options' => ['placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12',
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
        <label class="control-label col-md-3 col-sm-3 col-xs-3">CATATAN<span class="required">*</span>
        </label>
        <div class="col-md-4 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'remark')->textArea(['maxlength' => true, 'rows' => 2])->label(false); ?>
                       </div>
                       </div>

<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <button class="btn btn-primary" type="reset">Reset</button>
        <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
    </div>
</div>
</div>
<?php ActiveForm::end(); ?>

<!--form-->


