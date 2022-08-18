<?php


?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 25px; font-size: 10px;">
  <table>
        <tr>
            <td><font size="2"><b>Rujukan Kami</b></font></td>
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
                 echo ($letter->gelaran->Title);
             }
                
            ?>
    
</div>

<div style="margin-bottom: 10px; font-size: 11px;">
    <br>  <b>TAWARAN CUTI BELAJAR SECARA SEPENUH MASA BERGAJI PENUH
</div>

<div style="margin-bottom: 10px; text-align:justify; font-size: 11px;">
Dengan hormatnya perkara di atas adalah dirujuk.
</div>

<div style="margin-bottom: 15px; text-align:justify; font-size: 11px;">
  2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sukacita dimaklumkan bahawa Mesyuarat Jawatankuasa Pengajian Lanjutan (Akademik)   
    Bil. 3/2019 (Kali Ke-77) yang telah bersidang pada 08 Ogos <?=  date('Y')  ?> bersetuju meluluskan permohonan tuan untuk melanjutkan pengajian seperti butiran berikut;<br><br>
<div class="x_content">
  <center>
    <div class="table-responsive">
           <table style="vertical-align:10px; font-size: 10px; border: 1px solid #000;">
            <tr style=" background-color: lightgrey;">
                <td><b>PERINGKAT</b></td>
               <td><b><?= ucwords(strtoupper($pengajian->tahapPendidikan)) ?></b></td>
             </tr>

            <tr>
                <td style=" background-color: lightgrey;" ><b>BIDANG</b></td>
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
                 <td><b>TARIKH PENGAJIAN</b> </td>
                 <td><b><?= ucwords(strtoupper($pengajian->tarikhmula)) ?> <b>SEHINGGA</b> <?=ucwords(strtoupper($pengajian->tarikhtamat))?>(<?=ucwords(strtoupper($pengajian->tempohpengajian))?>)</b></td>
            </tr>
             
            <tr style=" background-color: lightgrey;">
                 <td><b>PENAJAAN</b> </td>
                 <td><b><?= ucwords(strtoupper($biasiswa->nama_tajaan)) ?> </b></td>
            </tr>
            
            <tr style=" background-color: lightgrey;">
                 <td><b>CATATAN</b> </td>
                 <td><b><?= ucwords(strtoupper($model->ulasan_bsm)) ?> </b></td>
            </tr>
          
          </table>
     </div><br>
</div>



<div style="margin-bottom: 15px; text-align:justify; font-size: 11px;">
  3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sehubungan itu, tuan perlu melengkapkan dokumen seperti berikut;<br><br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.1. Akaun Penerimaan Tawaran; <br/>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.2. Akaun Persetujuan Memulakan Cuti Belajar Tanpa Tajaan; <br/>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.3. Kadar Elaun dan Biasiswa Cuti Belajar (Malaysia)<br/>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.4. Borang Pendaftaran Pengajian (dikembalikan setelah kakitangan mendaftar pengajian) dan; <br/>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.5. Borang Perjanjian (4 Salinan) <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sehubungan itu, tuan perlu melengkapkan dokumen seperti berikut;<br><br>
  

 


</div>

<div style="margin-bottom: 15px; text-align:justify; font-size: 11px;">
   Sekiranya tuan menerima tawaran ini, tuan adalah dikehendaki menandatangani perjanjian ikatan perkhidmatan dengan UMS 
   dan tidak dibenarkan melakukan kerja-kerja luar sepanjang tempoh pengajian. 
   Dokumen lengkap bagi perkara 3.1, 3.2 dan 3.5  di atas hendaklah dikembalikan dalam tempoh empat belas (14) hari daripada surat ini dikeluarkan.
  <br><br>
Sekian.

</div>

<div style="margin-bottom: 8px; font-size: 11px;">Yang ikhlas,<br><br><br>

   <b>MASRI BIN JUDAH</b><br>
   Ketua<br>
   Bahagian Sumber Manusia<br>
   b.p Pendaftar

</div>

<div style="margin-bottom:11px; font-size:10px;">
  Pegawai untuk dihubungi:
  <br>No. Telefon&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;088-320000 samb. 1058 (Puan Yanti Yusup)
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
            <td>dj/mj</td>

        </tr>
            </table>
</div>