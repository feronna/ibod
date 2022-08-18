<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJs("
    $('.modalButtonnn').on('click', function () {
        $('#modal2').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });

    $('#modal2').on('hidden.bs.modal', function () {
        $.pjax.reload({
            container: '#pjax_kategori5',
            url: 'pjax-data-k5?lppid=" . $lpp->lpp_id . "',
        }).done(function () {
            $.pjax.reload({
                container: '#pjax_kategori5_result',
            url: 'pjax-result-k5?lppid=" . $lpp->lpp_id . "',
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
                        container: '#pjax_kategori5',
                        url: 'pjax-data-k5?lppid=" . $lpp->lpp_id . "',
                    }).done(function () {
                        $.pjax.reload({
                            container: '#pjax_kategori5_result',
                        url: 'pjax-result-k5?lppid=" . $lpp->lpp_id . "',
                        });
                    });
                });
            }
        });
    });

    $(document).on('ready pjax:success', function() {
        $('.modalButtonnn').on('click', function () {
            $('#modal2').modal('show')
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
                        container: '#pjax_kategori5',
                        url: 'pjax-data-k5?lppid=" . $lpp->lpp_id . "',
                    }).done(function () {
                        $.pjax.reload({
                            container: '#pjax_kategori5_result',
                        url: 'pjax-result-k5?lppid=" . $lpp->lpp_id . "',
                        });
                    });
                });
            }
        });
    });
");

$this->registerJs("
    $('.modalButton5').on('click', function () {
        $('#modal5').modal('show')
                .find('#modalContent1')
                .load($(this).attr('value'));
    });
");
?>

<?php
Modal::begin([
    'header' => '<strong>Tambah / Kemaskini</strong>',
    'id' => 'modal2',
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
    'id' => 'modal5',
    'size' => 'modal-lg',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false
    ]
]);
echo "<div id='modalContent1'></div>";
Modal::end();
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
            <h4>Perkhidmatan</h4>
        </li>
    </ol>
</nav>

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
                // 'content' => Html::button('Tambah Data', [
                //     'value' => Url::to(['elnpt3/create-urus-tadbir', 'lppid' => $lpp->lpp_id]),
                //     // 'type' => 'button',
                //     'title' => 'Tambah Data',
                //     'class' => 'btn-primary btn-sm modalButtonnn'
                // ]),
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

<div class="table-responsive">
    <?=
    \kartik\grid\GridView::widget([
        'id' => 'kategori5',
        'emptyText' => 'Tiada Rekod',
        'striped' => false,
        'summary' => '',
        'dataProvider' => $dataProvider,
        'showFooter' => false,
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'id' => 'pjax_kategori5_result',
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
                    return (!$model['auto'] ? (!($model['lain']) ? '<span class="label label-default">Pending</span> ' : '<span class="label label-primary">Manual</span> ') : '') . rtrim($model['aktiviti']) . ' ' . (($model['lain'] && $model['modal']) ?  Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => Url::to(['elnpt3/aktiviti-lain', 'lppid' => $lpp->lpp_id, 'kategori' => $model['kategori']]), 'class' => 'btn btn-default btn-xs modalButton5', 'style' => 'visibility: hidden;']) : '');
                },
                'format' => 'raw',
            ],
            [
                'header' => 'BIL UNIT',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                'value' => function ($model) {
                    $arryCurr = [57, 58, 59];
                    return isset($model['input']) ? (in_array($model['id'], $arryCurr) ? Yii::$app->formatter->asCurrency($model['input'], 'RM ') : $model['input']) : '<span class="label label-warning">No data available</span>';
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