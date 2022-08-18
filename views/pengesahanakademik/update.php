<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\pengesahan */

$this->title = 'Update Pengesahan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pengesahans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pengesahan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
