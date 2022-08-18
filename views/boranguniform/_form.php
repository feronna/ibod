<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\kemudahan\Boranguniform */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="boranguniform-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'icno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jeniskemudahan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'harga_belian')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bil_belian')->textInput() ?>

    <?= $form->field($model, 'used_dt')->textInput() ?>

    <?= $form->field($model, 'entry_date')->textInput() ?>

    <?= $form->field($model, 'resit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_pt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'catatan_pt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'semakan_pt')->textInput() ?>

    <?= $form->field($model, 'status_pp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'catatan_pp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ver_date')->textInput() ?>

    <?= $form->field($model, 'tarikh_hantar')->textInput() ?>

    <?= $form->field($model, 'status_kj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'catatan_kj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'app_date')->textInput() ?>

    <?= $form->field($model, 'stat_bendahari')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'catatan_bendahari')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bendahari_date')->textInput() ?>

    <?= $form->field($model, 'pengakuan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mohon')->textInput() ?>

    <?= $form->field($model, 'isActive2')->textInput() ?>

    <?= $form->field($model, 'jumlah_belian')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dokumen_sokongan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'dokumen_sokongan2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status_semasa')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
