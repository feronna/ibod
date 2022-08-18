<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" media="print" href="bootstrap.css" />
<?php


use yii\helpers\Url; 

error_reporting(0);

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

?> 
     
     
     
     <div class="col-md-12 col-sm-3 col-xs-12" style=" font-size:15px;">
                    <div class="profile_img text-center">
                        <div id="crop-avatar"> 
                     
                          <img src="/staff/web/images/logo-umsblack-text-png.png" width="200px" height="auto" alt="signature"/> <br><br>
                        </div>
                    </div>
      </div>
<div style=" text-align:center">
    
      <br><b><h5>UNIT PENGEMBANGAN PROFESIONALISME | BAHAGIAN SUMBER MANUSIA <br/><u> 
        PERMOHONAN PERTUKARAN BIDANG PENGAJIAN</h5></b>
        
     
     </div>
       <br/>
   
<h6><b>MAKLUMAT PERIBADI</b></h6>
<table class="table" style="font-size: 10px;font-family:Arial;"> 
    <tbody>
        <tr style="background-color:lightseagreen;color:white">
            
<th colspan="5" class="text-center"> 
    <p style="font-size: 14px;"><?= strtoupper($biodata->CONm); ?> |
    <?=date("Y") - date("Y", strtotime($biodata->COBirthDt))." ". "TAHUN"?></p><br/>
</th>
</tr>

<tr>
    <th rowspan="8" class="text-center">
    <center>
        <div class="profile_img">
            <div id="crop-avatar"> <br/><br/>
                <img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($biodata->ICNO)); ?>.jpeg" width="90" height="120">
            </div>
        </div> 
    </center>
</th>  
  
</tr>  
<tr> 
    <th style="width:20%">JAWATAN </th>
    <td style="width:20%"> <?= strtoupper($biodata->jawatan->fname);?></td> 
    <th>JFPIB</th>
    <td><?= strtoupper($biodata->department->fullname);?></td>  

</tr>

<tr> 
    <th style="width:20%">ICNO</th>
    <td style="width:20%"><?= $biodata->ICNO; ?></td> 
    <th>UMSPER</th>
    <td><?= $biodata->COOldID; ?></td>  

</tr>
<tr> 

                       
                        <th style="width:20%">TARIKH LANTIKAN</th>
                        <td style="width:20%"><?= strtoupper($biodata->displayStartLantik); ?></td>
                        <th style="width:20%">TARAF PERKAHWINAN</th>
                        <td style="width:20%"> <?= strtoupper($biodata->displayTarafPerkahwinan) ?></td>


                    </tr>

                    <tr> 

                        <th style="width:20%">TARIKH DISAHKAN DALAM PERKHIDMATAN</th>
                        <td style="width:20%">  <?php
                                    if ($biodata->confirmDt) {
                                        echo strtoupper($biodata->confirmDt->tarikhMula);
                                    } else {
                                        echo '<i>Tiada Maklumat</i>';
                                    }
                                    ?></td>
                        <th style="width:20%">TEMPOH BERKHIDMAT SEMASA</th>
                        <td style="width:20%"><?= strtoupper($biodata->servPeriodPermanent);  ?></td>


                    </tr>
                     
                    <tr> 
                        
                        <th style="width:20%">EMEL</th>
                        <td style="width:20%"><?= $biodata->COEmail; ?></td> 
                        <th style="width:20%">NO. TELEFON</th>
                        <td style="width:20%"><?= $biodata->COHPhoneNo; ?></td>
                    </tr>
</tbody>
</table> 


<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12"> 
<div class="x_panel">

<div class="x_title">
   <h6 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN</strong></h6>
   
   <div class="clearfix"></div>
