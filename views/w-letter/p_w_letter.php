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
<p align="right">
    <?php

    use Da\QrCode\QrCode;

$qrCode = (new QrCode('https://registrar.ums.edu.my/directory/web/site/pkp?id=' . $permohonan->id))
            ->setSize(100)
            ->setMargin(5)
            ->useForegroundColor(51, 153, 255);
    header('Content-Type: ' . $qrCode->getContentType());
    ?>
</p>

<div style="background-image: url(<?= $qrCode->writeDataUri(); ?>);background-repeat: no-repeat;  background-attachment: fixed; background-position: right;"> 
    <div style="margin-bottom: 10px; ">
        <b>KEPADA YANG BERKENAAN</b>  <br/>
        Tuan/Puan,   
    </div> 
    <?php $esurat = $permohonan->Pegawai(); ?> 

    <div style="margin-bottom: 10px; text-align:justify; width: 75%">
        <b><?= $esurat->title; ?> <br/></b>
    </div>

    <div style="margin-bottom: 10px; text-align:justify">
        Dengan segala hormatnya perkara di atas adalah dirujuk.
    </div>  
</div> 

<div style="margin-bottom: 10px; text-align:justify">  
    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Selaras dengan surat dari Jabatan Pendaftar [Ruj: UMS(S)/PEND2.1/100-1/9/2] bertarikh <?= $permohonan->biodata->getTarikh(Yii::$app->formatter->asDate($esurat->tarikh_AP)); ?> maka adalah dimaklumkan bahawa  <b><?= strtoupper($permohonan->biodata->CONm); ?>, <?= $permohonan->biodata->jawatan->nama; ?> (<?= $permohonan->biodata->jawatan->gred; ?>)</b> di <b><?= $permohonan->biodata->department->fullname; ?></b> UMS telah mendapat kad <?= $permohonan->findCardColor($permohonan->biodata->ICNO); ?> melalui sistem penilaian risiko individu  UMS Shields.  Beliau telah diarahkan
    untuk bertugas pada 
    <?php if ($title == 'Baru') { ?>
        <?= $permohonan->biodata->getTarikh(Yii::$app->formatter->asDate($permohonan->StartDate)); ?> hingga <?= $permohonan->biodata->getTarikh(Yii::$app->formatter->asDate($permohonan->EndDate)); ?>
    <?php } else { ?>
        <?= $permohonan->biodata->getTarikh(Yii::$app->formatter->asDate($permohonan->StartDate)); ?> hingga <?= $permohonan->biodata->getTarikh(Yii::$app->formatter->asDate($permohonan->EndDate)); ?>
    <?php } ?>
    bagi melaksanakan
    tugas yang perlu diselesaikan dengan segera dan mustahak. 
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
<?php
if ($title == 'Baru') {
    if ($permohonan->veh_status) {
        if ($permohonan->veh_driver) {
            ?>
            <div style="margin-bottom: 10px; text-align:justify"> 
                5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Untuk makluman, kakitangan ini <b><?= strtoupper($permohonan->biodata->CONm); ?></b>, perlu dihantar ke tempat bertugas kerana beliau <?= $permohonan->kekangan->name; ?> dan nama pemandu tersebut adalah <b><?= strtoupper($permohonan->veh_driver); ?></b>, No. K/P <b><?= strtoupper($permohonan->veh_driver_icno ? $permohonan->veh_driver_icno : ''); ?></b>.
            </div>
            <?php
        } else {
            ?>
            <div style="margin-bottom: 10px; text-align:justify"> 
                5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Untuk makluman, kakitangan ini <b><?= strtoupper($permohonan->biodata->CONm); ?> </b>, perlu dihantar ke tempat bertugas kerana beliau <?= $permohonan->kekangan->name; ?>.
            </div>

            <?php
        }
    }
}
?>
<div style="margin-bottom: 10px; text-align:justify">
    <small>Sebarang pertanyaan dan pengesahan boleh menghubungi pegawai yang bertugas seperti berikut :</small>
</div>  

