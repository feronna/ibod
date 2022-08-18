<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use app\models\lnpk\TblMain;

$checkPyd = TblMain::find()->where(['PYD' => Yii::$app->user->identity->ICNO])->exists();
$checkPP = TblMain::find()->where(['OR', ['PPP' => Yii::$app->user->identity->ICNO], ['PPK' => Yii::$app->user->identity->ICNO]])->exists();

NavBar::begin();
echo Nav::widget([
    'items' => [
        [
            'label' => 'Laman Utama',
            'url' => ['lnpk/index'],
        ],
        [
            'label' => 'Senarai Borang',
            'url' => ['lnpk/senarai-borang'],
            'visible' => ($checkPyd),
        ],
        [
            'label' => 'Senarai PYD',
            'url' => ['lnpk/senarai-pyd'],
            'visible' => ($checkPP),
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>