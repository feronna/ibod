<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
//error_reporting(0);
?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<h5> <strong><center>KEMASKINI ULASAN</center></strong> </h5>

<div class="col-md-12 col-sm-12 col-xs-12">
   <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list-alt"></i> Hasil Semakan</strong></h2>
            <div class="clearfix"></div>
        </div>
        <br>
        <div class="form-group">
           
                <label class="control-label col-md-3 col-sm-3 col-xs-3">Semakan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                     <?php
            echo $form->field($kontrak,'status_semakan')->
            dropDownList(['Layak Dipertimbangkan' => 'LAYAK DIPERTIMBANGKAN', 
                          'Dokumen Tidak Lengkap' => 'DOKUMEN TIDAK LENGKAP'
                
                          
                        ])->label(false);
?>
                    
                </div>
        </div>
          
        <div class="form-group" align="center">
            <h5 style="font-size:120%;" class="text-justify"> 
                </h5>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan: <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_bsm')->textArea(['maxlength' => true, 'rows' => 8])->label(false); ?>
                </div>
        </div>
        
            <div class="ln_solid"></div>
            
    </div>
</div>


  
        
        
        
        
        
      
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>




