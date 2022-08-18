<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" media="print" href="bootstrap.css" />
<div style="margin-bottom: 170px;font-size: 11px">
     <br>
 
 </div> 
              
<div style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;">
                <table class="table table-sm table-bordered" style=" font-size: 10px; width:100%;">
                     <tr>
                      <td  colspan="10" style="text-align:center; background-color:#527e72" color="white" height="30px"><strong> BUTIRAN PERMOHONAN <?= ucwords(strtoupper($facility->displayjenis->kemudahan ))?></strong></td>

                     </tr>
                       <tr> 
                     <td style="width:30%"  height="25px"><strong>NAMA</strong></td>
                     <td style="width:70%"  height="25px">&nbsp;<?= $facility->kakitangan->CONm ?> </td> 
                     </tr>
                     
                     <tr> 
                     <td style="width:35%" height="25px"><strong>NO. KP</strong></td>
                     <td style="width:65%" height="25px">&nbsp;<?= $facility->icno ?></td> 
                     </tr>
                     
                    <tr> 
                      <td style="width:35%"  height="25px"><strong>UMS PER</strong></td>
                     <td style="width:65%">&nbsp;<?= $facility->kakitangan->COOldID ?></td> 
                     </tr>
                      
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>JAWATAN & GRED</strong></td>
                     <td style="width:70%"  height="25px">&nbsp;<?= ucwords(strtoupper($facility->kakitangan->jawatan->nama))?> (<?= $facility->kakitangan->jawatan->gred?>)</td> 
                     </tr>
                     
<!--                     <tr> 
                     <td style="width:35%"  height="25px"><strong>TARAF JAWATAN</strong></td>
                     <td style="width:65%">&nbsp;<?= ucwords(strtoupper($facility->kakitangan->statusLantikan->ApmtStatusNm ))?></td> 
                     </tr>-->
                      
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>J/ A/ F/ P/ I/ B</strong></td>
                     <td style="width:70%"  height="25px">&nbsp;<?= ucwords(strtoupper($facility->kakitangan->department->fullname)) ?> </td> 
                     </tr>
                     
                      <tr> 
                     <td style="width:35%"  height="25px"><strong>EMEL</strong></td>
                     <td style="width:65%">&nbsp;<?= $facility->kakitangan->COEmail ?></td> 
                     </tr>
                      
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>NO. TELEFON BIMBIT</strong></td>
                     <td style="width:70%"  height="25px">&nbsp;<?= $facility->kakitangan->COHPhoneNo ?>  </td> 
                     </tr>
                     
                      <tr> 
                     <td style="width:35%"  height="25px"><strong>NO. UC</strong></td>
                     <td style="width:65%">&nbsp;<?= $facility->kakitangan->COOUCTelNo ?></td> 
                     </tr>
                      
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>WILAYAH ASAL</strong></td>
                     <td style="width:70%"  height="25px">&nbsp;<?= ucwords(strtoupper($facility->wilayah_asal))?>  </td> 
                     </tr>
                      
                     
                      <tr> 
                     <td style="width:35%"  height="25px"><strong>TARIKH TERAKHIR</strong></td>
                     <td style="width:65%">&nbsp;<?php
                            if($mod){
                                echo ucwords(strtoupper($mod->lastdt)); //id 1 n 2 
                            } 
                            else { 
                                 echo 'TIADA REKOD' ;
                            } 
                            ?></td> 
                     </tr>
                      
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>TARIKH DIGUNAKAN</strong></td>
                     <td style="width:70%"  height="25px"> &nbsp;<?= ucwords(strtoupper($facility->useddt))?> </td> 
                     </tr>
                     
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>KADAR KELAYAKAN</strong></td>
                     <td style="width:70%"  height="25px">&nbsp;<?= $kadar->tanggungan ?>  </td> 
                     </tr>
                     
                     <tr> 
                     <td style="width:35%"  height="25px"><strong>TUJUAN</strong></td>
                     <td style="width:65%">&nbsp;<?= ucwords(strtoupper( $facility->tujuan)) ?></td> 
                     </tr>
                     
                     
                          
                      </table>
 </div>
 
