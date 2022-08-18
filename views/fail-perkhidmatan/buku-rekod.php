<?php
use yii\helpers\Html;

$statusLabel = [
        0 => 'Tidak Berpencen',
        1 => 'Berpencen'
   
];
error_reporting(0);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
     
        <div class="x_title">
            <h2><strong>BUKU REKOD PERKHIDMATAN</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
<div style="margin-bottom: 12px; font-size:15px;">
    <br><b>MAKLUMAT PERIBADI</b>
   &nbsp; &nbsp;&nbsp;&nbsp; 
</div>
             
<div style="margin-bottom: 20px;font-size: 12px;">
    <table width="500px" height="80px">
        <tr>
            <td>Nama Kakitangan</td>
            <td>: <?= ucwords(strtolower($nama->CONm))?></td>
        </tr>
         <tr>
            <td>No. Kad Pengenalan / Paspot</td>
            <td>: <?= $nama->ICNO?></td>
        </tr>
        <tr>
            <td>Rujukan No Fail</td>
            <td>: <?=  $nama->COOldID ?></td>
        </tr>
         <tr>
            <td>Jantina</td>
            <td>: <?=  $nama->jantina->Gender ?></td>
        </tr>
         <tr>
            <td>Taraf Perkahwinan</td>
            <td>: <?=  $nama->tarafPerkahwinan->MrtlStatus ?></td>
        </tr>
         <tr>
            <td>Tarikh Lahir</td>
            <td>: <?=  $nama->tarikhLahir?></td>
        </tr>
         <tr>
            <td>Tempat Lahir</td>
            <td>: <?=  $nama->tempatLahir->State ?></td>
        </tr>
         <tr>
            <td>Negara Lahir</td>
            <td>: <?=  $nama->negaraLahir->Country ?></td>
        </tr>
           <tr>
            <td>Agama</td>
            <td>: <?= $nama->agama->Religion?></td>
        </tr>
           <tr>
            <td>Bangsa</td>
            <td>: <?= $nama->bangsa->Race?></td>
        </tr>
        
    </table>
</div>

<div style="margin-bottom: 12px; font-size:15px;">
    <br><b>MAKLUMAT JAWATAN SEKARANG</b>
   &nbsp; &nbsp;&nbsp;&nbsp; 
</div>
<div style="margin-bottom: 20px;font-size: 12px">
    <table width="500px" height="80px">
        <tr>
            <td>Jawatan Sekarang</td>
            <td>: <?= $nama->jawatan->nama . " (" . $nama->jawatan->gred . ")";?></td>
        </tr>
        
         <tr>
            <td>Tarikh Dilantik</td>
    
                 <td>
                        <?php  if ($nama->tarikhDilantik->tarikhMula != null){
                     echo ": \n"; echo  $nama->tarikhDilantik->tarikhMula;  
                  }else{
                      echo ': Tiada Rekod';
                 }
                ?>
                            </td>
        </tr>
   
         <tr>
            <td>Tarikh Disahkan Dalam Jawatan</td>
           
             <td>
                        <?php  if ($nama->sahJawatan->tarikhMula != null){
                   echo ": \n"; echo  $nama->sahJawatan->tarikhMula;  
                  }else{
                      echo ': Tiada Rekod';
                 }
                ?>
                            </td>
        </tr>
         <tr>
            <td>Jabatan Sekarang</td>
            <td>: <?=  $nama->department->fullname?></td>
        </tr>
        
    </table>
</div>
                
                <div style="margin-bottom: 12px; font-size:15px;">
    <br><b>KENYATAAN PERKHIDMATAN</b>
   &nbsp; &nbsp;&nbsp;&nbsp; 
</div>
                <div style="margin-bottom: 20px;font-size: 12px;">
    <table width="500px" height="80px">
       
         <tr>
            <td>Tarikh Layak Dimasukkan Ke Dalam Perjawatan Berpencen</td>
            <td>: <?=  $pencen->tarikhMula ?></td>
        </tr>
         <tr>
            <td>Tarikh Dimasukkan Ke Dalam Perjawatan Berpencen</td>
            <td>: <?= $pencen->tarikhMula ?></td>
        </tr>
         <tr>
            <td>Tarikh Sampai Umur Dihadkan</td>
            <td>: <?=  $bersara->tarikhKuatkuasa?></td>
        </tr>
         
    </table>
</div>
                
 <div style="margin-bottom: 12px; font-size:15px;">
    <br><b>BUTIR-BUTIR JAWATAN SEBELUM LANTIKAN KE UMS</b>
   &nbsp; &nbsp;&nbsp;&nbsp; 
