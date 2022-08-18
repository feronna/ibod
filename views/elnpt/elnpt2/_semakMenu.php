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
        'url' => ['elnpt2/maklumat-guru', 'lppid' => $lppid]
    ]
];
foreach ($mrkh_all as $ind => $bbb) {
    $item[$ind]['label'] = $bbb['bahagian'];
    if ($bbb['bhg_kod'] == 'ringkasan') {
        //$item[$ind]['url'] = (array)('elnpt/lppid='.$lppid);
        $item[$ind]['url'] = ['elnpt2/semak-' . $bbb['bhg_kod'], 'lppid' => $lppid];
        //continue;
    } else {
        //$item[$ind]['url'] = (array)('elnpt/semak-lpp?lppid='.$lppid.'&bhg_no='.$bbb['id']);
        $item[$ind]['url'] = ['elnpt2/semak-lpp', 'lppid' => $lppid, 'bhg_no' => $bbb['id']];
    }
    array_push($items, $item[$ind]);
}

$ringkasan = [
    'label' => 'Ringkasan',
    'url' => ['elnpt2/semak-ringkasan', 'lppid' => $lppid]
];

$pengesahan = [
    'label' => 'Pengesahan',
    'url' => ['elnpt2/pengesahan-borang-penilai', 'lppid' => $lppid]
];

$kilanan = [
    'label' => 'Perkhidmatan Tahun <sup><span class="label label-success">Baru</span></sup>',
    'url' => ['elnpt2/semak-perkhidmatan-tahun', 'lppid' => $lppid],
    // 'visible' => $sah,
];

//$pengesahan1 = [
//        'label' => 'Pengesahan Markah',
//        'url' => ['elnpt/pengesahan-markah', 'lppid' => $lppid]
//];
array_push($items, $ringkasan);
array_push($items, $kilanan);
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