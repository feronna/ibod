<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;

error_reporting(0);
?>

  





<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
 <strong><center>KEMASKINI ELAUN PEMBAYARAN</center></strong> </h5>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
        
       
<table class="table table-sm table-bordered">
            
                    

                     
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                
                                <tr class="headings">
                                    <th class="text-center" colspan="3"> <?= $pengajian->HighestEduLevel?></th>
                                </tr>
                       
                    <tr> 
                        <th style="width:10%" align="right">JENIS ELAUN</th>
                        <td style="width:20%"><?=
                        strtoupper($pmodel->esh) ?></td>
                       
                    </tr>
                    
                    
                            </thead></table>
 
        
        
       
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

