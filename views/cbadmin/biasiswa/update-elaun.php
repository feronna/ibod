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
<h5> <strong><center>KEMASKINI MAKLUMAT PENAJAAN</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
        <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenisCd">Nama Agensi/Tajaan:<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
          
            
             <?php
            echo $form->field($c,'jenisCd')->
            dropDownList(['3' => 'KEMENTERIAN PENGAJIAN TINGGI',
                          '2' => 'UNIVERSITI MALAYSIA SABAH', 
                          '1'=>'TAJAAN LUAR',
//                          'TIKET'=> 'TIKET PENERBANGAN',
                        
                        ],['prompt'=>'Pilih Nama Agensi/Tajaan'])->label(false);
?>
                               
<!--                              <div id="test" style="display: none">
                                        <?= $form->field($c, 'jenisCd')->textInput()->label(false); ?>
                              </div>-->
                                
        </div>
                </div>
                
           
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA TAJAAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($c, 'nama_tajaan')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">BENTUK TAJAAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
<?php
            echo $form->field($c,'BantuanCd')->
            dropDownList(['1' => 'SLAB',
                          '2' => 'SLAI',
                          '3' => 'UMS - YURAN PENGAJIAN SAHAJA',
                          '4'=> 'DANA UMS' ,
                          '5'=>'TANPA TAJAAN',
                          '6' =>'YURAN PENGAJIAN',
                          '8' => 'SARA HIDUP',
                          '7'=> 'TIKET PENERBANGAN',
                        
                        ],['prompt'=>'Pilih Nama Agensi/Tajaan'])->label(false);
?>                </div>
            </div>
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">CATATAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($c, 'c_tajaan')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">LOKASI PENGAJIAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'lokasi')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH MULA PENAJAAN:<span class="required"></span>
                 </label>                           
            
            
            <div class="col-md-6 col-sm-6 col-xs-12">

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
                    ?>
            </div>
        </div>
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH TAMAT PENAJAAN:<span class="required"></span>
                </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                 <?=
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
                    ?></div>
            </div>
        
         
       
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">JENIS KADAR:<span class="required"></span>
                </label>

             <i class="fa fa-info-circle fa-lg"  data-toggle="tooltip" title="Kadar A: Kuala Lumpur, Pulau Pinang, Seberang Perai, Johor Bahru, Shah Alam,
                Sepang, Klang, Kajang, Petaling Jaya, Ampang, Sabah dan Sarawak. Kadar B:  Tempat–tempat lain"></i>
         <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'kadar')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            
            
            </div>
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">AKUAN MEMBAWA KELUARGA:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php
            echo $form->field($model,'family')->
            dropDownList(['YA' => 'YA ',
                          'TIDAK' => 'TIDAK', 
                          
                        ],['prompt'=>'Akuan Akan Membawa Keluarga'])->label(false);
?>
                </div>
            </div>
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">PASANGAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php
            echo $form->field($model,'pasangan')->
            dropDownList(['ISTERI' => 'ISTERI ',
                          'SUAMI' => 'SUAMI',
                          '0' => '-',
                          
                        ],['prompt'=>'Pasangan'])->label(false);
?>
                </div>
            </div>
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">ANAK:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                                       <?= $form->field($model, 'anak')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>

                </div>
            </div>
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH MULA MEMBAWA KELUARGA:<span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-9">
        <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'bk',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]).' HINGGA'.DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'bk1',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
            </div>
        
       
        
        
       
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
</div>
