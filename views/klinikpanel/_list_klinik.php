<?php
use yii\grid\GridView;
?>


<div class="table-responsive">
<?=
    GridView::widget([
        'dataProvider' => $klinik,
        'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                'label' => 'Nama Klinik',
//                'attribute' => 'jawatan_dipohon',
                'attribute' => 'nama',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
                [
                'label' => 'Alamat',
//                'attribute' => 'jawatan_dipohon',
                'attribute' => 'alamat',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
                [
                'label' => 'No. Telefon',
//                'attribute' => 'jawatan_dipohon',
                'attribute' => 'telefon',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
                [
                'label' => 'Emel',
//                'attribute' => 'jawatan_dipohon',
                'attribute' => 'klinik_email',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
        ],
        
    ]);
    ?>
    
</div>