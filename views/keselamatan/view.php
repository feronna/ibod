<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\keselamatan\TblRekod */

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
            'ot_in',
            'ot_out',
            'reason_id',
            'status_in',
            'status_out',
            'incomplete',
            'absent',
            'external',
            'app_by',
            'app_dt',
            'remark_status',
            'wp_id',
            'in_lat_lng',
            'out_lat_lng',
            'ot_in_lat_lng',
            'ot_out_lat_lng',
            'in_ip',
            'out_ip',
            'remark',
            'app_remark',
            'ot_in_ip',
            'ot_out_ip',
        ],
    ]) ?>

</div>
