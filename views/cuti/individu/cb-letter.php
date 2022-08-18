<?php ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<br>
<br>
<br>
<br>
<div style="margin-bottom: 15px;font-size: 11px">
    <table>
        <tr>
            <td><small>Rujukan Kami</small>
            <small>&nbsp;&nbsp;: &nbsp;UMS/PEND2.2/500 – 3/1/2</small></td>
        </tr>
        </br>
        <tr>
            <td><small>Tarikh</small>
            <small>&nbsp;&nbsp;: &nbsp; <?= Yii::$app->MP->Tarikh($model->start_date); ?></small></td>
        </tr>
        </br>
        <tr>
            <td><strong><?= $model->kakitangan->gelaran->Title . ' ' . $model->kakitangan->CONm ?></strong></td>

        </tr>
        <tr>
            <td><?= $model->kakitangan->jawatan->nama ?></td>
        </tr>
        <tr>
            <td><?= $model->kakitangan->department->fullname ?></td>
        </tr>
    </table>
</div>


<div style="margin-bottom: 10px; ">

    Puan,
</div>

<div style="margin-bottom: 10px; text-align:justify">
<strong><?php echo $manage->title ?></strong><br />
</div>

<div style="margin-bottom: 10px; text-align:justify">
    Dengan segala hormatnya perkara di atas adalah dirujuk.
</div>
</div>

<div style="margin-bottom: 10px; text-align:justify">
    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adalah dimaklumkan permohonan Cuti Bersalin puan telah diluluskan berkuatkuasa mulai 
    pada <?=Yii::$app->MP->Tarikh($model->start_date) ?> hingga <?= Yii::$app->MP->Tarikh($model->end_date) ?> iaitu selama <?= $model->tempoh ?> hari. Kelulusan diberi adalah selaras dengan terma dan
    syarat Kemudahan Cuti Bersalin Bagi Kakitangan Perkhidmatan Awam : Pekeliling Perkhidmatan
    Bilangan 5, Tahun 2017.

</div>

<div style="margin-bottom: 10px; text-align:justify">
    3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Berdasarkan rekod, puan telah menggunakan kemudahan Cuti Bersalin ini untuk kali <?= $total ?> bagi
    kelahiran anak <?= $child ?> sepanjang tempoh perkhidmatan dengan kerajaan dan baki kelayakkan
    kemudahan Cuti Bersalin puan seterusnya adalah <?= $bal ?> hari.
</div>

<div style="margin-bottom: 10px; text-align:justify">
    4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Surat makluman daripada ketua jabatan mengesahkan puan telah kembali bertugas setelah tamat
    tempoh Cuti Bersalin hendaklah dikemukakan kepada Bahagian Sumber Manusia (BSM).
</div>

<div style="margin-bottom: 10px; text-align:justify">
    Sekian, terima kasih.
</div>

<div style="margin-bottom: 10px; text-align:justify">
    <strong>PRIHATIN RAKYAT: DARURAT MEMERANGI COVID-19</strong>
    <br />
    <br />

    <small>Saya Yang Menjalankan Amanah,
    <br />
    <br />
    <b>[SURAT INI ADALAH CETAKAN KOMPUTER,TANDATANGAN TIDAK DIPERLUKAN ]</b> 
    <br>
    <br>

     <strong><?php echo $manage->kakitangan->CONm ?></strong><br />
     <?php echo $manage->kakitangan->jawatan->nama ?><br>
        b.p Pendaftar </br>
<br>
        No. Tel : 088-320000 Samb. 101937<br />
        <?php echo $manage->kakitangan->COEmail ?><br>

        s.k: Encik Luqman Ridha Anwar, Pendaftar, Jabatan Pendaftar <br>
        ☞ Bendahari<br>
        ☞ Cik Kamisah Binti Husin, Ketua, Bahagian Sumber Manusia<br>
        ☞ Puan Wendy Binti Induk, Penolong Pendaftar Kanan, Jabatan Bendahari<br />
    </small>
</div>