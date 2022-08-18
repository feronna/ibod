<?php ?>

    <?php if($permohonan->jumlahLuluss != 0.00){ ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 15px;font-size: 11px">
    <table>
        <tr>
            <td><small>Rujukan Kami</small></td>
            <td><small>&nbsp;&nbsp;: &nbsp;UMS/PEND2.2/500-5/2/1</small></td>
        </tr>
        <tr>
            <td><small>Tarikh</small></td>
            <td><small>&nbsp;&nbsp;: &nbsp; 
                <?php 
                    //echo Yii::$app->formatter->asDate($permohonan->checkDateLetter, 'php:d M Y');
                    echo $permohonan->checkDateLetter;
                ?>
            </small></td>  
        </tr>
    </table> 
</div>  

<!--<div style="background-image: url(<? $qrCode->writeDataUri(); ?>);background-repeat: no-repeat;  background-attachment: fixed; background-position: right;"> -->
<div> 
    <div style="margin-bottom: 10px; ">
        <b><?= strtoupper($permohonan->biodata->displayGelaran.' '.$permohonan->biodata->CONm) ?></b><br/>
        <?= ucwords($permohonan->biodata->jawatan->nama) ?><br/>
        <?= ucwords($permohonan->biodata->displayDepartment) ?><br/> 
    </div>
    
    <div style="margin-bottom: 10px; ">
        Tuan/Puan,   
    </div>

    <div style="margin-bottom: 10px; text-align:justify">
        <b>STATUS PERMOHONAN PROGRAM PEMBANGUNAN PROFESIONAL ANJURAN LUAR</b>
        <!-- <br/>TAJUK KURSUS : <?php //strtoupper($permohonan->namaProgram) ?> -->
    </div>

    <div style="margin-bottom: 10px; ">
        Dengan hormatnya perkara di atas adalah dirujuk.   
    </div>
    
    <div style="margin-bottom: 10px; text-align:justify">
        <table class="table2">
            <tr class="table2"><td class="table2"><b>Tajuk Kursus</b></td><td class="table2"><?= strtoupper($permohonan->namaProgram) ?></td></tr>
            <tr class="table2"><td class="table2"><b>Tarikh </b></td><td class="table2"><?= strtoupper($permohonan->displayDateLetter);?></td></tr>
            <tr class="table2"><td class="table2"><b>Tempat</b></td><td  class="table2"><?= strtoupper($permohonan->lokasi);?></td></tr>
        </table>
    </div>  
</div> 
<br/>

     

<div style="margin-bottom: 10px; text-align:justify">  
    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sukacita dimaklumkan bahawa Unit Latihan Bahagian Sumber Manusia
telah meluluskan permohonan Tuan/Puan mengikuti kursus di atas dan pembiayaan yang ditanggung adalah
seperti berikut:
</div>
<div style="margin-bottom: 10px; text-align:justify">
<table class="table2">
        <thead>
            <tr class="table2">
                <th class="table2">Bil</th>
                <th class="table2">Perkara</th>
                <th class="table2">Vot Peruntukan Latihan Pusat</th>
<!--                <th class="table2">Butiran Pembiayaan</th>-->
                <th class="table2">Pembiayaan Diluluskan</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table2"><td class="table2">1</td><td class="table2">Yuran</td><td class="table2">MHI B005-001-B29000</td><td class="table2">RM <?= $permohonan->lulusYuran ?></td></tr>
            <tr class="table2"><td class="table2">2</td><td class="table2">Tiket Kapal Terbang</td><td class="table2">MHI B005-001-B21000</td><td class="table2">RM <?= $permohonan->lulusTiket ?></td></tr>
            <tr class="table2"><td class="table2">3</td><td class="table2">Hotel</td><td class="table2">MHI B005-001-B21000</td><td class="table2">RM <?= $permohonan->lulusPenginapan ?></td></tr>
            <tr class="table2"><td colspan="3" class="table2" align="center">Jumlah Keseluruhan</td><td class="table2">RM <?= $permohonan->jumlahLuluss ?></td></tr>
        </tbody>
    </table>
</div>

<br/>
<div style="margin-bottom: 10px; text-align:justify">
    3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Untuk makluman, lain-lain kos yang tidak dinyatakan di atas boleh dimohon menggunakan
peruntukan jabatan (tertakluk kepada pertimbangan Ketua PTJ masing-masing). 
<!-- Sebarang penarikan
diri tanpa alasan munasabah dalam tempoh lima hari (5) hari daripada tarikh kursus berlangsung akan
menyebabkan denda sebanyak RM50.00 dikenakan ke atas Tuan/Puan. -->
</div>

<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<div style="margin-bottom: 10px; text-align:justify"> 
    4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sebarang pertanyaan berkenaan perkara ini boleh berhubung dengan <?= $permohonan->displayUrusetia ?>

<br/><br/>Segala kerjasama dan perhatian Tuan/Puan berhubung perkara ini amat dihargai dan didahului dengan
ucapan terima kasih.

<br/><br/>Sekian.

</div>

<br/>
<div style="margin-bottom: 10px; text-align:justify">
            Saya Yang Menjalankan Amanah,
            <br/><br/>
            <strong><?= $permohonan->displayPegawaiLatihan(1) ?></strong><br/> 
            <?= $permohonan->displayPegawaiLatihan(4) ?><br/>
                b.p Ketua Bahagian<br/> 

                No. Tel	: 088320000 samb. <?= $permohonan->displayPegawaiLatihan(2) ?><br/>
                No. Faks : 088320243 / 320651<br/>
                Emel : <?= $permohonan->displayPegawaiLatihan(3) ?><br/>
                <?php
            ?>
            s.k: - Ketua Bahagian Sumber Manusia<br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <?= $permohonan->displayCommentary(1) ?><br/> 
            <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <?php //$permohonan->displayCommentary(2) ?><br/> -->
            <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <?php //$permohonan->displayCommentary(3) ?><br/>-->
        
</div>

<br/><br/>
<div style="margin-bottom: 5px; text-align:center">
    <b><small>SURAT INI ADALAH CETAKAN KOMPUTER DAN TIDAK MEMERLUKAN TANDATANGAN</small></b> 
</div>

    <?php  }?>

    <?php if($permohonan->jumlahLuluss == 0.00){ ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 15px;font-size: 11px">
    <table>
        <tr>
            <td><small>Rujukan Kami</small></td>
            <td><small>&nbsp;&nbsp;: &nbsp;UMS/PEND2.2/500-5/2/1</small></td>
        </tr>
        <tr>
            <td><small>Tarikh</small></td>
            <td><small>&nbsp;&nbsp;: &nbsp; 
                <?php 
                    //echo Yii::$app->formatter->asDate($permohonan->checkDateLetter, 'php:d M Y');
                    echo $permohonan->checkDateLetter;
                ?>
            </small></td>  
        </tr>
    </table> 
</div>  

<!--<div style="background-image: url(<? $qrCode->writeDataUri(); ?>);background-repeat: no-repeat;  background-attachment: fixed; background-position: right;"> -->
<div> 
    <div style="margin-bottom: 10px; ">
        <b><?= strtoupper($permohonan->biodata->displayGelaran.' '.$permohonan->biodata->CONm) ?></b><br/>
        <?= ucwords($permohonan->biodata->jawatan->nama) ?><br/>
        <?= ucwords($permohonan->biodata->displayDepartment) ?><br/> 
    </div>
    
    <div style="margin-bottom: 10px; ">
        Tuan/Puan,   
    </div>

    <div style="margin-bottom: 10px; text-align:justify">
        <b>STATUS PERMOHONAN PROGRAM PEMBANGUNAN PROFESIONAL ANJURAN LUAR
        <br/>TAJUK KURSUS : <?= strtoupper($permohonan->namaProgram) ?></b>
    </div>

    <div style="margin-bottom: 10px; ">
        Dengan hormatnya, perkara di atas adalah dirujuk.   
    </div>
    
    <div style="margin-bottom: 10px; text-align:justify">
        <table class="table2">
            <tr class="table2"><td class="table2"><b>Tajuk Kursus</b></td><td class="table2"><?= strtoupper($permohonan->namaProgram) ?></td></tr>
            <tr class="table2"><td class="table2"><b>Tarikh </b></td><td class="table2"><?= strtoupper($permohonan->displayDateLetter);?></td></tr>
            <tr class="table2"><td class="table2"><b>Tempat</b></td><td  class="table2"><?= strtoupper($permohonan->lokasi);?></td></tr>
        </table>
    </div>  
</div> 
<br/>

<div style="margin-bottom: 10px; text-align:justify"> 
    1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mohon kerjasama pihak Tuan/Puan untuk mengisi Borang Penilaian Keberkesanan Progam
Pembangunan Profesional di HR-Online (pilih pautan Individual Development Plan-IDP) selepas
program tamat. Sebarang pertanyaan berkenaan perkara ini sila hubungi <?= $permohonan->displayUrusetia ?>

<br/><br/>Segala kerjasama dan perhatian Tuan/Puan berhubung perkara ini amatlah dihargai dan didahului dengan
ucapan ribuan terima kasih.

</div>

<br/>
<div style="margin-bottom: 10px; text-align:justify">
            Saya Yang Menjalankan Amanah,
            <br/><br/>
            <strong><?= $permohonan->displayPegawaiLatihan(1) ?></strong><br/> 
            <?= $permohonan->displayPegawaiLatihan(4) ?><br/>
                b.p Pendaftar<br/> 

                No. Tel	: 088320000 samb. <?= $permohonan->displayPegawaiLatihan(2) ?><br/>
                No. Faks : 088320243 / 320651<br/>
                Emel : <?= $permohonan->displayPegawaiLatihan(3) ?><br/>
                <?php
            ?>
            s.k: - Pendaftar<br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <?= $permohonan->displayCommentary(1) ?><br/> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <?= $permohonan->displayCommentary(2) ?><br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <?= $permohonan->displayCommentary(3) ?><br/> 
        
</div>

<br/><br/>
<div style="margin-bottom: 5px; text-align:center">
    <b><small>SURAT INI ADALAH CETAKAN KOMPUTER DAN TIDAK MEMERLUKAN TANDATANGAN</small></b> 
</div>

    <?php  }?>


