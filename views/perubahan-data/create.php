<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\updatestatus */

$this->title = 'Create Updatestatus';
$this->params['breadcrumbs'][] = ['label' => 'Updatestatuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="updatestatus-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
