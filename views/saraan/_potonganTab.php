<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
// use yii\bootstrap\Modal;

?>

<div class="row">
    <div class="table-responsive">
        <?=
            GridView::widget([
                //'tableOptions' => [
                //  'class' => 'table table-striped jambo_table',
                //],
                'emptyText' => 'Tiada Rekod',
                //                                'pager' => [
                //                                    'class' => \kop\y2sp\ScrollPager::className(),
                //                                    'container' => '.grid-view tbody',
                //                                    'triggerOffset' => 10,
                //                                    'item' => 'tr',
                //                                    'paginationSelector' => '.grid-view .pagination',
                //                                    'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
                //                                 ],
                'summary' => '',
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'BIL',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        //                                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'ELAUN',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return ($model->elaunnn) ? $model->elaunnn->it_account_name . ' (' . $model->elaunnn->it_income_code . ')' : null;
                        },
                    ],
                    [
                        //                                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'JUMLAH',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->SR_NEW_VALUE;
                        },
                        'format' => 'html'
                    ],
                    [
                        'header' => 'KOD PROJEK',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            // return ($model->elaunnn) ? $model->elaunnn->it_status: null;
                            return $model->SR_PROJECT_CODE;
                        },
                    ],
                    [
                        'header' => 'PUSAT KOS',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            // return ($model->elaunnn) ? $model->elaunnn->it_status: null;
                            return null;
                        },
                    ],
                    [
                        //                                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'JENIS KIRAAN',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->SR_CALC_TYPE;
                        },
                        'format' => 'html'
                    ],
                    [
                        'header' => 'DARI',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return \Yii::$app->formatter->asDate($model->SR_DATE_FROM, 'yyyy-MM-dd');
                        },
                    ],
                    [
                        'header' => 'SEHINGGA',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->SR_DATE_TO ? \Yii::$app->formatter->asDate($model->SR_DATE_TO, 'yyyy-MM-dd') : null;
                        },
                    ],
                    [
                        'header' => 'JENIS PERUBAHAN',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->SR_CALC_TYPE;
                        },
                    ],
                    [
                        'header' => 'CATATAN',
                        'headerOptions' => ['class' => 'text-center'],
                        // 'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->SR_REMARK;
                        },
                    ],
                    [
                        //                                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'STATUS',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->SR_STATUS;
                        },
                        'format' => 'html'
                    ],

                    //                                     [
                    //                                         'class' => 'yii\grid\ActionColumn',
                    //                                         'header' => 'TINDAKAN',
                    //                                         'headerOptions' => ['class'=>'text-center col-md-1'],
                    //                                         'contentOptions' => ['class'=>'text-center'],
                    //                                         'template' => '{view} {update} {delete}',
                    //                                         'buttons' => [
                    //                                             'view' => function ($url, $model) {
                    //                                                 $url = Url::to(['saraan/lpg-report-2', 'lpg_id' => $model->t_lpg_id]);
                    //                                                 return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, [
                    //                                                     'title' => 'lpg', 'target' => '_blank', 'class' => 'btn btn-default btn-sm',
                    //                                                 ]);
                    //                                             },
                    //                                             'update' => function ($url, $model) {
                    //                                                 $url1 = Url::to(['saraan/kemaskini-lpg', 'icno' => $model->t_lpg_ICNO, 'lpg_id' => $model->t_lpg_id]);
                    //                                                 return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url1, 'class' => 'btn btn-default btn-sm modalButton']);
                    //                                             },
                    //                                             'delete' => function ($url, $model) {
                    //                                                 $url2 = Url::to(['saraan/padam-lpg', 'lpg_id' => $model->t_lpg_id]);
                    //                                                 return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url2, [
                    //                                                     'class' => 'btn btn-default btn-sm',
                    //                                                     'data' => [
                    //                                                                 'confirm' => 'Adakah anda ingin membuang rekod ini?',
                    //                                                                 'method' => 'post',
                    //                                                             ],
                    //                                                     ]);
                    //                                                 //Html::button('<span class="glyphicon glyphicon-trash"></span>', ['value' => $url2, 'class' => 'btn btn-default btn-sm']);
                    //                                             },       
                    //                                         ],        
                    //                                     ],          
                ],
            ]);
        ?>
    </div>
</div>