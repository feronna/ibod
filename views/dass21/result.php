<?php

function color_d($score) {
    switch($score){
    case($score >= 14):
        return $color = 'progress-bar-danger';
    case($score >= 11):
        return $color = 'progress-bar-danger';
    case($score >= 7):
        return $color = 'progress-bar-primary';
    case($score >= 5):
        return $color = 'progress-bar-info';
    case($score >= 0):
        return $color = 'progress-bar-success';
}
};

function color_a($score) {
    switch($score){
    case($score >= 10):
        return $color = 'progress-bar-danger';
    case($score >= 8):
        return $color = 'progress-bar-danger';
    case($score >= 6):
        return $color = 'progress-bar-primary';
    case($score >= 4):
        return $color = 'progress-bar-info';
    case($score >= 0):
        return $color = 'progress-bar-success';
}
};

function color_s($score) {
    switch($score){
    case($score >= 17):
        return $color = 'progress-bar-danger';
    case($score >= 13):
        return $color = 'progress-bar-danger';
    case($score >= 10):
        return $color = 'progress-bar-primary';
    case($score >= 8):
        return $color = 'progress-bar-info';
    case($score >= 0):
        return $color = 'progress-bar-success';
}
};

/* @var $this yii\web\View */
use yii\helpers\Html;
?>

<div class="row">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['dass21/index']) ?></li>
        <li>Keputusan / Results</li>
    </ol>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>DASS-21 Keputusan Penilaian / Assessment Results</strong></h2>
            
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
                    <td><?= $result->created_dt; ?></td>
                </tr>
            </table>
            
            <div class="ln_solid"></div>
            
            <ul>
                <li>
                    Skala Kemurungan / Depression Scale : <strong><?= $d_msg; ?></strong>
                </li>
            </ul>
            
            <div class="progress">
                <div class="progress-bar <?=color_d($result->skor_d)?>" role="progressbar" aria-valuenow="<?= $result->skor_d?>" aria-valuemin="0" aria-valuemax="21" style="width: <?= (($result->skor_d/21)*100).'%;'?>">
                    <?= $result->skor_d.'/21'?>
                </div>
            </div>
            
            <ul>
                <li>
                    Skala Kebimbangan / Anxiety Scale : <strong><?= $a_msg; ?></strong>
                </li>
            </ul>
            
            <div class="progress">
                <div class="progress-bar <?=color_a($result->skor_a)?>" role="progressbar" aria-valuenow="<?= $result->skor_a?>" aria-valuemin="0" aria-valuemax="21" style="width: <?= (($result->skor_a/21)*100).'%;'?>">
                    <?= $result->skor_a.'/21'?>
                </div>
            </div>
            
            <ul>
                <li>
                    Skala Tekanan / Stress Scale : <strong><?= $s_msg; ?></strong>
                </li>
            </ul>
            
            <div class="progress">
                <div class="progress-bar <?=color_s($result->skor_s)?>" role="progressbar" aria-valuenow="<?= $result->skor_s?>" aria-valuemin="0" aria-valuemax="21" style="width: <?= (($result->skor_s/21)*100).'%;'?>">
                    <?= $result->skor_s.'/21'?>
                </div>
            </div>
            <div class="table-responsive">
            <table class="table">
                <tr>
                    <th></th>
                    <th class="text-center">KEMURUNGAN / DEPRESSION</th>
                    <th class="text-center">KEBIMBANGAN / ANXIETY</th>
                    <th class="text-center">STRESS / TEKANAN</th>
                </tr>
                <tr>
                    <td align="right">NORMAL</td>
                    <td align="center">0 - 4</td>
                    <td align="center">0 - 3</td>
                    <td align="center">0 - 7</td>
                </tr>
                <tr>
                    <td align="right">RINGAN / MILD</td>
                    <td align="center">5 - 6</td>
                    <td align="center">4 - 5</td>
                    <td align="center">8 - 9</td>
                </tr>
                <tr>
                    <td align="right">SEDERHANA / MODERATE</td>
                    <td align="center">7 - 10</td>
                    <td align="center">6 - 7</td>
                    <td align="center">10 - 12</td>
                </tr>
                <tr>
                    <td align="right">TERUK / SEVERE</td>
                    <td align="center">11 - 13</td>
                    <td align="center">8 - 9</td>
                    <td align="center">13 - 16</td>
                </tr>
                <tr>
                    <td align="right">SANGAT TERUK / EXTREMELY SEVERE</td>
                    <td align="center">14+</td>
                    <td align="center">10+</td>
                    <td align="center">17+</td>
                </tr>
            </table>
            </div>
            <div class="ln_solid"></div>
            
            <p>
            <ul><strong>PENAFIAN</strong>
                    <li>DASS21 ADALAH UNTUK TUJUAN SARINGAN UMUM SIMPTOM-SIMPTOM STRES, KEBIMBANGAN DAN KEMURUNGAN SAHAJA</li>
                    <li>UJIAN DASS21 BUKAN UNTUK TUJUAN MENDIAGNOSIS PENYAKIT MENTAL</li>
                    <li>BAGI SKOR SEDERHANA DAN KE ATAS PERLU BERJUMPA DENGAN KAUNSELOR UNTUK PERBINCANGAN LANJUT</li>
                </ul>
            </p>
        </div>
    </div></div>
</div>