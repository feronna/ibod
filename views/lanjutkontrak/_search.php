<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\kontrak\KontrakSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kontrak-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'icno') ?>

    <?= $form->field($model, 'reason') ?>

    <?= $form->field($model, 'tarikh_m') ?>

    <?= $form->field($model, 'ver_by') ?>

    <?php // echo $form->field($model, 'app_by') ?>

    <?php // echo $form->field($model, 'status_pp') ?>

    <?php // echo $form->field($model, 'status_jfpiu') ?>

    <?php // echo $form->field($model, 'status_tnca') ?>

    <?php // echo $form->field($model, 'status_pendaftar') ?>

    <?php // echo $form->field($model, 'status_nc') ?>

    <?php // echo $form->field($model, 'status_bsm') ?>

    <?php // echo $form->field($model, 'ulasan_pp') ?>

    <?php // echo $form->field($model, 'ulasan_jfpiu') ?>

    <?php // echo $form->field($model, 'ulasan_tnca') ?>

    <?php // echo $form->field($model, 'ulasan_pendaftar') ?>

    <?php // echo $form->field($model, 'ulasan_nc') ?>

    <?php // echo $form->field($model, 'ver_date') ?>

    <?php // echo $form->field($model, 'app_date') ?>

    <?php // echo $form->field($model, 'tnca_date') ?>

    <?php // echo $form->field($model, 'pendaftar_date') ?>

    <?php // echo $form->field($model, 'bsma_date') ?>

    <?php // echo $form->field($model, 'lulus_date') ?>

    <?php // echo $form->field($model, 'tempoh_l_pp') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'tempoh_l_bsm') ?>

    <?php // echo $form->field($model, 'tempoh_l_jfpiu') ?>

    <?php // echo $form->field($model, 'tempoh_l_tnca') ?>

    <?php // echo $form->field($model, 'tempoh_l_pendaftar') ?>

    <?php // echo $form->field($model, 'tempoh_l_nc') ?>

    <?php // echo $form->field($model, 'terima') ?>

    <?php // echo $form->field($model, 'job_category') ?>

    <?php // echo $form->field($model, 'dokumen_sokongan') ?>

    <?php // echo $form->field($model, 'surat') ?>

    <?php // echo $form->field($model, 'sesi_id') ?>

    <?php // echo $form->field($model, 'tahun_sesi') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
