<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\kualiti\Kualiti */

$this->title = $model->msiso_id;
$this->params['breadcrumbs'][] = ['label' => 'Kualitis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kualiti-view">

    

    <p>

        <?= Html::a('Kemaskini', ['update-auditkit', 'id' => $model->msiso_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Padam', ['delete-auditkit', 'id' => $model->msiso_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Anda pasti ingin memadam rekod ini?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Kembali', ['audit-kit'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            [
                'label' => 'Kategori',
                'attribute' => 'kategori',
                'format' => 'raw',
            ],
            'no_prosedur',
            'tajuk_prosedur',
            [
                'label' => 'Lampiran',
                'value' => $model->displayLink,
                'format' => 'raw',
            ],
           
            [
                'label' => 'JAFPIB',
                'attribute' => 'department.fullname',
            ],
            'insert_date',
            'update_date',
            'updater.CONm',
        ],
    ]) ?>

</div>