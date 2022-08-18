<?php


use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

$icno = Yii::$app->user->getId();

$pending = app\models\pengesahan\Pengesahan::totalPending($icno);

NavBar::begin();
echo Nav::widget([
    'items' => [
            
            [
            'label' => "<i class='fa fa-user'></i>&nbsp;Tindakan Individu",
            'items' => [
                    ['label' => "<i class='fa fa-user'></i>&nbsp;Permohonan", 'url' => ['mohonpengesahan']],
                    
                    ],
        ],
//            [
//            'label' => "<i class='fa fa-edit'></i>&nbsp;Tindakan Pegawai$pending",
//            'items' => [
//                     ['label' => "<i class='fa fa-user'></i>&nbsp;Menunggu Tindakan", 'url' => ['menunggu']],
//                    ],
//        ],
            [
            'label' => "<i class='fa fa-edit'></i>&nbsp;Tindakan Ketua Jabatan",
            'items' => [
                     ['label' => "<i class='fa fa-user'></i>&nbsp;Menunggu Tindakan", 'url' => ['menunggu']],
                    ],
        ],
        [
            'label' => '<i class="fa fa-edit"></i>&nbsp;Tindakan BSM',
            'items' => [
                    ['label' => "<i class='fa fa-user'></i>&nbsp;Senarai Permohonan", 'url' => ['senarai']],
                 ['label' => "<i class='fa fa-user'></i>&nbsp;Senarai Status Pengesahan", 'url' => ['senarai']],
                    ['label' => '<i class="fa fa-exclamation-triangle"></i>&nbsp;Tambah Admin', 'url' => ['tambahadmin']],
                 ['label' => '<i class="fa fa-exclamation-triangle"></i>&nbsp;Urus Mesyuarat', 'url' => ['urus-mesyuarat']],
                 ['label' => '<i class="fa fa-exclamation-triangle"></i>&nbsp;Tetapan', 'url' => ['tetapan']],
                    ],
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>