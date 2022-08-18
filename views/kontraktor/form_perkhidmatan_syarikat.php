<?php

use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;  
use yii\helpers\ArrayHelper; 
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
?> 
<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="x_panel"> 
    <div class="x_title">
       <h2>Perkhidmatan Kontraktor </h2> 
        <div class="form-group text-right">
            <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    
 
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Kontraktor: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                  <?= $form->field($record, 'apsu_lname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>

                </div>
            </div>
        </div>
        
        
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jenis Perkhidmatan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?=
                    $form->field($model, 'jenis_kontrak')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\Kontraktor\RefKontrakType::find()->all(), 'id', 'jenis_desc'),
                        'options' => ['class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                 <?php $form->field($model, 'jenis_kontrak')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>

                </div>
            </div>
        </div>  
        <div class="form-group text-center">
               <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Simpan'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']])?>
               <button class="btn btn-primary" type="reset">Reset</button>
            </div>
    </div>
</div>
 <?php ActiveForm::end(); ?>  
</div>