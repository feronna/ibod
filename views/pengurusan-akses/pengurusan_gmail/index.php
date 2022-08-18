<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

?>
<style>
    .fix-width>tbody>tr>th {
        width: 30%;
    }
</style>
<div class="x_panel">

    <div class="x_title">
        <h4><?= "Senarai Staf (Lantikan Baru)" ?></h4>
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
                    'value' => 'sebab_perubahan',
                ],
                [
                    'value' => function($model){
                        return Yii::$app->MP->Tarikh($model->tarikh_kuatkuasa);
                    },
                    'label' => 'TARIKH KUATKUASA',
                ],
                [
                    'value' => function($model){
                        return $model->statusAD;
                    },
                    'label' => 'ACTIVE DIRECTORY',
                    'format' => 'raw',
                ],
                [
                    'value' => function($model){
                        if(!$model->tindakan4){
                            return '<span class="label label-danger">Belum Diambil Tindakan</span>';
                        }
                        else if($model->tindakan4->status == 1){
                            return '<span class="label label-success">Selesai</span>';
                        }else{
                            return '<span class="label label-warning">Belum Selesai</span>';
                        }
                    },
                    'label' => 'STATUS',
                    'filter' => Select2::widget([
                        'model'=>$searchModel,
                        'attribute' => 'status',
                        'data' => ['1'=>'Selesai','0'=>'Belum Selesai','-1'=>'Belum Diambil Tindakan'],
                        'options' => ['placeholder' => 'Pilih..'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                    'format' => 'raw',
                ],
                
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Tindakan',
                    'headerOptions' => ['class' => 'text-center '],
                    'contentOptions' => ['class' => 'text-center',],
                    'template' => '{p-g-lihat} | {p-g-tindakan}',
                    'buttons' => [
                        'p-g-lihat' => function ($url, $model) {
                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['p-g-lihat', 'id' => $model->id]);
                        },
                        'p-g-tindakan' => function ($url, $model) {
                            return Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['p-g-tindakan', 'id' => $model->id]);
                        },
                    ],
                ],
            ],
        ]) ?>
    </div>

</div>