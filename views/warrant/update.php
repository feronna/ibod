<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\warrant\TblJawatan */

$this->title = 'Update Tbl Jawatan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Jawatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-jawatan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
