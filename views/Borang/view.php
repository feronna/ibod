<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tblbuka\borang */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Borangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="borang-view">

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
            'jeniskemudahan',
            'butiran',
            'nama_tempat',
            'negara',
            'date_from',
            'date_to',
            'days',
            'entry_date',
//            'status',
//            'catatan',
//            'status_pp',
//            'catatan_pp',
//            'status_kj',
//            'catatan_kj',
//            'implikasi',
            'upload',
        ],
    ]) ?>

</div>
