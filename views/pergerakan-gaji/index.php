<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\tblrscosalmovemthSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblrscosalmovemths';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblrscosalmovemth-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tblrscosalmovemth', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ICNO',
            'SalMoveMth',
            'SalMoveMthType',
            'SalMoveMthStDt',
            'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
