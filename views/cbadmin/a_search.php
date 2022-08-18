 <?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
error_reporting(0);
?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>  



   

<div class="x_panel">
    <div class="x_title">
        <h2><strong>REKOD KESELURUHAN KAKITANGAN</strong></h2>
         <p align="right">  <?= Html::a('Kembali', ['cbadmin/halaman-admin'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
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
            'header' => 'NO',
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
  return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').'<br><small>'.$model->kakitangan->ICNO.'</small>'.' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>';
                                              
                            }, 
                                  
                     
//                        'value' => function($data){
//                        return Html::a($data->kakitangan->CONm).'<br/> '
//                                ;
//                        },
//                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                       'vAlign' => 'middle',
//                'hAlign' => 'center',
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
                                    
//                                    [
//                        'label' => 'NO. KAD PENGENALAN',
//                        'format' => 'raw',
//                        'filter' => Select2::widget([
//                            'name' => 'icno',
//                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPengajian::find()->all(), 'icno', 'kakitangan.ICNO'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
//                            
//                            
//                            'value' => function($model) {
////                                $ICNO = $model->icno;
////                                $id = $model->laporID;
//  return 
// '<br>'.$model->kakitangan->ICNO;//                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')';
//                            }, 
//                                  
//                     
////                        'value' => function($data){
////                        return Html::a($data->kakitangan->CONm).'<br/> '
////                                ;
////                        },
////                        'contentOptions' => ['style' => 'text-decoration: underline;'],
//                       'vAlign' => 'middle',
//                'hAlign' => 'center',
//                    ],
//                                    [
//                        'label' => 'JAWATAN',
//                        'format' => 'raw',
//                        
//                            
//                            
//                            'value' => function($model) {
////                                $ICNO = $model->icno;
////                                $id = $model->laporID;
//                                return 
//                                       strtoupper('<br>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')');
//                            }, 
//                                  
//                     ],
//                        'value' => function($data){
//                        return Html::a($data->kakitangan->CONm).'<br/> '
//                                ;
//                        },
//                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                     [
                'label' => 'JAWATAN',
                   'format' => 'raw',
                         'vAlign' => 'middle',
                          'hAlign' => 'center',

                'value'=>function ($data) {
                                    return   strtoupper('<br><strong>'.$data->kakitangan->jawatan->nama.'</strong><br> '.'<strong>('.$data->kakitangan->jawatan->gred.')</strong>');
                },
                'filter' => Select2::widget([
                            'name' => 'jawatan',
                            'value' => $jawatan,
                            'data' => ArrayHelper::map(app\models\hronline\GredJawatan::find()->all(), 'id', 'fname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
                                    
                            
//                                [
//                        'label' => 'PERINGKAT PENGAJIAN',
//                        'format' => 'raw',
//                        'filter' => Select2::widget([
//                            'name' => 'HighestEduLevelCd',
//                            'value' => isset(Yii::$app->request->queryParams['HighestEduLevelCd'])? Yii::$app->request->queryParams['HighestEduLevelCd']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\Edulevel::find()->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
//                            
//                             'value'=>function ($model)  {
//                            return $model->HighestEduLevel;
//                },
//                            
//                     
//                        'vAlign' => 'middle',
//                'hAlign' => 'center', 
//                     
//                    ],
                       
                                
//                                 [
//                        'label' => 'INSTITUSI/UNIVERSITI',
//                        'value' => function($model) {
//                            return strtoupper($model->InstNm);
//                        },
//                                'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//
//                    ],
                           
//                        [
//                'label' => 'STATUS',
//                'value'=>function ($model) {
//                    return strtoupper($model->kakitangan->serviceStatus->ServStatusNm);
//                },
//                'filter' => Select2::widget([
//                            'name' => 'status',
//                            'value' => $status,
//                            'data' => [1 => 'AKTIF', 2 => 'TIDAK AKTIF BERGAJI PENUH'],
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
////                        'visible' => $role,
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
//            ],
                        [
                'label' => 'STATUS PERKHIDMATAN',
                   'format' => 'raw',
                         'vAlign' => 'middle',
                          'hAlign' => 'center',

                 'value'=>function ($data) {
                    return strtoupper($data->kakitangan->serviceStatus->ServStatusNm);
                },
                'filter' => Select2::widget([
                            'name' => 'khidmat',
                            'value' => $khidmat,
                            'data' => ArrayHelper::map(app\models\hronline\ServiceStatus::find()->all(), 'ServStatusCd', 'ServStatusNm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
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
//                          [
//                'label' => 'STATUS PERKHIDMATAN',
//                'value'=>function ($data) {
//                    return strtoupper($data->kakitangan->serviceStatus->ServStatusNm);
//                },
//                
//                 
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
//                          
//            ],
                    [
                        'label' => 'PERINCIAN',
                        'value' => function($model) {
                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', [
                                        'view-rekod-staf',
                                        'id' => $model->icno,
//                                        'title' => 'personal',
                                            ], [
                                        'class' => 'btn btn-default',
//                                        'target' => '_blank',
                                    ]) ;
//                                    Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', [
//                                        'cbadmin/delete-data?id='.$model->id,
//                                    
//                                            ], [
//                                        'class' => 'btn btn-default',
//                                        'data' => ['confirm' => 'Anda ingin membuang rekod ini?', ],
//                                        'vAlign' => 'middle',
//                                        'hAlign' => 'center',
//                                        
//                                  
//                                      
//                                    ]);
                        },
                                
                                'vAlign' => 'middle',
                                                'hAlign' => 'center',
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 15%;'],
                            ],
//                            [
//                                'class' => 'yii\grid\CheckboxColumn',
//                                'checkboxOptions' => function ($model, $key, $index, $column) {
//
//                                    return ['value' => $model->icno, 'id' => $model->icno, 'onclick' => 'check(this.value, this.checked)'];
//                                }
//                                    ],
                                ],
                                'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                'resizableColumns' => true,
                'responsive' => true,
                'responsiveWrap' => true,
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

                <?php
                $icno = '';
                foreach ($dataProvider->query->all() as $d) {
                    $icno = $icno . ',' . $d->icno;
                }
                ?>
                
