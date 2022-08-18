<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\number\NumberControl;
use kartik\date\DatePicker;

?>
 
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,1410,1470], 'vars' => []]); ?>
<?php $form = ActiveForm::begin([ 'options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Kemaskini Tempahan Penerbangan</strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
         <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA : <span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model->kakitangan, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>

            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Tempahan : <span class="required"  style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               <?= $form->field($model, 'status_tempahan')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
 
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">HARGA :<span class="required"  style="color:red;"> *</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               <?=
                    $form->field($model, 'jumlah')->widget(NumberControl::classname(), [
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH EMAIL DIHANTAR : <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              
               <?= $form->field($model, 'email_send')->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>
            </div>
        </div> 
        
        <div class="customer-form">  
                <div class="form-group" align="left">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
                    <br>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                 
                </div>
                </div>
            </div> 
        <div class="ln_solid"></div>
    </div>
    </div>
</div> <?php ActiveForm::end(); ?>

          