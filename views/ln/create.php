<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ln\Ln */

//$this->title = 'Create Ln';
//$this->params['breadcrumbs'][] = ['label' => 'Lns', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ln-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'status' => $status,
        //'displaymohon' => $displaymohon,
    ]) ?>

</div>
