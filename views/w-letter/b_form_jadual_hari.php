<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;
?>  
<?= $this->render('menu') ?>  
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 

<div class="x_panel"> 
    <div class="x_title">
        <h2>Carian Senarai Bulanan</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">     
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun dan Bulan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">    
                <?=
                $form->field($model, 'shortname')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Bulan'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'startView' => 'year',
                        'minViewMode' => 'months',
                        'format' => 'mm-yyyy'
                    ]
                ])->label(false);
                ?> 
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">  
                <div class="form-group text-center">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?>
                    <?= \yii\helpers\Html::a('Reset', ['carian-set-jadual-hari'], ['class' => 'btn btn-danger']) ?>

                </div>
            </div>
        </div> 



    </div>
</div>   

<?php ActiveForm::end(); ?> 

 



