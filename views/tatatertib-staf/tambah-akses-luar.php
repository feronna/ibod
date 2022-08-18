<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;
 

$title = $this->title = 'Takwim Mesyuarat Pengajian Lanjutan';
error_reporting(0);
?>


          
       
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5><strong><i class="fa fa-plus"></i> ADD EXTERNAL USER</strong></h5> 
              
           
            
            <div class="clearfix"></div>

          
            </div>
            <div class="x_content">

                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                
                
                
                 <div class="clearfix"></div>
               
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="umsper">USER ID: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($external, 'user_id')->textInput(['placeholder'=>'Auto Generate','disabled'=>true,'maxlength' => true])->label(false) ?>
                </div>
            </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">NAME: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($external, 'name')->textInput(['placeholder' => 'User Fullname'])->label(false); ?> 
                    </div>
                </div> 
                 
                 <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">USERNAME: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($external, 'username')->textInput(['placeholder' => 'User Email'])->label(false); ?> 
                    </div>
                </div> 
           
                <div class="form-group">
                    <div class="col-sm-3"></div> 
                    <div class="col-sm-9">
                        <?= Html::submitButton('ADD', ['class' => 'btn btn-success']) ?>
                        <?= Html::resetButton('RESET', ['class' => 'btn btn-primary']); ?>

                    </div>
                </div>

             

            </div>
        </div>
    </div>
     
       <?php ActiveForm::end(); ?>

</div>