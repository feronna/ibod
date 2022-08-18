<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblpenempatan */

$this->title = 'Create Tblpenempatan';
$this->params['breadcrumbs'][] = ['label' => 'Tblpenempatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblpenempatan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
