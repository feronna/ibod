<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tblbuka\borang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="borang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'icno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'butiran')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_tempat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'negara')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'days')->textInput() ?>

    <?= $form->field($model, 'entry_date')->textInput() ?>

    <?= $form->field($model, 'ver_date')->textInput() ?>
    
     <?= $form->field($model, 'app_date')->textInput() ?>
    
    <?= $form->field($model, 'status_penyelia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'catatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_pp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'catatan_pp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_kj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'catatan_kj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'implikasi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'upload')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'upload2')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
