<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\utilities\PosTblPermohonanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pos Tbl Permohonans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pos-tbl-permohonan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pos Tbl Permohonan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'icno_pemohon',
            'tujuan_mel:ntext',
            'tarikh_mohon',
            'alamat_penghantar:ntext',
            //'alamat_penerima:ntext',
            //'icno_pelulus',
            //'status_jafpib',
            //'tarikh_status_jafpib',
            //'icno_pom',
            //'status_pom',
            //'tarikh_status_pom',
            //'tracking_no',
            //'tarikh_dihantar',
            //'jenis_khidmat_mel',
            //'bayaran_mel',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
