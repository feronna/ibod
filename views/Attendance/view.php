<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\kehadiran\TblRekod */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Rekods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-rekod-view">

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
            'day',
            'tarikh',
            'time_in',
            'time_out',
            'total_hours',
            'reason_id',
            'late_in',
            'early_out',
            'incomplete',
            'absent',
            'external',
            'app_by',
            'app_dt',
            'remark_status',
            'wp_id',
            'in_lat_lng',
            'out_lat_lng',
            'in_ip',
            'out_ip',
            'remark',
            'app_remark',
        ],
    ]) ?>

</div>
