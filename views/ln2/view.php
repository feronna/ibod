<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ln\Ln2 */

$this->title = $model->bil;
$this->params['breadcrumbs'][] = ['label' => 'Ln2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ln2-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'bil' => $model->bil, 'ICNO' => $model->ICNO], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'bil' => $model->bil, 'ICNO' => $model->ICNO], [
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
            'bil',
            'lulus_date',
            'date_from',
            'jfpib',
            'ICNO',
            'nama',
            'tujuan:ntext',
            'tempat:ntext',
            'pembiayaan:ntext',
            'kod_peruntukan:ntext',
        ],
    ]) ?>

</div>
