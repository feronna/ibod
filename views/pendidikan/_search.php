<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\TblpendidikanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblpendidikan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ICNO') ?>

    <?= $form->field($model, 'InstCd') ?>

    <?= $form->field($model, 'HighestEduLevelCd') ?>

    <?= $form->field($model, 'SponsorshipCd') ?>

    <?= $form->field($model, 'Sponsorship') ?>

    <?php // echo $form->field($model, 'MajorCd') ?>

    <?php // echo $form->field($model, 'MinorCd') ?>

    <?php // echo $form->field($model, 'EduCertTitle') ?>

    <?php // echo $form->field($model, 'EduCertTitleBI') ?>

    <?php // echo $form->field($model, 'ConfermentDt') ?>

    <?php // echo $form->field($model, 'OverallGrade') ?>

    <?php // echo $form->field($model, 'AcrtdEduAch') ?>

    <?php // echo $form->field($model, 'id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
