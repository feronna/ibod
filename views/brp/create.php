<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\brp\tblrscobrp */

$this->title = 'Create Tblrscobrp';
$this->params['breadcrumbs'][] = ['label' => 'Tblrscobrps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblrscobrp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
