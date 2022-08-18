<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\utilities\PosTblPermohonanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pos-tbl-permohonan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'icno_pemohon') ?>

    <?= $form->field($model, 'tujuan_mel') ?>

    <?= $form->field($model, 'tarikh_mohon') ?>

    <?= $form->field($model, 'alamat_penghantar') ?>

    <?php // echo $form->field($model, 'alamat_penerima') ?>

    <?php // echo $form->field($model, 'icno_pelulus') ?>

    <?php // echo $form->field($model, 'status_jafpib') ?>

    <?php // echo $form->field($model, 'tarikh_status_jafpib') ?>

    <?php // echo $form->field($model, 'icno_pom') ?>

    <?php // echo $form->field($model, 'status_pom') ?>

    <?php // echo $form->field($model, 'tarikh_status_pom') ?>

    <?php // echo $form->field($model, 'tracking_no') ?>

    <?php // echo $form->field($model, 'tarikh_dihantar') ?>

    <?php // echo $form->field($model, 'jenis_khidmat_mel') ?>

    <?php // echo $form->field($model, 'bayaran_mel') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
