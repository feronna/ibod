<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
error_reporting(0);
?>

<?php
Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true ]]); ?>
 
  
    <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-book"></i><strong> Rekod Penghantaran Resit</strong></h2>
                 
        <div class="clearfix"></div>
        </div>
        <div class="x_content">
 
                <div class="col-md-16 col-sm-10 col-xs-12">
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Resit : <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                     <?= $form->field($model, 'resit')->label(false)->widget(Select2::classname(), [
                    'data' => ['1' => 'RESIT DITERIMA',
                                    ],
                    'options' => ['placeholder' => 'Sila Pilih'],

                    ]); ?>
                </div>
                </div>
                    
                    <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Terima : <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                     <input type="text" class="form-control" value="<?php echo $model->entrydate;?>" disabled="disabled">

                </div>
                </div>
                  
               <div class="form-group">
               <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
               <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
               <button class="btn btn-primary" type="reset">Reset</button>
               </div>
            </div>
            </div>  
        
    </div>
</div>
    </div>

            <?php ActiveForm::end(); 
            Pjax::end();?>
