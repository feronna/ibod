<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblrscopsnstatus */

$this->title = 'Create Tblrscopsnstatus';
$this->params['breadcrumbs'][] = ['label' => 'Tblrscopsnstatuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblrscopsnstatus-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
