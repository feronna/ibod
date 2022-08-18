<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii;

 $title = $this->title = 'DeskripsiTugas';
 
$this->registerJs($js);
 
?>


<div class="row">
<div class="col-md-12">
   <div class="x_panel">
        <div class="x_title">
            <h2>Dimensi</h2>
             <p align="right" >
                    <?php echo Html::a('Kembali', ['/my-portfolio/lihat-dimensi', 'id' => $portfolio->id], ['class' => 'btn btn-primary btn-sm']); ?>  
               
                </p>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
           
<div class="customer-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    

   
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelDimensi[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'dimensi',
                    'dimensi_utama',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelDimensi as $i => $modelDimensi): ?>
                
                
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                    
                       
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                     
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelDimensi->isNewRecord) {
                                echo Html::activeHiddenInput($modelDimensi, "[{$i}]id");
                            }
                        ?>
                        

                        <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">DIMENSI<span class="required" style="color:red;">*</span>
                        <?=
                         $form->field($modelDimensi, "[{$i}]dimensi")->label(false)->textArea(['maxlength' => true, 'placeholder' => 'Contoh: Bilangan Waran Perjawatan (SKP Bil. S14/2020)'])->label(false) ?>
                       </div>
                            
                             <div class="col-md-6 col-sm-6 col-xs-12">SKOP<span class="required" style="color:red;">*</span>
                        <?=
                         $form->field($modelDimensi, "[{$i}]dimensi_utama")->textArea(['maxlength' => true, 'placeholder' => 'Contoh: 2,323 (7-Pengurusan Utama; 1007-akademik dan 1,308-Pentadbiran)'])->label(false) ?>
                       </div>
						</div><!-- .row -->
                   
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
          
            <?php DynamicFormWidget::end(); ?>
        </div>
    

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
        
        
        
        
            </div>
        </div>
</div>
</div>
    
 