<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Subjek */

$this->title = 'Create Subjek';
$this->params['breadcrumbs'][] = ['label' => 'Subjeks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subjek-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
