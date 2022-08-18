<?php

use kartik\editable\Editable;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

$grid = \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider4,
    'id' => 'data_kategori2',
    'emptyText' => 'Tiada Rekod',
    'striped' => false,
    'summary' => '',
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'Nomatrik',
        'NamaPelajar',
        'KodSesi_Sem',
        'TahapPenyeliaanBM',
        'StatusPengajianBM',
        'LevelPengajian'
    ],
]);

$this->registerJs("
    $('.modalButton1_2').on('click', function () {
        $('#modal1_2').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });

    $(document).on('ready pjax:success', function() {
        $('.modalButton1_2').on('click', function () {
            $('#modal1_2').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
        });
    });

    $('.modalButtonPljr').on('click', function () {
        $('#modalPljr').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });

    $(document).on('ready pjax:success', function() {
        $('.modalButtonPljr').on('click', function () {
            $('#modalPljr').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
        });
    });
");

$this->registerJs("
    $('.modalButtonn').on('click', function () {
        $('#modall').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });

    $('#modall').on('hidden.bs.modal', function () {
        $.pjax.reload({
            container: '#pjax_kategori1',
            url: 'pjax-data-k1?lppid=" . $lpp->lpp_id . "',
        }).done(function () {
            $.pjax.reload({
                container: '#pjax_kategori1_result',
            url: 'pjax-result-k1?lppid=" . $lpp->lpp_id . "',
            });
        });
    })

    $( document ).ready(function() {
        $('.pjax-delete-pnp').on('click', function(e) {
            e.preventDefault();
            var deleteUrl = $(this).attr('delete-url')
            var result = confirm('Are you sure you want to delete this item?');                                
            if(result) {
                $.ajax({
                    url: deleteUrl,
                    type: 'post',
                    error: function(xhr, status, error) {
                        alert('There was an error with your request.' + xhr.responseText);
                    }
                }).done(function(data) {
                    $.pjax.reload({
                        container: '#pjax_kategori1',
                        url: 'pjax-data-k1?lppid=" . $lpp->lpp_id . "',
                    }).done(function () {
                        $.pjax.reload({
                            container: '#pjax_kategori1_result',
                        url: 'pjax-result-k1?lppid=" . $lpp->lpp_id . "',
                        });
                    });
                });
            }
        });
    });

    $(document).on('ready pjax:success', function() {
        $('.modalButtonn').on('click', function () {
            $('#modall').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
        });

        $('.pjax-delete-pnp').on('click', function(e) {
            e.preventDefault();
            var deleteUrl = $(this).attr('delete-url')
            var result = confirm('Are you sure you want to delete this item?');                                
            if(result) {
                $.ajax({
                    url: deleteUrl,
                    type: 'post',
                    error: function(xhr, status, error) {
                        alert('There was an error with your request.' + xhr.responseText);
                    }
                }).done(function(data) {
                    $.pjax.reload({
                        container: '#pjax_kategori1',
                        url: 'pjax-data-k1?lppid=" . $lpp->lpp_id . "',
                    }).done(function () {
                        $.pjax.reload({
                            container: '#pjax_kategori1_result',
                        url: 'pjax-result-k1?lppid=" . $lpp->lpp_id . "',
                        });
                    });
                });
            }
        });
    });
");

$semester = [
    // '1-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '' => '1 - ' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '',
    '2-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '' => '2-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '',
    '3-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '' => '3-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '',
    '1-' . ($lpp->tahun) . '/' . ($lpp->tahun + 1) . '' => '1-' . ($lpp->tahun) . '/' . ($lpp->tahun + 1) . '',
    // '2-' . ($lpp->tahun) . '/' . ($lpp->tahun + 1) . '' => '2 - ' . ($lpp->tahun) . '/' . ($lpp->tahun + 1) . '',
    // '3-' . ($lpp->tahun) . '/' . ($lpp->tahun + 1) . '' => '3 - ' . ($lpp->tahun) . '/' . ($lpp->tahun + 1) . '',
    // 'Nursing' => [
    //     '1-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '' => '1-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '',
    // ]
];
?>

<?php
Modal::begin([
    'header' => '<strong>Tambah / Kemaskini</strong>',
    'id' => 'modall',
    'size' => 'modal-lg',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false
    ]
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?php
Modal::begin([
    'header' => '<strong>Senarai Aktiviti Lain</strong>',
    'id' => 'modal1_2',
    'size' => 'modal-lg',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false
    ]
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?php
Modal::begin([
    'header' => '<strong>Tambah Pelajar</strong>',
    'id' => 'modalPljr',
    'size' => 'modal-lg',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
        'tabindex' => false,
    ]
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
            <h4>Pengajaran</h4>
        </li>
    </ol>
</nav>

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

<div class="table-responsive">
    <?=
    \kartik\grid\GridView::widget([
        'id' => 'kategori1',
        'emptyText' => 'Tiada Rekod',
        'striped' => false,
        'summary' => '',
        'dataProvider' => $dataProvider,
        'showFooter' => false,
        'pjax' => true,
        'rowOptions' => function ($model) {
            if ($model['id'] == 6) {
                return ['class' => 'danger'];
            }
        },
        'pjaxSettings' => [
            'options' => [
                'id' => 'pjax_kategori1_result',
            ],
        ],
        'columns' => [
            [
                'header' => 'HAKIKI',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return $model['isHakiki'] ? 'Hakiki' : 'Selain Hakiki';
                },
                'group' => true,
                // 'groupOddCssClass' => '',  // configure odd group cell css class
                // 'groupEvenCssClass' => '', // configure even group cell css class
            ],
            [
                'header' => 'BIL',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return $model['bil'];
                },
                'group' => true,
                'groupOddCssClass' => '',  // configure odd group cell css class
                'groupEvenCssClass' => '', // configure even group cell css class
            ],
            [
                'label' => 'AKTIVITI',
                'headerOptions' => ['class' => 'column-title text-center'],
                'contentOptions' => ['style' => 'vertical-align:middle'],
                'value' => function ($model, $key, $index) use ($form, $inputs, $lpp) {
                    if ($model['id'] == 6) {
                        return '<del>' . rtrim($model['aktiviti']) . '</del>';
                    }
                    return (!$model['auto'] ? (!($model['lain']) ? '<span class="label label-default">Pending</span> ' : '<span class="label label-primary">Manual</span> ') : '') . rtrim($model['aktiviti']) . ' ' . (($model['lain'] && $model['modal']) ?  Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => Url::to(['elnpt3/aktiviti-lain', 'lppid' => $lpp->lpp_id, 'kategori' => $model['kategori']]), 'class' => 'btn btn-default btn-xs modalButton1_2']) : '');
                },
                'format' => 'raw',
            ],
            [
                'header' => 'BIL UNIT',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return ($model['id'] != 6) ?  (isset($model['input']) ? $model['input'] : '<span class="label label-warning">No data available</span>') : '';
                }, // configure even group cell css class
                'format' => 'html',
            ],
            [
                'header' => 'MATA DIPEROLEH',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return ($model['id'] != 6) ? ('<b>' . Yii::$app->formatter->asDecimal($model['mata'], 2) . '</b>') : '';
                }, // configure even group cell css class
                'format' => 'html',
            ],
        ],
    ]);
    ?>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
            <h4>Penyeliaan</h4>
        </li>
    </ol>
