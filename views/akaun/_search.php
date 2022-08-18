<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\TblakaunSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblakaun-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ICNO') ?>

    <?= $form->field($model, 'AccNo') ?>

    <?= $form->field($model, 'AccTypeCd') ?>

    <?= $form->field($model, 'AccPurposeCd') ?>

    <?= $form->field($model, 'AccNmCd') ?>

    <?php // echo $form->field($model, 'CityCd') ?>

    <?php // echo $form->field($model, 'AccStatus') ?>

    <?php // echo $form->field($model, 'AccBranch') ?>

    <?php // echo $form->field($model, 'AccBranchCd') ?>

    <?php // echo $form->field($model, 'id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
