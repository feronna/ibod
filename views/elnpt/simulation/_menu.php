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
        'url' => ['simulation/elnpt/maklumat-guru', 'lppid' => $lppid]
    ]
];
foreach ($menu as $ind => $bbb) {
    $item[$ind]['label'] = $bbb['bahagian'];
    //    $item[$ind]['url'] = (array)('elnpt/'.($bbb['bhg_kod'].'?lppid='.$lppid));
    $item[$ind]['url'] = ['simulation/elnpt/' . $bbb['bhg_kod'], 'lppid' => $lppid];
    array_push($items, $item[$ind]);
}

array_push($items, [
    'label' => 'Ringkasan',
    'url' => ['simulation/elnpt/ringkasan', 'lppid' => $lppid]
]);

$pengesahan = [
    'label' => 'Pengesahan',
    'url' => ['simulation/elnpt/pengesahan-borang', 'lppid' => $lppid]
];

$maklum = [
    'label' => 'Maklum Balas Sistem (Google Form)',
    'url' => 'https://docs.google.com/forms/d/17WocQVoYhak7iIL6YYwBxwDI0cgmKXefRhdkpHJK9mY/edit?ts=5fe2a901&gxids=7628',
    // 'visible' => $sah,
    'linkOptions' => ['target' => '_blank'],
];

$pengesahan1 = [
    'label' => 'Semakan Markah',
    'url' => ['simulation/elnpt/pengesahan-markah', 'lppid' => $lppid],
    'visible' => $sah,
];

// array_push($items, $pengesahan);
// array_push($items, $maklum);
// array_push($items, $pengesahan1);

NavBar::begin();
echo Nav::widget([
    'items' => $items,
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>