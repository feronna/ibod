<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\pengesahan */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pengesahans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pengesahan-view">

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
            'tatatertib',
            'reason:ntext',
            'tarikh_m',
            'ver_by',
            'app_by',
            'status_pp',
            'status_jfpiu',
            'status_bsm',
            'ulasan_pp:ntext',
            'ulasan_jfpiu:ntext',
            'ver_date',
            'app_date',
            'lulus_date',
            'tempoh_l_pp',
            'status',
            'tempoh_l_bsm',
            'tempoh_l_jfpiu',
            'terima',
        ],
    ]) ?>

</div>
