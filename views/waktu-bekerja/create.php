<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\kehadiran\tblwp */

$this->title = 'Create Tblwp';
$this->params['breadcrumbs'][] = ['label' => 'Tblwps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblwp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
