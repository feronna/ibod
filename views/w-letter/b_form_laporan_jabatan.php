<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;  
use kartik\date\DatePicker;
?>  
<?= $this->render('menu') ?> 
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 

    <div class="x_panel"> 
        <div class="x_title">
            <h2>Laporan Bulanan Jabatan WFO</h2> 
            <p align="right">
            <?= Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
        </p>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    
             
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Bulan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">    
                    <?=
                $form->field($model, 'isActive')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Bulan'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'startView' => 'year',
                        'minViewMode' => 'months',
                        'format' => 'mm'
                    ]
                ])->label(false);
                ?> 
                </div>
            </div> 
            
            <div class="form-group text-center">
                <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
                <?= Html::submitButton('Jana', ['class' => 'btn btn-success']) ?>
            </div>

        </div>
    </div>   

    <?php ActiveForm::end(); ?> 

</div>  

