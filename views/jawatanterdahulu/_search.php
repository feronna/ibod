<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\TbljawatanterdahuluSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbljawatanterdahulu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ICNO') ?>

    <?= $form->field($model, 'PrevPostNm') ?>

    <?= $form->field($model, 'PrevPostStartDt') ?>

    <?= $form->field($model, 'PrevPostEndDt') ?>

    <?= $form->field($model, 'PrevPostDesc') ?>

    <?php // echo $form->field($model, 'id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
