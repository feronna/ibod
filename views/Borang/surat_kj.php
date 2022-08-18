<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" media="print" href="bootstrap.css" />
<div style="margin-bottom: 170px;font-size: 11px">
     <br>
    
 </div> 
             <div style="margin-bottom:-14px; margin-left:-61px;margin-right:-61px; font-size: 10px;">
                     <table class="table table-sm table-bordered" style=" font-size: 10px;" width:100%;>
                     <tr>
                       <td colspan="10" style="text-align:center; background-color:#527e72" color="white" height="30px" ><strong>  MAKLUMAT PEMOHON </strong></td>
                     </tr>
                     
                    <tr> 
                     <td style="width:15%"  height="25px"><strong>NAMA</strong></td>
                     <td style="width:35%"  height="25px"><?= $facility->kakitangan->CONm ?></td>
                     <td style="width:15%"  height="25px"><strong>NO. KP</strong></td>
                     <td style="width:35%"  height="25px"><?= $facility->icno ?> </td>
                    </tr>
                    
                    <tr> 
                     <td style="width:15%"  height="25px"><strong>JAWATAN & GRED</strong></td>
                     <td><?= ucwords(strtoupper($facility->kakitangan->jawatan->nama))?> (<?= $facility->kakitangan->jawatan->gred?>)</td>
                    </tr>
                     
                     <tr> 
                     <td style="width:15%"  height="25px"><strong>J/ F/ P/ I/ B</strong></td>
                     <td style="width:35%"  height="25px"><?= ucwords(strtoupper($facility->kakitangan->department->fullname)) ?> </td>    
                     <td style="width:15%"  height="25px"><strong>TARAF JAWATAN</strong></td>
                     <td style="width:35%"  height="25px"><?= ucwords(strtoupper($facility->kakitangan->statusLantikan->ApmtStatusNm ))?></td> 
                     </tr>
              
                     <tr> 
                     <td style="width:15%"  height="25px"><strong>EMEL</strong></td>
                     <td style="width:35%"  height="25px"><?= $facility->kakitangan->COEmail ?></td>
                     <td style="width:15%"  height="25px"><strong>NO TELEFON</strong></td>
                     <td style="width:35%"  height="25px"><?= $facility->kakitangan->COOffTelNo ?></td>
                     </tr>
                     <tr> 
                      </table> 
             </div>
 <div style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;">
                 <table class="table table-sm table-bordered" style=" font-size: 10px;" width:100%;>
                     <tr>
                       <td colspan="10" style="text-align:center; background-color:#527e72" color="white" height="30px" ><strong> <?= ucwords(strtoupper($facility->displayjenis->kemudahan ))?></strong></td>
                     </tr>
                     
                    <tr> 
                     <td style="width:30%"  height="25px"><strong>TUNTUTAN</strong></td>
                     <td style="width:70%" height="25px"><?= ucwords(strtoupper($facility->displayjenis->kemudahan ))?></td>
                    
                     </tr>
                     
                     <tr> 
                     <td style="width:30%" height="25px"><strong>BUTIRAN</strong></td>
                     <td style="width:70%"  height="25px"><?= ucwords(strtoupper($facility->reftujuan->tujuan))?></td>
                     
                     </tr>
                     <tr>
                         
                      <tr> 
                     <td style="width:30%"  height="25px"><strong>TUJUAN</strong></td>
                     <td style="width:70%"  height="25px"><?= ucwords(strtoupper($facility->tujuan))?></td>
                      
                     </tr>
                     
                     <tr>  
                     <td style="width:30%" height="25px"><strong>DESTINASI</strong></td>
                     <td style="width:70%"  height="25px"><?= ucwords(strtoupper($facility->nama_tempat))?> <?= ucwords(strtoupper($facility->negara))?></td>
                     </tr>
                     
                     <tr>  
                     <td style="width:30%"  height="25px"><strong>TARIKH</strong></td>
                     <td style="width:70%"  height="25px"><?= ucwords(strtoupper($facility->dateFrom))?> -&nbsp;<?= ucwords(strtoupper($facility->dateTo))?></td>
                     </tr>
                     
                     <tr>  
                     <td style="width:30%" height="25px"><strong>TEMPOH</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->days?> HARI</td>
                     </tr>
                             
                      </table>
 </div>
 <div style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;">
                <table class="table table-sm table-bordered" style=" font-size: 10px; width:100%;">
                     <tr>
                      <td  colspan="10" style="text-align:center; background-color:#527e72" color="white" height="25px" ><strong>PENGAKUAN PEGAWAI</strong></td>

                     </tr>
                       <tr> 
                           <td style="font-size: 12px; width:100%"  height="25px" ><strong> 
                            Saya mengesahkan maklumat-maklumat yang dinyatakan dalam permohonan ini adalah benar dan betul. <br>
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
                     <td style="width:30%"  height="25px"><strong>PEGAWAI TADBIR</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->pegTadbir->CONm ?> </td> 
                     </tr>
                        
                      <tr> 
                     <td style="width:30%" height="25px"><strong>TARIKH SEMAKAN</strong></td>
                     <td style="width:70%"  height="25px"><?= ucwords(strtoupper($facility->reviewdate))?></td> 
                     </tr>
                      
                    <tr> 
                     <td style="width:30%"  height="25px"><strong>STATUS SEMAKAN</strong></td>
                     <td style="width:70%"  height="25px"> <?= $facility->status ?></td> 
                     </tr>
                      
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>CATATAN</strong></td>
                     <td style="width:70%"  height="25px"> <?= $facility->catatan ?></td> 
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
                     <td style="width:30%"  height="25px"><strong>PEGAWAI TADBIR</strong></td> 
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
                       <td colspan="10" style="text-align:center;  background-color:#527e72" color="white" height="25px" ><strong>PERAKUAN PEGAWAI BSM</strong></td>
                        
                     </tr>
                     
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>PEGAWAI BSM</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->pegBsm->CONm ?></td> 
                     </tr>
                      
                     <tr> 
                     <td style="width:30%" height="25px"><strong>TARIKH PERAKUAN</strong></td>
                     <td style="width:70%"  height="25px"><?= ucwords(strtoupper($facility->verdate))?></td> 
                     </tr>
                     
                    <tr> 
                     <td style="width:30%"  height="25px"><strong>STATUS PERAKUAN</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->status_pp ?></td> 
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

 <div style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;">

                  <table class="table table-sm table-bordered" style=" font-size: 10px; width:100%;">
                     <tr>
                       <td colspan="10" style="text-align:center; background-color:#527e72" color="white" height="25px" ><strong>KELULUSAN KETUA BSM</strong></td>
                        
                     </tr>
                     
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>KETUA BSM</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->kjBsm->CONm ?></td> 
                     </tr> 
                        
                     <tr> 
                     <td style="width:30%" height="25px"><strong>TARIKH KELULUSAN</strong></td>
                     <td style="width:70%"  height="25px"><?= ucwords(strtoupper($facility->appdate))?></td> 
                     </tr>
                     
                    <tr> 
                     <td style="width:30%"  height="25px"><strong>STATUS KELULUSAN</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->status_kj ?></td> 
                     </tr>
                      
                     <tr> 
                     <td style="width:30%" height="25px"><strong>CATATAN</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->catatan_kj ?></td> 
                     </tr>
                                    
                          
                      </table>
              </div>
</pagebreak>