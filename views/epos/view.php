<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\utilities\PosTblPermohonan */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pos Tbl Permohonans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pos-tbl-permohonan-view">

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
            'icno_pemohon',
            'tujuan_mel:ntext',
            'tarikh_mohon',
            'alamat_penghantar:ntext',
            'alamat_penerima:ntext',
            'icno_pelulus',
            'status_jafpib',
            'tarikh_status_jafpib',
            'icno_pom',
            'status_pom',
            'tarikh_status_pom',
            'tracking_no',
            'tarikh_dihantar',
            'jenis_khidmat_mel',
            'bayaran_mel',
        ],
    ]) ?>

</div>
