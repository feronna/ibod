<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
error_reporting(0); 
?>

<!--<div class="row">
<div class="col-md-12">
    <php echo $this->render('/tblrscoadminpost/_topmenu'); ?> 
</div>
</div>-->
<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/portfolio/_menu');?>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
     
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>SENARAI REKOD MYPORTFOLIO</strong></h2>
        
      
                <div class="clearfix"></div>
            </div>
  
           
            <div class="x_content">

                <div class="table-responsive">
                    <?=
                        GridView::widget([
                        'options' => [
                        'class' => 'table-responsive',
                        ],
                        'dataProvider' => $dataProvider,
                        'filterModel' => true,
                        //'summary' => '',
                        //'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                        //'filterModel' => $searchModel,
                        'columns' => [
                             
                                [
                         'class' => 'kartik\grid\SerialColumn',
                        'header' => 'Bil.',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
  
                   [
                        'format' => 'raw',
                        'label' => 'Nama Kakitangan',
                        'value' => function($data){
                        return Html::a($data->CONm, ["/portfolio/lihat-portfolio", 'id' => $data->myjd->id], ['target' => '_blank']);
                        },
                        'filter' => Select2::widget([
                        'name' => 'ICNO',
                        'value' => $ICNO,
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '1'])->all(), 'ICNO', 'kakitangan.CONm'),
                       'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                        'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ],
                                
                   
                                
                     [
                        'label' => 'Jawatan',
                        'value' => 'jawatan.fname',
                         'filter' => Select2::widget([
                         'name' => 'gredJawatan',
                         'value' => $gredJawatan,
                          'data' => ArrayHelper::map(\app\models\hronline\GredJawatan::find()->all(), 'id', 'fname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ], 
           
                    [
                        'label' => 'JFPIU',
                        'value' => 'department.fullname',
                         'filter' => Select2::widget([
                         'name' => 'DeptId',
                         'value' => $DeptId,
                          'data' => ArrayHelper::map(\app\models\hronline\Department::find()->all(), 'id', 'fullname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ], 
                                
                  
                     
                      
                                [
                        'label' => 'STATUS BORANG',
                        'value' => function($model) {
                             if ($model->myjd->status_hantar == 1) {
                                  return '<span class="label label-success">TELAH DIHANTAR</span>';
                            }if (($model->myjd->status_hantar == null) && ($model->myjd->kp_agree == 2)) {
                                  return '<span class="label label-danger">DITOLAK</span>';
                            } else {
                                  return '<span class="label label-danger">BELUM DIHANTAR</span>';
                            }
                        },
                        'format' => 'raw',
                    ],
                                
                                
                    [
                        'label' => 'Status Perakuan KP',
                        'value' => function($model) {
                            
                            if($model->myjd->kp != null){
                            if ($model->myjd->kp_agree == null){
                             return '<span class="label label-danger">BELUM DIPERAKUKAN</span>';
                           
                            }if ($model->myjd->kp_agree == 1){
                             return '<span class="label label-success">DERAKUKAN</span>';
                           
                            } if ($model->myjd->kp_agree == 2){
                             return '<span class="label label-danger">DITOLAK</span>';
                           
                            }
                         }else{
                             return 'Terus kepada Pegawai Pelulus';
                         }
                       
                        },
                        'format' => 'raw',
                    ],
                         [
                        'label' => 'Perakuan KP',
                        'value' => function($model) {
                           if($model->myjd->kp != null){
                            if ($model->myjd->kp_agree == null){
                             return '<span class="label label-danger">BELUM DIPERAKUKAN</span>';
                           
                            }else{
                             return $model->myjd->perakuan_kp;
                            }
                           }else{
                                 return 'Terus kepada Pegawai Pelulus'; 
                           }
                       
                        },
                        'format' => 'raw',
                    ],
                                
                          [
                        'label' => 'Status Kelulusan KJ',
                        'value' => function($model) {
                            if ($model->myjd->kj_agree == null){
                             return '<span class="label label-danger">BELUM DILULUSKAN</span>';
                           
                            }if ($model->myjd->kj_agree == 1){
                             return '<span class="label label-success">DILULUSKAN</span>';
                           
                            } if ($model->myjd->kj_agree == 2){
                             return '<span class="label label-danger">DiTOLAK</span>';
                           
                            }
                       
                        },
                        'format' => 'raw',
                    ],
                                
                   [
                        'label' => 'Kelulusan KJ',
                        'value' => function($model) {
                            if ($model->myjd->kj_agree == null){
                             return '<span class="label label-danger">BELUM DILULUSKAN</span>';
                           
                            }else{
                             return $model->myjd->perakuan_kj;
                            }
                       
                        },
                        'format' => 'raw',
                    ],
                                
                                
//                    [
//                        'label' => 'Nama Naziran',
//                        'value' => function($model) {
//                            return ucwords(strtolower($model->naziran->naziranIcno->CONm));},
//                        'format' => 'raw',
//                    ],

                                    
//                         [
//                            'label'=>'Cetak',
//                            'format' => 'raw',
//                            'value'=>function ($data){
//                      
//                            return Html::a('<span aria-hidden="true">CETAK</span>', ['my-portfolio/generate-letter-admin', 'id' => $data->myjd->id ], ['class' => 'btn btn-danger btn-xs']);
//                            },
//                           
//                        ],            
            
//                            [
//                            'label'=>'Tindakan',
//                            'format' => 'raw',
//                            'value'=>function ($data){
//                       
//                            return Html::a('<span aria-hidden="true">MyJD</span>', ['my-portfolio/deskripsi-tugas-admin', 'id' => $data->myjd2->id ], ['class' => 'btn btn-info btn-xs']);
//                            },
//                             
//                        ],
//                                    
                        
                                    
                                    
                         [
                            'label'=>'Borang Naziran',
                            'format' => 'raw',
                            'value'=>
                              function ($data){
                             
                               if($data->myjd->naziran->icno != $data->myjd->icno){
                             return Html::a('<span aria-hidden="true">Tambah</span>', ['my-portfolio/borang-naziran', 'id' => $data->myjd->id ], ['class' => 'btn btn-primary btn-xs']);
                                }
                              else{
                              return Html::a('<span aria-hidden="true">Kemaskini</span>', ['my-portfolio/kemaskini-borang-naziran', 'id' => $data->myjd->id ], ['class' => 'btn btn-warning btn-xs']);
                                }                        
       

                            },
                            
                        ],
                    
                       
                                
                                
                                
                                
                                         
                            ],
                                
                        'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                        'resizableColumns' => true,
                        'responsive' => false,
                        'responsiveWrap' => false,
                        'floatHeader' => true,
                        'floatHeaderOptions' => ['position' => 'absolute'],
                        'resizableColumnsOptions' => ['resizeFromBody' => true]
                                
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>