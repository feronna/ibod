<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\cbelajar\TblUrusMesyuarat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-urus-mesyuarat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kali_ke')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tarikh_mesyuarat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_mesyuarat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'masa_mesyuarat')->textInput() ?>

    <?= $form->field($model, 'tempat_mesyuarat')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
