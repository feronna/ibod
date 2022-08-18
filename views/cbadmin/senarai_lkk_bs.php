<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
?>
<script src="/pace/pace.js"></script>
<link href="/pace/themes/pace-theme-barber-shop.css" rel="stylesheet" />
<?php
error_reporting(0); 
?>
<div class="row">

<?= $this->render('/cutibelajar/_topmenu') ?>
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <p align="right">  <?= Html::a('Kembali', ['cbadmin/halaman-admin'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
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
    </div>


    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-book"></i> LAPORAN KEMAJUAN KURSUS</strong></h2>
                <br/>
<!--                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>-->
                <div class="clearfix"></div>
            </div>
            <?= Html::a('<i class="text-success fa fa-download"></i> Muat Turun', ['report', 'status' => $searchModel->status_bsm],['style'=>"float: right; font-size:18px;", 'target' => "_blank"]) ?>
            
            <br>
<!--             <h5>Senarai Kakitangan Akademik - Tidak Aktif Bergaji Penuh</h5>-->
            
            <div class="x_content">
                

                <?=
                GridView::widget([
                'options' => [
                'class' => 'table-responsive',
                    ],
                    'dataProvider' => $dataProvider,
                    'filterModel' => true,
                    'summary' => '',

                    'columns' => [
                            ['class' => 'kartik\grid\SerialColumn',
                                'header' => 'Bil',
                                'vAlign' => 'middle',
                        'hAlign' => 'center',
                                ],
                        
                        [
                        'label' => 'NAMA ',
                                'headerOptions' => ['style' => 'width:50%'],

                        'format' => 'raw',
                        'filter' => Select2::widget([
                            'name' => 'icno',
                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\TblLkk::find()->where(['status_form'=>1])->all(), 'icno', 'kakitangan.CONm'),
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
                     
//                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                        'vAlign' => 'middle',
//                        'hAlign' => 'center',
                         'group' => true,
                    ],
                        [
                        'label' => 'JAWATAN',
                        'value' => 'kakitangan.jawatan.fname',
//                        'filter' => Select2::widget([
//                            'name' => 'jawatan',
//                            'value' => isset(Yii::$app->request->queryParams['jawatan'])? Yii::$app->request->queryParams['jawatan']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPermohonan::find()->where(['jenis_user_id' => '1'])->all(), 'kakitangan.jawatan.id', 'kakitangan.jawatan.fname'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                             
                            
                    ],
                         [
                'label' => 'JFPIB',
                'value'=>function ($data) {
                    return $data->kakitangan->department->shortname;
                },
                'filter' => Select2::widget([
                            'name' => 'jfpiu',
                            'value' => $jfpiu,
                            'data' => ArrayHelper::map(app\models\hronline\Department::find(['isActive' => 1])->all(), 'id', 'shortname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                    
                        ]),
                 
                'vAlign' => 'middle',
                'hAlign' => 'center',
                          
            ],
                        
                   
                    
                                
//                                     
//                   
////                      'value' => 'HighestEduLevel',
//                      'vAlign' => 'middle',
//                      'hAlign' => 'center',
//                    ], 
//                    [
//                      'label' => 'Tarikh Tamat Pengajian',
//                      'value' => 'study.tarikhtamat',
//                   
////                      'value' => 'HighestEduLevel',
//                      'vAlign' => 'middle',
//                      'hAlign' => 'center',
//                    ],     
                    
//                    [
//                        'label' => 'Universiti',
//                        'value' => 'study.InstNm',
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                    ], 
                       
//                        [
//                         'attribute' => 'tarikh_m',
//                            'value' => 'tarikhmohon',
//                        'label' => 'Tarikh Mohon',
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                    ],
                        
                        [
                        'label' => 'TARIKH HANTAR LKK',
                        'attribute' => 'effectivedt',
                        'format' => 'raw',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        
//                        [
//                        'label'=>'Tindakan',
//                        'format' => 'raw',
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                        'value'=>function ($data) {
//                        //return Html::a('<i class="fa fa-edit">', ["kontrak/tindakan_bsm", 'id' => $data->id]);
//                        if($data->status!='5' && $data->status!='4'){
//                       return
//                        Html::a('<i class="fa fa-edit">', ["status-perkhidmatan/view", 'icno' => $data->icno], ['target' => '_blank',  'data-toggle'=>'tooltip', 
//                        'title'=>'Ubah Status Perkhidmatan']);}
//                        else{
// 
//                            return Html::a('<i class="fa fa-edit">', ["kontrak/permohonankontrak", 'id' => $data->id], ['target' => '_blank']);
//                        }
//                      },
//             ],
                    [
                                            'header' => 'LKK',
                                            'headerOptions' => ['class'=>'text-center'],
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{mohon}',
                                            'buttons' => [
                                                'mohon' => function($url, $model) 
                                                {
                                                        $ICNO = $model->icno;
                                                        $url = Url::to(['cbadmin/view-lkk', 'id'=>$ICNO]);
                                                       return 
                                                        Html::a('<i class="fa fa-bar-chart fa-xs"></i>', $url, ['title' => 'Lihat Laporan']); 
                                                    
                                                },
                                                        
                                                
                                                
                                        ],
                                                
                                            'contentOptions' => ['class' => 'text-center'],
                                        ],
//                              [
//                'class' => 'yii\grid\CheckboxColumn',
//                'checkboxOptions' => function ($data) { 
//                if(($data->status_bsm=='4' ||$data->status_bsm=='5')){
//                return ['disabled' => 'disabled'];
//                }
//                return ['value' => $data->id, 'checked'=> true];
//                },
//            ],
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
</div>

