<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" media="print" href="bootstrap.css" />
<?php
use yii\helpers\Html; 


use yii\helpers\Url; 

error_reporting(0);

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

?> 
     
     
     
     <div class="col-md-12 col-sm-3 col-xs-12" style="margin-bottom: 15px; font-size:15px; margin-top: 50px">
                    <div class="profile_img text-center">
                        <div id="crop-avatar"> 
                     
                          <img src="/staff/web/images/logo-umsblack-text-png.png" width="200px" height="auto" alt="signature"/> <br><br>
                        </div>
                    </div>
      </div>

       <div class="x_panel" style=" text-align:center">
        <div class="x_content"> 
              
            <span class="required" style="color:#062f49;">
                <strong>
                    <center>
        
        <?php if ($biodata->jawatan->job_category==1)
        {?>
        <?= strtoupper('
     UNIT PEMBANGUNAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PERMOHONAN PENGAJIAN LANJUTAN KAKITANGAN AKADEMIK
        '); ?><?php }else{?>
            
            <?= strtoupper('
     UNIT PEMBANGUNAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PERMOHONAN PENGAJIAN LANJUTAN KAKITANGAN PENTADBIRAN
        '); ?><?php
        }?>

                        
                </strong> </center>
            </span> 
        </div>
    </div>
   
<h6><b>MAKLUMAT PERIBADI</b></h6>
<table class="table" style="font-size: 10px;font-family:Arial;"> 
    <tbody>
        <tr style="background-color:lightseagreen;color:white">
            
<th colspan="5" class="text-center"> 
    <p style="font-size: 12px;"><?= strtoupper($biodata->CONm); ?> |
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




<br/> 

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
       
        <div class="x_panel">
            <div class="x_title">
   <h6  ><strong><i class="fa fa-book"></i> MAKLUMAT AKADEMIK</strong></h6>
   
   
   <div class="clearfix"></div>
</div>   
            <?php
                    $akademik = $biodata->akademik;
              if($akademik){ ?>
            <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                    <thead style="background-color:lightseagreen;color:white">
                
                    <tr>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIL</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TAHAP PENDIDIKAN </th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIDANG</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">UNIVERSITI/INSTITUSI</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">KELAS/CGPA</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TARIKH DIANUGERAHKAN</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TAJAAN</th>
                        
                    </tr>
    </thead>
                    <tbody>

                    <?php $bil=1; foreach ($akademik as $akademik) { ?>

                        <tr>

                            <td><?= $bil++ ?></td>
                            <td><?= strtoupper($akademik->tahapPendidikan); ?></td>
                            <td><?= strtoupper($akademik->namaMajor);?></td>
                            <td><?= strtoupper($akademik->namainstitut);?></td>
                            <td><?= strtoupper($akademik->OverallGrade);?></td>
                            <td class="text-center"><?= strtoupper($akademik->confermentDt);?></td> 
                            <td ><?= strtoupper($akademik->Sponsorship);?></td>

                        </tr>
                    <?php } ?>
                    </tbody>
              
                
                </table>
                 
             </div>
              <?php }?>
    </div>
</div>
</div>
<div style="page-break-before:always">&nbsp;</div> 
<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12"> 
<div class="x_panel">

<div class="x_title">
   <h6 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN YANG DIPOHON</strong></h6>
   
   <div class="clearfix"></div>
</div>      

     <?php if($pengajian){
        foreach ($pengajian as $pengajian) {
                
                ?>  
            

                    <div class="x_content ">

                 <div class="table-responsive" >
                     
                        <table class="table table-striped table-sm  table-bordered" style="font-size: 10px;font-family:Arial;">
                            <thead>
                                
                                <tr class="info">
                                    <th colspan="8" style="background-color:lightseagreen;color:white"><center>
            
                                <?php if($pengajian->tahapPendidikan)
                                {
                                 echo strtoupper($pengajian->tahapPendidikan);
                                         
                                }
                                
                              
?></center></th>
                                </tr>
                                <tr> 
                        <th colspan="4" align="left">JAWATAN SEMASA CUTI BELAJAR</th>
                        <td colspan="4">
                        <?=strtoupper($biodata->jawatan->fname) ?></td>
                       
                    </tr>
                    <tr> 
                                
                        <th colspan="4" align="left">UNIVERSITI/INSTITUSI</th>
                        <td colspan="4">
                                  <?php echo strtoupper($pengajian->InstNm); ?></td><?php }?></tr>
                        
                        
                   
                     
                    <tr>
                 
                        <th colspan="4" align="left">BIDANG</th>
                        <td colspan="4"><?php
                        
                        if(($pengajian->MajorCd == NULL) && ($pengajian->MajorMinor != NULL))
                        {
                                echo  strtoupper($pengajian->MajorMinor);
                        }
                        elseif (($pengajian->MajorCd != NULL) && ($pengajian->MajorMinor != NULL))  {
                            echo   strtoupper($pengajian->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($pengajian->major->MajorMinor);
                        }
?></td>
                          <?php }?> 
                    </tr>
                    
                     <tr> 
                                
                        <th colspan="4" align="left">MOD PENGAJIAN</th>
                        <td colspan="4">
                            
                                  <?php if($pengajian->modeID)
                                  {echo strtoupper($pengajian->mod->studyMode);}
                                  
                                  else{
                                      echo "Tiada Maklumat";
                                  }
?></td></tr>
                     
                      <tr> 
                                
                        <th colspan="4" align="left">TAJUK PENYELIDIKAN</th>
                        <td colspan="4">
                                  <?php echo strtoupper($pengajian->tajuk_tesis); ?></td></tr>
                        <tr> 
                                
                        <th colspan="4" align="left">NAMA PENYELIA</th>
                        <td colspan="4">
                                  <?php echo strtoupper($pengajian->nama_penyelia); ?></td></tr>
                          <tr> 
                                
                        <th colspan="4" align="left">EMEL PENYELIA</th>
                        <td colspan="4">
                                  <?php echo ($pengajian->emel_penyelia); ?></td></tr>
                    
                  
                 
                    
                        <tr> 
                     
                        <th colspan="4" align="left">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td colspan="4">
                        <?= strtoupper($pengajian->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($pengajian->tarikhtamat)?> (<?= strtoupper($pengajian->tempohpengajian);?>)</td>
                        </tr>
                          
                     
                    
                  
                
                    

                          
            
                                
                      
                        </table>
                    </div> 

        </div></div>
  </div>
</div>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
              <?php 
              if($biasiswa){ ?>
            <div class="x_title">
                <h6><strong><i class="fa fa-money"></i>MAKLUMAT PEMBIAYAAN/PINJAMAN YANG DIPOHON</strong></h6>
                <div class="clearfix"></div>
            </div>

 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;">
                    <thead style="background-color:lightseagreen;color:white">
                    <tr class="headings" style="background-color:lightseagreen;color:white">
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white"><font size="2" >BIL</font></th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white"><font size="2">NAMA AGENSI/TAJAAN</font> </th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white"><font size="2">BENTUK TAJAAN </font></th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white"><font size="2">JUMLAH AMAUN</font></th>
                       
                    </tr>

                </thead>
                <tbody>

                    <?php $bil=1; foreach ($biasiswa as $biasiswa) { ?>

                        <tr>

                            <td style="width:6%;"><font size="2"><?= $bil++ ?></font></td>
                            <td><font size="2"><?= $biasiswa->nama_tajaan; ?></font></td>
                            <td><font size="2"><?= $biasiswa->bantuan->bentukBantuan;?></font></td>
                            <td><font size="2">RM <?= $biasiswa->amaunBantuan;?></font></td>
                           
                            
                        
                        </tr>
                    <?php } ?>
                </tbody>

                     </table>

                </form>



            </div>
        </div>
    </div>
</div>

      <?php } ?>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        <?php
                    $keluarga = $biodata->keluarga;
              if($keluarga){ ?>
        <div class="x_panel">
            
            <div class="x_title">
                <h6><strong><i class="fa fa-users"></i> MAKLUMAT KELUARGA</strong></h6>
                <div class="clearfix"></div>
            </div>

 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white"><font size="2">BIL</font></th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white"><font size="2">NAMA </font></th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white"><font size="2">HUBUNGAN</font></th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white"><font size="2">NO. KAD PENGENALAN</font> </th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white"><font size="2">UMUR </font></th>
                       
                    </tr>

                </thead>
                <tbody>

                    <?php $bil=1; foreach ($keluarga as $keluarga) { 
                         if($keluarga->hubunganKeluarga->RelNm == "Isteri" 
                   || $keluarga->hubunganKeluarga->RelNm == "Anak Kandung" || $keluarga->hubunganKeluarga->RelNm == "Suami"){?>

                        <tr>

                            <td style="width:6%;"><font size="2"><?= $bil++ ?></font></td>
                            <td><font size="2"><?= strtoupper($keluarga->FmyNm); ?></font></td>
                            <td><font size="2"><?= strtoupper($keluarga->hubunganKeluarga->RelNm);?></font></td>
                            <td><font size="2"><?= strtoupper($keluarga->FamilyId); ?></font></td>
                            <td><font size="2"><?=date("Y") - date("Y", strtotime($keluarga->FmyBirthDt))." " ."TAHUN";?></font></td>
                            
                        
                        </tr>
                      <?php }}}else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center"><b>Tiada Rekod </b></td>                     
                    </tr>
                  <?php  
                } ?>  
                </tbody>

                     </table>

                </form>



            </div>

        </div>
    </div>


      
</div>


<div class="x_panel">

<div class="x_title">
   <h6><strong><i class="fa fa-book"></i> MAKLUMAT BON PERKHIDMATAN</strong></h6>
   <div class="clearfix"></div>
</div> 
<div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;">
   <thead style="background-color:lightseagreen;color:white">
       
        <tr class="headings">
            <th class="column-title text-center" style="background-color:lightseagreen;color:white">BIL</th>
            <th class="column-title text-center" style="background-color:lightseagreen;color:white">PERINGKAT PENGAJIAN </th>
            <th class="column-title text-center" style="background-color:lightseagreen;color:white">TARIKH MULA BON </th>
            <th class="column-title text-center" style="background-color:lightseagreen;color:white">TEMPOH BON </th>
            <th class="column-title text-center" style="background-color:lightseagreen;color:white">TEMPOH BERKHIDMAT </th>
            <th class="column-title text-center" style="background-color:lightseagreen;color:white" colspan="2">BAKI BON</th>

        </tr>
        
        
        

    </thead>
    <tbody>
         <?php if($bon){ ?>
        <?php $bil=1; foreach ($bon as $bon) { ?>
        <tr>
<td class="text-center"><?= $bil++ ?></td>
<td class="text-center"><?= strtoupper($bon->tahapPendidikan); ?></td>

<td class="text-center"><?= strtoupper($bon->dtm); ?></td>

<td class="text-center"><?= strtoupper($bon->tempoh); ?></td>
<td class="text-center">
    
<?= strtoupper($bon->tempohbon
); ?></td>

         
<!--<td class="text-center"><?php //$bon->j_bon; ?></td>-->
            

        </tr>
        <?php }} else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>TIADA MAKLUMAT</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
             <tr>
                             <td colspan="4" align="right"><strong>JUMLAH TEMPOH BERKHIDMAT</strong></td>
                            
                     <td class="text-center" col>
                         <?= $sum+= $bon->tempohbon?>
                     </td></tr>
        



 </table>
</form>           </div> <!-- div for row-->
          <!-- div for well-->
</div>
<div class="x_panel">
<div class="x_title">
   <h6><strong><i class="fa fa-legal"></i> MAKLUMAT TUNTUTAN GANTIRUGI</strong></h6>
   <div class="clearfix"></div>
</div>
      <div>
<form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;">
   <thead style="background-color:lightseagreen;color:white">
       
       <tr class="headings">
                                            <th class="text-center" width="5%" style="background-color:lightseagreen;color:white">BIL</th>
                                            <th class="text-center" style="background-color:lightseagreen;color:white">PERINGKAT PENGAJIAN
</th>

                                            <th class="text-center" style="background-color:lightseagreen;color:white">JUMLAH PENGAJIAN</th>
                                            <th class="text-center" style="background-color:lightseagreen;color:white" colspan="8">JUMLAH GANTIRUGI SECARA PRO RATA</th>

<!--                                            <th class="text-center" style="width: 10%;">TEMPOH PENGAJIAN</th>-->
                                          

                                        </tr>
        
        
        

    </thead>
    <tbody>
         <?php if($tuntut){ ?>
        <?php $bil=1; foreach ($tuntut as $tuntut) { ?>
        <tr>
<td class="text-center"><?= $bil++ ?></td>
<td class="text-center"><?= strtoupper($tuntut->tahapPendidikan); ?></td>

<td class="text-center"><?= strtoupper($tuntut->j_cb); ?></td>

<td class="text-center"><?= strtoupper($tuntut->j_gantirugi); ?></td>

          

        </tr>
        <?php }} else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>TIADA MAKLUMAT</i></td>                     
                        </tr>
                  <?php  
                } ?>
                  
         
       
        



 </table>
</form>           </div></div>

<!-- <div style="page-break-before:always">&nbsp;</div> -->

<div class="x_panel">
        
          
          <div class="x_title">
   <h5 ><strong><i class="fa fa-legal"></i> NOMINAL DAMAGES</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
                
                    <div class="col-md-12 col-sm-12 col-xs-12"> 

                        <div class="x_content">
                            <div>
<form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;">
                           <thead style="background-color:lightseagreen;color:white">NOMINAL DAMAGES</thead>
                     </tr>
                                    <?php
                                   
                                    if ($nd) {
                                        $bil1 = 1;
                                        ?>
                                      

                                        <tr>
                                            <th>TARIKH MULA NOMINAL DAMAGES</th>
                                            <td class="text-left">
                                        <?php if($nd->dt_nominal)
                                        {
                                            echo strtoupper($nd->dtnominal);
                                        }
                                        else{
                                            echo "Tiada Maklumat";
                                        }
?></td>
                                        </tr>
                                        <tr>
                                            <?php if($nd->nd_nominal)
                                            {?>
                                             <th >TARIKH TAMAT NOMINAL DAMAGES</th>
                                             <td class="text-left"><?= strtoupper($nd->nd_nominal);?></td>

                                            <?php }?>
                                        </tr>
                                        
                                        <tr>
                                             <th class="text-left">TEMPOH NOMINAL DAMAGES</th>
                                             <td class="text-left">
                                            <?php 
                                          if($nd->nd_nominal)
                    {
                    echo $nd->tempohh;}
                     elseif ($nd->dt_setuju)
                    {
                        echo $nd->tempohhh;
                   
                    }

                    elseif ($nd->j_nd)
                    {
                        echo '<strong><small>'.$nd->tempoh1.'</strong></small>';
                   
                    }
                    else
                    {
                        echo "-";
                        
                    }?>
                                           </td>

     
                                        </tr>
                                         
                                        <tr>
                                             <th class="text-left" >JUMLAH KUTIPAN (BULANAN) : RM<?= strtoupper($nd->j_nd);?></th>
                                             <td class="text-left">
                    <?php
                    if($nd->nd_nominal)
                       {
                           echo "RM".($nd->j_nd * $nd->tempohh);
                           
                       }
                       elseif($nd->dt_setuju)
                       {
                           echo "RM".($nd->j_nd * $nd->tempoh1);
                       }
                      else
                       {
                       echo "RM".($nd->j_nd * $nd->tempohhh);}?>
                    </td>

                                        </tr>
                                           

                                     
                                        
                                      
<?php }
                                    else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center"><i>TIADA MAKLUMAT</i></td>                     
                        </tr>

                            <?php   }?>
                                            
                                </table>
                             
                            </div>
                        </div>
                    </div>
                
        </div>



     <p align="right"><font size="2">   <?php echo "[Tarikh Dicetak:"  .' '.date("Y-m-d").', '.  date("h:i:sa")."]";?></p>
