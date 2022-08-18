<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;


?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>KEMASKINI REKOD ELAUN INDIVIDU YANG DILULUSKAN</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
           <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">ESH:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'esh')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
           <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">EBSR:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ebsr')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
           <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">EBK:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ebk')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
           <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">CATATAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
          
         
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>
        
        

<?php ActiveForm::end(); ?>

    </div>
    </div>
</div>
</div>
