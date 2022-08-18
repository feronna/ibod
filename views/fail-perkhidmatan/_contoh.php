<?php

$statusLabel = [
        0 => 'Tidak Berpencen',
        1 => 'Berpencen'
   
];
error_reporting(0);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 12px">
    <br><b>MAKLUMAT PERIBADI</b>
   &nbsp; &nbsp;&nbsp;&nbsp; 
</div>

<div style="margin-bottom: 20px;font-size: 8px;">
    <table width="800px">
        <tr>
            <td>Nama Kakitangan</td>
            <td>: <?= ucwords(strtolower($nama->CONm))?></td>
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
        
    </table>
</div>

<div style="margin-bottom: 12px">
    <br><b>MAKLUMAT JAWATAN SEKARANG</b>
   &nbsp; &nbsp;&nbsp;&nbsp; 
</div>
<div style="margin-bottom: 20px;font-size: 8px">
    <table width="900px">
        <tr>
            <td>Jawatan Sekarang</td>
            <td>: <?= $nama->jawatan->nama . " (" . $nama->jawatan->gred . ")";?></td>
        </tr>
        <tr>
            <td>Tarikh Dilantik</td>
    
                 <td>
                        <?php  if ($nama->tarikhDilantik->tarikhMula != null){
                   echo  $nama->tarikhDilantik->tarikhMula;  
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
                   echo  $nama->sahJawatan->tarikhMula;  
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

<div style="margin-bottom: 15px">
    <br><b>BUTIR-BUTIR PERKHIDMATAN</b>
   &nbsp; &nbsp;&nbsp;&nbsp; 
</div>

<table size="5px" class="table table-sm table-bordered table-striped">
    <tr>
         <th width="5px" class="text-center">Kebenaran</th>
         <th class="text-center">Butir-butir perubahan atau lain-lain hal mengenai Kakitangan
(Lihat Panduan 5)</th>
         <th class="text-center">Nama Jawatan, Peringkat dan/atau Kelas 
(Lihat Panduan 5)</th>
           <th class="text-center">Tarikh Mulai Daripada</th>
      <th class="text-center">Berpencen Tak Berpencen, Peruntukan Terbuka</th>
    </tr>
 
                  <?php $bil=1; foreach ($maklumat as $maklumats) { ?>
                          <tr>
                           
                          <td>
                        <?php  if ($maklumats->rujukan_surat != null){
                   echo  $maklumats->rujukan_surat;  echo 'bth:';
                      echo date("d.m.Y",  strtotime($maklumats->tarikh_surat));
                  }else{
                      echo 'UMS(PER)';echo $maklumats->biodata->COOldID; "\n"; echo 'bth:';
                      echo date("d.m.Y",  strtotime($maklumats->tarikh_surat));
                      echo $maklumats->t_lpg_id;
                 }
                ?>
                            
                            
                            </td>
                          <td><?= $maklumats->remark?></td>
                          <td><?= $maklumats->jawatan->nama . " (" . $maklumats->jawatan->gred . ")";?></td>
                          <td><?= $maklumats->tarikhMulai?></td>
                          <td><?= $statusLabel[$maklumats->isPencen]?></td>
                          </tr>
               
    <?php } ?>
</table>