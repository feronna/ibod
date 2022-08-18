<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = 'Maklumat Pengajian Yang Telah Dipohon';

?>

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    
     <div class="x_panel">
        <div class="row">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['cutibelajar/halaman-utama-pemohon']) ?></li>
        <li><?= Html::a('Maklumat Pengajian Yang Dipohon', ['cbelajar/maklumat-pengajian', 'id'=>$model->iklan_id]) ?></li>
        
    </ol>
</div>
    <div class="x_panel">
        <div class="x_title text-center">
            <h2><strong><i class="fa fa-list-ul"></i> Maklumat Pengajian</strong></h2>
              <p align ="right">
                    <?php echo Html::a('<i class="fa fa-edit"></i> ', ['cbelajar/update', 'id' => $model->id], ['class' => 'btn btn-success btn-sm', 'target'=>'_blank']); ?>
                  
                </p>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="tblprcobiodata-view ">
                <p>

               <div class="table-responsive">
    <?= $this->render('_lihatpengajian',[
        'model'=>$model,
        ]) ?>
               </div>
          </div>   
        </div>
        <p align="right">

                    <?= Html::a('Kembali', ['maklumat-pengajian', 'id' => $model->iklan_id], ['class' => 'btn btn-primary btn-sm']) ?>
               </p>
    </div>
</div>

