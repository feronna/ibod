<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2; 
use yii\helpers\ArrayHelper;
use app\models\Kemudahan\Refjeniskemudahan;
use app\models\Kemudahan\Refakaun;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\SwitchInput;
use kartik\date\DatePicker;
error_reporting(0);
?>


<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,211], 'vars' => []]); ?>
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Buka / Tutup Permohonan</strong></h2>
                <div class="form-group text-right">
                <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
                </div>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
         <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Kemudahan<span class="required"> :</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'jeniskemudahan')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Refjeniskemudahan::find()->all(), 'kemudahancd', 'kemudahan'),
                    'options' => [
                            'placeholder' => 'Sila Pilih'],

                ]); ?>
                
            </div>
        </div>
<!--        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Permohonan<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">-->
                <?php
                    $form->field($model, 'status')->label(false)->widget(Select2::classname(), [
                          'value' => ['Please Select' => 'Please Select'],
                          'data' => [
//                                'Please Select' => 'Please Select', 
                                '1' => 'Open',
                                '0' => 'Close', 
                                ],
                        'options' => ['placeholder' => 'Please Select','class' => 'form-control col-md-7 col-xs-12',  'value' => 'Close',
                            'onchange' => 'javascript:if ($(this).val() == "0"){
                        $("#place-holder").show();
                        }
                        else{
                        $("#place-holder").hide();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
<!--                    <div class="col-md-3 col-sm-8 col-xs-8">
                   <input type="number" id="place-holder" name="tempohs" class="form-control" maxlength="20" style="display: none" placeholder="bulan    cth: 6">
                   
                    </div>-->
                    
<!--            </div>
        </div>-->
        <div id = "place-holder" class="form-group">
        <div class="form-group">
           <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Tarikh Buka 
            </label> 
            <div class="col-md-4 col-sm-4 col-xs-10">
                <?= $form->field($model, 'startDate')->label(false)->widget(DatePicker::classname(),[
                    'readonly' => false,
                    'removeButton' => false,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
//                        'startDate'=>date('startDate'),
//                        'minDate'=>'0'
                    ],
                    'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1',  ],
                    ]); ?>

            </div>
         </div>
        <div class="form-group">
           <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Tarikh Tutup 
           </label> 
            <div class="col-md-4 col-sm-4 col-xs-10">
                <?= $form->field($model, 'endDate')->label(false)->widget(DatePicker::classname(),[
                    'readonly' => false,
                    'removeButton' => false,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
//                        'startDate'=>date('endDate'),
//                        'minDate'=>'0'
                    ],
                    'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1' ],
                    ]); ?>

            </div>
         </div>
            
         <?php if($model->status == 0 || $model->status == 'Please Select'){ ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan<span class="required"> :</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                
                <?= $form->field($model, 'reason')->textarea(array('rows'=>6,'cols'=>5, 'disabled'=>'disabled'))->label(false);?>   
                 
            </div>
            <div style="color: red; margin-top: 0px;">
                   <strong>*Catatan untuk membuka atau tutup permohonan.  </strong>
        </div>
        </div>
         <?php }else{?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan<span class="required"> :</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                
                <?= $form->field($model, 'reason')->textarea(array('rows'=>6,'cols'=>5))->label(false);?>  
                 
            </div>
            <div style="color: red; margin-top: 0px;">
                   <strong>*Catatan untuk membuka atau tutup permohonan.  </strong>
        </div>
        </div> 
         <?php }?>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                 <button class="btn btn-primary" type="reset">Reset</button>
            </div>
        </div>
            <?php ActiveForm::end();?>
    </div>
    </div>
</div>