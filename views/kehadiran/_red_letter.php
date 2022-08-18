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

<p><?= $biodata->gelaran->Title ?>,</p>

<p><strong>SURAT TUNJUK SEBAB KAD KEHADIRAN BERWARNA MERAH (<?= strtoupper(TblRekod::viewBulanBm(date("m"))) ?> <?= date("Y") ?>)</strong></p>

<p>Dengan segala hormatnya perkara di atas adalah dirujuk.</p>

<p style="text-align: justify;text-justify: inter-word;">
    02.&nbsp;&nbsp;&nbsp;Sehubungan itu, <?= $biodata->gelaran->Title ?> adalah dikehendaki untuk mengemukakan surat tunjuk sebab <strong>dalam tempoh dua (2) minggu</strong> dari tarikh surat ini dikeluarkan kepada pihak Bahagian Sumber Manusia (BSM) 
    bagi tarikh-tarikh ketidakpatuhan seperti dalam laporan yang dilampirkan bersama dan status ketidakpatuhan berkenaan seperti berikut;
</p>

<p  style="text-align: justify;text-justify: inter-word;">
<ol type="i">
    <li>Tiada rekod catatan semasa melakukan ketidakpatuhan atau sebelum 10 haribulan pada bulan berikutnya untuk pengesahan Pegawai Peraku (PPP)/Pegawai Pelulus (PPK).</li>

    <li>Alasan yang direkodkan tidak diterima oleh Pegawai Peraku (PPP)/Pegawai Pelulus (PPK).</li>
</ol>
</p>


<p style="text-align: justify;text-justify: inter-word;">
    03.&nbsp;&nbsp;&nbsp;Merujuk kepada kepada Garis Panduan Kehadiran Bekerja Melalui Sistem Kehadiran Atas Talian “Staff Attendance Recording System” (STARS) Universiti Malaysia Sabah (UMS) Tahun 2019 Perenggan 4.7 
    <i>Kakitangan yang gagal merekodkan kehadiran dan tidak berada di tempat kerja mengikut WBB yang diluluskan akan menerima notis peringatan daripada sistem untuk dikemaskini. Tindakan penahanan gaji, pemotongan emolumen dan tindakan tatatertib akan diambil sekiranya mendapat arahan daripada Ketua Jabatan serta kad warna menjadi merah</i>.
</p>

<p style="text-align: justify;text-justify: inter-word;">
    Perhatian <?= $biodata->gelaran->Title ?> dalam perkara ini amatlah dihargai dan diucapkan terima kasih.
</p>

<p style="text-align: justify;text-justify: inter-word;">
    Sekian.
</p>

<p><strong>“BERTEKAD CEMERLANG”</strong></p>

<p>Yang ikhlas,</p>
<p>[Surat ini adalah cetakan komputer dan tidak memerlukan tandatangan]</p>
<p>
    <strong>HAYATI SALLEH BAIHAKI</strong><br>
    Penolong Pendaftar Kanan<br>
    Seksyen Perkhidmatan<br>
    Bahagian Sumber Manusia<br>
    b/p Pendaftar
</p>

<p>
    No. Telefon : 088 320000 Ext : 1437/1058<br>
    No. Faks&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 088 320047

</p>

<p style="font-size: 9px">
    s.k &nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;Pendaftar<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;Ketua JFPIB<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;Fail Cuti PER UMSPEND2.2/500-3/1/2 (<?=$biodata->COOldID ?>)
</p>
<p style="font-size: 8px">
    HSB/PJ
</p>

