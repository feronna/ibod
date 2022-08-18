<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ibod\Ibod */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ibods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ibod-view">

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
            'lpu_name',
            'lpu_position',
            'lpu_start_date',
            'lpu_end_date',
            'lpu_entry_date',
            'updated_date',
            'updated_by',
            'isActive',
            'attachment:ntext',
            'catatan:ntext',
        ],
    ]) ?>

</div>
