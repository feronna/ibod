<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\cbelajar\LkkTblPenyelia */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lkk Tbl Penyelias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="lkk-tbl-penyelia-view">

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
            'nama',
            'emel',
            'jawatan',
            'jabatan',
            'password',
            'access_level',
            'last_login',
            'last_ipaccess',
            'staff_icno',
            'HighestEduLevelCd',
        ],
    ]) ?>

</div>
