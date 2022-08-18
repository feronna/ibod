<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label' => 'Nama Bahasa',
              'value' => $model->bahasa,
              'contentOptions' => ['style'=>'width:auto'],
              'captionOptions' => ['style'=>'width:26%'],],
            ['label' => 'Kemahiran Lisan',
              'value' => $model->oral],
            ['label' => 'Kemahiran Menulis',
              'value' => $model->written],
            ['label' => 'Sijil Kemahiran',
              'value' => $model->sijil],
          ],  
    ]) ?>