</div> 
                
                <table class="table table-sm table-bordered">
                <tr>
                 
                    <th class="text-center">Jawatan</th>
                    <th class="text-center">Tarikh Dilantik</th>
                    <th class="text-center">Nama Majikan</th>
                </tr>
                  <?php if($pengalaman) {
                          foreach ($pengalaman as $key=>$pengalamans) { ?>
                          <tr>
                           
                        
                        
                          <td><?= $pengalamans->PrevEmpRemarks?></td>
                          <td><?= $pengalamans->tarikhDilantik?></td>
                          <td><?= $pengalamans->OrgNm?></td>
                          </tr>
               
                  <?php } }
      else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
</table>
   
   <div style="margin-bottom: 12px; font-size:15px;">
    <br><b>KELAYAKAN AKADEMIK</b>
   &nbsp; &nbsp;&nbsp;&nbsp; 
</div> 
                
                <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Institut</th>
                    <th class="text-center">Tahap Pendidikan</th>
                    <th class="text-center">Major</th>
                    <th class="text-center">Nama Sijil</th>
                </tr>
                <?php if($sijil) {
                        foreach ($sijil as $key=>$sijils) { ?>
                          <tr>
                           
                        
                        
                          <td><?= $sijils->institut->InstNm?></td>
                          <td><?= $sijils->pendidikanTertinggi->HighestEduLevel?></td>
                          <td><?= $sijils->major->MajorMinor?></td>
                          <td><?= $sijils->EduCertTitle?></td>
                          </tr>
    <?php } }
      else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
  
</table>              
                
                
<div style="margin-bottom: 15px; font-size:15px">
    <br><strong>WARIS DEKAT</strong>
   &nbsp; &nbsp;&nbsp;&nbsp; 
</div>
                
                  <table class="table table-sm table-bordered">
                <tr>
              
                    <th class="text-center">Nama</th>
                    <th class="text-center">Persaudaraan</th>
                    <th class="text-center">Alamat</th>
                </tr>
                      <?php if($waris) {
                          foreach ($waris as $wariss) { ?>
                          <tr>
                           
                        
                        
                          <td><?= $wariss->FmyNm?></td>
                          <td><?= $wariss->hubunganKeluarga->RelNm?></td>
                          <td><?= $wariss->FmyAddr1. $wariss->FmyAddr2?></td>
                          </tr>
                          
                               <?php } }
      else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
</table>

<div style="margin-bottom: 15px; font-size:15px">
    <br><strong>BUTIR-BUTIR PERKHIDMATAN</strong>
   &nbsp; &nbsp;&nbsp;&nbsp; 
</div>
                
                            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Kebenaran</th>
                    <th class="text-center">Butir-butir perubahan atau lain-lain hal mengenai Kakitangan
(Lihat Panduan 5</th>
                    <th class="text-center">Nama Jawatan, Peringkat dan/atau Kelas 
(Lihat Panduan 5)</th>
               
                    <th class="text-center">Tarikh Mulai Daripada</th>
                    <th class="text-center">Berpencen Tak Berpencen, Peruntukan Terbuka</th>
                      <th class="text-center">Gaji Sebulan
                   
                      
                      </th>
               
                </tr>

 
                  <?php $bil=1; foreach ($maklumat as $maklumats) { ?>
                          <tr>
                           
                          <td>
                        <?php  if ($maklumats->rujukan_surat != null){
                   echo  $maklumats->rujukan_surat; echo "\n"; echo 'bth:';
                      echo date("d.m.Y",  strtotime($maklumats->tarikh_surat));
                  }else{
                      echo 'UMS(PER)';echo $maklumats->biodata->COOldID;echo "\n";echo 'bth:';
                      echo date("d.m.Y",  strtotime($maklumats->tarikh_surat));echo "\n";
                      echo $maklumats->t_lpg_id;
                 }
                ?>
                            
                            
                            </td>

                          <td><?= $maklumats->remark?></td>
                          <td><?= $maklumats->jawatan->nama . " (" . $maklumats->jawatan->gred . ")";?></td>
                          <td><?= $maklumats->tarikhMulai?></td>
                          <td><?= $statusLabel[$maklumats->isPencen]?></td>
                          <td><?= $maklumats->gaji_sebulan?></td>
                      
                          <?php foreach ($gaji as $gajis) { ?>
                          
                          
                              
                          Gaji Pokok :
                          <?= $gajis->MPDH_PAID_AMT?>
                           Gaji Pokok :
                          <?= $gajis->MPDH_PAID_AMT?>
                          
                          
                          
                          <?php  }?>
                          
                 <?php }
    
            
    
    ?>
</table>
              
            
        </div>
    </div>
</div>
