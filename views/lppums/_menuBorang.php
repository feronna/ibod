<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use app\models\lppums\TblBahagianKriteria;

$lpp = app\models\lppums\TblMain::findOne($lppid);
$var1 = (app\models\lppums\TblMain::find()->where(['lpp_id' => $lppid, 'PYD' => \Yii::$app->user->identity->ICNO])->exists());
$var2 = \app\models\lppums\TblStafAkses::find()
    ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
    ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
    ->andWhere(['IS NOT', 'a.akses_lpp', NULL])
    ->exists();


$test = TblBahagianKriteria::find()
    ->select(['hrm.lppums_bahagian_has_kriteria.*', 'hrm.lppums_kriteria.*'])
    ->joinWith('kriteria')
    ->where(['kump_khidmat' => $lpp->gredJawatan->job_group])
    ->all();

$test2 = \yii\helpers\ArrayHelper::getColumn($test, 'bahagian_id');

$tahun = app\models\lppums\TblLppTahun::find()->where(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun])->one();

NavBar::begin();
echo Nav::widget([
    'items' => [
        [
            'label' => 'Laman Utama',
            'url' => ['lppums/index'],
        ],
        [
            'label' => 'Borang LPP',
            'url' => ['lppums/borang-lpp'],
            'visible' => $var1,
        ],
        [
            'label' => 'Senarai Tugas',
            'url' => [(($lpp->tahun >= 2022)) ? 'lppums/senarai-tugas-baru' : 'lppums/senarai-tugas', 'lpp_id' => $lppid],
        ],
        [
            'label' => 'SKT',

            'items' => [
                [
                    'label' => 'Bahagian 1',
                    'url' => [(($lpp->tahun >= 2022)) ? 'lppums/skt-bahagian1-test' : 'lppums/skt-bahagian1', 'lpp_id' => $lppid],
                ],
                [
                    'label' => 'Bahagian 2',
                    'url' => ['lppums/skt-bahagian2', 'lpp_id' => $lppid],
                ],
                [
                    'label' => 'Bahagian 3',
                    'url' => ['lppums/skt-bahagian3', 'lpp_id' => $lppid],
                ]
            ]
        ],


        [
            'label' => 'Bahagian I',
            'format' => 'html',
            'url' => ['lppums/bahagian1', 'lpp_id' => $lppid],
        ],
        [
            'label' => 'Bahagian II',
            'url' => [(($lpp->tahun >= 2022)) ? 'lppums/bahagian2-test' : 'lppums/bahagian2', 'lpp_id' => $lppid],
        ],
        [
            'label' => 'Bahagian III',
            'url' => (!$var1 && in_array(1, $test2) or $var2) ? [(($lpp->tahun >= 2022)) ? 'lppums/bahagian3-test' :  'lppums/bahagian3', 'lpp_id' => $lppid] : '#',
            'options' => (!$var1 && in_array(1, $test2) or $var2) ? [] : ['style' => 'opacity: 0.5'],
        ],
        [
            'label' => 'Bahagian IV',
            'url' => (!$var1 && in_array(3, $test2) or $var2) ? [(($lpp->tahun >= 2022)) ? 'lppums/bahagian4-test' :  'lppums/bahagian4', 'lpp_id' => $lppid] : '#',
            'options' => (!$var1 && in_array(3, $test2) or $var2) ? [] : ['style' => 'opacity: 0.5']
        ],
        [
            'label' => 'Bahagian V',
            'url' => (!$var1 && in_array(2, $test2) or $var2) ? [(($lpp->tahun >= 2022)) ? 'lppums/bahagian5-test' : 'lppums/bahagian5', 'lpp_id' => $lppid] : '#',
            'options' => (!$var1 && in_array(2, $test2) or $var2) ? [] : ['style' => 'opacity: 0.5']
        ],
        [
            'label' => 'Bahagian VI',
            'url' => (!$var1 && in_array(4, $test2) or $var2) ? [(($lpp->tahun >= 2022)) ? 'lppums/bahagian6-test' : 'lppums/bahagian6', 'lpp_id' => $lppid] : '#',
            'options' => (!$var1 && in_array(4, $test2) or $var2) ? [] : ['style' => 'opacity: 0.5']
        ],
        [
            'label' => 'Bahagian VII',
            'url' => ['lppums/bahagian7', 'lpp_id' => $lppid],

        ],
        [
            'label' => 'Bahagian VIII',
            'url' => ['lppums/bahagian8', 'lpp_id' => $lppid],
        ],
        [
            'label' => 'Bahagian IX',
            'url' => ['lppums/bahagian9', 'lpp_id' => $lppid],
        ],
        [
            'label' => 'Pengesahan',
            'url' => ['lppums/pengesahan', 'lpp_id' => $lppid],
        ],
        [
            'label' => 'Borang Maklumbalas dan Aduan',
            'url' => 'https://docs.google.com/forms/d/e/1FAIpQLSf9gOTlyCBc8r4TpfBTzJFcbbclGvTeCBdq1_kldHW4QW2jyg/viewform?vc=0&c=0&w=1&flr=0',
            'visible' => $lpp->tahun == 2022,
            'linkOptions' => ['target' => '_blank'],
        ],
        [
            'label' => 'Semakan Markah',
            'url' => ['lppums/pengesahan-markah', 'lpp_id' => $lppid],
            'visible' => !is_null($tahun) ? (($lpp->tahun == $tahun->lpp_tahun)) : false,
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>