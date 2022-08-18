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
//                           'value' => function ($batch) {
//                            return $batch->elaunPakaian->kemudahan;
//                            },
                            'label' => 'Kod',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-left'],
                            'format' => 'html',
                            'value' => $batch->elaunPakaian->kemudahan,
                        ],
                        [
                            'label' => 'UMSPER',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-left'],
                            'value' => $batch->kakitangan->COOldID,
                        ],
                        [
                            'label' => 'Nama',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-left'],
                            'value' => $batch->kakitangan->CONm,
                        ],
                        [
                            'label' => 'Sebab Perubahan',
                            'value' => $batch->elaunPakaian->kemudahan,
                        ],
                        [
                            'label' => 'Catatan', 
                            'value' => $batch-> payDetails->approver_remark,

                        ],
                        [
                            'label' => 'JFPIU Proses',
                            'value' => $batch->kakitangan->department->fullname,
                        ],
                        [
                            'label' => 'Tarikh Kuatkuasa',
                            'value' => $batch->datefrom,
                        ],
                        [
                            'label' => 'Status',
                            'format' => 'raw',
                            'value' => $batch->payDetails->statuskj,
                        ],
 
                    ],
                ]) ?>

            </div>
            <hr>
            <div class="row">
                 <?php
//                    ModalAjaxMultiple::widget([
//                        'id' => 'createCompany',
//                        'header' => 'Create Company',
//                        'toggleButton' => [
//                            'label' => 'New Company',
//                            'class' => 'btn btn-primary btn-sm pull-right'
//                        ],
//                        'url' => Url::to(['borang/create-elaun', 'id' => $batch->PAY_PARENT_ID]), // Ajax view with form to load
//                        'ajaxSubmit' => true, // Submit the contained form as ajax, true by default
//                        // ... any other yii2 bootstrap modal option you need
//                    ]);

                ?>

                <div class="clearfix"></div>
                <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider, 
                            'summary' => '',
                            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                            'columns' => [
                                [
                                'header' => 'ID RUJUKAN',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => '',
                            ],
                                [
                                    // 'attribute' => 'SR_ROC_TYPE',
                                    'value' => function ($model) {
                                    return $model-> elaunPakaian->kemudahan;
                                    },
                                    'label' => 'ELAUN/POTONGAN',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'format' => 'html',
//                                    'value' => '',
                                ],
                               
                                 [
                                'header' => 'JUMLAH SEBELUM',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => '',
                            ],
                                [
                                     
                                    'label' => 'JUMLAH',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'format' => 'html',
                                     'value' => function ($model) { 
                                    return $model->PAY_NEW_VALUE;

                                }, 
                                ],
                                [
                                    
                                    'label' => 'JENIS KIRAAN',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'format' => 'html',
//                                     'value' => function ($model) { 
//                                    return $model->payDetails->jenis_kiraan;
//
//                                }, 
                                    'value' => '',
                                ],
                                [
                                    //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'KOD PROJEK',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => '',
                                    'format' => 'html'
                                ],
                                [
                                    //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'PUSAT KOS',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => '',
                                    'format' => 'html'
                                ],
                                [
                                    //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'DARI',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'], 
                                    'format' => 'html', 
                                    'value' => function ($model) {
                                     return \Yii::$app->formatter->asDate($model->PAY_DATE_FROM, 'yyyy-MM-dd');
                                },

                                ],
                                [
                                    //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'SEHINGGA',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'], 
                                    'format' => 'html',
                                    'value' => function ($model) {
                                     return \Yii::$app->formatter->asDate($model->PAY_DATE_TO, 'yyyy-MM-dd');
                                },
                                ],
                                [
                                    //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'JENIS',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => '',
                                ],
                                [
                                    //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'JENIS PERUBAHAN',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => '',
                                ],
                            ],
                        ]);
                    ?>

            </div>
            <hr>
             
        </div>
    </div>
</div>
