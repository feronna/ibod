<?php


use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

$icno = Yii::$app->user->getId();

$pending = app\models\ln\Ln::totalPending($icno);

NavBar::begin();
echo Nav::widget([
    'items' => [
            [
            'label' => "<i class='fa fa-user'></i>&nbsp;Tindakan Individu",
            'items' => [
                    ['label' => "<i class='fa fa-user'></i>&nbsp;Permohonan", 'url' => ['create']],
                    ['label' => "<i class='fa fa-user'></i>&nbsp;Semakan Permohonan", 'url' => ['index']],
                    ['label' => "<i class='fa fa-user'></i>&nbsp;Senarai Menunggu", 'url' => ['menunggu']],
                    ],
                
        ],
            [
            'label' => "<i class='fa fa-user'></i>&nbsp;Tindakan Pegawai",
            'items' => [
                     ['label' => "<i class='fa fa-edit'></i>&nbsp;Senarai Menunggu Tindakan", 'url' => ['menunggu2']],
                    ],
        ],
//            [
//            'label' => '<i class="fa fa-edit"></i>&nbsp;Tindakan Bendahari',
//            'items' => [
//                    ['label' => "<i class='fa fa-edit'></i>&nbsp;Senarai Menunggu Tindakan", 'url' => ['senarai-tindakan']],
//                    ['label' => "<i class='fa fa-edit'></i>&nbsp;Senarai Tindakan Selesai", 'url' => ['senarai-tindakan-s']],
//                    ],
//        ],   
      ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>