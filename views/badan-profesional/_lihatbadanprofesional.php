<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Lihat Badan Profesional';

?>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label' => 'Badan Profesional',
              'value' => $model->nambadanprofesional,
              'contentOptions' => ['style'=>'width:auto'],
              'captionOptions' => ['style'=>'width:26%'],
            ],
            ['label' => 'Peringkat',
            'value' => $model->peringkat ? $model->peringkat->LvlNm : '<span style="background-color:yellow;color:black;">Sila kemaskini peringkat Kelab/Persatuan/Institusi/Kesatuan ini.</span>',
            'format' => 'raw',
            ],
            ['label' => 'No. Keahlian',
              'value' => $model->membershipNo,
              'format' => 'raw',
            ],
            ['label' => 'Taraf Keahlian',
              'value' => $model->tarkeahlian],
            ['label' => 'Jawatan',
              'value' => $model->jaw],
            ['label' => 'Tarikh Mula Menyertai',
              'value' => $model->tarikhmula],
            ['label' => 'Tarikh Tamat Menyertai',
              'value' => $model->tarikhakhir],
            ['label' => 'Yuran Dikenakan',
              'value' => $model->yuran],
            ['label' => 'Status Keahlian',
              'value' => $model->staaktif],
            ['label'=>'File',
             'value'=> $model->displayLink,
             'format' => 'raw',],
             ['label' => 'URL',
            'value' => $model->url ? $model->url : '<span class="label label-warning">Sila Kemaskini</span>',
            'format' => 'raw',],
            
        ],
    ]) ?>
