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
 
 <p align="right"><?= Html::a('Kembali', ['cutibelajar/permohonan-semasa'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>
  <div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> 
     LAPOR DIRI TAMAT TEMPOH PENGAJIAN LANJUTAN
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
 <div class="row"> 
<div class="col-md-12 col-xs-12"> 

<div class="x_panel">

        <div class="x_title">
            <h4><strong> PANDUAN PERMOHONAN</strong></h4>
            <div class="clearfix"></div>     
        </div>
        <div class="x_content"> 
            <?php if($model->biasiswa->jenisCd == 3)
    {?>
            <b style="color:red">JIKA ANDA SELESAI, TAJAAN KPT:</b><br> 
            <div align="justify"><strong>
            
                    1. SILA PILIH STATUS PENGAJIAN ANDA <b>LULUS</b>.</strong><br> </div>
            <div align="justify"><strong>
            
           2. SILA MUAT NAIK SALINAN SIJIL ASAL/SURAT PENGESAHAN SENAT LULUS PENGAJIAN.</strong><br> </div>
            <div align="justify"><strong>
            
           3. KLIK BUTANG ELAUN AKHIR PENGAJIAN UNTUK TUNTUTAN.</strong><br> </div>
            <div align="justify"><strong>
            
           4. KLIK BUTANG ELAUN TESIS UNTUK TUNTUTAN.</strong><br> </div>
            <div align="justify"><strong>
            
           5. KLIK BUTANG HADIAH PERGERAKAN GAJI UNTUK TUNTUTAN (HANYA UNTUK JAWATAN GRED DS45 SAHAJA).</strong><br> </div>
            
            <div align="justify"><strong>
           6. KLIK BUTANG PENGESAHAN UNTUK MENGHANTAR BORANG LAPOR DIRI ANDA.</strong><br> </div>
            
            <br>
    <?php }
//    elseif($model->biasiswa->jenisCd == "NULL"){
//        
//        return "-";
//    }
    
    else { ?>
             <b style="color:red">JIKA ANDA SELESAI, TAJAAN UMS/LUAR:</b><br> 
            <div align="justify"><strong>
            
           1. SILA PILIH STATUS PENGAJIAN ANDA <b>LULUS</b>.</strong><br> </div>
            <div align="justify"><strong>
            
           2. KLIK BUTANG HADIAH PERGERAKAN GAJI UNTUK TUNTUTAN.</strong><br> </div>
          
            <div align="justify"><strong>
           3. KLIK BUTANG PENGESAHAN UNTUK MENGHANTAR BORANG LAPOR DIRI ANDA.</strong><br> </div>
    <?php }?>
        </div>
</div>
</div></div>
 <div class ="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->
<!--    <div class="x_title">
        <h2><strong><i class="fa fa-check-square"></i> PANDUAN PERMOHONAN</strong><br/>
        <small>Sila Klik Setiap Butang Untuk Hantar Permohonan</small></h2>
            
            <div class="clearfix"></div>
        </div>-->
         <div class="x_content">
             
<?php
  echo Html::a(Yii::t('app',' <i class="fa fa-graduation-cap"></i> STATUS PENGAJIAN'), ['lapordiri/borang'], ['class' => 'btn btn-primary btn-md']);
//  echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
//     echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/lkk-jfpiu'], ['class' => 'btn btn-default btn-lg']);
  

?>
    <?php if($model->study2->tajaan->jenisCd == 3)
    {?><?php
  
  echo Html::a(Yii::t('app',' <i class="fa fa-th-list"></i> ELAUN AKHIR PENGAJIAN'), ['lapordiri/tuntut-akhir'], ['class' => 'btn btn-primary btn-md','target'=>'_blank']);

  echo Html::a(Yii::t('app',' <i class="fa fa-book"></i> ELAUN TESIS'), ['lapordiri/tuntut-tesis'], ['class' => 'btn btn-primary btn-md','target'=>'_blank']);

    ?><?php }
   
?>
 <?php if($lapor)
    {?><?php
    
   if($model->kakitangan->jawatan->gred == "DS45")
    {
          echo Html::a(Yii::t('app',' <i class="fa fa-gift"></i> HADIAH PERGERAKAN GAJI'), ['lapordiri/tuntut-hpg'], ['class' => 'btn btn-primary btn-md','target'=>'_blank']);
    }
  echo Html::a(Yii::t('app',' <i class="fa fa-check"></i> PENGESAHAN'), ['lapordiri/pengesahan','i'=>$i], ['class' => 'btn btn-primary btn-md','target'=>'_blank']);
//  echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
//     echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/lkk-jfpiu'], ['class' => 'btn btn-default btn-lg']);
  

    ?><?php } else
    {
          echo Html::a(Yii::t('app',' <i class="fa fa-gift"></i> HADIAH PERGERAKAN GAJI'), ['lapordiri/tuntut-hpg'], ['class' => 'btn btn-primary btn-md','target'=>'_blank']);

    }
?>
         </div>
    </div>
      </div>


 </div>
 <div class="x_panel">
    <div class="x_title">
   <h5 ><strong><i class="fa fa-user"></i> MAKLUMAT PEMOHON</strong></h5>
   
   
   <div class="clearfix"></div>
</div>      
    <div class="col-md-3 col-sm-3  profile_left"> 
        

        <div class="profile_img">
            <div id="crop-avatar"> <br/><br/>
                <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($biodata->ICNO)); ?>.jpeg" width="150" height="180"></center>
            </div>
        </div> 
        <br/> 
    </div>
    <div class="col-md-9 col-sm-9 col-xs-9">

        <div class="col-md-12 col-sm-12 col-xs-12">   
            <br/>
<!--            <h4 colspan="2" style="background-color:lightseagreen;color:white"><center>MAKLUMAT PERIBADI</center></h4>-->
                   
            <table class="table" style="width:100%">
                
                <thead>
                    <tr>
                        <th colspan="4" class="text-center">
                <h5><?=  strtoupper($model->kakitangan->CONm); ?> |
                <?=date("Y") - date("Y", strtotime($model->kakitangan->COBirthDt))." ". "TAHUN"?></h5>
                </th>
                </tr>  
                <tr>
                    <th colspan="4" class="text-center"> 
                        <?= strtoupper($model->kakitangan->jawatan->fname);?> | 
                        <?= strtoupper($model->kakitangan->department->fullname);?>
                    </th> 
                </tr>
                </thead>
                <tbody>

                    <tr> 
                        <th style="width:20%">ICNO</th>
                        <td style="width:20%"><?= $model->kakitangan->ICNO; ?></td> 
                        <th>UMSPER</th>
                        <td><?= $model->kakitangan->COOldID; ?></td>  

                    </tr>
                    <tr> 

                       
                        <th style="width:20%">TARIKH LANTIKAN</th>
                        <td style="width:20%"><?= strtoupper($model->kakitangan->displayStartLantik); ?></td>
                       <th width="20%">TARAF PERKAHWINAN: </th>
                       <td><?= strtoupper($model->kakitangan->displayTarafPerkahwinan) ?></td> 

                    </tr>
                    <tr> 

                        <th style="width:20%">TARIKH DISAHKAN DALAM PERKHIDMATAN</th>
                        <td style="width:20%">  <?php
                                    if ($model->kakitangan->confirmDt) {
                                        echo strtoupper($model->kakitangan->confirmDt->tarikhMula);
                                    } else {
                                        echo 'Tiada Maklumat';
                                    }
                                    ?></td>
                        <th style="width:20%">TEMPOH BERKHIDMAT SEMASA</th>
                        <td style="width:20%"><?= strtoupper($model->kakitangan->servPeriodPermanent);  ?></td>


                    </tr>
                     
                    <tr> 
                        
                        <th>EMEL</th>
                        <td><?= $model->kakitangan->COEmail; ?></td> 
                        <th style="width:20%">NO. TELEFON</th>
                        <td style="width:20%"><?= $model->kakitangan->COHPhoneNo; ?></td>
                    </tr>
                    
                    
                     
                </tbody>
            </table> 
        </div> 
        <br/>

    </div>
</div>
 
<div class="x_panel">
      <div class="col-md-12 col-sm-12 col-xs-12"> 
<?php if($model->agree == 2){?>   <p align="right">
     <?= Html::a('Update', ['update-borang?id='.$model->laporID], ['class' => 'btn btn-primary btn-sm']) ?></p><?php }?>
<div class="x_title">
   <h5 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN </strong></h5>
   
   
   <div class="clearfix"></div>
</div>      

     <?php if($model->study2){
        
                ?>  
            

                    <div class="x_content ">

                 <div class="table-responsive">
                     
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                
                                <tr class="headings">
                                    <th colspan="2" style="background-color:lightseagreen;color:white"><center>
            
                                <?php if($stu->tahapPendidikan)
                                {
                                 echo strtoupper($stu->tahapPendidikan);
                                         
                                }
                                
                              
?></center></th>
                                </tr>
                               
                    <tr> 
                                
                        <th style="width:10%" align="right">UNIVERSITI/INSTITUSI</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($stu->InstNm); ?></td></tr>
                        
                        
                   
                     
                       
                 
                        <th style="width:10%" align="right">BIDANG</th>
                        <td style="width:20%"><?php
                        
                        if(($stu->MajorCd == NULL) && ($stu->MajorMinor != NULL))
                        {
                                echo  strtoupper($stu->MajorMinor);
                        }
                        elseif (($stu->MajorCd != NULL) && ($stu->MajorMinor != NULL))  {
                            echo   strtoupper($stu->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($stu->major->MajorMinor);
                        }
?></td>
                      
                    
                     <tr> 
                                
                        <th style="width:10%" align="right">MOD PENGAJIAN</th>
                        <td style="width:20%">
                            
                                  <?php if($stu->modeID)
                                  {echo strtoupper($stu->mod->studyMode);}
                                  
                                  else{
                                      echo "<i>Tiada Maklumat</i>";
                                  }
?></td></tr>
                     
                      <tr> 
                                
                        <th style="width:10%" align="right">TAJUK PENYELIDIKAN</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($stu->tajuk_tesis); ?></td></tr>
                        <tr> 
                                
                        <th style="width:10%" align="right">NAMA PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($stu->nama_penyelia); ?></td></tr>
                          <tr> 
                                
                        <th style="width:10%" align="right">EMEL PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($stu->emel_penyelia); ?></td></tr>
                    
                  
                 
                    
                        <tr> 
                     
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($stu->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($stu->tarikhtamat)?> (<?= strtoupper($stu->tempohpengajian);?>)</td>
                        </tr>
                        <tr>
                        <th style="width:10%" align="right">PENAJAAN BIASISWA:</th>
                        <td><?= ucwords(strtoupper($stu->tajaan->nama_tajaan)); ?></td> 
                    </tr>
                              <?php }     else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center"><b>Tiada Rekod Maklumat Pengajian yang dipohon</b></td>                     
                    </tr>
                  <?php  
                } ?> 
                     
                    
                  
                
                    
      
                            </thead>
                        

                                
                      
                        </table>

                    </div> 

        </div></div>
  </div>

 <div class="x_panel">

        <div class="x_title">
   <h5><strong><i class="fa fa-th-list"></i> MAKLUMAT PELANJUTAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
    <div class="x_content">
 
                    
                        <div>
<form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered">
   <thead style="background-color:lightseagreen;color:white">
       
        <tr class="headings">
          <th width="50px" height="20px">BIL</th>
            <th>TARIKH PELANJUTAN CUTI BELAJAR </th>
            <th class="column-title text-center">TEMPOH </th>
            <th class="column-title text-center">PELANJUTAN KALI KE</th>
            <th class="column-title text-center">JUSTIFIKASI TERDAHULU</th>

        </tr>
        
        
        

    </thead>
    <tbody>
         <?php if($stu->lanjut){ ?>
        <?php $bil=1; foreach ($stu->lanjut as $l) { ?>
<tr>
<td class="text-center"><?= $bil++ ?></td>
<td><?= strtoupper($l->stlanjutan); ?>  <b>HINGGA</b> <?= strtoupper($l->ndlanjutan); ?> </td>
<td class="text-center">

<?= strtoupper($l->tempohlanjutan); ?> </td>
<td class="text-center"><?= $l->idlanjutan; ?></td>
<td class="text-center"><?= $l->justifikasi; ?></td>

</tr>
        <?php }} else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
         
        
        



 </table>
</form>           </div>
                    </div> 

        </div>
 <?php if(($model->study2->HighestEduLevelCd == 1) || ($model->study2->HighestEduLevelCd == 20)
            || ($model->study2->HighestEduLevelCd == 11) || ($model->study2->HighestEduLevelCd == 101) || ($model->study2->HighestEduLevelCd == 102) ||
            ($model->study2->HighestEduLevelCd == 202) ||    ($model->study2->HighestEduLevelCd == 8) || ($model->study2->HighestEduLevelCd == 212))
                        {?>
<div class="x_panel">
    <?php if ($model->agree == NULL) { ?>   <p align="right">
            <?= Html::a('Kemaskini', ['kemaskini-lapordiriselesai?i=' . $model->laporID], ['class' => 'btn btn-primary btn-sm','target'=>'_blank']) ?></p><?php } ?>
    <div class="x_content">
        <div class="x_title">
   <h5><strong><i class="fa fa-exclamation-circle"></i> STATUS PENGAJIAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table" >
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">
                    <th scope="col" colspan=12">
                    <center>STATUS PENGAJIAN TERKINI</center></th>
                
                  <th scope="col" colspan=12">
                      
                  <center>SALINAN SIJIL IJAZAH/SURAT PENGESAHAN SENAT	</center></td></th>
               </thead>
              
                    <tr>

                            <td colspan='12' style="vertical-align: middle" class="text-justify"><?php if($model->status_pengajian == 1)
                            {
                                echo '<b><center>'.$model->study->status_pengajian.'</b></center>';
                                ?>  
                                
                            
                        

                        
                   
                           <?php
                 if ($model->upload->dokumen) { ?>
        <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen), true); ?>" target="_blank" >
       <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
       <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
        }?></td></tr>
                            
                           
                               
                               <?php
                            }
                            
                           
                          
                            
                            else
                            {
                              echo $model->study->status_pengajian;
                            }
                            ?>
                            
                            </tr>
                       
                    

             



                </table>
                
        </div> </div></div>
  
 <?php }?>

  <?php if($model->study2->HighestEduLevelCd == 200)
                        {?>
<div class="x_panel">
    <?php if($model->agree == NULL){?>   <p align="right">
     <?= Html::a('KEMASKINI BORANG', ['kemaskini-lapordiriselesai?i='.$model->laporID], ['class' => 'btn btn-primary btn-sm']) ?></p><?php }?>
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
      </h5>
   
   
   <div class="clearfix"></div>
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TELAH SELESAI</center></th>
<tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS PENGAJIAN:<br>
                       </th>

                                
                       <td class="text-center"><?= $model->study->status_pengajian;?></td>      
                        

                        
                   
                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN SEPANJANG TEMPOH PENGAJIAN BAGI:<br>
                            <small>Pos Doktoral</small>
                       </th>

                                
                            
                        

                        
                   
                           <?php
                 if ($model->upload->dokumen5) { ?>
        <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen5), true); ?>" target="_blank" >
       <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
       <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
        }?></td>                      

                        
                    </tr>
                     
                
                    
                    
                     
                    

                     
                </table>
            </div>  </div>  </div>

                        <?php }?>
    
         
              <?php if($model->study2->HighestEduLevelCd == 99)
                        {?>
<div class="x_panel">
     <?php if($model->agree == NULL){?>   <p align="right">
     <?= Html::a('KEMASKINI BORANG', ['kemaskini-lapordiriselesai?i='.$model->laporID], ['class' => 'btn btn-primary btn-sm','target'=>'_blank']) ?></p><?php }?>
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
      </h5>
   
   
   <div class="clearfix"></div>
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TELAH SELESAI</center></th>
<tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS PENGAJIAN:<br>
                       </th>

                                
                       <td class="text-center"><?= $model->study->status_pengajian;?></td>      
                        

                        
                   
                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN SEPANJANG TEMPOH PENGAJIAN BAGI:<br>
                            <small>Sabatikal</small>
                       </th>

                                
                            
                        

                        
                   
                           <?php
                 if ($model->upload->dokumen5) { ?>
        <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen5), true); ?>" target="_blank" >
       <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
       <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
        }?></td>                      

                        
                    </tr>
                     
                
                    
                    
                     
                    

                     
                </table>
            </div>  </div>  </div>

                        <?php }?>


