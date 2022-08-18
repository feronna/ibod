<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\myidp\AdminJfpiu */

$this->title = Yii::t('app', 'Update Admin Jfpiu: {name}', [
    'name' => $model->staffID,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin Jfpius'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->staffID, 'url' => ['view', 'id' => $model->staffID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="admin-jfpiu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
