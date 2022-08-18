<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ikad\TblMohon */

$this->title = 'Update Tbl Mohon: ' . $model->d_mohon_id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Mohons', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->d_mohon_id, 'url' => ['view', 'id' => $model->d_mohon_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-mohon-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
