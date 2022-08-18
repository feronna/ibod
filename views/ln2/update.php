<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ln\Ln2 */

$this->title = 'Update Ln2: ' . $model->bil;
$this->params['breadcrumbs'][] = ['label' => 'Ln2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bil, 'url' => ['view', 'bil' => $model->bil, 'ICNO' => $model->ICNO]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ln2-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
