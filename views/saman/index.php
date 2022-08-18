<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\saman\SamanStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Saman Statuses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saman-status-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Saman Status', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'NOSAMAN',
            'STATUS',
            'INSERTDATE',
            'PAIDDATE',
            'UPDATER',
            //'AMOUNT_PENDING',
            //'AMNKUNCI',
            //'AMOUNT_PAID',
            //'ID',
            //'AMNKUNCI_PAID',
            //'CATATAN:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
