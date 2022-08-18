<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\TblakaunSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblakauns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblakaun-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tblakaun', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ICNO',
            'AccNo',
            'AccTypeCd',
            'AccPurposeCd',
            'AccNmCd',
            //'CityCd',
            //'AccStatus',
            //'AccBranch',
            //'AccBranchCd',
            //'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
