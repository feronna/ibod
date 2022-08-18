<?php
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;

?>


<div class="table-responsive">
<?=
    GridView::widget([
        'dataProvider' => $medcares,
//        'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                'label' => 'Nama Pesakit',
//                'attribute' => 'jawatan_dipohon',
                'value' => !empty($medcares->keluarga->FmyNm) ? $medcares->keluarga->FmyNm : 'kakitangan.kakitangan.CONm',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
                [
                'label' => 'No.KP Pesakit',
//                'attribute' => 'jawatan_dipohon',
                'value' => !empty($medcares->keluarga->FamilyId) ? $medcares->keluarga->FamilyId : 'patient_icno',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
                [
                'label' => 'Tarikh Rawatan',
//                'attribute' => 'jawatan_dipohon',
                'value' => 'visit_dt',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
                
                [
                'label' => 'Jumlah Tuntutan (RM)',
//                'attribute' => 'jawatan_dipohon',
                'value' => 'deduct_amt',
                'format' => ['decimal',2],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
        ['class' => 'yii\grid\ActionColumn',
//             'header' => '',
             'template' => '{view-medcare}',
             'buttons' => [
                    'view-medcare' => function ($url, $medcares) {
                        $url = Url::to(['klinikpanel/view-medcare', 'id' => $medcares->id]);
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                    }
                ],
]
        ],
        
    ]);
    ?>
    
</div>