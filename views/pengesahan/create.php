<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\pengesahan */

$this->title = 'Create Pengesahan';
$this->params['breadcrumbs'][] = ['label' => 'Pengesahans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pengesahan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
