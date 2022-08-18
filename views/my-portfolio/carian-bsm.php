<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
?> 

<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel"> 
        <div class="x_content">
            <?php $form = ActiveForm::begin(); ?>

            <div class="col-md-3 col-sm-3 col-xs-3 col-md-offset-8 col-sm-offset-8 col-xs-offset-8">
                <?=
                $form->field($search, 'icno')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Nama Staff'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                ?>
                
                
            </div>
            
                 <div class="col-md-3 col-sm-3 col-xs-3 col-md-offset-8 col-sm-offset-8 col-xs-offset-8">
         
                    <?=
                    $form->field($search, 'jabatan_semasa')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Department::find()->all(), 'id', 'shortname'),
                        'options' => ['placeholder' => 'Jabatan', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
         
            </div>
            
                 <div class="col-md-3 col-sm-3 col-xs-3 col-md-offset-8 col-sm-offset-8 col-xs-offset-8">
         
                    <?=
                    $form->field($search, 'gred')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\GredJawatan::find()->orderBy(['gred' => SORT_ASC])->all(), 'id', 'fname'),
                        'options' => ['placeholder' => 'Jawatan', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
         
            </div>
        

            <div class="col-md-1 col-sm-1 col-xs-1">
                <div class="form-group">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="x_panel"> 
        <div class="x_content">  


            <div class="table-responsive">

                <?php
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Nama Pegawai',
                        'value' => function($model) {
                            return ucwords(strtolower($model->biodata->CONm));                       },
                        'format' => 'raw',
                    ],
                     
                    [
                        'label' => 'Jabatan',
                        'value' => function($model) {
                            return ucwords(strtolower($model->department->fullname));                       },
                        'format' => 'raw',
                    ],
                                    
                     [
                        'label' => 'Jawatan',
                        'value' => function($model) {
                            return ucwords(strtolower($model->biodata->jawatan->nama));                       },
                        'format' => 'raw',
                    ],
                                    
                    [
                        'label' => 'Gred',
                        'value' => function($model) {
                            return ucwords(strtoupper($model->biodata->jawatan->gred));                       },
                        'format' => 'raw',
                    ],
                 
                    [
                        'label' => 'Status Borang',
                        'value' => function($model) {
                             if ($model->status_hantar == 1) {
                                  return '<span class="label label-success">TELAH DIHANTAR</span>';
                            }if (($model->status_hantar == null) && ($model->kp_agree == 2)) {
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
                            
                            if($model->kp != null){
                            if ($model->kp_agree == null){
                             return '<span class="label label-danger">BELUM DIPERAKUKAN</span>';
                           
                            }if ($model->kp_agree == 1){
                             return '<span class="label label-success">DERAKUKAN</span>';
                           
                            } if ($model->kp_agree == 2){
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
                           if($model->kp != null){
                            if ($model->kp_agree == null){
                             return '<span class="label label-danger">BELUM DIPERAKUKAN</span>';
                           
                            }else{
                             return $model->perakuan_kp;
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
                            if ($model->kj_agree == null){
                             return '<span class="label label-danger">BELUM DILULUSKAN</span>';
                           
                            }if ($model->kj_agree == 1){
                             return '<span class="label label-success">DILULUSKAN</span>';
                           
                            } if ($model->kj_agree == 2){
                             return '<span class="label label-danger">DiTOLAK</span>';
                           
                            }
                       
                        },
                        'format' => 'raw',
                    ],
                                
                   [
                        'label' => 'Kelulusan KJ',
                        'value' => function($model) {
                            if ($model->kj_agree == null){
                             return '<span class="label label-danger">BELUM DILULUSKAN</span>';
                           
                            }else{
                             return $model->perakuan_kj;
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
                      
                            return Html::a('<span aria-hidden="true">CETAK</span>', ['my-portfolio/generate-letter-admin', 'id' => $data->id ], ['class' => 'btn btn-danger btn-block']);
                            },
                              'hAlign' => 'center',
                              'vAlign' => 'middle',
                        ],            
            
                            [
                            'label'=>'Tindakan',
                            'format' => 'raw',
                            'value'=>function ($data){
                       
                            return Html::a('<span aria-hidden="true">MyJD</span>', ['my-portfolio/deskripsi-tugas-admin', 'id' => $data->id ], ['class' => 'btn btn-info btn-block']);
                            },
                              'hAlign' => 'center',
                              'vAlign' => 'middle',
                        ],
                                    
                        
                                    
                                    
                         [
                            'label'=>'Borang Naziran',
                            'format' => 'raw',
                            'value'=>
                              function ($data){
                             
                               if($data->naziran->icno != $data->icno){
                             return Html::a('<span aria-hidden="true">Tambah</span>', ['my-portfolio/borang-naziran', 'id' => $data->id ], ['class' => 'btn btn-primary btn-block']);
                                }
                              else{
                              return Html::a('<span aria-hidden="true">Kemaskini</span>', ['my-portfolio/kemaskini-borang-naziran', 'id' => $data->id ], ['class' => 'btn btn-warning btn-block']);
                                }                        
       

                            },
                              'hAlign' => 'center',
                              'vAlign' => 'middle',
                        ],
                    
                        ];



                        echo GridView::widget([
                            'dataProvider' => $permohonan,
                            'columns' => $gridColumns,
                            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                            'beforeHeader' => [
                                [
                                    'columns' => [], 
                                ]
                            ],
                            'toolbar' => [ 
                            ],
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true, 
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                                'heading' => '<h2>SENARAI REKOD JOB DESCRIPTION</h2>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>  

