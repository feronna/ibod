<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;

?>
        <div class="row">

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
                    <?php echo Html::a('<i class="fa fa-edit"></i> ', ['cbelajar/updatesm', 'id' => $model->id], ['class' => 'btn btn-success btn-sm', 'target'=>'_blank']); ?>
                  
                </p>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="tblprcobiodata-view ">
                <p>

               <div class="table-responsive">
<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label'=>'Lokasi Pengajian',
             'value'=>$model->lokasi],
            ['label'=>'Nama Universiti',
             'value'=>$model->InstNm],
            ['label'=> 'Negara',
             'value' => $model->negara->Country,
             'contentOptions' => ['style'=>'width:auto'],
              'captionOptions' => ['style'=>'width:26%'],
            ],
            ['label'=> 'Peringkat Pengajian',
             'format'=>'raw',
             'value' =>$model->tahapPendidikan],
            ['label'=> 'Bidang',
             'value' => $model->major->MajorMinor],
             ['label'=> 'Mod Pengajian',
             'format'=>'raw',
             'value' =>$model->mod->studyMode],
            ['label'=> 'Tarikh Mula Pengajian',
             'value' => $model->tarikhmula],
            ['label'=> 'Tarikh Tamat Pengajian',
             'value' => $model->tarikhtamat],
            ['label'=> 'Tempoh Pengajian',
             'value' => $model->tempohpengajian],
            ['label'=> 'Tajuk Tesis / Tajuk Penyelidikan',
             'value' => $model->tajuk_tesis],
            ['label'=> 'Nama Penyelia',
             'value' => $model->nama_penyelia],
            ['label'=> 'Emel Penyelia',
             'value' => $model->emel_penyelia],
            

        ],
    ]) ?>

 </div>
          </div>   
        </div>
        <p align="right">

                    <?= Html::a('Kembali', ['maklumat-pengajian-separuh-masa', 'id' => $model->iklan_id], ['class' => 'btn btn-primary btn-sm']) ?>
               </p>
    </div>
     </div></div></div>