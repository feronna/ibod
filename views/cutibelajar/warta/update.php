<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
error_reporting(0);
?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>KEMASKINI MAKLUMAT MMC</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
       
        

           <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">NO. PENDAFTARAN MMC:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                      <?= $form->field($model, 'no_daftar_mmc')->textInput()->label(false);?>    

                </div>
            </div>
         <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">NO. APC TERKINI:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                      <?= $form->field($model, 'no_apc')->textInput()->label(false);?>    

                </div>
            </div>
        
       
        
        

        
        

    </div>
    </div>
</div>
</div>


  
        
        
        
        
        
      
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>




