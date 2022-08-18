<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 20px;font-size: 11px">
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


<div style="margin-bottom: 25px; ">
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
    <br><b>PENEMPATAN BERTUGAS SEBAGAI <?= strtoupper($biodata->jawatan->nama) ?><br>


   &nbsp; &nbsp;&nbsp;&nbsp;   NAMA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;<?= strtoupper($biodata->gelaran->Title)?>&nbsp;<?= $permohonan->kakitangan->CONm?><br>
   &nbsp; &nbsp;&nbsp;&nbsp;  JAWATAN&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?= strtoupper($biodata->jawatan->nama) ?>&nbsp;GRED <?=$biodata->jawatan->gred?>
    </b>  
</div>

<div style="margin-bottom: 10px; text-align:justify">
    Dengan segala hormatnya saya merujuk perkara di atas.
</div>

<div style="margin-bottom: 15px; text-align:justify">
    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Selaras dengan pelantikan tersebut, 
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
                
             ?> akan ditempatkan bertugas di <strong><?= ucwords(strtolower($permohonan->department->fullname)) ?> (<?= ucwords($permohonan->department->shortname) ?>)</strong>, kampus cawangan <strong><?= ucwords(strtolower($permohonan->campus->campus_name)) ?></strong> berkuatkuasa pada
        <strong> <?= $permohonan->tarikhMula ?></strong>.
</div>

<div style="margin-bottom: 15px; text-align:justify">
    3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sehubungan itu, pihak Pendaftar mengucapkan tahniah di atas pelantikan ini dan berharap
        <?php  if ($biodata->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($biodata->TitleCd== 'L001'){
                echo  'tuan';
                }
             if($biodata->TitleCd!= 'P019' && $biodata->TitleCd != 'L001'){
                 echo ($biodata->gelaran->Title);
             }
                
            ?> akan memberikan komitmen yang cemerlang dalam perkhidmatan 
        <?php  if ($biodata->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($biodata->TitleCd== 'L001'){
                echo  'tuan';
                }
             if($biodata->TitleCd!= 'P019' && $biodata->TitleCd != 'L001'){
                 echo ($biodata->gelaran->Title);
             }
                
            ?>.
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
    <br><br>
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