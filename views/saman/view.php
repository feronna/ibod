<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\saman\SamanStatus */

$this->title = $model->NOSAMAN;
$this->params['breadcrumbs'][] = ['label' => 'Saman Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="saman-status-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->NOSAMAN], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->NOSAMAN], [
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
            'NOSAMAN',
            'STATUS',
            'INSERTDATE',
            'PAIDDATE',
            'UPDATER',
            'AMOUNT_PENDING',
            'AMNKUNCI',
            'AMOUNT_PAID',
            'ID',
            'AMNKUNCI_PAID',
            'CATATAN:ntext',
        ],
    ]) ?>

</div>
