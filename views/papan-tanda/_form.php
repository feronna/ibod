<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\e_perkhidmatan\PapanTanda */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="papan-tanda-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'icno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tajuk')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tarikh_mula')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tarikh_hingga')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tempat')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'masa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ver_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ver_date')->textInput() ?>

    <?= $form->field($model, 'status_semakan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ulasan_semakan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'app_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'app_date')->textInput() ?>

    <?= $form->field($model, 'status_kj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ulasan_kj')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
