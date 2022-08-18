<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


error_reporting(0);
/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

?> 

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

     

    <div class="x_panel">
        <div class="x_content">
           <span class="required" style="color:black;">
                <strong>
                    <center><?= strtoupper('
   <u><h2><strong>REKOD ELAUN KAKITANGAN</strong></h2></u></b>
 '); ?>
                </strong> </center>
            </span> 
        </div>
   
    </div>

 <div class="row">
     
    <div class="col-xs-12 col-md-12 col-lg-12" >

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $view;?>">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i>KEMENTERIAN PENGAJIAN TINGGI (KPT)</strong></h2>

        <div class="clearfix"></div>
        </div>
        <div class="x_content">
<table class="table table-striped table-sm  table-bordered">
<thead>
                                 
                    <tr> 
                        <th style="width:10%" align="right">NAMA TAJAAN</th>
                        <td style="width:20%"><?=
                        strtoupper($b->nama_tajaan) ?></td>
                       
                    </tr>  
                     <tr> 
                        <th style="width:10%" align="right">JENIS KADAR: 
                           <i class="fa fa-info-circle fa-lg"  data-toggle="tooltip" title="Kadar A: Kuala Lumpur, Pulau Pinang, Seberang Perai, Johor Bahru, Shah Alam,
                        Sepang, Klang, Kajang, Petaling Jaya, Ampang, Sabah dan Sarawak. Kadar B:  Tempat–tempat lain"></i></th>
                         <td style="width:30%">                   
                        <?= $form->field($model, 'kadar')->widget(Select2::classname(), 
                       [ 'data' => ['KADAR A' => 'KADAR A', 'KADAR B' => 'KADAR B'],
                        
                         'options' =>['placeholder' => 'Pilih Kadar', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "KADAR A"){
                        $("#a").show();$("#b").hide();
                        }
                        else if($(this).val() == "KADAR B"){
                        $("#b").show();$("#a").hide();}
                        
                        else{$("#a").hide();$("#b").hide()
                        }'
                        ],
                            
                            'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label(false); ?></td>
                       
                    </tr>
                          
                    <tr  id="a" style="display: none"> 
                        <th style="width:10%" align="right">JENIS ELAUN</th>
                        <td style="width:20%">      <?= $form->field($model, 'jenis_elaun')->widget(Select2::classname(), 
                        ['data' => 
                            ArrayHelper::map(app\models\cbelajar\RefTblElaunA::find()->WHERE(['jenis_kadar'=>"A"])->
                                    orderBy(['id' => SORT_ASC,])->all(), 'id', 'nama_elaun'),
                        
                            'options' => [
                            'placeholder' => 'Pilih Jenis Elaun','class' => 'form-control col-md-7 col-xs-12'],
                            
                            'pluginOptions' => [
                            'allowClear' => true,
                             'multiple' => true
                        ],
                    ])->label(false); ?></td>
                       
                    </tr>
                    
                    
                    <tr  id="b" style="display: none"> 
                        <th style="width:10%" align="right">JENIS ELAUN</th>
                        <td style="width:20%">      <?= $form->field($model, 'jenis_elaun')->widget(Select2::classname(), 
                        ['data' => 
                            ArrayHelper::map(app\models\cbelajar\RefTblElaunA::find()->WHERE(['jenis_kadar'=>"B"])->
                                    orderBy(['id' => SORT_ASC,])->all(), 'id', 'nama_elaun'),
                        
                            'options' => [
                            'placeholder' => 'Pilih Jenis Elaun','class' => 'form-control col-md-7 col-xs-12'],
                            
                            'pluginOptions' => [
                            'allowClear' => true,
                             'multiple' => true
                        ],
                    ])->label(false); ?></td>
                       
                    </tr>
                   
                   
                   

                            </thead>

                                
                      
                        </table>
                    </div> 
    </div>
</div>     
</div>
 <div class="row">
  <!-- Perakuan Ketua Jabatan -->
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $edit;?>"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-graduation-cap"></i> KEMENTERIAN PENGAJIAN TINGGI (KPT)</strong></h2>
            
            <div class="clearfix"></div>
        </div>
        <br>
        <div class="form-group">
           
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Status Perakuan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'kadar')->widget(Select2::classname(), 
                       [ 'data' => ['KADAR A' => 'KADAR A', 'KADAR B' => 'KADAR B'],
                        
                         'options' =>['placeholder' => 'Pilih', 
                            'onchange' => 'javascript:if ($(this).val() == "KADAR A"){
                        $("#a").show();$("#b").show();
                        }
                        else if($(this).val() == "KADAR B"){
                        $("#b").show();$("#a").hide();}
                        
                        else{$("#a").hide();$("#b").hide()
                        }'
                        ],
                            
                            'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label(false); ?>
                </div>
        </div>
        <div class="form-group" id="a" style="display: none" align="center">
        <div style="width: 580px; height: 130px;border:2px solid red">
            <br><p align="left">&nbsp;Saya mengesahkan bahawa semua kenyataan yang diberikan oleh pemohon adalah benar.<br>
               &nbsp;1. Tarikh dan tempoh cuti belajar sesuai.<br>
               &nbsp;2. Fungsi JFPIU tidak akan terjejas sepanjang ketidakberadaan kakitangan.<br>
               &nbsp;3. Saya bersetuju untuk memberi pelepasan kepada beliau tanpa staf gantian.</p>
            </div>
        </div>        
        <div class="form-group" id="b" style="display: none" align="center">
            <h5 style="font-size:120%;" class="text-justify"> 
                </h5>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>
        
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
    </div>
</div>
        

    </div>
    </div>
   <?php ActiveForm::end(); ?>
    </div>




