<?php

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 30px; font-size: 12px ">
      Ruj. Kami  : UMS/PEND2.2/400-3/15/6<br>
      Tarikh     : <?= $facility->appdate ?>
      
 
</div>

        <div style="margin-bottom: 30px; font-size: 14px">
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

        <div style="margin-bottom: 16px; font-size: 14px">
            <br>  <b>KELULUSAN KEMUDAHAN TAMBANG <?= ucwords(strtoupper($facility->displayjenis->kemudahan ))?><br>

        </div>

        <div style="margin-bottom: 20px; text-align:justify; font-size: 14px">
        Dengan segala hormatnya perkara di atas adalah dirujuk.
        </div>

        <div style="margin-bottom: 25px;font-size: 14px;text-align:justify" >
            2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sukacita dimaklumkan bahawa Universiti telah bersetuju meluluskan permohonan seperti dalam
            borang permohonan untuk menggunakan kemudahan tambang <?= $facility->displayjenis->kemudahan ?> ke <?= $flight->dest_berlepas ?> pada
            <?= $flight->depart ?> seperti yang diperuntukan dalam <b>Pekeliling Perkhidmatan Bilangan 22 Tahun 2008 dan Pekeliling Bendahari Bil. 1
            Tahun 2020,</b> pada para 3.5 menyatakan kelayakan tiket penerbangan adalah yang lebih murah dan menjimatkan masa.<b> Universiti telah meluluskan
            "Tambang Penerbangan" meliputi kesuluruhan kos tambang kapal terbang yang merangkumi harga tiket penerbangan, cukai lapangan terbang, 
            insurans penumpang, dan surcaj bahan api. Perbelanjaan lain seperti penginapan, makan dan sebagainya [perubahan jadual penerbangan selepas
            tiket dikeluarkan] adalah tanggungan 
                <?php  if ($facility->kakitangan->TitleCd == 'P019'){
                        echo  'Puan,';
                        }
                        if ($facility->kakitangan->TitleCd== 'L001'){
                        echo  'Tuan,';
                        }
                     if($facility->kakitangan->TitleCd!= 'P019' && $facility->kakitangan->TitleCd != 'L001'){
                         echo ($facility->kakitangan->gelaran->Title);
                     }

                     ?></b><br>
        </div>
 <div style="margin-bottom: 210px;font-size: 14px;text-align:justify" >
                    3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Untuk makluman, takrif bagi keluarga 
                     <?php  if ($facility->kakitangan->TitleCd == 'P019'){
                        echo  'Puan,';
                        }
                        if ($facility->kakitangan->TitleCd== 'L001'){
                        echo  'Tuan,';
                        }
                     if($facility->kakitangan->TitleCd!= 'P019' && $facility->kakitangan->TitleCd != 'L001'){
                         echo ($facility->kakitangan->gelaran->Title);
                     }

                     ?> yang layak mendapat kemudahan ini adalah tertakluk kepada <b> Pekeliling Perkhidmatan Bilangan 22 Tahun 2008.</b> Kemudahan
                     ini hanya layak dipohon oleh Pekerja, <b>enam(6)bulan dari tarikh melapor diri</b> di Universiti untuk digunakan buat pertama kalinya
                     dan seterusnya ialah pada bila-bila masa dalam tahun berikutnya selepas tarikh lapor diri  <?php  if ($facility->kakitangan->TitleCd == 'P019'){
                        echo  'Puan,';
                        }
                        if ($facility->kakitangan->TitleCd== 'L001'){
                        echo  'Tuan,';
                        }
                     if($facility->kakitangan->TitleCd!= 'P019' && $facility->kakitangan->TitleCd != 'L001'){
                         echo ($facility->kakitangan->gelaran->Title);
                     }

                     ?> di wilayah penempatan.<br>
                     
 </div>
 <div style="margin-bottom: 30px;font-size: 14px;text-align:justify" >
                     4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sehubungan itu, sekiranya pegawai dan isteri yang kedua-duanya bertukar wilayah, hanya seorang
                     sahaja yang layak menggunakan kemudahan Tambang <?= $facility->displayjenis->kemudahan ?> untuk <b>membawa keluarga</b> mengunjungi wilayah asal
                     dalam sesuatu tahun manakala suami atau isterinya boleh menggunakan kemudahan tambang tersebut atas <b>kadar bujang</b> mengikut kelayakan yang
                     ditetapkan dalam tempoh yang sama. Keluarga bermaksud anak-anak pegawai <b>di bawah umur 21 tahun</b> yang masih dalam tanggungan pegawai,
                     termasuk anak tiri dan anak angkat yang diambil mengikut undang-undang, bagi anak yang daif disebabkan oleh kelemahan otak atau jasmani, had
                     umur di atas tidak terpakai dan keseluruhan keluarga
                     <?php  if ($facility->kakitangan->TitleCd == 'P019'){
                        echo  'Puan,';
                        }
                        if ($facility->kakitangan->TitleCd== 'L001'){
                        echo  'Tuan,';
                        }
                     if($facility->kakitangan->TitleCd!= 'P019' && $facility->kakitangan->TitleCd != 'L001'){
                         echo ($facility->kakitangan->gelaran->Title);
                     }

                     ?></b> hendaklah didaftarkan sebagai anak/tanggungan di Universiti ini terlebih dahulu. Isteri atau suami boleh disediakan tambang mengikut
                     kelayakan manakala tambang bagi anak-anak adalah kelas Ekonomi.<br> 
        </div>


        </div>
        <div style="margin-bottom: 25px; text-align:justify">
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
                           - Bendahari UMS<br>
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
        
         