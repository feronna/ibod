<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

?>       

     <div class="x_panel">
<div class="x_content">
          <div class="table-responsive">

         
                  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
               
                       <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Aktiviti<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                     <?= $form->field($tambahCarta, 'aktiviti')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
              
              <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Simpan',['class' => 'btn btn-success']) ?>
                </div>
            </div>


            <?php ActiveForm::end(); ?>
              
              
               
              
              
        </div>
        
    </div>
     </div>