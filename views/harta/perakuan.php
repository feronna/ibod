<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>

<div class="row">
<div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-users"></i>PERAKUAN KETUA JABATAN</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                  <div class="table-responsive">
                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Status Perakuan<span class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <?=
                            $form->field($ketuaJabatan, 'status_kj')->label(false)->widget(Select2::classname(), [
                            'data' => [1 =>'DIPERAKUKAN', 0 => 'TIDAK DIPERAKUKAN'],
                            'options' => ['placeholder' => 'Pilih Tindakan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan Ketua Jabatan<span class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($ketuaJabatan, 'ulasan_kj')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                        </div>
                    </div>
                    <div class="ln_solid"></div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" type="reset">Reset</button>
                            <?= Html::submitButton('Hantar Jawapan', ['class' => 'btn btn-success', 'data'=>['confirm'=>'Adakah anda pasti dengan tindakan ini?']]) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
                <!--form-->
            </div>
            </div>
        </div>
    </div>
</div>

