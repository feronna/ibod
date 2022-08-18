<?php

error_reporting(0);


?> 

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 &nbsp; &nbsp;&nbsp;&nbsp;
 <div class="col-md-12 col-sm-3 col-xs-12" style=" font-size:15px; margin-top: 20px">
                    <div class="profile_img text-center">
                        <div id="crop-avatar"> 
                     
                          <img src="/staff/web/images/logo-umsblack-text-png.png" width="200px" height="auto" alt="signature"/> <br><br>
                        </div>
                    </div>
      </div>
 <div style=" text-align:center">
      <br><b><h5>UNIT PENGEMBANGAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> 
     PEMAKLUMAN LAPOR DIRI KEMBALI BERTUGAS</h5></b>
      &nbsp; &nbsp;&nbsp;&nbsp; 
     </div>
    
<h6><b>MAKLUMAT PERIBADI</b></h6>
<table class="table" style="font-size: 10px;font-family:Arial;"> 
    <tbody>
        <tr style="background-color:lightseagreen;color:white">
            
<th colspan="5" class="text-center"> 
    <p style="font-size: 14px;"><?= strtoupper($model->kakitangan->CONm); ?> |
    <?=date("Y") - date("Y", strtotime($model->kakitangan->COBirthDt))." ". "TAHUN"?></p><br/>
</th>
</tr>

<tr>
    <th rowspan="8" class="text-center">
    <center>
        <div class="profile_img">
            <div id="crop-avatar"> <br/><br/>
                <img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($model->kakitangan->ICNO)); ?>.jpeg" width="90" height="120">
            </div>
        </div> 
    </center>
</th>  
  
</tr>  
<tr> 
    <th style="width:20%">JAWATAN </th>
    <td style="width:20%"> <?= strtoupper($model->kakitangan->jawatan->fname);?></td> 
    <th>JFPIB</th>
    <td><?= strtoupper($model->kakitangan->department->fullname);?></td>  

</tr>

<tr> 
    <th style="width:20%">ICNO</th>
    <td style="width:20%"><?= $model->kakitangan->ICNO; ?></td> 
    <th>UMSPER</th>
    <td><?= $model->kakitangan->COOldID; ?></td>  

