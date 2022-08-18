<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use app\models\lnpk\TblMain;

$lnpk = TblMain::findOne($lnpk_id);

NavBar::begin();
echo Nav::widget([
    'items' => [
        [
            'label' => 'Laman Utama',
            'url' => ['lnpk/index'],
        ],
        [
            'label' => 'Senarai PYD',
            'url' => ['lnpk/senarai-pyd'],
            'visible' => ($lnpk->PPP == \Yii::$app->user->identity->ICNO),
        ],
        [
            'label' => 'Bahagian 1',
            'url' => ['lnpk/bahagian1', 'lnpk_id' => $lnpk_id],
        ],
        [
            'label' => 'Bahagian 2',
            'url' => ['lnpk/bahagian2', 'lnpk_id' => $lnpk_id],
        ],
        [
            'label' => 'Bahagian 3',
            'url' => ['lnpk/bahagian3', 'lnpk_id' => $lnpk_id],
        ],
        [
            'label' => 'Sasaran Kerja & Laporan Pencapaian',
            'url' => ['lnpk/bahagian-skt-pencapaian', 'lnpk_id' => $lnpk_id],
            'visible' => ($lnpk->lnpk_jenis == 2)
        ],
        [
            'label' => 'Pengesahan',
            'url' => ['lnpk/pengesahan', 'lnpk_id' => $lnpk_id],
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>