<?php if($fmy->exists()){?>
 <div style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;">

                 <table class="table table-sm table-bordered" style=" font-size: 10px;">
                     <tr>
                       <td colspan="14" style="text-align:center; background-color:#527e72" color="white" height="25px" ><strong> MAKLUMAT TANGGUNGAN</strong></td>
                     </tr>
                     
                    <tr> 
              
                 <td colspan="2"  height="25px"><center><strong>NAMA</strong></center></td> 
                 <td colspan="2"  height="25px"><center><strong>UMUR</strong></center></td>
                 <td colspan="4"  height="25px"><center><strong>NO.MYKAD</strong></center></td> 
                 <td colspan="4"  height="25px"><center><strong>TARIKH LAHIR</strong></center></td> 
                 <td colspan="2"  height="25px"><center><strong>HUBUNGAN</strong></center></td>
                    
                     </tr>
                     
                     <?php if($keluarga) { 
                       foreach ($keluarga as $keluargakakitangan) { 
                    ?>
                     <tr>  
                    
                     <td  colspan="2"  height="25px">&nbsp;&nbsp;<?= $keluargakakitangan->nama; ?></td> 
                     <td  colspan="2"  height="25px"><center><?= $diff = (date('Y') - date('Y',strtotime($keluargakakitangan->tarikh_lahir)));?></center></td>
                     <td  colspan="4"  height="25px"><center><?= $keluargakakitangan->icno; ?></center></td>
                     <td  colspan="4"  height="25px"><center><?= $keluargakakitangan->tarikhLahir;?></center></td>
                     <td  colspan="2"  height="25px"><center><?= $keluargakakitangan->hubungan; ?></center></td>
                     
                     </tr>
                      
                       <?php } 

                    } else{
                        ?>
                        <tr>
                            <td colspan="10" class="text-center">Tiada Rekod</td>                     
                        </tr>
                      <?php  
                    } ?>  
              
                      </table>
 </div>
<pagebreak>
      
     <div style="margin-bottom: 170px;font-size: 11px">
     <br>
 
 </div> 
<div style="margin-bottom:-8px; margin-left:-61px;margin-right:-61px; font-size: 10px;">

                 <table class="table table-sm table-bordered" style=" font-size: 10px;">
                     <tr>
                         <td colspan="16" style="text-align:center; background-color:#527e72" color="white" height="25px" ><strong> JADUAL PENERBANGAN YANG DIRANCANG ATAU DITEMPAH </strong></td>
                     </tr>
                     <tr>
                         <td colspan="16" style="text-align:center; background-color:#527e72" color="white" height="20px" ><strong> PERLEPASAN</strong></td>
                       
                     </tr>
                     
                    <?php if($planes) { 
                       foreach ($planes as $planes) { 
                    ?> 
                    <tr>  
                     <td colspan="4"  height="35px"><strong>DESTINASI LAPANGAN TERBANG :</strong></td>
                     <td colspan="12"  height="35px"> <strong>&nbsp;<?= $planes->dest_berlepas ?></strong></td> 
                   </tr> 
                   <tr>  
                     <td colspan="4"  height="35px"><strong>TARIKH:</strong></td>
                     <td colspan="4"  height="35px"> <strong>&nbsp;<?= $planes->depart; ?></strong></td> 
                     <td colspan="4"  height="35px"><strong>MASA:</strong></td>
                     <td colspan="4"  height="35px"> <strong>&nbsp;<?= $planes->masa_berlepas;?></strong></td> 
                   </tr> 
                   <tr>
                      <td colspan="16" style="text-align:center; background-color:#527e72" color="white" height="20px" ><strong> KETIBAAN</strong></td>
                         
                    </tr>
                   <tr>  
                     <td colspan="4"  height="35px"><strong>DESTINASI LAPANGAN TERBANG :</strong></td>
                     <td colspan="12"  height="35px"> <strong>&nbsp;<?= $planes->dest_tiba ?></strong></td> 
                   </tr> 
                   <tr>  
                     <td colspan="4"  height="35px"><strong>TARIKH:</strong></td>
                     <td colspan="4"  height="35px"> <strong>&nbsp;<?= $planes->arrival; ?></strong></td> 
                     <td colspan="4"  height="35px"><strong>MASA:</strong></td>
                     <td colspan="4"  height="35px"> <strong>&nbsp;<?= $planes->masa_tiba;?></strong></td> 
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
<div style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;">
                <table class="table table-sm table-bordered" style=" font-size: 10px; width:100%;">
                     <tr>
                      <td  colspan="10" style="text-align:center; background-color:#527e72" color="white" height="25px" ><strong>PENGAKUAN PEGAWAI</strong></td>

                     </tr>
                       <tr> 
                           <td style="font-size: 12px; width:100%"  height="25px" ><strong> 
                           Saya mengesahkan bahawa segala maklumat yang diberikan dalam permohonan ini adalah benar dan betul.
                           Urusan pembelian tiket Mengunjungi Wilayah Asal saya adalah berdasarkan peraturan yang sedang berkuatkuasa. <br>
                            <br><br> 
                             &nbsp;&nbsp; PEMOHON &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= $facility->kakitangan->CONm ?> 
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 
                            
                             TARIKH : <?= $facility->entryDate ?>
                             <br>
                             
                         </strong></td> 

                     </tr> 
                      </table>
 </div>

  <?php if($facility->entry_type == 1){?>

 <div style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;">
                <table class="table table-sm table-bordered" style=" font-size: 10px; width:100%;">
                     <tr>
                      <td  colspan="10" style="text-align:center; background-color:#527e72" color="white" height="25px" ><strong>SEMAKAN PEMBANTU TADBIR BSM</strong></td>

                     </tr>
                       <tr> 
                     <td style="width:30%"  height="25px"><strong>PEMBANTU TADBIR (P/O) KANAN</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->pegTadbir->CONm ?> </td> 
                     </tr>
                     
                     <tr> 
                     <td style="width:35%" height="25px"><strong>TARIKH SEMAKAN</strong></td>
                     <td style="width:65%" height="25px"><?= ucwords(strtoupper($facility->date_pt))?></td> 
                     </tr>
                     
                    <tr> 
                      <td style="width:35%"  height="25px"><strong>STATUS SEMAKAN</strong></td>
                     <td style="width:65%"> <?= $facility->status_pt ?></td> 
                     </tr>
                      
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>CATATAN</strong></td>
                     <td style="width:70%"  height="25px"> <?= $facility->catatan_pt ?></td> 
                     </tr>
                          
                      </table>
 </div>

  <?php } ?>
<?php if($facility->entry_type == 2){?>
<div style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;">
                <table class="table table-sm table-bordered" style=" font-size: 10px; width:100%;">
                     <tr>
                        <td colspan="10" style="text-align:center; background-color:#527e72" color="white" height="25px" ><strong> SEMAKAN PEMBANTU TADBIR BSM</strong></td>
                       
                     </tr>
                     
                      <tr> 
                     <td style="width:30%"  height="25px"><strong>PEMBANTU TADBIR (P/O) KANAN</strong></td> 
                     <td style="width:70%"  height="25px"> TIDAK BERKAITAN </td> 
                     
                     </tr> 
                     
                     <tr> 
                     <td style="width:30%" height="25px"><strong>TARIKH SEMAKAN</strong></td>
                     <td style="width:70%"  height="25px"> TIDAK BERKAITAN </td> 
                     </tr>
                     
                    <tr> 
                      <td style="width:30%"  height="25px"><strong>STATUS SEMAKAN</strong></td>
                      <td style="width:70%"  height="25px"> TIDAK BERKAITAN  </td> 
                     </tr> 
                    
                       <tr> 
                     <td style="width:30%"  height="25px"><strong>CATATAN</strong></td>
                     <td style="width:70%"  height="25px"> TIDAK BERKAITAN </td> 
                     </tr>
                      </table>
 </div> 
 <?php } ?>
  <pagebreak>
      <div style="margin-bottom: 170px;font-size: 11px">
     <br>
 
 </div> 
 <?php if($facility->entry_type == 1){?>
<div style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;">

                  <table class="table table-sm table-bordered" style=" font-size: 10px; width:100%;">
                     <tr>
                       <td  colspan="10" style="text-align:center; background-color:#527e72" color="white" height="25px" ><strong>PERAKUAN PEGAWAI BSM</strong></td>
                      
                     </tr>
                     
                      <tr> 
                     <td style="width:30%"  height="25px"><strong>PEGAWAI BSM</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->pegBsm->CONm ?></td> 
                     </tr>
                     
                      <tr> 
                     <td style="width:35%" height="25px"><strong>TARIKH PERAKUAN</strong></td>
                     <td style="width:65%" height="25px"><?= ucwords(strtoupper($facility->verdate))?></td> 
                     </tr>
                      
                    <tr> 
                     <td style="width:35%"  height="25px"><strong>STATUS PERAKUAN</strong></td>
                    <td style="width:65%" height="25px"> <?= $facility->status_pp ?></td> 
                     </tr> 
               
                      <tr> 
                     <td style="width:30%"  height="25px"><strong>CATATAN</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->catatan_pp ?></td> 
                     </tr>
                          
                      </table>
              </div>
<?php } ?>
<?php if($facility->entry_type == 2){?>
<div style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;"> 
                  <table class="table table-sm table-bordered" style=" font-size: 10px; width:100%;">
                     <tr>
                       <td colspan="10" style="text-align:center;  background-color:#527e72" color="white" height="25px" ><strong>PERAKUAN PEGAWAI BSM</strong></td>
                        
                     </tr> 
                      <tr>  
                     <td style="width:30%"  height="25px"><strong>PEGAWAI BSM</strong></td> 
                     <td style="width:70%"  height="25px">TIDAK BERKAITAN</td>  
                    
                     </tr>
                     
                     <tr> 
                     <td style="width:30%" height="25px"><strong>TARIKH PERAKUAN</strong></td>
                     <td style="width:70%"  height="25px">TIDAK BERKAITAN</td> 
                     </tr>
                     
                    <tr> 
                     <td style="width:30%"  height="25px"><strong>STATUS PERAKUAN</strong></td>
                     <td style="width:70%"  height="25px"> TIDAK BERKAITAN</td> 
                     </tr>
                      
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>CATATAN</strong></td>
                     <td style="width:70%"  height="25px">TIDAK BERKAITAN</td> 
                     </tr>
                          
                      </table>
              </div>
 <?php } ?>

 
<div  class=" break"style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;">

                  <table class="table table-sm table-bordered" style=" font-size: 10px; width:100%;">
                     <tr>
                       <td  colspan="10" style="text-align:center; background-color:#527e72" color="white" height="25px" ><strong>KELULUSAN KETUA BSM</strong></td>
                      
                     </tr>
                     
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>KETUA BSM</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->kjBsm->CONm ?></td> 
                     </tr> 
                     
                      <tr> 
                     <td style="width:35%" height="25px"><strong>TARIKH KELULUSAN</strong></td>
                     <td style="width:65%" height="25px"><?= ucwords(strtoupper($facility->appdate))?></td> 
                     </tr>
                      
                    <tr> 
                     <td style="width:35%"  height="25px"><strong>STATUS KELULUSAN</strong></td>
                    <td style="width:65%" height="25px">  <?= $facility->status_kj ?></td> 
                     </tr>
                      
                       <tr> 
                     <td style="width:30%" height="25px"><strong>CATATAN</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->catatan_kj ?></td> 
                     </tr>
                          
                      </table>
              </div>
 
<?php }else{ ?>
<?php { ?>
 
 <div style="margin-bottom:-8px; margin-left:-61px;margin-right:-61px; font-size: 10px;">

                 <table class="table table-sm table-bordered" style=" font-size: 10px;">
                     <tr>
                         <td colspan="16" style="text-align:center; background-color:#527e72" color="white" height="30px" ><strong> JADUAL PENERBANGAN YANG DIRANCANG ATAU DITEMPAH </strong></td>
                     </tr>
                     <tr>
                         <td colspan="16" style="text-align:center; background-color:#527e72" color="white" height="20px" ><strong> PERLEPASAN</strong></td>
                     </tr>
                     
                    <?php if($planes) { 
                       foreach ($planes as $planes) { 
                    ?> 
                    <tr>  
                     <td colspan="4"  height="35px"><strong>DESTINASI LAPANGAN TERBANG :</strong></td>
                     <td colspan="12"  height="35px"> <strong>&nbsp;<?= $planes->dest_berlepas ?></strong></td> 
                   </tr> 
                   <tr>  
                     <td colspan="4"  height="35px"><strong>TARIKH:</strong></td>
                     <td colspan="4"  height="35px"> <strong>&nbsp;<?= $planes->depart; ?></strong></td> 
                     <td colspan="4"  height="35px"><strong>MASA:</strong></td>
                     <td colspan="4"  height="35px"> <strong>&nbsp;<?= $planes->masa_berlepas;?></strong></td> 
                   </tr> 
                   <tr>
                      <td colspan="16" style="text-align:center; background-color:#527e72" color="white" height="20px" ><strong> KETIBAAN</strong></td>
                    </tr>
                   <tr>  
                     <td colspan="4"  height="35px"><strong>DESTINASI LAPANGAN TERBANG :</strong></td>
                     <td colspan="12"  height="35px"> <strong>&nbsp;<?= $planes->dest_tiba ?></strong></td> 
                   </tr> 
                   <tr>  
                     <td colspan="4"  height="35px"><strong>TARIKH:</strong></td>
                     <td colspan="4"  height="35px"> <strong>&nbsp;<?= $planes->arrival; ?></strong></td> 
                     <td colspan="4"  height="35px"><strong>MASA:</strong></td>
                     <td colspan="4"  height="35px"> <strong>&nbsp;<?= $planes->masa_tiba;?></strong></td> 
                   </tr> 
                     
                      <?php } 

                    } else{
                        ?>
                        <tr>
                            <td colspan="5" class="text-center">Tiada Rekod</td>                     
                        </tr>
                      <?php  
                    } ?>  
<!--                     <td colspan="3"  height="25px"><strong>DESTINASI PERLEPASAN</strong></td>
                     <td colspan="3"  height="25px"><strong>MASA</strong></td>
                     <td colspan="3"  height="25px"><strong>TARIKH</strong></td>
                     <td colspan="3"  height="25px"><strong>DESTINASI PERLEPASAN</strong></td>
                     <td colspan="2"  height="25px"><strong>MASA</strong></td>-->
                     <!--<td colspan="4"  height="25px"><strong>JENIS(S/P/A)</strong></td>-->
                    
                    
                     
                     
              
                      </table>
 </div>
<div style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;">
                <table class="table table-sm table-bordered" style=" font-size: 10px; width:100%;">
                     <tr>
                      <td  colspan="10" style="text-align:center; background-color:#527e72" color="white" height="25px" ><strong>PENGAKUAN PEGAWAI</strong></td>

                     </tr>
                       <tr> 
                           <td style="font-size: 12px; width:100%"  height="25px" ><strong><br>
                            Saya mengesahkan bahawa segala maklumat yang diberikan dalam permohonan ini adalah benar dan betul.
                            Urusan pembelian tiket Mengunjungi Wilayah Asal saya adalah berdasarkan peraturan yang sedang berkuatkuasa. <br><br>
                         
                              &nbsp;&nbsp;&nbsp;&nbsp; PEMOHON &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= $facility->kakitangan->CONm ?> 
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 
                             &nbsp;&nbsp; 
                             TARIKH : <?= $facility->entryDate ?>
                             <br><br>
                             
                         </strong></td> 

                     </tr>
                     
                      
                          
                      </table>
 </div>
 <pagebreak>
      
     <div style="margin-bottom: 170px;font-size: 11px">
     <br>
 
 </div> 
     
  <?php if($facility->entry_type == 1){?>

 <div style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;">
                <table class="table table-sm table-bordered" style=" font-size: 10px; width:100%;">
                     <tr>
                      <td  colspan="10" style="text-align:center; background-color:#527e72" color="white" height="25px" ><strong>SEMAKAN PEMBANTU TADBIR BSM</strong></td>

                     </tr>
                       <tr> 
                     <td style="width:30%"  height="25px"><strong>PEMBANTU TADBIR (P/O) KANAN</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->pegTadbir->CONm ?> </td> 
                     </tr>
                     
                     <tr> 
                     <td style="width:35%" height="25px"><strong>TARIKH SEMAKAN</strong></td>
                     <td style="width:65%" height="25px"><?= ucwords(strtoupper($facility->date_pt))?></td> 
                     </tr>
                     
                    <tr> 
                      <td style="width:35%"  height="25px"><strong>STATUS SEMAKAN</strong></td>
                     <td style="width:65%"> <?= $facility->status_pt ?></td> 
                     </tr>
                      
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>CATATAN</strong></td>
                     <td style="width:70%"  height="25px"> <?= $facility->catatan_pt ?></td> 
                     </tr>
                          
                      </table>
 </div>

  <?php } ?>
<?php if($facility->entry_type == 2){?>
<div style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;">
                <table class="table table-sm table-bordered" style=" font-size: 10px; width:100%;">
                     <tr>
                        <td colspan="10" style="text-align:center; background-color:#527e72" color="white" height="25px" ><strong> SEMAKAN PEMBANTU TADBIR BSM</strong></td>
                       
                     </tr>
                     
                      <tr> 
                     <td style="width:30%"  height="25px"><strong>PEMBANTU TADBIR (P/O) KANAN</strong></td> 
                     <td style="width:70%"  height="25px"> TIDAK BERKAITAN </td> 
                     
                     </tr>
                     
                     <tr> 
                     <td style="width:30%" height="25px"><strong>TARIKH SEMAKAN</strong></td>
                     <td style="width:70%"  height="25px"> TIDAK BERKAITAN </td> 
                     </tr>
                     
                    <tr> 
                      <td style="width:30%"  height="25px"><strong>STATUS SEMAKAN</strong></td>
                      <td style="width:70%"  height="25px"> TIDAK BERKAITAN  </td> 
                     </tr> 
                    
                       <tr> 
                     <td style="width:30%"  height="25px"><strong>CATATAN</strong></td>
                     <td style="width:70%"  height="25px"> TIDAK BERKAITAN </td> 
                     </tr>
                      </table>
 </div> 
 <?php } ?>

 <?php if($facility->entry_type == 1){?>
<div style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;">

                  <table class="table table-sm table-bordered" style=" font-size: 10px; width:100%;">
                     <tr>
                       <td  colspan="10" style="text-align:center; background-color:#527e72" color="white" height="25px" ><strong>PERAKUAN PEGAWAI BSM</strong></td>
                      
                     </tr>
                     
                      <tr> 
                     <td style="width:30%"  height="25px"><strong>PEGAWAI BSM</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->pegBsm->CONm ?></td> 
                     </tr>
                     
                      <tr> 
                     <td style="width:35%" height="25px"><strong>TARIKH PERAKUAN</strong></td>
                     <td style="width:65%" height="25px"><?= ucwords(strtoupper($facility->verdate))?></td> 
                     </tr>
                      
                    <tr> 
                     <td style="width:35%"  height="25px"><strong>STATUS PERAKUAN</strong></td>
                    <td style="width:65%" height="25px"> <?= $facility->status_pp ?></td> 
                     </tr> 
               
                      <tr> 
                     <td style="width:30%"  height="25px"><strong>CATATAN</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->catatan_pp ?></td> 
                     </tr>
                          
                      </table>
              </div>
<?php } ?>
<?php if($facility->entry_type == 2){?>
<div style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;"> 
                  <table class="table table-sm table-bordered" style=" font-size: 10px; width:100%;">
                     <tr>
                       <td colspan="10" style="text-align:center;  background-color:#527e72" color="white" height="25px" ><strong>PERAKUAN PEGAWAI BSM</strong></td>
                        
                     </tr> 
                      <tr>  
                     <td style="width:30%"  height="25px"><strong>PEGAWAI BSM</strong></td> 
                     <td style="width:70%"  height="25px">TIDAK BERKAITAN</td>  
                    
                     </tr>
                     
                     <tr> 
                     <td style="width:30%" height="25px"><strong>TARIKH PERAKUAN</strong></td>
                     <td style="width:70%"  height="25px">TIDAK BERKAITAN</td> 
                     </tr>
                     
                    <tr> 
                     <td style="width:30%"  height="25px"><strong>STATUS PERAKUAN</strong></td>
                     <td style="width:70%"  height="25px"> TIDAK BERKAITAN</td> 
                     </tr>
                      
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>CATATAN</strong></td>
                     <td style="width:70%"  height="25px">TIDAK BERKAITAN</td> 
                     </tr>
                          
                      </table>
              </div>
 <?php } ?>

 
<div  class=" break"style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;">

                  <table class="table table-sm table-bordered" style=" font-size: 10px; width:100%;">
                     <tr>
                       <td  colspan="10" style="text-align:center; background-color:#527e72" color="white" height="25px" ><strong>KELULUSAN KETUA BSM</strong></td>
                      
                     </tr>
                     
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>KETUA BSM</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->kjBsm->CONm ?></td> 
                     </tr> 
                     
                      <tr> 
                     <td style="width:35%" height="25px"><strong>TARIKH KELULUSAN</strong></td>
                     <td style="width:65%" height="25px"><?= ucwords(strtoupper($facility->appdate))?></td> 
                     </tr>
                      
                    <tr> 
                     <td style="width:35%"  height="25px"><strong>STATUS KELULUSAN</strong></td>
                    <td style="width:65%" height="25px">  <?= $facility->status_kj ?></td> 
                     </tr>
                      
                       <tr> 
                     <td style="width:30%" height="25px"><strong>CATATAN</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->catatan_kj ?></td> 
                     </tr>
                          
                      </table>
              </div>
<?php } ?>  
     <?php } ?>  
</pagebreak>
  </pagebreak>