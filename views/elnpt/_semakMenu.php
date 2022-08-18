<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

$lpp = app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]);

$item = [];
$items = [
    [
        'label' => 'Menu Utama',
        'url' => ($lpp->PPP == Yii::$app->user->identity->ICNO or $lpp->PPK == Yii::$app->user->identity->ICNO
        or $lpp->PEER == Yii::$app->user->identity->ICNO) ? ['elnpt/index'] : ['elnpt/dashboard']
    ],
    [
        'label' => 'Maklumat Guru',
        'url' => ['elnpt/maklumat-guru', 'lppid' => $lppid]
    ]
];
foreach($mrkh_all as $ind => $bbb) {
    $item[$ind]['label'] = $bbb['bahagian'];
    if($bbb['bhg_kod'] == 'ringkasan'){
        //$item[$ind]['url'] = (array)('elnpt/lppid='.$lppid);
        $item[$ind]['url'] = ['elnpt/semak-'.$bbb['bhg_kod'], 'lppid' => $lppid];
        //continue;
    }else{
        //$item[$ind]['url'] = (array)('elnpt/semak-lpp?lppid='.$lppid.'&bhg_no='.$bbb['id']);
        $item[$ind]['url'] = ['elnpt/semak-lpp', 'lppid' => $lppid, 'bhg_no' => $bbb['id']];
    }
    array_push($items, $item[$ind]);
}

$pengesahan = [
    'label' => 'Pengesahan',
    'url' => ['elnpt/pengesahan-borang', 'lppid' => $lppid]
];

//$pengesahan1 = [
//        'label' => 'Pengesahan Markah',
//        'url' => ['elnpt/pengesahan-markah', 'lppid' => $lppid]
//];

array_push($items, $pengesahan);
//array_push($items, $pengesahan1);

//echo print_r($items);

NavBar::begin();
    echo Nav::widget([
        'items' => $items,
        'options' => ['class' => 'navbar-nav'],
        'encodeLabels' => false,
    ]);
NavBar::end();
?>
<br>