<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Bangsa';
?>
<div class="negeri-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Kembali', ['skindex'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Tambah Bangsa', ['tk_bangsa?id='], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
             'header'=>'Bil.',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:3%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'ID',
             'value'=>'RaceCd',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:8%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Nama Bangsa',
             'value'=>'Race',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:15%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Bangsa CdMM',
             'value'=>'RaceCdMM',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:15%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Status',
             'value'=>'isActive',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:15%','bgcolor'=>'#e8e9ea'],],

            ['class' => 'yii\grid\ActionColumn',
             'header'=>'Tindakan',
             'template' => '{tk_bangsa}',
               'buttons'=>[
                'tk_bangsa' => function($url){
                    return Html::a('<span class="fa fa-pencil"></span>', $url);
                }     ],
             'contentOptions' => ['class' => 'text-center'],
             'headerOptions' => ['class'=>'text-center','style'=>'width:10%','bgcolor'=>'#e8e9ea'],],
        ],
    ]); ?>
</div>
