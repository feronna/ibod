<?php
use yii\grid\GridView;
?>


<div class="table-responsive">
<?=
    GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                'label' => 'Nama Klinik',
//                'attribute' => 'jawatan_dipohon',
                'value' => 'klinik.nama',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
                [
                'label' => 'Tarikh Rawatan',
//                'attribute' => 'jawatan_dipohon',
                'value' => 'rawatan_date',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
                [
                'label' => 'Nama Pesakit',
//                'attribute' => 'jawatan_dipohon',
                'value' => 'pesakit_name',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
                [
                'label' => 'Jumlah Tuntutan (RM)',
//                'attribute' => 'jawatan_dipohon',
                'value' => 'jum_tuntutan',
                'format' => ['decimal',2],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
        ['class' => 'yii\grid\ActionColumn',
//             'header' => '',
             'template' => '{view}',
//             'visibleButtons' => [
//                    'update' => function ($model, $key, $index) {
//                        return $model->updated_by == Yii::$app->user->identity->id ? false : true;
//                    },
//                    'view' => function ($model, $key, $index) {
//                        return $model->updated_by == Yii::$app->user->identity->id ? false : true;
//                    }
//             ],
]
        ],
        
    ]);
    ?>
    
</div>