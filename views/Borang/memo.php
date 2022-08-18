<?php

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="col-md-12 col-sm-3 col-xs-12" style="margin-bottom: 15px; font-size:15px; margin-top: 50px">
                    <div class="profile_img text-center">
                        <div id="crop-avatar"> 
                     
                          <img src="/staff/web/images/logo-umsblack-text-png.png" width="200px" height="auto" alt="signature"/> <br><br>
                        </div>
                    </div>
      </div>
<div style="margin-bottom: 15px;font-size: 11px">
    <br>
</div>

       <div style="margin-bottom: 30px;font-size: 12px">
    <table>
        <tr>
            <td><strong>KEPADA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
            <td><strong>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PUAN SUZIE MOHAMAD </strong></td> 
        </tr>
        <tr>
            <td> </td>
            <td><strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PENOLONG BENDAHARI KANAN </strong></td> 
        </tr>
        <tr>
            <td> </td>
            <td><strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SEKTOR BAYARAN </strong></td> 
        </tr>
        <tr>
            <td><strong>TARIKH&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
            <td><strong>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $facility->appdate ?></strong></td> 
        </tr>
        <tr>
            <td><strong>RUJUKAN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
            <td><strong>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; UMS/ PEND2.2/ 400-3/ 15/ 4 </strong></td> 
        </tr>
        <tr>
            <td><strong>PERKARA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
            <td><strong>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PERMOHONAN <?= ucwords(strtoupper($facility->displayjenis->kemudahan ))?></strong></td> 
        </tr>
        
        
    </table>
</div>


        <div>
           <?php  if ($facility->kakitangan->TitleCd == 'P019'){
                        echo  'Puan,';
                        }
                        if ($facility->kakitangan->TitleCd== 'L001'){
                        echo  'Tuan,';
                        }
                     if($facility->kakitangan->TitleCd!= 'P019' && $facility->kakitangan->TitleCd != 'L001'){
                         echo ($facility->kakitangan->gelaran->Title);
                     }

                    ?>

        </div> 
        <div style="margin-bottom: 10px; text-align:justify">
            <br>
        Dengan hormatnya perkara di atas adalah dirujuk.
        </div>

        <div style="margin-bottom: 15px; text-align:justify">
            2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bersama-sama ini dikemukakan permohonan <?= $facility->displayjenis->kemudahan ?> 
           daripada pemohon mengikut butiran seperti berikut : 
        </div>


        </div>
          <div class="x_content">
                <div class="table-responsive">

                 <table class="table table-sm table-bordered" style=" font-size: 10px;">
                     <tr>
                       <td colspan="10" style="text-align:center; background-color:#527e72" color="white" height="30px" ><strong> MAKLUMAT TANGGUNGAN DAN KELAYAKAN PENGANGKUTAN</strong></td>
                     </tr>
                     
                    <tr> 
                    
                     <td colspan="2" style="text-align:center; background-color:#527e72" color="white" height="25px"><strong>NAMA</strong></td>
                     <td colspan="2" style="text-align:center; background-color:#527e72" color="white" height="25px"><strong>JAWATAN /GRED</strong></td>
                     <td colspan="2" style="text-align:center; background-color:#527e72" color="white" height="25px"><strong>TARIKH</strong></td>
                     <td colspan="2" style="text-align:center; background-color:#527e72" color="white" height="25px"><strong>TEMPAT</strong></td> 
                     <td colspan="2" style="text-align:center; background-color:#527e72" color="white" height="25px"><strong>KELAYAKAN(RM)</strong></td> 
                    
                     </tr>
                 
                     <tr>  
                  
                     <td  colspan="2"  height="25px"><?= ucwords(strtolower($facility->kakitangan->CONm)) ?></td>
                     <td  colspan="2"  height="25px"><?= ucwords(strtolower($facility->kakitangan->jawatan->nama))?>&nbsp;(<?= $facility->kakitangan->jawatan->gred?>)</td>
                     <td  colspan="2"  height="25px"><?= $facility->dateFrom ?> - <?= $facility->dateTo ?></td>
                     <td  colspan="2"  height="25px"><?= ucwords(strtolower($facility->nama_tempat))?>&nbsp;<?= $facility->negara?> </td>
                     <td  colspan="2"  height="25px"><?= $facility->jumlah ?></td>

                     
                     </tr>
                
              
                      </table>
 </div>
                    
                </div>
         
        <div style="margin-bottom: 15px; text-align:justify">
            <br>
            3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sukacita sekiranya pihak puan dapat membuat bayaran kepada penama yang
        berkenaan. Sehubungan itu, dilampirkan bersama-sama ini dokumen-dokumen yang berkaitan
        untuk rujukan pihak puan selanjutnya. 
        </div>
        
      <div style="margin-bottom: 8px">
          <br>
          Sekian, terima kasih.<br><br>
          Saya Yang Menjalankan Amanah,<br><br>
           <b>SHARIFAH ROFIDAH HABIB HASAN</b><br>
           Ketua<br>
           Unit Kemudahan dan Persaraan<br>
           Seksyen Perkhidmatan<br>
           Bahagian Sumber Manusia<br>
           b.p Ketua Bahagian Sumber Manusia

        </div>

        <div style="margin-bottom:11px; font-size: 11px;">

          <br>No. Telefon: 088-320000 ext. 1072  
          <br>No. Faks: 088-320047
          <br>Alamat e-mel: shfidah@ums.edu.my	

        </div>

        <div style="">
          <table style="vertical-align:11px; font-size: 11px">
                <tr>
                    <td>s.k.</td>

                </tr>
                  <tr>
                      <td></td>
                      <td> - Ketua BSM<br>
                           - Bendahari UMS<br> 
                      </td>
                  </tr>

            </table>
              <div style="margin-bottom:22px; font-size: 11px;">
 
          <br>
          <br>mam/srhh 

        </div>
        </div>
         <div style="margin-bottom:-30px; font-size: 12px;">

          
        </div>
        
        
        <div style="margin-bottom:22px; font-size: 13px;">
                 <br>
                 <div align = "center"><strong> INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN </strong></div>

        </div>
        
        
        
        
         