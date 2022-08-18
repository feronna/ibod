<?php
/* @var $this yii\web\View */

use yii\bootstrap\Alert;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use igorvolnyi\widgets\modal\ModalAjaxMultiple;

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_content">
            <div class="row">
                <?= DetailView::widget([
                    'model' => $batch,
                    'attributes' => [
                        [
                            'label' => 'Kod',
                            'value' => $batch->srb_batch_code,
                            // 'contentOptions' => ['style'=>'width:auto'],
                            // 'captionOptions' => ['style'=>'width:26%'],  
                        ],
                        [
                            'label' => 'UMSPER',
                            'value' => $batch->srb_staff_id,
                        ],
                        [
                            'label' => 'Nama',
                            'value' => $batch->biodataSendiri->CONm,
                        ],
                        [
                            'label' => 'Sebab Perubahan',
                            'value' => $batch->reason->RR_REASON_DESC,
                        ],
                        [
                            'label' => 'Catatan',
                            'value' => $batch->srb_remarks,
                        ],
                        [
                            'label' => 'JFPIU Proses',
                            'value' => $batch->department->dm_dept_desc,
                        ],
                        [
                            'label' => 'Tarikh Kuatkuasa',
                            'value' => $batch->srb_effective_date,
                        ],
                        [
                            'label' => 'Status',
                            'value' => $batch->srb_status,
                        ],

                        // ['label' => 'Nama Role',
                        //   'value' => $role->role_name],
                        // ['label' => 'Nama Controller',
                        //   'value' =>  $role->controller_id],
                    ],
                ]) ?>
            </div>
            <hr>
            <div class="row">
                <?= 
                    ModalAjaxMultiple::widget([
                        'id' => 'createCompany',
                        'header' => 'Create Company',
                        'toggleButton' => [
                            'label' => 'New Company',
                            'class' => 'btn btn-primary btn-sm pull-right'
                        ],
                        'url' => Url::to(['saraan/create-elaun', 'batch_code' => $batch->srb_batch_code]), // Ajax view with form to load
                        'ajaxSubmit' => true, // Submit the contained form as ajax, true by default
                        // ... any other yii2 bootstrap modal option you need
                    ]);

                ?>
                <div class="clearfix"></div>
                <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'summary' => '',
                        'columns' => [
                            [
                                'attribute' => 'SR_REF_ID',
                                'label' => 'ID RUJUKAN',
                                'headerOptions' => ['class' => 'text-center col-md-4'],
                                // 'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                // 'attribute' => 'SR_ROC_TYPE',
                                'value' => function ($model) {
                                    return ($model->elaunnn) ? $model->elaunnn->it_account_name . ' (' . $model->elaunnn->it_income_code . ')' : null;
                                },
                                'label' => 'ELAUN/POTONGAN',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'format' => 'html',
                            ],
                            [
                                'attribute' => 'SR_OLD_VALUE',
                                'label' => 'JUMLAH SEBELUM',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'format' => 'html',
                            ],
                            [
                                'attribute' => 'SR_NEW_VALUE',
                                'label' => 'JUMLAH',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'format' => 'html',
                            ],
                            [
                                'attribute' => 'SR_CALC_TYPE',
                                'label' => 'JENIS KIRAAN',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'format' => 'html',
                            ],
                            [
                                //                                        'class' => 'yii\grid\SerialColumn',
                                'header' => 'KOD PROJEK',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return null;
                                },
                                'format' => 'html'
                            ],
                            [
                                //                                        'class' => 'yii\grid\SerialColumn',
                                'header' => 'PUSAT KOS',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return null;
                                },
                                'format' => 'html'
                            ],
                            [
                                //                                        'class' => 'yii\grid\SerialColumn',
                                'header' => 'DARI',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return \Yii::$app->formatter->asDate($model->SR_DATE_FROM, 'yyyy-MM-dd');
                                },
                                'format' => 'html'
                            ],
                            [
                                //                                        'class' => 'yii\grid\SerialColumn',
                                'header' => 'SEHINGGA',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return \Yii::$app->formatter->asDate($model->SR_DATE_TO, 'yyyy-MM-dd');
                                },
                                'format' => 'html'
                            ],
                            [
                                //                                        'class' => 'yii\grid\SerialColumn',
                                'header' => 'JENIS',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return ($model->elaunnn) ? $model->elaunnn->it_trans_type : null;
                                },
                                'format' => 'html'
                            ],
                            [
                                //                                        'class' => 'yii\grid\SerialColumn',
                                'header' => 'JENIS PERUBAHAN',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->SR_CHANGE_TYPE;
                                },
                                'format' => 'html'
                            ],
                            // [
                            //     'class' => 'yii\grid\ActionColumn',
                            //     'header' => 'TINDAKAN',
                            //     'headerOptions' => ['class'=>'text-center col-md-1'],
                            //     'contentOptions' => ['class'=>'text-center'],
                            //     'template' => '{edit} ',
                            //     'buttons' => [
                            //         'edit' => function ($url, $model) {
                            //             $url = Url::to(['saraan/kumpulan', 'roc_batch' => $model->srb_batch_code]);      
                            //             return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                            //         },      
                            //     ],        
                            // ], 
                        ],
                    ]);
                ?>

            </div>
            <hr>
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Diisi Oleh</label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <?= $batch->srb_staff_id ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Isi</label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <?= \Yii::$app->formatter->asDate($batch->srb_enter_date, 'yyyy-MM-dd HH:mm:ss.SSS') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>