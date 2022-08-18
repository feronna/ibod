<?php

$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modall').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\models\gaji\TblStaffRoc;

?>

<?php
Modal::begin([
    'header' => 'Kemasukan',
    'id' => 'modall',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
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
                        'header' => 'BATCH CODE',
                        'headerOptions' => ['class' => 'text-center'],
                        // 'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->srb_batch_code;
                        },
                    ],
                    [
                        //                                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'SEBAB PERGERAKAN',
                        'headerOptions' => ['class' => 'text-center'],
                        // 'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->reason->RR_REASON_DESC;
                        },
                    ],
                    [
                        'class' => 'kartik\grid\ExpandRowColumn',
                        'value' => function($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        // 'detail' => function($model, $key, $index, $column) {
                        //     $searchModel = new TblStaffRoc();
                        //     $searchModel->SR_ENTRY_BATCH = $model->srb_batch_code;
                        //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                            
                        //     return Yii::$app->controller->renderPartial('_elaun2', [
                        //         'searchModel' => $searchModel,
                        //         'dataProvider' => $dataProvider,
                        //     ]);
                        // },
                        'detailUrl' => 'elaun-details',
                        'headerOptions' => ['class' => 'text-center'], 
                        'contentOptions' => ['class' => 'text-center'],         
                        'expandOneOnly' => true
                    ],
                    [
                        //                                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'CATATAN',
                        'headerOptions' => ['class' => 'text-center'],
                        // 'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->srb_remarks;
                        },
                        'format' => 'html'
                    ],
                    [
                        //                                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'JFPIU',
                        'headerOptions' => ['class' => 'text-center col-md-2'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            // return ($model->processDept) ? $model->processDept->dm_dept_desc : null;
                            return $model->department->dm_dept_desc;
                        },
                        'format' => 'html'
                    ],
                    [
                        'header' => 'TARIKH KUATKUASA',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->srb_effective_date;
                        },
                    ],
                    [
                        'header' => 'TARIKH',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            // return ($model->elaunnn) ? $model->elaunnn->it_status: null;
                            return \Yii::$app->formatter->asDate($model->srb_enter_date, 'yyyy-MM-dd');
                        },
                    ],
                    [
                        'header' => 'STATUS',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->srb_status;
                        },
                    ],
                    // [
                    //     'header' => 'ELAUN/POTONGAN',
                    //     'headerOptions' => ['class' => 'text-center col-md-1'],
                    //     'contentOptions' => ['class' => 'text-center'],
                    //     'value' => function ($model) {
                    //         return ($model->elaunnn) ? $model->elaunnn->it_trans_type : null;
                    //     },
                    // ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'TINDAKAN',
                        'headerOptions' => ['class'=>'text-center col-md-1'],
                        'contentOptions' => ['class'=>'text-center'],
                        'template' => '{edit} ',
                        'buttons' => [
                            'edit' => function ($url, $model) {
                                $url = Url::to(['saraan/kumpulan', 'roc_batch' => $model->srb_batch_code]);      
                                return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                            },      
                        ],        
                    ],          
                ],
            ]);
        ?>
    </div>
</div>