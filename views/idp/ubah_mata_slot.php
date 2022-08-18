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
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Ubah Mata Slot : 
<!--                    <span class="required">*</span>-->
                </label>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <?=
                    $form->field($model, 'mataSlot')->label(false)->widget(Select2::classname(), [
                        'data' => [
                            '1' => '1', 
                            '3' => '3',
                            '6' => '6',
                            '12' => '12',
                            '18' => '18',
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
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                </div>
        </div>
        </div>
</div>
<?php ActiveForm::end(); ?>