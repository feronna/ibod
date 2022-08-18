<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\TblanugerahSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblanugerah-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'awdId') ?>

    <?= $form->field($model, 'ICNO') ?>

    <?= $form->field($model, 'AwdCd') ?>

    <?= $form->field($model, 'TitleCd') ?>

    <?= $form->field($model, 'CfdByCd') ?>

    <?php // echo $form->field($model, 'AwdCatCd') ?>

    <?php // echo $form->field($model, 'StateCd') ?>

    <?php // echo $form->field($model, 'AwdCfdDt') ?>

    <?php // echo $form->field($model, 'AwdAbbr') ?>

    <?php // echo $form->field($model, 'AwdReason') ?>

    <?php // echo $form->field($model, 'AwdStatus') ?>

    <?php // echo $form->field($model, 'CountryCd') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
