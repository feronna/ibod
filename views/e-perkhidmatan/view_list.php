<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;

$this->title = Yii::t('app', 'Senarai Program');

//echo $this->render('/permohonan/_topmenu');
echo $this->render('/e-perkhidmatan/contact');
?>

<div class="rpt-tbl-permohonan-index">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel x_panel-success">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <div class="clearfix"></div>
                </div>

                <?php Pjax::begin(); ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'emptyText' => 'Tiada permohonan ditemui.',
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>-</b></i>'],
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => [
                        ['class' => 'kartik\grid\SerialColumn'],
                        // [
                        //     'class' => 'kartik\grid\ExpandRowColumn',
                        //     'width' => '50px',
                        //     'value' => function ($model, $key, $index, $column) {
                        //         return GridView::ROW_COLLAPSED;
                        //     },
                        //     // uncomment below and comment detail if you need to render via ajax
                        //     // 'detailUrl' => Url::to(['/site/book-details']),
                        //     // 'detail' => function ($model, $key, $index, $column) {
                        //     //     return Yii::$app->controller->renderPartial('view_penceramah', ['model' => $model]);
                        //     // },
                        //     'detailUrl' => 'permohonan-list',
                        //     'headerOptions' => ['class' => 'kartik-sheet-style'],
                        //     'expandOneOnly' => true
                        // ],
                        [
                            'label' => 'Nama Program',
                            'hAlign' => 'center',
                            'vAlign' => 'middle',
                            'value' => 'event_name'

                        ],
                        [
                            'label' => 'Tarikh Permohonan',
                            'hAlign' => 'center',
                            'vAlign' => 'middle',
                            'value' => 'tarikhPohon',
                        ],
                        [
                            'label' => 'Status Permohonan',
                            'hAlign' => 'center',
                            'vAlign' => 'middle',
                            'format' => 'raw',
                            'value' => 'statusPermohonan',
                            //'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
                            //'captionOptions' => ['tooltip' => 'Tooltip'],
                        ],
                        //'penerima_icno',
                        //'penerima_notes:ntext',
                        //'penerima_date',
                        //'reporter_icno',
                        //'report:ntext',
                        //'report_status',
                        //'report_date',
                        //'approver_icno',
                        //'approval_date',
                        [
                            'class' => 'kartik\grid\BooleanColumn',
                            'attribute' => 'countdown_status',
                            'label' => 'Countdown',
                            'vAlign' => 'middle'
                        ],
                        [
                            'class' => 'kartik\grid\BooleanColumn',
                            'attribute' => 'papan_tanda_status',
                            'label' => 'Papan Tanda',
                            'vAlign' => 'middle'
                        ],
                        [
                            'class' => 'kartik\grid\BooleanColumn',
                            'attribute' => 'parkir_status',
                            'label' => 'Parkir',
                            'vAlign' => 'middle'
                        ],
                        [
                            'class' => 'kartik\grid\BooleanColumn',
                            'attribute' => 'kawalan_status',
                            'label' => 'Kawalan Keselamatan',
                            'vAlign' => 'middle'
                        ],
                        [
                            'class' => 'kartik\grid\BooleanColumn',
                            'attribute' => 'banner_status',
                            'label' => 'Banner',
                            'vAlign' => 'middle'
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'header' => 'Tindakan',
                            'hAlign' => 'center',
                            'vAlign' => 'middle',
                            //'headerOptions' => ['style' => 'color:#337ab7'],
                            'template' => '{view} | {delete} ',
                            'buttons' => [

                                'view' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('app', 'Papar'),
                                        'target' => '_blank'
                                    ]);
                                },

                                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'Kemaskini'),
                                        'target' => '_blank'
                                    ]);
                                },

                                'delete' => function ($url, $model) {
                                    return Html::a(
                                        '<span class="glyphicon glyphicon-trash"></span>',
                                        $url,
                                        [
                                            'data' => [
                                                'confirm' => 'Adakah anda pasti anda ingin menghapuskan rekod permohonan ini?',
                                                'method' => 'post',
                                            ],
                                        ],
                                        ['title' => Yii::t('app', 'Hapus'),]
                                    );
                                },
                            ],
                            'visibleButtons' => [
                                'delete' => function ($model) {
                                    return $model->event_application_status == '1';
                                },
                                // 'view' => function ($model) {
                                //     return $model->zone_status == 'active';
                                // },
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'view') {
                                    $url = 'view?id=' . $model->event_id;
                                    return $url;
                                }

                                // if ($action === 'update') {
                                //     $url = 'update?id=' . $model->event_id;
                                //     return $url;
                                // }

                                if ($action === 'delete') {
                                    $url = 'delete?id=' . $model->event_id;
                                    return $url;
                                }
                            }
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>