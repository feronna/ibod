<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

$item = [];
$items = [
    [
        'label' => 'Menu Utama',
        'url' => ['elnpt/index']
    ],
    [
        'label' => 'Maklumat Guru',
        'url' => ['elnpt/maklumat-guru', 'lppid' => $lppid]
    ]
];
foreach($mrkh_all as $ind => $bbb) {
    $item[$ind]['label'] = $bbb['bahagian'];
//    $item[$ind]['url'] = (array)('elnpt/'.($bbb['bhg_kod'].'?lppid='.$lppid));
    $item[$ind]['url'] = ['elnpt/'.$bbb['bhg_kod'], 'lppid' => $lppid];
    array_push($items, $item[$ind]);
}

$pengesahan = [
    'label' => 'Pengesahan',
    'url' => ['elnpt/pengesahan-borang', 'lppid' => $lppid]
];

$pengesahan1 = [
        'label' => 'Semakan Markah',
        'url' => ['elnpt/pengesahan-markah', 'lppid' => $lppid]
];

array_push($items, $pengesahan);
array_push($items, $pengesahan1);

NavBar::begin();
    echo Nav::widget([
        'items' => $items,
        'options' => ['class' => 'navbar-nav'],
        'encodeLabels' => false,
    ]);
NavBar::end();
?>
<br>