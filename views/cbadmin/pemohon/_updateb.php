<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\MajorMinor; 

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>KEMASKINI MAKLUMAT PEMBIAYAAN/PINJAMAN</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
       
       <table class="table table-sm table-bordered">
    
    
    <tr>
            <td width="40%"><strong>NAMA AGENSI/TAJAAN:</strong></td>
            <td><?= $form->field($model, 'nama_tajaan')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
</td>
    </tr>
    
     <tr> 
                        <th style="width:10%" align="right">BENTUK TAJAAN</th>
                        <td style="width:40%"><?php
            echo $form->field($model,'jenisCd')->
            dropDownList(['3' => 'KEMENTERIAN PENGAJIAN TINGGI',
                          '2' => 'UNIVERSITI MALAYSIA SABAH', 
                          '1'=>'TAJAAN LUAR',
                          '4' =>'TANPA TAJAAN',
//                          'TIKET'=> 'TIKET PENERBANGAN',
                        
                        ],['prompt'=>'Pilih Nama Agensi/Tajaan'])->label(false);
?> </td>
                       
                    </tr>
                    <tr> 
                        <th style="width:10%" align="right">AMAUN (RM)</th>
            <td><?= $form->field($model, 'amaunBantuan')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                       
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

