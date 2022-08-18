<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\Url; 
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
?>
<script src="/pace/pace.js"></script>
<link href="/pace/themes/pace-theme-barber-shop.css" rel="stylesheet" />
<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\kontrak\KontrakSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
 error_reporting(0); 
?>

<?= $this->render('/cutibelajar/_topmenu') ?>



<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-check"></i> Senarai Terima Tawaran Pengajian Lanjutan </strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <?= Html::a('<i class="text-success fa fa-download"></i> Muat Turun', ['report', 'status' => $searchModel->status_bsm],['style'=>"float: right; font-size:18px;", 'target' => "_blank"]) ?>
            
         
            
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
                        'label' => 'Nama Pemohon',
                        'format' => 'raw',
                        'filter' => Select2::widget([
                            'name' => 'icno',
                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPermohonan::find()->where(['jenis_user_id' => '1', 'status_proses'=>"Terima Tawaran"])->all(), 'icno', 'kakitangan.CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                        'value' => function($data){
                        return Html::a($data->kakitangan->CONm, ["maklumatkontrak1", 'id' => $data->id]);
                        },
                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'label' => 'Jawatan',
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
                        'label' => 'JFPIU',
//                        'filter' => Select2::widget([
//                            'name' => 'jfpiu',
//                            'value' => isset(Yii::$app->request->queryParams['jfpiu'])? Yii::$app->request->queryParams['jfpiu']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPermohonan::find()->where(['jenis_user_id' => '1'])->all(), 'kakitangan.department.id', 'kakitangan.department.shortname'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
                        'value' => 'kakitangan.department.shortname',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'options' => ['width' => '100px'],
                    ],
                        
                    [
                      'label' => 'Peringkat Pengajian',
                      'value' => 'study.pendidikanTertinggi.HighestEduLevel',
                   
//                      'value' => 'HighestEduLevel',
                      'vAlign' => 'middle',
                      'hAlign' => 'center',
                    ], 
                    
                                 [
                      'label' => 'Tarikh Pengajian',
                      'value' => function ($model){
                            
                                
                                if (($model->tarikhmula != null) && ($model->tarikhtamat != 0000-00-00)){
                                    
//                                 
                                        $formatteddate = $model->study->tarikhmula.' - '.$model->study->tarikhtamat;
                                    
                                } else {
                                    $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
                                } 
                                return $formatteddate;
                            },
                                     
//                                     
                   
//                      'value' => 'HighestEduLevel',
                      'vAlign' => 'middle',
                      'hAlign' => 'center',
                    ], 
//                    [
//                      'label' => 'Tarikh Tamat Pengajian',
//                      'value' => 'study.tarikhtamat',
//                   
////                      'value' => 'HighestEduLevel',
//                      'vAlign' => 'middle',
//                      'hAlign' => 'center',
//                    ],     
                    
                    [
                        'label' => 'Universiti',
                        'value' => 'study.InstNm',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ], 
                       
//                        [
//                         'attribute' => 'tarikh_m',
//                            'value' => 'tarikhmohon',
//                        'label' => 'Tarikh Mohon',
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                    ],
                        
//                        [
//                        'label' => 'Status Perakuan Ketua JFPIU',
//                        'attribute' => 'statusjfpiu',
//                        'format' => 'raw',
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                    ],
                        
                        [
                        'label'=>'Tindakan',
                        'format' => 'raw',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'value'=>function ($data) {
                        //return Html::a('<i class="fa fa-edit">', ["kontrak/tindakan_bsm", 'id' => $data->id]);
                        if($data->status!='5' && $data->status!='4'){
                       return
                        Html::a('<i class="fa fa-edit">', ["status-perkhidmatan/view", 'icno' => $data->icno], ['target' => '_blank',  'data-toggle'=>'tooltip', 
                        'title'=>'Ubah Status Perkhidmatan']);}
                        else{
 
                            return Html::a('<i class="fa fa-edit">', ["kontrak/permohonankontrak", 'id' => $data->id], ['target' => '_blank']);
                        }
                      },
             ],
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
                                                        Html::a('<i class="fa fa-file fa-xs"></i>', $url, ['title' => 'Lihat Data']); 
                                                    
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

