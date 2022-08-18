<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\msiso\ClauseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbl Clauses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-clause-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbl Clause', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'clause',
            'clause_order',
            'clause_name',
            'clause_details:ntext',
            //'created_by',
            //'created_dt',
            //'status',
            //'parent_clause',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
