<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<div class="col-md-12 col-sm-12 col-xs-12"> 

<?php echo $this->render('/cutibelajar/_topmenu'); ?>

<p align ="right">
                    
                    <?php echo Html::a('Kembali',  ['cbadmin/pemohon/maklumat-biasiswa',  'id' => $model->iklan_id], ['class' => 'btn btn-primary btn-sm']); ?> 
                </p>
                
<div class="x_panel">
<div class="x_title">
   <h5 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT BIASISWA</strong></h5>
   
   
   <div class="clearfix"></div>
</div> 
    <p align="right"><?php
          
    echo Html::button('Kemaskini Maklumat Biasiswa <i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['cbadmin/pemohon/update-sponsor', 'id' => $model->id]),
                     'class' => 'btn btn-primary btn-xs mapBtn'])                               
                 ;
                 

 ?></p>
<div class="x_content">
<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label'=>'NAMA TAJAAN',
             'value'=> strtoupper($model->nama_tajaan)],
            
           
            ['label'=> 'BENTUK TAJAAN ',
             'value' => strtoupper($model->sponsor->bentukBantuan_ums),
            ],
            ['label'=> 'AMAUN',
             'format'=>'raw',
             'value' => "RM".$model->amaunBantuan],
           
            

        ],
    ]) ?>
</div></div></div>
