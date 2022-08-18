<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombor Rujukan<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?= $form->field($model, 'no_rujukan')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-3">Tarikh Mesyuarat<span class="required">*</span>
    </label>
    <div class="col-md-3 col-md-3 col-sm-3 col-sm-3 col-xs-6">
        <?=
DatePicker::widget([
    'model' => $model,
    'attribute' => 'tarikh_m',
    'template' => '{input}{addon}',
    'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
    'clientOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd'
    ]
]);
?>
    </div>
</div>
<div class="ln_solid"></div>

<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <button class="btn btn-primary" type="reset">Reset</button>
        <?= Html::submitButton('Hantar', ['class' => 'btn btn-success','url' => ['openpos/s_permohonan_individu']]) ?>
    </div>
</div>
</div>
</div>
<?php ActiveForm::end(); ?>

<!--form-->


