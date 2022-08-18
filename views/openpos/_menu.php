<?php

use yii\helpers\Url;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use app\models\kehadiran\TblRekod;

//$pendingReason = TblRekod::totalPendingReason();
//$ketidakpatuhan = TblRekod::totalPendingKetidakpatuhan();
//$wbb = TblRekod::totalPendingWbb();

NavBar::begin();
echo Nav::widget([
    'items' => [
           
            [
            'label' => "<i class='fa fa-user'></i>&nbsp;Tindakan Individu",
            'items' => [
                    ['label' => '<i class="fa fa-exchange"></i>&nbsp;Permohonan Baru', 'url' => ['openpos/memohon']],
                    ['label' => '<i class="fa fa-list"></i>&nbsp;Senarai Permohonan', 'url' => ['openpos/senaraipermohonan']],
            ],
        ],
            [
            'label' => "<i class='fa fa-users'></i>&nbsp;Tindakan Ketua Jabatan",
            'items' => [
                    ['label' => "<i class='fa fa-exclamation-triangle'></i>&nbsp;Senarai Menunggu Perakuan", 'url' => ['openpos/s_tindakan_permohonan']],
                   
            ],
        ],
            [
            'label' => '<i class="fa fa-edit"></i>&nbsp;Tindakan Pegawai Perjawatan ',
            'items' => [
                    ['label' => '<i class="fa fa-exclamation-triangle"></i>&nbsp;Buka Permohonan', 'url' => ['openpos/buka_permohonan']],
                    ['label' => '<i class="fa fa-exclamation-triangle"></i>&nbsp;Senarai Menunggu Pengesahan', 'url' => ['openpos/s_permohonan_individu']],
                    ['label' => '<i class="fa fa-exclamation-triangle"></i>&nbsp;Senarai Semua Permohonan', 'url' => ['openpos/download']],
            ],
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>