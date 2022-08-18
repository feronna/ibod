<?php


use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

$icno = Yii::$app->user->getId();

$pending = app\models\cbelajar\TblPermohonan::totalPending($icno);

NavBar::begin();
echo Nav::widget([
    'items' => [
            
            [
            'label' => "<i class='fa fa-user'></i>&nbsp;Tindakan Individu",
            'items' => [

                    ['label' => "<i class='fa fa-home'></i>&nbsp;Halaman Utama", 'url' => ['halaman-utama-pemohon']],
                    ['label' => "<i class='fa fa-list'></i>&nbsp;Semakan Permohonan", 'url' => ['permohonan-semasa']],
                    
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

                    ['label' => "<i class='fa fa-home'></i>&nbsp;Halaman Utama", 'url' => ['cbelajar/halaman-utama-bsm']],
                    ['label' => "<i class='fa fa-user'></i>&nbsp;Senarai Permohonan", 'url' => ['cutibelajar/senarai']],
                    ['label' => '<i class="fa fa-exclamation-triangle"></i>&nbsp;Tambah Admin', 'url' => ['tambahadmin']],

                    ],
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>