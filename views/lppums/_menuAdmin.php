<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

NavBar::begin();
echo Nav::widget([
    'items' => [
        [
            'label' => 'Laman Utama',
            'url' => ['lppums/dashboard'],
        ],
        [
            'label' => 'Pengurusan',
            'items' => [
                [
                    'label' => 'Reset Borang',
                    'url' => ['lppums/reset-borang-lpp'],
                ],
                [
                    'label' => 'Buka Borang',
                    'url' => ['lppums/buka-borang-lpp'],
                ],
                [
                    'label' => 'Ketakakuran Staf <sup><span class="label label-success">Baru</span></sup>',
                    'url' => ['lppums/ketakakuran-staf'],
                ],
                [
                    'label' => 'Buang Borang',
                    'url' => ['lppums/padam-borang-lpp'],
                ],
                [
                    'label' => 'Penetapan Pegawai Penilai',
                    'url' => ['lppums/penetapan-pegawai-penilai'],
                ],
                [
                    'label' => 'Pendaftaran Penetap Penilai',
                    'url' => ['lppums/pendaftaran-penetap-penilai'],
                ],
                [
                    'label' => 'Pengurusan Tahun Penilaian',
                    'url' => ['lppums/pengurusan-tahun-penilaian'],
                ],
                [
                    'label' => 'Jana Laporan',
                    'url' => ['lppums/generate-report'],
                ],
                [
                    'label' => 'Jana Laporan V2',
                    'url' => ['lppums/generate-report-v2'],
                ],
                [
                    'label' => 'Cadangan APC',
                    'url' => ['lppums/pengurusan-cadangan-apc'],
                ],
            ]
        ],
        [
            'label' => 'Pemantauan',
            'items' => [
                [
                    'label' => 'Cuti Belajar',
                    'url' => ['lppums/senarai-cuti-belajar'],
                ],
                [
                    'label' => 'Carian Borang',
                    'url' => ['lppums/carian-borang-lpp'],
                ],
                [
                    'label' => 'Markah Borang',
                    'url' => ['lppums/markah-borang'],
                ],
                [
                    'label' => 'Pengesahan markah',
                    'url' => ['lppums/pengesahan-markah-borang'],
                ],
                [
                    'label' => 'Pantau Pergerakan Borang',
                    'url' => ['lppums/pantau-pergerakan-borang'],
                ],
            ]
        ],
        [
            'label' => 'Penetapan Akses Sistem',
            'url' => ['lppums/penetapan-akses-sistem'],
        ],
        [
            'label' => 'Panduan Pengisian Borang',
            'url' => ['lppums/panduan-pengisian-borang'],
        ],
        [
            'label' => 'Akses Sebagai <sup><span class="label label-warning">Beta</span></sup>',
            'format' => 'raw',
            'items' => [
                [
                    'label' => 'Penilai',
                    'url' => ['lppums/carian-borang-lpp-penilai'],
                ],
            ]
        ],
        [
            'label' => 'LNPK',
            'items' => [
                [
                    'label' => 'Carian Borang',
                    'url' => ['lnpk/carian-borang'],
                ],
            ]
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>