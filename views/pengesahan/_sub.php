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

                'attribute'=>'NAMA',

                'value'=>'kakitangan.CONm',

            ],
            [

                'attribute'=>'TARIKH MOHON',

                'value'=>'tarikhmohon',

            ],
            [

                'attribute'=>'UMS (PER)',

                'value'=>'kakitangan.COOldID',

            ],
            [

                'attribute'=>'GRED & JAWATAN',

                'value'=>'kakitangan.jawatan.fname',

            ],
            [

                'attribute'=>'JAFPIB',

                'value'=>'kakitangan.department.fullname',

            ],

        ],

       'clearBuffers' => true, 
          'filename' => 'Rekod Laporan Pengesahan Dalam Perkhidmatan',
          
    
    ]);
    
?>

<br>

 

 