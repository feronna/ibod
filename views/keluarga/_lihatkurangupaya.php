<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<?= DetailView::widget([
        
        'model' => $model,
        'attributes' => [
            ['label' => 'No. Kad OKU',
              'value' => $model->socialwelfareno,
              'contentOptions' => ['style' => 'width:auto'],
              'captionOptions' => ['style' => 'width:26%'],
            ],
            ['label' => 'No. Laporan Doktor',
              'value' => $model->drrptno,  
            ],
            ['label' => 'Jenis Kecacatan',
              'value' => $model->jenkecacatan,
            ],
            ['label' => 'Tarikh Kad Dikeluarkan',
              'value' => $model->tarikhkad
              ,
            ],
            ['label' => 'Dokumen Sokongan',
              'value'=> $model->displayLink, 
             'format' => 'raw',
            ],
            
        ],
    ]) ?>