<div style="margin-bottom: 10px; text-align:justify;"> 

    <p align="center"> <small>
            <b><?= $esurat->kakitangan ? $esurat->kakitangan->gelaran->Title : 'Tiada Maklumat'; ?>&nbsp;<?= $esurat->kakitangan ? ucwords(strtolower($esurat->kakitangan->CONm)) : 'Tiada Maklumat'; ?></b> <br/>
            <?= $esurat->kakitangan ? $esurat->kakitangan->jawatan->nama : 'Tiada Maklumat'; ?>&nbsp;(<?= $esurat->kakitangan ? $esurat->kakitangan->jawatan->gred : 'Tiada Maklumat'; ?>)<br/>
            Bahagian Sumber Manusia, Jabatan Pendaftar <br/>
            088 320000 samb. <?= $esurat->kakitangan ? $esurat->kakitangan->COOUCTelNo : 'Tiada Maklumat'; ?>/ <?= $esurat->kakitangan ? $esurat->kakitangan->COHPhoneNo : 'Tiada Maklumat'; ?> <br/>
            <br/>  
        </small></p> 
    <p align="center"> <small>
            <?php $peg = $permohonan->Pegawai2(); ?>
            <b><?= $peg->kakitangan ? $peg->kakitangan->gelaran->Title : 'Tiada Maklumat'; ?>&nbsp;<?= $peg->kakitangan ? ucwords(strtolower($peg->kakitangan->CONm)) : 'Tiada Maklumat'; ?></b> <br/>
            <?= $peg->kakitangan ? $peg->kakitangan->jawatan->nama : 'Tiada Maklumat'; ?>&nbsp;(<?= $peg->kakitangan ? $peg->kakitangan->jawatan->gred : 'Tiada Maklumat'; ?>)<br/>
            Bahagian Sumber Manusia, Jabatan Pendaftar <br/> 
            088 320000 samb. <?= $peg->kakitangan ? $peg->kakitangan->COOUCTelNo : 'Tiada Maklumat'; ?>/ <?= $peg->kakitangan ? $peg->kakitangan->COHPhoneNo : 'Tiada Maklumat'; ?>
        </small></p>

</div>

<div style="margin-bottom: 10px; text-align:justify">
    Sekian, terima kasih.
</div> 

<div style="margin-bottom: 10px; text-align:justify"> 
    <?php
    if ($permohonan->ICNO == $permohonan->isChiefBsm()) {
        $pn = $permohonan->Pendaftar();
        ?>
        <small>Saya Yang Menjalankan Amanah,<br/> <strong><?= $pn ? $pn->CONm : 'Tiada Maklumat'; ?></strong><br/> 
            Pendaftar<br/>

            No. Tel	: 088-320000 samb. <?= $pn ? $pn->COOUCTelNo : 'Tiada Maklumat'; ?><br/>
            No. Faks : <?= $pn ? $pn->department->fax_no : 'Tiada Maklumat'; ?><br/>
            Emel : <?= $pn ? $pn->COEmail : 'Tiada Maklumat'; ?><br/>
            <?php
        } else {
            $bsm = $permohonan->Bsm();
            ?>
            <small>Saya Yang Menjalankan Amanah,<br/> <strong><?= $bsm ? $bsm->CONm : 'Tiada Maklumat'; ?></strong><br/> 
                Ketua Bahagian Sumber Manusia<br/>
                B.p Pendaftar<br/> 

                No. Tel	: 088-320000 samb. <?= $bsm ? $bsm->COOUCTelNo : 'Tiada Maklumat'; ?><br/>
                No. Faks : <?= $bsm ? $bsm->department->fax_no : 'Tiada Maklumat'; ?><br/>
                Emel : <?= $bsm ? $bsm->COEmail : 'Tiada Maklumat'; ?><br/>
                <?php
            }
            ?>
            s.k: - Pendaftar<br/> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Ketua Bahagian Keselamatan<br/> 
        </small>
</div>

<div style="margin-bottom: 5px; text-align:center">
    <b><small>SURAT INI ADALAH CETAKAN KOMPUTER,TANDATANGAN TIDAK DIPERLUKAN</small></b> 
</div>   
