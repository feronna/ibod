<?php

$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TblBarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sistem Rekod Stor Barangan Steril';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php echo $this->render('/cutibelajar/_topmenu');?>

<div class="x_panel" >
    <div class="x_title">
        <h2>Carian Penyelia</h2>
        <p align="right">   <?= Html::a('Tambah', ['tambah-penyelia'], 
                        ['class' => 'btn btn-success btn-sm',    'target' => '_blank',]) ?>
                            
                         <?= Html::a('Kembali', ['cbadmin/halaman-admin'], 
                        ['class' => 'btn btn-primary btn-sm']) ?>
                         
        
        <div class="clearfix"></div>
    </div>
</div>

<div class="x_panel">
    <div class="x_title">
        <h2><strong>REKOD PENYELIA</strong></h2>
         &nbsp;
   
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="table-responsive">

            <?=
            GridView::widget([
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
                            'name' => 'staff_icno',
                            'value' => isset(Yii::$app->request->queryParams['staff_icno'])? Yii::$app->request->queryParams['staff_icno']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\LkkTblPenyelia::find()->all(), 'staff_icno', 'kakitangan.CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                             'allowClear' => true
                            ],
                        ]),
                            
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->laporID;
                                                return Html::a('<strong><small>'.$model->kakitangan->CONm.'</strong></small>').'</small>'.' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')';
                  
//                                return Html::a('<u><strong>'.$model->kakitangan->CONm.'</strong></u>', ['/lkk/senarailkk?icno='.$model->icno]).'</small>'.' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.
//                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')';
                            }, 
                                  
                     
//                        'value' => function($data){
//                        return Html::a($data->kakitangan->CONm).'<br/> '
//                                ;
//                        },
//                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                     
                    ],
//            [
//                'label' => 'NAMA KAKITANGAN',
//                   'format' => 'raw',
////                         'vAlign' => 'middle',
////                          'hAlign' => 'center',
//
//                   'value' => function($model) {
////                                $ICNO = $model->icno;
////                                $id = $model->laporID;
//                                return Html::a('<strong><small>'.$model->kakitangan->CONm.'</strong></small>').'</small>'.' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.
//                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')';
//                            }, 
//              
////                'vAlign' => 'middle',
////                'hAlign' => 'center',
//            ],
                                    [
                'label' => 'SEMESTER',
                   'format' => 'raw',
                         'vAlign' => 'middle',
                          'hAlign' => 'center',

                 'value'=>function ($data) {
                    
                    if($data->reportId)
                    {
                    return '<small>'. strtoupper($data->svsem->semester). '</small>';
                    }
                    else
                    {
                        return '-';
                    }
                },
              
                
            ],
            [
                'label' => 'NAMA PENYELIA',
                   'format' => 'raw',
//                         'vAlign' => 'middle',
//                          'hAlign' => 'center',
 'filter' => Select2::widget([
                            'name' => 'nama',
                            'value' => isset(Yii::$app->request->queryParams['nama'])? Yii::$app->request->queryParams['nama']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\LkkTblPenyelia::find()->all(), 'nama', 'nama'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                             'allowClear' => true
                            ],
                        ]),
                 'value'=>function ($data) {
                    return '<small>'. strtoupper($data->nama). '</small>';
                },
              
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
            ],
            [
                'label' => 'EMEL',
                   'format' => 'raw',
//                         'vAlign' => 'middle',
//                          'hAlign' => 'center',

                 'value'=>function ($data) {
                    return ($data->emel);
                },
              
                
            ],
                        
            [
                'label' => 'JAWATAN',
                   'format' => 'raw',
//                         'vAlign' => 'middle',
//                          'hAlign' => 'center',

                 'value'=>function ($data) {
                    return '<small>'. strtoupper($data->jawatan).'</small>';
                },
              
                
            ],
                        [
                'label' => 'JABATAN',
                   'format' => 'raw',
//                         'vAlign' => 'middle',
//                          'hAlign' => 'center',

                 'value'=>function ($data) {
                    return '<small>'. strtoupper($data->jabatan). '</small>';
                },
              
                
            ],
                                 
                  [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'TINDAKAN',
                      
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                      
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['update', 'id' => $model->id]);
                                    return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 
                                        'class' => 'btn btn-default btn-xs modalButton']).
                                        Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', [
                                       'cb-lkk/delete-data?id='.$model->id,
                                   
                                           ], [
                                       'class' => 'btn btn-default btn-xs',
                                       'data' => ['confirm' => 'Anda ingin membuang rekod ini?', ],
                                    'vAlign' => 'middle',
                                       'hAlign' => 'center',
                                       
                                 
                                                                         ]);
                                    
                                    
                                },
                            ],
                        ],