</tr>
<tr> 

                       
                        <th style="width:20%">TARIKH LANTIKAN</th>
                        <td style="width:20%"><?= strtoupper($model->kakitangan->displayStartLantik); ?></td>
                        <th style="width:20%">TARAF PERKAHWINAN</th>
                        <td style="width:20%"> <?= strtoupper($model->kakitangan->displayTarafPerkahwinan) ?></td>


                    </tr>

                    <tr> 

                        <th style="width:20%">TARIKH DISAHKAN DALAM PERKHIDMATAN</th>
                        <td style="width:20%">  <?php
                                    if ($model->kakitangan->confirmDt) {
                                        echo strtoupper($model->kakitangan->confirmDt->tarikhMula);
                                    } else {
                                        echo '<i>Tiada Maklumat</i>';
                                    }
                                    ?></td>
                        <th style="width:20%">TEMPOH BERKHIDMAT SEMASA</th>
                        <td style="width:20%"><?= strtoupper($model->kakitangan->servPeriodPermanent);  ?></td>


                    </tr>
                     
                    <tr> 
                        
                        <th style="width:20%">EMEL</th>
                        <td style="width:20%"><?= $model->kakitangan->COEmail; ?></td> 
                        <th style="width:20%">NO. TELEFON</th>
                        <td style="width:20%"><?= $model->kakitangan->COHPhoneNo; ?></td>
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
    
     <?php if($model->study2){
                
                ?>  
            

                    <div class="x_content ">

                 <div class="table-responsive" >
                     
                        <table class="table table-striped table-sm  table-bordered" style="font-size: 10px;font-family:Arial;">
                            <thead>
                                
                                <tr class="info">
                                    <th colspan="8" style="background-color:lightseagreen;color:white"><center>
            
                                <?php if($model->study2->tahapPendidikan)
                                {
                                 echo strtoupper($model->study2->tahapPendidikan);
                                         
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
                                  <?php echo strtoupper($model->study2->InstNm); ?></td></tr>
                        
                        
                   
                     
                    <tr>
                 
                        <th colspan="4" align="left">BIDANG</th>
                        <td colspan="4"><?php
                        
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
                          <?php }?> 
                    </tr>
                    
                     
                     
                    
                  
                 
                    
                        <tr> 
                     
                        <th colspan="4" align="left">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td colspan="4">
                        <?= strtoupper($model->study2->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($model->study2->tarikhtamat)?> (<?= strtoupper($model->study2->tempohtajaan);?>)</td>
                        </tr>
                        
                        
                    
                  <tr>
                        <th colspan="4" align="left">PENAJAAN BIASISWA:</th>
                        <td colspan="4"><?= ucwords(strtoupper($model->tajaan->nama_tajaan)); ?></td> 
                    </tr>
                
                    

                          
            
                                
                      
                        </table>
                    </div> 

        </div></div>
  </div>
</div>
<div style="page-break-before:always">&nbsp;</div> 

<div class="x_panel">
    <div class="x_title">
   <h6><strong><i class="fa fa-th-list"></i> MAKLUMAT PELANJUTAN TERDAHULU</strong></h6>
   
   
   <div class="clearfix"></div>
</div>
<div>
<form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered" style="font-size: 11px;font-family:Arial;">
   <thead style="background-color:lightseagreen;color:white">
       
        <tr class="headings">
           <th width="50px" height="20px" class=" text-center" style="background-color:lightseagreen;color:white">BIL</th>
            <th style="background-color:lightseagreen;color:white">TARIKH PELANJUTAN CUTI BELAJAR </th>
            <th class="column-title text-center" style="background-color:lightseagreen;color:white">TEMPOH </th>
            <th class="column-title text-center" style="background-color:lightseagreen;color:white">PELANJUTAN KALI KE</th>
            <th class="column-title text-center" style="background-color:lightseagreen;color:white">JUSTIFIKASI</th>

        </tr>
        
        
        

    </thead>
    <tbody>
        
         <?php if($b->lanjut){ ?>
        <?php $bil=1; foreach ($b->lanjut as $l) { ?>
<tr>
<td class="text-center"><?= $bil++ ?></td>
<td> <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->stlanjutan)?> 
                            HINGGA <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->ndlanjutan)?></td>
<td class="text-center">

<?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->tempohlanjutan)?></td>

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
<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12"> 
<div class="x_panel">

<div class="x_title">
   <h6 ><strong><i class="fa fa-graduation-cap"></i> STATUS PENGAJIAN TERKINI</strong></h6>
   
   <div class="clearfix"></div>
</div>      

    
            

                    <div class="x_content ">

                 <div class="table-responsive" >
                     
                        <table class="table table-striped table-sm  table-bordered" style="font-size: 10px;font-family:Arial;">
                            <thead>
                                
                                
                        <tr> 
                     
                        <th colspan="4" align="left">STATUS PENGAJIAN</th>
                        <td colspan="4">
                        <?= strtoupper ($model->study->status_pengajian)?> </td>
                        </tr>
                     
                    
                  
                
                    

                          
            
                                
                      
                        </table>
                    </div> 

        </div></div>
  </div>
</div>

 <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12"> 
<div class="x_panel">

<div class="x_title">
   <h6 ><strong><i class="fa fa-graduation-cap"></i> TARIKH JANGKAAN TAMAT PENGAJIAN</strong></h6>
   
   <div class="clearfix"></div>
</div>      

    
            

                    <div class="x_content ">

                 <div class="table-responsive" >
                     
                        <table class="table table-striped table-sm  table-bordered" style="font-size: 10px;font-family:Arial;">
                            <thead>
                                
                                
                        <tr> 
                     
                        <th colspan="4" align="left">TARIKH JANGKAAN HANTAR TESIS TERKINI</th>
                        <td colspan="4">
                                    <?php
                                    if($model->dt_tesis != NULL)
                                    {
                                        echo strtoupper($model->dttesis);
                                        
                                    }
                                    else
                                    {
                                        echo 'Tiada Maklumat';
                                    }
                                    ?>
                                  </td> 
                        </tr>
                     
                    <tr> 
                     
                        <th colspan="4" align="left">TARIKH JANGKA VIVA</th>
                        <td colspan="4">
                                    <?php
                                    if($model->dt_viva != NULL)
                                    {
                                        echo strtoupper($model->dtviva);
                                        
                                    }
                                    else
                                    {
                                        echo 'Tiada Maklumat';
                                    }
                                    ?>
                                  </td> 
                        </tr>
                  
                
                     <tr> 
                     
                        <th colspan="4" align="left">JANGKA TAMAT PENGAJIAN</th>
                        <td colspan="4">
                                   <?php
                                    if($model->dt_endstudy != NULL)
                                    {
                                        echo strtoupper($model->dtnstudy);
                                        
                                    }
                                    else
                                    {
                                        echo 'Tiada Maklumat';
                                    }
                                    ?>
                                  </td> 
                        </tr>

                          <tr> 
                     
                        <th colspan="4" align="left">TARIKH JANGKA KEPUTUSAN RASMI</th>
                        <td colspan="4">
                                  <?php
                                    if($model->dt_result != NULL)
                                    {
                                        echo strtoupper($model->dtresult);
                                        
                                    }
                                    else
                                    {
                                        echo 'Tiada Maklumat';
                                    }
                                    ?>
                                  </td> 
                        </tr>
            
                              <tr> 
                     
                        <th colspan="4" align="left">JUSTIFIKASI</th>
                        <td colspan="4">
                                   <?= $model->catatan;?>
                                  </td> 
                        </tr>  
                        
                             <tr> 
                     
                        <th colspan="4" align="left">BORANG PERSETUJUAN PEMOTONGAN GAJI</th>
                        <td colspan="4">
                                   <?php
                                    if ($model->upload->dokumen_6) { ?>
                                  
                                  <a class="form-control" style="border:0;box-shadow: none;" href="<?= yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen_6), true); ?>" target="_blank" ><i></i> 
                                      <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
                                    <?php } else {
                                        echo 'Tiada Maklumat'.'<br>';
                                    }?>
                                  </td> 
                        </tr>  
                      
                        </table>
                    </div> 

        </div></div>
  </div>
    </div> 
<?php if($model->biasiswa->jenisCd == 3)
    {?>
<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12"> 
<div class="x_panel">

<div class="x_title">
   <h6 ><strong><i class="fa fa-graduation-cap"></i> TUNTUTAN LAPOR DIRI PENGAJIAN</strong></h6>
   
   <div class="clearfix"></div>
</div>      

     
            

                    <div class="x_content ">

                 <div class="table-responsive" >
                     
                        <table class="table table-striped table-sm  table-bordered" style="font-size: 10px;font-family:Arial;">
                            <thead>
                                
                                <tr class="info">
                                    <th colspan="8" style="background-color:lightseagreen;color:white"><center>
            
                             JENIS TUNTUTAN</center></th>
                             <th colspan="8" style="background-color:lightseagreen;color:white"><center>
            
                             SEMAKAN</center></th>
                                </tr>
                                <tr> 
                        <th colspan="8" align="left">ELAUN AKHIR PENGAJIAN</th>
                        <td colspan="8">
                       <?php if($akhir)
    {?>
                            <p>&#9989; <?= $akhir->tarikh_m ?></p>
                                
                          <?php }
                          else{?>
                            <p> X</p>
                         <?php }
?></td>
                       
                    </tr>
                   
                    <tr> 
                        <th colspan="8" align="left">ELAUN TESIS-KPT</th>
                        <td colspan="8">
                       <?php if($tesis)
    {?>
                            <p>&#9989; <?= $tesis->tarikh_m ?></p>
                                
                          <?php }
                          else{?>
                            <p> X</p>
                         <?php }
?></td>
                       
                    </tr>
                    <tr> 
                        <th colspan="8" align="left">HADIAH PERGERAKAN GAJI-HPG</th>
                        <td colspan="8">
                       <?php if($hpg)
    {?>
                            <p>/ <?= $hpg->tarikh_m ?></p>
                                
                          <?php }
                          else{?>
                            <p> X</p>
                         <?php }
?></td>
                       
                    </tr>
    <?php }?>
                
                    

                          
            
                                
                      
                        </table>
                    </div> 

        </div></div>
  </div>
</div>
<div class="row" > 
    <div class="col-xs-12 col-md-12 col-lg-12"> 

    <div class="x_panel">
        <div class="x_title">
            <h6><strong><i class="fa fa-check-square"></i> PERAKUAN PEMOHON </strong></h6>
           
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             <h4 style="font-size: 18px;font-family:Times New Roman;"><small>Saya mengaku maklumat yang dikemukakan adalah benar dan sekiranya saya tidak melengkapkan
                                    dokumen lapor diri seperti yang dinyatakan dalam senarai semak urusan yang berkaitan dengan
                                    perkhidmatan dan saraan saya tidak akan diproses.</small> </h4>
            <h5 style="font-size: 12px;font-family:Times New Roman;">Tarikh Hantar: <?php echo $model->tarikh_mohon;?></h5><br/>
        </div>
    </div>
</div>
</div>
<div style="page-break-before:always">&nbsp;</div> 

<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12"> 
<div class="x_panel">

<div class="x_title">
   <h6 ><strong><i class="fa fa-graduation-cap"></i> STATUS PERAKUAN KETUA JABATAN/DEKAN</strong></h6>
   
   <div class="clearfix"></div>
</div>      

   
            

                    <div class="x_content ">

                 <div class="table-responsive" >
                     
                        <table class="table table-striped table-sm  table-bordered" style="font-size: 10px;font-family:Arial;">
                            <thead>
                                
                                <tr class="info">
                                    <th colspan="8" style="background-color:lightseagreen;color:white"><center>
            
                             PERAKUAN KETUA JABATAN/DEKAN</center></th>
                             
                                </tr>
                                <tr> 
                    <tr> 
                    <td colspan="8"><center><P>Adalah dimaklumkan bahawa penama berikut merupakan kakitangan dibawah seliaan saya <b>(<?=$model->ketuajfpiu ?>)</b> yang telah mengikuti pengajian lanjutan dan beliau telah melapor diri bertugas semula seperti berikut:</P></center></td>
                </tr>
                            <tr> 
                     
                        <th colspan="4" align="left">TARIKH LAPOR DIRI</th>
                        <td colspan="4">
                                   <?= strtoupper($model->dtlapor);?>
                                  </td> 
                        </tr> 
                       <tr> 
                     
                        <th colspan="4" align="left">STATUS PERAKUAN</th>
                        <td colspan="4">
                                   <?= strtoupper($model->status_jfpiu);?>
                                  </td> 
                        </tr> 
                        <tr> 
                     
                        <th colspan="4" align="left">ULASAN</th>
                        <td colspan="4">
                                   <?= strtoupper($model->ulasan_jfpiu);?>
                                  </td> 
                        </tr> 
                         <tr> 
                     
                        <th colspan="4" align="left">TARIKH DIPERAKUKAN</th>
                        <td colspan="4">
                                   <?= strtoupper($model->app_date);?>
                                  </td> 
                        </tr> 
                        <tr> 
                     
                        <th colspan="4" align="left">DIPERAKUKAN OLEH</th>
                        <td colspan="4">
                                   <?= strtoupper($model->ketuajfpiu);?>
                                  </td> 
                        </tr> 
 
                
                    

                          
            
                                
                      
                        </table>
                    </div> 

        </div></div>
  </div>
</div>
      <p align="right"><font size="2">   <?php echo "[Tarikh Dicetak:"  .' '.date("Y-m-d").', '.  date("h:i:sa")."]";?></p>

        
        
   




