<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\cbelajar\UrusMesyuaratSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbl Urus Mesyuarats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-urus-mesyuarat-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbl Urus Mesyuarat', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'kali_ke',
            'tarikh_mesyuarat',
            'nama_mesyuarat',
            'masa_mesyuarat',
            //'tempat_mesyuarat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
