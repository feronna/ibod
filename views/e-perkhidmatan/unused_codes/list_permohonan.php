<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
?>

<div class="rpt-tbl-permohonan-index">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel x_panel-success">
                <div class="x_title">
                    <h5>
                        <h3><span class="label label-primary" style="color: white">Senarai Permohonan Tambahan</span>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </h3>
                    </h5>
                </div>
                <div class="x_content">
                    <?php Pjax::begin(); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'emptyText' => 'Tiada permohonan ditemui.',
                        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>-</b></i>'],
                        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                        'columns' => [
                            ['class' => 'kartik\grid\SerialColumn'],
                            [
                                'label' => 'Jenis Permohonan',
                                'hAlign' => 'center',
                                'vAlign' => 'middle',
                                'format' => 'raw',
                                'value' => 'reference.ptype'

                            ],
                            [
                                'label' => 'Tarikh Permohonan',
                                'hAlign' => 'center',
                                'vAlign' => 'middle',
                                'value' => 'date_applied',
                            ],
                            [
                                'label' => 'Status Permohonan',
                                'hAlign' => 'center',
                                'vAlign' => 'middle',
                                'format' => 'raw',
                                'value' => 'appStatus',
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
                                'class' => 'kartik\grid\ActionColumn',
                                'header' => 'Tindakan',
                                'hAlign' => 'center',
                                'vAlign' => 'middle',
                                //'headerOptions' => ['style' => 'color:#337ab7'],
                                'template' => '{view} | {update} | {delete} ',
                                'buttons' => [

                                    'view' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                            'title' => Yii::t('app', 'Papar'),
                                        ]);
                                    },

                                    'update' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                            'title' => Yii::t('app', 'Kemaskini'),
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
                                        return $model->application_status == '1';
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

                                    if ($action === 'update') {
                                        $url = 'update?id=' . $model->event_id;
                                        return $url;
                                    }

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
</div>