<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\system_core\TblPendingTaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbl Pending Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-pending-task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbl Pending Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'count',
            'url:url',
            ['label' => 'Status',
             'attribute'=>'status',
                'value' => 'statusname'],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
