<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\e_perkhidmatan\PapanTanda */

$this->title = 'Update Papan Tanda: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Papan Tandas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="papan-tanda-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
