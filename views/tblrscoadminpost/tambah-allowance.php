<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblrscoadminpost */

$this->title = 'Create Tblrscoadminpost';
$this->params['breadcrumbs'][] = ['label' => 'Tblrscoadminposts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
    <div class="x_title">
<!--            <ol class="breadcrumb">
                <li><php echo Html::a('<i class="fa fa-home"></i> Halaman Utama', ['halaman-utama']) ?></li>
                <li><= Html::a('Rekod Lantikan', Yii::$app->request->referrer) ?></li>
                <li>Tambah Rekod Allowance</li>
            </ol>-->
            <h2><strong>Tambah Allowance</strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('&nbsp;Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?></p>   
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

    <?= $this->render('_form3', [
        'model' => $model,
        'job_group' => $job_group,
    ]) ?>

    </div>
</div>
</div>
</div>
