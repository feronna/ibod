<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\latihan\IdpV */

$this->title = 'Update Idp V: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Idp Vs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="idp-v-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
