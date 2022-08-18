<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\TblpengalamankerjaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblpengalamankerja-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ICNO') ?>

    <?= $form->field($model, 'OrgNm') ?>

    <?= $form->field($model, 'OccSectorCd') ?>

    <?= $form->field($model, 'CorpBodyTypeCd') ?>

    <?= $form->field($model, 'PrevEmpRemarks') ?>

    <?php // echo $form->field($model, 'PrevEmpStartDt') ?>

    <?php // echo $form->field($model, 'PrevEmpEndDt') ?>

    <?php // echo $form->field($model, 'id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
