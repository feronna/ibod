<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\e_perkhidmatan\PapanTandaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Papan Tandas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="papan-tanda-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Papan Tanda', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'icno',
            'tajuk:ntext',
            'tarikh_mula',
            'tarikh_hingga',
            //'tempat:ntext',
            //'masa',
            //'status',
            //'ver_by',
            //'ver_date',
            //'status_semakan',
            //'ulasan_semakan:ntext',
            //'app_by',
            //'app_date',
            //'status_kj',
            //'ulasan_kj:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
