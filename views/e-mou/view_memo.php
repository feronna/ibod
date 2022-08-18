<?php

use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h5 class="text-left">Maklumat</h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?=
                    DetailView::widget([
                        'model' => $memo,
                        'attributes' => [
                            [
                                'label' => 'JAFPIB',
                                'value' => function ($model) {
                                    return $model->department->fullname;
                                },
                                'captionOptions' => ['style' => 'width:20%'],
                                'contentOptions' => ['class' => 'text-left'],
                            ],
                            [
                                'label' => 'Agensi Luar',
                                'value' => function ($model) {
                                    return $model->external_parties;
                                },
                                'contentOptions' => ['class' => 'text-left'],
                            ],
                            [
                                'label' => 'Negara',
                                'value' => function ($model) {
                                    return $model->country->Country;
                                },
                                'contentOptions' => ['class' => 'text-left'],
                            ],
                            [
                                'label' => 'Tarikh Tandatangan',
                                'value' => function ($model) {
                                    return Yii::$app->formatter->asDate($model->signature_date, 'dd/MM/yyyy');
                                },
                                'contentOptions' => ['class' => 'text-left'],
                            ],
                            [
                                'label' => 'Tarikh Luput',
                                'value' => function ($model) {
                                    return Yii::$app->formatter->asDate($model->expiration_date, 'dd/MM/yyyy');
                                },
                                'contentOptions' => ['class' => 'text-left'],
                            ],
                            [
                                'label' => 'Jenis Memorandum',
                                'value' => function ($model) {
                                    return $model->emouType->memorandum_type_desc;
                                },
                                'contentOptions' => ['class' => 'text-left'],
                            ],
                            [
                                'label' => 'JK Pelulus',
                                'value' => function ($model) {
                                    return $model->emouApprover->approver_committee_desc;
                                },
                                'contentOptions' => ['class' => 'text-left'],
                            ],
                            [
                                'label' => 'Status',
                                'value' => function ($model) {
                                    return $model->emouStatus->status_desc;
                                },
                                'contentOptions' => ['class' => 'text-left'],
                            ],
                            [
                                'label' => 'Tarikh Status',
                                'value' => function ($model) {
                                    return $model->status_date;
                                },
                                'contentOptions' => ['class' => 'text-left'],
                            ],
                            [
                                'label' => 'Dokumen Memorandum',
                                'value' => function ($model) {
                                    return $model->jfpiu_files ? yii\helpers\Html::a('<b>' . $model->jfpiu_files . '</b>', 'https://hronline.ums.edu.my/emou/v1.1/index.php?r=dataEntry/tEmou01Memorandum/downloadFile&id=' . $model->memorandum_id . '&jfpiu=1&owner=1', ['target' => '_blank']) : null;
                                },
                                'format' => 'html',
                                'contentOptions' => ['class' => 'text-left'],
                            ],
                            [
                                'label' => 'Tarikh Akhir Kemaskini',
                                'value' => function ($model) {
                                    return $model->last_update;
                                },
                                'contentOptions' => ['class' => 'text-left'],
                            ],
                        ],
                    ]);
                    ?>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <?php yii\widgets\Pjax::begin([
                            'id' => 'grid-company-pjax',
                            'timeout' => 99999
                        ]) ?>
                        <?=
                        GridView::widget([
                            'emptyText' => 'Tiada Rekod',
                            'summary' => '',
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                [
                                    // 'class' => 'yii\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return $model->order_no;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PROGRAM',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return $model->program->program_desc;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'BIDANG KERJASAMA',
                                    'headerOptions' => ['class' => 'text-center'],
                                    // 'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return $model->field_desc;
                                    },
                                    //'attribute' => 'tahun',
                                    'format' => 'html',
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'TINDAKAN',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'template' => '{update}',
                                    'buttons' => [
                                        'update' => function ($url, $model) {
                                            // $url = Url::to(['e-mou/view-memorandum', 'id' => $model->memorandum_id]);
                                            // return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                            return igorvolnyi\widgets\modal\ModalAjaxMultiple::widget([
                                                'id' => 'createCompany',
                                                'header' => '<div class="pull-left">Kemaskini Memorandum</div>',
                                                // 'size' => 'modal-lg',
                                                'toggleButton' => [
                                                    'label' => '<span class="glyphicon glyphicon-edit"></span>',
                                                    'class' => 'btn btn-default btn-sm'
                                                ],
                                                'clientOptions' => ['backdrop' => false],
                                                'url' => Url::to(['e-mou/update-field', 'field_id' =>  $model->field_id, 'id_memorandum' =>  $model->id_memorandum]), // Ajax view with form to load
                                                'ajaxSubmit' => true, // Submit the contained form as ajax, true by default
                                                // ... any other yii2 bootstrap modal option you need
                                                // 'options' => ['class' => 'header-primary'],
                                                'pjaxContainer' => '#grid-company-pjax',
                                            ]);
                                        },
                                    ],
                                ],
                            ],
                        ]);
                        ?>
                        <?php yii\widgets\Pjax::end() ?>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">Bil</th>
                                <th class="text-center">Petunjuk Prestasi Utama (KPI)</th>
                                <th class="text-center">Sasaran / Target</th>
                            </tr>

                            <?php
                            foreach ($memo->emouKpi as $field) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $field->order_no ?></td>
                                    <td "><?= $field->kpi_desc ?></td>
                                    <td class=" text-center"><?= $field->quantity_target ?></td>
                                </tr>
                            <?php    }
                            ?>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <ol>
                        <li>
                            <p>Pengesahan Dari Canselori</p>
                            <?=
                            DetailView::widget([
                                'model' => $memo,
                                'attributes' => [
                                    [
                                        'label' => 'Pengesahan JPPJK',
                                        'value' => function ($model) {
                                            return $model->verify_date;
                                        },
                                        'captionOptions' => ['style' => 'width:20%'],
                                    ],
                                    [
                                        'label' => 'Pengesahan JPPJK',
                                        'value' => function ($model) {
                                            return $model->verify_date;
                                        },
                                    ],
                                    [
                                        'label' => 'Pengesahan JPPJK',
                                        'value' => function ($model) {
                                            return $model->verify_comment;
                                        },
                                        'format' => 'text'
                                    ],
                                ]
                            ]) ?>
                        </li>
                        <li>
                            <p>Semakan Dari BPI</p>
                            <?=
                            DetailView::widget([
                                'model' => $memo,
                                'attributes' => [
                                    [
                                        'label' => 'Semakan BPT',
                                        'value' => function ($model) {
                                            return $model->review->review_desc;
                                        },
                                        'captionOptions' => ['style' => 'width:20%'],
                                    ],
                                    [
                                        'label' => 'Tarikh Semakan BPI',
                                        'value' => function ($model) {
                                            return $model->review_date;
                                        },
                                    ],
                                    [
                                        'label' => 'Dokumen Memorandum BPI',
                                        'value' => function ($model) {
                                            return $model->bpt_files ? yii\helpers\Html::a('<b>' . $model->bpt_files . '</b>', 'https://hronline.ums.edu.my/emou/v1.1/index.php?r=dataEntry/tEmou01Memorandum/downloadFile&id=' . $model->memorandum_id . '&jfpiu=1&owner=2', ['target' => '_blank']) : null;
                                        },
                                        'format' => 'html'
                                    ],
                                    [
                                        'label' => 'Komen Semakan BPI',
                                        'value' => function ($model) {
                                            return $model->review_comment;
                                        },
                                        'format' => 'html'
                                    ],
                                ]
                            ]) ?>
                        </li>
                        <li>
                            <p>Perakuan Dari Senat</p>
                            <?=
                            DetailView::widget([
                                'model' => $memo,
                                'attributes' => [
                                    [
                                        'label' => 'Perakuan Senat',
                                        'value' => function ($model) {
                                            return $model->emouApproval->approval_desc;
                                        },
                                        'captionOptions' => ['style' => 'width:20%'],
                                    ],
                                    [
                                        'label' => 'Tarikh Kelulusan Senat / PBPU',
                                        'value' => function ($model) {
                                            return $model->approval_date;
                                        },
                                    ],
                                    [
                                        'label' => 'Komen Kelulusan Senat / PBPU',
                                        'value' => function ($model) {
                                            return $model->approval_comment;
                                        },
                                        'format' => 'html'
                                    ],
                                ]
                            ]) ?>
                        </li>
                        <li>
                            <p>Perakuan Dari LPU</p>
                            <?=
                            DetailView::widget([
                                'model' => $memo,
                                'attributes' => [
                                    [
                                        'label' => 'Perakuan LPU',
                                        'value' => function ($model) {
                                            return $model->emouSecApproval->second_approval_desc;
                                        },
                                        'captionOptions' => ['style' => 'width:20%'],
                                    ],
                                    [
                                        'label' => 'Tarikh Perakuan LPU',
                                        'value' => function ($model) {
                                            return $model->second_approval_date;
                                        },
                                    ],
                                    [
                                        'label' => 'Komen Perakuan LPU',
                                        'value' => function ($model) {
                                            return $model->second_approval_comment;
                                        },
                                        'format' => 'html'
                                    ],
                                ]
                            ]) ?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>