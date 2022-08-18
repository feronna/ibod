<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;

error_reporting(0);
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>


<h5> <strong><center>REKOD LAPOR DIRI</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
        
       
<table class="table table-sm table-bordered">
            
                    

                     
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                           
                       <tr> 
                        <th style="width:10%" align="right">TARIKH LAPOR DIRI</th>
                        <td style="width:20%">     <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'dt_lapordiri',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
</td>
                       
                    </tr>         
                    <tr> 
                        <th style="width:10%" align="right">STATUS PENGAJIAN</th>
                        <td style="width:20%">
                 <?php
            echo $form->field($model,'status_pengajian')->
            dropDownList([
                          '1' => 'LULUS/SELESAI PENGAJIAN',
                          
                          '2' => 'SEDANG MENULIS',
                          '3' => 'SEDANG TUNGGU VIVA',
                          '4' => 'TELAH HANTAR DRAF TESIS AKHIR KEPADA PENYELIA (SEMUA BAB)',
                          '5' => 'TELAH VIVA (MAJOR / MINOR COREECTION)',
                          "6"=> 'TUNGGU KEPUTUSAN RASMI',
                          '7' => 'GAGAL PENGAJIAN',
                          "12"=> 'MENDAFTAR DAN DIBENARKAN MENGULANG PEPERIKSAAN DALAM TEMPOH 6 BULAN',

                          '13' => 'GAGAL PENGAJIAN DAN DIBERHENTIKAN',
                          'GAGAL PENGAJIAN DAN MELETAK JAWATAN' => 'GAGAL PENGAJIAN DAN MELETAK JAWATAN',
                          "MIA"=> 'MIA',


//                          'TIDAK BALIK LAPOR DIRI' => 'MELETAK JAWATAN'
                          
                        ],['prompt'=>'Status Pengajian'])->label(false);
?></td>
                       
                    </tr>
                    <tr> 
                        <th style="width:10%" align="center">SELESAI-GOT?</th>
                        <td style="width:20%"> 
                         <?php
            echo $form->field($model,'got')->
            dropDownList(['1' => 'YA ',
                          '2' => 'TIDAK', 
                          
                        ],['prompt'=>'GOT'])->label(false);
?></td>
                       
                    </tr>
                    <tr> 
                        <th style="width:10%" align="right">TARIKH SELESAI</th>
                        <td style="width:20%">     <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'dt_selesai',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
</td>
                       
                    </tr>
                    
                     <tr> 
                        <th style="width:10%">CATATAN [TARIKH SELESAI]</th>
                        <td style="width:20%"><?= $form->field($model, 'c_nd')->textarea(['maxlength' => true, 'rows' => 6])->label(false); ?>
</td>
                       
                    </tr>
                   
                    <tr> 
                        <th style="width:10%">CATATAN</th>
                        <td style="width:20%">         <?= $form->field($model, 'catatan')->textarea(['maxlength' => true, 'rows' => 6])->label(false); ?>
</td>
                       
                    </tr>
                    
                    
                    
                    
                  
                    
                    <tr> 
                        <th style="width:10%" align="right">TARIKH MULA NOMINAL DAMAGES</th>
                        <td style="width:20%">         
      <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'dt_nominal',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
</td>
                       
                    </tr>
                    
                   
                    
                 
                    
                     
                    
                    
                     

                            </thead>
                        
                                     
                        </table>
    
            
         <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>
                    
            <?php ActiveForm::end(); ?>


<!--        
         <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       
                <? //Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>-->
         
        
        
        


    </div>
    </div>