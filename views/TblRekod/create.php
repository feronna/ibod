<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TblRekod */

$this->title = 'Create Tbl Rekod';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Rekods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-rekod-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
