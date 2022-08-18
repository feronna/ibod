<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TblRekod */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-rekod-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'icno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'day')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tarikh')->textInput() ?>

    <?= $form->field($model, 'time_in')->textInput() ?>

    <?= $form->field($model, 'time_out')->textInput() ?>

    <?= $form->field($model, 'ot_in')->textInput() ?>

    <?= $form->field($model, 'ot_out')->textInput() ?>

    <?= $form->field($model, 'reason_id')->textInput() ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_in')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_out')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'absent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'app_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'app_dt')->textInput() ?>

    <?= $form->field($model, 'remark_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wp_id')->textInput() ?>

    <?= $form->field($model, 'latitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'longitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'in_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'out_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ot_in_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ot_out_ip')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
