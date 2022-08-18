<?php

use app\models\survey\TblAkses;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

NavBar::begin();
echo Nav::widget([
    'items' => [
        [
            'label' => "<i class='fa fa-check-square-o'></i>&nbsp;Menu Staff",
            'items' => [
                ['label' => '<i class="fa fa-list"></i>&nbsp;Survey', 'url' => ['survey/staff/index']],
            ],
        ],
        [
            'label' => "<i class='fa fa-user'></i>&nbsp; Menu Dekan/Ketua Jabatan",
            'visible' => TblAkses::isUserKj(Yii::$app->user->identity->ICNO),
            'items' => [
                ['label' => '<i class="fa fa-list"></i>&nbsp;Senarai Aktiviti', 'url' => ['survey/ketua/senarai-aktiviti']],
            ],
        ],
        [
            'label' => "<i class='fa fa-user'></i>&nbsp;Menu Naib Canselor",
            'visible' => TblAkses::isUserVc(Yii::$app->user->identity->ICNO),
            'items' => [
                ['label' => '<i class="fa fa-list"></i>&nbsp;Senarai Aktiviti', 'url' => ['survey/vc/senarai-aktiviti']],
            ],
        ],
        [
            'label' => "<i class='fa fa-lock'></i>&nbsp;Menu Urusetia",
            'visible' => TblAkses::isUserAdmin(Yii::$app->user->identity->ICNO),
            'items' => [
                ['label' => '<i class="fa fa-list"></i>&nbsp;Senarai Aktiviti', 'url' => ['survey/urusetia/senarai-aktiviti']],
                ['label' => '<i class="fa fa-check-square-o"></i>&nbsp;Daftar Aktiviti', 'url' => ['survey/urusetia/create-aktiviti']],
                ['label' => '<i class="fa fa-stop-circle"></i>&nbsp;Jawatan Hampir Tamat', 'url' => ['survey/urusetia/admin-post-list-tamat']],
                ['label' => '<i class="fa fa-line-chart"></i>&nbsp;Statistik Keseluruhan', 'url' => ['survey/urusetia/statistik']],
                ['label' => '<i class="fa fa-bar-chart"></i>&nbsp;Keputusan Keseluruhan', 'url' => ['survey/urusetia/keputusan']],
                ['label' => '<i class="fa fa-user"></i>&nbsp;Akses Survey', 'url' => ['survey/urusetia/senarai-akses']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;Raw Data', 'url' => ['survey/urusetia/raw-data']],
            ],
        ],
        [
            'label' => "<i class='fa fa-user'></i>&nbsp;Menu Urusetia JFPIB",
            'visible' => TblAkses::isUserUrusetia(Yii::$app->user->identity->ICNO),
            'items' => [
                ['label' => '<i class="fa fa-list"></i>&nbsp;Senarai Aktiviti', 'url' => ['survey/urusetia-jbtn/senarai-aktiviti']],
            ],
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>