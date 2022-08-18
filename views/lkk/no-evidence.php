<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
error_reporting(0);
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<h5> <strong><center>EVIDENCE/OUTPUT/SUBMITTED</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
   
       
        
        
<div class="form-group"  align="center">
            
                <label class="control-label col-md-3 col-sm-3 col-xs-12">JUSTIFICATION <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  
                    <?= $form->field($model, 'comment')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                  
                  
                </div>
        </div>
        
        
  
       
      
         
        
        
         
        
         
        
         

        
        

    </div>
    </div>
</div>
</div>


  
        
        
        
        
        
      
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>




