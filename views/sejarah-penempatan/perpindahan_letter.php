<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 15px;font-size: 11px">
    <table>
        <tr>
            <td>Rujukan</td>
            <td>: <?= $permohonan->letter_order_refno ?></td>
        </tr>
        <tr>
            <td>Tarikh</td>
            <td>: <?=  $permohonan->TarikhSurat  ?></td>
        </tr>
    </table>
</div>


<div style="margin-bottom: 15px; ">
    <b>   <?= strtoupper($biodata->gelaran->Title) ?>&nbsp;<?= $biodata->CONm ?></b><br>
    <?= ucwords(strtolower($biodata->jawatan->nama))?><br>
    <?=ucwords(strtolower($permohonan->department->fullname)) ?>
    <br> 

</div>

<!--<div>
   <php  if ($gelarans->Title == 'Cik'){
                echo  'Puan,';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'Tuan,';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo ($gelarans->Title);
             }
                
            ?>
    
</div>-->

<div>
   <?php  if ($biodata->TitleCd == 'P019'){
                echo  'Puan,';
                }
                if ($biodata->TitleCd== 'L001'){
                echo  'Tuan,';
                }
             if($biodata->TitleCd!= 'P019' && $biodata->TitleCd != 'L001'){
                 echo ($biodata->gelaran->Title);
             }         
            ?>
</div>

<div style="margin-bottom: 10px">
    <br>  <b>PERTUKARAN TEMPAT BERTUGAS KAKITANGAN PENTADBIRAN<br>


   &nbsp; &nbsp;&nbsp;&nbsp;   NAMA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;<?= strtoupper($biodata->gelaran->Title)?>&nbsp;<?= $permohonan->kakitangan->CONm?><br>
   &nbsp; &nbsp;&nbsp;&nbsp;  JAWATAN&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?= strtoupper($biodata->jawatan->nama) ?>&nbsp;GRED <?=$biodata->jawatan->gred?>
   
</div>

<div style="margin-bottom: 10px; text-align:justify">
    Dengan segala hormatnya saya merujuk perkara di atas.
</div>

<div style="margin-bottom: 15px; text-align:justify">
    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adalah dimaklumkan bahawa melalui Mesyuarat Pihak Berkuasa Pengurusan Universiti (PBPU) Bil. <?= ucwords(strtolower($permohonan->bil_mesyuarat)) ?>/<?= ucwords(strtolower($permohonan->tahun_mesyuarat)) ?> (Kali Ke-<?= ucwords(strtolower($permohonan->mesyuarat_kali_ke)) ?>) telah mengarahkan pertukaran tempat bertugas  
<!--    Kali Ke-<= $biodata->kali_ke ?> yang bersidang pada <=  $biodata->tarikhMesyuarat ?> telah <strong><= $word[$biodata->letter_status]['letter_status']?></strong>  pertukaran tempat bertugas-->
           <?php  if ($biodata->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($biodata->TitleCd== 'L001'){
                echo  'tuan';
                }
             if($biodata->TitleCd!= 'P019' && $biodata->TitleCd != 'L001'){
                 echo ($biodata->gelaran->Title);
             }
                
             ?> dari <strong><?= ucwords(strtolower($permohonan->oldDepartment->fullname)) ?> (<?= ucwords($permohonan->oldDepartment->shortname) ?>) </strong>ke <strong><?= ucwords(strtolower($permohonan->department->fullname)) ?> (<?= ucwords($permohonan->department->shortname) ?>)</strong>, berkuatkuasa pada
        <strong> <?= $permohonan->tarikhMula ?></strong> (<strong><?= $permohonan->hariMula ?></strong>).
</div>

<div style="margin-bottom: 15px; text-align:justify">
    4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kakitangan perlu mematuhi arahan penempatan ini berdasarkan Peraturan 3(2)(i),
    Jadual Kedua, Akta Badan-Badan Berkanun (Tatatertib dan Surcaj) 2000 [Akta 605] yang
    menyatakan “Seseorang pegawai tidak boleh ingkar perintah atau berkelakuan dengan apaapa
    cara yang boleh ditafsirkan dengan munasabah sebagai ingkar perintah”.
</div>

<div style="margin-bottom: 15px; text-align:justify">
    4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sehubungan itu, pihak <?php  if ($biodata->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($biodata->TitleCd== 'L001'){
                echo  'tuan';
                }
             if($biodata->TitleCd!= 'P019' && $biodata->TitleCd != 'L001'){
                 echo ($biodata->gelaran->Title);
             }
                
            ?> dipohon untuk menguruskan semua tugas yang perlu 
    diselesaikan di <?= $permohonan->oldDepartment->fullname?> serta membuat Nota Serah Tugas kepada Ketua Jabatan. Dilampirkan bersama ini
    Borang Pengesahan Lapor Diri di JFPIU Baru untuk tindakan pihak
     <?php  if ($biodata->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($biodata->TitleCd== 'L001'){
                echo  'tuan';
                }
             if($biodata->TitleCd!= 'P019' && $biodata->TitleCd != 'L001'){
                 echo ($biodata->gelaran->Title);
             }
                
            ?> selanjutnya.
</div>

<div style="margin-bottom: 15px; text-align:justify">
    Diharapkan semoga <?php  if ($biodata->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($biodata->TitleCd== 'L001'){
                echo  'tuan';
                }
             if($biodata->TitleCd!= 'P019' && $biodata->TitleCd != 'L001'){
                 echo ($biodata->gelaran->Title);
             }
                
            ?> akan terus memberikan komitmen, sumbangan dan perkhidmatan yang
            cemerlang kepada Universiti. 
</div>

<div style="margin-bottom: 15px; text-align:justify">
   Sekian, terima kasih.
</div>
<br>
<div style="margin-bottom: 8px">
    Saya Yang Menjalankan Amanah,<br>
    <br><br>
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
<!--                <td>    
                      Pendaftar<br>
                     <= ucwords(strtolower($oldDept->chiefBiodata->jawatan->nama))?><br>
                     <= ucwords(strtolower($approvedDept->chiefBiodata->jawatan->nama))?>
                     <br>Fail (UMS-PER <= $applicant->COOldID ?>)<br><br><br>
                </td>-->
               <td>    
                      Pendaftar<br>
<!--                     <= ucwords(strtolower($oldDept->chiefBiodata->jawatan->nama))?><br>-->
                     <?= ucwords(strtolower($approvedDept->adminpos->adminpos->position_name))?> <?= ucwords(strtolower($permohonan->department->fullname)) ?>
                     <br>Fail (UMS-PER <?= $biodata->COOldID ?>)<br><br><br>
              </td>
          </tr>
        
    </table>
    <table style="vertical-align:11px; font-size: 8px; font-style: italic"><br><br><br>
     
            </table>
</div>
</div>