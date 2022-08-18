<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\TblrscopersalpointSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblrscopersalpoints';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblrscopersalpoint-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tblrscopersalpoint', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ICNO',
            'PerSalPointStDt',
            'PerSalPointEndDt',
            'SalPointCd',
            'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
