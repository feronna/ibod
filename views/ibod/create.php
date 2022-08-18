<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ibod\Ibod */

$this->title = 'Create Ibod';
$this->params['breadcrumbs'][] = ['label' => 'Ibods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ibod-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
