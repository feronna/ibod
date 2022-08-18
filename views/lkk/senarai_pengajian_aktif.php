 <?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\export\ExportMenu;
use kartik\date\DatePicker;

error_reporting(0);
?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>  
<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

    <?php 

$gridColumns = [
    
                        ['class' => 'yii\grid\SerialColumn',
                            'header' => 'BIL',],

                        
                        [   
                            
                            'label' => 'NAMA KAKITANGAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->kakitangan->CONm));
                            },
                            'format' => 'raw'
                            
                        ],
                                    
                             [   
                            
                            'label' => 'NO KAD PENGENALAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->icno));
                            },
                            'format' => 'raw'
                            
                        ],
                         [
                'label' => 'JFPIB',
                'value'=>function ($data) {
                    return $data->kakitangan->department->shortname;
                },
                
                                            'format' => 'raw'

                          
            ],
                         [   
                            
                            'label' => 'INSTITUT/UNIVERSITI',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->InstNm));
                            },
                            'format' => 'raw'
                            
                        ],
                                    
                                 
                        [   
                            
                            'label' => 'NEGARA',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return strtoupper($data->negara->Country);
                            },
                            'format' => 'raw'
                            
                        ],
                                    
                           [   
                            
                            'label' => 'BIDANG',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                              
                                if(($data->MajorCd == NULL) && ($data->MajorMinor != NULL))
                        {
                                return  strtoupper($data->MajorMinor);
                        }
                        elseif (($data->MajorCd != NULL) && ($data->MajorMinor != NULL))  {
                            return   strtoupper($data->MajorMinor);

                        }
                        else
                        {
                          return   strtoupper($data->major->MajorMinor);
                        }
                            },
                            'format' => 'raw'
                            
                        ],
                        
                         [   
                            
                            'label' => 'TARIKH PENGAJIAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return strtoupper($data->tarikhmula).' HINGGA '.strtoupper($data->tarikhtamat);
                            },
                            'format' => 'raw'
                            
                        ],            
                                  
                                     
                        
                        
                        
                    ];


?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 

 <div class="x_panel" >
    <div class="x_title">
        <h2>CARIAN</h2>
        <p align="right">  <?= Html::a('Kembali', ['cbadmin/page-semak'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
        <div class="clearfix"></div>
    </div>
    <div class="x_panel">
            <div class="x_content">
                <?php
                $forms = ActiveForm::begin([
                            'action' => [''],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1
                            ],
                ]);
                ?>
                <div class="form-group">
                                      <div class="col-md-2 col-sm-2 col-xs-6">
                                        <?=  DatePicker::widget([
                                        'name' => 'my',
                                        'value' => $my,
                                        'type' => DatePicker::TYPE_INPUT,
                                         'options' => ['placeholder' => 'Tahun','autocomplete' => 'off'
                                                ],
                                        'pluginOptions' => [
                                            'autoclose'=>true,
                                            'format' => 'yyyy-mm',
                    //                        'viewMode' => "years", 
                                            'minViewMode'=> "months"
                                        ]
                                    ]);?>
                                    </div>
                                </div>
<!--                <div class="col-md-3 col-sm-3 col-xs-3 col-md-offset-8 col-sm-offset-8 col-xs-offset-8">
         
                    <?//php
                    $form->field($model, 'jabatan_semasa')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Department::find()->all(), 'id', 'shortname'),
                        'options' => ['placeholder' => 'Jabatan', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
         
            </div>
                 -->
               
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']) ?>
                </div>
                 

                <?php ActiveForm::end(); ?>
                 
            </div>
        </div>
 </div></div>
<div class="col-md-12 col-sm-12 col-xs-12 "> 

<div class="x_panel">
    <div class="x_title">
        <h2><strong>REKOD PERMOHONAN PENGAJIAN KAKITANGAN YANG DILULUSKAN (AKTIF)</strong></h2>
        <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
        &nbsp;
     <?=
                    ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'filename' => 'Senarai Kakitangan Cuti Belajar '.date('Y-m-d'),
                            'clearBuffers' => true,
                            'stream' => false,
                            'folder' => '@app/web/files/cb/.',
                            'linkPath' => '/files/cb/',
                            'batchSize' => 10,
                        ]); 
                    ?>
        <div class="clearfix"></div>
    </div>
    
    <div class="x_content">

        <div class="table-responsive">

           <?= GridView::widget([
        'pager' => [
        'firstPageLabel' => 'First',
        'lastPageLabel'  => 'Last'
    ],
        'options' => [
                'class' => 'table-responsive',
                    ],
        'dataProvider' => $dataProvider,
        'filterModel' => true,
//        'summary' => '',
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn',
            'header' => 'No',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            ],
                   [
                        'label' => 'NAMA',
                        'format' => 'raw',
                        'filter' => Select2::widget([
                            'name' => 'icno',
                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPengajian::find()->WHERE(['status'=>1])->all(), 'icno', 'kakitangan.CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                             'allowClear' => true
                            ],
                        ]),
                            
                            
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->laporID;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').'<br><small>'.$model->kakitangan->ICNO.'</small>'.' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')';
                            }, 
                                  
                     
