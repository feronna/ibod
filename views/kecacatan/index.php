<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\TblkecacatanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblkecacatans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblkecacatan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tblkecacatan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ICNO',
            'DisabilityTypeCd',
            'DisabilityCauseCd',
            'DisabilityDt',
            'AccidentDt',
            //'SocialWelfareNo',
            //'HealDt',
            //'DrRptNo',
            //'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
