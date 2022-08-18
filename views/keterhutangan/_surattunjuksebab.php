<?php

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 18px;">
    <table>
        <tr>
            <td style="font-size: 12px"><b>Rujukan Kami</b></td>
            <td></td> <td></td>
            <td>:</td>
            <td style="font-size: 12px"><b>UMS(S)/PEN2.1/500-2/15/1 Jld. </b></td>
        </tr>
        <tr>
            <td style="font-size: 12px"><b>Tarikh</b></td>
             <td></td> <td></td>
            <td>:</td>
            <td><?= $biodata->tarikhNoti?></td>
        </tr>
    </table>
</div>


<div style="margin-bottom: 25px;font-size: 13px ">
    <b><?= strtoupper($biodata->kakitangan->gelaran->Title) ?>&nbsp;<?= ucwords(strtoupper($biodata->kakitangan->CONm)) ?> </b><br>
    <b> <?= ucwords(strtoupper($biodata->kakitangan->department->fullname))?></b><br>
    UNIVERSITI MALAYSIA SABAH
    <br>
 

</div>

<div>
<?php  if ($biodata->kakitangan->gelaran->TitleCd == 'P019'){
                echo  'Puan,';
                }
                if ($biodata->kakitangan->gelaran->TitleCd == 'L001'){
                echo  'Tuan,';
                }
                
             if($biodata->kakitangan->gelaran->TitleCd != 'P019' && $biodata->kakitangan->gelaran->TitleCd != 'L001'){
                 echo ($biodata->kakitangan->gelaran->Title); echo ',';
             }
                
            ?>
    
</div>

<div style="margin-bottom: 7px; font-size:13px;  text-align:justify">
    <br>  <b>PERMOHONAN PENJELASAN BAGI PERINCIAN POTONGAN EMOLUMEN MELEBIHI 60% DARIPADA EMOLUMEN BULANAN BERDASARKAN PENYATA GAJI 
     BULAN <?php if($biodata->sesi == 1){
                 echo 'JANUARI SEHINGGA JUN';
             }else{
                  echo 'JULAI SEHINGGA DISEMBER';
             }
             ?>  
          TAHUN <?= $biodata->tahun?>
     <br>

</div>
<br>
<div style="margin-bottom: 7px; font-size:13px; text-align:justify">
    Dengan segala hormatnya perkara di atas adalah dirujuk.
</div>