//                        'value' => function($data){
//                        return Html::a($data->kakitangan->CONm).'<br/> '
//                                ;
//                        },
//                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                     
                    ],
                                    [
                'label' => 'JFPIB',
                                                     'format' => 'raw',

                'value'=>function ($data) {
                    return $data->kakitangan->department->shortname;
                },
                'filter' => Select2::widget([
                            'name' => 'jfpiu',
                            'value' => $jfpiu,
                            'data' => ArrayHelper::map(app\models\hronline\Department::find()->where(['isActive'=>1])->all(), 'id', 'shortname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
                                    [
                        'label' => 'PERINGKAT PENGAJIAN',
                        'format' => 'raw',
                        'filter' => Select2::widget([
                            'name' => 'HighestEduLevelCd',
                            'value' => isset(Yii::$app->request->queryParams['HighestEduLevelCd'])? Yii::$app->request->queryParams['HighestEduLevelCd']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\Edulevel::find()->orderBy(['HighestEduLevelRank'=>SORT_DESC])->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            
                             'value'=>function ($model)  {
                    
                             if($model->HighestEduLevel)
                             {
                             return $model->HighestEduLevel;}
                             else
                             {
    return strtoupper($model->tahapPendidikan);
                             }
                },
                            
                     
                        'vAlign' => 'middle',
                'hAlign' => 'center', 
                     
                    ],
                        
                       
                                    
//                            [
//                                
//                        'label' => 'PERINGKAT PENGAJIAN',
//                                
//                          
////                        'format' => 'raw',
//                        'filter' => Select2::widget([
//                            'name' => 'peringkat',
//                            'value' => isset(Yii::$app->request->queryParams['HighestEduLevelCd'])? Yii::$app->request->queryParams['HighestEduLevelCd']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\Edulevel::find()->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                             'allowClear' => true
//                                
//                            ],
//                        ]),
////                         'value'=>function ($data)  {
////                            return $data->HighestEduLevel;
////                },
//                                     'vAlign' => 'middle',
//                                     'hAlign' => 'center',
//                       ],
                                
//                                 [
//                        'label' => 'INSTITUSI/UNIVERSITI',
//                        'value' => function($model) {
//                            return strtoupper($model->pengajian->InstNm);
//                        },
//                                'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//
//                    ],
//                                
//                                [
//                        'label' => 'KATEGORI',
//                        'value' => function($model) {
//                             return $model->kakitangan->jawatan->fullname;
//                        },
//                                'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//
//                    ],
                                [
                'label' => 'KATEGORI',
                'value'=>function ($model) {
                    return $model->kakitangan->jawatan->job_category == 1? 'AKADEMIK':'PENTADBIRAN';
                },
                'filter' => Select2::widget([
                            'name' => 'category',
                            'value' => $category,
                            'data' => [1 => 'AKADEMIK', 2 => 'PENTADBIRAN'],
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
//                        'visible' => $role,
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
                        [
                        'label' => 'TARIKH TAMAT PENGAJIAN',
                        'format' => 'raw',
//                        'filter' => Select2::widget([
//                            'name' => 'tarikhtamat',
//                            'value' => isset(Yii::$app->request->queryParams['tarikhtamat'])? Yii::$app->request->queryParams['HighestEduLevelCd']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\Edulevel::find()->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
//                            
                             'value'=>function ($model)  {
                    
                             if($model->tarikh_tamat)
                             {
                             return '<span class="label label-danger"> '. strtoupper($model->tarikhtamat). '</span>';
                             
                             }
//                          if(!$model->lanjut->icno)
//                             {
//                              var_dump($model->lanjut->icno);die;
////                                 return 
////                                 '<span class="label label-danger"> '. 
////                                  strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->ndlanjutan). 
////                                 '</span>';
//                             }
                             else{
                                 return "-";
                             }
//                             elseif ($model->lanjutan)
//                             {
//    return strtoupper($model->tahapPendidikan);
//                             }
                },
                            
                     
                        'vAlign' => 'middle',
                'hAlign' => 'center', 
                     
                    ],
                           
//                    [
//                        'label' => 'TINDAKAN',
//                        'value' => function($model) {
//                            return Html::a('<i class="fa fa-info" aria-hidden="true"></i>', [
//                                        'view-rekod-staf',
//                                        'id' => sha1($model->icno),
////                                        'title' => 'personal',
//                                            ], [
//                                        'class' => 'btn btn-default',
//                                        'target' => '_blank',
//                                    ]) .
//                                    Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', [
//                                        'cbadmin/delete-data?id='.$model->id,
//                                    
//                                            ], [
//                                        'class' => 'btn btn-default',
//                                                
//                                        'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//                                        
//                                  
//                                      
//                                    ]);
//                        },
//                                'format' => 'raw',
//                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 15%;'],
//                            ],
                                
                              [
                        'label' => 'PERINCIAN',
                        'value' => function($model) {
                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', [
                                        'pengajian',
//                                        'icno' =>$model->icno,
                                        'id' => $model->id,
//                                        'i'=>$model->HighestEduLevelCd,
                                
//                                        'title' => 'personal',
                                            ], [
                                        'class' => 'btn btn-default',
//                                        'target' => '_blank',
                                    ]) ;
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 15%;'],
                                  'vAlign' => 'middle',
                                               'hAlign' => 'center',

                            ],
//                              [
//                        'label'=>'TINDAKAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data)  {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->icno;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['view_pengajian', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-edit fa-md mapBtn']);}
////                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
//                        else{
//                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
//                        }
//                      },
//                               'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//                           
//                    ],
                            
                                ],
                                'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                'resizableColumns' => true,
                'responsive' => false,
                'responsiveWrap' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
                            ]);
                            ?>
                        </div>
                    </div>
                </div> 
    
    <div class="x_panel">
    <div class="x_title">
        <h2><strong>REKOD PENGAJIAN KAKITANGAN YANG DILULUSKAN (KESELURUHAN)</strong></h2>
        <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
        &nbsp;
     <?=
                    ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'filename' => 'Senarai Kakitangan Cuti Belajar '.date('Y-m-d'),
                            'clearBuffers' => true,
                            'stream' => false,
                            'folder' => '@app/web/files/cb/.',
                            'linkPath' => '/files/cb/',
                            'batchSize' => 10,
                        ]); 
                    ?>
        <div class="clearfix"></div>
    </div>
    
    <div class="x_content collapse">

        <div class="table-responsive">

           <?= GridView::widget([
        'pager' => [
        'firstPageLabel' => 'First',
        'lastPageLabel'  => 'Last'
    ],
        'options' => [
                'class' => 'table-responsive',
                    ],
        'dataProvider' => $dataProvider,
        'filterModel' => true,
//        'summary' => '',
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn',
            'header' => 'No',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            ],
                   [
                        'label' => 'NAMA',
                        'format' => 'raw',
                        'filter' => Select2::widget([
                            'name' => 'icno',
                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPengajian::find()->all(), 'icno', 'kakitangan.CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                             'allowClear' => true
                            ],
                        ]),
                            
                            
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->laporID;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').'<br><small>'.$model->kakitangan->ICNO.'</small>'.' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')';
                            }, 
                                  
                     
//                        'value' => function($data){
//                        return Html::a($data->kakitangan->CONm).'<br/> '
//                                ;
//                        },
//                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                     
                    ],
                                    [
                'label' => 'JFPIB',
                                                     'format' => 'raw',

                'value'=>function ($data) {
                    return $data->kakitangan->department->shortname;
                },
                'filter' => Select2::widget([
                            'name' => 'jfpiu',
                            'value' => $jfpiu,
                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPengajian::find()->joinWith('kakitangan.department')->all(), 'kakitangan.DeptId', 'kakitangan.department.shortname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
                                    [
                        'label' => 'PERINGKAT PENGAJIAN',
                        'format' => 'raw',
                        'filter' => Select2::widget([
                            'name' => 'HighestEduLevelCd',
                            'value' => isset(Yii::$app->request->queryParams['HighestEduLevelCd'])? Yii::$app->request->queryParams['HighestEduLevelCd']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\Edulevel::find()->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            
                             'value'=>function ($model)  {
                    
                             if($model->HighestEduLevel)
                             {
                             return $model->HighestEduLevel;}
                             else
                             {
    return strtoupper($model->tahapPendidikan);
                             }
                },
                            
                     
                        'vAlign' => 'middle',
                'hAlign' => 'center', 
                     
                    ],
                       
                                    
//                            [
//                                
//                        'label' => 'PERINGKAT PENGAJIAN',
//                                
//                          
////                        'format' => 'raw',
//                        'filter' => Select2::widget([
//                            'name' => 'peringkat',
//                            'value' => isset(Yii::$app->request->queryParams['HighestEduLevelCd'])? Yii::$app->request->queryParams['HighestEduLevelCd']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\Edulevel::find()->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                             'allowClear' => true
//                                
//                            ],
//                        ]),
////                         'value'=>function ($data)  {
////                            return $data->HighestEduLevel;
////                },
//                                     'vAlign' => 'middle',
//                                     'hAlign' => 'center',
//                       ],
                                
//                                 [
//                        'label' => 'INSTITUSI/UNIVERSITI',
//                        'value' => function($model) {
//                            return strtoupper($model->pengajian->InstNm);
//                        },
//                                'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//
//                    ],
//                                
//                                [
//                        'label' => 'KATEGORI',
//                        'value' => function($model) {
//                             return $model->kakitangan->jawatan->fullname;
//                        },
//                                'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//
//                    ],
                                [
                'label' => 'KATEGORI',
                'value'=>function ($model) {
                    return $model->kakitangan->jawatan->job_category == 1? 'AKADEMIK':'PENTADBIRAN';
                },
                'filter' => Select2::widget([
                            'name' => 'category',
                            'value' => $category,
                            'data' => [1 => 'AKADEMIK', 2 => 'PENTADBIRAN'],
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
//                        'visible' => $role,
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
                           
//                    [
//                        'label' => 'TINDAKAN',
//                        'value' => function($model) {
//                            return Html::a('<i class="fa fa-info" aria-hidden="true"></i>', [
//                                        'view-rekod-staf',
//                                        'id' => sha1($model->icno),
////                                        'title' => 'personal',
//                                            ], [
//                                        'class' => 'btn btn-default',
//                                        'target' => '_blank',
//                                    ]) .
//                                    Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', [
//                                        'cbadmin/delete-data?id='.$model->id,
//                                    
//                                            ], [
//                                        'class' => 'btn btn-default',
//                                                
//                                        'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//                                        
//                                  
//                                      
//                                    ]);
//                        },
//                                'format' => 'raw',
//                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 15%;'],
//                            ],
                                
                              [
                        'label' => 'PERINCIAN',
                        'value' => function($model) {
                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', [
                                        'pengajian',
//                                        'icno' =>$model->icno,
                                        'id' => $model->id,
//                                        'i'=>$model->HighestEduLevelCd,
                                
//                                        'title' => 'personal',
                                            ], [
                                        'class' => 'btn btn-default',
                                        'target' => '_blank',
                                    ]) ;
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 15%;'],
                                  'vAlign' => 'middle',
                                               'hAlign' => 'center',

                            ],
//                              [
//                        'label'=>'TINDAKAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data)  {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->icno;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['view_pengajian', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-edit fa-md mapBtn']);}
////                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
//                        else{
//                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
//                        }
//                      },
//                               'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//                           
//                    ],
                            
                                ],
                                'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                'resizableColumns' => true,
                'responsive' => false,
                'responsiveWrap' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
                            ]);
                            ?>
                        </div>
                    </div>
                </div> 
</div>
                <?php
                $icno = '';
                foreach ($dataProvider->query->all() as $d) {
                    $icno = $icno . ',' . $d->icno;
                }
                ?>
                <script>
                    document.getElementsByClassName("select-on-check-all")[0].setAttribute("onclick", "selectall(this.checked)");
                    var inputs = document.getElementsByTagName('input');
                    var is_checked = false;
                    var t = '';
                    document.getElementsByClassName("select-on-check-all")[0].checked = true;
                    for (var x = 0; x < inputs.length; x++) {
                        if (inputs[x].type == 'checkbox' && inputs[x].name == 'selection[]') {
                            is_checked = inputs[x].checked;
                            if (is_checked == false) {
                                document.getElementsByClassName("select-on-check-all")[0].checked = false;
                            }
                        }
                    }
                    var data = sessionStorage.getItem('checkedcv');
                    var icno = data.split(',');
                    for (i = 0; i < icno.length; i++) {
                        var element = document.getElementById(icno[i]);
                        if (typeof (element) != 'undefined' && element != null)
                        {
                            element.checked = true;
                        }
                    }
                    function selectall(c) {
                        var icno = "<?= $icno ?>";
        var icno1 = icno.split(',');
        var data = sessionStorage.getItem('checkedcv');
        if (data == null) {
            data = '';
        }
        if (c === true) {
            for (i = 0; i < icno1.length; i++) {

                if (data.includes(icno1[i])) {
                }
                else {
                    data = data + ',' + icno1[i];
                }
            }
        }
        else {
            for (i = 0; i < icno1.length; i++) {
                if (data.includes(icno1[i])) {
                    data = data.replace(',' + icno1[i], '');
                    data = data.replace(icno1[i], '');
                }
            }

        }
        sessionStorage.setItem('checkedcv', data);
    }

    function check(val, c) {
        var data = sessionStorage.getItem('checkedcv');
        if (c === true) {
            data = data + ',' + val;
        }
        else {
            data = data.replace(',' + val, '');
            data = data.replace(val, '');
        }
        sessionStorage.setItem('checkedcv', data);
    }

    function test() {
        var data = sessionStorage.getItem('checkedcv');
        var keys = $('#w5').yiiGridView('getSelectedRows');
        window.open("data", '_blank');
    }

</script>
