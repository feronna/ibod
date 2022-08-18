<?php

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 20px; font-size: 12px ">
      Ruj. Kami  : UMS/PEND2.2/400-3/15/6<br>
      Tarikh     : <?= $facility->appdate ?>
      
 
</div>

        <div style="margin-bottom: 25px; font-size: 14px;">
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

        <div style="margin-bottom: 10px;font-size: 14px;">
            <br>  <b>KELULUSAN KEMUDAHAN TAMBANG <?= ucwords(strtoupper($facility->displayjenis->kemudahan ))?><br>

        </div>

        <div style="margin-bottom: 10px; text-align:justify;font-size: 14px;">
        Dengan segala hormatnya perkara di atas adalah dirujuk.
        </div>

        <div style="margin-bottom: 10px; text-align:justify;font-size: 14px;" >
            2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sukacita dimaklumkan bahawa permohonan Kemudahan Tambang Mengunjungi Wilayah Asal  <?php  if ($facility->kakitangan->TitleCd == 'P019'){
                        echo  'puan,';
                        }
                        if ($facility->kakitangan->TitleCd== 'L001'){
                        echo  'tuan,';
                        }
                     if($facility->kakitangan->TitleCd!= 'P019' && $facility->kakitangan->TitleCd != 'L001'){
                         echo ($facility->kakitangan->gelaran->Title);
                     }

                     ?> atas <?= ucwords(strtolower($kadar->tanggungan)) ?> telah diluluskan berdasarkan <strong> Pekeliling Perkhidmatan Bilangan 22 Tahun 2008
                     dan Pekeliling Bendahari Bil.1 Tahun 2020.</strong> Para 3.5 dalam pekeliling ini menyatakan bahawa kelayakan tiket penerbangan adalah pada kadar
                     yang lebih murah dan menjimatkan masa. Destinasi <strong><?= $flight->dest_berlepas ?> pada <?= $flight->depart ?> - <?= $flight->arrival ?>. </strong>
            <br> 
             
             
            3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Oleh yang demikian, sebagai makluman <?php  if ($facility->kakitangan->TitleCd == 'P019'){
                        echo  'puan,';
                        }
                        if ($facility->kakitangan->TitleCd== 'L001'){
                        echo  'tuan,';
                        }
                     if($facility->kakitangan->TitleCd!= 'P019' && $facility->kakitangan->TitleCd != 'L001'){
                         echo ($facility->kakitangan->gelaran->Title);
                     }

                     ?>, sebarang perubahan tarikh dan masa selepas tarikh mengunjungi wilayah asal ini
            dikeluarkan adalah atas tanggungan pihak <?php  if ($facility->kakitangan->TitleCd == 'P019'){
                        echo  'puan,';
                        }
                        if ($facility->kakitangan->TitleCd== 'L001'){
                        echo  'tuan,';
                        }
                     if($facility->kakitangan->TitleCd!= 'P019' && $facility->kakitangan->TitleCd != 'L001'){
                         echo ($facility->kakitangan->gelaran->Title);
                     }

                     ?> sendiri.
             <br> 
                     
        </div>


        </div>
        <div style="margin-bottom: 12px; text-align:justify;font-size: 14px;">
          Perhatian dan kerjasama <?php  if ($facility->kakitangan->TitleCd == 'P019'){
                        echo  'puan,';
                        }
                        if ($facility->kakitangan->TitleCd== 'L001'){
                        echo  'tuan,';
                        }
                     if($facility->kakitangan->TitleCd!= 'P019' && $facility->kakitangan->TitleCd != 'L001'){
                         echo ($facility->kakitangan->gelaran->Title);
                     }

                     ?> di atas perkara ini amat dihargai dan didahului dengan ucapan terima kasih.  
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
                      <td> - Ketua BSM<br> 
                           - UMS PER (<?= $facility->kakitangan->COOldID ?>)

                      </td>
                  </tr>

            </table>
              <div style="margin-bottom:22px; font-size: 11px;">

           
          <br>mam/srhh 

        </div>
        </div> 
        
        <div style="margin-bottom:22px; font-size: 13px;">
                 <br>
                 <div align = "center"><strong> INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN </strong></div>

        </div>
        
         