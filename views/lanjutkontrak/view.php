<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\kontrak\Kontrak */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kontraks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kontrak-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'icno',
            'reason:ntext',
            'tarikh_m',
            'ver_by',
            'app_by',
            'status_pp',
            'status_jfpiu',
            'status_tnca',
            'status_pendaftar',
            'status_nc',
            'status_bsm',
            'ulasan_pp:ntext',
            'ulasan_jfpiu:ntext',
            'ulasan_tnca:ntext',
            'ulasan_pendaftar:ntext',
            'ulasan_nc:ntext',
            'ver_date',
            'app_date',
            'tnca_date',
            'pendaftar_date',
            'bsma_date',
            'lulus_date',
            'tempoh_l_pp',
            'status',
            'tempoh_l_bsm',
            'tempoh_l_jfpiu',
            'tempoh_l_tnca',
            'tempoh_l_pendaftar',
            'tempoh_l_nc',
            'terima',
            'job_category',
            'dokumen_sokongan:ntext',
            'surat',
            'sesi_id',
            'tahun_sesi',
        ],
    ]) ?>

</div>
