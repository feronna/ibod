<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WarrantSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-jawatan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'jawatan') ?>

    <?= $form->field($model, 'gred') ?>

    <?= $form->field($model, 'jumlah_waran') ?>

    <?= $form->field($model, 'kategori') ?>

    <?php // echo $form->field($model, 'kumpkhidmat_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
