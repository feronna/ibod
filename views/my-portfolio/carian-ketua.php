<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
?> 


<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/my-portfolio/_menu');?>
</div>


<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel"> 
        <div class="x_content">
            <?php $form = ActiveForm::begin(); ?>

            <div class="col-md-3 col-sm-3 col-xs-3 col-md-offset-8 col-sm-offset-8 col-xs-offset-8">
                <?=
                $form->field($search, 'ICNO')->widget(Select2::classname(), [
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
                    $form->field($search, 'DeptId')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Department::find()->all(), 'id', 'shortname'),
                        'options' => ['placeholder' => 'Jabatan', 'class' => 'form-control col-md-4 col-xs-12'],
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
                        'label' => 'No. K/P',
                        'value' => function($model) {
                             if ($model->biodata->NatCd == "MYS") {
                                return $model->icno;
                            } else {
                                return $model->biodata->latestPaspot;
                            }
                        },
                        'format' => 'raw',
                    ],
                 
                    [
                        'label' => 'Status Borang',
                        'value' => function($model) {
                             if ($model->status_hantar == 1) {
                                  return '<span class="label label-success">TELAH DIHANTAR</span>';
                            } else {
                                  return '<span class="label label-danger">BELUM DIHANTAR</span>';
                            }
                        },
                        'format' => 'raw',
                    ],
                      [
                        'label' => 'Nama PP',
                        'value' => function($model) {
                            return ucwords(strtolower($model->ketuaPerkhidmatan->CONm));                       },
                        'format' => 'raw',
                    ],
                     [
                        'label' => 'Status Perakuan PP',
                        'value' => function($model) {
                            
                            if($model->kp != null){
                            if ($model->kp_agree == null){
                             return '<span class="label label-danger">BELUM DIPERAKUKAN</span>';
                           
                            }if ($model->kp_agree == 1){
                             return '<span class="label label-success">DERAKUKAN</span>';
                           
                            } if ($model->kp_agree == 2){
                             return '<span class="label label-danger">DiTOLAK</span>';
                           
                            }
                         }else{
                             return 'Terus kepada Pegawai Pelulus';
                         }
                       
                        },
                        'format' => 'raw',
                    ],
                                    
                       [
                        'label' => 'Nama KJ',
                        'value' => function($model) {
                            return ucwords(strtolower($model->ketuaJabatan->CONm));                       },
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
                            'label'=>'Tindakan',
                            'format' => 'raw',
                            'value'=>function ($data){
                       
                            //  return  Html::button('<i class="fa fa-info" aria-hidden="true"></i> INFO', ['value' => \yii\helpers\Url::to(['keterangan-log', 'id' => $data->id]), 'class' => 'mapBtn btn-sm btn-danger btn-block']);
                                  return Html::a('<i class="fa fa-eye">', ["my-portfolio/deskripsi-tugas-admin", 'id' => $data->id]);                   

                            },
                              'hAlign' => 'center',
                              'vAlign' => 'middle',
                        ],
                                    
                           [
                            'label'=>'Tindakan',
                            'format' => 'raw',
                            'value'=>function ($data){
                                  if(!is_null($data->kp)){
                           

                                if(is_null($data->kp_agree)){
                                   return Html::a('Kemaskini KP', ['my-portfolio/kemaskini-data-pensetuju', 'id' => $data->id], ['class'=>'btn btn-info btn-xs']);
                                }else{
                                        return "<span class='badge badge-success'>Telah Diperakukan</span>";
                                    }
                                }else{
                                return Html::a('Tambah KP', ['my-portfolio/kemaskini-data-pensetuju', 'id' => $data->id], ['class'=>'btn btn-success btn-xs']);
                            }
                      
                            },
                              'hAlign' => 'center',
                              'vAlign' => 'middle',
                        ],
                                    
                              [
                            'label'=>'Tindakan',
                            'format' => 'raw',
                            'value'=>function ($data){
   
                                    if(!is_null($data->kj)){

                                    if(is_null($data->kj_agree)){
                                        return Html::a('Kemaskini KJ', ['my-portfolio/kemaskini-data-peraku', 'id' => $data->id], ['class'=>'btn btn-success btn-xs']);
                                    }else{
                                        return "<span class='badge badge-success'>Telah Diperakukan</span>";
                                    }
                                }else{
                                    return Html::a('Tambah KJ', ['my-portfolio/kemaskini-data-peraku', 'id' => $data->id], ['class'=>'btn btn-info btn-xs']);
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
                                'heading' => '<h2>KEMASKINI PP & KJ</h2>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>  

