<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ln\Ln2 */

$this->title = 'Create Ln2';
$this->params['breadcrumbs'][] = ['label' => 'Ln2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ln2-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
