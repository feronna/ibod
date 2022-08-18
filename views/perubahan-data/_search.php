<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\updatestatusSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="updatestatus-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'usern') ?>

    <?= $form->field($model, 'COTableName') ?>

    <?= $form->field($model, 'COActivity') ?>

    <?= $form->field($model, 'COUpadteDate') ?>

    <?= $form->field($model, 'COUpdateIP') ?>

    <?php // echo $form->field($model, 'COUpdateComp') ?>

    <?php // echo $form->field($model, 'COUpdateCompUser') ?>

    <?php // echo $form->field($model, 'COUpdateSQL') ?>

    <?php // echo $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'idval') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
