<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ikad\TblMohonSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-mohon-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'd_mohon_id') ?>

    <?= $form->field($model, 'd_pemohon_icno') ?>

    <?= $form->field($model, 'd_bahasa_kad') ?>

    <?= $form->field($model, 'd_gelaran_bm') ?>

    <?= $form->field($model, 'd_gelaran_bi') ?>

    <?php // echo $form->field($model, 'd_nama') ?>

    <?php // echo $form->field($model, 'd_edu_bi_1') ?>

    <?php // echo $form->field($model, 'd_edu_bi_2') ?>

    <?php // echo $form->field($model, 'd_edu_bm_1') ?>

    <?php // echo $form->field($model, 'd_edu_bm_2') ?>

    <?php // echo $form->field($model, 'd_jawatan_bi') ?>

    <?php // echo $form->field($model, 'd_jawatan_bm') ?>

    <?php // echo $form->field($model, 'd_jbtn_bi') ?>

    <?php // echo $form->field($model, 'd_jbtn_bm') ?>

    <?php // echo $form->field($model, 'd_kampus_bi') ?>

    <?php // echo $form->field($model, 'd_kampus_bm') ?>

    <?php // echo $form->field($model, 'd_kampus2_bi') ?>

    <?php // echo $form->field($model, 'd_kampus2_bm') ?>

    <?php // echo $form->field($model, 'd_office_telno') ?>

    <?php // echo $form->field($model, 'd_office_extno') ?>

    <?php // echo $form->field($model, 'd_faxno') ?>

    <?php // echo $form->field($model, 'd_hpno') ?>

    <?php // echo $form->field($model, 'd_email') ?>

    <?php // echo $form->field($model, 'd_pieces') ?>

    <?php // echo $form->field($model, 'd_tarikh_mohon') ?>

    <?php // echo $form->field($model, 'd_hantar') ?>

    <?php // echo $form->field($model, 'd_tarikh_hantar') ?>

    <?php // echo $form->field($model, 'd_status_kad') ?>

    <?php // echo $form->field($model, 'd_status_tarikh') ?>

    <?php // echo $form->field($model, 'd_update_id') ?>

    <?php // echo $form->field($model, 'd_peraku_peg') ?>

    <?php // echo $form->field($model, 'd_peraku_peg_id') ?>

    <?php // echo $form->field($model, 'd_peraku_peg_dt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
