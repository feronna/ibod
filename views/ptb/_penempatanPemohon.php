<?php

$word = [
    0 => [
        'letter_status' => 'tidak meluluskan',
    
    ],
    5 => [
        'letter_status' => 'tidak meluluskan',
    
    ],
    4 => [
        'letter_status' => 'meluluskan',
    
    ],

];
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 20px;font-size: 11px">
    <table>
        <tr>
            <td>Rujukan</td>
            <td>: <?= $letter->letter_reference ?></td>
        </tr>
        <tr>
            <td>Tarikh</td>
            <td>: <?=  $letter->created  ?></td>
        </tr>
    </table>
</div>


<div style="margin-bottom: 25px; ">
    <b>   <?= strtoupper($gelarans->Title) ?>&nbsp;<?= $letter->recipient_name ?></b><br>
    <?= ucwords(strtolower($letter->new_position))?><br>
    <?=ucwords(strtolower($letter->recipient_dept)) ?>
    <br> 

</div>

<div>
   <?php  if ($gelarans->Title == 'Cik'){
                echo  'Puan,';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'Tuan,';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo ($gelarans->Title);
             }
                
            ?>
    
</div>

<div style="margin-bottom: 10px">
    <br>  <b>PERTUKARAN TEMPAT BERTUGAS KAKITANGAN PENTADBIRAN<br>


   &nbsp; &nbsp;&nbsp;&nbsp;  <strong> NAMA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;</strong><b><?= strtoupper($gelarans->Title)?>&nbsp;</strong><b><?= $letter->recipient_name?></b><br>
   &nbsp; &nbsp;&nbsp;&nbsp; <strong> JAWATAN&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</strong><b><?= $letter->new_position?></b><strong>&nbsp;GRED <?=$letter->new_gred?></strong>
   
</div>

<div style="margin-bottom: 10px; text-align:justify">
    Dengan segala hormatnya perkara di atas adalah dirujuk.
</div>

<div style="margin-bottom: 15px; text-align:justify">
    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adalah dimaklumkan bahawa Mesyuarat Pihak Berkuasa Pengurusan Universiti (PBPU) Bil. 6/2019 (Siri 2)  
    Kali Ke-<?= $letter->kali_ke ?> yang bersidang pada <?=  $letter->tarikhMesyuarat ?> telah <strong><?= $word[$letter->letter_status]['letter_status']?></strong>  pertukaran tempat bertugas
           <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'tuan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> dari <strong><?= ucwords(strtolower($letter->old_dept)) ?> </strong>ke <strong><?= ucwords(strtolower($letter->approved_dept)) ?></strong>, berkuatkuasa pada
        <strong> <?= $letter->dateIssue ?></strong> (<strong><?= $letter->hariIssue ?></strong>).
</div>

<div style="margin-bottom: 15px; text-align:justify">
    3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sehubungan itu pihak <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'tuan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> adalah dipohon untuk menguruskan semua tugas yang perlu 
    diselesaikan di <?= $oldDept->shortname?> serta membuat Nota Serah Tugas kepada Ketua Jabatan. Selain itu,
     <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'tuan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> adalah dikehendaki untuk melapor diri kepada Ketua Jabatan Baharu di JFPIU baharu.
</div>

<div style="margin-bottom: 15px; text-align:justify">
    Diharapkan semoga <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'tuan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> akan terus memberi sumbangan dan perkhidmatan yang
    cemerlang kepada Universiti.
</div>

<div style="margin-bottom: 8px">
    Saya Yang Menjalankan Amanah,<br>
    <br>
   <b>KAMISAH HUSIN</b><br>
   Ketua<br>
   Bahagian Sumber Manusia<br>
   b.p Pendaftar

</div>

<div style="margin-bottom:11px; font-size: 11px;">
  Pegawai untuk dihubungi:
  <br>No. Telefon: 088-320000 samb. 1444 (En. Ismail Ladama)
  <br>No. Faks: 088-320047
  <br>Alamat e-mel: mail@ums.edu.my	

</div>

<div style="">
  <table style="vertical-align:11px; font-size: 11px">
        <tr>
            <td>s.k.</td>
            
        </tr>
          <tr>
              <td></td>
              <td>    
                      Pendaftar<br>
                     <?= ucwords(strtolower($oldDept->chiefBiodata->jawatan->nama))?><br>
                     <?= ucwords(strtolower($approvedDept->chiefBiodata->jawatan->nama))?>
                     <br>Fail (UMS-PER <?= $applicant->COOldID ?>)<br><br><br>
              </td>
          </tr>
        
    </table>
    <table style="vertical-align:11px; font-size: 8px; font-style: italic"><br><br><br>
     
            </table>
</div>
</div>