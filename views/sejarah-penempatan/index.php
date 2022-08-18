<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\tblpenempatanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblpenempatans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblpenempatan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tblpenempatan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ICNO',
            'date_start',
            'date_update',
            'dept_id',
            //'campus_id',
            //'reason_id',
            //'remark',
            //'letter_order_refno',
            //'date_letter_order',
            //'letter_refno',
            //'update_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
