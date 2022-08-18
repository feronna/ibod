<?php

use app\models\dkums\Users;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

NavBar::begin();
echo Nav::widget([
    'items' => [
        [
            'label' => "<i class='fa fa-user'></i>&nbsp;Menu Staff",
            'items' => [
                ['label' => '<i class="fa fa-list"></i>&nbsp;Rekod DKUMS Anda', 'url' => ['dkums/index']],
                ['label' => '<i class="fa fa-check-square-o"></i>&nbsp;Soal Selidik', 'url' => ['dkums/intro'], 'linkOptions' => ['target' => '']],
            ],
        ],
        [
            'label' => "<i class='fa fa-lock'></i>&nbsp;Menu Admin",
            'visible' => Users::isUserAdmin(Yii::$app->user->identity->ICNO),
            'items' => [
                ['label' => '<i class="fa fa-wrench"></i>&nbsp;Tetapan Tahun', 'url' => ['dkums/senarai-tahun']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;Senarai Staff', 'url' => ['dkums/senarai-staff']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;Raw Data', 'url' => ['dkums/raw-data']],
                ['label' => '<i class="fa fa-line-chart"></i>&nbsp;Statistik JAFPIB', 'url' => ['dkums/stat-by-dept']],
                ['label' => '<i class="fa fa-bar-chart"></i>&nbsp;Indeks JAFPIB', 'url' => ['dkums/indeks-jafpib']],
            ],
        ],
        [
            'label' => "<i class='fa fa-users'></i>&nbsp;Menu Ketua Pentadbiran",
            'visible' => Users::isUserPenetapPenilai(Yii::$app->user->identity->ICNO),
            'items' => [
                ['label' => '<i class="fa fa-bar-chart"></i>&nbsp;Statistik JAFPIB', 'url' => ['dkums/stat-dept']],
                ['label' => '<i class="fa fa-line-chart"></i>&nbsp;Indeks JAFPIB', 'url' => ['dkums/indeks-jafpib-ketua']],
            ],
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>