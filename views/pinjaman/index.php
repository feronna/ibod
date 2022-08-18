<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PinjamanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pinjamen';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pinjaman-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pinjaman', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'icno',
            'tarikh_mohon',
            'status_semasa',
            'no_kakitangan',
            //'agensi_bank',
            //'jumlah_pinjaman',
            //'bayaran_bulanan',
            //'jumlah_bulan_bayaran',
            //'status_pt',
            //'catatan_pt',
            //'datetime_pt',
            //'status_pp',
            //'catatan_pp',
            //'datetime_pp',
            //'dokumen_sokongan:ntext',
            //'isActive',
            //'tarikh_diambil',
            //'diterima_oleh',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
