<?php
$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);
use kartik\export\ExportMenu;
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\web\JsExpression;

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

error_reporting(0);
?>
<?= $this->render('/cutibelajar/_topmenu') ?>
<!-- $this->render('/lkk/menu_jumlah')-->
 <?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

    <?php 

$gridColumns = [
    
                        ['class' => 'yii\grid\SerialColumn',
                            'header' => 'BIL',],
//[   
//                            
//                            'label' => 'TARIKH AKHIR HANTAR LKP',
//                            'value' => function ($data){
//                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
//                                return strtoupper ($data->dt)
//                                  ;
//                            },
//                            'format' => 'raw'
//                            
//                        ],   
//                        [
//                'label' => 'SEMESTER/SESI',
//                'format' => 'raw',
//                'headerOptions' => ['class'=>'text-center'],
////                 'contentOptions' => ['class'=>'text-center'],
//                 'value'=>function ($list)
//                            {
//                                return
//                    '<small>: '.strtoupper($list->semester. ' / '. $list->session).'</small>';
//                 }
//                 
//                 
//            ],
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
                        
                     
                  
                        
                        
                        
                    ];


?>


      <p align="right"><?= Html::a('Kembali', ['statistik'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>

<div class="x_panel">
    
<div class="row"> 
    
<div class="col-md-12 col-xs-12"> 
         <div class="x_title">
            <h5><strong><i class="fa fa-check-circle fa-lg" style="color:green"></i> SENARAI KESELURUHAN</strong></h5>
            <p align ="left">  <?=
                    ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'filename' => '_senarai_keseluruhan '.' '.$my,
                            'clearBuffers' => true,
                            'stream' => false,
                            'folder' => '@app/web/files/cb/.',
                            'linkPath' => '/files/cb/',
                            'batchSize' => 10,
                        ]); 
                ?></p>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
             <?= GridView::widget([
                 'pager' => [
        'firstPageLabel' => 'First',
        'lastPageLabel'  => 'Last'
    ],
        'dataProvider' => $dataProvider,
//                         'filterModel' => FALSE,

//        'summary' => '',
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                 'options' => [
                'class' => 'table-responsive',
                    ],
        'columns' => [
//            ['class' => 'kartik\grid\SerialColumn',
//            'header' => 'No',
//            'vAlign' => 'middle',
//            'hAlign' => 'center',
//            ],
            ['class' => 'kartik\grid\SerialColumn',
             'header' => 'BIL',
             'contentOptions' => ['class'=>'text-center'],
              'vAlign' => 'middle',
            'hAlign' => 'center',
            ],
            
//            [
//                'label' => 'EMEL PENYELIA',
//                'format' => 'raw',
////                'headerOptions' => ['class'=>'text-center'],
////                                'contentOptions' => ['class'=>'text-center'],
//                        'value' => function($model) {                                        
//                                 return '<small>'.  strtolower($model->pengajian->emel_penyelia).'</small>';
//                                
// },
//            ],
            
           
                    
              
           [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA',
                            'headerOptions' => ['class'=>'column-title'],
                               'filter' => Select2::widget([
                            'name' => 'ICNO',
                            'value' => isset(Yii::$app->request->queryParams['ICNO'])? Yii::$app->request->queryParams['ICNO']:'',
                            'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'value' => function($model) {
                                $ICNO = $model->ICNO;
                                return Html::a('<strong>'.$model->CONm.'</strong>').'<br><small>'.$model->department->fullname.'</small>'.
                                        '<br><small>'.$model->jawatan->nama.' '.$model->jawatan->gred;
                            }, 
                          
                                    'format' => 'html',
                        ],
//               

                    
             
                                                        

            
        ],
                 'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],  
                'resizableColumns' => false,
                'responsive' => false,
                'responsiveWrap' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
    ]); ?>
    </div>
        </div>
     
    </div>
</div></div>


 