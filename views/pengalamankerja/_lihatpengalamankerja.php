<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label' => 'Nama Majikan',
              'value' => $model->OrgNm,
              'contentOptions' => ['style'=>'width:auto'],
              'captionOptions' => ['style'=>'width:26%'],
            ],
            ['label' => 'Sektor Majikan',
              'value' => $model->sekpekerjaan],
            ['label' => 'Jenis Majikan',
              'value' => $model->jenmajikan],
            ['label' => 'Nama Jawatan',
              'value' => $model->jawatan],
              ['label' => 'Kategori Pekerjaan',
              'value' => $model->katPekerjaan],
              ['label' => 'Bawa Servis',
              'value' => $model->bawServis],
              ['label' => 'Status Jawatan',
              'value' => $model->staJawatan],
            ['label' => 'Keterangan Tugas',
              'value' => $model->PrevEmpRemarks],
            ['label' => 'Tarikh Mula',
              'value' => $model->prevEmpStartDt],
            ['label' => 'Tarikh Berhenti',
              'value' => $model->prevEmpEndDt],
            
        ],
    ]) ?>