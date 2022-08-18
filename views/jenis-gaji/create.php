<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblrscosaltype */

$this->title = 'Create Tblrscosaltype';
$this->params['breadcrumbs'][] = ['label' => 'Tblrscosaltypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblrscosaltype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
