<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use app\models\lnpk\TblMain;

$checkPyd = TblMain::find()->where(['PYD' => Yii::$app->user->identity->ICNO])->exists();
$checkPP = TblMain::find()->where(['OR', ['PPP' => Yii::$app->user->identity->ICNO], ['PPK' => Yii::$app->user->identity->ICNO]])->exists();

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
            'url' => ['lppums/index'],
        ],
        [
            'label' => 'Borang LPP',
            'url' => ['lppums/borang-lpp'],
            'visible' => (((Yii::$app->user->identity->jawatan->job_group != 2) && (Yii::$app->user->identity->jawatan->job_group != 3)) or
                \app\models\lppums\TblMain::findOne(['PYD' => Yii::$app->user->identity->ICNO]))
        ],
        [
            'label' => 'Penetap Penilai',
            //'url' => ['lppums/bahagian9', 'lpp_id' => $lppid],
            'visible' => (app\models\lppums\TblPenetapPenilai::find()
                ->leftJoin(['a' => 'hrm.lppums_lpp_tahun'], 'a.lpp_tahun = hrm.lppums_tbl_penetap_penilai.tahun AND a.lpp_aktif = \'Y\'')
                ->where(['hrm.lppums_tbl_penetap_penilai.penetap_icno' => Yii::$app->user->identity->ICNO])
                ->exists()),
            'items' => [
                [
                    'label' => 'Penetapan Pegawai Penilai',
                    'url' => ['lppums/penetap-pegawai-penilai'],
                ],
                [
                    'label' => 'Pantau Pergerakan Borang',
                    'url' => ['lppums/penetap-pantau-pergerakan-borang'],
                ],
                [
                    'label' => 'Markah Staff Jabatan',
                    'url' => ['lppums/penetap-markah-borang'],
                ]
            ]
        ],
        [
            'label' => 'Senarai PYD',
            'url' => ['lppums/senarai-pyd'],
            'visible' => (app\models\lppums\TblMain::find()
                ->where(['or', ['PPP' => Yii::$app->user->identity->ICNO], ['PPK' => Yii::$app->user->identity->ICNO]])
                ->exists()),
        ],
        //            [
        //                'label' => 'Pengurusan',
        //                //'url' => ['lppums/penetapan-akses-sistem'],
        //                'visible' => (app\models\lppums\TblStafAkses::find()->where(['ICNO' => Yii::$app->user->identity->ICNO, 'akses_id' => 1])->exists()),
        //                'items' => [
        //                    [
        //                        'label' => 'Penetapan Akses Sistem',
        //                        'url' => ['lppums/penetapan-akses-sistem'],
        //                        //'visible' => (app\models\lppums\TblStafAkses::find()->where(['ICNO' => Yii::$app->user->identity->ICNO])->exists()),
        //                        'visible' => (app\models\lppums\TblStafAkses::find()
        //            ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
        //            ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
        //            ->andWhere(['IS NOT', 'a.akses_set_akses', NULL])
        //            ->exists()),
        //                    ],
        //                    [
        //                        'label' => 'Penetapan Pegawai Penilai',
        //                        'url' => ['lppums/penetapan-pegawai-penilai'],
        //                    ],
        //                    [
        //                        'label' => 'Pendaftaran Penetap Penilai',
        //                        'url' => ['lppums/pendaftaran-penetap-penilai'],
        //                    ],
        //                    [
        //                        'label' => 'Carian Borang LNPT',
        //                        'url' => ['lppums/carian-borang-lpp'],
        //                    ],
        //                    [
        //                        'label' => 'Pengurusan Tahun Penilaian',
        //                        'url' => ['lppums/pengurusan-tahun-penilaian'],
        //                    ],
        //                    [
        //                        'label' => 'Reset LPP',
        //                        'url' => ['lppums/reset-borang-lpp'],
        //                    ],
        //                    [
        //                        'label' => 'Buang Borang LPP',
        //                        'url' => ['lppums/padam-borang-lpp'],
        //                    ],
        //                    [
        //                        'label' => 'Pantau Pergerakan Borang',
        //                        'url' => ['lppums/pantau-pergerakan-borang'],
        //                    ],
        //                ]
        //            ],
        [
            'label' => 'Panduan Pengisian Borang',
            'url' => ['lppums/panduan-pengisian-borang'],
        ],
        [
            'label' => "<i class='fa fa-briefcase'></i>&nbsp;SMO-UMS",
            'items' => [
                [
                    'label' => "<i class='fa fa-building'></i>&nbsp;Maklumbalas & Cadangan",
                    'url' => ['smo/list-komponen-1'],
                ],
                [
                    'label' => "<i class='fa fa-users'></i>&nbsp;Pemantauan PYD",
                    'url' => ['smo/list-komponen-2'],
                ],
            ]
        ],
        [
            'label' => 'LNPK',
            'visible' => ($checkPyd || $checkPP),
            'url' => ['lnpk/index'],
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>