<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\pengesahan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pengesahan-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <?= $form->field($model, 'tatatertib')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reason')->textarea(['rows' => 6]) ?>
   
    <p style="color: green">
                Sila pastikan maklumat permohonan adalah tepat sebelum klik hantar. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini
    </p>   
    
    <div class="ln_solid"></div>
    
    <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button class="btn btn-primary" type="reset">Reset</button>
                <?= Html::submitButton('Hantar Permohonan', ['class' => 'btn btn-success']) ?>
            </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
