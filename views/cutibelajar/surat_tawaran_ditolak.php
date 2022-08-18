<?php

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 25px;font-size: 11px">
  <table>
        <tr>
            <td>Rujukan</td>
            <td>:UMS/PEND2.2/500-2/4/3(<?= $model->no_rujukan ?>)</td>
        </tr>
       <tr>
            <td>Tarikh</td>
            <td>: <?=  $model->created  ?></td> <!-- tarikh diluluskan KJ atau mesyuarat? -->
        </tr>
    </table>
</div>


<div style="margin-bottom: 25px; ">
    <b>   <?= strtoupper($letter->gelaran->Title) ?>&nbsp;<?= $letter->CONm?></b><br>
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
    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adalah dimaklumkan bahawa Unit Pengajian Lanjutan    
    Bil.<?= $model->no_rujukan ?>/<?=  date('Y')  ?> yang telah bersidang pada <?= $model->tarikhMesyuarat ?>, tidak bersetuju memperakukan pengesahan dalam perkhidmatan 
        <?php  if ($letter->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($letter->TitleCd == 'L001'){
                echo  'tuan';
                }
             if($letter->TitleCd!= 'P019' && $letter->TitleCd != 'L001'){
                 echo ($letter->gelaran->Title);
             }
                
            ?> kerana <?=  $model->ulasan_jfpiu  ?>
</div>

<div style="margin-bottom: 15px; text-align:justify">
  3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sehubungan itu, mesyuarat telah bersetuju untuk melanjutkan tempoh percubaan 
   <?php  if ($letter->TitleCd == 'P019'){
                echo  'puan';
                }
                if ($letter->TitleCd == 'L001'){
                echo  'tuan';
                }
             if($letter->TitleCd!= 'P019' && $letter->TitleCd != 'L001'){
                 echo ($letter->gelaran->Title);
             }
                
            ?> seperti berikut:
            <br>
<div class="x_content">
    <div class="table-responsive">
           <table style="vertical-align:11px; font-size: 12px; border: 1px solid #000;"  width="100%">
            <tr style=" background-color: lightgrey;">
               <th>PELANJUTAN</th>
              <th>TARIKH</th>
              <th>IMPLIKASI PELANJUTAN</th>>             
            </tr>
            <tr style ="border: 4px solid #000;">
              <th><?= strtoupper($model->pelanjutan) ?>  </th>
              <th><?= strtoupper($model->tarikh_mohon_balik)?> - <?= strtoupper($model->tarikh_mohon_balik)  ?></th>
              <th><?= strtoupper($model->implikasi_pelanjutan) ?></th>
            </tr>
          </table>
     </div>
</div>

<!--<div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center; vertical-align:11px; font-size: 12px; ">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">PELANJUTAN</th>
                        <th class="column-title text-center">TARIKH</th>
                        <th class="column-title text-center">IMPLIKASI PELANJUTAN</th>
                    </tr>
                </thead>
                <tbody>          
                        <tr>
                            <td style="width:10%;"><?= strtoupper($model->pelanjutan) ?></td>
                            <td style="width:30%;"><?= strtoupper($model->tarikh_mohon_balik)?> - <?= strtoupper($model->tarikh_mohon_balik)  ?></td>
                            <td style="width:30%;"><?= strtoupper($model->implikasi_pelanjutan) ?></td>
                        </tr>
                </tbody>
            </table>    
        </div>
</div>-->
<br>
<!-- Tindakan penamatan perkhidmatan boleh diambil sekiranya tuan gagal memenuhi syarat 
pengesahan dalam perkhidmatan selepas tamat tempoh pelanjutan minimum, 
selaras dengan  <b>Peraturan-Peraturan Pegawai Awam (Pelantikan, Kenaikan Pangkat dan 
    Penamatan Perkhidmatan) 2012 </b>yang menyatakan bahawa, <i>“Tertakluk kepada 
subperaturan (2), Yang di-Pertuan Agong boleh menamatkan perkhidmatan seseorang 
pegawai dalam percubaan pada perlantikan pertama yang telah gagal untuk disahkan dalam 
perkhidmatan semasa tempoh percubaan, sama ada tempoh percubaan asal atau dilanjutkan”.</i>
    <br>
Perhatian puan amat dihargai dan didahului dengan ucapan ribuan terima kasih.
 -->
</div>

<div style="margin-bottom: 8px">
    Yang ikhlas,<br><br><br>

   <b>MASRI BIN JUDAH</b><br>
   Ketua<br>
   Bahagian Sumber Manusia<br>
   b.p Pendaftar

</div>

<div style="margin-bottom:11px; font-size:10px;">
  Pegawai untuk dihubungi:
  <br>No. Telefon&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;088-320000 samb. 1058 (Puan Yanti Yusup)
  <br>No. Faks&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;088-320651
  <br>Alamat e-mel&nbsp;:&nbsp;&nbsp;&nbsp;<u style="color:blue;">yantiy@ums.edu.my </u> 

</div>

<div style="">
  <table style="vertical-align:11px; font-size: 11px">
        <tr>
            <td>s.k.      &nbsp;-Pendaftar<br>
                    &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;-<?= ucwords(strtolower($letter->department->chiefBiodata->jawatan->nama))?>
                    <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -Fail (UMS-PER) <?= $letter->COOldID ?><br><br><br>
              </td>
          </tr>
        
    </table>
    <table style="vertical-align:11px;font-size: 11px; font-style: italic">
         
        <tr>
            <td>br/pj</td>

        </tr>
            </table>
</div>