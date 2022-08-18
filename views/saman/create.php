<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Saman\SamanOld */

// $this->title = 'Create Saman Old';
$this->params['breadcrumbs'][] = ['label' => 'Saman Olds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saman-old-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'category' => $category
    ]) ?>

</div>
