<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

error_reporting(0);

?>
<style>
    .modal-dialog{
        width: 70%;
        margin : auto;
       
    }
</style>
<?php if ($idB == 'belumSahHadir'){ ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

<div class="col-md-12 col-sm-12 col-xs-12">            
    <div class="x_panel">
        <br>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Pengesahan Kehadiran : 
<!--                    <span class="required">*</span>-->
                </label>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <?=
                    $form->field($model, 'sahHadirbyStaf')->label(false)->widget(Select2::classname(), [
                        'data' => [
                            'YA' => 'HADIR', 
                            'TIDAK' => 'TIDAK'
                            ],
                        'options' => [
                            'placeholder' => 'Pilih', 
                            'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "TIDAK"){
                                $("#tempoh").show();
                                }
                                else{
                                $("#tempoh").hide();
                                }',
                            'default' => '$("#tempoh").hide()',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);



                    ?>
                </div>
        </div>
        
        <div class="form-group" id="tempoh" >
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Justifikasi : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'alasanTidakHadir')->textarea(array('rows'=>6,'cols'=>5))->label(false);?>
                </div>
            </div>
        
        
<!--        <div class="ln_solid"></div>-->
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
</div>
<?php ActiveForm::end(); ?>
<?php } elseif ($idB == 'sudahSahHadir'){ ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

<div class="col-md-12 col-sm-12 col-xs-12">            
    <div class="x_panel">
        <br>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Pengesahan Kehadiran : 
<!--                    <span class="required">*</span>-->
                </label>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <?=
                    $form->field($model, 'sahHadirbyStaf')->textInput(['disabled' => 'disabled'])->label(false);



                    ?>
                </div>
        </div>
        
        <div class="form-group" id="tempoh" >
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Justifikasi : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'alasanTidakHadir')->textarea(['disabled' => 'disabled'],array('rows'=>6,'cols'=>5))->label(false);?>
                </div>
            </div>

        </div>
</div>
<?php ActiveForm::end(); ?>
<?php } ?>