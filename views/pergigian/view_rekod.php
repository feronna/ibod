<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pergigian\Pergigian */

$this->title = $model->tuntutan_gigi_id;
$this->params['breadcrumbs'][] = ['label' => 'Pergigians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pergigian-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->tuntutan_gigi_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->tuntutan_gigi_id], [
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
            'tuntutan_gigi_id',
            'icno',
            'klinik_gigi_id',
            'gred_id',
            'dept_id',
            'used_dt',
            'check_by',
            'check_dt',
            'app_by',
            'app_dt',
            'jumlah_tuntutan',
            'catatan:ntext',
            'datetime_record_entry',
        ],
    ]) ?>

</div>
