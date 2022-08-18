<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\e_perkhidmatan\ParkirSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parkirs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parkir-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Parkir', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'icno',
            'jenis_kenderaan:ntext',
            'no_pendaftaran_kenderaan:ntext',
            'jenama_kenderaan:ntext',
            //'model_kenderaan:ntext',
            //'warna_kenderaan:ntext',
            //'tarikh_meletakkan_kenderaan',
            //'tarikh_pengambilan_kenderaan',
            //'days',
            //'status',
            //'tarikh_m',
            //'ver_by',
            //'ver_date',
            //'status_semakan',
            //'ulasan_semakan:ntext',
            //'app_by',
            //'app_date',
            //'status_kj',
            //'ulasan_kj:ntext',
            //'isActive',
            //'letter_sent',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
