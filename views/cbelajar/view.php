<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\cbelajar\TblUrusMesyuarat */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Urus Mesyuarats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-urus-mesyuarat-view">

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
            'kali_ke',
            'tarikh_mesyuarat',
            'nama_mesyuarat',
            'masa_mesyuarat',
            'tempat_mesyuarat',
        ],
    ]) ?>

</div>
