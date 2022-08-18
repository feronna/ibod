<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ikad\TblMohon */

$this->title = 'Create Tbl Mohon';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Mohons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-mohon-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
