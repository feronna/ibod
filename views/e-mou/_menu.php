<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

NavBar::begin();
echo Nav::widget([
    'items' => [
        [
            'label' => 'Permohonan Baru',
            'items' => [
                [
                    'label' => 'Memorandum Belum Dihantar',
                    'url' => ['e-mou/memorandum-belum-hantar'],
                ],
                [
                    'label' => 'Memorandum Menunggu Kelulusan',
                    'url' => ['e-mou/memorandum-tunggu-lulus'],
                ],
                [
                    'label' => 'Memorandum Tidak Diluluskan',
                    'url' => ['e-mou/memorandum-tidak-lulus'],
                ],
                [
                    'label' => 'Memorandum Menunggu Dimeterai',
                    'url' => ['e-mou/memorandum-tunggu-dimeterai'],
                ],
                [
                    'label' => 'Memorandum Telah Dimeterai',
                    'url' => ['e-mou/memorandum-dimeterai'],
                ],



            ]
        ],
        [
            'label' => 'Kemaskini Laporan Aktiviti',
            'items' => [
                [
                    'label' => 'Memorandum Telah Disahkan',
                    'url' => ['e-mou/memorandum-telah-sah'],
                ],
                [
                    'label' => 'Memorandum Menunggu Pengesahan',
                    'url' => ['e-mou/memorandum-tunggu-sah'],
                ],
                [
                    'label' => 'Memorandum Akan Tamat',
                    'url' => ['e-mou/memorandum-akan-tamat'],
                ],
                [
                    'label' => 'Memorandum Tamat Tempoh',
                    'url' => ['e-mou/memorandum-tamat-tempoh'],
                ],
            ]
        ],
        [
            'label' => 'Laporan',
            'items' => [
                [
                    'label' => 'Senarai Memorandum',
                    'url' => ['e-mou/senarai-memorandum'],
                ],
                [
                    'label' => 'Senarai Memorandum Aktif',
                    'url' => ['e-mou/senarai-memorandum-aktif'],
                ],
                [
                    'label' => 'Senarai Memorandum Tidak Aktif',
                    'url' => ['e-mou/senarai-memorandum-tidak-aktif'],
                ],
                // [
                //     'label' => 'Memorandum Tamat Tempoh',
                //     'url' => ['e-mou/memorandum-tamat-tempoh'],
                // ],
            ]
        ],
        // [
        //     'label' => 'Utiliti',            'items' => [
        //         [
        //             'label' => 'Penetapan Tahun Penilaian',
        //             'url' => ['elnpt/penetapan-tahun-penilaian'],
        //         ],
        //         [
        //             'label' => 'Pendaftaran Penetap Penilai',
        //             'url' => ['elnpt/pendaftaran-penetap-penilai?thn=2021'],
        //         ],
        //         [
        //             'label' => 'Pengurusan Rubrik',                    'items' => [
        //                 [
        //                     'label' => 'Jabatan',
        //                     'url' => ['elnpt/penetapan-rubrik-dept'],
        //                 ],
        //                 [
        //                     'label' => 'Gred Jawatan',
        //                     'url' => ['elnpt/penetapan-rubrik-gred'],
        //                 ]
        //             ]
        //         ],
        //         [
        //             'label' => 'Tambah Kumpulan Department <sup><span class="label label-success">Baru</span></sup>',
        //             'url' => ['elnpt/tambah-kump-dept'],
        //         ],
        //         [
        //             'label' => 'Pembetulan Markah LNPT <sup><span class="label label-warning">2020</span></sup>',
        //             'url' => ['elnpt/fix-markah'],
        //         ],
        //         [
        //             'label' => 'Run Queue',
        //             'url' => ['elnpt/run-queue'],
        //             // 'visible' => (Yii::$app->user->identity->ICNO == '930807125121')
        //         ],
        //     ]
        // ],
        // [
        //     'label' => 'Pemantauan',            'items' => [
        //         [
        //             'label' => 'Cuti Belajar',
        //             'url' => ['elnpt/senarai-cuti-belajar'],
        //         ],                [
        //             'label' => 'Carian Borang',
        //             'url' => ['elnpt/carian-borang'],
        //         ],                [
        //             'label' => 'Markah Borang',
        //             'url' => ['elnpt/markah-borang'],
        //         ],                [
        //             'label' => 'Pengesahan Markah',
        //             'url' => ['elnpt/pengesahan-markah-borang'],
        //         ],                [
        //             'label' => 'Pantau Pergerakan Borang',
        //             'url' => ['elnpt/pantau-pergerakan-borang'],
        //         ],
        //         [
        //             'label' => 'Carian Arkib Borang <sup><span class="label label-success">Baru</span></sup>',
        //             'url' => ['elnpt/carian-arkib-borang'],
        //         ],
        //     ]
        // ],
        // [
        //     'label' => 'Pengurusan',            'items' => [
        //         [
        //             'label' => 'Buka Borang',
        //             'url' => ['elnpt/buka-borang-lpp'],
        //         ],
        //         [
        //             'label' => 'Reset Borang',
        //             'url' => ['elnpt/reset-borang'],
        //         ],                [
        //             'label' => 'Status Borang',
        //             'url' => ['elnpt/urus-status-borang'],
        //         ],                [
        //             'label' => 'Pembetulan Penilai',
        //             'url' => ['elnpt/penetapan-ppp-ppk-peer'],
        //         ],
        //         [
        //             'label' => 'Jana Laporan',
        //             'url' => ['elnpt/generate-report'],
        //         ],
        //         [
        //             'label' => 'Jana Laporan V2',
        //             'url' => ['elnpt/generate-report-v2'],
        //         ],
        //         [
        //             'label' => 'Cadangan APC',
        //             'url' => ['elnpt/pengurusan-cadangan-apc'],
        //         ],
        //     ]
        // ],        [
        //     'label' => 'Penetapan Akses Sistem',
        //     'url' => ['elnpt/penetapan-akses-testing'],
        // ],
        // [
        //     'label' => 'Rujukan / Panduan',
        //     'url' => ['elnpt/rujukan-panduan'],
        //     'items' =>  [
        //         [
        //             'label' => '2019',
        //             'url' => ['elnpt/rujukan-panduan'],
        //         ],
        //         [
        //             'label' => '2020',
        //             'url' => ['elnpt2/rujukan-panduan'],
        //         ],
        //     ]
        // ],
        // [
        //     'label' => 'Akses Sebagai <sup><span class="label label-warning">Beta</span></sup>',
        //     'format' => 'raw',            'items' => [
        //         [
        //             'label' => 'PYD',
        //             'url' => ['elnpt/carian-borang-v2'],
        //         ],
        //         [
        //             'label' => 'Penilai',
        //             'url' => ['elnpt/carian-borang-penilai'],
        //         ],
        //     ]
        // ],
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>