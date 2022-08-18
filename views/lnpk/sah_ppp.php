<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">

            <div class="panel-body">
                <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => [
                        'class' => 'form-horizontal form-label-left',
                        'data-pjax' => true
                    ],
                    'fieldConfig' => ['template' => '{label}{input}'],
                ]); ?>

                <?= $form->errorSummary($model, ['header' => 'Maaf, anda tidak dibenarkan untuk membuat pengesahan Laporan Penilaian Prestasi kerana terdapat maklumat wajib yang belum lengkap:']); ?>

                <p align="center">
                    Saya (<?= ($model->pp->CONm ?? $model->ppp->CONm) ?? null; ?>) mengesahkan bahawa semua maklumat yang terkandung pada Laporan Penilaian Prestasi Tahun <?= $model->tahun; ?> ini adalah benar.<br><br>
                    Saya bersetuju Laporan Penilaian Prestasi Tahun <?= $model->tahun; ?> ini untuk disahkan oleh Ketua Jabatan.<br>
                </p>

                <div style="text-align: center">
                    <?= ($model->PPP == \Yii::$app->user->identity->ICNO) ?  $form->field($model, 'PPP_sah')->checkbox(['label' => null]) : $form->field($model, 'PPP_sah')->checkbox(['label' => null]); ?>
                    <?= Html::submitButton('Hantar Pengesahan', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
                <?php yii\widgets\Pjax::end() ?>
            </div>
        </div>
    </div>
</div>