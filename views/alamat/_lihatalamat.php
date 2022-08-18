<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
?> 

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label' => 'Jenis Alamat',
              'value' => $model->jenalamat,
              'contentOptions' => ['style'=>'width:auto'],
              'captionOptions' => ['style'=>'width:26%'],  
            ],
              
            ['label' => 'No. KP / Paspot',
              'value' => $model->ICNO],
            ['label' => 'Negara',
              'value' =>  $model->displayNegara],
            ['label' => 'Negeri',
              'value' => $model->displayNegeri],
            ['label' => 'Daerah',
              'value' => $model->displayDaerah],
            ['label' => 'Alamat 1',
              'value' => $model->addr1 ,
              'visible'=> $model->Addr1 ? true:false],
            ['label' => 'Alamat 2',
              'value' => $model->addr2 ,
              'visible'=> $model->Addr2 ],
            ['label' => 'Alamat 3',
              'value' => $model->addr3,
              'visible'=>$model->Addr3],
            ['label' => 'Poskod',
              'value' => $model->Postcode],
            ['label' => 'No. Telefon',
              'value' => $model->TelNo],
        ],
    ]) ?>


