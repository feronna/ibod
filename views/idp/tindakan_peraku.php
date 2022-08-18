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
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

<div class="col-md-12 col-sm-12 col-xs-12">            
    <div class="x_panel">
        <br>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Status Perakuan Kursus : 
<!--                    <span class="required">*</span>-->
                </label>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <?=
                    $form->field($model, 'statusPermohonan')->label(false)->widget(Select2::classname(), [
                        'data' => [
                            'DIPERAKUI' => 'PERMOHONAN DIPERAKUI', 
                            'TIDAK DIPERAKUI' => 'PERMOHONAN TIDAK DIPERAKUI'
                            ],
//                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
//                            'onchange' => 'javascript:if ($(this).val() == "4"){
//                        $("#tempoh").show();
//                        }
//                        else{
//                        $("#tempoh").hide();
//                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);



                    ?>
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