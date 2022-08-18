<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\TblBadanProfesionalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-badan-profesional-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'profId') ?>

    <?= $form->field($model, 'ICNO') ?>

    <?= $form->field($model, 'ProfBodyCd') ?>

    <?= $form->field($model, 'ProfBodyOther') ?>

    <?= $form->field($model, 'MembershipTypeCd') ?>

    <?php // echo $form->field($model, 'JoinDt') ?>

    <?php // echo $form->field($model, 'FeeAmt') ?>

    <?php // echo $form->field($model, 'Designation') ?>

    <?php // echo $form->field($model, 'ResignDt') ?>

    <?php // echo $form->field($model, 'ProfAssocStatus') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
