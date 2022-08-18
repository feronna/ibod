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
        margin-bottom: 10px;
        font-size: 14px;
    }
</style>
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
                <div id="sym" class="form-group">
                <li>Do you have these symptoms fever, cough, or shortness of breath? <span style="color: red" class="required">*</span><br><br>
                    <div class="col-md-1 col-sm-4 col-xs-4">
                        <?= $form->field($model, 'health_status')->radioList([2 => 'Yes' , 1 => 'No'])->label(false);?>
                    </div>
                </li></div>
                
                <div id="garis" class="ln_solid"></div>
                <div id="temp" class="form-group">
                <li>
                    My temperature measurement is <span style='color: red;' class="required" id="reqtemp">*</span><br><br>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <?= $form->field($model, 'temperature')->radioList(['< 36.0' => 'Less than 36.0 °C', '36.0 - 37.5' => 'Between 36.0 °C and 37.5 °C (Normal)', '> 37.5' => 'More than 37.5 °C'])->label(false);?>
                   
                    </div>
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
