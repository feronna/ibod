<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\kehadiran\tblwpSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblwp-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'wp_id') ?>

    <?= $form->field($model, 'icno') ?>

    <?= $form->field($model, 'remark') ?>

    <?= $form->field($model, 'entry_dt') ?>

    <?php // echo $form->field($model, 'ver_by') ?>

    <?php // echo $form->field($model, 'ver_dt') ?>

    <?php // echo $form->field($model, 'ver_remark') ?>

    <?php // echo $form->field($model, 'app_by') ?>

    <?php // echo $form->field($model, 'app_dt') ?>

    <?php // echo $form->field($model, 'app_remark') ?>

    <?php // echo $form->field($model, 'start_date') ?>

    <?php // echo $form->field($model, 'end_date') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
