<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

use app\models\elnpt\Tblprcobiodata;
use app\models\elnpt\TblMain;

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
                'url' => ['elnpt/index'],
            ],
            [
                'label' => 'Penetapan Pegawai Penilai',
                'url' => ['elnpt/penetap-penilai'],
            ],
            [
                'label' => 'Pantau Pergerakan Borang',
                'url' => ['elnpt/penetap-pantau-pergerakan-borang'],
            ],
        ],
        'options' => ['class' => 'navbar-nav'],
        'encodeLabels' => false,
    ]);
NavBar::end();
?>
<br>