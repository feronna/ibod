<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label' => 'Kategori Anugerah',
              'value' => $model->katanugerah,
              'contentOptions' => ['style'=>'width:auto'],
              'captionOptions' => ['style'=>'width:26%'],
            ],
            ['label' => 'Nama Anugerah',
              'value' => $model->namanugerah],
            ['label' => 'Singkatan Anugerah',
              'value' => $model->AwdAbbr],
            ['label' => 'Gelaran',
              'value' => $model->gel],
            ['label' => 'Dianugerahkan Oleh',
              'value' => $model->diaoleh],
            ['label' => 'Negara',
              'value' => $model->nega],
            ['label' => 'Negeri',
              'value' => $model->nege],
            ['label' => 'Tarikh Dianugerahkan',
              'value' => $model->awdCfdDt],
            ['label' => 'Sebab Dianugerahkan',
              'value' => $model->AwdReason],
            ['label' => 'Status Anugerah',
              'value' => $model->status],
     
        ],
    ]) ?>

