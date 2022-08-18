<?php
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

//$pendingReason = TblRekod::totalPendingReason();
//$ketidakpatuhan = TblRekod::totalPendingKetidakpatuhan();
//$wbb = TblRekod::totalPendingWbb();

NavBar::begin();
echo Nav::widget([
    'items' => [
           
             [
            'label' => "<i class='fa fa-user'></i>&nbsp;Tindakan Individu",
            'items' => [
                    ['label' => '<i class="fa fa-exchange"></i>&nbsp;Permohonan', 'url' => ['kemudahan/lihat_tuntutan']],
                    ['label' => '<i class="fa fa-list"></i>&nbsp;Senarai Permohonan', 'url' => ['borang/senarai']],
        //        ['label' => '<i class="fa fa-list"></i>&nbsp;Testing Page', 'url' => ['borang/testyear' ]],
            ],
        ],
            [
            'label' => "<i class='fa fa-users'></i>&nbsp;Tindakan Ketua Jabatan",
            'items' => [
//              ['label' => "<i class='fa fa-exclamation-triangle'></i>&nbsp;Menunggu Tindakan", 'url' => ['borang/senarai2']],
                ['label' => '<i class="fa fa-exclamation-triangle"></i>&nbsp;Menunggu Tindakan', 'url' => ['borang/senarai_tindakan']],
                   
            ],
        ],
        [
           'label' => "<i class='fa fa-user'></i>&nbsp;Tindakan Pegawai Penyelia",
           'items' => [
//              ['label' => "<i class='fa fa-exclamation-triangle'></i>&nbsp;Menunggu Tindakan", 'url' => ['borang/senarai_permohonan2']],
                ['label' => '<i class="fa fa-exclamation-triangle"></i>&nbsp;Menunggu Tindakan', 'url' => ['borang/senarai_tindakan']],
                   
            ],
        ],
            [
            'label' => '<i class="fa fa-user"></i>&nbsp;Tindakan Pegawai BSM ',
            'items' => [
                    ['label' => '<i class="fa fa-exclamation-triangle"></i>&nbsp;Daftar Jenis Kemudahan', 'url' => ['kemudahan/daftar_tuntutan']],
                    ['label' => '<i class="fa fa-exclamation-triangle"></i>&nbsp;Senarai Kemudahan', 'url' => ['kemudahan/senarai_tuntutan']],
//                  ['label' => '<i class="fa fa-exclamation-triangle"></i>&nbsp;Menunggu Tindakan', 'url' => ['borang/senarai_permohonan']],
                    ['label' => '<i class="fa fa-exclamation-triangle"></i>&nbsp;Menunggu Tindakan', 'url' => ['borang/senarai_tindakan']],
                    ['label' => '<i class="fa fa-exclamation-triangle"></i>&nbsp;Senarai Semua Permohonan', 'url' => ['borang/senarai_berjaya']],
                     ['label' => '<i class="fa fa-exclamation-triangle"></i>&nbsp;Laporan', 'url' => ['borang/laporan']],
            ],
        ],
        [
            'label' => '<i class="fa fa-user"></i>&nbsp;Tindakan Bendahari ',
            'items' => [
                    ['label' => '<i class="fa fa-exclamation-triangle"></i>&nbsp;Menunggu Tindakan', 'url' => ['borang/senarai_bendahari']],
                   
            ],
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>
