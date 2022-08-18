<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\myidp\AdminJfpiuSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-jfpiu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'staffID') ?>

    <?= $form->field($model, 'date_added') ?>

    <?= $form->field($model, 'added_by') ?>

    <?= $form->field($model, 'staff_dept_on_added') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
