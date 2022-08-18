<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\tblrscopsnstatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblrscopsnstatuses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblrscopsnstatus-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tblrscopsnstatus', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ICNO',
            'PsnStatusCd',
            'PsnStatusNo',
            'PsnIncomeTaxNo',
            'PsnEpfNo',
            //'PsnStatusStDt',
            //'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