</nav>

<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <tr>
            <th class="text-center" rowspan="3">BIL.</th>
            <th class="text-center col-md-4" rowspan="3">TAHAP PENYELIAAN</th>
            <th class="text-center" colspan="6">BILANGAN PELAJAR DISELIA YANG AKTIF (TERKUMPUL)</th>

        </tr>
        <tr>
            <th class="text-center" colspan="3">SEBAGAI PENYELIA UTAMA/PENGERUSI</th>
            <th class="text-center" colspan="3">SEBAGAI PENYELIA BERSAMA/AHLI</th>
        </tr>
        <tr>
            <th class="text-center">BELUM PERLANJUTAN</th>
            <th class="text-center">TELAH PERLANJUTAN (2 SEMESTER ATAU KURANG)</th>
            <th class="text-center">TELAH PERLANJUTAN</th>
            <th class="text-center">BELUM PERLANJUTAN</th>
            <th class="text-center">TELAH PERLANJUTAN (2 SEMESTER ATAU KURANG)</th>
            <th class="text-center">TELAH PERLANJUTAN</th>
        </tr>
        <?php
        $cnt = 1;
        foreach ($data as $ind => $dt) { ?>
            <tr>
                <td class="text-center"><?= $cnt; ?></td>
                <td><?php
                    switch ($ind) {
                        case 'PHD':
                            echo 'PhD (Penyelidikan)';
                            break;
                        case 'MASTER':
                            echo 'Sarjana (Penyelidikan)';
                            break;
                        case 'M.Phil.':
                            echo 'DrPH (Doctor of Public Health)';
                            break;
                        case 'kerja_kursus':
                            echo 'Sarjana (Kerja Kursus)';
                            break;
                        case 'sarjana_muda':
                            echo 'Sarjana Muda (Projek Tahun Akhir)';
                            break;
                        case 'sarjana_muda_2':
                            echo 'Sarjana Muda (Latihan Industri/ Latihan Amali/ Praktikum/ PUPUK)';
                            break;
                        case 'sarjana_muda_klinikal':
                            echo 'Sarjana Klinikal CM/ MM';
                            break;
                        case 'pasca':
                            echo 'Pascasiswazah Antarabangsa';
                            break;
                    }
                    ?></td>
                <td class="text-center"><?= array_key_exists('verified_by', $dt) ? Editable::widget([
                                            'name' => 'utama_belum',
                                            'attribute' => 'utama_belum',
                                            'asPopover' => true,
                                            'value' => $dt['utama_belum'],
                                            'header' => 'Belum Perlanjutan',
                                            'size' => 'sm',
                                            'options' => ['class' => 'form-control'],
                                            'formOptions' => [
                                                'action' => ['elnpt3/update-penyeliaan?lppid=' . $lpp->lpp_id . '&id=' . $dt['id'] . '&tahap=' . $dt['tahap']],
                                            ],
                                            'pluginEvents' => [
                                                "editableSuccess" => "function(event, val, form, data) {
                                                    $.pjax.reload({
                                                        container: '#pjax_kategori2_result',
                                                    url: 'pjax-result-k2?lppid=" . $lpp->lpp_id . "',
                                                    });
                                                }",
                                            ],
                                        ]) : $dt['utama_belum'] ?></td>
                <td class="text-center"><?= array_key_exists('verified_by', $dt) ? Editable::widget([
                                            'name' => 'utama_telah_sem',
                                            'attribute' => 'utama_telah_sem',
                                            'asPopover' => true,
                                            'value' => $dt['utama_telah_sem'],
                                            'header' => 'Telah Perlanjutan (2 Semester / Kurang)',
                                            'size' => 'sm',
                                            'options' => ['class' => 'form-control'],
                                            'formOptions' => [
                                                'action' => ['elnpt3/update-penyeliaan?lppid=' . $lpp->lpp_id . '&id=' . $dt['id'] . '&tahap=' . $dt['tahap']],
                                            ],
                                            'pluginEvents' => [
                                                "editableSuccess" => "function(event, val, form, data) {
                                                    $.pjax.reload({
                                                        container: '#pjax_kategori2_result',
                                                    url: 'pjax-result-k2?lppid=" . $lpp->lpp_id . "',
                                                    });
                                                }",
                                            ],
                                        ]) : $dt['utama_telah_sem'] ?></td>
                <td class="text-center"><?= array_key_exists('verified_by', $dt) ? Editable::widget([
                                            'name' => 'utama_telah',
                                            'attribute' => 'utama_telah',
                                            'asPopover' => true,
                                            'value' => $dt['utama_telah'],
                                            'header' => 'Telah Perlanjutan',
                                            'size' => 'sm',
                                            'options' => ['class' => 'form-control'],
                                            'formOptions' => [
                                                'action' => ['elnpt3/update-penyeliaan?lppid=' . $lpp->lpp_id . '&id=' . $dt['id'] . '&tahap=' . $dt['tahap']],
                                            ],
                                            'pluginEvents' => [
                                                "editableSuccess" => "function(event, val, form, data) {
                                                    $.pjax.reload({
                                                        container: '#pjax_kategori2_result',
                                                    url: 'pjax-result-k2?lppid=" . $lpp->lpp_id . "',
                                                    });
                                                }",
                                            ],
                                        ]) : $dt['utama_telah'] ?></td>
                <td class="text-center"><?= array_key_exists('verified_by', $dt) ? Editable::widget([
                                            'name' => 'sama_belum',
                                            'attribute' => 'sama_belum',
                                            'asPopover' => true,
                                            'value' => $dt['sama_belum'],
                                            'header' => 'Belum Perlanjutan',
                                            'size' => 'sm',
                                            'options' => ['class' => 'form-control'],
                                            'formOptions' => [
                                                'action' => ['elnpt3/update-penyeliaan?lppid=' . $lpp->lpp_id . '&id=' . $dt['id'] . '&tahap=' . $dt['tahap']],
                                            ],
                                            'pluginEvents' => [
                                                "editableSuccess" => "function(event, val, form, data) {
                                                    $.pjax.reload({
                                                        container: '#pjax_kategori2_result',
                                                    url: 'pjax-result-k2?lppid=" . $lpp->lpp_id . "',
                                                    });
                                                }",
                                            ],
                                        ]) : $dt['sama_belum'] ?></td>
                <td class="text-center"><?= array_key_exists('verified_by', $dt) ? Editable::widget([
                                            'name' => 'sama_telah_sem',
                                            'attribute' => 'sama_telah_sem',
                                            'asPopover' => true,
                                            'value' => $dt['sama_telah_sem'],
                                            'header' => 'Telah Perlanjutan (2 Semester / Kurang)',
                                            'size' => 'sm',
                                            'options' => ['class' => 'form-control'],
                                            'formOptions' => [
                                                'action' => ['elnpt3/update-penyeliaan?lppid=' . $lpp->lpp_id . '&id=' . $dt['id'] . '&tahap=' . $dt['tahap']],
                                            ],
                                            'pluginEvents' => [
                                                "editableSuccess" => "function(event, val, form, data) {
                                                    $.pjax.reload({
                                                        container: '#pjax_kategori2_result',
                                                    url: 'pjax-result-k2?lppid=" . $lpp->lpp_id . "',
                                                    });
                                                }",
                                            ],
                                        ]) : $dt['sama_telah_sem'] ?></td>
                <td class="text-center"><?= array_key_exists('verified_by', $dt) ? Editable::widget([
                                            'name' => 'sama_telah',
                                            'attribute' => 'sama_telah',
                                            'asPopover' => true,
                                            'value' => $dt['sama_telah'],
                                            'header' => 'Telah Perlanjutan',
                                            'size' => 'sm',
                                            'options' => ['class' => 'form-control'],
                                            'formOptions' => [
                                                'action' => ['elnpt3/update-penyeliaan?lppid=' . $lpp->lpp_id . '&id=' . $dt['id'] . '&tahap=' . $dt['tahap']],
                                            ],
                                            'pluginEvents' => [
                                                "editableSuccess" => "function(event, val, form, data) {
                                                    $.pjax.reload({
                                                        container: '#pjax_kategori2_result',
                                                    url: 'pjax-result-k2?lppid=" . $lpp->lpp_id . "',
                                                    });
                                                }",
                                            ],
                                        ]) : $dt['sama_telah'] ?></td>
            </tr>
        <?php $cnt++;
        } ?>
    </table>
