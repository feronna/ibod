<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\kontrak\KontrakSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kontraks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kontrak-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Kontrak', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
        <?= Html::a('Create Notification', ['notification'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'icno',
            'reason:ntext',
            'tarikh_m',
            'ver_by',
            //'app_by',
            //'status_pp',
            //'status_jfpiu',
            //'status_tnca',
            //'status_pendaftar',
            //'status_nc',
            //'status_bsm',
            //'ulasan_pp:ntext',
            //'ulasan_jfpiu:ntext',
            //'ulasan_tnca:ntext',
            //'ulasan_pendaftar:ntext',
            //'ulasan_nc:ntext',
            //'ver_date',
            //'app_date',
            //'tnca_date',
            //'pendaftar_date',
            //'bsma_date',
            //'lulus_date',
            //'tempoh_l_pp',
            //'status',
            //'tempoh_l_bsm',
            //'tempoh_l_jfpiu',
            //'tempoh_l_tnca',
            //'tempoh_l_pendaftar',
            //'tempoh_l_nc',
            //'terima',
            //'job_category',
            //'dokumen_sokongan:ntext',
            //'surat',
            //'sesi_id',
            //'tahun_sesi',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
