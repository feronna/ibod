<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\select2\Select2;
error_reporting(0);
/* @var $this yii\web\View */
/* @var $searchModel app\models\pengesahan\PengesahanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?= $this->render('/pengesahan/_topmenu') ?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"  style="display: <?php echo $displaypentadbiran;?>"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><?php echo $titlepentadbiran;?></strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             <?= GridView::widget([
        'dataProvider' => $senaraipentadbiran,
        'summary' => '',
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn',
                                'header' => 'Bil.',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                                ],
            [
                'label' => 'Nama',
                'value' => 'kakitangan.CONm'
            ], 
            [
                'label' => 'Jawatan & Gred',
                'value' => 'kakitangan.jawatan.fname'
            ],    
                         [
                        'header' => 'Status Pengesahan',
                        'attribute' => 'confirmation.statusPengesahan.ConfirmStatusNm',
                        'format' => 'raw',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
            [
                'label' => 'Tarikh Mohon',
                'value' => 'tarikhmohon'
            ],
            [
                'label' => 'Status Perakuan Ketua Jabatan',
                'format' => 'raw',
                'value'=>function ($data) use($titlepentadbiran) {

                       if($titlepentadbiran == 'Senarai Menunggu Perakuan [Pentadbiran]'){
                           return $data->statusjfpiu;
                       }
                      },
                              'vAlign' => 'middle',
                        'hAlign' => 'center',
            ],
            [
                'label' => 'Status Kelulusan BSM',
                'format' => 'raw',
                'value'=>function ($data) use($titlepentadbiran) {
                
                        if($titlepentadbiran == 'Senarai Menunggu Perakuan [Pentadbiran]'){
                            return $data->statusbsm;
                        }  
                      },
                              'vAlign' => 'middle',
                        'hAlign' => 'center',
            ],                  
            [
                'label' => 'Tindakan',
                'format' => 'raw',
                'value'=>function ($data) use($titlepentadbiran){
                       if($titlepentadbiran == 'Senarai Menunggu Perakuan [Pentadbiran]'){
                          return 
                        Html::a('<i class="fa fa-edit">', ["pengesahan/tindakan_jfpiu", 'id' => $data->id], ['target' => '_blank']);
                       }
                        
                      },
            ],
//              [
//                'label' => 'Salinan Surat',
//                'format' => 'raw',
//                'value'=>function ($statuss){
//                          if($statuss->status == "DALAM TINDAKAN KETUA JABATAN" ){
//                          return 
//                        Html::a('<i class="fa fa-download">');
//                       }
//                       if($statuss->status == "LULUS"){
//                          return 
//                        Html::a('<i class="fa fa-download">', ["pengesahan/surat-pengesahan", 'id' => $statuss->id]);
//                       }
//                       else if ($statuss->status == "TIDAK LULUS"){
//                         return 
//                        Html::a('<i class="fa fa-download">', ["pengesahan/surat-pengesahan", 'id' => $statuss->id]);
//                       }  
//                       },
//                       
//            ],
        ],
    ]); ?>
    </div>
    </div>
</div>
</div>