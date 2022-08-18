<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\e_perkhidmatan\ParkirSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parkir-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'icno') ?>

    <?= $form->field($model, 'jenis_kenderaan') ?>

    <?= $form->field($model, 'no_pendaftaran_kenderaan') ?>

    <?= $form->field($model, 'jenama_kenderaan') ?>

    <?php // echo $form->field($model, 'model_kenderaan') ?>

    <?php // echo $form->field($model, 'warna_kenderaan') ?>

    <?php // echo $form->field($model, 'tarikh_meletakkan_kenderaan') ?>

    <?php // echo $form->field($model, 'tarikh_pengambilan_kenderaan') ?>

    <?php // echo $form->field($model, 'days') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'tarikh_m') ?>

    <?php // echo $form->field($model, 'ver_by') ?>

    <?php // echo $form->field($model, 'ver_date') ?>

    <?php // echo $form->field($model, 'status_semakan') ?>

    <?php // echo $form->field($model, 'ulasan_semakan') ?>

    <?php // echo $form->field($model, 'app_by') ?>

    <?php // echo $form->field($model, 'app_date') ?>

    <?php // echo $form->field($model, 'status_kj') ?>

    <?php // echo $form->field($model, 'ulasan_kj') ?>

    <?php // echo $form->field($model, 'isActive') ?>

    <?php // echo $form->field($model, 'letter_sent') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
