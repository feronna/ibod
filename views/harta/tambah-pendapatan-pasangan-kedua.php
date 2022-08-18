<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\number\NumberControl;


?>

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2>Tambah Pendapatan Pasangan</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
            <p style="color: green">
                Sila nyatakan jumlah dan sekiranya tiada jumlah letak '0' pada ruang yang disediakan.
            </p>
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Gaji Pokok<span class="required" style="color:red;">*</span></label>
                </label>
              <div class="col-md-6 col-sm-6 col-xs-12" align="left">
                  <?=
                    $form->field($pend, 'gaji_pokok')->widget(NumberControl::classname(), [
                         'name' => 'gaji_pokok',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         'options' => $saveOptions,
                         'displayOptions' => [
                            'placeholder' => Yii::t('app', 'Contoh: ').'RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
                  
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Imbuhan Tetap Khidmat Awam (ITKA)<span class="required" style="color:red;">*</span></label>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12" align="left">
                  <?=
                    $form->field($pend, 'itka')->widget(NumberControl::classname(), [
                         'name' => 'itka',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         'options' => $saveOptions,
                         'displayOptions' => [
                            'placeholder' => Yii::t('app', 'Contoh: ').'RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
                  
                </div>
            </div>
            
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Imbuhan Tetap Keraian (ITK)<span class="required" style="color:red;">*</span></label>
                </label>
              
                     <div class="col-md-6 col-sm-6 col-xs-12" align="left">
                  <?=
                    $form->field($pend, 'itk')->widget(NumberControl::classname(), [
                         'name' => 'itk',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         'options' => $saveOptions,
                         'displayOptions' => [
                            'placeholder' => Yii::t('app', 'Contoh: ').'RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
                  
                </div>
            </div>
            
            
            
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Bayaran Insentif Wilayah (BIW)<span class="required" style="color:red;">*</span></label>
                </label>
           
                 <div class="col-md-6 col-sm-6 col-xs-12" align="left">
                  <?=
                    $form->field($pend, 'biw')->widget(NumberControl::classname(), [
                         'name' => 'biw',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         'options' => $saveOptions,
                         'displayOptions' => [
                            'placeholder' => Yii::t('app', 'Contoh: ').'RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
                  
                </div>
                
            </div>
            
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Imbuhan Tetap Perumahan (ITP)<span class="required" style="color:red;">*</span></label>
                </label>
    
                  <div class="col-md-6 col-sm-6 col-xs-12" align="left">
                  <?=
                    $form->field($pend, 'itp')->widget(NumberControl::classname(), [
                         'name' => 'itp',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         'options' => $saveOptions,
                         'displayOptions' => [
                            'placeholder' => Yii::t('app', 'Contoh: ').'RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
                  
                </div>
            </div>
            
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Elaun Perumahan Wilayah (EPW)<span class="required" style="color:red;">*</span></label>
                </label>
            
                <div class="col-md-6 col-sm-6 col-xs-12" align="left">
                  <?=
                    $form->field($pend, 'epw')->widget(NumberControl::classname(), [
                         'name' => 'epw',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         'options' => $saveOptions,
                         'displayOptions' => [
                            'placeholder' => Yii::t('app', 'Contoh: ').'RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
                  
                </div>

            </div>
             
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Simpan',['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
</div>