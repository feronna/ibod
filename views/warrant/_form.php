<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\warrant\TblJawatan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-jawatan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'jawatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gred')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jumlah_waran')->textInput() ?>

    <?= $form->field($model, 'kategori')->textInput() ?>

    <?= $form->field($model, 'kumpkhidmat_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
