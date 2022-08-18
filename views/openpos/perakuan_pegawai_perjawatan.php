<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>
<h2>Keputusan Mesyuarat</h2>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Status Perakuan <span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-6">
        <?=
        $form->field($model, 'status')->label(false)->widget(Select2::classname(), [
            'data' => ['VERIFIED' => 'PERMOHONAN DISAHKAN', 'REJECTED' => 'PERMOHONAN DITOLAK'],
            'options' => ['placeholder' => 'Pilih Perakuan', 'class' => 'form-control col-md-7 col-xs-12',
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
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan Perakuan <span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?= $form->field($model, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
    </div>
</div>
<div class="ln_solid"></div>

<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <button class="btn btn-primary" type="reset">Reset</button>
        <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
    </div>
</div>
</div>
</div>
<?php ActiveForm::end(); ?>

<!--form-->


