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
<?php if ($idB == 'belumBatal'){ ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

<div class="col-md-12 col-sm-12 col-xs-12">            
    <div class="x_panel">
        <br>
        
        <div class="form-group" id="tempoh" >
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Sebab Pembatalan : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'justifikasiBatal')->textarea(array('rows'=>6,'cols'=>5))->label(false);?>
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
<?php } elseif ($idB == 'sudahBatal'){ ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

<div class="col-md-12 col-sm-12 col-xs-12">            
    <div class="x_panel">
        <br>
        
        <div class="form-group" id="tempoh" >
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Justifikasi : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'justifikasiBatal')->textarea(['disabled' => 'disabled'],array('rows'=>6,'cols'=>5))->label(false);?>
                </div>
            </div>

        </div>
</div>
<?php ActiveForm::end(); ?>
<?php } ?>