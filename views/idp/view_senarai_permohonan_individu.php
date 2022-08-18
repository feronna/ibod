<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use app\models\hronline\Department;
use app\models\myidp\UserAccess;
use kartik\grid\GridView;
use app\models\myidp\TblYears;
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;
use kartik\export\ExportMenu;

echo $this->render('/idp/_topmenu');

error_reporting(0);

$gridColumnsPeserta = [
    [
        'class' => 'yii\grid\SerialColumn',
        'header' => 'Bil',
    ],
    [
        'label' => 'Pemohon',
        'value' => function ($data) {
            return ucwords(strtoupper($data->biodata->CONm));
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'label' => 'Program',
        'value' => function ($data) {
            return strtoupper($data->namaProgram);
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'label' => 'Tarikh Kursus',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'raw',
        'value' => function ($model) {
            if (($model->tarikhMula != null) && ($model->tarikhMula != 0000 - 00 - 00)) {

                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                $formatteddate = $myDateTime->format('d/m/Y');

                if ($model->tarikhTamat) {

                    $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhTamat);
                    $formatteddate2 = $myDateTime2->format('d/m/Y');

                    if ($formatteddate == $formatteddate2) {
                        $formatteddate = $formatteddate;
                    } else {
                        $formatteddate = $formatteddate . ' - ' . $formatteddate2;
                    }
                }
            } else {
                $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
            }
            return $formatteddate;
        },
    ],
    [
        'label' => 'Tempat',
        'value' => function ($data) {
            return strtoupper($data->lokasi);
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'label' => 'Anjuran',
        'value' => function ($data) {
            return ucwords($data->penganjur) . ' - ' . ucwords(strtoupper($data->namaPenganjur));
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    //            [
    //                'label' => 'Tarikh Pohon',
    //                'value' => function ($data){
    //                                $tarikhKursus = $data->tarikhPohon;
    //                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
    //                                $formatteddate = $myDateTime->format('d-m-Y');
    //                                return $formatteddate;
    //                            }
    //            ],
    //            [
    //                'label' => 'Kompetensi Dipohon',
    //                'format' => 'raw',
    //                'value' => function ($data){
    //                            return $data->kompetensii;
    //                            }
    //            ],
    //            [
    //                'label' => 'Dokumen',
    //                'format' => 'raw',
    //                'value' => function ($data){
    //                            return $data->displayLink4;
    //                            },
    //                'headerOptions' => ['style' => 'width:200px'],
    //            ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header' => 'Tindakan',
        'template' => '{view}',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'title' => Yii::t('app', 'Papar'),
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url = 'tindakan-pemohon?permohonanID=' . $model->permohonanID;
                return $url;
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'label' => 'Status',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'raw',
        'value' => 'statusPermohonann'
    ]

];

$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'header' => 'Bil',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'label' => 'Program',
        'value' => function ($data) {
            return strtoupper($data->namaProgram);
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'label' => 'Tarikh Kursus',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'raw',
        'value' => function ($model) {
            if (($model->tarikhMula != null) && ($model->tarikhMula != 0000 - 00 - 00)) {

                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                $formatteddate = $myDateTime->format('d/m/Y');

                if ($model->tarikhTamat) {

                    $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhTamat);
                    $formatteddate2 = $myDateTime2->format('d/m/Y');

                    if ($formatteddate == $formatteddate2) {
                        $formatteddate = $formatteddate;
                    } else {
                        $formatteddate = $formatteddate . ' - ' . $formatteddate2;
                    }
                }
            } else {
                $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
            }
            return $formatteddate;
        },
    ],
    [
        'label' => 'Tempat',
        'value' => function ($data) {
            return ucwords(strtoupper($data->lokasi));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'label' => 'Anjuran',
        'value' => function ($data) {
            return ucwords($data->penganjur) . ' - ' . ucwords(strtoupper($data->namaPenganjur));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    //            [
    //                'label' => 'Tarikh Pohon',
    //                'value' => function ($data){
    //                                $tarikhKursus = $data->tarikhPohon;
    //                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
    //                                $formatteddate = $myDateTime->format('d-m-Y');
    //                                return $formatteddate;
    //                            }
    //            ],
    //            [
    //                'label' => 'Kompetensi Dipohon',
    //                'format' => 'raw',
    //                'value' => function ($data){
    //                            return $data->kompetensii;
    //                            }
    //            ],
    //            [
    //                'label' => 'Dokumen',
    //                'format' => 'raw',
    //                'value' => function ($data){
    //                            return $data->displayLink4;
    //                            },
    //                'headerOptions' => ['style' => 'width:200px'],
    //            ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header' => 'Tindakan',
        'template' => '{view}{delete}',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'title' => Yii::t('app', 'Papar'),
                ]);
            },
            'delete' => function ($url, $model) {

                if ($model->statusPermohonan == '1' || $model->statusPermohonan == '99') {

                    return Html::a(
                        '<span class="glyphicon glyphicon-trash"></span>',
                        $url,
                        [
                            'data' => [
                                'confirm' => 'Adakah anda pasti anda ingin membatalkan permohonan ini?',
                                'method' => 'post',
                            ],
                        ],
                        ['title' => Yii::t('app', 'Batal'),]
                    );
                }
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url = 'tindakan-pemohon?permohonanID=' . $model->permohonanID;
                return $url;
            }
            if ($action === 'delete') {
                $url = 'batal-permohonan-by-pemohon?id=' . $model->permohonanID;
                return $url;
            }
        }
    ],
    [
        'label' => 'Status',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'raw',
        'value' => 'statusPermohonann',
    ]

];


