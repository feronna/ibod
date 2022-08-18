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
                 <table class="table table-sm table-bordered" style=" font-size: 10px;">
                     <tr>
                       <td colspan="10" style="text-align:center; background-color:#527e72" color="white" height="30px" ><strong> KASUT & PAKAIAN SERAGAM</strong></td>
                     </tr>
                     
                    <tr> 
                     <td colspan="1"  height="25px"><strong>TUNTUTAN</strong></td>
                     <td  colspan="9"  height="25px"><?= ucwords(strtoupper($facility->seragam ))?></td>
                    
                     </tr>
                     
                      <tr> 
                     <td colspan="1"  height="25px"><strong>JENIS KULIT KASUT</strong></td>
                     <td>
                       <?php if($facility->jenis_belian !=  NULL){ 
                            echo ucwords(strtoupper($facility->jenis_belian ));
                         }else{
                                echo 'TIADA BERKAITAN' ;
                           }?>
                     </td>
                     <td colspan="2"  height="25px"><strong>BIL KULIT KASUT</strong></td>
                     
                     <td colspan="6"  height="25px"> 
                          <?php if($facility->bil_belian !=  NULL){ 
                            echo ucwords(strtoupper($facility->bil_belian ));
                           }else{
                                echo 'TIADA BERKAITAN' ;
                           }?>
                     </td>
                   
                   
                     </tr>
                     
                      <tr> 
                     <td colspan="1"  height="25px"><strong>TARIKH</strong></td>
                     <td><?= ucwords(strtoupper($facility->used))?></td>
                     <td colspan="2"  height="25px"><strong>NOMBOR BIL/RESIT</strong></td>
                     <td colspan="6"  height="25px"><?= $facility->resit?></td>
                     </tr>
                     
                     <tr> 
                     <td colspan="1"  height="25px"><strong>JUMLAH TUNTUTAN</strong></td>
                     <td  colspan="9"  height="25px">RM <?= $facility->jumlah_tuntutan?></td>
                     
                     </tr>
                     <tr>
                         
                        
                             
                      </table>
 </div>
  
  
 <div style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;">
                <table class="table table-sm table-bordered" style=" font-size: 10px; width:100%;">
                     <tr>
                        <td colspan="10" style="text-align:center; background-color:#527e72" color="white" height="25px" ><strong>PERAKUAN KETUA JABATAN</strong></td>
                       
                     </tr>
                     
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>KETUA JABATAN</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->pegBsm->CONm ?></td> 
                     </tr>
                     
                      <tr> 
                     <td style="width:30%" height="25px"><strong>TARIKH PERAKUAN</strong></td>
                     <td style="width:70%"  height="25px"><?= ucwords(strtoupper($facility->appdate))?></td> 
                     </tr>
                     
                    <tr> 
                      <td style="width:30%"  height="25px"><strong>STATUS PERAKUAN</strong></td>
                      <td style="width:70%"  height="25px"> <?= $facility->status_kj ?> </td> 
                     </tr>
                      
                      <tr> 
                     <td style="width:30%"  height="25px"><strong>CATATAN</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->catatan_kj ?></td> 
                     </tr>
                          
                      </table>
 </div>
 
<div style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;">

                  <table class="table table-sm table-bordered" style=" font-size: 10px; width:100%;">
                     <tr>
                       <td colspan="10" style="text-align:center;  background-color:#527e72" color="white" height="25px" ><strong>SEMAKAN PENYELIA BPG</strong></td>
                        
                     </tr>
                     
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>PEGAWAI PENYELIA</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->pegTadbir->CONm ?> </td> 
                     </tr> 
                     
                     <tr> 
                     <td style="width:30%" height="25px"><strong>TARIKH SEMAKAN</strong></td>
                     <td style="width:70%"  height="25px"><?= ucwords(strtoupper($facility->date_pt))?> </td> 
                     </tr>
                      
                    <tr> 
                     <td style="width:30%"  height="25px"><strong>STATUS SEMAKAN</strong></td>
                     <td style="width:70%"  height="25px"> <?= $facility->status_pt ?></td> 
                     </tr>
                      
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>CATATAN</strong></td>
                     <td style="width:70%"  height="25px"> <?= $facility->catatan_pt ?></td> 
                     </tr>
                          
                      </table>
              </div>
 <div style="margin-bottom:-12px; margin-left:-61px;margin-right:-61px; font-size: 10px;">

                  <table class="table table-sm table-bordered" style=" font-size: 10px; width:100%;">
                     <tr>
                       <td colspan="10" style="text-align:center; background-color:#527e72" color="white" height="25px" ><strong>KELULUSAN PEGAWAI BPG</strong></td>
                       
                     </tr>
                     
                     <tr> 
                     <td style="width:30%"  height="25px"><strong>PEGAWAI BPG</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->pegBsm->CONm ?></td> 
                     </tr>
                      
                      <tr> 
                     <td style="width:30%" height="25px"><strong>TARIKH KELULUSAN</strong></td>
                     <td style="width:70%"  height="25px"><?= ucwords(strtoupper($facility->verdate))?></td> 
                     </tr>
                     
                    <tr> 
                      <td style="width:30%"  height="25px"><strong>STATUS KELULUSAN</strong></td>
                      <td style="width:70%"  height="25px"><?= $facility->status_pp ?></td> 
                     </tr>
                      
                      <tr> 
                     <td style="width:30%"  height="25px"><strong>CATATAN</strong></td>
                     <td style="width:70%"  height="25px"><?= $facility->catatan_pp ?></td> 
                     </tr>
                          
                      </table>
              </div>
