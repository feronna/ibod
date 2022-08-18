<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\NegaraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Negara';
?>
<div class="negara-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Kembali', ['selenggarakod/skindex'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Tambah Negara', ['tk_negara?id='], ['class' => 'btn btn-primary']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'header' => 'Bil.',
                'contentOptions' => ['class' => 'text-left'],
                'headerOptions' => ['class' => 'text-left', 'style' => 'width:3%', 'bgcolor' => '#e8e9ea'],],
            ['label' => 'ID',
                'value' => 'CountryCd',
                'contentOptions' => ['class' => 'text-left'],
                'headerOptions' => ['class' => 'text-left', 'style' => 'width:8%', 'bgcolor' => '#e8e9ea'],],
            ['label' => 'Nama Negara',
                'value' => 'Country',
                'contentOptions' => ['class' => 'text-left'],
                'headerOptions' => ['class' => 'text-left', 'style' => 'width:15%', 'bgcolor' => '#e8e9ea'],],
            ['label' => 'Study Ext Period',
                'value' => 'StudyExtPeriod',
                'contentOptions' => ['class' => 'text-left'],
                'headerOptions' => ['class' => 'text-left', 'style' => 'width:15%', 'bgcolor' => '#e8e9ea'],],
            ['label' => 'Country Cd MM',
                'value' => 'CountryCdMM',
                'contentOptions' => ['class' => 'text-left'],
                'headerOptions' => ['class' => 'text-left', 'style' => 'width:15%', 'bgcolor' => '#e8e9ea'],],
            ['label' => 'Status',
                'value' => 'status',
                'contentOptions' => ['class' => 'text-left'],
                'headerOptions' => ['class' => 'text-left', 'style' => 'width:15%', 'bgcolor' => '#e8e9ea'],],
            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Tindakan',
                'template' => '{tk_negara}',
                'buttons' => [
                    'tk_negara' => function($url) {
                        return Html::a('<span class="fa fa-pencil"></span>', $url);
                    }],
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'text-center', 'style' => 'width:10%', 'bgcolor' => '#e8e9ea'],
            ],
        ],
    ]);
    ?>
</div>
