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
     PERAKUAN HADIAH PERGERAKAN GAJI (HPG)</h5></b>
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
                     
                        <th colspan="4" align="left">TARIKH LAPOR DIRI</th>
                        <td colspan="4">
                        <?= strtoupper($model->lapor->dtlapor)?> </td>
                        </tr>
                          
                        <tr> 
                     
                        <th colspan="4" align="left">TARIKH RASMI PEMBERIAN HPG [TARIKH LAYAK HPG]</th>
                        <td colspan="4">
                        <?= strtoupper($model->lapor->dtselesai)?> </td>
                        </tr>
                     
                    
                  
                
                    

                          
            
                                
                      
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
             <h4 style="font-size: 18px;font-family:Times New Roman;"><small>Saya mengaku segala maklumat dan dokumen yang disertakan adalah benar dan saya bersetuju sekiranya maklumat ini didapati palsu, permohonan ini akan terbatal dan saya boleh dikenakan tindakan tatatertib disebabkan tidak jujur/amanah seperti yang diperuntukkan di dalam Akta Badan-Badan Berkanun (Tatatertib dan Surcaj) 2000 (Akta 605).</small> </h4>
            <h5 style="font-size: 12px;font-family:Times New Roman;">Tarikh Hantar: <?php echo $model->tarikh_m;?></h5><br/>
        </div>
    </div>
</div>
</div>
<div style="page-break-before:always">&nbsp;</div> 

<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12"> 
<div class="x_panel">

<div class="x_title">
   <h6 ><strong><i class="fa fa-graduation-cap"></i> SEMAKAN UNIT PERJAWATAN</strong></h6>
   
   <div class="clearfix"></div>
</div>      

     <?php if($model->status_j == "Belum ditawarkan kenaikan pangkat jawatan Pensyarah Kanan Gred DS52")    
   {?>
                
               
            

                    <div class="x_content ">

                 <div class="table-responsive" >
                     
                        <table class="table table-striped table-sm  table-bordered" style="font-size: 10px;font-family:Arial;">
                            <thead>
                                
                         
                               
                    <tr> 
                                
                        <th colspan="4" align="left">SEMAKAN</th>
                        <td colspan="4">
                                   <?php echo strtoupper($model->status_j); ?></td></tr>
                        
                        
                     <tr> 
                                
                        <th colspan="4" align="left">CATATAN</th>
                        <td colspan="4">
                                  <?php echo strtoupper($model->ulasan_j); ?><br>
                        </td></tr>
                    
                    <tr>
                        <th colspan="4" align="left">TARIKH DIPERAKUKAN::</th>
                        <td  colspan="4"> <?= $model->app_dt;?></td>

                    </tr>
                  
                
                    

     </thead>
            
                                
                      
                        </table>
                    </div> 
   <?php } else{?>
       <div class="table-responsive" >
                     
                        <table class="table table-striped table-sm  table-bordered" style="font-size: 10px;font-family:Arial;">
                            <thead>
                                
                         
                               
                    <tr> 
                                
                        <th colspan="4" align="left">SEMAKAN</th>
                        <td colspan="4">
                                   <?php echo strtoupper($model->status_j); ?></td></tr>
                       
                    <tr> 
                                
                        <th colspan="4" align="left">MELALUI JAWATAN KUASA PEMILIH:</th>
                              <td colspan="3">Bil: (<?= $model->bil;?>)  </td>
                        <td colspan="5">Tahun: <?= $model->year;?>  </td>
                     </tr>
                       
                      <tr>
                        <th colspan="4" align="left">TARIKH MESYUARAT:</th>
                        <td  colspan="4"> <?= $model->dt_mesy;?></td>

                    </tr>
                    <tr>
                        <th colspan="4" align="left">TARIKH KUATKUASA:</th>
                        <td  colspan="4"> <?= $model->dt_kuat;?></td>

                    </tr>
                <tr>
                        <th colspan="4" align="left">TARIKH DIPERAKUKAN::</th>
                        <td  colspan="4"> <?= $model->app_dt;?></td>

                    </tr>
                     <tr> 
                                
                        <th colspan="4" align="left">CATATAN:</th>
                        <td colspan="4">
                                  <?php echo strtoupper($model->ulasan_j); ?><br>
                        </td></tr>
                    
                    
               
               
                   
                    

     </thead>
            
                                
                      
                        </table>
                    </div> 
  <?php }?>
        </div></div>
  </div>
