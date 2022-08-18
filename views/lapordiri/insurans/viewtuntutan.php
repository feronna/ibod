<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 

use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Permohonan Cuti Belajar'; 
?> 
<style>
    fieldset.scheduler-border {
        border: 1px groove #062f49 !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow: 0px 0px 0px 0px #000;
        box-shadow: 0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        width: inherit;
        /* Or auto */
        padding: 0 10px;
        /* To give a bit of padding on the left and right */
        border-bottom: none;
    }
</style>
  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div>
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
</div>
 
<p align="right"> 
    <?php 
                echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Borang', ['cetak-tuntut-insurans', 'id'=>$model->id,
                    'target'=>'_blank'], [
                    'class'=>'btn btn-primary btn-sm', 
                    'target'=>'_self', 
                    'data-toggle'=>'tooltip', 
                    'title'=>'Perakuan Tuntutan Insurans'
                ]);
                ?>
<?= Html::a('Kembali', ['cbadmin/senarai-tuntut-hpg'], 
         ['class' => 'btn btn-primary btn-sm']) ?>
    <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">

<div class="x_panel">

        <div class="x_title">
            <h5><strong><i class='fa fa-clipboard'></i> SEKSYEN PENGEMBANGAN PROFESIONALISME | SEKTOR PENGURUSAN BAKAT</strong></h5>
            <div class="clearfix"></div>     
        </div>

</div></div>
</div>


    <div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                 <h5><strong>
                  <i class='fa fa-arrow-right'></i> <?= strtoupper('
       
      PERMOHONAN TUNTUTAN INSURANS
 '); ?>
                    </strong> </h5>
            </span> 
        </div>
    </div>

 <div class="x_panel">
<fieldset class="scheduler-border">
            <legend class="scheduler-border">   <h5><i class='fa fa-user'></i> MAKLUMAT PEMOHON</h5>
                </h5>
</legend>  
        <div class="x_content">
            
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NAMA:</th>
                        <td><?= strtoupper($model->kakitangan->displayGelaran) . ' ' . ucwords(strtoupper($model->kakitangan->CONm)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NO. KAD PENGENALAN:</th>
                        <td><?= $model->kakitangan->ICNO; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NO. PEKERJA:</th>
                        <td><?= $model->kakitangan->COOldID; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">JABATAN / SEKSYEN:</th>
                        <td><?= strtoupper($model->kakitangan->department->fullname); ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">JAWATAN</th>
                        <td><?= strtoupper($model->kakitangan->jawatan->nama); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">GRED:</th>
                        <td><?= strtoupper($model->kakitangan->jawatan->gred); ?></td> 
                    </tr>
                    
                   

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TARAF JAWATAN:</th>
                        <td><?= strtoupper($model->kakitangan->statusLantikan->ApmtStatusNm) ?></td> 
                    </tr>
                    
                      <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">N0. TELEFON:</th>
                        <td><?= strtoupper($model->kakitangan->COHPhoneNo); ?></td> 
                    </tr>
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">EMEL:</th>
                        <td><?= $model->kakitangan->COEmail; ?></td> 
                    </tr>
                     
                </table>
            </div>   </div>  </div>

            <div class="x_panel">
<fieldset class="scheduler-border">
            <legend class="scheduler-border">   <h5><i class='fa fa-th-list'></i> MAKLUMAT PERMOHONAN</h5>
                </h5>
</legend>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TUNTUTAN INSURANS</center></th>

                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">
                      SALINAN  PEMBAYARAN INSURANS
                            :</th>
                     
                                                <td class="text-justify"> 
                                                    
                                                    <?php
                                    if ($model->dokumen) { ?>
                                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                                             href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen), true); ?>" target="_blank" >
                                                        <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
<?php } else {
                                        echo '<i>Tiada Maklumat</i>'.'<br>';
                                        } ?> 

                        
                    </tr>
                    
                     <tr class="headings">
                        <th class="col-md-6 col-sm-6 col-xs-12">
                    SALINAN INSURANS
                            :</th>
                      
                           <td class="text-justify">
<?php
                                    if ($model->dokumen2) { ?>
                              <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                 href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen2), true); ?>" target="_blank" ><u>Muat Turun Dokumen</u></a><br>
                                    <?php } else {
                                        echo '<i>Tiada Maklumat</i>'.'<br>';
                                        } ?> 
                                                        

                           </td>
                        
                    </tr>
                                            
                     
                    
                    

                     
                </table>
            </div>  </div>  </div>
<div class="row"> 
<div class="col-xs-12 col-md-12 col-lg-12">

      <div class="x_panel">   <div class="x_content">
                <div class="x_title">
   <h5><strong><i class="fa fa-check-square"></i> PERAKUAN KAKITANGAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">
                    <th scope="col" colspan=12">
                    <center>PERAKUAN KAKITANGAN</center></th></thead>

                    <tr class="headings">

                    
                
              
              

                    <td class="col-sm-2 text-center">
                        <div >
                             
                <p class="text-justify"><h5 style="color:grey;" >Saya mengaku segala maklumat dan 
                    dokumen yang disertakan adalah benar.

 </h5>
                            <center><p style="color:black;">Tarikh Mohon: <?php echo $model->tarikh_m; ?></p></center><br/>

                    </div>
                    </td>
              
                
                </table>
        </div> </div></div>
</div> </div> 
        <!--           view dyanamic end here--> 

        
    
<div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $view;?>"> 

       <div class="x_panel">


        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
               
                <th scope="col" colspan=12"  style="background-color:white;"><center>SEMAKAN UNIT PENGEMBANGAN PROFESIONALISME</center></th>

                   
                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">SEMAKAN PERMOHONAN:
                            </th>
                        <td class="text-justify">                                        
                 <?= $model->status_semakan;?> </td>
<tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">CATATAN:</th>
                        <td> <?= strtoupper($model->catatan);?> 
</td> 
                    </tr>
                        

                        
                    </tr>

                    
                    

                     
                </table>
      </div>  </div>  </div></div></div>
          <?php if($model->status_semakan === "Updated" || $model->status_semakan === "TUNGGU SEMAKAN")
      {?>
        <div class="row">
  <!-- Semakan Admin BSM -->
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $edit;?>"> 
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
                    <?=
                    $form->field($model,'status_semakan')->label(false)->widget(Select2::classname(), [
                        'data' => ['Layak Dipertimbangkan' => 'LAYAK DIPERTIMBANGKAN', 'Tidak Layak Dipertimbangkan' => 'TIDAK LAYAK DIPERTIMBANGKAN', 'Dokumen Tidak Lengkap' => 'DOKUMEN TIDAK LENGKAP'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "Dimajukan untuk pertimbangan JK Pengajian Lanjutan Akademik"){
                        $("#ulasan").show();$("#ulasan1").show();
                        }
                        else if($(this).val() == "Dokumen Tidak Lengkap"){
                        $("#ulasan1").show();$("#ulasan").hide();}
                        
                        else{$("#ulasan").hide();$("#ulasan1").hide()
                        }'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        
                       
                    ]);
                    ?>
                </div>
        </div>
          <div class="form-group"  align="center">
            <h5 style="font-size:120%;" class="text-justify"> 
                </h5>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan: <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>
        
        
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                </div>
      </div><?php }?>
    </div>
</div>
 </div>
     <?php ActiveForm::end(); ?>
   




