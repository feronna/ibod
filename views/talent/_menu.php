<?php

use app\models\survey\TblAkses;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

NavBar::begin();
echo Nav::widget([
    'items' => [
        [
            'label' => "<i class='fa fa-users'></i>&nbsp;Talent Pool",
            'visible' => TblAkses::isUserAdmin(Yii::$app->user->identity->ICNO),
            'items' => [
                ['label' => '<i class="fa fa-list"></i>&nbsp;Kriteria 1', 'url' => ['talent/index']],
                ['label' => '<i class="fa fa-table"></i>&nbsp;Kriteria 2', 'url' => ['talent/kriteria2']],
                ['label' => '<i class="fa fa-tasks"></i>&nbsp;Kriteria 3', 'url' => ['talent/kriteria3']],
                ['label' => '<i class="fa fa-tasks"></i>&nbsp;Kriteria 4', 'url' => ['talent/kriteria4']],
            ],
        ],
        [
            'label' => "<i class='fa fa-wrench'></i>&nbsp;Tetapan",
            'visible' => TblAkses::isUserAdmin(Yii::$app->user->identity->ICNO),
            'items' => [
                ['label' => '<i class="fa fa-sliders"></i>&nbsp;Jawatan & Gred', 'url' => ['talent/gred-setting']],
            ],
        ],
        
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>