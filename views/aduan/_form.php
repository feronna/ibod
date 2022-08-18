<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\aduan\RptTblAduan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rpt-tbl-aduan-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <form class="needs-validation" novalidate>

        <div class="x_content">

            <div class="col-md-10 col-sm-10 col-xs-12">

                <!-- <center>< Html::img('@web/images/bkums.png', [
                            // 'width' => '450px',
                            // 'height' => '450px'
                        ]) ?></center> -->

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penuh <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($modelBio, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombor Kad Pengenalan <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($modelBio, 'ICNO')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS-PER <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($modelBio, 'COOldID')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">JAFPIB <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($modelBio->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombor Telefon <span class="required"></span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?php

                        if ($modelBio->COHPhoneNo) {
                            echo $form->field($modelBio, 'COHPhoneNo')->textarea(array('rows' => 1, 'cols' => 5, 'class' => 'form-control', 'placeholder' => 'Sila isi nombor telefon anda di sini', 'required' => 'required', 'disabled' => 'disabled'))->label(false);
                        } else {
                            echo $form->field($modelBio, 'COHPhoneNo')->textarea(array('rows' => 12, 'cols' => 5, 'class' => 'form-control', 'placeholder' => 'Sila isi nombor telefon anda di sini', 'required' => 'required', 'disabled' => 'disabled'))->label(false);
                        }
                        //$form->field($modelBio, 'COHPhoneNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false);

                        ?>
                        <?php // $form->field($model->rekod, 'destinasi')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); 
                        ?>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <?= Html::a('<i class="fa fa-edit"></i> Kemaskini Nombor Telefon', ['biodata/kemaskini'], ['class' => 'btn btn-primary btn-sm', 'target' => '_blank']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?php

                        if ($modelBio->alamatTetap) {

                            echo $form->field($modelBio->alamatTetap, 'alamatPenuh')->textarea(array('rows' => 12, 'cols' => 5, 'class' => 'form-control', 'placeholder' => 'Sila isi alamat anda di sini', 'required' => 'required', 'disabled' => 'disabled'))->label(false);
                        } else {

                            echo $form->field($modelBio, 'alamat')->textarea(array('rows' => 12, 'cols' => 5, 'class' => 'form-control', 'value' => 'Sila lengkapkan alamat tetap anda.', 'required' => 'required', 'disabled' => 'disabled'))->label(false);
                        }

                        ?>

                    </div>
                    <p align="right"><?= Html::a('<i class="fa fa-edit"></i> Kemaskini Alamat', ['alamat/view'], ['class' => 'btn btn-primary btn-sm', 'target' => '_blank']) ?></p>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        Aduan Pelanggan
                        <!-- <span class="required" style="color:red;">*</span> -->
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                        <?= $form->field($model, 'aduan_details')->textarea(array('rows' => 12, 'cols' => 5, 'class' => 'form-control', 'placeholder' => 'Sila isi aduan anda di sini', 'required' => 'required', 'disabled' => $status != 1 ? true : false))->label(false); ?>
                        <?php if ($status == 1) { ?>
                            <div class="invalid-feedback">
                                Ruangan ini adalah mandatori.
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <?php if ($model->date_created != NULL) { ?>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Aduan <span class="required"></span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <?= $form->field($model, 'tarikhAdu')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Aduan <span class="required"></span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <?= $form->field($model->aduanStatus, 'details')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                        </div>
                    </div>

                    <?php if ($model->cancelled_date != NULL){?>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Dibatalkan <span class="required"></span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <?= $form->field($model, 'tarikhBatal')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                        </div>
                    </div>
                    <?php } ?>
                <?php } ?>

                <!-- <

                if ($status == 1) {
                    $button_title = 'Hantar';
                } else {
                    $button_title = 'Kemaskini';
                }

                ?> -->

                <div class="form-group">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <p align="right">
                            <?php if ($status == 1) { ?>
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
                        <?= Html::a('Kembali', ['view-list'], ['class' => 'btn btn-primary']) ?>
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