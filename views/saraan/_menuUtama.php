<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

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
                'url' => ['saraan/index'],
            ],
            [
                'label' => 'Laman Admin',
                'url' => ['saraan/dashboard'],
            ],
        ],    
        'options' => ['class' => 'navbar-nav'],
        'encodeLabels' => false,
    ]);
NavBar::end();
?>
<br>