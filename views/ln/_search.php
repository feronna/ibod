<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ln\LnSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ln-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'icno') ?>

    <?= $form->field($model, 'tujuan') ?>

    <?= $form->field($model, 'nama_tempat') ?>

    <?php // echo $form->field($model, 'negara') ?>

    <?php // echo $form->field($model, 'date_from') ?>

    <?php // echo $form->field($model, 'date_to') ?>

    <?php // echo $form->field($model, 'days') ?>

    <?php // echo $form->field($model, 'bil_peserta') ?>

    <?php // echo $form->field($model, 'perbelanjaan') ?>

    <?php // echo $form->field($model, 'entry_date') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'app_by') ?>

    <?php // echo $form->field($model, 'app_date') ?>

    <?php // echo $form->field($model, 'status_jfpiu') ?>

    <?php // echo $form->field($model, 'ulasan_jfpiu') ?>

    <?php // echo $form->field($model, 'ver_by') ?>

    <?php // echo $form->field($model, 'ver_date') ?>

    <?php // echo $form->field($model, 'status_bsm') ?>

    <?php // echo $form->field($model, 'ulasan_bsm') ?>
    
    <?php // echo $form->field($model, 'tambang') ?>
    
    <?php // echo $form->field($model, 'elaun_makan') ?>
    
    <?php // echo $form->field($model, 'ulasan_hotel') ?>
    
    <?php // echo $form->field($model, 'yuran') ?>
    
    <?php // echo $form->field($model, 'transport') ?>

    <?php // echo $form->field($model, 'dll') ?>
    
    <?php // echo $form->field($model, 'jumlah') ?>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
