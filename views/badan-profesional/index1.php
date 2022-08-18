<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Tbl Badan Profesionals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-badan-profesional-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbl Badan Profesional', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'profId',
            'ICNO',
            'ProfBodyCd',
            'ProfBodyOther',
            'MembershipTypeCd',
            //'JoinDt',
            //'FeeAmt',
            //'Designation',
            //'ResignDt',
            //'ProfAssocStatus',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
