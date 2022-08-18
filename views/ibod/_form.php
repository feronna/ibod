<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ibod\Ibod */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ibod-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'icno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lpu_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lpu_position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lpu_start_date')->textInput() ?>

    <?= $form->field($model, 'lpu_end_date')->textInput() ?>

    <?= $form->field($model, 'lpu_entry_date')->textInput() ?>

    <?= $form->field($model, 'updated_date')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isActive')->textInput() ?>

    <?= $form->field($model, 'attachment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'catatan')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
