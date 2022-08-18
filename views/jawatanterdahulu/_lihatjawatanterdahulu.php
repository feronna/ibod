<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Lihat Jawatan';

?>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label' => 'Nama Jawatan',
              'value' => $model->PrevPostNm,
              'contentOptions' => ['style'=>'width:auto'],
              'captionOptions' => ['style'=>'width:26%'],
            ],
            ['label' => 'Desripsi Jawatan',
              'value' => $model->PrevPostDesc],
            ['label' => 'Tarikh Mula',
              'value' => $model->prevPostStartDt],
            ['label' => 'Tarikh Akhir',
              'value' => $model->prevPostEndDt],
            
        ],
    ]) ?>