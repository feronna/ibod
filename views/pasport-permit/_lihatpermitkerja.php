<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<?= DetailView::widget([
        'model' => $permit,
        'attributes' => [
            ['label' => 'Work Permit Number',
              'value' => $permit->WrkPermitNo,
              'contentOptions' => ['style'=>'width:auto'],
              'captionOptions' => ['style'=>'width:26%'],],
            ['label' => 'Immigration Reference Number',
              'value' => $permit->ImigRefNo],
            ['label' => 'Date of Issue',
              'value' => $permit->wrkPermitIssueDt],
            ['label' => 'Date of Expiry',
              'value' => $permit->wrkPermitExpiryDt],
            ['label' => 'File',
              'value' => $permit->displayLink,
              'format' => 'raw',],
         
        ],
    ]) ?>

