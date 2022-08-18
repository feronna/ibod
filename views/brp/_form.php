<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\brp\tblrscobrp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscobrp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'icno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'brpCd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'jawatan_id')->textInput() ?>

    <?= $form->field($model, 'tarikh_mulai')->textInput() ?>

    <?= $form->field($model, 'tarikh_hingga')->textInput() ?>

    <?= $form->field($model, 'tarikh_lulus')->textInput() ?>

    <?= $form->field($model, 'rujukan_surat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tarikh_surat')->textInput() ?>

    <?= $form->field($model, 'isPencen')->textInput() ?>

    <?= $form->field($model, 'gaji_sebulan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'status_date')->textInput() ?>

    <?= $form->field($model, 'status_update_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sah')->textInput() ?>

    <?= $form->field($model, 'sah_date')->textInput() ?>

    <?= $form->field($model, 'sah_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 't_lpg_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insert_date')->textInput() ?>

    <?= $form->field($model, 'insert_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_update')->textInput() ?>

    <?= $form->field($model, 'update_by')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
