<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TblrscoapmtstatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblrscoapmtstatuses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblrscoapmtstatus-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tblrscoapmtstatus', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ICNO',
            'ApmtStatusCd',
            'ApmtStatusStDt',
            'ApmtStatusEndDt',
            'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
