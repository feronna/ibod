<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tblbuka\borang */

$this->title = 'Create Borang';
$this->params['breadcrumbs'][] = ['label' => 'Borangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="borang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
