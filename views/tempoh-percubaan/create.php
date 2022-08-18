<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblrscoprobtnperiod */

$this->title = 'Create Tblrscoprobtnperiod';
$this->params['breadcrumbs'][] = ['label' => 'Tblrscoprobtnperiods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblrscoprobtnperiod-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
