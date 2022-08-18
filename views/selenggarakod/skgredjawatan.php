<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;

$this->title = 'Gred Jawatan';
?>
<div class="gelaran-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Kembali', ['skindex'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Tambah Gred Jawatan', ['tk_gredjawatan?id'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn',
            //  'header'=>'Bil.',
            //  'contentOptions' => ['class' => 'text-left'],
            //  'headerOptions' => ['class'=>'text-left','style'=>'width:5%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'ID',
             'value'=>'id',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:10%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Nama',
             'attribute'=>'nama',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:30%','bgcolor'=>'#e8e9ea'],
             'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Carian Nama Jawatan',
                ],
            ],
            ['label'=>'Gred',
             'attribute'=>'gred',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:10%','bgcolor'=>'#e8e9ea'],
             'filterInputOptions' => [
                'class'       => 'form-control',
                'placeholder' => 'Gred',
            ],
            ],
            ['label'=>'Nama Penuh',
             'value'=>'fname',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:auto','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Kategori Jawatan',
            'filter' => Select2::widget([
                'model'=>$searchModel,
                'attribute' => 'job_category',
                'data' => ['1'=>'Akademik','2'=>'Pentadbiran'],
                'options' => ['placeholder' => 'Pilih..'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]),
             'value'=>function($model){
                 return ($model->job_category == 1) ? 'Akademik' : 'Pentadbiran';
             },
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:10%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Status',
            'filter' => Select2::widget([
                'model'=>$searchModel,
                'attribute' => 'isActive',
                'data' => ['1'=>'Aktif','0'=>'Tidak Aktif'],
                'options' => ['placeholder' => 'Pilih..'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]),
             'value'=>function($model){
                 return $model->isActive ? 'Aktif' : 'Tidak Aktif';
             },
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:auto','bgcolor'=>'#e8e9ea'],],
            ['class' => 'yii\grid\ActionColumn',
             'header'=>'Tindakan',
             'template' => '{tk_gredjawatan}',
               'buttons'=>[
                'tk_gredjawatan' => function($url){
                    return Html::a('<span class="fa fa-pencil"></span>', $url);
                }     ],
             'contentOptions' => ['class' => 'text-center'],
             'headerOptions' => ['class'=>'text-center','style'=>'width:10%','bgcolor'=>'#e8e9ea'],],
        ],
    ]); ?>
</div>