//                                        [
//                        'label' => 'PADAM',
//                        'value' => function($model) {
////                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', [
////                                        'view-rekod-staf',
////                                        'id' => $model->icno,
//////                                        'title' => 'personal',
////                                            ], [
////                                        'class' => 'btn btn-default',
//////                                        'target' => '_blank',
////                                    ]) ;
//                                return  Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', [
//                                       'cb-lkk/delete-data?id='.$model->id,
//                                   
//                                           ], [
//                                       'class' => 'btn btn-default',
//                                       'data' => ['confirm' => 'Anda ingin membuang rekod ini?', ],
//                                    'vAlign' => 'middle',
//                                       'hAlign' => 'center',
//                                       
//                                 
//                                                                         ]);
//                        },
//                                
//                                'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//                                'format' => 'raw',
//                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 15%;'],
//                            ],
//                         [
//                'label' => 'NAMA KAKITANGAN',
//                   'format' => 'raw',
////                         'vAlign' => 'middle',
////                          'hAlign' => 'center',
//
//                 'value'=>function ($data) {
//                    return strtoupper($data->staff_icno);
//                },
//              
//                
//            ],
                        
                      
            
//                    [
//                        'label' => 'NAMA',
//                        'format' => 'raw',
//                        
//                        
//                            'value' => function($model) {
////                                $ICNO = $model->icno;
////                                $id = $model->laporID;
//                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').
//                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')'.' <br>'.$model->kakitangan->department->fullname.
//                                        ' ('.$model->kakitangan->department->shortname.')';
//                            }, 
//                                  
////                        'contentOptions' => ['style' => 'text-decoration: underline;'],
//                        'vAlign' => 'middle',
//                        
//                     
////                         'group' => true,
//                    ],
//                            
//                               [                      'label' => 'PERINGKAT PENGAJIAN',
//                       'value' => function($model) {
//                          if($model->tahapPendidikan)
//                                {
//                                return strtoupper($model->tahapPendidikan);}
//                       },
//                               'vAlign' => 'middle',
//                                               'hAlign' => 'center',
//
//                   ],
                                
//[
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
//                    
//                             if($model->HighestEduLevel)
//                             {
//                             return $model->HighestEduLevel;}
//                             else
//                             {
//    return strtoupper($model->tahapPendidikan);
//                             }
//                },
//                            
//                     
//                        'vAlign' => 'middle',
//                'hAlign' => 'center', 
//                     
//                    ],
                    
                                      
//                                [
//                        'label' => 'JENIS TAJAAN',
//                        'value' => function($model) {
//                            return strtoupper($model->nama_tajaan);
//                        },
//                                'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//
//                    ],
////                           [
//                'label' => 'JFPIB',
//                'value'=>function ($data) {
//                    return $data->kakitangan->department->shortname;
//                },
//                
//                 
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
//                          
//            ],

//                                [
//                        'label'=>'TINDAKAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data)  {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->icno;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['view_biasiswa', 'id' => $data->id]),'style'=>'background-color: transparent; 
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
////                              
//                            [
//                                'class' => 'yii\grid\CheckboxColumn',
//                                'checkboxOptions' => function ($model, $key, $index, $column) {
//
//                                    return ['value' => $model->icno, 'id' => $model->icno, 'onclick' => 'check(this.value, this.checked)'];
//                                }
//                                    ],
                                ],
                                             'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                'resizableColumns' => false,
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
