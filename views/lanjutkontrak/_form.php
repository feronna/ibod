<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\kontrak\Kontrak */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kontrak-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'icno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reason')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tarikh_m')->textInput() ?>

    <?= $form->field($model, 'ver_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'app_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_pp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_jfpiu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_tnca')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_pendaftar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_nc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_bsm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ulasan_pp')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ulasan_jfpiu')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ulasan_tnca')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ulasan_pendaftar')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ulasan_nc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ver_date')->textInput() ?>

    <?= $form->field($model, 'app_date')->textInput() ?>

    <?= $form->field($model, 'tnca_date')->textInput() ?>

    <?= $form->field($model, 'pendaftar_date')->textInput() ?>

    <?= $form->field($model, 'bsma_date')->textInput() ?>

    <?= $form->field($model, 'lulus_date')->textInput() ?>

    <?= $form->field($model, 'tempoh_l_pp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tempoh_l_bsm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tempoh_l_jfpiu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tempoh_l_tnca')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tempoh_l_pendaftar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tempoh_l_nc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'terima')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job_category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dokumen_sokongan')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
