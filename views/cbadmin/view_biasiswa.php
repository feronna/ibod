<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;


?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>MAKLUMAT PENAJAAN</center></strong> </h5>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
        
       
<table class="table table-sm table-bordered">
    <tr>
            <td width="40%"><strong>NAMA BIASISWA:</strong></td>
            <td><?= $model->nama_tajaan; ?></td>
    </tr>
    
    <tr>
            <td width="40%"><strong>TARIKH MULA TAJAAN:</strong></td>
            <td><?= $form->field($model, 'dt_stajaan')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
</td>
    </tr>
    
      <tr>
            <td width="40%"><strong>TARIKH TAMAT TAJAAN:</strong></td>
            <td><?= $form->field($model, 'dt_ntajaan')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
</td>
    </tr>
    
       <tr>
            <td width="40%"><strong>PELANJUTAN TAJAAN PERTAMA:</strong></td>
            <td><?= $form->field($model, 'lanjut_biasiswa')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
</td>
    </tr>
    
    <tr>
            <td width="40%"><strong>CATATAN:</strong></td>
            <td><?= $form->field($model, 'lanjut_biasiswa')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
</td>
    </tr>
    
    
    
</table>
        
        
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
