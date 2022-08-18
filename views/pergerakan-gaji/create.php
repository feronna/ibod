<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblrscosalmovemth */

$this->title = 'Create Tblrscosalmovemth';
$this->params['breadcrumbs'][] = ['label' => 'Tblrscosalmovemths', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblrscosalmovemth-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
