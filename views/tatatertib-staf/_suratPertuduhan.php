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
            <td>Pej Kami</td>
            <td>: UMS(S)/PEND2.1/500-2/15/9 UMS(PER) </td>
        </tr>
        <tr>
            <td>Tarikh</td>
            <td>: <?=  $maklumat->created_at  ?></td>
        </tr>
    </table>
</div>


<div style="margin-bottom: 25px; ">
    <b>   <?= strtoupper($gelarans->Title) ?>&nbsp;<strong><?= $maklumat->kakitangan->CONm?> </strong></b><br>
    <?= ucwords(strtolower($maklumat->dept->fullname))?><br>
Universiti Malaysia Sabah
    <br> 

</div>

<div style="margin-bottom: 25px; ">
    <strong> Melalui dan Salinan </strong>
</div>


<div style="margin-bottom: 25px; ">
    <b>   <?= strtoupper($maklumat->ketuaJabatan->gelaran->Title) ?>&nbsp;<strong><?= $maklumat->ketuaJabatan->CONm?> </strong></b><br>
    <?= ucwords(strtolower($maklumat->ketuaJabatan->department->fullname))?><br>
Universiti Malaysia Sabah
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
                 echo ($gelarans->Title), ',';
             }
                
            ?>
    
</div>

<div style="margin-bottom: 10px">
    <br>  <b><?=  strtoupper($maklumat->maklumatMeeting->bidangKuasa->bidang_kuasa_nm). 'DI BAWAH AKTA BADAN-BADAN BERKANUN (TATATERTIB DAN SURCAJ) 2000 [AKTA 605]' ?><br>
        <br>
</div>

<div style="margin-bottom: 10px; text-align:justify">
    Dengan segala hormatnya perkara di atas adalah dirujuk.
</div><br>

<div style="margin-bottom: 15px; text-align:justify">
    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adalah dimaklumkan bahawa Jawatankuasa Tatatertib Kakitangan Universiti Malaysia Sabah, [<?= $maklumat->maklumatMeeting->bidangKuasa->bidang_kuasa_nm?>,
    kategori <?= $maklumat->kakitangan->jawatan->skimPerkhidmatan->name ?>] (selepas ini dirujuk sebagai 'Jawatankuasa Tatatertib Kakitangan')
    Telah bersidang pada <?= $maklumat->maklumatMeeting->tarikhMesyuarat ?> bagi mendengar dan menimbangkan aduan dan laporan yang telah diterima terhadap
   <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan,';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'puan,';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title), '.';
             }
                
            ?>
</div>

<div style="margin-bottom: 15px; text-align:justify">
    3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Setelah meneliti laporan yang dikemukakan,Jawatankuasa Tatatertib Kakitangan berpendapat
   bahawa    <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan,';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'puan,';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title), '.';
             }
                
            ?>
   telah berkelakuan yang melanggar tatakelakuan yang membolehkan tindakan Tatatertib diambil terhadap   <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'puan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> di atas tuduhan berikut :
      
</div>

<div style="margin-bottom: 15px; text-align:justify">
Pertuduhan
</div>

<div style="margin-bottom: 15px; text-align:justify">
Bahawa <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan,';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'puan,';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title), ',';
             }
                
            ?>
Nama Kakitangan <?= $maklumat->kakitangan->CONm ?> (No. Kad Pengenalan: <?= $maklumat->icno?> ) yang bertugas sebagai 
<?= $maklumat->kakitangan->jawatan->nama ?> (<?= $maklumat->kakitangan->jawatan->gred ?>) di <?= $maklumat->kakitangan->department->fullname ?> ,
Universiti Malaysia Sabah telah didapati melakukan kesalahan <?= $maklumat->jenisKesalahan->kesalahan_nm ?>.
</div>


