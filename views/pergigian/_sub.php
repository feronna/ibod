<?php

use kartik\export\ExportMenu;

?>

 
<?= ExportMenu::widget([
    
    'dataProvider' => $dataProvider,    
    'id' => 'includedExport',
    'showFooter' =>true,
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

                'attribute'=>'KLINIK',

                'value'=>'klinik.klinik_nama',
             
            ],
           [

                'attribute'=>'TARIKH',

                'value'=>'used_dt',
               'footer' => 'Jumlah Tuntutan (RM)',

            ],
           [

                'attribute'=>'JUMLAH',
               'value' => function($dataProvider) {return'RM' ." ".$dataProvider->jumlah_tuntutan ;},
                            'footer' => 'RM '.$sum,

            ],

 
        ],

       'clearBuffers' => true, 
          'filename' => 'Rekod Tuntutan Rawatan Pergigian',
          
    
    ]);
    
?>

<br>

 