<?php
$name = strtolower($kj->chiefBiodata->CONm);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<br>
<br>
<br>
<br>
<div style="margin-bottom: 15px;font-size: 20px">
    <table>
        <tr>
            <td><b><small>Ruj. Kami</small></b>
                <small>&nbsp;&nbsp;: UMS/PEND2.2/500 – 3/1/2</small>
            </td>
        </tr>
        <h3>
            <tr>
                <td><strong><small>Tarikh</small></strong>
                    <small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= Yii::$app->MP->Tarikh($model->lulus_dt); ?></small>
                </td>
            </tr>
            <br>
            <br>
            <tr>
                <td><strong><?= strtoupper($model->kakitangan->gelaran->Title . ' ' . $model->kakitangan->CONm) ?></strong></td>

            </tr>
            <tr>
                <td><?= $model->kakitangan->jawatan->nama ?></td>
            </tr>
            <tr>
                <td><?= $model->kakitangan->department->fullname ?></td>
            </tr>
        </h3>
    </table>
</div>


<div style="margin-bottom: 10px;font-size:15px; ">

    Puan,
</div>

<div style="margin-bottom: 10px; text-align:justify;font-size:15px;">
    <strong><?php echo $manage->title ?></strong><br />
</div>

<div style="margin-bottom: 10px; text-align:justify;font-size:15px;font-size:15px;">
    Dengan segala hormatnya perkara di atas adalah dirujuk.
</div>
</div>

<div style="margin-bottom: 10px; text-align:justify ;font-size:15px;">
    2.&nbsp;&nbsp;&nbsp;Adalah dimaklumkan bahawa permohonan Cuti Bersalin puan telah diluluskan berkuatkuasa mulai
    pada <?= Yii::$app->MP->Tarikh($model->start_date) ?> hingga <?= Yii::$app->MP->Tarikh($model->end_date) ?> iaitu selama <?= $model->tempoh ?> hari. Kelulusan diberi adalah selaras dengan terma dan
    syarat Kemudahan Cuti Bersalin Bagi Kakitangan Perkhidmatan Awam : Pekeliling Perkhidmatan
    Bilangan 5, Tahun 2017.

</div>

<div style="margin-bottom: 10px; text-align:justify;font-size:15px;">
    3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Berdasarkan rekod, puan telah menggunakan kemudahan Cuti Bersalin ini untuk kali <?= $total ?> bagi
    kelahiran anak <?= $child ?> sepanjang tempoh perkhidmatan dengan kerajaan dan baki kelayakkan
    kemudahan Cuti Bersalin puan seterusnya adalah <?= $bal ?> hari.
</div>

<div style="margin-bottom: 10px; text-align:justify;font-size:15px;">
    4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Surat makluman daripada ketua jabatan mengesahkan puan telah kembali bertugas setelah tamat
    tempoh Cuti Bersalin hendaklah dikemukakan kepada Bahagian Sumber Manusia (BSM).
</div>

<div style="margin-bottom: 10px; text-align:justify;font-size:15px;">
    Sekian, terima kasih.
</div>
<br />
<div style="margin-bottom: 10px; text-align:justify;font-size:14px;">
    <strong>"WAWASAN KEMAKMURAN BERSAMA 2030"</strong>
    <br />
    <br />

    <small>Saya yang menjalankan amanah,
        <br />
        <br />
        <b>[SURAT INI ADALAH CETAKAN KOMPUTER,TANDATANGAN TIDAK DIPERLUKAN ]</b>
        <br>
        <br>

        <strong style="font-size:15px;"><?php echo $manage->kakitangan->CONm ?></strong><br />
        <div style="margin-bottom: 10px; font-size:11px;">

            <?php echo $manage->kakitangan->jawatan->nama ?><br>
            b.p Pendaftar </br>
            <br>
            No. Tel : 088-320000 Samb. 102005<br />
            Alamat E-mel : <?php echo $manage->kakitangan->COEmail ?><br>
        </div>
</div>
<div style="margin-bottom: 10px; font-size:10px;">

    s.k:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☞ Pendaftar <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☞ <?= ucfirst($kj->chiefBiodata->gelaran->Title) . ' ' . ucwords($name,'. ') ?><br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☞ Cik Kamisah Binti Husin, Ketua, Bahagian Sumber Manusia<br>
    <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☞ Encik Samsuidin Bin Nurdin, Timbalan Pengarah, Hospital Universiti Malaysia Sabah<br> -->
</div>
</small>