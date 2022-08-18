<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tblbuka\borangSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="borang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'icno') ?>

    <?= $form->field($model, 'dept') ?>

    <?= $form->field($model, 'unit') ?>

    <?= $form->field($model, 'gred_jawatan') ?>

    <?php // echo $form->field($model, 'butiran') ?>

    <?php // echo $form->field($model, 'nama_tempat') ?>

    <?php // echo $form->field($model, 'negara') ?>

    <?php // echo $form->field($model, 'date_from') ?>

    <?php // echo $form->field($model, 'date_to') ?>

    <?php // echo $form->field($model, 'days') ?>

    <?php // echo $form->field($model, 'entry_date') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'catatan') ?>

    <?php // echo $form->field($model, 'status_pp') ?>

    <?php // echo $form->field($model, 'catatan_pp') ?>

    <?php // echo $form->field($model, 'status_kj') ?>

    <?php // echo $form->field($model, 'catatan_kj') ?>

    <?php // echo $form->field($model, 'implikasi') ?>

    <?php // echo $form->field($model, 'upload') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
