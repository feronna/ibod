<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        ['label' => 'Kluster Kepakaran',
            'value' => $model->bidkepakaran,
            'contentOptions' => ['style' => 'width:auto'],
            'captionOptions' => ['style' => 'width:26%'],],
        ['label' => 'Bidang Kepakaran',
            'value' => $model->bidang],
        ['label' => 'File',
            'value' => $model->displayLink,
            'format' => 'raw',],
        ],
]);
?>