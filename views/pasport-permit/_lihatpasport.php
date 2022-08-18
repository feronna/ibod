<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<?= DetailView::widget([
        'model' => $paspot,
        'attributes' => [
            ['label' => 'Passport Number',
             'value' => $paspot->PassportNo,
             'contentOptions' => ['style'=>'width:auto'],
              'captionOptions' => ['style'=>'width:26%'],],
            ['label' => 'Passport Type',
             'value' =>$paspot->jenpaspot],
            ['label' => 'Nationality',
             'value' => $paspot->nega],
            ['label' => 'Place of Birth',
             'value' => $paspot->nege],
            ['label' => 'Date od Issue',
              'value' => $paspot->issuedDt],
            ['label' => 'Date of Expiry',
              'value' => $paspot->passportExpiryDt],
            ['label' => 'File',
              'value' => $paspot->displayLink,
              'format' => 'raw',],
        ],
    ]) ?>
