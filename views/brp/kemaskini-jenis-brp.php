
<?php
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\number\NumberControl;
// as a widget
/* @var $form CActiveForm */

use dosamigos\datepicker\DatePicker;
?>

<div class="row">
<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2>Kemaskini Rekod BRP Pegawai</h2>
        
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
           
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

   
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tajuk Brp<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($kemaskini, 'brpTitle')->textarea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            
            
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan Brp<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($kemaskini, 'brpBottomDesc')->textarea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            
              
     

            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
           
                    <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <!--form-->
        </div>
    </div>
</div>
</div>

