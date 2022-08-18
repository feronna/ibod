<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\cbelajar\LkkTblPenyelia */

$this->title = 'Create Lkk Tbl Penyelia';
$this->params['breadcrumbs'][] = ['label' => 'Lkk Tbl Penyelias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lkk-tbl-penyelia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