<?php if($model->study2->HighestEduLevelCd == 207 || $model->study2->HighestEduLevelCd == 211)
                        {?>
<div class="x_panel">
      <?php if($model->agree == NULL){?>   <p align="right">
     <?= Html::a('KEMASKINI BORANG', ['kemaskini-lapordiriselesai?i='.$model->laporID], ['class' => 'btn btn-primary btn-sm','target'=>'_blank']) ?></p><?php }?>
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
      </h5>
   
   
   <div class="clearfix"></div>
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TELAH SELESAI</center></th>
<tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS PENGAJIAN:<br>
                       </th>

                                
                       <td class="text-center"><?= $model->study->status_pengajian;?></td>      
                        

                        
                   
                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN SEPANJANG TEMPOH PENGAJIAN:<br>
                            <small><?php $stu->tahapPendidikan;?></small>
                       </th>

                                
                            
                        

                        
                   
                           <?php
                 if ($model->upload->dokumen5) { ?>
        <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen5), true); ?>" target="_blank" >
       <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
       <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
        }?></td>                      

                        
                    </tr>
                     
                
                    
                    
                     
                    

                     
                </table>
            </div>  </div>  </div>

                        <?php }?>
                    
     <?php if($model->study2->HighestEduLevelCd == 210)
                        {?>
<div class="x_panel">
      <?php if($model->agree == NULL){?>   <p align="right">
     <?= Html::a('KEMASKINI BORANG', ['kemaskini-lapordiriselesai?i='.$model->laporID], ['class' => 'btn btn-primary btn-sm','target'=>'_blank']) ?></p><?php }?>
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
      </h5>
   
   
   <div class="clearfix"></div>
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TELAH SELESAI</center></th>
<tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS PENGAJIAN:<br>
                       </th>

                                
                       <td class="text-center"><?= $model->study->status_pengajian;?></td>      
                        

                        
                   
                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN SEPANJANG TEMPOH PENGAJIAN BAGI:<br>
                            <small>Latihan Industri</small>
                       </th>

                                
                            
                        

                        
                   
                           <?php
                 if ($model->upload->dokumen5) { ?>
        <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen5), true); ?>" target="_blank" >
       <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
       <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
        }?></td>                      

                        
                    </tr>
                     
                
                    
                    
                     
                    

                     
                </table>
            </div>  </div>  </div>

                        <?php }?>
          
          

     <?php ActiveForm::end(); ?>
   




