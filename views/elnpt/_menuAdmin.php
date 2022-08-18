<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

NavBar::begin();
echo Nav::widget([
    'items' => [
        [
            'label' => 'Laman Utama',
            'url' => ['elnpt/dashboard'],
        ],
        [
            'label' => 'Utiliti',
            'items' => [
                [
                    'label' => 'Penetapan Tahun Penilaian',
                    'url' => ['elnpt/penetapan-tahun-penilaian'],
                ],
                [
                    'label' => 'Pendaftaran Penetap Penilai',
                    'url' => ['elnpt/pendaftaran-penetap-penilai?thn=2021'],
                ],
                // [
                //     'label' => 'Pengurusan Rubrik',
                //     'items' => [
                //         [
                //             'label' => 'Jabatan',
                //             'url' => ['elnpt/penetapan-rubrik-dept'],
                //         ],
                //         [
                //             'label' => 'Gred Jawatan',
                //             'url' => ['elnpt/penetapan-rubrik-gred'],
                //         ]
                //     ]
                // ],
                // [
                //     'label' => 'Tambah Kumpulan Department <sup><span class="label label-success">Baru</span></sup>',
                //     'url' => ['elnpt/tambah-kump-dept'],
                // ],
                // [
                //     'label' => 'Pembetulan Markah LNPT <sup><span class="label label-warning">2020</span></sup>',
                //     'url' => ['elnpt/fix-markah'],
                // ],
                // [
                //     'label' => 'Run Queue',
                //     'url' => ['elnpt/run-queue'],
                //     // 'visible' => (Yii::$app->user->identity->ICNO == '930807125121')
                // ],
            ]
        ],
        [
            'label' => 'Pemantauan',
            'items' => [
                [
                    'label' => 'Cuti Belajar',
                    'url' => ['elnpt/senarai-cuti-belajar'],
                ],
                [
                    'label' => 'Carian Borang',
                    'url' => ['elnpt/carian-borang'],
                ],
                [
                    'label' => 'Markah Borang',
                    'url' => ['elnpt/markah-borang'],
                ],
                [
                    'label' => 'Pengesahan Markah',
                    'url' => ['elnpt/pengesahan-markah-borang'],
                ],
                [
                    'label' => 'Pantau Pergerakan Borang',
                    'url' => ['elnpt/pantau-pergerakan-borang'],
                ],
                [
                    'label' => 'Carian Arkib Borang',
                    'url' => ['elnpt/carian-arkib-borang'],
                ],
            ]
        ],
        [
            'label' => 'Pengurusan',
            'items' => [
                [
                    'label' => 'Buka Borang',
                    'url' => ['elnpt/buka-borang-lpp'],
                ],
                [
                    'label' => 'Reset Borang',
                    'url' => ['elnpt/reset-borang'],
                ],
                [
                    'label' => 'Status Borang',
                    'url' => ['elnpt/urus-status-borang'],
                ],
                [
                    'label' => 'Pembetulan Penilai',
                    'url' => ['elnpt/penetapan-ppp-ppk-peer'],
                ],
                [
                    'label' => 'Jana Laporan',
                    'url' => ['elnpt/generate-report'],
                ],
                [
                    'label' => 'Jana Laporan V2',
                    'url' => ['elnpt/generate-report-v2'],
                ],
                [
                    'label' => 'Cadangan APC',
                    'url' => ['elnpt/pengurusan-cadangan-apc'],
                ],
            ]
        ],
        [
            'label' => 'Penetapan Akses Sistem',
            'url' => ['elnpt/penetapan-akses-testing'],
        ],
        [
            'label' => 'Rujukan / Panduan',
            'url' => ['elnpt/rujukan-panduan'],
            'items' =>  [
                [
                    'label' => '2019',
                    'url' => ['elnpt/rujukan-panduan'],
                ],
                [
                    'label' => '2020 / 2021',
                    'url' => ['elnpt2/rujukan-panduan'],
                ],
            ]
        ],
        [
            'label' => 'Akses Sebagai',
            'format' => 'raw',
            'items' => [
                [
                    'label' => 'PYD',
                    'url' => ['elnpt/carian-borang-v2'],
                ],
                [
                    'label' => 'Penilai',
                    'url' => ['elnpt/carian-borang-penilai'],
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
        [
            'label' => 'Support Ticket <sup><span class="label label-success">Baru</span></sup>',
            'url' => ['elnpt3/ticket-list'],
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>