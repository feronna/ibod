<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

error_reporting(0);

use yii\widgets\ActiveForm;
?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

<div class="col-md-12 col-sm-12 col-xs-12" align="left"> 

    <?= Html::a('<i class="fa fa-bullhorn" aria-hidden="true"></i> NOTIFIKASI STAF', ['notifistaf'], ['class' => 'btn btn-primary btn-md'])
    ?>


</div>
<?php ActiveForm::end(); ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <p align="right"> 
            <?= Html::a('Kembali', ['data/index'], ['class' => 'btn btn-primary btn-sm']) ?>
        </p>
        <div class="x_panel"> 
            <div class="x_content">  

                <div class="table-responsive">

                    <?php
                    $gridColumns = [
                        ['class' => 'yii\grid\SerialColumn',
                            'header' => 'BIL',
                            'headerOptions' => ['style' => 'width:1%', 'class' => 'text-center'],
//                           'headerOptions' => ['style' => 'width:5%'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            //'attribute' => 'CONm',
                            'label' => 'NO. KAD PENGENALAN',
//                            'headerOptions' => ['class'=>'text-center'],
                            'options' => ['style' => 'width:2%'],
                            'contentOptions' => ['class' => 'text-left'],
                            'value' => function($model) {
                        $ICNO = $model->ICNO;
                        return Html::a('<strong>' . strtoupper($model->ICNO) . '</strong>');
                    },
                            'format' => 'html',
                        ],
                        [
                            //'attribute' => 'CONm',
                            'label' => 'NAMA KAKITANGAN',
                            'headerOptions' => ['class' => 'column-title'],
                            'options' => ['style' => 'width:50%'],
                            'filter' => Select2::widget([
                                'name' => 'ICNO',
                                'value' => isset(Yii::$app->request->queryParams['ICNO']) ? Yii::$app->request->queryParams['ICNO'] : '',
                                'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]),
                            'value' => function($model) {
                        $ICNO = $model->ICNO;
//                                $id = $model->id;
                        return Html::a('<strong>' . $model->CONm . '</strong>') . ' <br><small><b>UMSPER (' . $model->COOldID . ')</b></small>' . '<br><small>' . $model->department->fullname . '</small>' .
                                '<br><small>' . $model->jawatan->nama . ' ' . $model->jawatan->gred;
                    },
                            'format' => 'html',
                        ],
                        [
                            'label' => 'PERINCIAN',
                            'value' => function($model) {
                                return Html::a('<i class="fa fa-graduation-cap" aria-hidden="true"></i>', [
                                            'pendidikan/adminview',
                                            'icno' => $model->ICNO,
//                                        'title' => 'personal',
                                                ], [
                                            'class' => 'btn btn-default',
                                            'target' => '_blank',
                                ]);
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
//                                     [
//                'class' => 'yii\grid\CheckboxColumn',
//                'options' => ['style' => 'width:1%'],
//
//                'checkboxOptions' => function ($data) { 
//                if(($data->status=='1')){
//                return ['disabled' => 'disabled'];
//                }
//                return ['value' => $data->id, 'checked'=> true];
//                },
//            ],
                            ];




                            echo GridView::widget([
                                'pager' => [
                                    'firstPageLabel' => 'First',
                                    'lastPageLabel' => 'Last'
                                ],
                                'filterModel' => true,
                                'dataProvider' => $urus,
                                'columns' => $gridColumns,
                                'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                                'beforeHeader' => [
                                    [
                                        'columns' => [],
                                        'options' => ['class' => 'skip-export'] // remove this row from export
                                    ]
                                ],
                                'toolbar' => [
                                    ['content' => '']
                                ],
                                'bordered' => true,
                                'striped' => false,
                                'condensed' => false,
                                'responsive' => true,
                                'hover' => true,
                                'panel' => [
                                    'type' => GridView::TYPE_DEFAULT,
                                    'heading' => '<h5><i class= "fa fa-graduation-cap"></i> SENARAI KAKITANGAN TIADA PENDIDIKAN</h5>',
                                ],
                            ]);
                            ?>
                </div>



            </div>
        </div>  

    </div>  
</div>


