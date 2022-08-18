<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kontraktor\kontraktor */

$this->title = 'Update Kontraktor: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kontraktors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kontraktor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
