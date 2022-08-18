<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\hronline\MajorMinor; 
use kartik\select2\Select2;
use app\models\hronline\Negara;
/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>KEMASKINI SEMAKAN</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
       
       <table class="table table-sm table-bordered">
    
           <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">SEMAKAN PERMOHONAN:</th>
                        <td colspan="5">
                        <?php
                                echo $form->field($model,'status_semakan')->
                                dropDownList(['Layak Dipertimbangkan' => 'LAYAK DIPERTIMBANGKAN', 'Tidak Layak Dipertimbangkan'=>'TIDAK LAYAK DIPERTIMBANGKAN',
                                              'Dokumen Tidak Lengkap' => 'DOKUMEN TIDAK LENGKAP'
                                            ],['prompt'=>'Pilih Status Semakan'])->label(false);
?>
                        </td>
                 </tr>
</td>
    </tr>

               
                    <tr> 
                        <th style="width:10%" align="right">CATATAN:</th>
            <td>                    <?= $form->field($model, 'ulasan_bsm')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>

                       
                    </tr>
    
    
</table>

        
            
        
        
    </div>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    

        
    <div class="x_content">
  
       
        
        
        
        
      
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>

    </div>
    </div>
</div>

