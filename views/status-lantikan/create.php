<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblrscoapmtstatus */

$this->title = 'Create Tblrscoapmtstatus';
$this->params['breadcrumbs'][] = ['label' => 'Tblrscoapmtstatuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblrscoapmtstatus-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
