<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\tblrscoservstatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblrscoservstatuses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblrscoservstatus-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tblrscoservstatus', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ICNO',
            'ServStatusCd',
            'ServStatusDtl',
            'ServStatusStDt',
            'id',
            //'sebab_berhenti:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
