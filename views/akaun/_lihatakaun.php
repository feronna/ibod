<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label' => 'No. Akaun',
              'value' => $model->AccNo,
              'contentOptions' => ['style'=>'width:auto'],
              'captionOptions' => ['style'=>'width:26%'],
            ],
            ['label' => 'Jenis Akaun',
              'value' => $model->jenakaun],
            ['label' => 'Tujuan Akaun',
              'value' => $model->tujakaun],
            ['label' => 'Nama Bank/Institusi',
              'value' => $model->namakaun],
            ['label' => 'Cawangan Akaun',
              'value' => $model->cawakaun],
            ['label' => 'Daerah',
              'value' => $model->banakaun],
            ['label' => 'Nama Cawangan Akaun',
              'value' => $model->namcawakaun],
            ['label' => 'Status Akaun',
              'value' => $model->staakaun],
            ['label'=>'File',
             'value'=> $model->displayLink, 
             'format' => 'raw',],
        ],
    ]) ?>