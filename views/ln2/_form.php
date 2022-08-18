<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ln\Ln2 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ln2-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lulus_date')->textInput() ?>

    <?= $form->field($model, 'date_from')->textInput() ?>

    <?= $form->field($model, 'jfpib')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ICNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tujuan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tempat')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pembiayaan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kod_peruntukan')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
