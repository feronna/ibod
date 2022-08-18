<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblpenempatan */

$this->title = 'Update Tblpenempatan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tblpenempatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 " > 
<div class="x_panel">
    <div class="x_title">
            <ol class="breadcrumb">
                <li><?php echo Html::a('<i class="fa fa-home"></i> Halaman Utama', ['halaman-utama']) ?></li>
                <li><?php echo Html::a('Rekod Penempatan', ['admin-view', 'id' => $model->ICNO]) ?></li>
                <li><?= Html::a('Sejarah Penempatan', ['sejarah-penempatan/lihat-rekod-kakitangan', 'ICNO' => $model->ICNO]) ?></li>
                <li>Kemaskini Sejarah Penempatan</li>
            </ol>
            <h2><strong>Kemaskini Sejarah Penempatan</strong></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
    <?= $this->render('_borang', [
        'model' => $model,
    ]) ?>
    </div>
</div>
</div>
</div>
