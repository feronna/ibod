<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\brp\tblrscobrp */

$this->title = 'Update Tblrscobrp: ' . $model->brp_id;
$this->params['breadcrumbs'][] = ['label' => 'Tblrscobrps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->brp_id, 'url' => ['view', 'id' => $model->brp_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tblrscobrp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
