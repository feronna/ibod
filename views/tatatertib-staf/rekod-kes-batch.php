<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//yii\helpers\VarDumper::dump($jenis_cuti,10,true);

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
?>


  
    <div class="x_panel">
         <div class="x_title">
        <h2><i class="fa fa-pencil-square"></i>&nbsp;<strong>Rekod Kes : Sila Pilih Jenis Rekod /</strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
        <div class="x_content">
            <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3  col-md-offset-1">JENIS PERMOHONAN</label>
            <div class="col-md-4 col-sm-4 ">
            <select class="form-control"id="foo">
            <option>--Pilih Rekod--</option>
            <option value="../tatatertib-staf/rekod-kes ">Rekod Kes Kakitangan</option>
            <option value="../tatatertib-staf/rekod-kes-batch ">Rekod Kes Batch</option>

             
            </select>
            </div>
            </div>
         
        </div> 
    
        </div>
    


   <div class="x_panel">
    
        <div class="x_content">
           
<div class="customer-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    

   
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 15, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelRekod[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'kes', 'icno',
                    
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelRekod as $i => $modelRekod): ?>
                
                
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                
                   
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelRekod->isNewRecord) {
                                echo Html::activeHiddenInput($modelRekod, "[{$i}]id");
                            }
                        ?>
                        

        
                  <div class="row">
	               <div>KOMPETENSI<span class="required" style="color:red;">*</span>			
               <?=
                    $form->field($modelRekod, "[{$i}]icno")->label(false)->widget(Select2::classname(), [
                        'data' => $biodataKakitangan,
                        'options' => ['placeholder' => 'Pilih Staf', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
            </div><!-- .row -->
           </div>
            
                        
                        
                </div>
                </div>
            <?php endforeach; ?>
            </div>
            
                  

                
            
            <?php DynamicFormWidget::end(); ?>
        </div>
    
    
                
                               <div class="row">
	               <div>KOMPETENSI<span class="required" style="color:red;">*</span>			
                <?= $form->field($modelRekod, "[{$i}]kes")->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div><!-- .row -->
           </div>
   
    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
        
        
        
        
            </div>
        </div>


     <script>
    document.getElementById("foo").onchange = function() {
        if (this.selectedIndex!==0) {
            window.location.href = this.value;
        }        
    };
</script>