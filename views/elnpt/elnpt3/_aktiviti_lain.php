<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="table-responsive">
    <?=
    \kartik\grid\GridView::widget([
        'id' => 'aktiviti_lain',
        'emptyText' => 'Tiada Rekod',
        'striped' => false,
        'summary' => '',
        'dataProvider' => $dataProvider,
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'id' => 'pjax_aktiviti_lain',
            ],
        ],
        'showFooter' => false,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'BIL',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'label' => 'AKTIVITI',
                'headerOptions' => ['class' => 'column-title text-center'],
                // 'contentOptions' => ['style' => 'vertical-align:middle'],
                'value' => function ($model, $key, $index) {
                    return $model->title;
                },
                'format' => 'raw',
            ],
            [
                'label' => 'JENIS',
                'headerOptions' => ['class' => 'column-title text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model, $key, $index) {
                    return $model->jenis;
                },
                'format' => 'raw',
                'visible' => $model->kategori == 1,
            ],
            [
                'label' => 'PERANAN',
                'headerOptions' => ['class' => 'column-title text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model, $key, $index) {
                    return $model->peranan;
                },
                'format' => 'raw',
                'visible' => $model->kategori != 1,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'DOKUMEN SOKONGAN',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) use ($lppid) {
                        return Html::a(
                            "<i class='fa fa-file' aria-hidden='true'></i>",
                            Url::to(['elnpt3/view-file', 'hashfile' => $model->filehash, 'lppid' => $lppid]),
                            ['data-pjax' => 0, 'target' => '_blank', 'class' => 'btn btn-xs btn-default']
                        ) .
                            '<sub><b>' . ((strlen($model['verified_by']) != 0 && !is_null($model['verified_by'])) ? '<span class="label label-success">Verified</span>' : '<span class="label label-default">Unverified</span>') . '</b></sub>';
                        // return $model->id;
                    },
                ],
                // 'visibleButtons' => [
                //     'view' => function ($model, $key, $index) use ($lpp) {
                //         return ($model['ver_by'] == 'SMP UMS')  ? false : true;
                //     }
                // ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'TINDAKAN',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) use ($lppid) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', false, [
                            'class' => 'btn btn-default btn-sm pjax-delete-aktiviti',
                            'delete-url' =>  Url::to(['elnpt3/padam-aktiviti-lain', 'id' => $model->id, 'lppid' =>  $lppid]),
                            // 'data' => [
                            //     'confirm' => 'Are you sure you want to delete this item?',
                            //     'method' => 'post',
                            // ],
                        ]);
                    },
                ],
            ],
        ],
    ]);
    ?>
</div>