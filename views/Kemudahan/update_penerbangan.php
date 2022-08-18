<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; 
use kartik\widgets\SwitchInput; 
use kartik\select2\Select2;

error_reporting(0);
?>


 
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,211], 'vars' => []]); ?>
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Kemaskini Penerbangan</strong></h2>
                <div class="form-group text-right">
                <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
                </div>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Penerbangan<span class="required"> *</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                 <?= $form->field($model, 'penerbangan')->textInput(['maxlength' => true, 'placeholder' => 'Penerbangan']) ->label(false);?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Penerbangan<span class="required"> *</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               <?= $form->field($model, 'flightType')->label(false)->widget(Select2::classname(), [
                                'data' => [
                                '1' => 'Perlepasan (Depart)', 
                                '2' => 'Ketibaan (Arrival)',
                               
                             ],
                                'options' => [
                                        'placeholder' => 'Sila Pilih'],

                            ]); ?> 
            </div>
        </div>
 
         
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              
             
                 <?php $model->isActive = 0; ?>
                <?= $form->field($model, 'isActive')->checkbox()->label(false); ?>


              
            </div>
        </div> 
         
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
            <?php ActiveForm::end();?>
    </div>
    </div>
</div>