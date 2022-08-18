<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblpenempatanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblpenempatan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ICNO') ?>

    <?= $form->field($model, 'date_start') ?>

    <?= $form->field($model, 'date_update') ?>

    <?= $form->field($model, 'dept_id') ?>

    <?php // echo $form->field($model, 'campus_id') ?>

    <?php // echo $form->field($model, 'reason_id') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'letter_order_refno') ?>

    <?php // echo $form->field($model, 'date_letter_order') ?>

    <?php // echo $form->field($model, 'letter_refno') ?>

    <?php // echo $form->field($model, 'update_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
