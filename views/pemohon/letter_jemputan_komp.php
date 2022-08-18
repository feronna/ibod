<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 25px;font-size: 11px">
    <table>
        <tr>
            <td><small>Rujukan</small></td>
            <td><small>&nbsp;&nbsp;: &nbsp;UMS/PEND2.2/500-2/5/<?= $komp->ref_no; ?></small></td>
        </tr>
        <tr>
            <td><small>Tarikh</small></td>
            <td><small>&nbsp;&nbsp;: &nbsp;<?= $komp->iklan->getTarikh($komp->tarikh_srt); ?></small></td>  
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
    <b> JEMPUTAN MENGHADIRI UJIAN <?= strtoupper($komp->title_komp); ?> BAGI JAWATAN <?= strtoupper($komp->iklan->jawatan->fname); ?></b><br/>
</div>



<div style="margin-bottom: 10px; text-align:justify;">
    Dengan hormatnya perkara di atas adalah dirujuk.
</div>

<?php
if ($komp->iklan->jawatan->fname == '(N41) Penolong Pendaftar') {
    $komp->iklan->jawatan->fname = '(N41) Pegawai Tadbir';
}

if ($komp->iklan->jawatan->fname == '(J41) Jurutera') {
    $komp->iklan->jawatan->fname = '(J41) Jurutera/Juruukur Bahan/Arkitek';
}

if ($komp->iklan->jawatan->fname == '(N29) Setiausaha Pejabat') {
    $komp->iklan->jawatan->fname = '(N29) Pembantu Khas/Pembantu Setiausaha Pejabat/Setiausaha Pejabat';
}

if ($komp->iklan->jawatan->fname == '(W19) Pembantu Tadbir Kewangan') {
    $komp->iklan->jawatan->fname = '(W19) Pembantu Tadbir Kewangan/Pembantu Akauntan';
}

if ($komp->iklan->jawatan->fname == '(UD43) Pegawai Perubatan') {
    $komp->iklan->jawatan->fname = '(UD43/UD44, UD47/UD48, UD51/UD52, UD53/UD54) Pegawai Perubatan';
}
?>
<div style="margin-bottom: 15px; text-align:justify;">
    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sukacita dimaklumkan bahawa tuan/puan adalah dipelawa untuk menghadiri ujian tersebut yang akan diadakan pada ketetapan berikut: 
</div>

<div style="margin-bottom: 10px; text-align:justify;"> 
    <table border="0" style="width:100%">
        <tr>
            <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tarikh</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?= $komp->iklan->getTarikh($komp->tarikh_komp); ?></b></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Masa</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?= strtoupper($komp->masa_komp); ?></b></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                
            </td>
        </tr> 
    </table>
</div>

<div style="position: absolute; left:30.5%; bottom: 45%; width: 59%"><b> 
                             <?= $komp->tempat_komp; ?> 
                    </b>
</div>
<div style="margin-bottom: 15px; text-align:justify;"><br/><br/><br/>
    3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sehubungan dengan itu, tuan/puan dikehendaki untuk membawa <b><?= $komp->desc_komp; ?></b>.
</div>

<div style="margin-bottom: 15px; text-align:justify;">
    4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kerjasama tuan/puan adalah dipohon untuk memberi maklum balas kehadiran melalui sistem HROnline v4.0 selewat-lewatnya pada <b><?= $komp->iklan->getTarikh($komp->tarikh_maklumbalas); ?> (<?= $komp->hari_maklumbalas; ?>)</b>. <br/><br/>
</div>  

<div style="margin-bottom: 15px; text-align:justify;">
    Sekian, terima kasih.<br/><br/> 
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
