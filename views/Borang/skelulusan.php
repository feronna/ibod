<?php

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 20px; font-size: 11px ">
      Ruj. Kami  : UMS/PEND2.2/400-3/15/4<br>
      Tarikh     : <?= $facility->appdate ?>
      
 
</div>

        <div style="margin-bottom: 25px; ">
            <b>  <?= ucwords(strtoupper($facility->kakitangan->gelaran->Title ))?>&nbsp;<?= $facility->kakitangan->CONm ?></b><br>
                   <?= ucwords(strtolower($facility->kakitangan->jawatan->nama))?>&nbsp;(<?= $facility->kakitangan->jawatan->gred?>)<br>
                   <?=ucwords(strtolower($facility->kakitangan->department->fullname)) ?>

            <br>

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

        <div style="margin-bottom: 10px">
            <br>  <b>PERMOHONAN <?= ucwords(strtoupper($facility->displayjenis->kemudahan ))?><br>

        </div>

        <div style="margin-bottom: 10px; text-align:justify">
        Dengan segala hormatnya perkara di atas adalah dirujuk.
        </div>

        <div style="margin-bottom: 15px; text-align:justify">
            2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sukacita dimaklumkan bahawa permohonan <b> <?= $facility->displayjenis->kemudahan ?> <?php  if ($facility->kakitangan->TitleCd == 'P019'){
                        echo  'Puan,';
                        }
                        if ($facility->kakitangan->TitleCd== 'L001'){
                        echo  'Tuan,';
                        }
                     if($facility->kakitangan->TitleCd!= 'P019' && $facility->kakitangan->TitleCd != 'L001'){
                         echo ($facility->kakitangan->gelaran->Title);
                     }

                     ?></b> <b>[RM<?= $facility->jumlah ?>]</b> untuk menghadiri<i> "<?= $facility->tujuan ?>" </i> 
            pada <?= $facility->datefrom ?> - <?= $facility->dateTo ?> di <?= $facility->nama_tempat ?>, <?= $facility->negara ?> 
            diluluskan oleh Pihak Universiti selaras dengan Pekeliling Perbendaharaan Malaysia WP 1.4.


        </div>


        </div>
        <div style="margin-bottom: 15px; text-align:justify">
          Perhatian dan kerjasama <?php  if ($facility->kakitangan->TitleCd == 'P019'){
                        echo  'puan,';
                        }
                        if ($facility->kakitangan->TitleCd== 'L001'){
                        echo  'tuan,';
                        }
                     if($facility->kakitangan->TitleCd!= 'P019' && $facility->kakitangan->TitleCd != 'L001'){
                         echo ($facility->kakitangan->gelaran->Title);
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

          <br>No. Telefon: 088-320000 ext. 100963 
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
                           - Fail UMS [PER] - <?= $facility->kakitangan->COOldID ?>

                      </td>
                  </tr>

            </table>
              <div style="margin-bottom:22px; font-size: 11px;">

          <br>
          <br>
          <br>mam/srhh 

        </div>
        </div>
        
         
        
        <div style="margin-bottom:22px; font-size: 13px;">
                 <br>
                 <div align = "center"><strong> INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN </strong></div>

        </div>
        
         