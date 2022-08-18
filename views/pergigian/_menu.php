<?php


use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;


NavBar::begin();
echo Nav::widget([
    'items' => [
            [
            'label' => "<i class='fa fa-user'></i>&nbsp;Tindakan Individu",
            'items' => [
                    ['label' => "<i class='fa fa-user'></i>&nbsp;Tuntutan Baru", 'url' => ['create']],
                    ['label' => "<i class='fa fa-user'></i>&nbsp;Senarai Klinik Pergigian", 'url' => ['senaraiklinik']],
                    
                    ],
        ],
            [
            'label' => "<i class='fa fa-edit'></i>&nbsp;Tindakan Pegawai",
            'items' => [
                     ['label' => "<i class='fa fa-edit'></i>&nbsp;Senarai Menunggu Tindakan", 'url' => ['senarai-tindakan']],
                     ['label' => "<i class='fa fa-edit'></i>&nbsp;Senarai Tindakan Selesai", 'url' => ['senarai-tindakan-s']],
                     ['label' => "<i class='fa fa-edit'></i>&nbsp;Senarai Rekod Tuntutan", 'url' => ['rekod-tuntutan']],
                     ['label' => "<i class='fa fa-edit'></i>&nbsp;Selenggara Klinik Pergigian", 'url' => ['selenggaraklinik']],
                     ['label' => "<i class='fa fa-edit'></i>&nbsp;Statistik", 'url' => ['statistik-bulanan']],
                    ],
        ],
            [
            'label' => '<i class="fa fa-edit"></i>&nbsp;Tindakan Bendahari',
            'items' => [
                    ['label' => "<i class='fa fa-edit'></i>&nbsp;Senarai Menunggu Tindakan", 'url' => ['senarai-tindakan']],
                    ['label' => "<i class='fa fa-edit'></i>&nbsp;Senarai Tindakan Selesai", 'url' => ['senarai-tindakan-s']],
                    ],
        ],   
            [
            'label' => '<i class="fa fa-lock"></i>&nbsp;Administrator',
            'items' => [
                    ['label' => "<i class='fa fa-edit'></i>&nbsp;Tambah Admin", 'url' => ['akses-pengguna']],                    
                    ],
        ],   
      ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>