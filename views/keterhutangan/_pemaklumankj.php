<?php

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" media="print" href="bootstrap.css" />
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
            <td><strong><?= $biodata->tarikhNoti?></strong></td>
        </tr>
    </table>
</div>


<div style="margin-bottom: 15px;font-size: 13px ">
    <b><?= strtoupper($biodata->kakitangan->rujukan->pelulus->gelaran->Title) ?>&nbsp;<?= ucwords(strtoupper($biodata->kakitangan->rujukan->pelulus->CONm))?> </b><br>
    <b> <?= ucwords(strtoupper($biodata->kakitangan->department->fullname))?></b><br>
    UNIVERSITI MALAYSIA SABAH
</div>

<div style="margin-bottom: 7px; font-size:13px;  text-align:justify">
    <br>  <b>PEMAKLUMAN LAPORAN KEDUDUKAN KEWANGAN KAKITANGAN <?=ucwords(strtoupper($biodata->kakitangan->department->fullname))?> (<?= $biodata->kakitangan->department->shortname?>)
     <br>

</div>
<br>
<div style="margin-bottom: 7px; font-size:13px; text-align:justify">
    Adalah saya diarahkan untuk merujuk kepada perkara tersebut di atas.
</div>

<br>

<div style="margin-bottom: 7px; font-size:13px; text-align:justify">
    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Merujuk kepada laporan kedudukan kewangan yang dimajukan oleh Jabatan Bendahari, kami dapati bahawa kakitangan
     di bawah selian  <?php  if ($biodata->kakitangan->rujukan->pelulus->gelaran->TitleCd == 'P019'){
                echo  'puan,';
                }
                if ($biodata->kakitangan->rujukan->pelulus->gelaran->TitleCd == 'L001'){
                echo  'tuan,';
                }
                
             if($biodata->kakitangan->rujukan->pelulus->gelaran->TitleCd != 'P019' && $biodata->kakitangan->rujukan->pelulus->gelaran->TitleCd != 'L001'){
                 echo ($biodata->kakitangan->rujukan->pelulus->gelaran->Title);
             }
                
            ?>
     
     seperti yang tersebut di atas berada dalam keadaan keterhutangan kewangan yang serius
</div>


<div style="margin-bottom: 7px;font-size:13px; text-align:justify">
  3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Butiran keadaan keterhutangan kewangan yang serius adalah seperti yang berikut:
</div>

<div style="margin-bottom: 18px;">
    <table style="margin-left: 30px;">
        <tr>
            <td style="font-size: 12px"><b>Nama</b></td>
            <td></td> <td></td>
            <td>:</td>
            <td style="font-size: 12px"><b><?= ucwords(strtolower($biodata->kakitangan->CONm))?></b></td>
        </tr>
        <tr>
            <td style="font-size: 12px"><b>No. Kakitangan</b></td>
             <td></td> <td></td>
            <td>:</td>
            <td style="font-size: 12px"><b><?= ucwords(strtolower($biodata->kakitangan->COOldID))?></b></td>
        </tr>
     

    </table>
    
    
    
       <table class="table table-sm table-bordered jambo_table table-striped"  style=" font-size: 9px;" align="center"> 
                    <tr>
                        <td  style="text-align:center; background-color:#2290F0" color="white"  height="25px"><strong>TAHUN/BULAN</strong></td>
                        <td  style="text-align:center; background-color:#2290F0" color="white"  height="25px"><strong>PENDAPATAN</strong></td> 
                        <td  style="text-align:center; background-color:#2290F0" color="white"  height="25px"><strong>PEMOTONGAN</strong></td> 
                        <td  style="text-align:center; background-color:#2290F0" color="white"  height="25px"><strong>JUMLAH BERSIH</strong></td> 
                        <td  style="text-align:center; background-color:#2290F0" color="white"  height="25px"><strong>EMOLUMEN %</strong></td> 
                    </tr>
                    <?php foreach($data as $payoll){ ?>
                    <tr>
                        <td><?= $payoll->MPH_PAY_MONTH ?></td>
                        <td>RM <?= $payoll->MPH_TOTAL_ALLOWANCE?></td> 
                        <td>RM <?= $payoll->MPH_TOTAL_DEDUCTION ?></td> 
                        <td>RM <?= ($payoll->MPH_TOTAL_ALLOWANCE)-($payoll->MPH_TOTAL_DEDUCTION) ?></td> 
                        <td><?= sprintf('%0.2f', round(($payoll->MPH_TOTAL_DEDUCTION/$payoll->MPH_TOTAL_ALLOWANCE)*100, 2)) ?>%</td> 
                    </tr>
                    <?php  } ?>
               
                </table>
</div>

<div style="margin-bottom: 7px;font-size:13px; text-align:justify">
4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if ($biodata->kakitangan->rujukan->pelulus->gelaran->TitleCd == 'P019'){
                echo  'Puan';
                }
                if ($biodata->kakitangan->rujukan->pelulus->gelaran->TitleCd == 'L001'){
                echo  'Tuan';
                }
                
             if($biodata->kakitangan->rujukan->pelulus->gelaran->TitleCd != 'P019' && $biodata->kakitangan->rujukan->pelulus->gelaran->TitleCd != 'L001'){
                 echo ($biodata->kakitangan->rujukan->pelulus->gelaran->Title);
             }
                
            ?> sebagai Ketua Jabatan hendaklah memantau kedudukan kewangan kakitangan yang tersebut di atas sehingga kakitangan
berkenaan bebas daripada berada di dalam keadaan keterhutangan kewangan yang serius dan telah memulihkan kedudukan kredit 
kewangan dengan sepenuhnya.
</div>


<div style="margin-bottom: 7px; font-size:13px; text-align:justify">
  5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Perhatian dan kerjasama <?php  if ($biodata->kakitangan->rujukan->pelulus->gelaran->TitleCd == 'P019'){
                echo  'puan,';
                }
                if ($biodata->kakitangan->rujukan->pelulus->gelaran->TitleCd == 'L001'){
                echo  'tuan,';
                }
                
             if($biodata->kakitangan->rujukan->pelulus->gelaran->TitleCd != 'P019' && $biodata->kakitangan->rujukan->pelulus->gelaran->TitleCd != 'L001'){
                 echo ($biodata->kakitangan->rujukan->pelulus->gelaran->Title);
             }
                
            ?> dalam perkara ini amat dihargai dan didahului dengan ucapan terima kasih.
</div>


<div style="margin-bottom: 7px; font-size:13px; text-align:justify">
  Sekian, terima kasih.
</div>

<div style="margin-bottom: 7px; font-size:13px;">
    Yang ikhlas,<div style="margin-bottom: 7px; margin-top:7px; font-size:11px; color:red">-----"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"-----</div>
     
   <b>YENNEY FADZLYENA BINTI AHMAD SHAH</b><br>
   Ketua Bahagian Perundangan dan Integriti<br>
   Jabatan Pendaftar<br>
   Universiti Malaysia Sabah<br>
   b.p. Pendaftar

</div>

<div style="">
  <table style="vertical-align:11px; font-size: 11px">
        <tr>
            <td>s.k.</td>
            
        </tr>
          <tr>
              <td></td>
              <td>    - Naib Canselor<br>
                      - Pendaftar<br>
                      - Bendahari<br>
                      - Ketua Jabatan
                    <br><br>
              </td>
          </tr>
        
    </table>
  
</div>
</div>