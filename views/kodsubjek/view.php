<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\hronline\Subjek;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Subjek */

$this->title = $model->subject_id;
$this->params['breadcrumbs'][] = ['label' => 'Subjeks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="subjek-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->subject_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'subject_id',
            'subject_name',
            ['label'=>'Status',
             'value'=> $model->status ? 'Aktif':'Tidak Aktif'],
           
        ],
    ]) ?>

</div>
