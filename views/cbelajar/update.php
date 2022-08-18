<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\cbelajar\TblUrusMesyuarat */

$this->title = 'Update Tbl Urus Mesyuarat: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Urus Mesyuarats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-urus-mesyuarat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
