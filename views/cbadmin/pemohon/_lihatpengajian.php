<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<div class="col-md-12 col-sm-12 col-xs-12"> 

<?php echo $this->render('/cutibelajar/_topmenu'); ?>

<p align ="right">
                    
                    <?php echo Html::a('Kembali',  ['cbadmin/pemohon/maklumat-pengajian',  'id' => $model->iklan_id], ['class' => 'btn btn-primary btn-sm']); ?> 
                </p>
                
<div class="x_panel">
<div class="x_title">
   <h5 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div> 
    <p align="right"><?php
          
    echo Html::button('Kemaskini Maklumat Pengajian <i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['cbadmin/pemohon/update-study', 'id' => $model->id]),
                     'class' => 'btn btn-primary btn-xs mapBtn'])                               
                 ;
                 

 ?></p>
<div class="x_content">
<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label'=>'NAMA UNIVERSITI',
             'value'=> strtoupper($model->InstNm)],
            ['label'=> 'LOKASI PENGAJIAN',
             'value' => strtoupper($model->lokasi),
             'contentOptions' => ['style'=>'width:auto'],
              'captionOptions' => ['style'=>'width:26%'],
            ],
            ['label'=> 'NEGARA',
             'value' => strtoupper($model->negara->Country),
             'contentOptions' => ['style'=>'width:auto'],
              'captionOptions' => ['style'=>'width:26%'],
            ],
            ['label'=> 'BIDANG PENGAJIAN',
//             'value' => strtoupper($model->major->MajorMinor)],
            
              'value'=>function ($model)  {
                        if($model->MajorCd == 9999)
                        {
                          return strtoupper($model->MajorMinor);  
                        }
                        else {
                                        return strtoupper($model->major->MajorMinor);
                        }
                        },
                                ],
//             ['label'=> 'MOD PENGAJIAN',
//             'format'=>'raw',
//             'value' => strtoupper($model->mod->studyMode)],
            ['label'=> 'TARIKH MULA PENGAJIAN',
             'value' => strtoupper($model->tarikhmula)],
            ['label'=> 'TARIKH TAMAT PENGAJIAN',
             'value' => strtoupper($model->tarikhtamat)],
            ['label'=> 'TEMPOH PENGAJIAN',
             'value' => strtoupper($model->tempohtajaan)],
             ['label'=> 'NAMA PENYELIA',
             'value' => strtoupper($model->nama_penyelia)],
             ['label'=> 'EMEL PENYELIA',
             'value' => ($model->emel_penyelia)],
            
           
            

        ],
    ]) ?>
</div>
</div>
</div>