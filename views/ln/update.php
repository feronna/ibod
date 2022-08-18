<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ln\Ln */

//$this->title = 'Update Ln: ' . $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Lns', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>

    <?= Html::encode($this->title) ?>

    <?= $this->render('mohon', [
        'model' => $model,
    ]) ?>

