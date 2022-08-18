<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\e_perkhidmatan\PapanTandaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="papan-tanda-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'icno') ?>

    <?= $form->field($model, 'tajuk') ?>

    <?= $form->field($model, 'tarikh_mula') ?>

    <?= $form->field($model, 'tarikh_hingga') ?>

    <?php // echo $form->field($model, 'tempat') ?>

    <?php // echo $form->field($model, 'masa') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'ver_by') ?>

    <?php // echo $form->field($model, 'ver_date') ?>

    <?php // echo $form->field($model, 'status_semakan') ?>

    <?php // echo $form->field($model, 'ulasan_semakan') ?>

    <?php // echo $form->field($model, 'app_by') ?>

    <?php // echo $form->field($model, 'app_date') ?>

    <?php // echo $form->field($model, 'status_kj') ?>

    <?php // echo $form->field($model, 'ulasan_kj') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
