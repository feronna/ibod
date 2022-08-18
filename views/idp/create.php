<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\myidp\AdminJfpiu */

$this->title = Yii::t('app', 'Create Admin Jfpiu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin Jfpius'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-jfpiu-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
