<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\msiso\TblClause */

$this->title = 'Update Tbl Clause: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Clauses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-clause-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
