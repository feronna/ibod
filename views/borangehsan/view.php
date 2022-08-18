<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\kemudahan\Borangehsan */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Borangehsans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="borangehsan-view">

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
            'pohon',
            'tujuan',
            'tarikh_mohon',
            'status_pt',
            'catatan_pt',
            'semakan_pt',
            'status_pp',
            'catatan_pp',
            'ver_date',
            'status_kj',
            'catatan_kj',
            'app_date',
            'tarikh_terima',
            'pengakuan',
            'isActive',
        ],
    ]) ?>

</div>
