<?php

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 25px;font-size: 11px">
  <table>
        <tr>
            <td>Rujukan</td>
            <td>: UMS/PEND2.2/500-2/4/3(<?= $model->kali_ke ?>)</td>
        </tr>
       <tr>
            <td>Tarikh</td>
            <td>: </td>
           <!-- <td>: <?=  $model->tarikhbsm  ?></td> <!-- tarikh diluluskan KJ atau mesyuarat@BSM? --> -->
        </tr>
    </table>
</div>


<div style="margin-bottom: 25px; ">
    <b>   <?= strtoupper($letter->gelaran->Title) ?>&nbsp;<?= $letter->CONm ?></b><br>
    <?= ucwords(strtolower($letter->jawatan->nama))?>&nbsp;(<?= $letter->jawatan->gred?>)<br>
    <?=ucwords(strtolower($letter->department->fullname)) ?>
    <br> <?php  if ($letter->campus_id == 2){
                echo  'UMS Kampus Antarabangsa Labuan';
                }else{
                    echo 'Universiti Malaysia Sabah';
                }
                
                 ?>

</div>

<div>
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

<div style="margin-bottom: 10px">
    <br>  <b>PENGESAHAN DALAM PERKHIDMATAN<br>

</div>

<div style="margin-bottom: 10px; text-align:justify">
Adalah saya diarah untuk merujuk kepada perkara di atas.
</div>

<div style="margin-bottom: 15px; text-align:justify">
    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sukacita dimaklumkan bahawa Jawatankuasa Pengesahan Dalam Perkhidmatan    
    Bil.&nbsp;<?= $model->kali_ke ?>/<?=  $model->tahun_mesyuarat ?> telah bersetuju memperakukan pengesahan dalam perkhidmatan  <?php  if ($letter->TitleCd == 'P019'){
                echo  'Puan,';
                }
                if ($letter->TitleCd == 'L001'){
                echo  'Tuan,';
                }
             if($letter->TitleCd!= 'P019' && $letter->TitleCd != 'L001'){
                 echo ($letter->gelaran->Title);
             }
                
            ?> mulai tarikh mesyuarat bersidang iaitu pada 
            <strong><?= $model->tarikhMesyuarat ?></strong> sebagai  <?= ucwords(strtolower($letter->jawatan->nama))?>&nbsp;<?= $letter->jawatan->gred?> dengan memilih <strong> <?= strtoupper($model->skim)?>.</strong>

</div>


<div style="margin-bottom: 15px; text-align:justify">
  Universiti Malaysia Sabah mengucapkan tahniah dan semoga puan akan terus memberikan perkhidmatan dengan penuh komitmen dan dedikasi untuk kemajuan dan kepentingan Universiti serta kemajuan kerjaya puan.
  <br><br>
Sekian dan selamat maju jaya.

</div>

<b>“WAWASAN KEMAKMURAN BERSAMA 2030”</b><br><br>

<div style="margin-bottom: 8px">
    Saya Yang Menjalankan Amanah,<br>
    <!--<img src="../../web/images/signature.png" width="100" height="50" alt="signature"/> <br>-->

   <b>KAMISAH HUSIN</b><br>
   Ketua<br>
   Bahagian Sumber Manusia<br>
   B.p Pendaftar

</div>

<div style="margin-bottom:11px; font-size: 11px;">
  Pegawai untuk dihubungi:
  <br>No. Telefon&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;088-320000 samb. 102005 (Pn. Rozaidah binti Hj. Amir Hussein)
  <br>No. Faks&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;088-320047
  <br>Alamat e-mel&nbsp;:&nbsp;&nbsp;&nbsp;idaazrie@ums.edu.my
</div>

<div style="">
  <table style="vertical-align:11px; font-size: 11px">
        <tr>
            <td>s.k.      &nbsp;-Pendaftar<br>
                    &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;-<?= ucwords(strtolower($letter->department->admin->adminpos->position_name))?>(<?= ucwords(strtolower($letter->department->admin->dept->fullname))?>)

<!--                    &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;-<= ucwords(strtolower($letter->department->chiefBiodata->jawatan->nama))?>-->
                    <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -Fail UMSPER [<?= $letter->COOldID ?>]<br><br><br>
              </td>
          </tr>
        
    </table>
<!--    <table style="vertical-align:11px;font-size: 11px; font-style: italic">
         
        <tr>
            <td>br/pj</td>

        </tr>
            </table>-->
</div>
<!--  <div style="margin-bottom:60px; font-size: 12px;">

          
</div>
        
        
<div style="margin-bottom:22px; font-size: 13px;">
                 <br>
                 <div align = "center"><strong> INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN </strong></div>

</div>-->