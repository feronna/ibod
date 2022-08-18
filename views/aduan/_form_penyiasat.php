<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use app\models\aduan\RptTblSiasatan;

/* @var $this yii\web\View */
/* @var $model app\models\aduan\RptTblAduan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rpt-tbl-aduan-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <form class="needs-validation" novalidate>

        <div class="x_content">

            <div class="col-md-10 col-sm-10 col-xs-12">

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penyiasat <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?php

                        if ($model->aduan_status != 5) {


                            // With a model and without ActiveForm
                            echo Select2::widget([
                                'name' => 'momo',
                                'value' => $penyiasat,
                                'id' => 'first',
                                'data' => $allStaf,
                                'options' => [
                                    'placeholder' => 'Sila pilih penyiasat ...',
                                    'disabled' => $model->aduan_status == 4 ? true : false
                                ],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'maximumInputLength' => 10,
                                    'allowClear' => true,
                                    'multiple' => true,
                                ],
                            ]);
                        } else { ?>
                            <div class="well well-lg" style="background-color: #eeeeee">
                            <?= RptTblSiasatan::getPenyiasat($model->aduan_id); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <p align="right">
                            <?php if ($model->aduan_status == 3) { ?>
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
                        <?php
                        if ($userStatus == 'admin') {
                            echo Html::a('Kembali', ['view-list-admin'], ['class' => 'btn btn-primary']);
                        } else {
                            echo Html::a('Kembali', ['view-list-chief'], ['class' => 'btn btn-primary']);
                        }
                        ?>
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