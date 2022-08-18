<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$statusLabel = [
        1 => '<span class="label label-success">Telah Dihantar</span>',
        null => '<span class="label label-warning">Belum Dihantar</span>',
];
$statusLabel2 = [
        1 => '<span class="label label-success">BERSALAH</span>',
        2 => '<span class="label label-warning">TIDAK BERSALAH</span>',
];
?>
  $title = $this->title = 'Maklum Balas Kakitangan';
?>
<style>

    .html-marquee {
        height: auto;
        /*background-color:#ffff33;*/
        /*font-family:Cursive;*/
        font-size:14px;
        color:red;
        /*border-width:4;*/
        /*border-style:dotted;*/
        /*border-color:#ff0000;*/
    }
    
    .hash{
        font-size: 17px;
    }
</style>

        <?php echo $this->render('/keterhutangan/_menu'); ?>
<div class="row">
<div class="col-md-12 col-xs-12"> 
  <div class="x_panel">
 
        <div class="x_content">
             <div class="table-responsive">
                <strong>  
                    
                    Sebarang pertanyaan dan kemusykilan mengenai sistem Keterhutangan Serius sila hubungi talian berikut:<br/><br/>
                  
                      <table  class="table table-bordered jambo_table">
                        <tr>
                            <td width="1px">Nama Sistem</td>
                            <td width="1px">Tindakan Tatatertib Staf</td>
                        </tr>
                        
                     <tr>
                            <td width="1px">Garis Panduan</td> 
                            <td width="1px"> <?php ?>
                    <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to('@web/files/guideline_ptb.pdf'); ?>" target="_blank" ><u>Garis Panduan.pdf</u></a>
                    <?php 
?></td>
                        </tr>  
                         <tr>
                            <td width="1px">Manual Pengguna</td> 
                            <td width="1px"> <?php ?>
                    <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to('@web/files/manual_pengguna_ptb.pdf'); ?>" target="_blank" ><u>Manual Pengguna.pdf</u></a>
                    <?php 
?></td>
                        </tr>  
                        <tr>
                            <td width="1px">Pegawai Bertanggungjawab</td> 
                            <td width="1px">1. Cik Hadijah Binti Engson     (Tel: 088-320000 Samb. 1523)<br>
                             2. Cik Hafizah Binti Hassan  (Tel: 088-320000 Samb. 144)</td>
                        </tr>  
                    </table>
                    
                </strong>
             </div>
        </div>
        </div>
</div>
</div>        
       

<div class="row">
<div class="col-md-12 col-xs-12"> 
   <div class="x_panel">
        <div class="x_title">
            <h2>Maklumbalas Kakitangan</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
           
<!--            <p style="color: green">
                * Permohonan Pertukaran sekali sahaja.
            </p>-->
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

               <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Surat Tunjuk Sebab
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                     <?php foreach ($models as $key=>$item): ?>
                        <tr>
                      
                      <td align= 'center'>         
                         <u><?= \yii\helpers\Html::a('SuratTunjukSebab.pdf', ['tatatertib-staf/surat-tunjuk-sebab', 'id' => $item->id], [ 'target' => '_blank']) ?>
                        </td></u>

                <?php endforeach;?>
                        </div>
                    </div>
            
                 
            
            <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kakitangan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= strtoupper($biodata->kakitangan->CONm)?>" disabled="">

                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
           
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Maklumbalas<span class="required" style="color:red;">*</span></label>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($biodata, 'reason')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            
                  <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen Sokongan :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                   <?php
                    if (!empty($biodata->file) && $biodata->file != 'deleted') {
                        echo Html::a(Yii::$app->FileManager->NameFile($biodata->file));
                        echo '&nbsp&nbsp&nbsp&nbsp';
                    }
                    else{
                       echo $form->field($biodata, 'file')->fileInput()->label(false);
                    }
                    ?>
                  <p style="color: green;">
         
        Pemohon boleh memuat naik dokumen sokongan yang difikirkan perlu. Contoh : Pengiktirafan / Lesen kepakaran / Rekod hospital atau lain-lain 
            </p>
            </div>
        </div>


        
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar Sebab',['class' => 'btn btn-success', 'data'=>['confirm'=>'Sila pastikan maklumat permohonan adalah tepat. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini. Teruskan?']]) ?>
                </div>
            </div>


            <?php ActiveForm::end(); ?>

            <!--form-->
        </div>
    </div>
</div>
</div>
<div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
                <div class="x_title">
                    <h2><strong>Sejarah Maklumbalas Kakitangan</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped table-sm jambo_table">
                    
                        <thead>

                        <tr class="headings">
                            <th class="column-title">Bil</th>
                            <th class="column-title">Representasi Bertulis</th>
                            <th class="column-title">Tarikh Dihantar</th>
                            <th class="column-title">Status</th>
                           <th class="column-title">Status Pertuduhan</th>
                            <th class="column-title">Rayuan ?</th>
                        </tr>
                        </thead>
                        </thead>
                <?php if($sejarah) {
                    
                   foreach ($sejarah as $sejarahs) {
                    
                ?>
                  
                <tr>
                    <td><?= $bil+1 ?></td>
                    <td><?= $sejarahs->reason ?></td>
                    <td><?= $sejarahs->tarikh_hantar_maklumbalas?></td>
                    <td><?= $statusLabel[$sejarahs->status_maklumbalas]?></td>
                     <td><?= $statusLabel2[$sejarahs->pelulus_agree2]?></td>
                    </td>
                            <td align= 'center'>
                                    <?php if($sejarahs->letter_sent2 == 1 && $sejarahs->pelulus_agree2 == 1){ ?>
                                        <?= \yii\helpers\Html::a('', ['rayuan', 'id' => $sejarahs->id], ['class'=>'fa fa-edit', 'target' => '_blank']) ?>
                        <?php }
                               
                        
                                    
                                    
                                     ?>
                                   
                   </td>
                  
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>

                    </table>

                </div>
            </div>
        </div>
    </div>
