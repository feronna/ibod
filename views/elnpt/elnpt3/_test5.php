<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="table-responsive">
    <?=
    \kartik\grid\GridView::widget([
        'rowOptions' => ['style' => 'vertical-align:middle'],
        'id' => 'data_kategori5',
        'emptyText' => 'Tiada Rekod',
        'striped' => false,
        'summary' => '',
        'dataProvider' => $dataProvider2,
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'id' => 'pjax_kategori5',
            ],
        ],
        'showFooter' => false,
        'toolbar' => [
            [
                'content' => Html::button('Tambah Data', [
                    'value' => Url::to(['elnpt3/create-urus-tadbir', 'lppid' => $lpp->lpp_id]),
                    // 'type' => 'button',
                    'title' => 'Tambah Data',
                    'class' => 'btn-primary btn-sm modalButtonnn'
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
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'KATEGORI JAWATANKUASA',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'Bilangan_jawatankuasa',
                'editableOptions' => function ($model, $key, $index) use ($lpp, $semester) {
                    return [
                        'header' => 'Kategori JawatanKuasa',
                        'name' => 'Bilangan_jawatankuasa',
                        'inputType' => kartik\editable\Editable::INPUT_SELECT2,
                        'placement'     => kartik\popover\PopoverX::ALIGN_RIGHT_TOP,
                        'buttonsTemplate' => '{submit}',
                        'value' => $model['Bilangan_jawatankuasa'],
                        // 'displayValue' => $index,
                        'options' => [ // your widget settings here
                            'class' => 'form-control',
                            'id' => $index . '-bil',
                            'data' => [
                                'Pentadbiran (Lantikan NC & ke atas)' => 'Pentadbiran (Lantikan NC & ke atas)',
                                'Pentadbiran (Lantikan Dekan/Pengarah/Timbalan Dekan/ Timbalan Pengarah)' => 'Pentadbiran (Lantikan Dekan/Pengarah/Timbalan Dekan/ Timbalan Pengarah)',
                                'Pentadbiran (Lantikan Ketua Program/ Penyelaras Gugusan)' => 'Pentadbiran (Lantikan Ketua Program/ Penyelaras Gugusan)',
                                'Pentadbiran (Ketua Jabatan/ Ketua Unit)' => 'Pentadbiran (Ketua Jabatan/ Ketua Unit)',
                                'Pentadbiran (Lantikan lain-lain)' => 'Pentadbiran (Lantikan lain-lain)',
                            ],
                            'pluginOptions' => [
                                'dropdownParent' => '#' . $index . '-bil-popover',
                            ],

                        ],
                        'formOptions' => [
                            'action' => ['elnpt3/update-urus-tadbir?lppid=' . $lpp->lpp_id],
                        ],
                        'type' => 'primary',
                    ];
                },
                'readonly' => function ($model, $key, $index, $widget) {
                    return ((strlen($model['ver_by']) == 0 && !is_null($model['ver_by'])) || ($model['ver_by'] == 'SMP UMS'))  ? true : false;
                }
                // 'pageSummary' => true
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'NAMA JAWATANKUASA',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'nama_jawatan',
                'editableOptions' => function ($model, $key, $index) use ($lpp, $semester) {
                    return [
                        'header' => 'Nama Jawatan',
                        'name' => 'nama_jawatan',
                        'inputType' => kartik\editable\Editable::INPUT_TEXT,
                        'placement'     => kartik\popover\PopoverX::ALIGN_RIGHT_TOP,
                        'buttonsTemplate' => '{submit}',
                        'value' => $model['nama_jawatan'],
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
                            'action' => ['elnpt3/update-urus-tadbir?lppid=' . $lpp->lpp_id],
                        ],
                        'type' => 'primary',
                        // 'beforeInput' => '<label>Jam F2F untuk 14 minggu</label>',
                    ];
                },
                'readonly' => function ($model, $key, $index, $widget) {
                    return ((strlen($model['ver_by']) == 0 && !is_null($model['ver_by'])) || ($model['ver_by'] == 'SMP UMS'))  ? true : false;
                }
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'PERANAN',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'Peranan_jawatankuasa',
                'editableOptions' => function ($model, $key, $index) use ($lpp, $semester) {
                    return [
                        'header' => 'Peranan JawatanKuasa',
                        'name' => 'Peranan_jawatankuasa',
                        'inputType' => kartik\editable\Editable::INPUT_SELECT2,
                        'placement'     => kartik\popover\PopoverX::ALIGN_RIGHT_TOP,
                        'buttonsTemplate' => '{submit}',
                        'value' => $model['Peranan_jawatankuasa'],
                        // 'displayValue' => $index,
                        'options' => [ // your widget settings here
                            'class' => 'form-control',
                            'id' => $index . '-peranan',
                            'data' => \yii\helpers\ArrayHelper::map(\app\models\elnpt\elnpt2\RefAspekSkor::find()->where(['bahagian' => 7, 'aspek_id' => 23])->all(), 'desc', 'desc'),
                            'pluginOptions' => [
                                'dropdownParent' => '#' . $index . '-peranan-popover',
                            ],

                        ],
                        'formOptions' => [
                            'action' => ['elnpt3/update-urus-tadbir?lppid=' . $lpp->lpp_id],
                        ],
                        'type' => 'primary',
                    ];
                },
                'readonly' => function ($model, $key, $index, $widget) {
                    return ((strlen($model['ver_by']) == 0 && !is_null($model['ver_by'])) || ($model['ver_by'] == 'SMP UMS'))  ? true : false;
                }
                // 'pageSummary' => true
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'TAHAP LANTIKAN',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'Tahap_jawatankuasa',
                'editableOptions' => function ($model, $key, $index) use ($lpp, $semester) {
                    return [
                        'header' => 'Tahap JawatanKuasa',
                        'name' => 'Tahap_jawatankuasa',
                        'inputType' => kartik\editable\Editable::INPUT_SELECT2,
                        'placement'     => kartik\popover\PopoverX::ALIGN_RIGHT_TOP,
                        'buttonsTemplate' => '{submit}',
                        'value' => $model['Tahap_jawatankuasa'],
                        // 'displayValue' => $index,
                        'options' => [ // your widget settings here
                            'class' => 'form-control',
                            'id' => $index . '-tahap',
                            'data' => \yii\helpers\ArrayHelper::map(\app\models\elnpt\elnpt2\RefAspekSkor::find()->where(['bahagian' => 7, 'aspek_id' => 24])->all(), 'desc', 'desc'),
                            'pluginOptions' => [
                                'dropdownParent' => '#' . $index . '-tahap-popover',
                            ],

                        ],
                        'formOptions' => [
                            'action' => ['elnpt3/update-urus-tadbir?lppid=' . $lpp->lpp_id],
                        ],
                        'type' => 'primary',
                    ];
                },
                'readonly' => function ($model, $key, $index, $widget) {
                    return ((strlen($model['ver_by']) == 0 && !is_null($model['ver_by'])) || ($model['ver_by'] == 'SMP UMS'))  ? true : false;
                }
                // 'pageSummary' => true
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'LANTIKAN BERELAUN',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'berelaun',
                'editableOptions' => function ($model, $key, $index) use ($lpp) {
                    return [
                        'header' => 'Lantikan Berelaun',
                        'name' => 'berelaun',
                        'inputType' => kartik\editable\Editable::INPUT_CHECKBOX,
                        'placement'     => kartik\popover\PopoverX::ALIGN_LEFT_TOP,
                        'buttonsTemplate' => '{submit}',
                        'formOptions' => [
                            'action' => ['elnpt3/update-urus-tadbir?lppid=' . $lpp->lpp_id],
                        ],
                        'displayValue' => ($model['berelaun'] == '1') ? 'Ya' : 'Tidak',
                        'displayValueConfig' => [0 => 'Tidak', 1 => 'Ya'],
                        'options' => [
                            'id' => $index . '-skop',
                            'class' => 'form-check-input',
                            'checked' => ($model['berelaun'] == '1') ? true : false,
                        ],
                        'type' => 'primary',
                        'beforeInput' => '<label>Lantikan Berelaun?</label>',
                    ];
                },
                'readonly' => function ($model, $key, $index, $widget) {
                    return ((strlen($model['ver_by']) == 0 && !is_null($model['ver_by'])) || ($model['ver_by'] == 'SMP UMS'))  ? true : false;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'DOKUMEN SOKONGAN',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) use ($lpp) {
                        return Html::a(
                            "<i class='fa fa-file' aria-hidden='true'></i>",
                            Url::to(['elnpt3/view-file', 'hashfile' => $model['file_hash'], 'lppid' => $lpp->lpp_id]),
                            ['data-pjax' => 0, 'target' => '_blank', 'class' => 'btn btn-xs btn-default']
                        ) .
                            '<br/><sub><b>' . ((strlen($model['ver_by']) != 0 && !is_null($model['ver_by'])) ? 'Verified by PPP' : 'Unverified') . '</b></sub>';
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
                'buttons' => [
                    'delete' => function ($url, $model, $key) use ($lpp) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', false, [
                            'class' => 'btn btn-default btn-sm pjax-delete-pnp',
                            'delete-url' =>  Url::to(['elnpt3/delete-urus-tadbir', 'id' => $model['id'], 'lppid' =>  $lpp->lpp_id]),
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