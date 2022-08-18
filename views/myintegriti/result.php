<?php

function color_d($score) {
    switch($score){
    case($score < 50):
        return $color = 'progress-bar-danger';
    case($score < 80):
        return $color = 'progress-bar-warning';
    case($score < 85):
        return $color = 'progress-bar-info';
    case($score <= 100):
        return $color = 'progress-bar-success';
}
};

function status($score) {
    switch($score){
    case($score < 2.5):
        return $color = 'Lemah';
    case($score < 4):
        return $color = 'Biasa';
    case($score < 4.25):
        return $color = 'Baik';
    case($score <= 5):
        return $color = 'Cemerlang';
}
};

/* @var $this yii\web\View */
use yii\helpers\Html;
?>

<div class="row">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['myintegriti/index']) ?></li>
		<li>Borang Soal Selidik MyIntegriti UMS</li>
        <li>Terima Kasih</li>
    </ol>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Terima kasih di atas kerjasama yang diberikan bagi menjawab soal-selidik ini.</strong></h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            
            <table class="table table-sm table-bordered">
                <tr>
                    <td width="15%"><strong>Nama Pegawai</strong></td>
                    <td><?= $bio->CONm; ?></td>
                </tr>
                <tr>
                    <td><strong>No. KP / Pasport</strong></td>
                    <td><?= $bio->ICNO; ?></td>
                </tr>
                <tr>
                    <td><strong>JSPIU</strong></td>
                    <td><?= $result->department->fullname; ?></td>
                </tr>
                <tr>
                    <td><strong>Jawatan / Gred</strong></td>
                    <td><?= $result->jawatan->nama; ?> / <?= $result->jawatan->gred; ?></td>
                </tr>
                <tr>
                    <td><strong>Tarikh / Masa</strong></td>
                    <td><?= app\models\myintegriti\TblPenilaian::fdate($result->created_dt); ?></td>
                </tr>
            </table>
            
			<hr>
            
            <ul>
                <li>
                    Amanah : <strong></strong>
                </li>
            </ul>
            
            <div class="progress">
                <div class="progress-bar <?=color_d(($result->amanah/5)*100)?>" role="progressbar" aria-valuenow="<?= $result->amanah?>" aria-valuemin="0" aria-valuemax="21" style="width: <?= (($result->amanah/5)*100).'%;'?>">
                    <?= status($result->amanah)?>
                </div>
            </div>
                        
             <ul>
                <li>
                    Bijaksana : <strong></strong>
                </li>
            </ul>
            
            <div class="progress">
                <div class="progress-bar <?=color_d(($result->bijaksana/5)*100)?>" role="progressbar" aria-valuenow="<?= $result->bijaksana?>" aria-valuemin="0" aria-valuemax="21" style="width: <?= (($result->bijaksana/5)*100).'%;'?>">
                    <?= status($result->bijaksana)?>
                </div>
            </div>

            <ul>
                <li>
                    Hemah : <strong></strong>
                </li>
            </ul>
            
            <div class="progress">
                <div class="progress-bar <?=color_d(($result->bijaksana/5)*100)?>" role="progressbar" aria-valuenow="<?= $result->hemah?>" aria-valuemin="0" aria-valuemax="21" style="width: <?= (($result->hemah/5)*100).'%;'?>">
                    <?= status($result->hemah)?>
                </div>
            </div>

            <ul>
                <li>
                    Indeks Berintegriti : <strong></strong>
                </li>
            </ul>
            
            <div class="progress">
                <div class="progress-bar <?=color_d($result->indeks_integriti)?>" role="progressbar" aria-valuenow="<?= $result->indeks_integriti?>" aria-valuemin="0" aria-valuemax="21" style="width: <?= ($result->indeks_integriti).'%;'?>">
                    <?= $result->indeks_integriti.'%'?>
                </div>
            </div>
<?php 
/*
<div class="table-responsive col-xs-12 col-md-12 col-lg-10">
            <table class="table">
                <tr>
                    <th class="text-center">TAHAP</th>
                    <th class="text-center">JULAT SKOR PURATA NILAI INTEGRITI</th>
                </tr>
                <tr>
                    <td align="center">CEMERLANG</td>
                    <td align="center">4.25 dan ke atas (85% hingga 100%)</td>
                </tr>
                <tr>
                    <td align="center">BAIK</td>
                    <td align="center">4.00 - 4.24 (80% hingga 84%)</td>
                </tr>
                <tr>
                    <td align="center">BIASA</td>
                    <td align="center">2.50 - 3.99 (50% hingga 79%)</td>
                </tr>
                <tr>
                    <td align="center">LEMAH</td>
                    <td align="center">Bawah daripada 2.50 (rendah daripada 50%</td>
                </tr>
            </table>
            </div>
            <div class="ln_solid"></div>
*/
?>
        </div>
		<div class="ln_solid"></div>
            
                <i style="font-size:16px">* Sumber instrumen daripada MyIntegrity (Ezhar, Hanina, Azimi & Amini, 2012) dan Alat Ukuran Budaya Kerja Staf Universiti (UPM, 2017).</i>
<div class="ln_solid"></div>
    </div></div>
</div>