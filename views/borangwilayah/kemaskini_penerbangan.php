<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; 
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

error_reporting(0);
?>


 
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86], 'vars' => []]); ?>
  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<div class="x_panel">
        <div class="x_title">
            <h2><strong>Kemaskini Jadual Penerbangan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
             <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p> 
            </ul>
            <div class="clearfix"></div>
        </div> 
        <div class="x_content">
            
        <div class="customer-form"> 
                

        <div class="panel panel-default">
            <div class="panel-heading">
                 
            </div>
            <div class="panel-body">
                <div class="container-items"><!-- widgetBody -->
               
                        <div class="panel-body">
                            
                            <div class="pull-right">
                              
                            </div>
                            <div class="clearfix"></div>
                       
                 <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <th scope="col" colspan=12"  style="background-color:white;"><center>JADUAL PENERBANGAN YANG DIRANCANG / DITEMPAH <br></center></th>
               <tr> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Destinasi Lapangan Terbang: (From)</th>
                        <td colspan="5">    
                            <?=$form->field($model, 'dest_berlepas')->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map($depart, 'penerbangan', 'penerbangan'),
                                    'options' => ['placeholder' => 'Return', 'default' => 0],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ], 
                                 ]); ?>     
                        </td> 
                    </tr>
                    
             
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh:</th>
                        <td>
                            <?= $form->field($model, 'tarikh_berlepas')->label(false)->widget(DatePicker::classname(),[
//                                            'readonly' => true,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd', 
                                                'startDate' => date('tarikh_tiba'),
                                                'minDate'=>'0'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>
                         
                     </td>               
                          <th class="col-md-3 col-sm-3 col-xs-12">Masa:</th>
                          <td>
                               <?= $form->field($model, 'masa_berlepas')->label(false)->widget(\kartik\time\TimePicker::classname(),[
                                'readonly' => false,
                                'pluginOptions' => [
                                    'format' => 'H:m:s',
                                    'autoclose'=>true,

                                ],
                                'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                ]); ?> 
                            
                    </td> 
                            </tr>
                            <tr> 
                    <tr> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Destinasi Lapangan Terbang: (Return)</th>
                        <td colspan="5">  
                          <?=$form->field($model, 'dest_tiba')->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map($depart, 'penerbangan', 'penerbangan'),
                                    'options' => ['placeholder' => 'Return', 'default' => 0],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ], 
                                 ]); ?> 
                    </td> 
                    </tr>
                  
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh:</th>
                        <td>
                          <?= $form->field($model, 'tarikh_tiba')->label(false)->widget(DatePicker::classname(),[
//                                            'readonly' => true,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd', 
                                                'startDate' => date('tarikh_tiba'),
                                                'minDate'=>'0'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>
                         
                        </td>  

                    <th class="col-md-3 col-sm-3 col-xs-12">Masa:</th>
                        <td>
                         
                            <?= $form->field($model, 'masa_tiba')->label(false)->widget(\kartik\time\TimePicker::classname(),[
                                'readonly' => false,
                                'pluginOptions' => [
                                    'format' => 'H:m:s',
                                    'autoclose'=>true,

                                ],
                                'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                ]); ?>  

                        </td> 
                    </tr>    
                </table>
                </div>
                </div>
                </div>
            </div>
            <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
               
                </div>
            </div>
        </div> 
       <?php ActiveForm::end();?>    
                
            </div>   
        </div>