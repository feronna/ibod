<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ptb\TblTugasBelumSelesai */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Tugas Belum Selesais', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-serah-tugas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Adakah anda pasti untuk memadamnya?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'senarai_tugas',
            'tugas_belum_selesai',
            'kedudukan_sekarang',
            'tindakan_susulan',
            'rujukan_fail',
            'senarai_harta_benda',
            'kedudukan_kewangan',
            'catatan',
        ],
    ]) ?>

</div>
