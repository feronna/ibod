<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\TblrscoadminpostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblrscoadminposts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblrscoadminpost-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tblrscoadminpost', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ICNO',
            'adminpos_id',
            'jobStatus',
            'paymentStatus',
            //'description',
            //'description_sef',
            //'dept_id',
            //'campus_id',
            //'appoinment_date',
            //'start_date',
            //'end_date',
            //'flag',
            //'files',
            //'renew',
            //'status_tugas',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
