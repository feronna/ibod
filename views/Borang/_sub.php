<?php

use kartik\export\ExportMenu;

?>

 
<?= ExportMenu::widget([
    
    'dataProvider' => $dataProvider,    
    'id' => 'includedExport',
    'showFooter' => true,
       'columns' => [

            ['class' => 'yii\grid\SerialColumn',
                  'header' => 'Bil',],
            [

                'attribute'=>'NAMA',

                'value'=>'kakitangan.CONm',

            ],
           [

                'attribute'=>'ICNO',

                'value'=>'icno',

            ],
           [

                'attribute'=>'JAWATAN',

                'value'=>'kakitangan.jawatan.fname',

            ],
           [

                'attribute'=>'Destinasi',

                'value'=>'nama_tempat'

            ],
           [

                'attribute'=>'TARIKH',

                'value'=>'entrydate',
                'footer' => 'Jumlah'

            ],
           [

                'attribute'=>'JUMLAH',
                'value' => function($dataProvider) { return 'RM' . " " . $dataProvider->jumlah ;}, 
                'footer' => 'RM  '.$sum,

            ],
             
 
        ],

       'clearBuffers' => true, 
          'filename' => 'Rekod Laporan Pemakaian Elaun Pakaian Panas',
          
    
    ]);
    
?>

<br>

 