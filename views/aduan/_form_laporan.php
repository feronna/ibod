<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\aduan\RptTblAduan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rpt-tbl-aduan-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <div class="x_content">

        <div class="col-md-10 col-sm-10 col-xs-12">

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penyiasat <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($modelBio, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan Disandang <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($modelBio->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Laporan
                    <!-- <span class="required" style="color:red;">*</span> -->
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">

                    <?= $form->field($model, 'report')->textarea(array('rows' => 50, 'cols' => 5, 'class' => 'form-control', 'placeholder' => 'Sila isi laporan anda di sini', 'required' => 'required', 'disabled' => $model->report_status != 1 ? true : false))->label(false); ?>
                    <?php if ($status == 1) { ?>
                        <div class="invalid-feedback">
                            Ruangan ini adalah mandatori.
                        </div>
                    <?php } ?>
                </div>
            </div>

            <?php if ($model->report_date != NULL) { ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Laporan <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model, 'tarikhLaporan')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Laporan <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model, 'statusLaporan')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                    </div>
                </div>

                <?php if ($model->cancelled_date != NULL) { ?>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Dibatalkan <span class="required"></span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <?= $form->field($model, 'tarikhBatal')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>

            <div class="form-group">
                <div class="col-sm-3"></div>
                <div class="col-sm-9">
                    <p align="right">
                        <?php if ($model->report_status == 1) { ?>
                            <button class="btn btn-primary" type="submit">Hantar <span class="glyphicon glyphicon-send" aria-hidden="true"></span></button>
                        <?php } ?>
                        <?php if ($status == 2 && $model->aduan_status == 1) { ?><?= Html::a(Yii::t('app', 'Hapus'), ['delete', 'id' => $model->aduan_id], [
                                                                                        'class' => 'btn btn-danger',
                                                                                        'data' => [
                                                                                            'confirm' => Yii::t('app', 'Adakah anda pasti anda ingin menghapuskan rekod aduan ini?'),
                                                                                            'method' => 'post',
                                                                                        ],
                                                                                    ]) ?>
                    <?php } ?>
                    <?= Html::a('Kembali', ['view-list-penyiasat'], ['class' => 'btn btn-primary']) ?>
                    </p>
                </div>
            </div>

        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>