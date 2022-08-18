<?php

use app\models\ikalendar\TblHrUsers;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

$user = TblHrUsers::find()->where(['email' => Yii::$app->user->identity->ICNO])->one();
NavBar::begin();
echo Nav::widget([
    'items' => [
        [
            'label' => 'Takwim Aktiviti',
            'url' => ['i-kalendar/takwim-aktiviti'],
        ],
        [
            'label' => 'Senarai Aktiviti',
            'url' => ['i-kalendar/index'],
        ],
        [
            'label' => 'Senarai Pengguna',
            'url' => ['i-kalendar/senarai-pengguna'],
            'visible' => ($user->isadmin == 1)
        ],
        [
            'label' => 'Senarai Bahagian/Seksyen/Unit',
            'url' => ['i-kalendar/senarai-bhg-sek-unit'],
            'visible' => ($user->isadmin == 1)
        ],
        [
            'label' => 'Pencapaian',
            'items' => [
                [
                    'label' => 'Tahunan',
                    'url' => ['i-kalendar/pencapaian-tahunan'],
                ],
                [
                    'label' => 'Bulanan',
                    'url' => ['i-kalendar/pencapaian-bulanan'],
                ],
            ]
        ],
        [
            'label' => 'Laporan Keseluruhan',
            'url' => ['i-kalendar/laporan-keseluruhan'],
        ],
        [
            'label' => 'Perincian Laporan',
            'url' => ['i-kalendar/perincian-laporan'],
        ],
        [
            'label' => 'Senarai Aktiviti Mengikut Bahagian',
            'url' => ['i-kalendar/senarai-aktiviti-bahagian'],
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>