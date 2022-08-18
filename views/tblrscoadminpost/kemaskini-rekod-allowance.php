<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblrscoadminpost */

//$this->title = 'Update Tblrscoadminpost: ' . $model->id;
$this->title = 'Kemaskini Rekod #' . $model->id;

$this->params['breadcrumbs'][] = ['label' => 'Tblrscoadminposts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 " > 
<div class="x_panel">
    <div class="x_title">
            <ol class="breadcrumb">
                <li><?php echo Html::a('<i class="fa fa-home"></i> Halaman Utama', ['admin-post-list']) ?></li>
                <li><?php echo Html::a('Rekod Lantikan', ['admin-view', 'id' => $model->ICNO]) ?></li>
                 <li><?= Html::a('Senarai Rekod Allowance',['lihat-rekod-allowance', 'ICNO' => $model->ICNO])  ?></li>
                <li>Kemaskini Rekod Allowance</li>
            </ol>
            <h2><strong>Kemaskini Rekod Allowance</strong></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
    <?= $this->render('_form3', [
        'model' => $model,
    ]) ?>
    </div>
</div>
</div>
</div>
