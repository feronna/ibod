<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\cbelajar\LkkTblPenyelia */

$this->title = 'Update Lkk Tbl Penyelia: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lkk Tbl Penyelias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lkk-tbl-penyelia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
