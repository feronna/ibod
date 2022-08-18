<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WarrantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbl Jawatans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-jawatan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbl Jawatan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'jawatan',
            'gred',
            'jumlah_waran',
            'kategori',
            //'kumpkhidmat_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