</div>
<div class="row">
   <div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h6><strong><i class="fa fa-bar-chart"></i> REKOD PERGERAKAN GAJI</strong></h6>
        </div>
 
        <div class="x_content">
         
            <div>
           <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                    <thead style="background-color:lightseagreen;color:white">
                
                    <tr>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BULAN PERGERAKAN </th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">JENIS PERGERAKAN</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TARIKH MULA</th>
                        
                    </tr>
    </thead>
                <?php if($alamat) {
                    
                   foreach ($alamat as $alamatkakitangan) {
                    
                ?>
                  
                <tr>
                    <td><?= strtoupper($alamatkakitangan->bulanPergerakan->name) ?></td>
                    <td><?= strtoupper($alamatkakitangan->jenisPergerakan->name)?></td>
                    <td><?= strtoupper($alamatkakitangan->tarikhMula)?></td>
                   
               
                    
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
            </div>
        </div>
    </div>
   </div> </div>  
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
       
        <div class="x_panel">
            <div class="x_title">
   <h6  ><strong><i class="fa fa-book"></i> PENGIRAAN PEMBERIAN HPG</strong></h6>
   
   
   <div class="clearfix"></div>
</div>   
            <?php
              if($model){ ?>
            <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                    <thead style="background-color:lightseagreen;color:white">
                
                    <tr>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">STATUS </th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">NILAI 1 KGT DS45</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">PERATUSAN BIW</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">PERGERAKAN GAJI TAHUN BAHARU</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">GAJI BAHARU</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIW</th>
                        
                    </tr>
    </thead>
                    <tbody>

                  

                        <tr>

                            <td><?= strtoupper($nd->statuss); ?></td>
                            <td class="text-center">RM<?= strtoupper($nd->nilai_kgt * 3); ?></td>
                            <td class="text-center"><?= strtoupper($nd->status_kgt); ?>%</td>
                            <td class="text-center"><?= strtoupper($nd->bulan_barukgt); ?> <?= strtoupper($nd->tahunb); ?></td>
                            <td class="text-center">RM<?= ($nd->kakitangan->gajiBasic2) + ($nd->nilai_kgt * 3); ?></td>
                            <td class="text-center">RM<?= round(($nd->kakitangan->gajiBasic2) + ($nd->nilai_kgt * 3)) * ($nd->status_kgt / 100); ?></td>
                        </tr>
                   
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
   <h6><strong><i class="fa fa-money"></i> MAKLUMAT GAJI</strong></h6>
   <div class="clearfix"></div>
</div>
    
           <div>
                <form id="w0" class="form-horizontal form-label-left" action="">
                                           <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >

                <?php if($c)
                {?>
                <thead style="background-color:lightseagreen;color:white">
                
                    <tr>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white" width="5%">BIL </th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">JENIS PENDAPATAN</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">GAJI ASAL</th>
                     
                        
                    </tr>
    </thead>
                
            
                   <?php foreach ($c as $key=>$item): ?>
                        <tr>
                            <td class="text-center"><?= $key+1 ?></td>
                             <td><?= $item->it_income_desc?></td>
                             <td>RM<?= $item->MPDH_PAID_AMT?></td>

                           </tr>

                <?php endforeach; ?>
             
                <?php foreach ($model2 as $key=>$item): ?>
                      
                           
                               <tr><td>
                             <td align="right"><strong>JUMLAH PENDAPATAN</strong></td>
                             <td><?= $item->MPH_TOTAL_ALLOWANCE?></td></td>
                               </tr>
                    
                <?php endforeach; ?>
                <?php }else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                        </tr>
                  <?php  
                  } ?>
            </table>
        </div>
    </div></div>
     
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
                                
                        <th colspan="4" align="left" style="background-color:lightseagreen;color:white">SEMAKAN PERMOHONAN</th>
                        <td colspan="4">
                                   <?php echo strtoupper($model->status_semakan); ?></td></tr>
                        
                        
                   <tr> 
                                
                        <th colspan="4" align="left" style="background-color:lightseagreen;color:white">CATATAN</th>
                        <td colspan="4">
                                  <?php echo strtoupper($model->catatan); ?></td></tr>
                  
                    
                      
                  
                
                    

     </thead>
            
                                
                      
                        </table>
                    </div>


        
      <p align="right"><font size="2">   <?php echo "[Tarikh Dicetak:"  .' '.date("Y-m-d").', '.  date("h:i:sa")."]";?></p>

        
        
   




