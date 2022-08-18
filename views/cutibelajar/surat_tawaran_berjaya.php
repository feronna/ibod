<?php


?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 25px; font-size: 10px;">
  <table>
        <tr>
            <td><font size="2"><b>Rujukan</b></font></td>
            <td><font size="2"><b>: UMS/PEND2.2/500-5/7/2 (<?= $letter->COOldID ?>)</b></font></td>
        </tr>
       <tr>
           <td><font size="2"><b>Tarikh</b></font></td>
           <td><font size="2"><b>: <?=  $model->created  ?></b></font></td> <!-- tarikh diluluskan KJ atau mesyuarat? -->
        </tr>
    </table>
</div>

<div style="margin-bottom: 25px;  font-size: 12px; ">
    <b>   <?= strtoupper($letter->gelaran->Title) ?>&nbsp;<?= $letter->CONm ?></b><br>
    <?= ucwords(strtolower($letter->jawatan->nama))?>&nbsp;(<?= $letter->jawatan->gred?>)<br>
    <?=ucwords(strtolower($letter->department->fullname)) ?>
   
</div>

<div style="font-size: 12px;">
   <?php  if ($letter->TitleCd == 'P019'){
                echo  'Puan,';
                }
                if ($letter->TitleCd== 'L001'){
                echo  'Tuan,';
                }
             if($letter->TitleCd!= 'P019' && $letter->TitleCd != 'L001'){
                 echo ($letter->gelaran->Title).',';
             }
                
            ?>
    
</div>

<div style="margin-bottom: 10px; font-size: 14px;">
     <b>MAKLUMAN KEPUTUSAN PERMOHONAN CUTI BELAJAR SEPENUH MASA
</div>

<!--<div style="margin-bottom: 10px; text-align:justify; font-size: 11px;">
Dengan hormatnya perkara di atas adalah dirujuk.
</div>-->

<div style="margin-bottom: 15px; text-align:justify; font-size: 12px;">
  2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dengan segala hormatnya perkara di atas adalah dirujuk dan permohonan cuti belajar 
  yang dikemukakan oleh pihak tuan seperti berikut:<br/><br>
<div class="x_content">
  <center>
    <div class="table-responsive">
           <table style="vertical-align:10px; font-size: 12px; border: 1px solid #000;">
            <tr style=" background-color: lightgrey;">
                <td><b>PERINGKAT PENGAJIAN</b></td>
               <td><b><?= ucwords(strtoupper($pengajian->tahapPendidikan)) ?></b></td>
             </tr>

            <tr>
                <td style=" background-color: lightgrey;" ><b>KURSUS / BIDANG</b></td>
                <td width="80%"><b><?=ucwords(strtoupper( $pengajian->namaMajor)) ?></b></td>
            </tr>

             <tr style=" background-color: lightgrey;">
                 <td><b>INSTITUT PENGAJIAN</b></td>
                 <td><b><?= ucwords(strtoupper($pengajian->InstNm)) ?></b></b></td>
            </tr>

             <tr>
                 <td  style=" background-color: lightgrey;"><b>MOD PENGAJIAN</b></td>
                 <td ><b><?= ucwords(strtoupper($pengajian->mod->studyMode)) ?></b></td>
            </tr>

             <tr style=" background-color: lightgrey;">
                 <td><b>TARIKH</b> </td>
                 <td><b><?= ucwords(strtoupper($pengajian->tarikhmula)) ?> 
                         <b>SEHINGGA</b> <?=ucwords(strtoupper($pengajian->tarikhtamat))?>
                          (<?=ucwords(strtoupper($pengajian->tempohpengajian))?>)</b></td>
            </tr>

            
              
          
          </table>
     </div><br>
</div>



<div style="margin-bottom: 15px; text-align:justify; font-size: 14px;">
  2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Berikut dimaklumkan keputusan Mesyuarat Jawatankuasa Pengajian Lanjutan (Akademik) Bil. 3/2019 (Kali Ke-77)
  yang bersidang pada:<br><br>
  
 <ul>KEPUTUSAN:
<li><b><u> Diluluskan Cuti Belajar Sepenuh Masa Bergaji Penuh tertakluk 
          <br>dengan mengemukakan surat tawaran universiti<br>
          sebelum atau pada 31 Ogos 2019.</b></u></li> 
 
 </ul>

</div>

<div style="margin-bottom: 15px; text-align:justify; font-size: 12px;">
Perhatian dan kerjasama tuan berhubung perkara ini amalah dihargai dan didahului dengan ucapan terima kasih.
<br><br>
Sekian.

</div>

<div style="margin-bottom: 8px; font-size: 11px;">
    Yang ikhlas,<br><br><br>

   <b>YANTI BINTI YUSUP</b><br>
   Penolong Pendaftar<br>
   Unit Pengajian Lanjutan<br>
   Bahagian Sumber Manusia<br>
   b/p Pendaftar

</div>

<div style="margin-bottom:11px; font-size:10px;">
  Pegawai untuk dihubungi:
  <br>No. Telefon&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;088-320000 samb. 1058
  <br>No. Faks&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;088-320651
  <br>Alamat e-mel&nbsp;:&nbsp;&nbsp;&nbsp;<u style="color:blue;">yantiy@ums.edu.my </u> 

</div>

<div style="">
  <table style="vertical-align:11px; font-size: 10px">
        <tr>
            <td>s.k.<br>&nbsp;- Naib Canselor<br>      
                    &nbsp;- Pendaftar<br>
                    &nbsp;- Dekan, Fakulti<br>
                    &nbsp;- Ketua, Sektor Pembangunan Sumber Manusia<br>
                    &nbsp;- Puan Muhajirah Muchlish, Timbalan Bendahari<br>
                  <!--   &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;-<?= ucwords(strtolower($letter->department->chiefBiodata->jawatan->nama))?> -->
                     &nbsp;- Fail (UMS-PER) <?= $letter->COOldID ?><br><br><br>
              </td>
          </tr>
        
    </table>
    <table style="vertical-align:11px;font-size: 11px; font-style: italic">
         
        <tr>
            <td>dj/yy</td>

        </tr>
            </table>
</div>