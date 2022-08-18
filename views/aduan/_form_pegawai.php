<?php

use app\models\hronline\TahapKemahiranBahasa;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper

/* @var $this yii\web\View */
/* @var $model app\models\aduan\RptTblAduan */
/* @var $form2 yii\widgets\ActiveForm */
?>

<div class="rpt-tbl-aduan-form">

    <?php $form2 = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <form class="needs-validation" novalidate>

        <div class="x_content">

            <div class="col-md-10 col-sm-10 col-xs-12">

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Pegawai <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form2->field($modelPegawai, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Unit <span class="required"></span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-12">

                        <?php
                        if ($modelUnit) {
                            echo $form2->field($modelUnit->unitname, 'unit_name')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false);
                        }
                        ?>

                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-3">
                        <div style='color:red'>
                            SILA BERHUBUNG DENGAN PENYELIA UNTUK MENGEMASKINI MAKLUMAT UNIT ANDA.
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombor Kad Pengenalan <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form2->field($modelPegawai, 'ICNO')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS-PER <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form2->field($modelPegawai, 'COOldID')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan : <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?=
                        $form2->field($model, 'aduan_status')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                '3' => 'DITERIMA UNTUK SIASATAN',
                                '4' => 'DITOLAK UNTUK SIASATAN',
                            ],
                            'options' => [
                                'placeholder' => 'Sila Pilih',
                                'disabled' => $model->aduan_status > 2 ? true : false,
                                'id' => '1'
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan : <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form2->field($model, 'officer_notes')->textarea(array('rows' => 6, 'cols' => 5, 'disabled' => $model->aduan_status > 2 ? true : false))->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <p align="right">
                            <?php if ($model->aduan_status == 2) { ?>
                                <button class="btn btn-primary" type="submit">Hantar <span class="glyphicon glyphicon-send" aria-hidden="true"></span></button>
                            <?php } ?>
                            <?php if ($status == 3) { ?><?= Html::a(Yii::t('app', 'Hapus'), ['delete', 'id' => $model->aduan_id], [
                                                            'class' => 'btn btn-danger',
                                                            'data' => [
                                                                'confirm' => Yii::t('app', 'Adakah anda pasti anda ingin menghapuskan rekod aduan ini?'),
                                                                'method' => 'post',
                                                            ],
                                                        ]) ?>
                        <?php } ?>
                        <?= Html::a('Kembali', ['view-list-officer'], ['class' => 'btn btn-primary']) ?>
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </form>

    <?php ActiveForm::end(); ?>

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

</div>