<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\TblkecacatanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblkecacatan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ICNO') ?>

    <?= $form->field($model, 'DisabilityTypeCd') ?>

    <?= $form->field($model, 'DisabilityCauseCd') ?>

    <?= $form->field($model, 'DisabilityDt') ?>

    <?= $form->field($model, 'AccidentDt') ?>

    <?php // echo $form->field($model, 'SocialWelfareNo') ?>

    <?php // echo $form->field($model, 'HealDt') ?>

    <?php // echo $form->field($model, 'DrRptNo') ?>

    <?php // echo $form->field($model, 'id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
