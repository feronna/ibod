<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TblrscosandanganSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblrscosandangans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblrscosandangan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tblrscosandangan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ICNO',
            'gredjawatan',
            'sandangan_id',
            'ApmtTypeCd',
            //'start_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
