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
    <?php echo $this->render('/my-portfolio/_menu');?>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
     
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>SENARAI REKOD DESKRIPSI TUGAS</strong></h2>
        
      
                <div class="clearfix"></div>
            </div>
  
           
            <div class="x_content">
                
                <strong><p style="color: red">
               * PENYELIA HENDAKLAH MEMASTIKAN (DISEMAK OLEH) DAN (DILULUSKAN OLEH) ADALAH BETUL MENGIKUT PPP DAN PPK SEMASA STAF.
                    </p></strong>
                <strong><p style="color: red">
               * SEKIRANYA BERLAKU PERUBAHAN SKIM/JAWATAN ATAU PERTUKARAN TEMPAT BERTUGAS PENYELIA HENDAKLAH MEMASTIKAN STAF MEMBUAT MYJD BAHARU.
                </p></strong>

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
                       // return Html::a($data->CONm, ["deskripsi-tugas-admin", 'id' => $data->myjd->id], ['target' => '_blank']);
                          if($data->myjdPenyelia->id == null){
                             return $data->CONm."</br>".'<span style="color:#FF0000;text-align:center;">** PERLU MEMBUAT MYJD BAHARU</span>';
                         }else{
                          return Html::a($data->CONm, ["deskripsi-tugas-admin", 'id' => $data->myjd->id], ['target' => '_blank']);
                        
                         }
                        
                        },
                    
                        'filter' => Select2::widget([
                        'name' => 'ICNO',
                        'value' => $ICNO,
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '1'])->all(), 'ICNO', 'kakitangan.CONm'),
                       'data' =>  ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->where(['DeptId' => Yii::$app->user->identity->DeptId])->andWhere(['Status' => 1])->all(), 'ICNO', 'CONm'),
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
                        'vAlign' => 'middle',
                        'hAlign' => 'left',
                    ],
                                
                    [
                            'label'=>'Disemak Oleh (PPP)',
                            'format' => 'raw',
                            'value'=>function ($data){
                        if($data->myjdPenyelia->id != null){
                          
                               if(!is_null($data->myjd->kp)){
                                   return $data->myjd->ketuaPerkhidmatan->CONm. "</br>". Html::a('Kemaskini PPP', ['my-portfolio/kemaskini-data-ppp', 'id' => $data->myjd->id,'page' => Yii::$app->getRequest()->getQueryParam('page')], ['class'=>'btn btn-info btn-xs']);
                                }else{
                                return Html::a('Tambah PPP', ['my-portfolio/kemaskini-data-ppp', 'id' => $data->myjd->id], ['class'=>'btn btn-success btn-xs']);
                                }
                                  }
                              else{
                                  return  $data->myjd->ketuaPerkhidmatan->CONm;
                               }
                      
                            },
                              'hAlign' => 'center',
                              'vAlign' => 'middle',
                        ],
                                    
                          [
                            'label'=>'Diluluskan Oleh (PPK)',
                            'format' => 'raw',
                            'value'=>function ($data){
                        if($data->myjdPenyelia->id != null){
                          
                               if(!is_null($data->myjd->kj)){
                                   return $data->myjd->ketuaJabatan->CONm. "</br>". Html::a('Kemaskini PPK', ['my-portfolio/kemaskini-data-ppk', 'id' => $data->myjd->id, 'page' => Yii::$app->getRequest()->getQueryParam('page')], ['class'=>'btn btn-info btn-xs']);
                                }else{
                                return Html::a('Tambah PPK', ['my-portfolio/kemaskini-data-ppk', 'id' => $data->myjd->id], ['class'=>'btn btn-success btn-xs']);
                                }
                                  }
                              else{
                                  return  $data->myjd->ketuaJabatan->CONm;
                               }
                      
                            },
                              'hAlign' => 'center',
                              'vAlign' => 'middle',
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

                                    
                         [
                            'label'=>'Cetak',
                            'format' => 'raw',
                            'value'=>function ($data){
                      
                            return Html::a('<span aria-hidden="true">CETAK</span>', ['my-portfolio/generate-letter-admin', 'id' => $data->myjd->id ], ['class' => 'btn btn-danger btn-xs']);
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