<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="table-responsive">
    <?=
    \kartik\grid\GridView::widget([
        'rowOptions' => ['style' => 'vertical-align:middle'],
        'id' => 'data_kategori1',
        'emptyText' => 'Tiada Rekod',
        'striped' => false,
        'summary' => '',
        'dataProvider' => $dataProvider2,
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'id' => 'pjax_kategori1',
            ],
        ],
        'showFooter' => false,
        'toolbar' => [
            [
                'content' => Html::button('Tambah Data', [
                    'value' => Url::to(['elnpt3/create-pnp', 'lppid' => $lpp->lpp_id]),
                    // 'type' => 'button',
                    'title' => 'Tambah Data',
                    'class' => 'btn-primary btn-sm modalButtonn'
                ]),
            ],
        ],
        'panel' => [
            // 'after' =>  '<div class="float-right float-end pull-right">' . Html::submitButton('Calculate', ['class' => 'btn btn-primary']) . '</div><div class="clearfix"></div>',
            // 'heading' => '<i class="fas fa-book"></i>  Library',
            'type' => 'primary',
            // 'before' => '<div style="padding-top: 7px;"><em>* Markah yang dipaparkan adalah tertakluk kepada perubahan selepas proses verifikasi oleh PPP dan penilaian kualiti peribadi oleh PPP, PPK dan PEER.</em></div>',
        ],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'BIL',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'header' => 'KOD KURSUS',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return $model['kod_kursus'];
                }, // configure even group cell css class
            ],
            [
                'header' => 'NAMA KURSUS',
                'headerOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return $model['nama_kursus'];
                }, // configure even group cell css class
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'SEKSYEN',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'seksyen',
                'editableOptions' => function ($model, $key, $index) use ($lpp) {
                    return [
                        'header' => 'Seksyen',
                        'name' => 'seksyen',
                        'inputType' => kartik\editable\Editable::INPUT_TEXT,
                        'placement'     => kartik\popover\PopoverX::ALIGN_RIGHT_TOP,
                        'buttonsTemplate' => '{submit}',
                        'value' => $model['seksyen'],
                        // 'displayValue' => $index,
                        'options' => [ // your widget settings here
                            'class' => 'form-control',
                            // 'id' => $index . '-syarahan',
                            // 'data' => $semester,
                            // 'pluginOptions' => [
                            //     'dropdownParent' => '#' . $index . '-syarahan-popover',
                            // ],

                        ],
                        'formOptions' => [
                            'action' => ['elnpt3/update-pengajaran?lppid=' . $lpp->lpp_id],
                        ],
                        'type' => 'primary',
                    ];
                },
                'readonly' => function ($model, $key, $index, $widget) {
                    return ((strlen($model['ver_by']) == 0 && !is_null($model['ver_by'])) || ($model['ver_by'] == 'SMP UMS'))  ? true : false;
                }
            ],
            // [
            //     'header' => 'BIL PELAJAR',
            //     'headerOptions' => ['class' => 'text-center col-md-1'],
            //     'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
            //     'value' => function ($model) {
            //         return $model['bil_pelajar'];
            //     }, // configure even group cell css class
            // ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'BIL PELAJAR',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'bil_pelajar',
                'editableOptions' => function ($model, $key, $index) use ($lpp) {
                    return [
                        'header' => 'Bil Pelajar',
                        'name' => 'bil_pelajar',
                        'inputType' => kartik\editable\Editable::INPUT_TEXT,
                        'placement'     => kartik\popover\PopoverX::ALIGN_RIGHT_TOP,
                        'buttonsTemplate' => '{submit}',
                        'value' => $model['bil_pelajar'],
                        // 'displayValue' => $index,
                        'options' => [ // your widget settings here
                            'class' => 'form-control',
                            // 'id' => $index . '-syarahan',
                            // 'data' => $semester,
                            // 'pluginOptions' => [
                            //     'dropdownParent' => '#' . $index . '-syarahan-popover',
                            // ],

                        ],
                        'formOptions' => [
                            'action' => ['elnpt3/update-pengajaran?lppid=' . $lpp->lpp_id],
                        ],
                        'pluginEvents' => [
                            "editableSuccess" => "function(event, val, form, data) {
                                $.pjax.reload({
                                    container: '#pjax_kategori1_result',
                                url: 'pjax-result-k1?lppid=" . $lpp->lpp_id . "',
                                });
                            }",
                        ],
                        'type' => 'primary',
                    ];
                },
                'readonly' => function ($model, $key, $index, $widget) {
                    return ((strlen($model['ver_by']) == 0 && !is_null($model['ver_by'])) || ($model['ver_by'] == 'SMP UMS'))  ? true : false;
                }
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'SEMESTER',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'semester',
                'editableOptions' => function ($model, $key, $index) use ($lpp, $semester) {
                    return [
                        'header' => 'Semester',
                        'name' => 'semester',
                        'inputType' => kartik\editable\Editable::INPUT_SELECT2,
                        'placement'     => kartik\popover\PopoverX::ALIGN_RIGHT_TOP,
                        'buttonsTemplate' => '{submit}',
                        'value' => $model['semester'],
                        // 'displayValue' => $index,
                        'options' => [ // your widget settings here
                            'class' => 'form-control',
                            'id' => $index . '-sem',
                            'data' => $semester,
                            'pluginOptions' => [
                                'dropdownParent' => '#' . $index . '-sem-popover',
                            ],

                        ],
                        'formOptions' => [
                            'action' => ['elnpt3/update-pengajaran?lppid=' . $lpp->lpp_id],
                        ],
                        'type' => 'primary',
                    ];
                },
                // 'pageSummary' => true
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'JAM SYARAHAN',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'jam_syarahan',
                'editableOptions' => function ($model, $key, $index) use ($lpp, $semester) {
                    return [
                        'header' => 'Jam Syarahan',
                        'name' => 'jam_syarahan',
                        'inputType' => kartik\editable\Editable::INPUT_TEXT,
                        'placement'     => kartik\popover\PopoverX::ALIGN_RIGHT_TOP,
                        'buttonsTemplate' => '{submit}',
                        'value' => $model['jam_syarahan'],
                        // 'displayValue' => $index,
                        'options' => [ // your widget settings here
                            'class' => 'form-control',
                            // 'id' => $index . '-syarahan',
                            // 'data' => $semester,
                            // 'pluginOptions' => [
                            //     'dropdownParent' => '#' . $index . '-syarahan-popover',
                            // ],

                        ],
                        'formOptions' => [
                            'action' => ['elnpt3/update-pengajaran?lppid=' . $lpp->lpp_id],
                        ],
                        'pluginEvents' => [
                            "editableSuccess" => "function(event, val, form, data) {
                                $.pjax.reload({
                                    container: '#pjax_kategori1_result',
                                url: 'pjax-result-k1?lppid=" . $lpp->lpp_id . "',
                                });
                            }",
                        ],
                        'type' => 'primary',
                        'beforeInput' => '<label>Jam F2F untuk 14 minggu</label>',
                    ];
                },
                // 'pageSummary' => true
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'JAM TUTORIAL',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'jam_tutorial',
                'editableOptions' => function ($model, $key, $index) use ($lpp, $semester) {
                    return [
                        'header' => 'Jam Tutorial',
                        'name' => 'jam_tutorial',
                        'inputType' => kartik\editable\Editable::INPUT_TEXT,
                        'placement'     => kartik\popover\PopoverX::ALIGN_RIGHT_TOP,
                        'buttonsTemplate' => '{submit}',
                        'value' => $model['jam_tutorial'],
                        // 'displayValue' => $index,
                        'options' => [ // your widget settings here
                            'class' => 'form-control',
                            // 'id' => $index . '-syarahan',
                            // 'data' => $semester,
                            // 'pluginOptions' => [
                            //     'dropdownParent' => '#' . $index . '-syarahan-popover',
                            // ],

                        ],
                        'formOptions' => [
                            'action' => ['elnpt3/update-pengajaran?lppid=' . $lpp->lpp_id],
                        ],
                        'pluginEvents' => [
                            "editableSuccess" => "function(event, val, form, data) {
                                $.pjax.reload({
                                    container: '#pjax_kategori1_result',
                                url: 'pjax-result-k1?lppid=" . $lpp->lpp_id . "',
                                });
                            }",
                        ],
                        'type' => 'primary',
                        'beforeInput' => '<label>Jam F2F untuk 14 minggu</label>',
                    ];
                },
                // 'pageSummary' => true
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'JAM AMALI',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'jam_amali',
                'editableOptions' => function ($model, $key, $index) use ($lpp, $semester) {
                    return [
                        'header' => 'Jam Amali',
                        'name' => 'jam_amali',
                        'inputType' => kartik\editable\Editable::INPUT_TEXT,
                        'placement'     => kartik\popover\PopoverX::ALIGN_RIGHT_TOP,
                        'buttonsTemplate' => '{submit}',
                        'value' => $model['jam_amali'],
                        // 'displayValue' => $index,
                        'options' => [ // your widget settings here
                            'class' => 'form-control',
                            // 'id' => $index . '-syarahan',
                            // 'data' => $semester,
                            // 'pluginOptions' => [
                            //     'dropdownParent' => '#' . $index . '-syarahan-popover',
                            // ],

                        ],
                        'formOptions' => [
                            'action' => ['elnpt3/update-pengajaran?lppid=' . $lpp->lpp_id],
                        ],
                        'pluginEvents' => [
                            "editableSuccess" => "function(event, val, form, data) {
                                $.pjax.reload({
                                    container: '#pjax_kategori1_result',
                                url: 'pjax-result-k1?lppid=" . $lpp->lpp_id . "',
                                });
                            }",
                        ],
                        'type' => 'primary',
                        'beforeInput' => '<label>Jam F2F untuk 14 minggu</label>',
                    ];
                },
                // 'pageSummary' => true
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'STATUS FAIL',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'status_fail',
                'editableOptions' => function ($model, $key, $index) use ($lpp) {
                    return [
                        'header' => 'Status Fail',
                        'name' => 'status_fail',
                        'inputType' => kartik\editable\Editable::INPUT_SELECT2,
                        'placement'     => kartik\popover\PopoverX::ALIGN_RIGHT_TOP,
                        'buttonsTemplate' => '{submit}',
                        'value' => $model['status_fail'],
                        'displayValueConfig' => [0 => 'Tiada'],
                        'options' => [ // your widget settings here
                            'class' => 'form-control',
                            'id' => $index . '-fail',
                            'data' => [
                                'Tiada' => 'Tiada',
                                'Ada - Lengkap' => 'Ada - Lengkap',
                                'Ada - Tidak Lengkap' => 'Ada - Tidak Lengkap',
                            ],
                            'pluginOptions' => [
                                'dropdownParent' => '#' . $index . '-fail-popover',
                            ],

                        ],
                        'formOptions' => [
                            'action' => ['elnpt3/update-pengajaran?lppid=' . $lpp->lpp_id],
                        ],
                        'pluginEvents' => [
                            "editableSuccess" => "function(event, val, form, data) {
                                $.pjax.reload({
                                    container: '#pjax_kategori1_result',
                                url: 'pjax-result-k1?lppid=" . $lpp->lpp_id . "',
                                });
                            }",
                        ],
                        'type' => 'primary',
                    ];
                },
                // 'pageSummary' => true
            ],
            [
                'header' => 'SMARTv3',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return ($model['status'] == 'Pass') ? '<span class="label label-success">Pass</span>' :
                        '<span class="label label-danger">Fail</span>';
                }, // configure even group cell css class
                'format' => 'html'
            ],
            [
                'header' => 'PK07',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return Yii::$app->formatter->asDecimal($model['pk07'], 2);
                }, // configure even group cell css class
                'format' => 'html'
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'PBL/FLIPPED CLASSROOM',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'hasTech',
                'editableOptions' => function ($model, $key, $index) use ($lpp) {
                    return [
                        'header' => 'PBL, Flipped classroom',
                        'name' => 'hasTech',
                        'inputType' => kartik\editable\Editable::INPUT_CHECKBOX,
                        'placement'     => kartik\popover\PopoverX::ALIGN_LEFT_TOP,
                        'buttonsTemplate' => '{submit}',
                        'formOptions' => [
                            'action' => ['elnpt3/update-pengajaran?lppid=' . $lpp->lpp_id],
                        ],
                        'pluginEvents' => [
                            "editableSuccess" => "function(event, val, form, data) {
                                $.pjax.reload({
                                    container: '#pjax_kategori1_result',
                                url: 'pjax-result-k1?lppid=" . $lpp->lpp_id . "',
                                });
                            }",
                        ],
                        'displayValueConfig' => [0 => 'No', 1 => 'Yes'],
                        'options' => [
                            'id' => $index . '-skop',
                            'class' => 'form-check-input',
                            'checked' => ($model['hasTech'] == 'Yes') ? true : false,
                        ],
                        'type' => 'primary',
                        'beforeInput' => '<label>Uses PBL, Flipped classroom etc?</label>',
                    ];
                },
            ],
            // [
            //     'class' => 'kartik\grid\EditableColumn',
            //     'header' => 'DOKUMEN SOKONGAN',
            //     'headerOptions' => ['class' => 'text-center col-md-1'],
            //     'contentOptions' => ['class' => 'text-center'],
            //     'attribute' => 'ver_by',
            //     'editableOptions' => function ($model, $key, $index) use ($lpp) {
            //         return [
            //             'header' => 'Dokumen Sokongan',
            //             'preHeader' => '<i class="glyphicon glyphicon-edit"></i> Sah ',
            //             'name' => 'ver_by',
            //             'inputType' => kartik\editable\Editable::INPUT_CHECKBOX,
            //             'placement'     => kartik\popover\PopoverX::ALIGN_LEFT_TOP,
            //             'buttonsTemplate' => '{submit}',
            //             'formOptions' => [
            //                 'action' => ['elnpt3/verify-document?lppid=' . $lpp->lpp_id . '&filehash=' . $model['file_hash']],
            //             ],
            //             'displayValue' => (strlen($model['ver_by']) != 0 && !is_null($model['ver_by'])) ? 'Verified' : 'Not Verified',
            //             'displayValueConfig' => [0 => 'Not Verified', 1 => 'Verified'],
            //             'options' => [
            //                 'id' => $index . '-ver',
            //                 'class' => 'form-check-input',
            //                 'checked' => (strlen($model['ver_by']) != 0 && !is_null($model['ver_by'])) ? true : false,
            //             ],
            //             'type' => 'primary',
            //             'size' => 'md',
            //             'beforeInput' => '<label>Verify/Unverify</label>',
            //         ];
            //     },
            //     'readonly' => function ($model, $key, $index, $widget) {
            //         return ((strlen($model['ver_by']) == 0 && !is_null($model['ver_by'])) || ($model['ver_by'] == 'SMP UMS'))  ? true : false;
            //     }
            // ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'DOKUMEN SOKONGAN',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'template' => '{view}',
                'visible' => false,
                'buttons' => [
                    'view' => function ($url, $model, $key) use ($lpp) {
                        return Html::a(
                            "<i class='fa fa-file' aria-hidden='true'></i>",
                            Url::to(['elnpt3/view-file', 'hashfile' => $model['file_hash'], 'lppid' => $lpp->lpp_id]),
                            ['data-pjax' => 0, 'target' => '_blank', 'class' => 'btn btn-xs btn-default']
                        ) .
                            '<sub><b>' . ((strlen($model['ver_by']) != 0 && !is_null($model['ver_by'])) ? '<span class="label label-success">Verified</span>' : '<span class="label label-default">Unverified</span>') . '</b></sub>';
                        // return $model->id;
                    },
                ],
                'visibleButtons' => [
                    'view' => function ($model, $key, $index) use ($lpp) {
                        return ($model['ver_by'] == 'SMP UMS')  ? false : true;
                    }
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'TINDAKAN',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'template' => '{delete}',
                'visible' => false,
                'buttons' => [
                    'delete' => function ($url, $model, $key) use ($lpp) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', false, [
                            'class' => 'btn btn-default btn-sm pjax-delete-pnp',
                            'delete-url' =>  Url::to(['elnpt3/delete-pnp', 'id' => $key, 'lppid' =>  $lpp->lpp_id]),
                            // 'data' => [
                            //     'confirm' => 'Are you sure you want to delete this item?',
                            //     'method' => 'post',
                            // ],
                        ]);
                    },
                ],
                'visibleButtons' => [
                    'delete' => function ($model, $key, $index) use ($lpp) {
                        return ($model['ver_by'] == 'SMP UMS')  ? false : true;
                    }
                ]
            ],
        ]
    ]);
    ?>
</div>