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
                    
                     ['label' => '<i class="fa fa-list"></i>&nbsp;Halaman Utama', 'url' => ['cbelajar/halaman-utama-pemohon']],
                      ['label' => '<i class="fa fa-exchange"></i>&nbsp;Permohonan', 'url' => ['cbelajar/permohonan-semasa']],
            ],
        ],
            [
           'label' => "<i class='fa fa-users'></i>&nbsp;Tindakan Ketua Jabatan",
            'items' => [
                ['label' => "<i class='fa fa-exclamation-triangle'></i>&nbsp;Menunggu Tindakan", 'url' => ['cbelajar/senarai2']],
                   
            ],
        ],
        [
           'label' => "<i class='fa fa-user'></i>&nbsp;Tindakan Pegawai Penyelia",
            'items' => [
                 ['label' => "<i class='fa fa-exclamation-triangle'></i>&nbsp;Menunggu Tindakan", 'url' => ['cbelajar/senarai-tindakan-permohonan-bsm']],
                   
            ],
        ],
            [
            'label' => '<i class="fa fa-user"></i>&nbsp;Tindakan Pegawai BSM ',
            'items' => [
                    ['label' => '<i class="fa fa-home"></i>&nbsp;Halaman Utama', 'url' => ['cbelajar/halaman-utama-bsm']],

                      ['label' => '<i class="fa fa-list"></i>&nbsp;Senarai Permohonan', 'url' => ['cbelajar/senarai-tindakan-permohonan']],
                    
            //      ['label' => '<i class="fa fa-user"></i>&nbsp;Tambah Pegawai Penyelia'],
            ],
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>
