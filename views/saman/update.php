<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\saman\SamanStatus */

$this->title = 'Update Saman Status: ' . $model->NOSAMAN;
$this->params['breadcrumbs'][] = ['label' => 'Saman Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NOSAMAN, 'url' => ['view', 'id' => $model->NOSAMAN]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="saman-status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
