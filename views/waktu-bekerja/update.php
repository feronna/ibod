<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\kehadiran\tblwp */

$this->title = 'Update Tblwp: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tblwps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tblwp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
