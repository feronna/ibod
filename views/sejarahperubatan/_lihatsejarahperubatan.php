<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label' => 'Nama Penyakit',
              'value' => $model->jenpenyakit,
              'contentOptions' => ['style' => 'width:auto'],
              'captionOptions' => ['style' => 'width:26%'],
            ],
            ['label' => 'Tahun',
              'value' => $model->Year],
            ['label' => 'Rawatan',
              'value' => $model->MedTreatment],
            ['label' => 'Tarikh Mula Rawatan',
              'value' => $model->treatmentStartDt],
            ['label' => 'Tarikh Akhir Rawatan',
              'value' => $model->treatmentEndDt],
            
        ],
    ]) ?>