</div>

<?php Html::button('Tambah Rekod', ['value' => Url::to(['elnpt3/tambah-pelajar', 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-success btn-sm modalButtonPljr pull-right']) ?>
<div class="clearfix"></div>

<?=
\yiister\gentelella\widgets\Accordion::widget(
    [
        'items' => [
            [
                'title' => 'Senarai Pelajar - Click to view',
                'active' => false,
                'content' => '<div class="table-responsive">' .
                    $grid
                    . '</div>'

            ],
        ],
    ]
);
?>

<br />

<div class="clearfix"></div>

<div class="table-responsive">
    <?=
    \kartik\grid\GridView::widget([
        'id' => 'kategori2',
        'emptyText' => 'Tiada Rekod',
        'striped' => false,
        'summary' => '',
        'dataProvider' => $dataProvider3,
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'id' => 'pjax_kategori2_result',
            ],
        ],
        'showFooter' => false,
        // 'rowOptions' => function ($model) {
        //     if ($model['id'] == 20) {
        //         return ['class' => 'info'];
        //     }
        // },
        'columns' => [
            [
                'header' => 'HAKIKI',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return $model['isHakiki'] ? 'Hakiki' : 'Selain Hakiki';
                },
                'group' => true,
                // 'groupOddCssClass' => '',  // configure odd group cell css class
                // 'groupEvenCssClass' => '', // configure even group cell css class
            ],
            [
                'header' => 'BIL',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return $model['bil'];
                },
                'group' => true,
                'groupOddCssClass' => '',  // configure odd group cell css class
                'groupEvenCssClass' => '', // configure even group cell css class
            ],
            [
                'label' => 'AKTIVITI',
                'headerOptions' => ['class' => 'column-title text-center'],
                'contentOptions' => ['style' => 'vertical-align:middle'],
                'value' => function ($model, $key, $index) use ($form, $inputs, $lpp) {
                    return (!$model['auto'] ? (!($model['lain']) ? '<span class="label label-default">Pending</span> ' : '<span class="label label-primary">Manual</span> ') : '') . rtrim($model['aktiviti']) . ' ' . (($model['lain'] && $model['modal']) ?  Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => Url::to(['elnpt3/aktiviti-lain', 'lppid' => $lpp->lpp_id, 'kategori' => $model['kategori']]), 'class' => 'btn btn-default btn-xs modalButton1_2', 'style' => 'visibility: hidden;']) : '');
                },
                'format' => 'raw',
            ],
            [
                'header' => 'BIL UNIT',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return isset($model['input']) ? $model['input'] : '<span class="label label-warning">No data available</span>';
                }, // configure even group cell css class
                'format' => 'html',
            ],
            [
                'header' => 'MATA DIPEROLEH',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    return '<b>' . Yii::$app->formatter->asDecimal($model['mata'], 2) . '</b>';
                }, // configure even group cell css class
                'format' => 'html',
            ],
        ],
    ]);
    ?>
</div>

<?= $this->renderAjax('_mini_summary', ['miniSummary' => $miniSummary]) ?>