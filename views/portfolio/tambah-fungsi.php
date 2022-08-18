<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


 $title = $this->title = 'DeskripsiTugas';

 
?>



<div class="row">
<div class="col-md-12">
   <div class="x_panel">
        <div class="x_title">
            <h2>Tambah Fungsi Unit</h2>
         
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
             
            
    
                 <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA UNIT
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
               
                    <div class="form-group">
                         <?= $form->field($akauntabilitiTitle, 'unit_details')->textArea(['maxlength' => true, 'readonly'=>true , 'value' => $akauntabilitiTitle->unit_details , 'rows' => 4])->label(false) ?>   
                    </div>
                </div>
            </div>
            
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">FUNGSI UNIT<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
              
                    <?=  $form->field($lihatTugass, 'description')->textArea(['maxlength' => true, 'rows' => 4])->label(false) ?>  
       
                </div>
            </div>

        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Tambah', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Kembali', ['portfolio/tambah-fungsi-unit'], ['class'=>'btn btn-warning']) ?>
            </div>
        </div>
            <?php ActiveForm::end();?>
    
        
        
        
            </div>
        </div>
</div>
</div>
    
    