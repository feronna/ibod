<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\GelaranSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gelaran';
?>
<div class="gelaran-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Kembali', ['skindex'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Tambah Gelaran', ['tk_gelaran?id'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
             'header'=>'Bil.',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:5%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'ID',
             'value'=>'TitleCd',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:10%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Gelaran',
             'value'=>'Title',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:30%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Cfd TitleStatus',
             'value'=>'CfdTitleStatus',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:0%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'MM TitleCd',
             'value'=>'MMTitleCd',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:10%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Title Fullname',
             'value'=>'TitleFullname',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:10%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Status',
             'value'=>'status',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:auto','bgcolor'=>'#e8e9ea'],],
            ['class' => 'yii\grid\ActionColumn',
             'header'=>'Tindakan',
             'template' => '{tk_gelaran}',
               'buttons'=>[
                'tk_gelaran' => function($url){
                    return Html::a('<span class="fa fa-pencil"></span>', $url);
                }     ],
             'contentOptions' => ['class' => 'text-center'],
             'headerOptions' => ['class'=>'text-center','style'=>'width:10%','bgcolor'=>'#e8e9ea'],],
        ],
    ]); ?>
</div>
