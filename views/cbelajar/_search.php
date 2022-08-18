<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\cbelajar\UrusMesyuaratSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-urus-mesyuarat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kali_ke') ?>

    <?= $form->field($model, 'tarikh_mesyuarat') ?>

    <?= $form->field($model, 'nama_mesyuarat') ?>

    <?= $form->field($model, 'masa_mesyuarat') ?>

    <?php // echo $form->field($model, 'tempat_mesyuarat') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
