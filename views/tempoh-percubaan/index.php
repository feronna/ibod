<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\tblrscoprobtnperiodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblrscoprobtnperiods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblrscoprobtnperiod-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tblrscoprobtnperiod', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ICNO',
            'ProbtnPeriod',
            'ProbtnStDt',
            'ProbtnEndDt',
            'ProbtnPeriodMin',
            //'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
