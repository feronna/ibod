<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\e_perkhidmatan\Parkir */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parkir-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'icno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jenis_kenderaan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'no_pendaftaran_kenderaan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'jenama_kenderaan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'model_kenderaan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'warna_kenderaan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tarikh_meletakkan_kenderaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tarikh_pengambilan_kenderaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'days')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tarikh_m')->textInput() ?>

    <?= $form->field($model, 'ver_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ver_date')->textInput() ?>

    <?= $form->field($model, 'status_semakan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ulasan_semakan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'app_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'app_date')->textInput() ?>

    <?= $form->field($model, 'status_kj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ulasan_kj')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'isActive')->textInput() ?>

    <?= $form->field($model, 'letter_sent')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
