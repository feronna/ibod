<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

//$query1 = TblTestingAccess::find()
//                                ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])
//                                ->exists();

//
//$item = [];
//$items = [
//    [
//        'label' => 'Menu Utama',
//        'url' => ['elnpt/index']
//    ]
//];
//foreach($mrkh_all as $ind => $bbb) {
//    $item[$ind]['label'] = $bbb['bahagian'];
//    $item[$ind]['url'] = (array)('elnpt/'.($bbb['bhg_kod']));
//    array_push($items, $item[$ind]);
//}

NavBar::begin();
    echo Nav::widget([
        'items' => [
            [
                'label' => 'Laman Utama',
                'url' => ['cbelajar/halaman-utama-bsm'],
            ],
            [
                'label' => 'Utiliti',
                //'url' => ['elnpt/index1'],
                'items' => [
//                    [
//                        'label' => 'Rujukan / Panduan',
//                        'url' =>['elnpt/rujukan-panduan'],
//                    ],
                    [
                        'label' => 'Penetapan Tahun Penilaian',
                        'url' =>['elnpt/penetapan-tahun-penilaian'],
                    ],
                    [
                        'label' => 'Pendaftaran Penetap Penilai',
                        'url' =>['elnpt/pendaftaran-penetap-penilai'],
                    ],
                    [
                        'label' => 'Pengurusan Rubrik',
                        
                        'items' => [
                            [
                                'label' => 'Jabatan',
                                'url' => ['elnpt/penetapan-rubrik-dept'],
                            ],
                            [
                                'label' => 'Gred Jawatan',
                                'url' => ['elnpt/penetapan-rubrik-gred'],
                            ]  
                        ]
                    ],
                ]
            ],
            [
                'label' => 'Pemantauan',
                //'url' => ['elnpt/index1'],
                'items' => [
                    [
                        'label' => 'Cuti Belajar',
                        'url' =>['elnpt/senarai-cuti-belajar'],
                    ],
                    
                    [
                        'label' => 'Carian Borang',
                        'url' =>['elnpt/carian-borang'],
                    ],
                    
                    [
                        'label' => 'Markah Borang',
                        'url' =>['elnpt/markah-borang'],
                    ],
                    
                    [
                        'label' => 'Pengesahan Markah',
                        'url' =>['elnpt/pengesahan-markah-borang'],
                    ],
                    
                    [
                        'label' => 'Pantau Pergerakan Borang',
                        'url' =>['elnpt/pantau-pergerakan-borang'],
                    ],
                ]
            ],
            [
                'label' => 'Pengurusan',
                //'url' => ['elnpt/index1'],
                'items' => [
                    
                    [
                        'label' => 'Buka Borang',
                        'url' =>['elnpt/buka-borang-lpp'],
                    ],
                    [
                        'label' => 'Reset Borang',
                        'url' =>['elnpt/reset-borang'],
                    ],
                    
                    [
                        'label' => 'Status Borang',
                        'url' =>['elnpt/urus-status-borang'],
                    ],
                    
                    [
                        'label' => 'Pembetulan Penilai',
                        'url' =>['elnpt/penetapan-ppp-ppk-peer'],
                    ],
                    [
                        'label' => 'Jana Laporan',
                        'url' =>['elnpt/generate-report'],
                    ],
                    [
                        'label' => 'Jana Laporan V2',
                        'url' =>['elnpt/generate-report-v2'],
                    ],
                ]
            ],
//            [
//                'label' => 'Urusan Penilaian Prestasi',
//                //'url' => ['elnpt/index1'],
//                'items' => [
//                    [
//                        'label' => 'Cadangan APC',
//                        'url' =>['elnpt/senarai-pyd-ppp'],
//                    ],
//                    [
//                        'label' => 'Cadangan APC(Baru)',
//                        'url' =>['elnpt/senarai-pyd-ppk'],
//                    ],
//                ]
//            ],
//            [
//                'label' => 'Laporan',
//                //'url' => ['elnpt/index1'],
//                'items' => [
//                    [
//                        'label' => 'Status Penghantaran Borang',
//                        'url' =>['elnpt/senarai-pyd-ppp'],
//                    ],
//                    [
//                        'label' => 'Markah Terkini',
//                        'url' =>['elnpt/senarai-pyd-ppk'],
//                    ],
//                ]
//            ],
//            [
//                'label' => 'Uji Lari',
//                //'url' => ['elnpt/index1'],
//                'items' => [
//                    [
//                        'label' => 'Penetapan Akses Testing',
//                        'url' =>['elnpt/penetapan-akses-testing'],
//                    ],
////                    [
////                        'label' => 'Markah Terkini',
////                        'url' =>['elnpt/senarai-pyd-ppk'],
////                    ],
//                ]
//            ],
            [
                'label' => 'Penetapan Akses Sistem',
                'url' =>['elnpt/penetapan-akses-testing'],
            ],
            [
                'label' => 'Rujukan / Panduan',
                'url' =>['elnpt/rujukan-panduan'],
            ],
            [
                'label' => 'Akses Sebagai <sub><span class="label label-warning">Beta</span></sub>',
                'format' => 'raw',
                //'url' => ['elnpt/index1'],
                'items' => [
                    [
                        'label' => 'PYD',
                        'url' =>['elnpt/carian-borang-v2'],
                    ],
                    [
                        'label' => 'Penilai',
                        'url' =>['elnpt/carian-borang-penilai'],
                    ],
//                    [
//                        'label' => 'Markah Borang',
//                        'url' =>['elnpt/markah-borang'],
//                    ],
//                    
//                    [
//                        'label' => 'Pantau Pergerakan Borang',
//                        'url' =>['elnpt/pantau-pergerakan-borang'],
//                    ],
                ]
            ],
        ],
        'options' => ['class' => 'navbar-nav'],
        'encodeLabels' => false,
    ]);
NavBar::end();
?>
<br>