<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\kemudahan\Borangehsan */

$this->title = 'Create Borangehsan';
$this->params['breadcrumbs'][] = ['label' => 'Borangehsans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="borangehsan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
