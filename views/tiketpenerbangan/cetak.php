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
     PERMOHONAN TEMPAHAN TIKET PENERBANGAN</h5></b>
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
                        
                        
                          
                       
                
                    

                          
            
                                
                      
                        </table>
                    </div> 

        </div></div>
  </div>
</div>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
       
        <div class="x_panel">
            <div class="x_title">
   <h6  ><strong><i class="fa fa-book"></i> MAKLUMAT PENUMPANG LAIN</strong></h6>
   
   
   <div class="clearfix"></div>
</div>   
            <?php
              if($penumpang2){ ?>
            <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                    <thead style="background-color:lightseagreen;color:white">
                
                    <tr>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">Bil.</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">Nama </th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">Umur</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">No. MyKAD/MyPR/KPT/Sijil Lahir</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">Jenis</th>
                        
                    </tr>
    </thead>
                    <tbody>
 <?php
                    if ($penumpang2) {
                        $counter = 0;
                        foreach ($penumpang2 as $penumpang2) {
                            $counter = $counter + 1;
                            ?>
                        
                           <tr>
                                <td><?= $counter; ?></td>
                                <td><?= $penumpang2->jp_nama; ?></td>
                                <td><?= $penumpang2->umur.' '."Tahun"?></td> 
                                <td><?= $penumpang2->jp_icno; ?></td> 
                                <td><?= $penumpang2->jp_hubungan; ?></td>
                            </tr>

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center">Tiada Rekod</td>                     
                        </tr>
<?php }
?>
                    
                    </tbody>
              
                
                </table>
                 
             </div>
              <?php }?>
    </div>
</div>
</div>

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
       
        <div class="x_panel">
            <div class="x_title">
   <h6  ><strong><i class="fa fa-book"></i> JADUAL PENERBANGAN YANG DIRANCANG/DITEMPAH</strong></h6>
   
   
   <div class="clearfix"></div>
</div>   
            <?php
              if($jadualTempahan){ ?>
            <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                     <thead style="background-color:lightseagreen;color:white">
                                <tr class="headings">
                                    <th class="text-center" width="5%" rowspan="2" style="background-color:lightseagreen;color:white">Bil.</th>
                                    <th class="text-center" colspan="3" style="background-color:lightseagreen;color:white">Pelepasan</th>
                                    <th class="text-center" colspan="3" style="background-color:lightseagreen;color:white">Ketibaan</th>
                                    <th class="text-center" style="background-color:lightseagreen;color:white">Jenis Tempahan</th>
                                  
                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center" style="background-color:lightseagreen;color:white">Tarikh</th>
                                    <th class="column-title text-center" style="background-color:lightseagreen;color:white">Destinasi</th>
                                    <th class="column-title text-center" style="background-color:lightseagreen;color:white">Masa</th>
                                    <th class="column-title text-center" style="background-color:lightseagreen;color:white">Tarikh</th>
                                    <th class="column-title text-center" style="background-color:lightseagreen;color:white">Destinasi</th>
                                    <th class="column-title text-center" style="background-color:lightseagreen;color:white">Masa</th>
                                    <th class="column-title text-center" style="background-color:lightseagreen;color:white">(S/P/A)</th>

                                </tr>
                            </thead>
                           
                           
      
                    <tbody>
 <?php
                    if ($jadualTempahan) {
                        $counter = 0;
                        foreach ($jadualTempahan as $jadualTempahan) {
                            $counter = $counter + 1;
                            ?>
                        
                           <tr>
                                <td class="text-center"><?= $counter; ?></td>
                                <td class="text-center"><?= $jadualTempahan->tarikhberlepas; ?></td> 
                                <td class="text-center"><?= $jadualTempahan->dest_berlepas ?></td>
                                <td class="text-center"><?= $jadualTempahan->masa_berlepas ?></td>
                                <td class="text-center"><?= $jadualTempahan->tarikhtiba; ?></td> 
                                <td class="text-center"><?= $jadualTempahan->dest_tiba ?></td>
                                <td class="text-center"><?= $jadualTempahan->masa_tiba ?></td>
                                <td class="text-center"><?= $jadualTempahan->jenistempahan->jenisTempahan ?></td>
                            </tr>

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center">Tiada Rekod</td>                     
                        </tr>
<?php }
?>
                    
                    </tbody>
              
                
                </table>
                 
             </div>
              <?php }?>
    </div>
</div>
</div>
<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12"> 
<div class="x_panel">

<div class="x_title">
   <h6 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PERMOHONAN</strong></h6>
   
   <div class="clearfix"></div>
</div>      

              
               
            

                    <div class="x_content ">
<div>
                <form id="w0" class="form-horizontal form-label-left" action="">
                                           <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                            <thead style="background-color:lightseagreen;color:white" >
                                
                         
                               
                 
                        
                          <tr> 
                                
                        <th colspan="4" align="left" style="background-color:white;color:black">CADANGAN AIRLINES</th>
                        <td colspan="4">
                                  <?php if($model->cadangan_airlines){?>
                            <?= strtoupper($model->cadangan_airlines);?>
                        <?php } else {
                            echo "TIADA MAKLUMAT";
                        }
?></td></tr>
                   
                  
                    
                      
                  
                
                    

     </thead>
            
                                
                      
                        </table>
                    </div>
                    </div>
</div></div></div>
<div style="page-break-before:always">&nbsp;</div> 

<div class="row" > 
    <div class="col-xs-12 col-md-12 col-lg-12"> 

    <div class="x_panel">
        <div class="x_title">
            <h6><strong><i class="fa fa-check-square"></i> PERAKUAN PEMOHON </strong></h6>
           
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             <h4 style="font-size: 18px;font-family:Times New Roman;"><small>Saya mengaku semua keterangan di atas adalah benar dan jika saya didapati memberi maklumat palsu, saya bersetuju permohonan ini (jika telah diluluskan) akan terbatal dengan sendirinya dan boleh diambil tindakan perundangan.</small> </h4>
            <h5 style="font-size: 12px;font-family:Times New Roman;">Tarikh Hantar: <?php echo $model->tarikh_mohon;?></h5><br/>
        </div>
    </div>
</div>
</div>


<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12"> 
<div class="x_panel">

<div class="x_title">
   <h6 ><strong><i class="fa fa-graduation-cap"></i> SEMAKAN UNIT PENGEMBANGAN PROFESIONALISME</strong></h6>
   
   <div class="clearfix"></div>
</div>      

              
               
            

                    <div class="x_content ">
<div>
                <form id="w0" class="form-horizontal form-label-left" action="">
                                           <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                            <thead style="background-color:lightseagreen;color:white" >
                                
                         
                               
                    <tr> 
                                
                        <th colspan="4" align="left" style="background-color:white;color:black">SEMAKAN PERMOHONAN</th>
                        <td colspan="4">
                                   <?php echo strtoupper($model->status_bsm); ?></td></tr>
                        
                        
                   <tr> 
                                
                        <th colspan="4" align="left" style="background-color:white;color:black">NO. PERUNTUKAN</th>
                        <td colspan="4">
                                  <?php echo strtoupper($model->no_peruntukan); ?></td></tr>
                   
                   <tr> 
                                
                        <th colspan="4" align="left" style="background-color:white;color:black">TARIKH SEMAKAN</th>
                        <td colspan="4">
                                  <?php echo strtoupper($model->ver_date); ?></td></tr>
                  
                    
                      
                  
                
                    

     </thead>
            
                                
                      
                        </table>
                    </div>
                    </div>
</div></div></div>

<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12"> 
<div class="x_panel">

<div class="x_title">
   <h6 ><strong><i class="fa fa-graduation-cap"></i> SEMAKAN KETUA BAHAGIAN SUMBER MANUSIA</strong></h6>
   
   <div class="clearfix"></div>
</div>      

              
               
            

                    <div class="x_content ">
<div>
                <form id="w0" class="form-horizontal form-label-left" action="">
                                           <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                            <thead style="background-color:lightseagreen;color:white" >
                                
                         
                               
                    <tr> 
                                
                        <th colspan="4" align="left" style="background-color:white;color:black">SEMAKAN PERMOHONAN</th>
                        <td colspan="4">
                                   <?php echo strtoupper($model->status_kj); ?></td></tr>
                        
                        
                   <tr> 
                                
                        <th colspan="4" align="left" style="background-color:white;color:black">ULASAN</th>
                        <td colspan="4">
                                  <?php echo strtoupper($model->ulasan_kj); ?></td></tr>
                   
                   <tr> 
                                
                        <th colspan="4" align="left" style="background-color:white;color:black">TARIKH DIPERAKUKAN</th>
                        <td colspan="4">
                                  <?php echo strtoupper($model->app_date); ?></td></tr>
                  
                    
                      
                  
                
                    

     </thead>
            
                                
                      
                        </table>
                    </div>
                    </div>
</div></div></div>

<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12"> 
<div class="x_panel">

<div class="x_title">
   <h6 ><strong><i class="fa fa-graduation-cap"></i> SEMAKAN UNIT PENTADBIRAN KEWANGAN BSM</strong></h6>
   
   <div class="clearfix"></div>
</div>      

              
               
            

                    <div class="x_content ">
<div>
                <form id="w0" class="form-horizontal form-label-left" action="">
                                           <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                            <thead style="background-color:lightseagreen;color:white" >
                                
                         
                               
                    <tr> 
                                
                        <th colspan="4" align="left" style="background-color:white;color:black">SEMAKAN PERMOHONAN</th>
                        <td colspan="4">
                                   <?php echo strtoupper($model->status_a); ?></td></tr>
                        
                        
                   <tr> 
                                
                        <th colspan="4" align="left" style="background-color:white;color:black">ULASAN</th>
                        <td colspan="4">
                                  <?php echo strtoupper($model->ulasan_a); ?></td></tr>
                   
                   <tr> 
                                
                        <th colspan="4" align="left" style="background-color:white;color:black">TARIKH SEMAKAN</th>
                        <td colspan="4">
                                  <?php echo strtoupper($model->ad_dt); ?></td></tr>
                  
                    
                      
                  
                
                    

     </thead>
            
                                
                      
                        </table>
                    </div>
                    </div>
</div></div></div>
        
      <p align="right"><font size="2">   <?php echo "[Tarikh Dicetak:"  .' '.date("Y-m-d").', '.  date("h:i:sa")."]";?></p>

        
        
   




