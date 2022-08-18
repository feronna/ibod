<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use app\models\lppums\TblBahagianKriteria;


NavBar::begin();
    echo Nav::widget([
        'items' => [
                    [
                        'label' => 'Bahagian 1',
                        'url' => ['skt-bahagian1', 'lpp_id' => $lppid],
                    ],
                    [
                        'label' => 'Bahagian 2',
                        'url' => ['skt-bahagian2', 'lpp_id' => $lppid],
                    ],
                    [
                        'label' => 'Bahagian 3',
                        'url' => ['skt-bahagian3', 'lpp_id' => $lppid],
                    ]
//            [
//                'label' => 'Bahagian',
//                'items' => [
                    
        ],
        'options' => ['class' => 'navbar-nav'],
        'encodeLabels' => false,
    ]);
NavBar::end();
?>
<br>