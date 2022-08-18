<?php

use yii\helpers\Url;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use app\models\kehadiran\TblRekod;



NavBar::begin();
echo Nav::widget([
    'items' => [
     
       
        
        [
            'label' => "<i class='fa fa-edit'></i>&nbsp". Yii::t('app', 'Tindakan Pegawai'),
            'items' => [
             
                    ['label' => "<i class='fa fa-list'></i>&nbsp;Senarai Permohonan", 'url' => ['brp/tindakan-ketua']],
           
                
                ]
        ],
           [
            'label' => '<i class="fa fa-edit"></i>&nbsp;Tindakan Admin',
            'items' => [
                
                    ['label' => '<i class="fa fa-list"></i>&nbsp;Senarai Permohonan', 'url' => ['brp/senarai-permohonan']],
                   
                    ['label' => '<i class="fa fa-list"></i>&nbsp;Tambah Admin', 'url' => ['brp/tambah-admin']],

            ],
        ],
      
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>