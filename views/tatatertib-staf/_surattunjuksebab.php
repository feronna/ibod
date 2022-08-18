<?php

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 18px;">
    <table>
        <tr>
            <td style="font-size: 12px"><b>Rujukan Kami</b></td>
            <td></td> <td></td>
            <td>:</td>
            <td style="font-size: 12px"><b>UMS(S)/PPUU1.6/500-2/15/9 Jld. </b></td>
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
    <br>  <b>TINDAKAN TATATERTIB BUKAN DENGAN TUJUAN BUANG KERJA ATAU TURUN PANGKAT DI BAWAH AKTA BADAN-BADAN BERKANUN (TATATERTIB & SURCAJ ) 2000 [AKTA 605]
    
     <br>

</div>
<br>
<div style="margin-bottom: 7px; font-size:13px; text-align:justify">
    Dengan segala hormatnya perkara di atas adalah dirujuk.
</div>



<div style="margin-bottom: 7px; font-size:13px; text-align:justify">
 2.   Dimaklumkan bahawa Jawatankuasa Tatatertib Kakitangan University Malaysia Sabah,[Bukan Dengan Tujuan Buang Kerja atau Turun Pangkat, Kategori Pengurusan dan Profesional](selepas ini dirujuk sebagai ‘Jawatankuasa Tatatertib Kakitangan’) telah bersidang pada 8 Julai 2014 bagi mendengar dan menimbangkan aduan dan laporan yang telah diterima terhadap tuan.
      
</div>

<br>
<div style="margin-bottom: 7px;font-size:13px; text-align:justify">
  3.	Setelah meneliti laporan yang dikemukakan, Jawatankuasa Tatatertib Kakitangan berpendapat bahawa tuan telah berkelakuan melanggar tatakelakuan yang membolehkan tindakan tatatertib diambil terhadap tuan di atas pertuduhan tersebut.
</div>

<div style="margin-bottom: 7px; font-size:13px; text-align:justify">
   Pertuduhan:
</div>


<br>
<div style="margin-bottom: 7px;font-size:13px; text-align:justify">
  Bahawa tuan, Nama Kakitangan ( No. Kad Pengenalan : *****) yang bertugas sebagai Jawatan Kakitangan di JFPIU, University Malaysia Sabah telah didapati melakukan penjelasan pertuduhan.dapatan persendirian yang sah sebagaimana yang dinyatakan di dalam Peraturan 10, Jadual Kedua, Akta 605.
</div>

<br>
<div style="margin-bottom: 7px; font-size:13px; text-align:justify">
  4.	Berdasarkan kepada kelakuan tuan ini, Jawatanjuasa Tatatertib Kakitangan setelah menimbangkan segala maklumat yang diterima berpendapat bahawa tuan patut dikenakan tindakan tatatertib di bawah Peraturan 3 ( e ) , 3 ( g ) dan 3 ( j ) , Jadual Kedua, Akta Badan-Badan Berkanun (Tatatertib dan Surcaj) 2000 [Akta 605] (mohon Lamiran 1 ).
</div>

<br>
<div style="margin-bottom: 7px; font-size:13px; text-align:justify">
 5.	Sekiranya tuan didapati bersalah atas pertuduhan di atas, tuan boleh dihukum mengikut Peraturan 40 , Jadual Kedua , Akta Badan-Badan Berkanun (Tatatertib dan Surcaj) 2000 [mohon rujuk lampiran 2]
</div>

<br>

<div style="margin-bottom: 7px; font-size:13px; text-align:justify">
  6.	Menurut Peraturan 34 (1), Jadual Kedua, Akta Badan-Badan Berkanun (Tatatertib dan Surcaj) 2000 [Akta 605]  tuandengan ini diberi tempoh dua puluh satu (21) hari dari tarikh tuan menerima surat pertuduhan ini untuk mengemukakan representasi bertulis yang menganungi alasan-alasan tuan untuk membebaskan diri tuan yang akan dikemukakan untuk pertimbangan Jawatankuasa Tatatertib Kakitangan. Representasi bertulis berkenaan hendaklah dikemukakan kepada Pengerusi Jawatankuasa Tatatertib kakitangan [Bukan Dengan Tujuan buang Kerja atau Turun Pangkat, Kategori Pengurusan dan Profesional] melalui Ketua Jabatan. (mohon semak lamipiran 3 ) .
</div>


<br>
<div style="margin-bottom: 7px; font-size:13px; text-align:justify">
 7.	Sekiranya tuan gagal mengemukakan representasi tuan dalam tempoh yang dinyatakan, maka Jawatankuasa Tatatertib Kakitanga menganggap bahawa tuan mengaku dengan pertuduhan di atas dan tuan tiada apa-apa pembelaan mahupun alasan untuk dikemukakan. Jawatankuasa Tatatertib Kakitangan akan memutuskan perkara ini berdasarkan keterangan-ketereangan yang sedia ada sahaja.
</div>


<br>
<div style="margin-bottom: 7px; font-size:13px; text-align:justify">
   Sekian, terima kasih.
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