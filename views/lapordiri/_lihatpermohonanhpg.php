<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
use app\models\kemudahan\Reftujuan; 
use app\models\cbelajar\TblPrestasi;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Permohonan Cuti Belajar'; 
error_reporting(0);
?> 

  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div>
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
</div>
 

  <div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> 
     PERMOHONAN TUNTUTAN HADIAH PERGERAKAN GAJI (HPG)
 '); ?>
                </strong> </center>
            </span> 
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
<!--        <div class="x_title">
           
            <div style=" background-color: #E8E5E4; width:1034px;height:30px;border:0px solid #000;"><h2><strong>&nbsp;MAKLUMAT PEMOHON</strong></h2> </div>
                    <div class="clearfix"></div>
        </div>-->
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama:</th>
                        <td><?= $model->kakitangan->displayGelaran . ' ' . ucwords(strtolower($model->kakitangan->CONm)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan:</th>
                        <td><?= $model->kakitangan->ICNO; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Pekerja:</th>
                        <td><?= $model->kakitangan->COOldID; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jabatan / Seksyen:</th>
                        <td><?= $model->kakitangan->department->fullname; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                        <td><?= $model->kakitangan->jawatan->nama; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Gred:</th>
                        <td><?= $model->kakitangan->jawatan->gred; ?></td> 
                    </tr>
                
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Taraf Jawatan:</th>
                        <td><?= $model->kakitangan->statusLantikan->ApmtStatusNm ?></td> 
                    </tr>
                    

                     
                </table>
            </div>   </div>  </div>
<div class="x_panel">
      <div class="col-md-12 col-sm-12 col-xs-12"> 

<div class="x_title">
   <h5 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN </strong></h5>
   
   
   <div class="clearfix"></div>
</div>      
 
            

                    <div class="x_content ">

                 <div class="table-responsive">
                     
     <?php if($model->study2){
        
                ?> 
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                
                                <tr class="headings">
                                    <th colspan="2" style="background-color:lightseagreen;color:white"><center>
            
                                <?php if($model->study2->tahapPendidikan)
                                {
                                 echo strtoupper($model->study2->tahapPendidikan);
                                         
                                }
                                
                              
?></center></th>
                                </tr>
                               
                    <tr> 
                                
                        <th style="width:10%" align="right">UNIVERSITI/INSTITUSI</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($model->study2->InstNm); ?></td></tr>
                        
                        
                   
                     
                       
                 
                        <th style="width:10%" align="right">BIDANG</th>
                        <td style="width:20%"><?php
                        
                        if(($model->study2->MajorCd == NULL) && ($model->study2->MajorMinor != NULL))
                        {
                                echo  strtoupper($model->study2->MajorMinor);
                        }
                        elseif (($model->study2->MajorCd != NULL) && ($model->study2->MajorMinor != NULL))  {
                            echo   strtoupper($model->study2->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($model->study2->major->MajorMinor);
                        }
?></td>
                      
                    
                     <tr> 
                                
                        <th style="width:10%" align="right">MOD PENGAJIAN</th>
                        <td style="width:20%">
                            
                                  <?php if($model->study2->modeID)
                                  {echo strtoupper($model->study2->mod->studyMode);}
                                  
                                  else{
                                      echo "<i>Tiada Maklumat</i>";
                                  }
?></td></tr>
                     
                      <tr> 
                                
                        <th style="width:10%" align="right">TAJUK PENYELIDIKAN</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($model->study2->tajuk_tesis); ?></td></tr>
                        
                  
                 
                    
                        <tr> 
                     
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($model->study2->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($model->study2->tarikhtamat)?> (<?= strtoupper($model->study2->tempohpengajian);?>)</td>
                        </tr>
                        <tr>
                        <th style="width:10%" align="right">BIASISWA:</th>
                        <td><?= ucwords(strtoupper($model->biasiswa->nama_tajaan)); ?></td> 
                    </tr>
                              <?php }     else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center"><b>Tiada Rekod Maklumat Pengajian </b></td>                     
                    </tr>
                  <?php  
                } ?> 
                     
                    
                  
                
                    
      
                            </thead>
                        

                                
                      
                        </table>

                    </div> 

        </div></div>
  </div>
    <div class="x_panel">   <div class="x_content">
        <div class="x_title">
   <h5 ><strong><i class="fa fa-exclamation-circle"></i> STATUS PENGAJIAN </strong></h5>
   
   
   <div class="clearfix"></div>
</div> 
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">
                    <th scope="col" colspan=12">
                    <center>STATUS PENGAJIAN TERKINI</center></th></thead>
              
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12"><center>STATUS PENGAJIAN:</center</th>

                        <td>
    <?php
      
      if(!$model->study2)
          {
              echo 'Tiada Maklumat';
          }
          elseif ($lapor->status_pengajian)
          {
              echo $lapor->status_pengajian;
          }
          else
          {
              
          
                              echo $lapor->study->status_pengajian;
//                              echo $model->cek->correction;
                            }?>
                          
                             
                             
                            
                            
                             

                        </td> 
                    </tr>



                </table>
                
        </div> </div></div>
           <div class="x_panel">
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
       </h5>
   
   
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>SALINAN DOKUMEN SOKONGAN</center></th>

                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            SALINAN IJAZAH/PENGESAHAN SENAT
                            :</th>
                     
                                                <td class="text-justify"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                                             href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen), true); ?>" target="_blank" >
                                                        <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>


                        
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
                             
                <p class="text-justify"><h5 style="color:grey;" >Saya mengaku segala maklumat dan dokumen yang disertakan adalah benar dan saya bersetuju
sekiranya maklumat ini didapati palsu, permohonan ini akan terbatal dan saya boleh dikenakan tindakan
tatatertib disebabkan tidak jujur/amanah seperti yang diperuntukkan di dalam Akta Badan-Badan
Berkanun (Tatatertib dan Surcaj) 2000 (Akta 605).
 </h5>
                            <center><p style="color:black;">Tarikh Mohon: <?php echo $model->tarikh_m; ?></p></center><br/>

                    </div>
                    </td>
              
                
                </table>
        </div> </div></div>
</div> </div> 

     <?php ActiveForm::end(); ?>
   




