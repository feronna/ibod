<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\PenajaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penaja';
?>
<div class="penaja-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Kembali', ['skindex'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Tambah Penaja', ['tk_penaja?id='], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
             'header'=>'Bil.',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:5%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'ID',
             'value'=>'SponsorshipCd',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:15%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Nama Penaja',
             'value'=>'SponsorshipNm',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:50%','bgcolor'=>'#e8e9ea'],],
            ['label'=>'Status',
             'value'=>'status',
             'contentOptions' => ['class' => 'text-left'],
             'headerOptions' => ['class'=>'text-left','style'=>'width:auto','bgcolor'=>'#e8e9ea'],],


            ['class' => 'yii\grid\ActionColumn',
             'header'=>'Tindakan',
             'template' => '{tk_penaja}',
               'buttons'=>[
                'tk_penaja' => function($url){
                    return Html::a('<span class="fa fa-pencil"></span>', $url);
                }     ],
             'contentOptions' => ['class' => 'text-center'],
             'headerOptions' => ['class'=>'text-center','style'=>'width:10%','bgcolor'=>'#e8e9ea'],],
        ],
    ]); ?>
</div>
