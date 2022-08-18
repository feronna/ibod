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

<div class="row">
<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <ol class="breadcrumb">
                <li><?php echo Html::a('<i class="fa fa-home"></i> Halaman Utama', ['halaman-utama']) ?></li>
                <li><?php echo Html::a('Rekod Lantikan', ['admin-view', 'id' => $model->ICNO]) ?></li>
                <li><?= Html::a('Senarai Rekod Lantikan',['lihat-rekod-kakitangan', 'ICNO' => $model->ICNO])  ?></li>
                <li>Lihat Rekod Lantikan</li>
            </ol>
            <h2><strong>Lihat Rekod Lantikan</strong></h2>
        <div class="clearfix"></div>
        </div>
        
    <div class="col-md-12 col-xs-12">
    <h1><?= Html::encode($this->title) ?></h1>
   
     <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
//            'ICNO',
            ['label'=> 'No IC',
            'value' => $model->ICNO,
                'contentOptions' => ['style'=>'width:auto'],
             'captionOptions' => ['style'=>'width:26%'],],
            
//            'adminpos_id',
            ['label'=> 'Jawatan Pentadbiran',
            'value' => $model->displayadminpos->position_name],
            
//            'jobStatus',
            ['label'=> 'Status Jawatan',
            'value' => $model->displayjobstatus->jobstatus_desc],
            
//            'paymentStatus',
            ['label'=> 'Status Bayaran',
            'value' => $model->displaypaymentstatus->paymentstatus_desc],
            
//            'description',
            ['label'=> 'Catatan',
            'value' => $model->description],
            
//            'description_sef',
            
//            'dept_id',
            ['label'=> 'JFPIB',
            'value' => $model->dept->fullname],
            
//            'campus_id',
             ['label'=> 'Kampus',
            'value' => $model->campus->campus_name],
            
//            'start_date',
            ['label'=> 'Tarikh Lantikan',
            'value' => $model->tarikhMula],
            
//            'appoinment_date',
            ['label'=> 'Tarikh Kuatkuasa',
            'value' => $model->tarikhKuatkuasa],
            
//            'end_date',
            ['label'=> 'Tarikh Tamat',
            'value' => $model->tarikhTamat],
                                         
//            'flag',
            ['label'=> 'Status',
            'value' => $model->displayflag->flagstatus],
            
//            'files',
            ['label'=> 'Nama Fail',
            'value' => $model->files],
            
//            'renew',
            ['label'=> 'Status Pembaharuan',
            'value' => $model->displayrenew->renewstatus],
            
//            'status_tugas',
            ['label'=> 'Status Tugas',
            'value' => $model->displaytugasstatus->tugasstatus_desc],
        ],
    ]) ?>
    
<!--    <div class="form-group text-center">
        <?php //echo Html::a('Kembali', ['tblrscoadminpost/lihat-rekod-kakitangan', 'ICNO'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>
        <?php //echo Html::a('Kemaskini', ['kemaskini-rekod-lantikan', 'id'=>$model->id], ['class'=>'btn btn-primary']) ?>
    </div>-->
    </div>
        
    </div>
</div>
</div>
