<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ln\Ln */

//$this->title = $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Lns', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<!--<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<php echo $this->render('/ln/_topmenu'); ?> 
</div>
</div>-->
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
    <div class="x_title">
            <h2><strong> Lihat Rekod Permohonan Bertugas Rasmi Di Luar Negara</strong></h2>
<!--            <p align="right"><= \yii\helpers\Html::a('Kembali', ['menunggu'], ['class' => 'btn btn-primary']) ?></p> -->
            <p align="right"><?= \yii\helpers\Html::a('&nbsp;Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?></p>   
            <div class="clearfix"></div>
        </div>
    <p>
       <!-- <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> -->
        <!-- <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'icno',
            'tujuan',
            'nama_tempat',
//            'negara',
            'date_from',
            'date_to',
            'days',
            'bil_peserta',
            'perbelanjaan',
            'entry_date',
            'status',
            'app_by',
            'app_date',
            'status_jfpiu',
            'ulasan_jfpiu:ntext',
            'ver_by',
            'ver_date',
            'status_semakan',
            'ulasan_semakan:ntext',
            'lulus_by',
            'lulus_date',
            'status_nc',
            'ulasan_nc:ntext',
        ],
    ]) ?>
       </div>
    </div>
</div>
</div>
