<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\system_core\TblPendingTask */

$this->title = 'Update Tbl Pending Task: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Pending Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-pending-task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
