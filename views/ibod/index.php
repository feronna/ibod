<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ibod\IbodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ibods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ibod-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ibod', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'icno',
            'lpu_name',
            'lpu_position',
            'lpu_start_date',
            //'lpu_end_date',
            //'lpu_entry_date',
            //'updated_date',
            //'updated_by',
            //'isActive',
            //'attachment:ntext',
            //'catatan:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
