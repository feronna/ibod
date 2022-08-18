<?php
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
?>


<div class="table-responsive">
<?=
    GridView::widget([
        'dataProvider' => $bukanpanels,
//        'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                'label' => 'Nama Kakitangan',
                'value' => 'kakitangan.kakitangan.CONm',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
                [
                'label' => 'Nama Klinik',
//                'attribute' => 'jawatan_dipohon',
                'attribute' => 'nama_klinik',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
                [
                'label' => 'Tarikh Rawatan',
//                'attribute' => 'jawatan_dipohon',
                'value' => 'tuntutan_date',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
                
                [
                'label' => 'Jumlah Tuntutan (RM)',
//                'attribute' => 'jawatan_dipohon',
                'value' => 'tuntutan',
                'format' => ['decimal',2],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
                [
                'label' => 'Direkodkan Oleh',
//                'attribute' => 'jawatan_dipohon',
                'value' => 'insertby.CONm',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
                [
                'label' => 'Direkodkan Pada',
//                'attribute' => 'jawatan_dipohon',
                'value' => 'insert_dt',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
        ['class' => 'yii\grid\ActionColumn',
                'header' => '',
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $dataProvider) {
                        $url = Url::to(['klinikpanel/update', 'id' => $dataProvider->id]);
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                    }
                ]
    ]
        ],
        
    ]);
    ?>
    
</div>