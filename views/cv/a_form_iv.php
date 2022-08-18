<?php

use kartik\form\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
?>   


<div class="x_panel">
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">SET INTERVIEW</p>
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
    <div class="x_content">  
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Date: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?=
                DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'tarikh_iv',
                    'template' => '{input}{addon}',
                    'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'required' => 'required', 'placeholder' => 'Start Date'],
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Time: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <?= $form->field($model, 'masa_iv')->textInput()->label(false); ?> 
            </div>  
            <div class="col-md-3 col-sm-3 col-xs-12">
                <span class="required" style="color:red;">ie: 9.00 AM -  5.00 PM</span>
            </div>
        </div>  
        <div class="form-group text-center">
            <?= \yii\helpers\Html::a('Cancel', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?> 
    </div>
</div>   
</div>  
