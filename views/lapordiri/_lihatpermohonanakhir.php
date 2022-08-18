<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
use app\models\kemudahan\Reftujuan; 
use app\models\cbelajar\TblPrestasi;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */
error_reporting(0);

?> 

  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div>
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
</div>
 

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
</style><div class="x_panel">
                <style>
.w3-table td,.w3-table th,.w3-table-all td,.w3-table-all th
{padding:2px 2px;display:table-cell;text-align:left;vertical-align:top}
</style>

                <div class="alert alert-info alert-dismissible fade in">
                        <table class="w3-table w3-bordered" style="font-size: 14px; color:black">
                          <h5 style="color:white">
                              <i class="fa fa-question-circle" style="color:white"></i> 
                              PANDUAN PERMOHONAN:<br><br>
                              <div align="justify"><strong> 
                                      <small style="color:white">- PERMOHONAN UNTUK MENDAPATKAN TUNTUTAN ELAUN AKHIR PENGAJIAN.</small></strong><br> </div>
            <div align="justify" style="color:white"><strong>
                    <small style="color:white">- SILA LAMPIRKAN DOKUMEN YANG SEWAJARNYA. HANYA PERMOHONAN YANG LENGKAP SAHAJA AKAN DIPROSES.</small></strong><br> </div>
            
           
     
                          </h5></table>
                    
                          
                            
                        
                         </table>
                </div>
            </div>
<div class="x_panel">  
    <div class="product_price"> 
        <h5 align="center" style="font-size:16px;font-weight: bold;"> 
             PERMOHONAN TUNTUTAN AKHIR PENGAJIAN</5> 
        <div class="clearfix"></div> 
    </div> 
</div>
<!--  <div class="row">

    <div class="col-xs-12 col-md-12 col-lg-12">
       
        <div class="x_panel">
           
          
                 <div class="x_title">
            <h4>UNIT PENGAJIAN LANJUTAN | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PERMOHONAN CUTI BELAJAR KAKITANGAN AKADEMIK</u></h4><br/>
            
           <p align ="right">
                    <?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>  
                </p>
                 
        
        </div>
    </div>
</div>
</div> -->
 <div class="x_panel">
          <fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                <h5><i class='fa fa-user-circle'></i>
                MAKLUMAT PERIBADI</h5></legend> 
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
                        <th class="col-md-3 col-sm-3 col-xs-12">NO. TELEFON:</th>
                        <td><?= $model->kakitangan->COHPhoneNo; ?></td> 
                    </tr>

                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">EMEL:</th>
                        <td><?= $model->kakitangan->COEmail; ?></td> 
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">ALAMAT:</th>
                        <td><?= $model->kakitangan->alamatTetap ? $model->kakitangan->alamat->alamatPenuh : '-'; ?></td> 
                    </tr>
                     <tr>
                        <th style="width:10%" align="right">PROGRAM:</th>
                        <td><?= ucwords(strtoupper($model->lapor->study2->tajaan->nama_tajaan)); ?></td> 
                    </tr>
                     <tr>
                        <th style="width:10%" align="right">PERINGKAT PENGAJIAN:</th>
                        <td> <?php if($model->studysemasa->tahapPendidikan)
                                {
                                 echo strtoupper($model->studysemasa->tahapPendidikan);
                                         
                                }
                                
                              
?></td> 
                    </tr>
                                       
                    <tr> 
                                
                        <th align="right">TEMPAT PENGAJIAN:</th>
                        <td style="width:60%">
                                  <?php echo strtoupper($model->studysemasa->InstNm); ?></td></tr>
                     <tr> 
                                
                        <th align="right">TEMPOH PENAJAAN KPT:</th>
                      <td style="width:40%">
                        <?= strtoupper($model->studysemasa->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($model->studysemasa->tarikhtamat)?> (<?= strtoupper($model->studysemasa->tempohtajaan);?>)</td></tr>
                      <tr> 
                                
                        <th align="right">TAJUK TESIS:</th>
                        <td style="width:60%">
                                  <?php echo strtoupper($model->studysemasa->tajuk_tesis); ?></td></tr>
                      <tr> 
                                
                        <th align="right">MOD PENGAJIAN</th>
                        <td>
                            
                                  <?php if($model->studysemasa->modeID)
                                  {echo strtoupper($model->studysemasa->mod->studyMode);}
                                  
                                  else{
                                      echo "<i>Tiada Maklumat</i>";
                                  }
?></td></tr>
                </table>
            </div> 

        </div>
        </div>

           <div class="x_panel">
<fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                <h5><i class='fa fa-th-list'></i>
                    MAKLUMAT PERMOHONAN</h5>
           </legend> 
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>ELAUN TESIS - KPT</center></th>

                     <tr class="headings">
                        
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">
                      BORANG PENGESAHAN KELAYAKAN ELAUN AKHIR PENGAJIAN
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
                        <th class="col-md-3 col-sm-3 col-xs-12">
                      BORANG TUNTUTAN KPT EAP
                            :</th>
                     
                                                       <td class="text-justify"> 
                                                    
                                                    <?php
                                    if ($model->dokumen4) { ?>
                                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                                             href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen4), true); ?>" target="_blank" >
                                                        <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
<?php } else {
                                        echo '<i>Tiada Maklumat</i>'.'<br>';
                                        } ?> 

                                                </td>


                        
                    </tr>
                    
                     <tr class="headings">
                        <th class="col-md-6 col-sm-6 col-xs-12">
                   SALINAN TIKET PENERBANGAN:
                            :</th>
                     
                                                       <td class="text-justify"> 
                                                    
                                                    <?php
                                    if ($model->dokumen2) { ?>
                                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                                             href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen2), true); ?>" target="_blank" >
                                                        <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
<?php } else {
                                        echo '<i>Tiada Maklumat</i>'.'<br>';
                                        } ?> 

                                                </td>


                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-6 col-sm-6 col-xs-12">
                   BOARDING PASS:
                            :</th>
                     
                                                       <td class="text-justify"> 
                                                    
                                                    <?php
                                    if ($model->dokumen3) { ?>
                                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                                             href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen3), true); ?>" target="_blank" >
                                                        <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
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
                  <fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                <h5><i class='fa fa-check-square'></i>
                PERAKUAN KAKITANGAN</h5></legend> 
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table>
        <tr>
            

            <td> 
                    <div class="product_price"   style="width: 1000px; height: 70px;"> 

                    <p style="color:black;font-family:'Arial';font-size: 12px;text-align: center;" >Saya <?= $model->kakitangan->CONm ?>
                            No. Kad Pengenalan: <u><?= $model->kakitangan->ICNO; ?></u>
        mengaku segala maklumat dan dokumen yang disertakan adalah benar. 
                        </p>
                    
                    <p style="color:black;text-align:center">Tarikh Mohon: <?php echo $model->tarikh_m;?></p><br/>
                      
            </div>
            </td>
        </tr>
    </table>
        </div> </div></div>
</div> </div>  

     <?php ActiveForm::end(); ?>
   