<div style="margin-bottom: 15px; text-align:justify">
4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Berdasarkan kepada kelakuan <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'puan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> ini, Jawatankuasa Tatatertib Kakitangan
Setelah menimbangkan segala maklumat yang diterima berpendapat bahwa <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'puan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?>
patut dikenakan tindakan tatatertib di bawah Peraturan 3 (e), 3 (g) dan 3 (j), Jadual
Kedua, Akta Badan-Badan Berkanun (Tatatertib dan Surcaj) 2000 [AKTA 605]
(mohon rujuk Lampiran 1).
</div>

        <div class="break"></div>
        
<div style="margin-bottom: 15px; text-align:justify">
5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sekiranya <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'puan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> didapati bersalah atas pertuduhan di atas, <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'puan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> boleh dihukum mengikut 
Peraturan 40, Jadual Kedua, Akta Badan-badan Berkanun ( Tatatertib dan Surcaj) 2000[Akta 605]
(mohon rujuk Lampiran 2).

</div>



<div style="margin-bottom: 15px; text-align:justify">
6.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sekiranya Menurut  Peraturan 34 (1),
Jadual Kedua, Akta Badan-Badan Berkanun (Tatatertib Dan Surcaj)
2000[Akta 605] <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'puan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> dengan ini diberi tempoh dua puluh satu (21) hari dari tarikh <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'puan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> menerima surat pertuduhan ini untuk mengemukakan representasi bertulis yang mengandungi alasan-alasan <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'puan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> untuk membebaskan diri <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'puan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> yang akan dikemukakan untuk pertimbangan Jawatankuasa Tatatertib Kakitangan. Representasi bertulis berkenaan hendaklah dikemukakan kepada Pengerusi
Jawatankuasa Tatatertib Kakitangan [<?= $maklumat->maklumatMeeting->bidangKuasa->bidang_kuasa_nm?>,
    kategori <?= $maklumat->kakitangan->jawatan->skimPerkhidmatan->name ?>] melalui Ketua Jabatan.(mohon rujuk Lampiran 3)

</div>



<div style="margin-bottom: 15px; text-align:justify">
7.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sekiranya <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'puan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> gagal mengemukakan representasi <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'puan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> 
dalam tempoh yang dinyatakan, maka Jawatankuasa Tatatertib Kakitangan menganggap bahawa <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'puan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> mengaku 
dengan pertuduhan diatas dan <?php  if ($gelarans->Title == 'Cik'){
                echo  'puan';
                }
                if ($gelarans->Title == 'Encik'){
                echo  'puan';
                }
             if($gelarans->Title != 'Cik' && $gelarans->Title != 'Encik'){
                 echo strtolower($gelarans->Title);
             }
                
            ?> tiada apa-apa pembelaan mahupun alasan untuk dikemukakan.
Jawatankuasa Tatatertib Kakitangan akan memutuskan perkara ini berdasarkan keterangan-keterangan yang sedia ada sahaja.

</div>
<div style="margin-bottom: 8px">
Sekian, Terima Kasih.
</div><br>
<div style="margin-bottom: 8px">
    Yang ikhlas,<br>
    <br>
    <b><?= strtoupper($maklumat->maklumatMeeting->namaPengerusi->CONm)?></b><br>
   Pengerusi Jawatankuasa Tatatertib Kakitangan<br>
   [<?= $maklumat->maklumatMeeting->bidangKuasa->bidang_kuasa_nm?>,
    kategori <?= $maklumat->kakitangan->jawatan->skimPerkhidmatan->name ?>] <br>


</div>


<div style="">
  <table style="vertical-align:11px; font-size: 11px">
        <tr>
            <td>s.k.</td>
            
        </tr>
          <tr>
      
              <td>    
               -    Pendaftar, UMS<br>
               -    Ketua Bahagian Sumber Manusia , Jabatan Pendaftar, UMS <br>
               -    Fail (UMS-PER <?= $maklumat->kakitangan->COOldID ?>)<br><br><br>
              </td>
          </tr>
        
    </table>
</div>
</div>