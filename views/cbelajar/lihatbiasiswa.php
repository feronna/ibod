<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = 'Maklumat Pembiayaan dan Pinjaman';

?>

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="row">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['cutibelajar/halaman-pemohon']) ?></li>
        <li><?= Html::a('Maklumat Pembiayaan / Pinjaman', ['cbelajar/maklumat-biasiswa', 'id'=>$model->iklan_id]) ?></li>
        
    </ol>
</div>
    <div class="x_panel">
        
        <p align="right"><?php
          
    echo Html::button('Kemaskini Maklumat Biasiswa <i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-sponsor', 'id' => $model->id]),
                     'class' => 'btn btn-primary btn-xs mapBtn'])                               
                 ;
                 

 ?></p>
        <div class="x_title text-center">
    
            <h2><strong><i class="fa fa-money"></i> PEMBIAYAAN/PINJAMAN</strong></h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="tblprcobiodata-view ">
                <p>

    <div class="table-responsive">
    <?= $this->render('_lihatbiasiswa',[
        'model'=>$model,
        ]) ?>
               </div>
          </div>   
        </div>
        <p align="right">
                    <?= Html::a('Kembali', ['maklumat-biasiswa', 'id'=> $model->iklan_id], ['class' => 'btn btn-primary btn-sm']) ?>
               </p>
    </div>
</div>

