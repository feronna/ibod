<?php

use kartik\export\ExportMenu;

?>

<?= ExportMenu::widget([
    
    'dataProvider' => $dataProvider,    
    'id' => 'includedExport',
       'columns' => [

            ['class' => 'yii\grid\SerialColumn',
                  'header' => 'BIL',],
           
           [

                'label'=>'TAHUN',

                'value'=>'tahun',

            ],
            [

                'label'=>'NAMA',

                'value'=>'kakitangan.CONm',

            ],
           [

                'label'=>'UMUR',

                'value'=>'kakitangan.umur',

            ],
           [

                'label'=>'UMSPER',

                'value'=>'kakitangan.COOldID',

            ],
           [

                'label'=>'NO. KP',

                'value'=>'kakitangan.ICNO',

            ],
         
          [

                'label'=>'GRED JAWATAN',

                'value'=>'kakitangan.jawatan.gred',

            ],
 
            [

                'label'=>'JFPIB',

                'value'=>'kakitangan.department.shortname',

            ],
           
           [

                'label'=>'EMEL',

                'value'=>'kakitangan.COEmail',

            ],
           
            [

                'label'=>'PERINGKAT PENGAJIAN',

                'value'=>'pengajian.pendidikanTertinggi.HighestEduLevel',

            ],
           
           [

                'label'=>'UNIVERSITI / PENEMPATAN',

                'value'=>'pengajian.InstNm',

            ],
           
            [

                'label'=>'NEGARA',

                'value'=>'pengajian.negara.Country',

            ],
           
            [

                'label'=>'BIDANG',

                'value'=>'pengajian.mod.studyMode',

            ],
           
            [

                'label'=>'TAJAAN',

                'value'=>'biasiswa.nama_tajaan',

            ],
            [
                'label' => 'MULA',
                'value' => 'pengajian.tarikhmula'
                ],
                
                [
                'label' => 'TAMAT',
                'value' => 'pengajian.tarikhtamat'
                ],
                 
                [
                'label' => 'LANJUTAN 01',
//                'value' => 
                ],
               
                [
                'label' => 'LANJUTAN 02',
//                'value' => ""
                ],
               
                [
                'label' => 'LANJUTAN 03',
//                'value' => ""
                ],
                
        ],

       'clearBuffers' => true, 
          'filename' => 'Rekod Laporan Pengajian Lanjutan',
          
    
    ]);
    
?>

<br>

 