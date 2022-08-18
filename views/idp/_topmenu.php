<style>
    .navbar-nav .open .dropdown-menu {
        position: absolute;
        background:
            #fff;
        margin-top: 0;
        border: 1px solid #D9DEE4;
        -webkit-box-shadow: none;
        right: 0;
        left: auto;
        width: auto;
    }
</style>

<?php

use app\models\cuti\SetPegawai;
use app\models\myidp\AdminJfpiu;
use app\models\myidp\UserAccess;
use app\models\hronline\Department;
use app\models\myidp\UrusetiaLatihan;
use app\models\hronline\Tblprcobiodata;

$user = Yii::$app->user->getId();

$findUser = UserAccess::find()->where(['userID' => $user])->one();

if (!$findUser) {

    $findUser2 = AdminJfpiu::find()->where(['staffID' => $user])->one();

    if (!$findUser2) {

        $checkPegawai = SetPegawai::find()
            ->where(['peraku_icno' => $user])
            ->orWhere(['pelulus_icno' => $user])
            ->all();

        $checkPegawai2 = Department::find()
            ->where(['chief' => $user])
            ->all();

        $nc = Tblprcobiodata::find()
            ->joinWith('jawatan')
            ->where(['id' => '2', 'Status' => '1', 'ICNO' => $user])
            ->one();

        if ($checkPegawai && $checkPegawai2) {

            echo \app\widgets\TopMenuWidget::widget(['top_menu' => [100, 108, 241], 'vars' => [
                [
                    'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId()),
                    'items' => [
                        [
                            'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId())
                        ],
                    ],
                ],
                [
                    'label' => \app\models\myidp\PermohonanLatihan::totalPending(Yii::$app->user->getId(), 0),
                    'items' => [
                        [
                            'label' => \app\models\myidp\PermohonanLatihan::totalPending(Yii::$app->user->getId(), 2)
                        ],
                        [
                            'label' => \app\models\myidp\PermohonanLatihan::totalPending(Yii::$app->user->getId(), 1)
                        ],
                        [
                            'label' => \app\models\myidp\PermohonanMataIdpIndividu::totalPending(Yii::$app->user->getId(), 3)
                        ],
                        [
                            'label' => \app\models\myidp\PermohonanMataIdpIndividu::totalPending(Yii::$app->user->getId(), 1)
                        ],
                        [
                            'label' => \app\models\myidp\PermohonanMataIdpIndividu::totalPending(Yii::$app->user->getId(), 2)
                        ],
                        [
                            'label' => \app\models\myidp\PermohonanMataIdpIndividu::totalPending(Yii::$app->user->getId(), 22)
                        ],
                    ],
                ],
            ]]);
        } elseif ($checkPegawai && !$checkPegawai2) {

            echo \app\widgets\TopMenuWidget::widget(['top_menu' => [100, 108, 241], 'vars' => [
                [
                    'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId()),
                    'items' => [
                        [
                            'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId())
                        ],
                    ],
                ],
                [
                    'label' => \app\models\myidp\PermohonanLatihan::totalPending(Yii::$app->user->getId(), 0),
                    'items' => [
                        [
                            'label' => \app\models\myidp\PermohonanLatihan::totalPending(Yii::$app->user->getId(), 2)
                        ],
                        [
                            'label' => \app\models\myidp\PermohonanLatihan::totalPending(Yii::$app->user->getId(), 1)
                        ],
                        ['label' => ''],
                        [
                            'label' => \app\models\myidp\PermohonanMataIdpIndividu::totalPending(Yii::$app->user->getId(), 1)
                        ],
                    ],
                ],
            ]]);
        }

        //        } elseif ($checkPegawai && $nc){
        //            
        //            echo \app\widgets\TopMenuWidget::widget(['top_menu' => [100, 108, 241], 'vars' => [
        //            ['label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId()),
        //                'items' => [
        //                    [
        //                        'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId())
        //                    ],
        //                 ],
        //           ],
        //           ['label' => \app\models\myidp\PermohonanLatihan::totalPending(Yii::$app->user->getId(),0),
        //                'items' => [
        //                                                    [
        //                                                        'label' => \app\models\myidp\PermohonanLatihan::totalPending(Yii::$app->user->getId(), 2)
        //                                                    ],
        //                                                    [
        //                                                        'label' => \app\models\myidp\PermohonanLatihan::totalPending(Yii::$app->user->getId(), 1)
        //                                                    ],
        //                                                    ['label' => ''],
        //                                                    [
        //                                                        'label' => \app\models\myidp\PermohonanMataIdpIndividu::totalPending(Yii::$app->user->getId(), 1)
        //                                                    ],
        //                                                ],],
        //           ]]);
        // 
        //        }
        //        



        else {

            echo \app\widgets\TopMenuWidget::widget(['top_menu' => [100, 241], 'vars' => [
                [
                    'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId()),
                    'items' => [
                        [
                            'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId())
                        ],
                    ],
                ],
            ]]);
        }
    } else {
        echo \app\widgets\TopMenuWidget::widget(['top_menu' => [100, 202, 241], 'vars' => [
            [
                'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId()),
                'items' => [
                    [
                        'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId())
                    ],
                ],
            ],
        ]]);
    }
}

