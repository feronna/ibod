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
    label{
        margin-bottom: 10px;
        font-size: 14px;
    }
</style>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
         

 
         <div class="col-md-12 col-sm-12 col-xs-12">  
              
    <div class="x_panel">
        <div class="x_content">
        
            <div class="form-group" style="font-size:18px;">
            <ol>
                <div id="sym" class="form-group">
                <li>Place of treatment<br><br>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'treatment_place')->radioList(['prw' => 'PRW / Klinik Rawatan UMS', 'lain-lain' => 'Klinik Panel UMS/Hospital/Lain-lain klinik'])->label(false);?>
                   
                </div>
                </li></div>
                
                <div id="garis" class="ln_solid"></div>
                <div id="temp" class="form-group">
                <li>
                    Status<br><br>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'status_prw')->radioList(['Allow to work' => 'Allow to work', 'Not allow to work' => 'Not allow to work'])->label(false);?>
                   
                </div>
                    </li></div>
                
            </ol>
            
        </div>
         <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
    </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


