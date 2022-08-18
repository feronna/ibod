<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use app\models\elnpt\Tblprcobiodata;
use app\models\elnpt\TblMain;
use app\models\lnpk\TblMain as TblMainLnpk;

$checkPyd = TblMain::find()->where(['PYD' => Yii::$app->user->identity->ICNO])->exists();
$checkPP = TblMain::find()->where(['OR', ['PPP' => Yii::$app->user->identity->ICNO], ['PPK' => Yii::$app->user->identity->ICNO]])->exists();

$query = TblMain::find()
    ->where(['PYD' => Yii::$app->user->identity->ICNO])
    ->exists();
$query2022 = TblMain::find()
    ->where(['PYD' => Yii::$app->user->identity->ICNO])
    ->andWhere(['tahun' => 2022])
    ->one();
$query1 = TblMain::find()
    ->where([
        'or', ['PPP' => Yii::$app->user->identity->ICNO],
        ['PPK' => Yii::$app->user->identity->ICNO],
        ['PEER' => Yii::$app->user->identity->ICNO]
    ])
    ->exists();
NavBar::begin();
echo Nav::widget([
    'items' => [
        [
            'label' => 'Laman Utama',
            'url' => ['elnpt/index'],
        ],
        [
            'label' => 'eLNPT',
            'visible' => $query,
            'items' => [
                [
                    'label' => 'Isi Borang',
                    'url' => ['elnpt/borang'],
                ],
                [
                    'label' => 'Arkib',
                    'url' => ['elnpt/arkib-borang'],
                ],
            ]
        ],
        [
            'label' => 'Senarai PYD',
            'visible' => $query or $query1,
            'items' => [
                [
                    'label' => 'Sebagai PPP',
                    'url' => ['elnpt/senarai-pyd-ppp'],
                ],
                [
                    'label' => 'Sebagai PPK',
                    'url' => ['elnpt/senarai-pyd-ppk'],
                ],
                [
                    'label' => 'Sebagai PEER',
                    'url' => ['elnpt/senarai-pyd-peer'],
                ],
            ]
        ],
        [
            'label' => 'Penetap Penilai',
            'url' => ['elnpt/penetap-penilai'],
            'visible' => \app\models\elnpt\TblPenetapPenilai::find()
                ->leftJoin(['a' => 'hrm.elnpt_tbl_lpp_tahun'], 'a.lpp_tahun = hrm.elnpt_tbl_penetap_penilai.tahun and a.lpp_aktif = \'Y\'')
                ->where(['penetap_icno' => Yii::$app->user->identity->ICNO])
                ->exists(),
        ],
        [
            'label' => 'Rujukan / Pertanyaan',
            'visible' => true,
            'url' => ['elnpt2/rujukan-panduan'],
        ],
        [
            'label' => '<b><font color="blue">Data LNPT</font></b>',
            'visible' => \app\models\elnpt\testing\TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => [1, 3]])->exists(),
            'url' => ['elnpt/bengkel-data'],
        ],
        // [
        //     'label' => 'Calculator LNPT <sup><span class="label label-success">New</span></sup>',
        //     'url' => ['elnpt2/calculator-lnpt'],
        // ],
        [
            'label' => 'LNPK',
            'visible' => ($checkPyd || $checkPP),
            'url' => ['lnpk/index'],
        ],
    ],
    'options' => ['class' => 'navbar-nav', 'id' => 'navbar-id',],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>