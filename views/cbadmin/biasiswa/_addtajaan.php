<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
error_reporting(0);
?>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>TAMBAH REKOD PENAJAAN</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
        
       
<table class="table table-sm table-bordered">
            
                    

                     
                    <table class="table table-striped table-sm  table-bordered">
                            <thead>
                        <tr> 
                        <th style="width:10%" align="right">JENIS TAJAAN</th>
                        <td style="width:40%"><?php
            echo $form->field($b,'jenisCd')->
            dropDownList(['3' => 'KEMENTERIAN PENGAJIAN TINGGI',
                          '2' => 'UNIVERSITI MALAYSIA SABAH', 
                          '1'=>'TAJAAN LUAR',
                          '4' =>'TANPA TAJAAN',
//                          'TIKET'=> 'TIKET PENERBANGAN',
                        
                        ],['prompt'=>'Pilih Nama Agensi/Tajaan'])->label(false);
?> </td>
                       
                    </tr>  
                    
                    <tr> 
                        <th style="width:10%" align="right">NAMA TAJAAN</th>
                        <td style="width:20%">                    <?= $form->field($b, 'nama_tajaan')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?></td>

                       
                    </tr> 
                    <tr> 
                        <th style="width:10%" align="right">BENTUK TAJAAN</th>
                        <td style="width:40%"><?php
            echo $form->field($b,'BantuanCd')->
            dropDownList(['1' => 'SLAB',
                          '2' => 'SLAI',
                          '3' => 'UMS - YURAN PENGAJIAN SAHAJA',
                          '4'=> 'DANA UMS' ,
                          '5'=>'TANPA TAJAAN',
                          '6' =>'YURAN PENGAJIAN',
                          '8' => 'SARA HIDUP',
                          '7'=> 'TIKET PENERBANGAN',
                        
                        ],['prompt'=>'Pilih Nama Agensi/Tajaan'])->label(false);
?> </td>
                       
                    </tr> 
                    
                    <tr> 
                        <th style="width:10%" align="right">CATATAN</th>
                        <td style="width:20%">                    
                <?= $form->field($b, 'c_tajaan')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?></td>

                       
                    </tr>  
                    <tr> 
                        <th style="width:10%" align="right">LOKASI PENGAJIAN:</th>
                         <td style="width:30%">                   

        
                    <?= $form->field($model, 'lokasi')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?></td>
                       
                    </tr>
                       
                    <tr> 
                        <th style="width:10%" align="right">TARIKH MULA PENAJAAN</th>
                        <td style="width:20%">      
                 <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'dt_stajaan',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?></td>
                       
                    </tr>
                    
                                  
                    <tr> 
                        <th style="width:20%" align="right">TARIKH TAMAT PENAJAAN:</th>
                        <td style="width:30%">                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'dt_ntajaan',
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
                        <th style="width:10%;" >JENIS KADAR:</th>
                         <td style="width:30%">                   
<?php
            echo $form->field($model,'kadar')->
            dropDownList(['KADAR A' => 'KADAR A ',
                          'KADAR B' => 'KADAR B', 
                          
                        ],['prompt'=>'Jenis Kadar'])->label(false);
?></td>
                       
                    </tr>
                    
                    
                    <tr> 
                        <th style="width:10%;" >AKUAN MEMBAWA KELUARGA (YA/TIDAK)</th>
                         <td style="width:30%">                   
<?php
            echo $form->field($model,'family')->
            dropDownList(['YA' => 'YA ',
                          'TIDAK' => 'TIDAK', 
                          
                        ],['prompt'=>'Akuan Akan Membawa Keluarga'])->label(false);
?></td>
                       
                    </tr>
                    
                    <tr> 
                        <th style="width:10%;" >PASANGAN</th>
                         <td style="width:30%">                   
<?php
            echo $form->field($model,'pasangan')->
            dropDownList(['ISTERI' => 'ISTERI ',
                          'SUAMI' => 'SUAMI',
                          '0' => '-',
                          
                        ],['prompt'=>'Pasangan'])->label(false);
?></td>
                       
                    </tr>
                    
                    <th style="width:10%" align="right">ANAK</th>
                         <td style="width:30%">                   
               <?php
            echo $form->field($model,'anak')->
            dropDownList(['1' => '1 ',
                          '2' => '2',
                          '3' => '3 ATAU LEBIH',
                          '0' => '-'
                          
                        ],['prompt'=>'Bilangan Anak yang dibawa'])->label(false);
?>
</td>
<tr> 
                        <th style="width:20%" align="right">TARIKH MULA BAWA KELUARGA:</th>
                        <td style="width:30%">                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 't_bk',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]).'<b> HINGGA</b>'.DatePicker::widget([
                        'model' => $model,
                        'attribute' => 't_bkt',
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
                   
                   
                    
                    
                     
                     
                                
<!--                                <tr class="headings">
                                    <th class="column-title text-center">Telah Dimuatnaik</th>
                                    <th class="column-title text-center">Belum Dimuatnaik</th>
                                </tr>-->
                            </thead>
                        
                                     
<!--                                   // <td class="text-center">
                                        <?//php
                                   if (!$k->namafile)
                                       {
                                     echo '&#10008;'; }?></td>
                                 
                                </tr>-->
                                
                      
                        </table>
                    </div> 

        </div>
                    
    


         
        
        
        


    </div>
    </div>



        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
<center> <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?></center>
            </div>    </div>
        </div>

<?php ActiveForm::end(); ?>








