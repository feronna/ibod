<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblrscosandangan */

$this->title = 'Create Tblrscosandangan';
$this->params['breadcrumbs'][] = ['label' => 'Tblrscosandangans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblrscosandangan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
