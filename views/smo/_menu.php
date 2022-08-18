<?php

use app\models\adu\Main;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;


NavBar::begin();
echo Nav::widget([
    'items' => [
        [
            'label' => "Laman Utama",
            'url' => ['lppums/index']
        ],
        [
            'label' => "<i class='fa fa-building'></i>&nbsp;Maklumbalas & Cadangan",
            'items' => [
                ['label' => '<i class="fa fa-list"></i>&nbsp;Senarai Maklumbalas', 'url' => ['smo/list-komponen-1']],
                ['label' => '<i class="fa fa-flag"></i>&nbsp;Maklumbalas Baharu', 'url' => ['smo/create-komponen-1']],
                ['label' => '<i class="fa fa-pencil"></i>&nbsp;Tindakan anda', 'url' => ['smo/list-k1']],
            ],
        ],
        [
            'label' => "<i class='fa fa-users'></i>&nbsp;Pemantauan PYD",
            'items' => [
                ['label' => '<i class="fa fa-list"></i>&nbsp;Senarai', 'url' => ['smo/list-komponen-2']],
                ['label' => '<i class="fa fa-flag"></i>&nbsp;Baharu', 'url' => ['smo/create-komponen-2']],
                ['label' => '<i class="fa fa-pencil"></i>&nbsp;Tindakan anda', 'url' => ['smo/list-k2']],
            ],
        ],
        [
            'label' => "<i class='fa fa-users'></i>&nbsp; Menu Dekan/Ketua Jabatan/Pengarah",
            'visible' => Main::isUserKj(Yii::$app->user->identity->ICNO),
            'items' => [
                ['label' => '<i class="fa fa-list"></i>&nbsp;Tindakan Maklumbalas & Cadangan', 'url' => ['smo/list-kj-k1']],
                ['label' => '<i class="fa fa-list-ol"></i>&nbsp;Pemantauan Maklumbalas & Cadangan', 'url' => ['smo/list-pantau-kj']],
            ],
        ],
        [
            'label' => "<i class='fa fa-users'></i>&nbsp; Menu Admin",
            'visible' => Main::isUserAdmin(Yii::$app->user->identity->ICNO),
            'items' => [
                ['label' => '<i class="fa fa-list"></i>&nbsp;Senarai Komponen 1', 'url' => ['smo/list-admin-k1']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;Senarai Komponen 2', 'url' => ['smo/list-admin-k2']],
            ],
        ],
        

        // [
        //     'label' => "<i class='fa fa-user'></i>&nbsp; Menu Ketua BSM",
        //     'visible' => Main::isUserBsm(Yii::$app->user->identity->ICNO),
        //     'items' => [
        //         ['label' => '<i class="fa fa-list"></i>&nbsp;Senarai Aduan', 'url' => ['adu/list-bsm']],
        //     ],
        // ],
        // [
        //     'label' => "<i class='fa fa-user'></i>&nbsp; Menu Ketua PPUU",
        //     'visible' => Main::isUserPpuu(Yii::$app->user->identity->ICNO),
        //     'items' => [
        //         ['label' => '<i class="fa fa-list"></i>&nbsp;Senarai Aduan', 'url' => ['adu/list-ppuu']],
        //     ],
        // ],

    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>