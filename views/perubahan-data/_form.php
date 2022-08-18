<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\updatestatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="updatestatus-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'usern')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'COTableName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'COActivity')->textInput() ?>

    <?= $form->field($model, 'COUpadteDate')->textInput() ?>

    <?= $form->field($model, 'COUpdateIP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'COUpdateComp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'COUpdateCompUser')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'COUpdateSQL')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'idval')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
