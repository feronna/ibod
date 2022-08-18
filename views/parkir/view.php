<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\e_perkhidmatan\Parkir */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Parkirs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="parkir-view">

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
            'jenis_kenderaan:ntext',
            'no_pendaftaran_kenderaan:ntext',
            'jenama_kenderaan:ntext',
            'model_kenderaan:ntext',
            'warna_kenderaan:ntext',
            'tarikh_meletakkan_kenderaan',
            'tarikh_pengambilan_kenderaan',
            'days',
            'status',
            'tarikh_m',
            'ver_by',
            'ver_date',
            'status_semakan',
            'ulasan_semakan:ntext',
            'app_by',
            'app_date',
            'status_kj',
            'ulasan_kj:ntext',
            'isActive',
            'letter_sent',
        ],
    ]) ?>

</div>
