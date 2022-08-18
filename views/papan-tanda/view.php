<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\e_perkhidmatan\PapanTanda */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Papan Tandas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="papan-tanda-view">

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
            'tajuk:ntext',
            'tarikh_mula',
            'tarikh_hingga',
            'tempat:ntext',
            'masa',
            'status',
            'ver_by',
            'ver_date',
            'status_semakan',
            'ulasan_semakan:ntext',
            'app_by',
            'app_date',
            'status_kj',
            'ulasan_kj:ntext',
        ],
    ]) ?>

</div>
