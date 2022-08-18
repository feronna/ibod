<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
use app\models\kemudahan\Reftujuan; 
use app\models\cbelajar\TblPrestasi;

error_reporting(0);

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
 <p align="right"><?= Html::a('Kembali', ['cutibelajar/senarai-borang'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>

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
       
      PERMOHONAN TUNTUTAN VISA
 '); ?>
                    </strong> </h5>
            </span> 
        </div>
    </div>
<div class="x_panel">
    
        <div class="x_title">
            <h4><strong> PANDUAN PERMOHONAN</strong></h4>
            <div class="clearfix"></div>     
        </div>
        <div class="x_content"> 
            <div align="justify"><strong>o 
           PERMOHONAN UNTUK MENDAPATKAN TUNTUTAN VISA.</strong><br> </div>
            <div align="justify"><strong>o 
           SILA LAMPIRKAN DOKUMEN YANG SEWAJARNYA. HANYA PERMOHONAN YANG LENGKAP SAHAJA AKAN DIPROSES.</strong><br> </div>
            
           
        </div>
</div>
 <div class="x_panel">
     <fieldset class="scheduler-border">
            <legend class="scheduler-border">   <h5><i class='fa fa-user'></i> MAKLUMAT PEMOHON</h5>
                </h5>
</legend>   
<!--        <div class="x_title">
           
            <div style=" background-color: #E8E5E4; width:1034px;height:30px;border:0px solid #000;"><h2><strong>&nbsp;MAKLUMAT PEMOHON</strong></h2> </div>
                    <div class="clearfix"></div>
        </div>-->
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
                        <th class="col-md-3 col-sm-3 col-xs-12">JABATAN/SEKSYEN:</th>
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
                        <td><?= strtoupper($model->kakitangan->statusLantikan->ApmtStatusNm); ?></td> 
                    </tr>
                    

                     
                </table>
            </div>   </div>  </div>

    
           <div class="x_panel">
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
       </h5>
   
            
</div>
               
        <div class="x_content">
         <?php if($model->status_semakan == "Dokumen Tidak Lengkap"){?>   <p align="left"><?php
     
    echo Html::button('Muatnaik Semula Dokumen <i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['lapordiri/update-borang-tesis', 'id'=> $model->id]),
                     'class' => 'btn btn-primary btn-xs mapBtn'])                               
                 ;
                 
 
 ?></p><?php }?>
           
        <div class="table-responsive">
            
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TUNTUTAN VISA</center></th>

                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">
                       SALINAN RESIT BAYARAN VISA 
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

                                                </td>
                    </tr>
                    
                     <tr class="headings">
                        <th class="col-md-6 col-sm-6 col-xs-12">
                    SALINAN SIJIL VISA:
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

     <?php ActiveForm::end(); ?>
   




