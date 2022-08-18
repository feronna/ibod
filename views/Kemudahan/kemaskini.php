<?php
use kartik\number\NumberControl;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

error_reporting(0);
?>


<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,211], 'vars' => []]); ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Kemasikini Kemudahan</strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
                
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
          
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Kemudahan<span class="required"> *</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                 <?= $form->field($model , 'kemudahan')->textInput(['maxlength' => true, 'placeholder' => 'Nama Kemudahan']) ->label(false);?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">KodAkaun<span class="required"> *</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                 <?= $form->field($modelakaun , 'kodAkaun')->textInput(['maxlength' => true, 'placeholder' => 'Nama Kemudahan']) ->label(false);?>
            </div>
        </div>
 
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah<span class="required">*</span>
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Keseluruhan Kemudahan<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                   <?=
                    $form->field($model, 'amount')->widget(NumberControl::classname(), [
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
        <div class="customer-form">  
                <div class="form-group" align="center">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2"> 
                    <br>
                    <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
                   
                </div>
                </div>
            </div>  
       

        <div class="ln_solid"></div>
 
    </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

 

