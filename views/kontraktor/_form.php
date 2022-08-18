<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Kontraktor\kontraktor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kontraktor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ICNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CONm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'COBirthDt')->textInput() ?>

    <?= $form->field($model, 'GenderCd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'COOffTelNo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ReligionCd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CountryCd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Addr1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Addr2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Addr3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Postcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CityCd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'StateCd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_kontraktor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_permit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'filename_vaksin_pm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'filename_sijil_pm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'filename_kad_cidb')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
