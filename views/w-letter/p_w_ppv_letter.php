<?php ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 15px;font-size: 11px">
    <table>
        <tr>
            <td><small>Rujukan Kami</small></td>
            <td><small>&nbsp;&nbsp;: &nbsp;UMS/PEND2.2/500 – 5/3/103</small></td>
        </tr>
        <tr>
            <td><small>Tarikh</small></td>
            <td><small>&nbsp;&nbsp;: &nbsp; <?= $permohonan->biodata->getTarikh(Yii::$app->formatter->asDate($permohonan->tarikh_notifikasi)); ?></small></td>  
        </tr>
    </table> 
</div>   
 
    <div style="margin-bottom: 10px; ">
        <b>KEPADA YANG BERKENAAN</b>  <br/>
        Tuan/Puan,   
    </div> 
 
    <div style="margin-bottom: 10px; text-align:justify">
        <b>ARAHAN UNTUK HADIR BERTUGAS DI PUSAT PEMBERIAN VAKSIN (PPV) IPT-UMS   </b>
    </div>

    <div style="margin-bottom: 10px; text-align:justify">
        Dengan segala hormatnya perkara di atas adalah dirujuk.
    </div> 

<div style="margin-bottom: 10px; text-align:justify">  
    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    Adalah dimaklumkan bahawa <b><?= strtoupper($permohonan->biodata->CONm); ?>, <?= $permohonan->biodata->jawatan->nama; ?> (<?= $permohonan->biodata->jawatan->gred; ?>)</b> telah mendapat kad <?= $permohonan->findCardColor($permohonan->biodata->ICNO); ?> melalui sistem penilaian risiko individu UMS Shields. Beliau telah diarahkan bertugas pada <b><?= $permohonan->biodata->getTarikh(Yii::$app->formatter->asDate($permohonan->StartDate)); ?></b> dan masa <b><?= $permohonan->StartTime; ?></b>  di PPV IPT-UMS.
  </div>

<div style="margin-bottom: 10px; text-align:justify">
    3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pihak Universiti mempunyai <i>standard operating procedure</i> (SOP) yang telah dikuatkuasakan
    oleh Pengurusan tertinggi universiti bagi memastikan penyebaran Virus COVID-19 dalam kampus
    universiti adalah terkawal melibatkan semua kakitangan atau pelawat yang keluar dan memasuki
    kawasan UMS seperti sekatan pemeriksaan/saringan kesihatan di pintu masuk UMS.
</div>

<div style="margin-bottom: 10px; text-align:justify"> 
    4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sehubungan itu, pihak kami mengesahkan bahawa kakitangan ini dibenarkan bertugas
    sepanjang tempoh yang dinyatakan pada Perenggan 2 sahaja dan akan mematuhi peraturan yang
    ditetapkan oleh pihak Pengurusan Tertinggi Universiti serta pihak berkuasa. 
</div>  

<div style="margin-bottom: 10px; text-align:justify">
    <small>Sebarang pertanyaan dan pengesahan boleh menghubungi pegawai yang bertugas seperti berikut :</small>
</div>  

<div style="margin-bottom: 10px; text-align:justify;"> 

    <p align="center"> <small>
            <b>Puan Sharifah Rofidah Habib Hasan</b> <br/> 
            Penolong Pendaftar, Bahagian Sumber  Manusia <br/> 
            HP: 019-892 2449/ emel: shfidah@ums.edu.my 
            <br/>  
        </small></p> 
    <p align="center"> <small>
             <b>Encik Sirahim Abdullah</b> <br/> 
            Timbalan Pendaftar, Pusat Penataran Ilmu dan Bahasa <br/>
            HP: 016-839 3100/ emel: rhm3112@ums.edu.my <br/>
        </small></p>

</div>

<div style="margin-bottom: 10px; text-align:justify">
    Sekian, terima kasih.
</div> 

<div style="margin-bottom: 10px; text-align:justify">
    <!--<strong>PRIHATIN RAKYAT: DARURAT MEMERANGI COVID-19</strong><br/> <br/> <br/>--> 
    <?php 
        $pn = $permohonan->Pendaftar();
        ?>
        <small>Saya Yang Menjalankan Amanah,<br/><br/>  <strong><?= $pn ? $pn->CONm : 'Tiada Maklumat'; ?></strong><br/> 
            Pendaftar<br/>
            b.p Naib Canselor<br/><br/>
            <?php $peg = $permohonan->Pegawai(); ?>
            No. Telefon	: 088-320000 samb. samb <?= $peg->kakitangan ? $peg->kakitangan->COOUCTelNo : 'Tiada Maklumat'; ?> (<?= $peg->kakitangan ? $peg->kakitangan->gelaran->Title : 'Tiada Maklumat'; ?>&nbsp;<?= $peg->kakitangan ? ucwords(strtolower($peg->kakitangan->CONm)) : 'Tiada Maklumat'; ?>)<br/>
            Alamat e-mel : <?= $peg->kakitangan ? $peg->kakitangan->COEmail : 'Tiada Maklumat'; ?><br/> 
            s.k: - Ketua JAFPIB<br/> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Ketua Bahagian Sumber Manusia<br/> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Fail<br/>
        </small>
</div>

<div style="margin-bottom: 5px; text-align:center">
    <b><small>SURAT INI ADALAH CETAKAN KOMPUTER,TANDATANGAN TIDAK DIPERLUKAN</small></b> 
</div>   
