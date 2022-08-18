<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

$this->title = 'Penamatan Akses';
?>
<style>
    .fix-width>tbody>tr>th {
        width: 30%;
    }
</style>
<div class="x_panel">

    <div class="x_title">
        <h4><?= "Senarai Staf ( lantikan baru / naik pangkat / berpindah / bersara / ditamatkan )" ?></h4>
        <div class="clearfix"></div>
    </div>

    <div class="row">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'Nama',
                    'attribute' => 'nama',
                    'filterInputOptions' => [
                        'class'       => 'form-control',
                        'placeholder' => 'Carian nama staf'
                    ]
                ],
                [
                    
                    'label' => 'JFPIB',
                    'value' => 'jfpib',
                ],
                [
                    
                    'label' => 'SEBAB PERUBAHAN',
                    'attribute' => 'sebab_perubahan',
                    'filterInputOptions' => [
                        'class'       => 'form-control',
                        'placeholder' => 'Carian Sebab Perubahan'
                    ]
                ],
                [
                    'value' => function($model){
                        return Yii::$app->MP->Tarikh($model->tarikh_kuatkuasa);
                    },
                    'label' => 'TARIKH KUATKUASA',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Tindakan',
                    'headerOptions' => ['class' => 'text-center '],
                    'contentOptions' => ['class' => 'text-center',],
                    'template' => '{lihat} | {kemaskini}',
                    'buttons' => [
                        'lihat' => function ($url, $model) {
                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihat-staf', 'id' => $model->id]);
                        },
                        'kemaskini' => function ($url, $model) {
                            return Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini', 'id' => $model->id]);
                        },
                    ],
                ],
            ],
        ]) ?>
    </div>

</div>