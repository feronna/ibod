<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\web\View;
error_reporting(0);

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Rekod BRP';


$statusLabel = [
        1 => '<span class="label label-warning">Selesai Disahkan</span>',
        0 => '<span class="label label-danger">Ditolak</span>',
        null  => '<span class="label label-danger">Belum Disahkan</span>',
];
$statusLabel2 = [
        1 => '<span class="label label-info">Selesai Disemak</span>',
        0 => '<span class="label label-danger">Ditolak</span>',
        null  => '<span class="label label-danger">Belum Disemak</span>',
];


?>
<div class="row">
<div class="col-md-12 col-xs-12"> 
 <div class="x_panel"> 
        <div class="x_title">
            <h2>Checklist BRP Pegawai</h2> <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama Pegawai</th>
                        <td><?= $model->CONm?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. KP / Paspot</th>
                        <td><?php
                            if ($model->NatCd == "MYS") {
                                echo strtoupper($model->ICNO);
                            } else {
                                echo $model->latestPaspot;
                            }
                            ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                        <td><?=strtoupper($model->jawatan->nama); ?> (<?= $model->jawatan->gred; ?>)</td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jabatan</th>
                        <td><?= strtoupper($model->department->fullname); ?></td> 
                    </tr> 
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jenis Lantikan</th>
                        <td><?= strtoupper($model->statusLantikan->ApmtStatusNm)?></td> 
                    </tr> 
                    
                </table>
            </div> 

        </div>
    </div>




    <div class="x_panel">

        
        <div class="x_content">
         <?= Html::a('Carian Kakitangan', ['brp/index'], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Tambah Rekod BRP', ['brp/tambah-rekod', 'ICNO' => $model->ICNO], ['class' => 'btn btn-success']) ?>
         <?= Html::a('Tambah Rekod LPG', ['brp/view-rekod-lpg', 'COOldID' => $model->COOldID], ['class' => 'btn btn-success']) ?>
         <?= Html::a('Lihat BRP', ['buku-rekod', 'ICNO' => $model->ICNO, 't_lpg_id' => $t_lpg_id], ['class' => 'btn btn-success']);?>   
         <?= Html::a('Cetak BRP', ['cetak-brp', 'ICNO' => $model->ICNO], ['class' => 'btn btn-success']);?>   

        </div>
    </div>



    <div class="x_panel">
        <div class="x_content">
                <div class="table-responsive">
          <table class="table table-sm table-bordered">
                      <?=
             GridView::widget([
                 
            'dataProvider' => $provider,
                'options' => [
                'class' => 'table-responsive',
                    ],
                  'emptyText'=> 'Tiada Rekod',
                 'summary' => '',
                  'options' => ['style' => 'float: right; font-size:18px;'],
                 'columns' => [
                   ['header' =>'Bil.',
                 'class' => 'kartik\grid\SerialColumn',
          
                    'format' => 'raw',
                    ],
            
                ['label' => 'No Siri',
                  'value' => 'brp_id'
                ],
                  ['label' => 'Status Semakan',
                  'value' => function($model) {
                            if ($model->status == null){
                             return '<span class="label label-danger">BELUM DISEMAK</span>';
                           
                            } if ($model->status == 1){
                             return '<span class="label label-success">SELESAI DISEMAK</span>';
                           
                            } if ($model->status == 0){
                             return '<span class="label label-danger">BELUM DISEMAK</span>';
                           
                            }
                        },
                         'format' => 'raw',
                         'hAlign' => 'center',
                ],
                 ['label' => 'Tarikh Semakan',
                 'value' => 'status_date'],
                
                 ['label' => 'Pengesahan Pegawai',
                  'value' => function($model) {
                            if ($model->sah == null){
                             return '<span class="label label-danger">BELUM DISAHKAN</span>';
                           
                            } if ($model->sah == 1){
                             return '<span class="label label-success">SELESAI DISAHKAN</span>';
                           
                            } if ($model->sah == 0){
                             return '<span class="label label-danger">BELUM DISAHKAN</span>';
                           
                            }
                        },
                         'format' => 'raw',
                         'hAlign' => 'center',
                     
                 ],
                            
                 ['label' => 'Tarikh Pengesahan',
                  'value' => 'sah_date'
                ],
              
                 ['label' => 'Kemaskini',
                'format' => 'raw',
                'value'=>function ($data){
                         return  Html::a('<i class="fa fa-pencil">', ["brp/kemaskini-pengesahan", 'brp_id' => $data->brp_id]);
                                
                   },
                  'hAlign' => 'center',
                   'vAlign' => 'middle',
                 ],  
                           
                 ['label' => 'Padam',
                'format' => 'raw',
                'value'=>function ($data){
                         return Html::a('<i class="fa fa-trash">', ["brp/padam-pengesahan", 'brp_id' => $data->brp_id] );
                                
                   },
                  'hAlign' => 'center',
                   'vAlign' => 'middle',
                 ],
                ],
   
                'resizableColumns' => true,
                'responsive' => false,
                'responsiveWrap' => false,
             
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
        ]);?>
                      </table>
      
        </div>
    </div>
</div>
</div>
</div>











