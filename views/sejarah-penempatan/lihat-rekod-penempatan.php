<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */
//$this->title = 'Sejarah Penempatan';
?> 
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <ol class="breadcrumb">
                <li><?php echo Html::a('<i class="fa fa-home"></i> Halaman Utama', ['halaman-utama']) ?></li>
                <li><?php echo Html::a('Rekod Penempatan', ['admin-view', 'id' => $model->ICNO]) ?></li>
                <li><?= Html::a('Sejarah Penempatan',['lihat-rekod-kakitangan', 'ICNO' => $model->ICNO])  ?></li>
                <li>Lihat Sejarah Penempatan</li>
            </ol>
            <h2><strong>Lihat Sejarah Penempatan</strong></h2>
        <div class="clearfix"></div>
        </div>
        
    <div class="col-md-12 col-xs-12">
    <h1><?= Html::encode($this->title) ?></h1>
   
     <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',

//            ['label'=> 'ICNO',
//            'value' => $model->ICNO],

            ['label'=> 'JFPIB',
            'value' => $model->department->fullname,
               'contentOptions' => ['style'=>'width:auto'],
             'captionOptions' => ['style'=>'width:26%'],],
            
            ['label'=> 'Kampus',
            'value' => $model->campus->campus_name],
            
            ['label'=> 'Sebab Perpindahan',
            'value' => $model->reasonPenempatan->name],
            
            ['label'=> 'No. Ruj. Surat Arahan Penempatan',
            'value' => $model->letter_order_refno],
            
            ['label'=> 'Tarikh Surat Arahan Penempatan',
            'value' => $model->tarikhSurat],
            
            ['label'=> 'No. Ruj. Surat',
            'value' => $model->letter_refno],
            
                   
            ['label'=> 'Catatan',
            'value' => $model->remark],
            
            ['label'=> 'Tarikh Kuatkuasa',
            'value' => $model->tarikhMula],
            
//            ['label'=> 'Dikemaskini Oleh',
//            'value' => $model->update->CONm],
            
            ['label'=> 'Dikemaskini Oleh',
            'value' => $model->update_by],
            
            ['label'=> 'Tarikh Kemaskini',
            'value' => $model->tarikhKemaskini],

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



