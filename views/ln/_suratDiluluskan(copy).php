<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 25px;font-size: 11px">
    <table>
        <tr>
            <td>Rujukan</td>
            <!--            <td>: UMS/CAN1.1.1/400-4/2/6(<= $model->kali_ke ?>)</td>-->
            <td>: UMS/CAN1.1.1/400-4/2/6</td>
        </tr>
        <tr>
            <td>Tarikh</td>
            <td>: <?=  $model->lulusdate  ?></td> <!-- tarikh diluluskan NC?  -->
        </tr>
    </table>
</div>

<div style="margin-bottom: 25px; ">
    <b>   <?= strtoupper($letter->gelaran->Title) ?>&nbsp;<?= $letter->CONm ?></b><br>
    <?= ucwords(strtolower($letter->jawatan->nama))?><br>
<!--    &nbsp;(<?= $letter->jawatan->gred?>)<br>-->
    <?=ucwords(strtolower($letter->department->fullname)) ?>
    <br> 
    <?php  if ($letter->campus_id == 2){
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
                 echo ($letter->gelaran->Title).(',');
             }    
            ?>   
</div>

<div style="margin-bottom: 10px">
    <br><strong>KELULUSAN BERTUGAS RASMI KE LUAR NEGARA</strong><br>
</div>

<div style="margin-bottom: 10px; text-align:justify">
Dengan segala hormatnya perkara di atas adalah dirujuk.
</div>

<div style="margin-bottom: 15px; text-align:justify">
    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adalah dimaklumkan bahawa, YBhg. Prof. Datuk ChM. Dr., telah <b>meluluskan</b> Permohonan
    Bertugas Rasmi ke Luar Negara yang dikemukakan oleh pihak <?php  if ($letter->TitleCd == 'P019'){
                echo  'Puan';
                }
                if ($letter->TitleCd == 'L001'){
                echo  'Tuan';
                }
             if($letter->TitleCd!= 'P019' && $letter->TitleCd != 'L001'){
                 echo ($letter->gelaran->Title);
             }
                
            ?> seperti butiran berikut:
            <br><br>
        <div class="x_content">
            <div class="table-responsive">
                <table style="vertical-align:11px; font-size: 12px; border: 1px solid black; border-collapse: collapse;"  width="100%">
                    <tr style ="border: 1px solid #000;">
                        <th style="text-align:center;">TARIKH PERJALANAN<br>YANG DILULUSKAN</th>
                        <td style="border: 1px solid black"><?= strtoupper($model->datefrom) ?> - <?= strtoupper($model->dateto)  ?></td>
                    </tr>
                    <tr style ="border: 1px solid #000;">
                        <th style="text-align:center">DESTINASI</th>
                        <td style="border: 1px solid black"><?= strtoupper($model->nama_tempat)?>, <?= strtoupper($model->negara)  ?></td>
                    </tr>
                    <tr style ="border: 1px solid #000;">
                        <th style="text-align:center;">TUJUAN</th> 
                        <td style="border: 1px solid black"><?= strtoupper($model->tujuan) ?></td>
                    </tr>
                    <tr style ="border: 1px solid #000;">
                        <th style="text-align:center;">JUMLAH ROMBONGAN</th>
                        <td style="border: 1px solid black"><?= strtoupper($model->bil_peserta) ?> ORANG
                            <?php if($peserta) { 
                               foreach ($peserta as $pesertakakitangan) { 
                            ?>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $bil++ ?>. <?= $pesertakakitangan->kakitangan->CONm; ?></p>
                               <?php } 
                            } else{
                                ?>                      
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;Tiada Rekod</p>                     
                              <?php  
                            } ?>                       
                        </td>
                    </tr>
                    <tr style ="border: 1px solid #000;">
                        <th style="text-align:center;">PERUNTUKAN</th>
                        <td style="border: 1px solid black"><b>&nbsp;<?= strtoupper($model->kod_peruntukan) ?> (RM<?= strtoupper($model->jumlah3) ?>)</b></td>
                    </tr>
                </table>
             </div>
        </div><br>
            
3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sehubungan itu, pihak
        <?php  if ($letter->TitleCd == 'P019'){
            echo  'Puan';
            }
            if ($letter->TitleCd == 'L001'){
            echo  'Tuan';
            }
         if($letter->TitleCd!= 'P019' && $letter->TitleCd != 'L001'){
             echo ($letter->gelaran->Title);
         }

        ?> dikehendaki untuk menghantar Borang LN-2 ke Pejabat ini
        dalam tempoh dua (02) minggu selepas kembali dari bertugas rasmi.
            
            <br><br>
            
Kerjasama dan perhatian pihak  
                <?php  if ($letter->TitleCd == 'P019'){
                echo  'Puan';
                }
                if ($letter->TitleCd == 'L001'){
                echo  'Tuan';
                }
             if($letter->TitleCd!= 'P019' && $letter->TitleCd != 'L001'){
                 echo ($letter->gelaran->Title);
             }
                
            ?>  dalam perkara ini amat dihargai dan saya dahului
                dengan ucapan ribuan terima kasih.
                <br><br>
                Sekian.
                <br><br>
                <strong>“PRIHATIN RAKYAT: DARURAT MEMERANGI COVID-19”</strong>
        
</div>

<div style="margin-bottom: 15px">
    Saya Yang Menjalankan Amanah,<br><br>
   <b>STELLA @ NURUL MARTINI GONTOL</b><br>
   Ketua<br>
   Pejabat Canselori<br>
   b.p. Naib Canselor
</div>

<div style="margin-bottom:11px; font-size: 11px;">
No. Telefon&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;088-320 212
  <br>No. Faks&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;088-320 126
  <br>Alamat e-mel&nbsp;:&nbsp;&nbsp;&nbsp;stella@ums.edu.my	

</div>

<div style="">
    <table style="vertical-align:11px;font-size: 11px; font-style: italic">   
        <tr>
            <td>SNMG/afk</td>
        </tr>
    </table>
</div>
        
        
<div style="margin-bottom:22px; font-size: 13px;">
                 <br>
                 <div align = "center"><strong> INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN </strong></div>
</div>