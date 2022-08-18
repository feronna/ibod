<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\aduan\RptTblAduanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rpt-tbl-aduan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'aduan_id') ?>

    <?= $form->field($model, 'staff_icno') ?>

    <?= $form->field($model, 'aduan_details') ?>

    <?= $form->field($model, 'date_created') ?>

    <?= $form->field($model, 'aduan_status') ?>

    <?php // echo $form->field($model, 'penerima_icno') ?>

    <?php // echo $form->field($model, 'penerima_notes') ?>

    <?php // echo $form->field($model, 'penerima_date') ?>

    <?php // echo $form->field($model, 'reporter_icno') ?>

    <?php // echo $form->field($model, 'report') ?>

    <?php // echo $form->field($model, 'report_status') ?>

    <?php // echo $form->field($model, 'report_date') ?>

    <?php // echo $form->field($model, 'approver_icno') ?>

    <?php // echo $form->field($model, 'approval_date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
