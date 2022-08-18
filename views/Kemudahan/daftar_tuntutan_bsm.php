<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; 
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\number\NumberControl;
use kartik\grid\GridView;
error_reporting(0);
?>


<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,1183,1314], 'vars' => []]); ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Jenis Kemudahan</strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
          
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Kemudahan<span class="required"> *</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($modelCustomer, 'kemudahan')->textInput(['maxlength' => true, 'placeholder' => 'Nama Kemudahan']) ->label(false);?>
 
            </div>
        </div>
 
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                  <?=
                    $form->field($modelCustomer, 'jumlah')->widget(NumberControl::classname(), [
                         'name' => 'jumlah',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         
                         'displayOptions' => [
                         //   'placeholder' => 'Contoh: RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Keseluruhan Kemudahan<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                 <?=
                    $form->field($modelCustomer, 'amount')->widget(NumberControl::classname(), [
                         'name' => 'jumlah',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         
                         'displayOptions' => [
                         //   'placeholder' => 'Contoh: RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
            </div>
        </div>

        <div class="ln_solid"></div>
 
    </div>
    </div>
</div>

<div class="row"> 
<div class="x_panel">
        <div class="x_title">
            <h2><strong>Maklumat Akaun  Kemudahan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div> 
        <div class="x_content">
        
        <div class="customer-form"> 
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper1', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items1', // required: css class selector
                    'widgetItem' => '.item1', // required: css class
                    'limit' => 1, // the maximum times, an element can be added (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $modelsAddress[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'full_name',
                        'address_line1',
                        'address_line2',
                        'city',
                        'state',
                        'postal_code',
                    ],
                ]); ?>

        <div class="panel panel-default">
            
           
                <div class="container-items1"><!-- widgetBody -->
                <?php foreach ($modelsAddress as $i => $modelAddress): ?>
                    <div class="item1 panel panel-default"><!-- widgetItem -->
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left">Akaun</h3>
                             
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                          
                            <?php
                                // necessary for update action.
                                if (! $modelAddress->isNewRecord) {
                                    echo Html::activeHiddenInput($modelAddress, "[{$i}]id");
                                }
                            ?>
                            <table class="table table-sm table-bordered" >
        <thead>
         
                <tr>
                         
                        
                        <td valign="2">Kod Akaun:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="2"> 
                            <?= $form->field($modelAddress, "[{$i}]kodAkaun")->textInput(['maxlength' => 400])->label(false); ?>
                         
                        </td>
 
                
                </tr> 
                  
        </thead>
                          </table> 
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
          
        </div><!-- .panel -->
        <?php DynamicFormWidget::end(); ?>
        <div class="customer-form">  
                <div class="form-group" align="center">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2"> 
                    <br>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
                </div>
            </div>  
            </div>   
        </div>
        </div>
    
</div>
 
<div class="row"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> E-Kemudahan Table Refjeniskemudahan</strong></h2>

                <div class="clearfix"></div>
            </div>
        <div class="x_content">
           <div class="table-responsive">
               <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL </th>
                        <th class="column-title text-center">KEMUDAHAN</th>   
                        <th class="text-center">Kod Akaun</th>   
                        <th class="text-center">TINDAKAN</th>  
                         
                       
                    </tr>
                    
                </thead>
                
               <?php if ($model) { $bil=1; ?>
                    <?php foreach ($model as $list) { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?= $bil++; ?></td>  
                            <td class="text-justify"><?php echo $list->kemudahan; ?></td> 
                            <td class="text-justify"><?php echo $list->kodakaun->kodAkaun; ?></td>    
                            <td class="text-center"> <?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ["kemudahan/view", 'kemudahancd' => $list->kemudahancd]) ?> | <?= Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['kemudahan/kemaskini', 'kemudahancd' => $list->kemudahancd]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['padam2', 'kemudahancd' => $list->kemudahancd]) ?></td>                    
                          
                          <?php } ?>
                          <?php } ?>
                   
                        </tr>
                        
            </table>
                 
           </div>
           </div>
        </div>
    
</div>
 
 <?php ActiveForm::end(); ?>

