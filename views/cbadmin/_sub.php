<?php
use kartik\export\ExportMenu;
?>
<?= ExportMenu::widget([
    
    'dataProvider' => $dataProvider,    
    'id' => 'includedExport',
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

                'attribute'=>'TARIKH',

                'value'=>'tarikh_m',

            ],

        ],

       'clearBuffers' => true, 
          'filename' => 'Rekod Laporan Pengesahan Dalam Perkhidmatan',
          
    
    ]);
    
?>

<br>

 

 