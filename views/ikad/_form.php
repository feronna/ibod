<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ikad\TblMohon */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-mohon-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'd_pemohon_icno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_bahasa_kad')->textInput() ?>

    <?= $form->field($model, 'd_gelaran_bm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_gelaran_bi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_edu_bi_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_edu_bi_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_edu_bm_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_edu_bm_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_jawatan_bi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_jawatan_bm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_jbtn_bi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_jbtn_bm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_kampus_bi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_kampus_bm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_kampus2_bi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_kampus2_bm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_office_telno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_office_extno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_faxno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_hpno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_pieces')->textInput() ?>

    <?= $form->field($model, 'd_tarikh_mohon')->textInput() ?>

    <?= $form->field($model, 'd_hantar')->dropDownList([ 'Y' => 'Y', 'N' => 'N', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'd_tarikh_hantar')->textInput() ?>

    <?= $form->field($model, 'd_status_kad')->textInput() ?>

    <?= $form->field($model, 'd_status_tarikh')->textInput() ?>

    <?= $form->field($model, 'd_update_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_peraku_peg')->dropDownList([ 'Y' => 'Y', 'N' => 'N', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'd_peraku_peg_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'd_peraku_peg_dt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