</div>      

     <?php if($model->study){
                
                ?>  
            

                    <div class="x_content ">

                 <div class="table-responsive" >
                     
                        <table class="table table-striped table-sm  table-bordered" style="font-size: 10px;font-family:Arial;">
                            <thead>
                                
                                <tr class="info">
                                    <th colspan="8" style="background-color:lightseagreen;color:white"><center>
            
                                <?php if($model->study->tahapPendidikan)
                                {
                                 echo strtoupper($model->study->tahapPendidikan);
                                         
                                }
                                
                              
?></center></th>
                                </tr>
                                <tr> 
                        <th colspan="4" align="left">JAWATAN SEMASA CUTI BELAJAR</th>
                        <td colspan="4">
                        <?=strtoupper($model->kakitangan->jawatan->fname) ?></td>
                       
                    </tr>
                    <tr> 
                                
                        <th colspan="4" align="left">UNIVERSITI/INSTITUSI</th>
                        <td colspan="4">
                                  <?php echo strtoupper($model->study->InstNm); ?></td></tr>
                        
                        
                   
                     
                    <tr>
                 
                        <th colspan="4" align="left">BIDANG</th>
                        <td colspan="4"><?php
                        
                        if(($model->study->MajorCd == NULL) && ($model->study->MajorMinor != NULL))
                        {
                                echo  strtoupper($model->study->MajorMinor);
                        }
                        elseif (($model->study->MajorCd != NULL) && ($model->study->MajorMinor != NULL))  {
                            echo   strtoupper($model->study->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($model->study->major->MajorMinor);
                        }
?></td>
                         
                    </tr>
                    <tr> 
                                
                        <th colspan="4" align="left">MOD PENGAJIAN</th>
                        <td colspan="4">
                            
                                  <?php if($model->study->modeID)
                                  {echo strtoupper($model->study->mod->studyMode);}
                                  
                                  else{
                                      echo "Tiada Maklumat";
                                  }
?></td></tr>
                     
                     <tr> 
                     
                        <th colspan="4" align="left">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td colspan="4">
                        <?= strtoupper($model->study->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($model->study->tarikhtamat)?> (<?= strtoupper($model->study->tempohpengajian);?>)</td>
                        </tr>
                        <tr>
                        <th colspan="4" align="left">BIASISWA:</th>
                        <td colspan="4"><?= ucwords(strtoupper($model->tajaan->nama_tajaan)); ?></td> 
                    </tr>
                              <?php }     else{
                    ?>
                    <tr>
                        <td colspan="4"><b>TIADA MAKLUMAT</b></td>                     
                    </tr>
                  <?php  
                } ?> 
                    
                  
                 
                    
                        
                       
                     
                    
                  
                
                    

                          
            
                                
                      
                        </table>
                    </div> 

        </div></div>
  </div>
</div>
<div style="page-break-before:always">&nbsp;</div> 

<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12"> 
<div class="x_panel">

<div class="x_title">
   <h6 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PERMOHONAN</strong></h6>
   
   <div class="clearfix"></div>
</div>      

     <?php if($model->study){
                
                ?>  
            

                    <div class="x_content ">

                 <div class="table-responsive" >
                     
                        <table class="table table-striped table-sm  table-bordered" style="font-size: 10px;font-family:Arial;">
                            <thead>
                                
                                <tr class="info">
                                    <th colspan="8" style="background-color:lightseagreen;color:white"><center>
            
               PERMOHONAN PERTUKARAN BIDANG PENGAJIAN</center></th>
                                </tr>
                                <tr> 
                        <th colspan="4" align="left">BIDANG PENGAJIAN</th>
                        <td colspan="4">
                       <?php
                        
                        if(($model->study->MajorCd == NULL) && ($model->study->MajorMinor != NULL))
                        {
                                echo  strtoupper($model->study->MajorMinor);
                        }
                        elseif (($model->study->MajorCd != NULL) && ($model->study->MajorMinor != NULL))  {
                            echo   strtoupper($model->study->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($model->study->major->MajorMinor);
                        }
?>
                          
   </td>
                       
                    </tr>
                    
                    <tr> 
                        <th colspan="4" align="left">BIDANG PENGAJIAN BAHARU</th>
                        <td colspan="4">
                       <?php
                       
                        {
                          echo   strtoupper($model->major->MajorMinor);
                        }
?>
                          
   </td>
                       
                    </tr>
                    <tr> 
                                
                        <th colspan="4" align="left">SURAT KELULUSAN PERTUKARAN BIDANG PENGAJIAN<br>
                            <i>Dari Tempat Pengajian</i>:</th>
                        <td colspan="4">
                             <?php   if ($model->dokumen_sokongan)
{ ?>

    <?php echo 'TELAH DISEMAK  &#10004;';?></td>
        <?php } 
else
{ ?>

    <td  colspan="4"><?php echo 'TIADA MAKLUMAT  &#10008;';?></td>
   
<?php }?></tr>
                    
                    <tr> 
                                
                        <th colspan="4" align="left">SURAT SOKONGAN PENYELIA<br>
                            <i>Dari Tempat Pengajian</i>:</th>
                        <td colspan="4">
                             <?php   if ($model->dokumen)
{ ?>

    <?php echo 'TELAH DISEMAK  &#10004;';?></td>
        <?php } 
else
{ ?>

    <td  colspan="4"><?php echo 'TIADA MAKLUMAT  &#10008;';?></td>
   
<?php }?></tr>
                        
                  
                    
                        <tr>
                        <th colspan="4" align="left">JUSTIFIKASI:</th>
                        <td colspan="4"><?= ucwords(strtoupper($model->catatan)); ?></td> 
                    </tr>
                    <tr>
                        <th colspan="4" align="left">STATUS SEMAKAN:</th>
                        <td colspan="4"><?= ucwords(strtoupper($model->status_bsm)); ?></td> 
                    </tr>
                              <?php }     else{
                    ?>
                    <tr>
                        <td colspan="4"><b>TIADA MAKLUMAT</b></td>                     
                    </tr>
                  <?php  
                } ?> 
                    
                  
                 
                    
                        
                       
                     
                    
                  
                
                    

                          
            
                                
                      
                        </table>
                    </div> 

        </div></div>
  </div>
</div>


<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12"> 
<div class="x_panel">

<div class="x_title">
   <h6 ><strong><i class="fa fa-graduation-cap"></i> STATUS KETUA JABATAN/DEKAN</strong></h6>
   
   <div class="clearfix"></div>
</div>      

     <?php if($model->study){
                
                ?>  
            

                    <div class="x_content ">

                 <div class="table-responsive" >
                     
                        <table class="table table-striped table-sm  table-bordered" style="font-size: 10px;font-family:Arial;">
                            <thead>
                                
                                <tr class="info">
                                    <th colspan="8" style="background-color:lightseagreen;color:white"><center>
            
               SEMAKAN KETUA JABATAN/DEKAN</center></th>
                                </tr>
                                
                    
                   
                    
                    
                    
                        
                  
                    
                        <tr>
                        <th colspan="4" align="left">STATUS PERAKUAN:</th>
                        <td colspan="4"><?= ucwords(strtoupper($model->status_jfpiu)); ?></td> 
                    </tr>
                    <tr>
                        <th colspan="4" align="left">ULASAN:</th>
                        <td colspan="4"><?= ucwords(strtoupper($model->ulasan_jfpiu)); ?></td> 
                    </tr>
                    <tr>
                        <th colspan="4" align="left">TARIKH DIPERAKUKAN:</th>
                        <td colspan="4"><?= ucwords(strtoupper($model->app_date)); ?></td> 
                    </tr>
                              <?php }     else{
                    ?>
                    <tr>
                        <td colspan="4"><b>TIADA MAKLUMAT</b></td>                     
                    </tr>
                  <?php  
                } ?> 
                    
                  
                 
                    
                        
                       
                     
                    
                  
                
                    

                          
            
                                
                      
                        </table>
                    </div> 

        </div></div>
  </div>
</div>

     <p align="right"><font size="2">   <?php echo "[Tarikh Dicetak:"  .' '.date("Y-m-d").', '.  date("h:i:sa")."]";?></p>