// if ($findUser){
else {

    if ($findUser->usertype == 'ketuaSektor') {

        echo \app\widgets\TopMenuWidget::widget(['top_menu' => [100, 108, 241, 1083, 1172], 'vars' => [
            [
                'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId()),
                'items' => [
                    [
                        'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId())
                    ],
                ],
            ],
            // ['label' => \app\models\myidp\PermohonanLatihan::totalPending(Yii::$app->user->getId(),0),
            //     'items' => [
            //                                         [
            //                                             'label' => \app\models\myidp\PermohonanLatihan::totalPending(Yii::$app->user->getId(), 2)
            //                                         ],
            //                                         [
            //                                             'label' => \app\models\myidp\PermohonanLatihan::totalPending(Yii::$app->user->getId(), 1)
            //                                         ],
            //                                         [
            //                                             'label' => \app\models\myidp\PermohonanMataIdpIndividu::totalPending(Yii::$app->user->getId(), 3)
            //                                         ],
            //                                         [
            //                                             'label' => \app\models\myidp\PermohonanMataIdpIndividu::totalPending(Yii::$app->user->getId(), 1)
            //                                         ],
            //                                         [
            //                                             'label' => \app\models\myidp\PermohonanMataIdpIndividu::totalPending(Yii::$app->user->getId(), 2)
            //                                         ],
            //                                         [
            //                                             'label' => \app\models\myidp\PermohonanMataIdpIndividu::totalPending(Yii::$app->user->getId(), 22)
            //                                         ],
            //                                         ['label' => ''],
            //                                         ['label' => ''],
            //                                         [
            //                                             'label' => \app\models\myidp\PermohonanKursusLuar::totalPending(21)
            //                                         ],
            //                                         [
            //                                             'label' => \app\models\myidp\PermohonanKursusLuar::totalPending(221)
            //                                         ]

            //                                     ],],
            // ['label' => ''],
            // ['label' => '']

        ]]);
    } elseif ($findUser->usertype == 'pegawaiLatihan') {

        echo \app\widgets\TopMenuWidget::widget(['top_menu' => [100, 108, 241, 1083, 1172], 'vars' => [
            [
                'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId()),
                'items' => [
                    [
                        'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId())
                    ],
                ],
            ],
            // ['label' => \app\models\myidp\PermohonanLatihan::totalPending(Yii::$app->user->getId(),0),
            //     'items' => [
            //                                         [
            //                                             'label' => \app\models\myidp\PermohonanLatihan::totalPending(Yii::$app->user->getId(), 2)
            //                                         ],
            //                                         [
            //                                             'label' => \app\models\myidp\PermohonanLatihan::totalPending(Yii::$app->user->getId(), 1)
            //                                         ],
            //                                         [
            //                                             'label' => \app\models\myidp\PermohonanMataIdpIndividu::totalPending(Yii::$app->user->getId(), 3)
            //                                         ],
            //                                         [
            //                                             'label' => \app\models\myidp\PermohonanMataIdpIndividu::totalPending(Yii::$app->user->getId(), 1)
            //                                         ],
            //                                         [
            //                                             'label' => \app\models\myidp\PermohonanMataIdpIndividu::totalPending(Yii::$app->user->getId(), 2)
            //                                         ],
            //                                         [
            //                                             'label' => \app\models\myidp\PermohonanMataIdpIndividu::totalPending(Yii::$app->user->getId(), 22)
            //                                         ],
            //                                         [
            //                                             'label' => \app\models\myidp\PermohonanKursusLuar::totalPending(20)
            //                                         ],
            //                                         [
            //                                             'label' => \app\models\myidp\PermohonanKursusLuar::totalPending(220)
            //                                         ],
            //                                         [
            //                                             'label' => '',
            //                                         ],
            //                                         [
            //                                             'label' => '',
            //                                         ],
            //                                         [
            //                                             'label' => \app\models\myidp\PermohonanKursusLuar::totalPendingSurat(22)
            //                                         ],
            //                                         [
            //                                             'label' => \app\models\myidp\PermohonanKursusLuar::totalPendingSurat(11)
            //                                         ],
            //                                     ],],
            // ['label' => ''],
            // ['label' => '']

        ]]);
    } elseif ($findUser->usertype == 'ul') {

        // $findUrusetia = UrusetiaLatihan::find()->where(['userID' => $user])->one();

        // if ($findUrusetia && ($findUrusetia->ul_type == 'pentadbiran')){

        //     echo \app\widgets\TopMenuWidget::widget(['top_menu' => [100, 104, 241, 1083, 1172], 'vars' => [
        //         ['label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId()),
        //             'items' => [
        //                 [
        //                     'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId())
        //                 ],
        //             ],
        //         ],
        //         ['label' => \app\models\myidp\PermohonanKursusLuar::totalPending(44),
        //             'items' => [
        //                                                 [
        //                                                     'label' => ''
        //                                                 ],
        //                                                 [
        //                                                     'label' => ''
        //                                                 ],
        //                                                 [
        //                                                     'label' => ''
        //                                                 ],
        //                                                 [
        //                                                     'label' => ''
        //                                                 ],
        //                                                 [
        //                                                     'label' => \app\models\myidp\PermohonanKursusLuar::totalPending(2)
        //                                                 ],
        //                                                 [
        //                                                     'label' => ''
        //                                                 ],
        //                                                 [
        //                                                     'label' => \app\models\myidp\PermohonanKursusLuar::totalPendingSurat(2)
        //                                                 ],
        //                                                 [
        //                                                     'label' => ''
        //                                                 ],
        //                                                 [
        //                                                     'label' => \app\models\myidp\PermohonanKursusLuar::totalPending(1)
        //                                                 ],
        //                                                 [
        //                                                     'label' => ''
        //                                                 ],

        //                                             ],]

        //     ]]);
        // } else {

        //     echo \app\widgets\TopMenuWidget::widget(['top_menu' => [100, 104, 241, 1083, 1172], 'vars' => [
        //         ['label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId()),
        //             'items' => [
        //                 [
        //                     'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId())
        //                 ],
        //             ],
        //         ],
        //         ['label' => \app\models\myidp\PermohonanKursusLuar::totalPending(4),
        //             'items' => [
        //                                                 [
        //                                                     'label' => ''
        //                                                 ],
        //                                                 [
        //                                                     'label' => ''
        //                                                 ],
        //                                                 [
        //                                                     'label' => ''
        //                                                 ],
        //                                                 [
        //                                                     'label' => ''
        //                                                 ],
        //                                                 [
        //                                                     'label' => ''
        //                                                 ],
        //                                                 [
        //                                                     'label' => \app\models\myidp\PermohonanKursusLuar::totalPending(22)
        //                                                 ],
        //                                                 [
        //                                                     'label' => ''
        //                                                 ],
        //                                                 [
        //                                                     'label' => \app\models\myidp\PermohonanKursusLuar::totalPendingSurat(1)
        //                                                 ],
        //                                                 [
        //                                                     'label' => ''
        //                                                 ],
        //                                                 [
        //                                                     'label' => \app\models\myidp\PermohonanKursusLuar::totalPending(3)
        //                                                 ],

        //                                             ],]

        //     ]]);

        // }

        // $checkUrusetia = UrusetiaLatihan::find()->where(['userID' => $user, 'ul_type' => 'ketuaUrusetia'])->one();

        // if ($checkUrusetia){

        echo \app\widgets\TopMenuWidget::widget(['top_menu' => [100, 104, 108, 202, 241, 1083, 1172], 'vars' => [
            [
                'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId()),
                'items' => [
                    [
                        'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId())
                    ],
                ],
            ],
        ]]);

        // } else {
        //     echo \app\widgets\TopMenuWidget::widget(['top_menu' => [100, 104, 241, 1083, 1172], 'vars' => [
        //         ['label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId()),
        //             'items' => [
        //                 [
        //                     'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId())
        //                 ],
        //             ],
        //         ],
        // ['label' => \app\models\myidp\PermohonanKursusLuar::totalPending(44),
        //     'items' => [
        //                                         [
        //                                             'label' => ''
        //                                         ],
        //                                         [
        //                                             'label' => ''
        //                                         ],
        //                                         [
        //                                             'label' => ''
        //                                         ],
        //                                         [
        //                                             'label' => ''
        //                                         ],
        //                                         [
        //                                             'label' => \app\models\myidp\PermohonanKursusLuar::totalPending(2)
        //                                         ],
        //                                         [
        //                                             'label' => ''
        //                                         ],
        //                                         [
        //                                             'label' => \app\models\myidp\PermohonanKursusLuar::totalPendingSurat(2)
        //                                         ],
        //                                         [
        //                                             'label' => ''
        //                                         ],
        //                                         [
        //                                             'label' => \app\models\myidp\PermohonanKursusLuar::totalPending(1)
        //                                         ],
        //                                         [
        //                                             'label' => ''
        //                                         ],

        //                                     ],]

        // ]]);
        //}

    } elseif ($findUser->usertype == 'admin') {

        echo \app\widgets\TopMenuWidget::widget(['top_menu' => [100, 104, 202, 108, 241, 1083, 1172, '1410'], 'vars' => [
            [
                'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId()),
                'items' => [
                    [
                        'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId())
                    ],
                ],
            ],

        ]]);
    } elseif ($findUser->usertype == 'ul-s') { //LINDA SHIRLEY
        echo \app\widgets\TopMenuWidget::widget(['top_menu' => [100, 241, 1172], 'vars' => [
            [
                'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId()),
                'items' => [
                    [
                        'label' => \app\models\myidp\BorangPenilaianLatihan::calcPendingBorang(Yii::$app->user->getId())
                    ],
                ],
            ],
        ]]);
    }
}
?>