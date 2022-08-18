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

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
<!--                <= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Kembali', ['halaman-utama-akademik'], ['class' => 'btn btn-primary']) ?><br>-->
                <h2><strong>Pelantikan 3 Bulan Akan Tamat (JFPIB Akademik)</strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', ['halaman-utama-akademik'], ['class' => 'btn btn-primary']) ?></p>   
<!--                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>-->
                <div class="clearfix"></div>
            </div>
<!--            <= Html::a('Kembali', ['halaman-utama-akademik'], ['class' => 'btn btn-primary']) ?>-->
            <?= Html::a('<div style="float: right; font-size:18px;"><i class="text-success fa fa-download"></i> Muat Turun</div>', ['reportakademik2', 'icno' => Yii::$app->request->queryParams['icno'], 'admin' => Yii::$app->request->queryParams['adminpos_id'], 'program' => Yii::$app->request->queryParams['program_id'], 'dept' => Yii::$app->request->queryParams['dept_id'], 'campus' => Yii::$app->request->queryParams['campus_id']]) ?>
            <div class="x_content">

                <div class="table-responsive">
                    <?=
                        GridView::widget([
                        'options' => [
                        'class' => 'table-responsive',
                        ],
                        'dataProvider' => $dataProvider,
                        'filterModel' => true,
                        //'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                        //'filterModel' => $searchModel,
                        'columns' => [
                             
                                [
                         'class' => 'kartik\grid\SerialColumn',
                        'header' => 'Bil.',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],

//                                [
//                        'label' => 'No IC',
//                        'value' => 'ICNO',
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                    ],
                            
//                                [
//                        'label' => 'Nama Staf',
//                        'value' => 'kakitangan.CONm',
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                    ],
                            
                                [
                        'format' => 'raw',
                        'label' => 'Nama Pemohon',
                        'value' => function($data){
                        return Html::a($data->kakitangan->CONm, ["lihat-rekod-lantikan", 'id' => $data->id], ['target' => '_blank']);
                        },
                        'filter' => Select2::widget([
                        'name' => 'icno',
                        'value' => $icno,
                        'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '1'])->all(), 'ICNO', 'kakitangan.CONm'),
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                                
//                                 [
//                        'label' => 'Jawatan Pentadbiran',
//                        'value' => 'adminpos.position_name',
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                    ],             
                              
                                [
                        'label' => 'Jawatan Pentadbiran',
                        'value' => 'adminpos.position_name',
                        'filter' => Select2::widget([
                            'name' => 'adminpos_id',
                            'value' => $adminpos_id,
                            'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->joinWith('adminpos')->where(['flag' => '1'])->orderBy(['position_type' => SORT_ASC, 'adminpos_id' => SORT_ASC])->all(), 'adminpos_id', 'adminpos.ref_position_name'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                                
                                [
                        'label' => 'Program Pengajaran',
                        'value' => 'program.NamaProgram',
                        'filter' => Select2::widget([
                            'name' => 'program_id',
                            'value' => $program_id,
                            'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->joinWith('program')->where(['flag' => '1'])->all(), 'program_id', 'program.NamaProgram'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],          
                                    
                                [
                                'label' => 'Catatan',
                                'value' => 'description',
                                    'vAlign' => 'middle',
                                'hAlign' => 'center',
                    ],  
                                
//                                [
//                        'label' => 'JFPIB',
//                        'value' => 'dept.fullname',
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                    ],
                                
                                [
                        'label' => 'JFPIB',
                        'value' => 'dept.fullname',
                            'filter' => Select2::widget([
                            'name' => 'dept_id',
                            'value' => $dept_id,
                            'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '1'])->all(), 'dept_id', 'dept.fullname'),
                                'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],                
                                
//                                [
//                        'label' => 'Kampus',
//                        'value' => 'campus.campus_name',
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                    ],
                                
                                [
                        'label' => 'Kampus',
                        'value' => 'campus.campus_name',
                            'filter' => Select2::widget([
                            'name' => 'campus_id',
                            'value' => $campus_id,
                            'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '1'])->all(), 'campus_id', 'campus.campus_name'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],           
                                
//                                [
//                        'label' => 'Tarikh Kuatkuasa',
//                        'attribute' => 'tarikhkuatkuasa',
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                    ],                                 
                                
                                [
                        'label' => 'Tarikh Tamat',
                        'attribute' => 'tarikhtamat',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],         
                                
//                               [
//                        'label' => 'Status',
//                        'attribute' => 'displayflag.flagstatus',
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                    ],
                            
                                [
                        'header' => 'Status',
                        'attribute' => 'displayflag.flagstatus',
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                            
                                [
                        'label' => 'Kiraan Hari',
                        'attribute' => 'baki',
                        'contentOptions' => ['style' => 'color: red;'],
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],      
//                                [
//                        'label'=>'Tindakan',
//                        'format' => 'raw',
//                        'value'=>function ($data){
//                                return Html::a('<i class="fa fa-eye">', ['lihat-rekod-lantikan', 'id' => $data->id]);
////                              return Html::a('<i class="fa fa-eye">', ['admin-view','id'=>$data->ICNO]) ;          
//                        },
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                          
//                    ],
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