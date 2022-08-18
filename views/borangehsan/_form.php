<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\kemudahan\Borangehsan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="borangehsan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'icno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jeniskemudahan')->textInput() ?>

    <?= $form->field($model, 'pohon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tujuan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tarikh_mohon')->textInput() ?>

    <?= $form->field($model, 'status_pt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'catatan_pt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'semakan_pt')->textInput() ?>

    <?= $form->field($model, 'status_pp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'catatan_pp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ver_date')->textInput() ?>

    <?= $form->field($model, 'status_kj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'catatan_kj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'app_date')->textInput() ?>

    <?= $form->field($model, 'tarikh_terima')->textInput() ?>

    <?= $form->field($model, 'pengakuan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isActive')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
