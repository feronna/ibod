<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\helpers\Url;

?>

<div class="row">
<?php
NavBar::begin();
    echo Nav::widget([
        'items' => [
            [
                'label' => 'Laman Utama',
                'url' => "".Url::to(['lppums/index'])."",
                //'linkOptions' => [...],
            ],
            [
                'label' => 'Borang LPP',
                'url' => "".Url::to(['lppums/borang-lpp'])."",
                /*'items' => [
                     ['label' => 'Saranan Kerja Tahunan', 'url' => "".Url::to(['skt/maklumat-pegawai']).""],
                     //'<div class="dropdown-divider"></div>',
                     //'<div class="dropdown-header">Dropdown Header</div>',
                     ['label' => 'Laporan Nilai Prestasi Tahunan', 'url' => '#'],
                ],*/
            ],
            [
                'label' => 'Panduan Pengisian Borang',
                'url' => ['site/login'],
                //'visible' => Yii::$app->user->isGuest
            ],
            [
                'label' => 'Senarai PYD',
                'url' => "".Url::to(['lppums/senarai-pyd'])."",
                //'visible' => Yii::$app->user->isGuest
            ],
            [
                'label' => 'Pengurusan',
                'items' => [
                     ['label' => 'Penetapan Akses', 'url' => "".Url::to(['lppums/penetapan-akses-sistem']).""],
                     //'<div class="dropdown-divider"></div>',
                     //'<div class="dropdown-header">Dropdown Header</div>',
                     ['label' => 'Penetapan Pegawai Penilai', 'url' => "".Url::to(['lppums/penetapan-pegawai-penilai']).""],
                     ['label' => 'Carian Borang LNPT', 'url' => "".Url::to(['lppums/carian-borang-lpp']).""],
                     ['label' => 'Pengurusan Tahun Penilaian', 'url' => "".Url::to(['lppums/pengurusan-tahun-penilaian']).""],
                     ['label' => 'Reset LPP', 'url' => "".Url::to(['lppums/reset-borang-lpp']).""],
                     ['label' => 'Buka Borang LPP untuk pengisian', 'url' => "".Url::to(['lppums/buka-pengisian-borang']).""],
                     ['label' => 'Laporan', 'url' => "#"],
                     ['label' => 'Pengurusan Cadangan APC', 'url' => "#"],
                ],
                //'visible' => Yii::$app->user->isGuest
            ],
        ],
        'options' => ['class' => 'navbar-nav'],
    ]);
NavBar::end();
?>
</div>

<br>