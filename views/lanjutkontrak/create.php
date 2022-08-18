<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\kontrak\Kontrak */

$this->title = 'Create Kontrak';
$this->params['breadcrumbs'][] = ['label' => 'Kontraks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kontrak-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
