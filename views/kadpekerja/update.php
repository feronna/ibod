<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kadpekerja\Kadpekerja */

$this->title = 'Update Kadpekerja: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kadpekerjas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kadpekerja-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
