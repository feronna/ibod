<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Gred */

$this->title = 'Create Gred';
$this->params['breadcrumbs'][] = ['label' => 'Greds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gred-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
