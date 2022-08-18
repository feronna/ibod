<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\kualiti\Kualiti */

$this->title = $model->msiso_id;
$this->params['breadcrumbs'][] = ['label' => 'Kualitis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kualiti-view">

    <h1><span class="label label-default">MSISO ID : <?= $model->msiso_id ?></span></h1>
    <br>

    <p>

        <?= Html::a('Kemaskini', ['update-manual', 'id' => $model->msiso_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Padam', ['delete-manual', 'id' => $model->msiso_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Anda pasti ingin memadam rekod ini?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Kembali', ['pelan-audit'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'msiso_id',
            'nama.kategori_nama',
            'no_prosedur',
            'tajuk_prosedur',
            [
                'label' => 'Lampiran',
                'value' => $model->displayLink,
                'format' => 'raw',
            ],
            'susunan',
            [
                'label' => 'JAFPIB',
                'attribute' => 'department.fullname',
            ],
            'insert_date',
            'update_date',
            [
                'label' => 'Dikemaskini Oleh',
                'attribute' => 'updater.CONm',
            ],
        ],
    ]) ?>

</div>