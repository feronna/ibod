<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\warrant\TblJawatan */

$this->title = 'Create Tbl Jawatan';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Jawatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-jawatan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
