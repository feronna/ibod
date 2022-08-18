<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\tblrscosaltypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblrscosaltypes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblrscosaltype-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tblrscosaltype', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ICNO',
            'SalTypeCd',
            'SalStatus',
            'SalTypeStDt',
            'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
