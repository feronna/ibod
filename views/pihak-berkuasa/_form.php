<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblrscoaptathy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscoaptathy-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ICNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'AptAthyCd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ICNOHeadServ')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'AptAthyStDt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
