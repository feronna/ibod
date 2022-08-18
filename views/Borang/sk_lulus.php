<?php

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 20px; font-size: 11px ">
      Ruj. Kami  : UMS/PEND2.2/400-3/15/4<br>
      Tarikh     : <?= $facility2->appdate ?>
      
 
</div>

        <div style="margin-bottom: 25px; ">
            <b>  <?= ucwords(strtoupper($facility2->kakitangan->gelaran->Title ))?>&nbsp;<?= $facility2->kakitangan->CONm ?></b><br>
                   <?= ucwords(strtolower($facility2->kakitangan->jawatan->nama))?>&nbsp;(<?= $facility2->kakitangan->jawatan->gred?>)<br>
                   <?=ucwords(strtolower($facility2->kakitangan->department->fullname)) ?>

            <br>

        </div>

        <div>
           <?php  if ($facility2->kakitangan->TitleCd == 'P019'){
                        echo  'Puan,';
                        }
                        if ($facility2->kakitangan->TitleCd== 'L001'){
                        echo  'Tuan,';
                        }
                     if($facility2->kakitangan->TitleCd!= 'P019' && $facility2->kakitangan->TitleCd != 'L001'){
                         echo ($facility2->kakitangan->gelaran->Title);
                     }

                    ?>

        </div>

        <div style="margin-bottom: 10px">
            <br>  <b>PERMOHONAN <?= ucwords(strtoupper($facility2->displayjenis->kemudahan ))?><br>

        </div>

        <div style="margin-bottom: 10px; text-align:justify">
        Dengan segala hormatnya perkara di atas adalah dirujuk.
        </div>

        <div style="margin-bottom: 15px; text-align:justify">
            2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sukacita dimaklumkan bahawa permohonan <b> <?= $facility2->displayjenis->kemudahan ?> <?php  if ($facility2->kakitangan->TitleCd == 'P019'){
                        echo  'Puan,';
                        }
                        if ($facility2->kakitangan->TitleCd== 'L001'){
                        echo  'Tuan,';
                        }
                     if($facility2->kakitangan->TitleCd!= 'P019' && $facility2->kakitangan->TitleCd != 'L001'){
                         echo ($facility2->kakitangan->gelaran->Title);
                     }

                     ?></b> <b>[RM<?= $facility2->jumlah ?>]</b> untuk menghadiri<i> "<?= $facility2->tujuan ?>" </i> 
            pada <?= $facility2->datefrom ?> - <?= $facility2->dateTo ?> di <?= $facility2->nama_tempat ?>, <?= $facility2->negara ?> 
            diluluskan oleh Pihak Universiti selaras dengan Pekeliling Perbendaharaan Malaysia WP 1.4.


        </div>


        </div>
        <div style="margin-bottom: 15px; text-align:justify">
          Perhatian dan kerjasama <?php  if ($facility2->kakitangan->TitleCd == 'P019'){
                        echo  'puan,';
                        }
                        if ($facility2->kakitangan->TitleCd== 'L001'){
                        echo  'tuan,';
                        }
                     if($facility2->kakitangan->TitleCd!= 'P019' && $facility2->kakitangan->TitleCd != 'L001'){
                         echo ($facility2->kakitangan->gelaran->Title);
                     }

                     ?>  berhubung perkara ini amat dihargai dan didahului dengan ucapan terima kasih.





        </div>

        <div style="margin-bottom: 8px">
        <b>"WAWASAN KEMAKMURAN BERSAMA 2030"</b><br><br>
            Saya Yang Menjalankan Amanah,<br><br><br>

           <b>SHARIFAH ROFIDAH HABIB HASAN</b><br>
           Ketua<br>
           Seksyen Saraan<br> 
           Bahagian Sumber Manusia<br>
           b.p Pendaftar

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
                      <td> - Ketua, Bahagian Sumber Manusia<br>
                           - Sektor Pengurusan Bayaran Jabatan Bendahari <br>
                           - Fail UMS [PER] - <?= $facility2->kakitangan->COOldID ?>

                      </td>
                  </tr>

            </table>
             <div style="margin-bottom:22px; font-size: 11px;">

          <br>
          <br>
          <br>mam/srhh 

        </div>
        </div>
        
        <div style="margin-bottom:60px; font-size: 12px;">

          
        </div>
        
        
        <div style="margin-bottom:22px; font-size: 13px;">
                 <br>
                 <div align = "center"><strong> INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN </strong></div>

        </div>