<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\TblpraddressSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblpraddress-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ICNO') ?>

    <?= $form->field($model, 'StateCd') ?>

    <?= $form->field($model, 'CityCd') ?>

    <?= $form->field($model, 'AddrTypeCd') ?>

    <?= $form->field($model, 'CountryCd') ?>

    <?php // echo $form->field($model, 'Addr1') ?>

    <?php // echo $form->field($model, 'Addr2') ?>

    <?php // echo $form->field($model, 'Addr3') ?>

    <?php // echo $form->field($model, 'Postcode') ?>

    <?php // echo $form->field($model, 'TelNo') ?>

    <?php // echo $form->field($model, 'id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
