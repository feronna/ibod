<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 25px;font-size: 11px">
    <table>
        <tr>
            <td><small>Rujukan</small></td>
            <td><small>&nbsp;&nbsp;: &nbsp;UMS/PEND2.2/500-2/5/<?= $iv->ref_no; ?></small></td>
        </tr>
        <tr>
            <td><small>Tarikh</small></td>
            <td><small>&nbsp;&nbsp;: &nbsp;<?= $iv->iklan->getTarikh($iv->tarikh_srt); ?></small></td>  
        </tr>
    </table>
</div>
 
<div> 
    <b><?= ucwords(strtolower($biodata->CONm)); ?></b><br/> 
    <?= $biodata->jawatan->nama . " (" . $biodata->jawatan->gred . ")"; ?><br/> 
    <?= ucwords(strtolower($biodata->department->fullname)); ?><br/>  
    Universiti Malaysia Sabah.<br/> <br/> 
</div>
<div>
    Tuan/Puan,  
    <br/><br/> 
</div>

<div style="margin-bottom: 25px; ">
    <b> JEMPUTAN MENGHADIRI TEMUDUGA PENGAMBILAN KAKITANGAN PENTADBIRAN <br/><?= strtoupper($iv->bil_srt); ?></b><br/>
 </div>



<div style="margin-bottom: 10px; text-align:justify">
    Dengan hormatnya perkara di atas adalah dirujuk.
</div>
 
<?php
if ($iv->iklan->jawatan->fname == '(N41) Penolong Pendaftar') {
    $iv->iklan->jawatan->fname = '(N41) Pegawai Tadbir';
}

if ($iv->iklan->jawatan->fname == '(J41) Jurutera') {
    $iv->iklan->jawatan->fname = '(J41) Jurutera/Juruukur Bahan/Arkitek';
}

if ($iv->iklan->jawatan->fname == '(N29) Setiausaha Pejabat') {
    $iv->iklan->jawatan->fname = '(N29) Pembantu Khas/Pembantu Setiausaha Pejabat/Setiausaha Pejabat';
}

if ($iv->iklan->jawatan->fname == '(W19) Pembantu Tadbir Kewangan') {
    $iv->iklan->jawatan->fname = '(W19) Pembantu Tadbir Kewangan/Pembantu Akauntan';
}

if ($iv->iklan->jawatan->fname == '(UD43) Pegawai Perubatan') {
    $iv->iklan->jawatan->fname = '(UD43/UD44, UD47/UD48, UD51/UD52, UD53/UD54) Pegawai Perubatan';
}
?>
<div style="margin-bottom: 15px; text-align:justify;">
    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sukacita dimaklumkan bahawa tuan/puan adalah dipelawa untuk hadir ke Temuduga
    Pengambilan Kakitangan Pentadbiran <?= $iv->bil_srt; ?> bagi jawatan <b><?= $iv->iklan->jawatan->fname ?> </b>yang akan 
    <br/>diadakan pada ketetapan berikut:
</div>

<div style="margin-bottom: 10px; text-align:justify;"> 
    <table border="0" style="width:100%">
        <tr>
            <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tarikh</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?= $iv->iklan->getTarikh($iv->tarikh_iv); ?></b></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Masa</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?= $iv->masa_iv; ?></b></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?= $iv->tempat_iv; ?></b></td>
        </tr> 
    </table>
</div>


<div style="margin-bottom: 15px; text-align:justify;">
    3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sehubungan dengan itu, sila bawa <b>salinan asal sjil-sijil akademik / dokumen sokongan berkaitan dengan jawatan yang dipohon</b> pada hari temuduga.
</div>

<div style="margin-bottom: 15px; text-align:justify;">
    4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kerjasama tuan/puan adalah dipohon untuk memberi maklum balas kehadiran melalui sistem HROnline v4.0 selewat-lewatnya pada <b><?= $iv->iklan->getTarikh($iv->tarikh_maklumbalas); ?> (<?= $iv->hari_maklumbalas; ?>)</b>. <br/> 
</div>  

<div style="margin-bottom: 15px; text-align:justify;">
    Sekian, terima kasih.<br/><br/><br/> 
</div>

<div style="margin-bottom: 15px; text-align:justify;">
    <strong>ISMAIL LADAMA</strong><br/>
    Penolong Pendaftar<br/>
    Bahagian Sumber Manusia<br/>
    b.p Pendaftar<br/><br/>

    <small>No. Tel	: 088-320000 samb. 1444 (En. Ismail Ladama)<br/>
        No. Faks : 088-320047<br/>
        Emel : mail@ums.edu.my<br/><br/>
        <br/> 
</div>

<div style="margin-bottom: 5px; text-align:center;">
    <b><small>CETAKAN SURAT INI TIDAK MEMERLUKAN TANDATANGAN</small></b> 
</div> 