<div style="margin-bottom: 7px; font-size:13px; text-align:justify">
    Dimaklumkan bahawa berdasarkan penelitian yang dibuat kepada slip gaji <?php  if ($biodata->kakitangan->gelaran->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($biodata->kakitangan->gelaran->TitleCd == 'L001'){
                echo  'tuan';
                }
                
             if($biodata->kakitangan->gelaran->TitleCd != 'P019' && $biodata->kakitangan->gelaran->TitleCd != 'L001'){
                 echo ($biodata->kakitangan->gelaran->Title);
             }
                
            ?> pada Bulan
       <?php if($biodata->sesi == 1){
                 echo 'Januari sehingga Jun';
             }else{
                  echo 'Julai sehingga Disember';
             }
             ?>  
          Tahun <?= $biodata->tahun?> adalah didapati bahawa potongan gaji yang dibuat oleh <?php  if ($biodata->kakitangan->gelaran->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($biodata->kakitangan->gelaran->TitleCd == 'L001'){
                echo  'tuan';
                }
                
             if($biodata->kakitangan->gelaran->TitleCd != 'P019' && $biodata->kakitangan->gelaran->TitleCd != 'L001'){
                 echo ($biodata->kakitangan->gelaran->Title);
             }
                
            ?> adalah melebihi 60% daripada
    emolumen bulanan <?php  if ($biodata->kakitangan->gelaran->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($biodata->kakitangan->gelaran->TitleCd == 'L001'){
                echo  'tuan';
                }
                
             if($biodata->kakitangan->gelaran->TitleCd != 'P019' && $biodata->kakitangan->gelaran->TitleCd != 'L001'){
                 echo ($biodata->kakitangan->gelaran->Title);
             }
                
            ?>.
</div>

<br>
<div style="margin-bottom: 7px;font-size:13px; text-align:justify">
   Sehubungan itu, <?php  if ($biodata->kakitangan->gelaran->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($biodata->kakitangan->gelaran->TitleCd == 'L001'){
                echo  'tuan';
                }
                
             if($biodata->kakitangan->gelaran->TitleCd != 'P019' && $biodata->kakitangan->gelaran->TitleCd != 'L001'){
                 echo ($biodata->kakitangan->gelaran->Title);
             }
                
            ?> dikehendaki untuk mengemukakan penjelasan bagi setiap perincian potongan emolumen
    <?php  if ($biodata->kakitangan->gelaran->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($biodata->kakitangan->gelaran->TitleCd == 'L001'){
                echo  'tuan';
                }
                
             if($biodata->kakitangan->gelaran->TitleCd != 'P019' && $biodata->kakitangan->gelaran->TitleCd != 'L001'){
                 echo ($biodata->kakitangan->gelaran->Title);
             }
                
            ?> dan bagaimana <?php  if ($biodata->kakitangan->gelaran->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($biodata->kakitangan->gelaran->TitleCd == 'L001'){
                echo  'tuan';
                }
                
             if($biodata->kakitangan->gelaran->TitleCd != 'P019' && $biodata->kakitangan->gelaran->TitleCd != 'L001'){
                 echo ($biodata->kakitangan->gelaran->Title);
             }
                
            ?> menyenggara kehidupan dengan baki gaji yang diterima yang disokong oleh ketua jabatan dalam tempoh (30) hari dari tarikh penerimaan
    surat ini. Penjelasan berkenaan hendaklah disalinkan ke Bahagian Perundangan dan Integriti, Jabatan Pendaftar.
</div>

<br>
<div style="margin-bottom: 7px;font-size:13px; text-align:justify">
  Kegagalan <?php  if ($biodata->kakitangan->gelaran->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($biodata->kakitangan->gelaran->TitleCd == 'L001'){
                echo  'tuan';
                }
                
             if($biodata->kakitangan->gelaran->TitleCd != 'P019' && $biodata->kakitangan->gelaran->TitleCd != 'L001'){
                 echo ($biodata->kakitangan->gelaran->Title);
             }
                
            ?> berbuat demikian atau mengemukakan alasan tidak munasabah membolehkan <?php  if ($biodata->kakitangan->gelaran->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($biodata->kakitangan->gelaran->TitleCd == 'L001'){
                echo  'tuan';
                }
                
             if($biodata->kakitangan->gelaran->TitleCd != 'P019' && $biodata->kakitangan->gelaran->TitleCd != 'L001'){
                 echo ($biodata->kakitangan->gelaran->Title);
             }
                
            ?> dianggap sebagai
  tidak bertanggungjawab dan ingkar perintah atau berkelakuan dengan apa-apa cara yang boleh ditafsirkan dengan munasabah sebagai ingkar perintah
  iaitu melanggar Peraturan 3 (2) (g) dan (i), Jadual Kedua, Akta Badan-Badan Berkanun (Tatatertib dan Surcaj) 2000 [Akta 605] 
  (selepas ini dirujuk sebagai "Akta 605") yang boleh dikenakan tindakan tatatertib dan <?php  if ($biodata->kakitangan->gelaran->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($biodata->kakitangan->gelaran->TitleCd == 'L001'){
                echo  'tuan';
                }
                
             if($biodata->kakitangan->gelaran->TitleCd != 'P019' && $biodata->kakitangan->gelaran->TitleCd != 'L001'){
                 echo ($biodata->kakitangan->gelaran->Title);
             }
                
            ?> juga dianggap sebagai berada dalam 
  keterhutangan kewangan yang serius sebagaimana yang dinyatakan di dalam Peraturan 12, Jadual Kedua, Akta 605 dan menyenggara taraf kehidupan 
  yang melebihi emolumen dan pendapatan persendirian yang sah sebagaimana yang dinyatakan di dalam Peraturan 10, Jadual Kedua, Akta 605.
</div>

<br>
<div style="margin-bottom: 7px; font-size:13px; text-align:justify">
    <?php  if ($biodata->kakitangan->gelaran->TitleCd == 'P019'){
                echo  'Puan';
                }
                if ($biodata->kakitangan->gelaran->TitleCd == 'L001'){
                echo  'Tuan';
                }
                
             if($biodata->kakitangan->gelaran->TitleCd != 'P019' && $biodata->kakitangan->gelaran->TitleCd != 'L001'){
                 echo ($biodata->kakitangan->gelaran->Title);
             }
                
            ?> adalah dimohon untuk mengambil tindakan yang sewajarnya dengan segera bagi memastikan
    potongan gaji yang dibuat tidak melebihi 60% daripada emolumen bulanan <?php  if ($biodata->kakitangan->gelaran->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($biodata->kakitangan->gelaran->TitleCd == 'L001'){
                echo  'tuan';
                }
                
             if($biodata->kakitangan->gelaran->TitleCd != 'P019' && $biodata->kakitangan->gelaran->TitleCd != 'L001'){
                 echo ($biodata->kakitangan->gelaran->Title);
             }
                
            ?>. Perhatian dan kerjasama <?php  if ($biodata->kakitangan->gelaran->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($biodata->kakitangan->gelaran->TitleCd == 'L001'){
                echo  'tuan';
                }
                
             if($biodata->kakitangan->gelaran->TitleCd != 'P019' && $biodata->kakitangan->gelaran->TitleCd != 'L001'){
                 echo ($biodata->kakitangan->gelaran->Title);
             }
                
            ?> dalam perkara ini adalah dihargai dan didahului 
    dengan ucapan terima kasih.
</div>

<br>

<div style="margin-bottom: 7px; font-size:13px;">
    Yang ikhlas,<div style="margin-bottom: 7px; margin-top:7px; font-size:11px; color:red">-----"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"-----</div>
     
   <b>PROF. DATUK DR. TAUFIQ YAP YUN HIN</b><br>
   Naib Canselor<br>
   Universiti Malaysia Sabah<br>

</div>

<div style="">
  <table style="vertical-align:11px; font-size: 11px">
        <tr>
            <td>s.k.</td>
            
        </tr>
          <tr>
              <td></td>
              <td>  
                      - Pendaftar<br>
                      - Ketua Jabatan
                    <br><br>
              </td>
          </tr>
        
    </table>
  
</div>
</div>