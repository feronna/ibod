<?php

use app\models\kehadiran\TblSelfhealth;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
//$checktoday = TblSelfhealth::checktoday();
//

$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); 
?>
<?= $this->render('_topmenu') ?>
<style>
    label{
        margin-bottom: 0;
    }
</style>
<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel"><div class="x_title">
                        <b>For inquiry, please contact below</b></div>
                    <ul>
                <div class="col-md-4 col-sm-4 col-xs-12"> 
                    <li>   En Mohd Azwan Bin Alleh <br>
                    Pegawai Teknologi Maklumat Kanan<br>
                    Email : azwan@ums.edu.my</li>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12"> 
                    <li>
                    Cik Noridah Binti Bitilis <br>
                    Penolong Pegawai Teknologi Maklumat<br>
                    Email : noridahbitilis@ums.edu.my</li>
                </div>
                    </ul></div>
</div>
        <div class="col-md-12 col-sm-12 col-xs-12">  
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-plus-square"></i> DAILY SELF HEALTH DECLARATION</strong></h2>  
            <div class="clearfix"></div>
        </div>
        <br>
        <div class="x_content">
            
            <?php 
            if(($model->health_status == 2 || $model->temperature == '>= 37.5') && $model->status == 'Work from office' && $model->status_prw == ''){
                echo '<span style="color:red">Please go to Pusat Rawatan Warga immediately</span>';
            }
            elseif(!TblSelfhealth::checktoday()){$model->status = $status;?>
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
                
                <div id="garis2" style="display:none" class="ln_solid"></div>
                <div id="sym" style="display:none" class="form-group">
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
                
                <div id="garis" style="display:none" class="ln_solid"></div>
                <div id="temp" style="display:none" class="form-group">
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
         <div class="form-group text-center">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'data'=>['confirm'=>'Are you sure?']]) ?>
                </div>
            </div>
         <?php }?>
        </div>
        </div>
    </div>
<?php ActiveForm::end();?>

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

<!--<script>
                function handlestatus(val){
                    if (val === 'Come to the office'){
                        $("#reqtemp").show();
                        $("#tblselfhealth-temperature").prop('required',true);
                    }
                    else{
                        $("#reqtemp").hide();
                        $("#tblselfhealth-temperature").prop('required',false);
                    }
                }
                </script>-->
