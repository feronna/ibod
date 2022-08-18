<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\utilities\PosTblPermohonan */

$this->title = 'Update Pos Tbl Permohonan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pos Tbl Permohonans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pos-tbl-permohonan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
