<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tblkemudahan\Tblkemudahan */

//$this->title = 'Update Tblkemudahan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kemudahan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="kemudahan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('kemaskini_tuntutan', [
        'model' => $model,
    ]) ?>

</div>
