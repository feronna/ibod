<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>
<style>
    .modal-dialog{
        width: 70%;
        margin : auto;
       
    }
</style>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
         

 
         <div class="col-md-12 col-sm-12 col-xs-12">  
              
    <div class="x_panel">
        <br>
             <div class="form-group" style="font-size:18px;">
            <ol>
                <div class="form-group">
                <li>
                    Status <span style="color: red" class="required">*</span><br><br>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        
                <?= $form->field($model, 'status')->label(false)->widget(Select2::classname(), [
                        'data' => ['Work from home' => 'Work from home', 'Work from office' => 'Work from office'],
                        'options' => ['required' => true,'placeholder' => 'Choose', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'status($(this).val())'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
                    </div>
                </li></div>
                
                <div id="garis2" style="display: <?= $model->status == 'Work from office'? :'none'?>" class="ln_solid"></div>
                <div id="sym" style="display: <?= $model->status == 'Work from office'? :'none'?>" class="form-group">
                <li>Do you have these symptoms fever, cough, or shortness of breath? <span style="color: red" class="required">*</span><br><br>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <?= $form->field($model, 'health_status')->label(false)->widget(Select2::classname(), [
                        'data' => [2 => 'Yes', 1 => 'No'],
                        'options' => ['required' => true,'placeholder' => 'Choose', 'class' => 'form-control col-md-7 col-xs-12',
                            ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
                    </div>
                </li></div>
                
                <div id="garis" style="display: <?= $model->status == 'Work from office'? :'none'?>" class="ln_solid"></div>
                <div id="temp" style="display: <?= $model->status == 'Work from office'? :'none'?>" class="form-group">
                <li>
                    My temperature measurement is <span style='color: red;' class="required" id="reqtemp">*</span><br><br>
                    <div class="col-md-3 col-sm-9 col-xs-9">
                    <?= $form->field($model, 'temperature')->label(false)->widget(Select2::classname(), [
                        'data' => ['< 36.0' => 'Less than 36.0', '36.0 - 37.5' => 'Between 36.0 and 37.5 (Normal)', '> 37.5' => 'More than 37.5'],
                        'options' => ['required' => true,'placeholder' => 'Choose', 'class' => 'form-control col-md-7 col-xs-12',
                            ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
                    </div>°C
                    </li></div>
                
            </ol>
            
        </div>
        
         <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']).Html::a('Delete', ['delete', 'id' => $model->id, 'url' => $url], [
                                            'class' => 'btn btn-danger','id' => 'delete',
            ]); ?>
                </div>
            </div>
        </div>
    </div>
            <?php ActiveForm::end(); ?>
<script>
    function status(val){
        if(val === 'Work from office'){
            $("#temp").show();
            $("#garis").show();
            $("#garis2").show();
            $("#sym").show();
            $("#tblselfhealth-temperature").prop('required',true);
            $("#tblselfhealth-health_status").prop('required',true);
        }else{
            $("#temp").hide();
            $("#garis").hide();
            $("#garis2").hide();
            $("#sym").hide();
            $("#tblselfhealth-temperature").prop('required',false);
            $("#tblselfhealth-health_status").prop('required',false);
        }
//        var url = window.location.href;
//        var curl = new URL(url);
//        curl.searchParams.set("status", val);
//        window.location.href = curl;
                            }
        </script>



