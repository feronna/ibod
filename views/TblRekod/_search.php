<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TblRekodSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-rekod-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'icno') ?>

    <?= $form->field($model, 'day') ?>

    <?= $form->field($model, 'tarikh') ?>

    <?= $form->field($model, 'time_in') ?>

    <?php // echo $form->field($model, 'time_out') ?>

    <?php // echo $form->field($model, 'ot_in') ?>

    <?php // echo $form->field($model, 'ot_out') ?>

    <?php // echo $form->field($model, 'reason_id') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'status_in') ?>

    <?php // echo $form->field($model, 'status_out') ?>

    <?php // echo $form->field($model, 'absent') ?>

    <?php // echo $form->field($model, 'app_by') ?>

    <?php // echo $form->field($model, 'app_dt') ?>

    <?php // echo $form->field($model, 'remark_status') ?>

    <?php // echo $form->field($model, 'wp_id') ?>

    <?php // echo $form->field($model, 'latitude') ?>

    <?php // echo $form->field($model, 'longitude') ?>

    <?php // echo $form->field($model, 'in_ip') ?>

    <?php // echo $form->field($model, 'out_ip') ?>

    <?php // echo $form->field($model, 'ot_in_ip') ?>

    <?php // echo $form->field($model, 'ot_out_ip') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
