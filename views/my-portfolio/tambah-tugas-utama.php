<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


 $title = $this->title = 'DeskripsiTugas';

 
?>



<div class="row">
<div class="col-md-12">
   <div class="x_panel">
        <div class="x_title">
            <h2>Tambah Tugas Utama</h2>
             <p align="right" >
                    <?php echo Html::a('Kembali', ['/my-portfolio/lihat-akauntabiliti', 'id' => $akauntabilitiTitle->portfolio_id], ['class' => 'btn btn-primary btn-sm']); ?>  
               
                </p>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
             
            
    
                 <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Akauntabiliti
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
               
                    <div class="form-group">
                         <?= $form->field($akauntabilitiTitle, 'description')->textArea(['maxlength' => true, 'readonly'=>true , 'value' => $akauntabilitiTitle->kata_kerja. $akauntabilitiTitle->object .$akauntabilitiTitle->description , 'rows' => 4])->label(false) ?>   
                    </div>
                </div>
            </div>
            
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tugas Utama<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
              
                    <?=  $form->field($lihatTugass, 'description')->textArea(['maxlength' => true, 'rows' => 4])->label(false) ?>  
       
                </div>
            </div>

        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Tambah', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Kembali', ['my-portfolio/lihat-akauntabiliti'], ['class'=>'btn btn-warning']) ?>
            </div>
        </div>
            <?php ActiveForm::end();?>
    
        
        
        
            </div>
        </div>
</div>
</div>
    
    