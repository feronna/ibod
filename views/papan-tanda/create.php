<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\e_perkhidmatan\PapanTanda */

$this->title = 'Create Papan Tanda';
$this->params['breadcrumbs'][] = ['label' => 'Papan Tandas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="papan-tanda-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
