<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tblbuka\Tbltuntutan */

$this->title = 'Create kemudahan';
$this->params['breadcrumbs'][] = ['label' => 'Kemudahans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kemudahan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
