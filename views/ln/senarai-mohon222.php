<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
error_reporting(0); 
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Papar Lantikan Belum Disahkan</strong></h2>
<!--                <p align="right"><= \yii\helpers\Html::a('Kembali', ['halaman-utama-keseluruhan'], ['class' => 'btn btn-primary']) ?></p>   -->
                <div class="clearfix"></div>
            </div>
            <?= Html::a('<div style="float: right; font-size:18px;"><i class="text-success fa fa-download"></i> Muat Turun</div>', ['reportlantikansah', 'icno' => Yii::$app->request->queryParams['icno'], 'admin' => Yii::$app->request->queryParams['adminpos_id'], 'program' => Yii::$app->request->queryParams['program_id'], 'dept' => Yii::$app->request->queryParams['dept_id'], 'campus' => Yii::$app->request->queryParams['campus_id']]) ?>
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
                            
                                [
                        'format' => 'raw',
                        'label' => 'Nama Penyandang',
                        'value' => function($data){
                        return Html::a($data->kakitangan->CONm, ["lihat-rekod-lantikan", 'id' => $data->id], ['target' => '_blank']);
                        },
                        'filter' => Select2::widget([
                        'name' => 'icno',
                        'value' => $icno,
                        'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '0'])->all(), 'ICNO', 'kakitangan.CONm'),
                        //'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],                                             
                                
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
                                
                                [
                        'label' => 'Kampus',
                        'value' => 'campus.campus_name',
                            'filter' => Select2::widget([
                            'name' => 'campus_id',
                            'value' => $campus_id,
                            'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '1'])->orderBy(['campus_id' => SORT_ASC])->all(), 'campus_id', 'campus.campus_name'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],          
                                
                               [
                        'label' => 'Tarikh Kuatkuasa',
                        'attribute' => 'tarikhmula',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],            
                                
                               [
                        'label' => 'Tarikh Tamat',
                        'attribute' => 'tarikhtamat',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],           
                                        
                               [
                        'label' => 'Status',
                        'attribute' => 'displayflag.flagstatus',
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                              
                                [
                        'label' => 'Tindakan',
                        'value' => function($model) {
                            return 
                            Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', [
                                        'kemaskini-rekod-lantikan?id='.$model->id,                
                                            ], [
                                        'class' => 'btn btn-default',
                                        'target' => '_blank',
                                        'vAlign' => 'middle',
                                        'hAlign' => 'center',
                                    ]).
                            Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['kemaskini-rekod-sah', 'id' => $model->id]), 'class' => 'btn btn-default fa fa-check mapBtn']).Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', [
                                        'delete-data?id='.$model->id,                
                                            ], [
                                        'class' => 'btn btn-default',
                                        'data' => ['confirm' => 'Anda ingin membuang rekod ini?', ],
                                        'vAlign' => 'middle',
                                        'hAlign' => 'center',
                                    ]);
                        },
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 10%;'],
                    ],

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