<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Institut;

$this->title = 'Institusi';
?>
<div class="jenis-alamat-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Kembali', ['skindex'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Tambah Institusi', ['tk_institut?id='], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       'filterModel' => $searchModel,
        'tableOptions' =>['class' => 'table table-bordered table-sm'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
             'header'=>'Bil.',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:5%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'ID',
             'value'=>'InstCd',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:15%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Nama Institusi',
             'attribute' => 'InstNm',
            'filter' => Select2::widget([
                'model'=>$searchModel,
                'attribute' => 'InstNm',
                'data' => ArrayHelper::map(Institut::find()->orderBy(['InstNm'=>SORT_ASC])->all(), 'InstNm', 'InstNm'),
                'options' => ['placeholder' => 'Pilih..'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]),
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:40%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Status',
             'value'=>'status',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:auto','bgcolor'=>'#e8e9ea'],],
            ['class' => 'yii\grid\ActionColumn',
             'header'=>'Tindakan',
             'template' => '{tk_institut}',
               'buttons'=>[
                'tk_institut' => function($url){
                    return Html::a('<span class="fa fa-pencil"></span>', $url);
                }     ],
             'contentOptions' => ['class' => 'text-center'],
             'headerOptions' => ['class'=>'text-center','style'=>'width:10%','bgcolor'=>'#e8e9ea'],],
        ],
    ]); ?>
</div>
