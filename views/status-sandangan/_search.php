<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TblrscosandanganSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscosandangan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ICNO') ?>

    <?= $form->field($model, 'gredjawatan') ?>

    <?= $form->field($model, 'sandangan_id') ?>

    <?= $form->field($model, 'ApmtTypeCd') ?>

    <?php // echo $form->field($model, 'start_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
