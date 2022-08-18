<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\TblsejarahperubatanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblsejarahperubatan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ICNO') ?>

    <?= $form->field($model, 'IllnessCd') ?>

    <?= $form->field($model, 'IllnessOther') ?>

    <?= $form->field($model, 'Year') ?>

    <?= $form->field($model, 'MedTreatment') ?>

    <?php // echo $form->field($model, 'TreatmentStartDt') ?>

    <?php // echo $form->field($model, 'TreatmentEndDt') ?>

    <?php // echo $form->field($model, 'id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
