<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

 $title = $this->title = 'DeskripsiTugas';

 
?>



<div class="row">
<div class="col-md-12">
   <div class="x_panel">
        <div class="x_title">
            <h2>Kemaskini Dimensi</h2>
             <p align="right" >
                    <?php echo Html::a('Kembali', ['/my-portfolio/lihat-dimensi', 'id' => $portfolio->id], ['class' => 'btn btn-primary btn-sm']); ?>  
               
                </p>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left'], 'method' => 'post']); ?>
            <div class="form-group">
                
               <div class="col-md-6 col-sm-6 col-xs-12">DIMENSI<span class="required" style="color:red;">*</span>
               <?= $form->field($lihatDimensi, 'dimensi')->textArea(['maxlength' => true, 'rows' => 4])->label(false) ?>
              </div>

                <div class="col-md-6 col-sm-6 col-xs-12">SKOP<span class="required" style="color:red;">*</span>
                    <?= $form->field($lihatDimensi, 'dimensi_utama')->textArea(['maxlength' => true, 'rows' => 4])->label(false) ?>
                </div>
            </div>

        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Kembali', ['my-portfolio/lihat-dimensi'], ['class'=>'btn btn-warning']) ?>
            </div>
        </div>
            <?php ActiveForm::end();?>
    
        
        
        
            </div>
        </div>
</div>
</div>
    
    