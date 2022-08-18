<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Gred */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gred-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'grade_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->checkbox(['label'=>'Aktif','value'=>1, 'uncheck'=>0]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
