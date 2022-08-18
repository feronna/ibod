<?php

use app\models\kehadiran\TblRekod;

Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
Yii::$app->response->headers->add('Content-Type', 'application/pdf');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<p>
    <strong>No. Rujukan : UMS/PEND2.2/500-6/1/3</strong>
    <br>
    <strong>Tarikh :  <?php echo date("d") . ' ' . TblRekod::viewBulanBm(date("m")) . ' ' . date("Y") ?></strong>
</p>

<p style="padding-top: 5px">
    <strong><?php echo $biodata->CONm; ?></strong>
    <br>
    <strong><?php echo strtoupper($biodata->jawatan->fname); ?></strong>
    <br>
    <strong><?php echo strtoupper($biodata->department->fullname); ?></strong>
</p>

<p><?=$biodata->gelaran->Title?>,</p>

<p><strong>PEMAKLUMAN DAN PERINGATAN PERTUKARAN KAD BEKERJA KEPADA WARNA HIJAU</strong></p>

<p>Dengan segala hormatnya, perkara di atas adalah dirujuk.</p>

<p style="text-align: justify;text-justify: inter-word;">
    02.&nbsp;&nbsp;&nbsp;Adalah dimaklumkan bahawa kad pekerja <?=$biodata->gelaran->Title?> telah bertukar kepada warna hijau pada bulan ini disebabkan oleh terdapat tiga (3) atau lebih catatan 
    ketidakpatuhan yang tidak diperakukan/tidak diambil tindakan oleh Pegawai Peraku (PPP)/Pegawai Pelulus (PPK) <?=$biodata->gelaran->Title?> seperti di bawah :-
</p>

<table class="table table-sm table-bordered" style="font-size: 11px;">
    <tr style="background-color: #4CAF50;">
        <th class="text-center">BIL</th>
        <th class="text-center">TARIKH</th>
        <th class="text-center">REKOD MASUK</th>
        <th class="text-center">REKOD KELUAR</th>
        <th class="text-center">JENIS KESALAHAN</th>
        <th class="text-center">CATATAN</th>
    </tr>
    <?php foreach ($rekod as $rekods) { ?>
        <tr>
            <td class="text-center"  style="text-align:center"><?= $bil++; ?></td>
            <td class="text-center"  style="text-align:center"><?= $rekods->formatTarikh; ?></td>
            <td class="text-center"  style="text-align:center"><?= $rekods->formatTimeIn; ?></td>
            <td class="text-center"  style="text-align:center"><?= $rekods->formatTimeOut; ?></td>
            <td class="text-center"  style="text-align:center"><?= $rekods->statusAll; ?></td>
            <td class="text-center"  style="text-align:center"><?= $rekods->catatan; ?></td>
        </tr>
    <?php } ?>
</table>

<p style="text-align: justify;text-justify: inter-word;">
    03.&nbsp;&nbsp;&nbsp;Sehubungan dengan itu, <?=$biodata->gelaran->Title?> juga dikehendaki untuk mengemukakan surat tunjuk sebab punca kepada ketidakpatuhan kepada ketua jabatan <?=$biodata->gelaran->Title?> dan Bahagian Sumber Manusia selewat-lewatnya seminggu selepas tarikh surat ini dikeluarkan.
</p>

<p style="text-align: justify;text-justify: inter-word;">
    04.&nbsp;&nbsp;&nbsp;Pihak <?=$biodata->gelaran->Title?> adalah diingatkan agar mematuhi kehadiran waktu bekerja yang telah ditetapkan agar kad pekerja <?=$biodata->gelaran->Title?> tidak bertukar kepada warna merah pada bulan berikutnya bagi mengelakkan <?=$biodata->gelaran->Title?> dikenakan tindakan tatatertib. 
</p>

<p style="text-align: justify;text-justify: inter-word;">
    Kerjasama dan keprihatinan pihak <?=$biodata->gelaran->Title?> ke atas perkara ini saya dahului dengan ucapan terima kasih.
</p>

<p style="text-align: justify;text-justify: inter-word;">
    Sekian dan harap maklum.
</p>

<p><strong>“BERTEKAD CEMERLANG”</strong></p>

<p>Yang ikhlas,</p>

<p>
    <strong>HAYATI SALLEH BAIHAKI</strong><br>
    Penolong Pendaftar Kanan<br>
    Seksyen Perkhidmatan<br>
    Bahagian Sumber Manusia<br>
    b.p Pendaftar
</p>

<p style="font-size: 9px">
    s.k &nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;Pendaftar<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;Ketua JFPIB

</p>


