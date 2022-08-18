<?php
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 15px; font-size: 11px ">
      Ruj. Kami  : UMS/PEND2.2/500-6/2/4<br>
      Tarikh     : <?= $pinjaman->tarikhm ?>
     
 
</div>

        <div style="margin-bottom: 20px; ">
            <b>  
       <!--Alamat-->

            <br>

        </div>

        <div>
           Tuan/Puan,

        </div>

        <div style="margin-bottom: 8px;font-size: 14px;">
            <br>  <b>SURAT KEBENARAN JABATAN DAN PENGESAHAN GAJI KAKITANGAN<br>

        </div>

         <div style="margin-bottom: 0px; text-align:justify; font-size: 13px;">
             <b>NAMA <?php  echo str_repeat("&nbsp;", 40);  ?> : <?= $pinjaman->biodata->CONm ?> </b>
        </div>


        <div style="margin-bottom: 10px; text-align:justify; font-size: 13px;">
             <b>NO. KAD PENGENALAN <?php  echo str_repeat("&nbsp;", 10);  ?>: <?= $pinjaman->biodata->ICNO ?> </b>
        </div>



        <div style="margin-bottom: 10px; text-align:justify; font-size: 13px;">
        Dengan segala hormatnya perkara di atas adalah dirujuk.
        </div>

        <div style="margin-bottom: 10px; text-align:justify; font-size: 13px;">
            2.<?php  echo str_repeat("&nbsp;", 5);  ?>  Adalah dimaklumkan bahawa penama di atas adalah kakitangan di <?= $pinjaman->biodata->department->fullname ?>,
            Universiti Malaysia Sabah dan maklumat lanjut adalah seperti butiran berikut:
                       
        </div>
        <div class="x_content">
                <div class="table-responsive">
                    <table  class="table table-bordered" style="vertical-align:11px; font-size: 13px; border: 0px solid #000;" width="100%" >
            <tr style=" background-color: lightgrey; border: 0px solid #000; ">
            <td style="text-align:right; border: 0px solid #000;" width ="8%">i.</td>
              <td style="text-align:left; border: 0px solid #000;" width ="10%">Jawatan</td>
              <td style="text-align:left; border: 0px solid #000;" width ="40%">: <?= $pinjaman->biodata->jawatan->nama ?></td> 
            </tr>
             <tr style=" background-color: lightgrey; border: 0px solid #000; ">
             <td style="text-align:right; border: 0px solid #000;" width ="8%">ii.</td>
              <td style="text-align:left; border: 0px solid #000;" width ="10%"> Gred Jawatan</td>
              <td style="text-align:left; border: 0px solid #000;" width ="35%">: <?= $pinjaman->biodata->jawatan->gred ?></td> 
            </tr>
             <tr style=" background-color: lightgrey; border: 0px solid #000; ">
             <td style="text-align:right; border: 0px solid #000;" width ="8%">iii.</td>
              <td style="text-align:left; border: 0px solid #000;" width ="10%">Tarikh Mula Berkhidmat</td>
              <td style="text-align:left; border: 0px solid #000;" width ="35%">: <?= $pinjaman->biodata->displayStartSandangan  ?></td> 
            </tr>
             <tr style=" background-color: lightgrey; border: 0px solid #000; ">
              <td style="text-align:right; border: 0px solid #000;" width ="8%">iv.</td>
              <td style="text-align:left; border: 0px solid #000;" width ="10%"> Taraf Jawatan</td>
              <td style="text-align:left; border: 0px solid #000;" width ="35%">: <?= $pinjaman->biodata->statusLantikan->ApmtStatusNm  ?> dan <?= $pinjaman->statPencen->statusPencen->PsnStatusNm?></td> 
            </tr>
             <tr style=" background-color: lightgrey; border: 0px solid #000; ">
             <td style="text-align:right; border: 0px solid #000;" width ="8%">v.</td>
              <td style="text-align:left; border: 0px solid #000;" width ="10%">Umur Opsyen Persaraan</td>
              <td style="text-align:left; border: 0px solid #000;" width ="35%">: <?php if($pension) { 
                   foreach ($pension as $retireage) { 
                ?> 
                   <?= $retireage->umurBersara->RetireAgeCd  ?> Tahun <?php } 
                   
                } else{ echo '';
                }
                    ?></td> 
            </tr>
             <tr style=" background-color: lightgrey; border: 0px solid #000; ">
             <td style="text-align:right; border: 0px solid #000;" width ="8%">vi.</td>
              <td style="text-align:left; border: 0px solid #000;" width ="10%">Tarikh Disahkan Jawatan</td>
              <td style="text-align:left; border: 0px solid #000;" width ="15%">: <?=  $gaji->tarikhpengesahan  ?></td> 
            </tr>
             <?php foreach($data as $payoll){ ?>
             <tr style=" background-color: lightgrey; border: 0px solid #000; ">
             <td style="text-align:right; border: 0px solid #000;" width ="8%">vii.</td>
              <td style="text-align:left; border: 0px solid #000;" width ="10%">Gaji Pokok</td>
              <td style="text-align:left; border: 0px solid #000;" width ="15%">: <?= $gaji->gajiBasic ?>  </td> 
            </tr>
            <tr style=" background-color: lightgrey; border: 0px solid #000; ">
            <td style="text-align:right; border: 0px solid #000;" width ="8%">viii.</td>
              <td style="text-align:left; border: 0px solid #000;" width ="10%">Elaun Tetap</td>
              <td style="text-align:left; border: 0px solid #000;" width ="15%">: RM <?= $sum ?> </td> 
            </tr>
            <tr style=" background-color: lightgrey; border: 0px solid #000; ">
            <td style="text-align:right; border: 0px solid #000;" width ="8%">ix.</td>
              <td style="text-align:left; border: 0px solid #000;" width ="10%">Gaji Kasar</td>
              <td style="text-align:left; border: 0px solid #000;" width ="15%">: RM <?= $payoll->MPH_TOTAL_ALLOWANCE  ?>   </td> 
            </tr>
            <tr style=" background-color: lightgrey; border: 0px solid #000; ">
            <td style="text-align:right; border: 0px solid #000;" width ="8%">x.</td>
              <td style="text-align:left; border: 0px solid #000;" width ="10%">Jumlah Potongan</td>
              <td style="text-align:left; border: 0px solid #000;" width ="35%">: RM <?= $payoll->MPH_TOTAL_DEDUCTION ?>  <?php // $payoll->MPH_PAY_MONTH   ?> </td> 
            </tr>
            <tr style=" background-color: lightgrey; border: 0px solid #000; ">
            <td style="text-align:right; border: 0px solid #000;" width ="8%">xi.</td>
              <td style="text-align:left; border: 0px solid #000;" width ="10%">Gaji Bersih</td>
              <td style="text-align:left; border: 0px solid #000;" width ="35%">: RM <?= ($payoll->MPH_TOTAL_ALLOWANCE)-($payoll->MPH_TOTAL_DEDUCTION) ?></td> 
            </tr> 
            <?php  } ?>
          </table>
                </div></div>
        <div style="margin-bottom: 10px; margin-left: 60px; text-align:justify; font-size: 13px;">
              
        </div> 
        </div> 

        <div style="margin-bottom: 10px; text-align:justify; font-size: 13px;">
            3.<?php  echo str_repeat("&nbsp;", 5);  ?> Pihak yang diberi kuasa oleh bahagian gaji tiada
            halangan dan memberi kebenaran potongan gaji dibuat melalui unit kewangan/bahagian gaji untuk 
            membayar balik pembiayaan, mohon tuan/puan pastikan potongan dalam slip gaji hendaklah tidak melebihi 60%
            daripada gaji kasar.
                       
        </div>

         <div style="margin-bottom: 15px; text-align:justify; font-size: 13px;">
             4.<?php  echo str_repeat("&nbsp;", 5);?> Pihak kami juga mengesahkan bahawa:<br>
             <?php  echo str_repeat("&nbsp;", 11); ?>a) Tiada sebarang tindakan tatatertib telah diambil terhadap penama jawatannya akan 
            digantung/dibuang  <?php  echo str_repeat("&nbsp;", 16);  ?> kerja.<br>
             <?php  echo str_repeat("&nbsp;", 11);  ?>b)&nbsp; Penama tidak terlibat dalam Skim Pelepasan Sukarela (VSS).<br>
             <?php  echo str_repeat("&nbsp;", 11);  ?>c)&nbsp; Penama tiada memohon untuk bercuti tanpa gaji.
                       
        </div>
        <br>
        <div style="margin-bottom: 6px; font-size: 13px;">
            Sekian, Terima Kasih.<br>
            Yang ikhlas,<br><br><br><br>

           <b>SHARIFAH ROFIDAH HABIB HASAN</b><br>
           Penolong Pendaftar<br>
           Seksyen Perkhidmatan<br> 
           Bahagian Sumber Manusia<br>
           b.p Pendaftar

        </div> 

        <div style=""> 
          <div style="margin-bottom:22px; font-size: 11px;">

          <br>
          <br>
          <br>mam/srhh 

        </div>
        </div>
        
         
        
        
        
         