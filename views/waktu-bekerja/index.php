<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\kehadiran\tblwpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblwps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblwp-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tblwp', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'wp_id',
            'icno',
            'remark',
            'entry_dt',
            //'ver_by',
            //'ver_dt',
            //'ver_remark',
            //'app_by',
            //'app_dt',
            //'app_remark',
            //'start_date',
            //'end_date',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
