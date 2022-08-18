<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\TblrscoadminpostSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscoadminpost-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ICNO') ?>

    <?= $form->field($model, 'adminpos_id') ?>

    <?= $form->field($model, 'jobStatus') ?>

    <?= $form->field($model, 'paymentStatus') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'description_sef') ?>

    <?php // echo $form->field($model, 'dept_id') ?>

    <?php // echo $form->field($model, 'campus_id') ?>

    <?php // echo $form->field($model, 'appoinment_date') ?>

    <?php // echo $form->field($model, 'start_date') ?>

    <?php // echo $form->field($model, 'end_date') ?>

    <?php // echo $form->field($model, 'flag') ?>

    <?php // echo $form->field($model, 'files') ?>

    <?php // echo $form->field($model, 'renew') ?>

    <?php // echo $form->field($model, 'status_tugas') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
