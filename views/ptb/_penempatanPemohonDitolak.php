<?php 


$word = [
    0 => [
        'letter_status' => 'tidak meluluskan',
    
    ],
    5 => [
        'letter_status' => 'tidak meluluskan',
    
    ],

];
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 20px;font-size: 11px">
    <table>
  
        <tr>
            <td>Tarikh</td>
            <td>: <?=  $letter->created ?></td>
        </tr>
    </table>
</div>

<div style="margin-bottom: 25px">
    <b>   <?= strtoupper($gelarans->Title) ?>&nbsp;<?= $letter->recipient_name ?></b><br>
    <?= ucwords(strtolower($letter->new_position))?><br>
    <?=ucwords(strtolower($letter->recipient_dept)) ?>
    <br> <?php  if ($letter->kampus_asal == 2){
                echo  'UMS Kampus Antarabangsa Labuan';
                }else{
                    echo 'Universiti Malaysia Sabah';
                }
                
                 ?>

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
    <br>  <b>PERTUKARAN TEMPAT BERTUGAS<br>
    &nbsp; &nbsp;&nbsp;&nbsp;  <strong> NAMA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;</strong><b><?= strtoupper($gelarans->Title)?>&nbsp;<?= $letter->recipient_name?></b><br>
   &nbsp; &nbsp;&nbsp;&nbsp; <strong> JAWATAN&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</strong><b><?= $letter->new_position?></b><strong>&nbsp;GRED <?=$letter->new_gred?></strong>
</div><br>

<div style="margin-bottom: 10px; text-align:justify">
    Dengan segala hormatnya surat permohonan pertukaran tempat bertugas daripada pihak   <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'tuan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> bertarikh <?= $letter->tarikhMohon ?> berhubung
    perkara di atas adalah dirujuk.
</div>

<div style="margin-bottom: 15px; text-align:justify">
    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dukacita dimaklumkan bahawa Mesyuarat Pihak Berkuasa Pengurusan Universiti (PBPU) Bil. 6/2019 (Siri 2)  
    Kali Ke-<?= $letter->kali_ke ?> yang bersidang pada <?=  $letter->tarikhMesyuarat ?> <strong><?= $word[$letter->letter_status]['letter_status']?></strong> permohonan  pertukaran tempat bertugas
          <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'tuan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> ke <?= ucwords(strtolower($letter->new_dept))?>&nbsp; (<?= $newDept->shortname?>), Kampus   <?= ucwords(strtolower($letter->kampus_mohon))?>.
</div>
                          
<div style="margin-bottom: 15px; text-align:justify">
    3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sehubungan itu,  <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'tuan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> adalah kekal bertugas di <?=  ucwords(strtolower($letter->old_dept))?> (<?= $oldDept->shortname?>).
</div>

<div style="margin-bottom: 15px; text-align:justify">
    4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Diharapkan semoga  <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'tuan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> akan terus memberikan komitmen, sumbangan dan perkhidmatan yang
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
                     <?= ucwords(strtolower($newDept->chiefBiodata->jawatan->nama))?><br>
                     Fail (UMS-PER <?= $applicant->COOldID ?>)<br><br><br>
              </td>
          </tr>
        
    </table>
    <table style="vertical-align:11px; font-size: 8px; font-style: italic"><br><br><br>
    
            </table>
</div>
</div>