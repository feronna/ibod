 <?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\export\ExportMenu;
use kartik\date\DatePicker;
use yii\helpers\Url;

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
    <p align="right">  <?= Html::a('Kembali', ['cbadmin/halaman-admin'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->

    <div class="x_title">
            <h5><strong>LAPORAN KEMAJUAN PENGAJIAN (LKP)</strong></h5>
            
            <div class="clearfix"></div>
        </div>

         <div class="x_content">
             
<?php
  echo Html::a(Yii::t('app','<i class="fa fa-address-card"></i> <span class="label label-success">REKOD KESELURUHAN</span>'), ['cbadmin/search-lkk'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-calendar"></i> <span class="label label-info">LKP BULANAN</span>'), ['cbadmin/lkk-report'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">SEMAKAN LKP</span>'), ['lkk/senaraisemakan'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-book"></i> <span class="label label-info">LAPORAN AKHIR</span>'), ['lkk/laporan-akhir'], ['class' => 'btn btn-default btn-lg']);


?>
         </div>
    </div>
      </div>


<div class="col-md-12 col-sm-12 col-xs-12 "> 

 <div class="x_panel" >
    <div class="x_title">
        <h2>CARIAN</h2>
        
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
        <h5><strong>SENARAI LAPORAN KEMAJUAN PENGAJIAN (LKP) KAKITANGAN</strong></h5>
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
                  
                                return Html::a('<u><strong>'.$model->kakitangan->CONm.'</strong></u>', ['/lkk/senarailkk?icno='.$model->icno]).'</small>'.' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.
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
                                
//                        [
//                        'label' => 'TARIKH MULA PENGAJIAN',
//                        'format' => 'raw',
////                        'filter' => Select2::widget([
////                            'name' => 'tarikhtamat',
////                            'value' => isset(Yii::$app->request->queryParams['tarikhtamat'])? Yii::$app->request->queryParams['HighestEduLevelCd']:'',
////                            'data' => ArrayHelper::map(\app\models\cbelajar\Edulevel::find()->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
////                            'options' => ['placeholder' => ''],
////                            'pluginOptions' => [
////                                'allowClear' => true
////                            ],
////                        ]),
////                            
//                             'value'=>function ($model)  {
//                    
//                             if($model->tarikh_mula)
//                             {
//                             return '<span class="label label-primary"> '. strtoupper($model->tarikhmula). '</span>';
//                             
//                             }
////                          if(!$model->lanjut->icno)
////                             {
////                              var_dump($model->lanjut->icno);die;
//////                                 return 
//////                                 '<span class="label label-danger"> '. 
//////                                  strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->ndlanjutan). 
//////                                 '</span>';
////                             }
//                             else{
//                                 return "-";
//                             }
////                             elseif ($model->lanjutan)
////                             {
////    return strtoupper($model->tahapPendidikan);
////                             }
//                },
//                            
//                     
//                        'vAlign' => 'middle',
//                'hAlign' => 'center', 
//                     
//                    ],
                           
[
                        'label' => 'TARIKH AKHIR HANTAR LKP',
                       'value' => function($model) {
                    
//                    if($model->lkk->status_borang == "Complete")
//                    {
                        return  strtoupper($model->lkk->dt);
//                    }
//                    else
//                    {
//                       return strtoupper($model->lkk->dt);
// 
//                    }
                        
                       },
                        'format' => 'raw',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                       
                                
                              [
                        'label' => 'LKP',
                        'value' => function($model) {
                            return Html::a('<i class="fa fa-bar-chart" aria-hidden="true"></i>', [
                                        'cbadmin/main-lkp',
//                                        'icno' =>$model->icno,
                                        'id' => $model->icno,
                                
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
               
