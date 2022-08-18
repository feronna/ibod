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
<h5> <strong><center>REKOD NOMINAL DAMAGES</center></strong> </h5>
<div> 
    <div class="x_panel"> 
     
            
            
 <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">STATUS PERKHIDMATAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                     <span class="label label-warning"> <?=  strtoupper($model->kakitangan->serviceStatus->ServStatusNm);?></span>
                           
                       
     
            </div>
            </div>

        
        
         <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH PATUT MULA:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
<?=
                    DatePicker::widget([
                        'model' => $nd,
                        'attribute' => 'dt_nominal',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
     
            </div>
            </div>
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH BERSETUJU:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
<?=
                    DatePicker::widget([
                        'model' => $nd,
                        'attribute' => 'dt_setuju',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
     
            </div>
            </div>
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH TAMAT:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
 <?=
                    DatePicker::widget([
                        'model' => $nd,
                        'attribute' => 'nd_nominal',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>

            </div>
            </div>
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">JUMLAH NOMINAL DAMAGES (BULANAN):<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
<?php
            echo $form->field($nd,'j_nd')->
            dropDownList([
                          '700' => 'RM700',
                          '500' => 'RM500 ',
                          '250' => 'RM250', 
                          
                        ],['prompt'=>'Jumlah Bulanan'])->label(false);
?>
     
            </div>
            </div>
        
       
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                                     <?= $form->field($nd, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>


            </div>
            </div>
        
         <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>
         <!-- <div class="ln_solid"></div> -->
            
        </div>
    </div>

            <?php ActiveForm::end(); 
            Pjax::end();?>