?>
<style>
    .modal-dialog {
        width: 70%;
        margin: auto;

    }
</style>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i>&nbsp;Carian</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $form = ActiveForm::begin([
                    'action' => ['idp/view-senarai-permohonan-individu'],
                    'method' => 'get',
                ])
                ?>

                <div class="col-xs-6 col-md-3 col-lg-2">

                    <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::findAll(['admin_status' => 1]), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                </div>
                <?php if ($isAdmin) { ?>
                    <div class="col-xs-12 col-md-3 col-lg-6">
                        <?= Select2::widget([
                            'name' => 'dept_id',
                            'value' => $dept_id,
                            // 'attribute' => 'state_2',
                            'data' => ArrayHelper::map($model_dept, 'id', 'fullname'),
                            'options' => ['placeholder' => 'PILIH JFPIB'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                <?php } ?>
                <div class="col-xs-12 col-md-2 col-lg-2">
                    <?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;Cari', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end() ?>
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>Senarai Permohonan Mata IDP <h3><span class="label label-success" style="color: white">MOHON SENDIRI</span>
                        <div class="pull-right">
                            <?=
                            ExportMenu::widget([
                                'dataProvider' => $dataProviderA,
                                'columns' => $gridColumns,
                                'filename' => 'Permohonan Mata IDP - ' . date('Y-m-d'),
                                'exportConfig' => [
                                    ExportMenu::FORMAT_TEXT => false,
                                    ExportMenu::FORMAT_HTML => false,
                                    ExportMenu::FORMAT_CSV => false,
                                    ExportMenu::FORMAT_EXCEL => true,
                                    ExportMenu::FORMAT_PDF => false,
                                    //                    ExportMenu::FORMAT_PDF => [
                                    //                        'pdfConfig' => [
                                    //                            'methods' => [
                                    //                                'SetTitle' => 'Grid Export - Krajee.com',
                                    //                                'SetSubject' => 'Generating PDF files via yii2-export extension has never been easy',
                                    //                                'SetHeader' => ['Krajee Library Export||Generated On: ' . date("r")],
                                    //                                'SetFooter' => ['|Page {PAGENO}|'],
                                    //                                'SetAuthor' => 'Kartik Visweswaran',
                                    //                                'SetCreator' => 'Kartik Visweswaran',
                                    //                                'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, GridView, Grid, yii2-grid, yii2-mpdf, yii2-export',
                                    //                            ]
                                    //                        ]
                                    //                    ],
                                ],
                                'clearBuffers' => true,
                                'stream' => false,
                                'folder' => '@app/web/files/myidp/.',
                                'linkPath' => '/files/myidp/',
                                'batchSize' => 10,
                                //                'deleteAfterSave' => true
                            ]);
                            ?></div>
                    </h3>
                </h5>
            </div>
            <div class="x_content">

                <?php Pjax::begin(); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProviderA,
                    //'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumns,
                ]);
                ?>
                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>Senarai Permohonan Mata IDP <h3><span class="label label-primary" style="color: white">PESERTA</span>
                        <div class="pull-right">
                            <?=
                            ExportMenu::widget([
                                'dataProvider' => $dataProviderB,
                                'columns' => $gridColumnsPeserta,
                                'filename' => 'Permohonan Mata IDP - ' . date('Y-m-d'),
                                'exportConfig' => [
                                    ExportMenu::FORMAT_TEXT => false,
                                    ExportMenu::FORMAT_HTML => false,
                                    ExportMenu::FORMAT_CSV => false,
                                    ExportMenu::FORMAT_EXCEL => true,
                                    ExportMenu::FORMAT_PDF => false,
                                    //                    ExportMenu::FORMAT_PDF => [
                                    //                        'pdfConfig' => [
                                    //                            'methods' => [
                                    //                                'SetTitle' => 'Grid Export - Krajee.com',
                                    //                                'SetSubject' => 'Generating PDF files via yii2-export extension has never been easy',
                                    //                                'SetHeader' => ['Krajee Library Export||Generated On: ' . date("r")],
                                    //                                'SetFooter' => ['|Page {PAGENO}|'],
                                    //                                'SetAuthor' => 'Kartik Visweswaran',
                                    //                                'SetCreator' => 'Kartik Visweswaran',
                                    //                                'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, GridView, Grid, yii2-grid, yii2-mpdf, yii2-export',
                                    //                            ]
                                    //                        ]
                                    //                    ],
                                ],
                                'clearBuffers' => true,
                                'stream' => false,
                                'folder' => '@app/web/files/myidp/.',
                                'linkPath' => '/files/myidp/',
                                'batchSize' => 10,
                                //                'deleteAfterSave' => true
                            ]);
                            ?>
                        </div>
                    </h3>
                </h5>
            </div>
            <div class="x_content">

                <?php Pjax::begin(); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProviderB,
                    //'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsPeserta,
                ]);
                ?>
                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>
</div>