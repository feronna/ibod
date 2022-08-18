<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\e_perkhidmatan\Parkir */

$this->title = 'Create Parkir';
$this->params['breadcrumbs'][] = ['label' => 'Parkirs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parkir-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
