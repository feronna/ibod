<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\system_core\TblPendingTask */

$this->title = 'Create Tbl Pending Task';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Pending Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-pending-task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
