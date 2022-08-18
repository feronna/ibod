<?php
use kartik\export\ExportMenu;
?>
<?= ExportMenu::widget([
    
    'dataProvider' => $dataProvider,    
    'id' => 'includedExport',
       'columns' => [

            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'BIL'
            ],
           
            [
                'attribute'=>'NAMA',

                'value'=>'kakitangan.CONm',

            ],

            [
                'attribute'=>'JAWATAN',

                'value'=>'kakitangan.jawatan.fname',

            ],
           
            [

                'attribute'=>'TARIKH',
                'value'=>'entrydate',
            ],

        ],

            'clearBuffers' => true, 
            'filename' => 'Rekod Laporan Permohonan Bertugas Rasmi Ke Luar Negara',
    ]);
    
?>

<br>

 

 