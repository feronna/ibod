<?php

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 15px; font-size: 11px ">
      Ruj. Kami  : UMS/PEND2.2/500-6/2/5<br>
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
            <br>  <b>PENGESAHAN KAKITANGAN UNIVERSITI MALAYSIA SABAH<br>

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
            2.<?php  echo str_repeat("&nbsp;", 5);  ?>Adalah dimaklumkan bahawa penama yang tersebut di atas adalah kakitangan Unversiti
            Malaysia Sabah dan memegang jawatan <?= ucwords(strtolower($pinjaman->biodata->statusLantikan->ApmtStatusNm))  ?> sebagai <?= ucwords(strtolower($pinjaman->biodata->jawatan->nama)) ?> Gred
        <?= $pinjaman->biodata->jawatan->gred ?> di <?=ucwords(strtolower($pinjaman->biodata->department->fullname)) ?>, Universiti Malaysia Sabah.
        </div>

        <div style="margin-bottom: 10px; text-align:justify; font-size: 13px;">
            3.<?php  echo str_repeat("&nbsp;", 5);  ?> Beliau telah berkhidmat dengan universiti ini sejak <strong><?= $pinjaman->biodata->displayStartSandangan  ?></strong> dan menerima gaji sebulan seperti berikut:
                       
        </div>

        <div class="x_content">
                <div class="table-responsive">
                    <table  class="table table-bordered" style="vertical-align:11px; font-size: 13px; border: 0px solid #000;" width="100%" > 
             <?php foreach($data as $payoll){ ?>
             <tr style=" background-color: lightgrey; border: 0px solid #000; ">
            <td style="text-align:right; border: 0px solid #000;" width ="10%">i.</td>
              <td style="text-align:left; border: 0px solid #000;" width ="10%"> Gaji Pokok</td>
              <td style="text-align:left; border: 0px solid #000;" width ="35%">: <?= $gaji->gajiBasic ?> </td> 
            </tr>
            <tr style=" background-color: lightgrey; border: 0px solid #000; ">
            <td style="text-align:right; border: 0px solid #000;" width ="10%">ii.</td>
              <td style="text-align:left; border: 0px solid #000;" width ="10%"> Elaun Tetap</td>
              <td style="text-align:left; border: 0px solid #000;" width ="35%">: RM <?= $sum ?> </td> 
            </tr>
            <tr style=" background-color: lightgrey; border: 0px solid #000; ">
            <td style="text-align:right; border: 0px solid #000;" width ="8%">iii.</td>
              <td style="text-align:left; border: 0px solid #000;" width ="10%">Gaji Kasar</td>
              <td style="text-align:left; border: 0px solid #000;" width ="35%">: RM <?= $payoll->MPH_TOTAL_ALLOWANCE  ?>   <?php // $payoll->MPH_PAY_MONTH   ?></td> 
            </tr>
            <tr style=" background-color: lightgrey; border: 0px solid #000; ">
            <td style="text-align:right; border: 0px solid #000;" width ="8%">iv.</td>
              <td style="text-align:left; border: 0px solid #000;" width ="10%">Jumlah Potongan</td>
              <td style="text-align:left; border: 0px solid #000;" width ="35%">: RM <?= $payoll->MPH_TOTAL_DEDUCTION ?></td> 
            </tr>
            <tr style=" background-color: lightgrey; border: 0px solid #000; ">
            <td style="text-align:right; border: 0px solid #000;" width ="8%">v.</td>
              <td style="text-align:left; border: 0px solid #000;" width ="10%">Gaji Bersih</td>
              <td style="text-align:left; border: 0px solid #000;" width ="35%">: RM <?= ($payoll->MPH_TOTAL_ALLOWANCE)-($payoll->MPH_TOTAL_DEDUCTION) ?></td> 
            </tr>   <?php  } ?>
          </table>
                </div></div> 
         
         <div style="margin-bottom: 15px; text-align:justify; font-size: 13px;">
           Sehubungan itu, sukacita sekiranya tuan dapat memberikan kerjasama yang sewajarnya kepada beliau.   
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

        <div style="margin-bottom:11px; font-size: 11px;">

          <br>No. Telefon: 088-320000 ext. 1072  
          <br>No. Faks: 088-320047
          <br>Alamat e-mel: shfidah@ums.edu.my	

        </div>
        <br>
      
        <div style="">
          <table style="vertical-align:11px; font-size: 11px">
                <tr>
                    <td>s.k.</td>

                </tr>
                  <tr>
                      <td></td>
                      <td> - Ketua BSM<br> 
                           - Fail UMS [PER] - <?= $pinjaman->biodata->COOldID ?>

                      </td>
                  </tr>

            </table>
              <div style="margin-bottom:22px; font-size: 11px;">

          <br>
          <br>
          <br>mam/srhh 

        </div>
        </div>
        
         
        
        
        
         