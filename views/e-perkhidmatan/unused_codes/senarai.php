<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\myidp\UserAccess;
use app\models\hronline\Department;

//echo $this->render('/idp/_topmenu');

// $gridColumnsPeserta = [
//     [
//         'class' => 'yii\grid\SerialColumn',
//         'header' => 'Bil',
//     ],
//     [
//         'label' => 'Pemohon',
//         'value' => function ($data) {
//             return ucwords(strtolower($data->biodata->CONm));
//         }
//     ],
//     [
//         'label' => 'Program',
//         'value' => function ($data) {
//             return strtoupper($data->namaProgram);
//         }
//     ],
//     [
//         'label' => 'Tarikh Kursus',
//         'hAlign' => 'center',
//         'format' => 'raw',
//         'value' => function ($model) {
//             if (($model->tarikhMula != null) && ($model->tarikhMula != 0000 - 00 - 00)) {

//                 $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
//                 $formatteddate = $myDateTime->format('d/m/Y');

//                 if ($model->tarikhTamat) {

//                     $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhTamat);
//                     $formatteddate2 = $myDateTime2->format('d/m/Y');

//                     if ($formatteddate == $formatteddate2) {
//                         $formatteddate = $formatteddate;
//                     } else {
//                         $formatteddate = $formatteddate . ' - ' . $formatteddate2;
//                     }
//                 } 
//             } else {
//                 $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
//             }
//             return $formatteddate;
//         },
//     ],
//     [
//         'label' => 'Tempat',
//         'value' => function ($data) {
//             return strtoupper($data->lokasi);
//         }
//     ],
//     [
//         'label' => 'Anjuran',
//         'value' => function ($data) {
//             return ucwords($data->penganjur) . ' - ' . ucwords(strtoupper($data->namaPenganjur));
//         }
//     ],
//     //            [
//     //                'label' => 'Tarikh Pohon',
//     //                'value' => function ($data){
//     //                                $tarikhKursus = $data->tarikhPohon;
//     //                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
//     //                                $formatteddate = $myDateTime->format('d-m-Y');
//     //                                return $formatteddate;
//     //                            }
//     //            ],
//     //            [
//     //                'label' => 'Kompetensi Dipohon',
//     //                'format' => 'raw',
//     //                'value' => function ($data){
//     //                            return $data->kompetensii;
//     //                            }
//     //            ],
//     //            [
//     //                'label' => 'Dokumen',
//     //                'format' => 'raw',
//     //                'value' => function ($data){
//     //                            return $data->displayLink4;
//     //                            },
//     //                'headerOptions' => ['style' => 'width:200px'],
//     //            ],
//     [
//         'class' => 'yii\grid\ActionColumn',
//         'header' => 'Tindakan',
//         'template' => '{view}',
//         'buttons' => [
//             'view' => function ($url, $model) {
//                 return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
//                     'title' => Yii::t('app', 'Papar'),
//                 ]);
//             },
//         ],
//         'urlCreator' => function ($action, $model, $key, $index) {
//             if ($action === 'view') {
//                 $url = 'tindakan-pemohon?permohonanID=' . $model->permohonanID;
//                 return $url;
//             }
//         }
//     ],
//     [
//         'label' => 'Status',
//         'hAlign' => 'center',
//         'format' => 'raw',
//         'value' => 'statusPermohonann'
//     ]

// ];

// $gridColumns = [
//     [
//         'class' => 'yii\grid\SerialColumn',
//         'header' => 'Bil',
//     ],
//     [
//         'label' => 'Program',
//         'value' => function ($data) {
//             return strtoupper($data->namaProgram);
//         }
//     ],
//     [
//         'label' => 'Tarikh Kursus',
//         'hAlign' => 'center',
//         'format' => 'raw',
//         'value' => function ($model) {
//             if (($model->tarikhMula != null) && ($model->tarikhMula != 0000 - 00 - 00)) {

//                 $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
//                 $formatteddate = $myDateTime->format('d/m/Y');

//                 if ($model->tarikhTamat) {

//                     $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhTamat);
//                     $formatteddate2 = $myDateTime2->format('d/m/Y');

//                     if ($formatteddate == $formatteddate2) {
//                         $formatteddate = $formatteddate;
//                     } else {
//                         $formatteddate = $formatteddate . ' - ' . $formatteddate2;
//                     }
//                 } 
//             } else {
//                 $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
//             }
//             return $formatteddate;
//         },
//     ],
//     [
//         'label' => 'Tempat',
//         'value' => function ($data) {
//             return ucwords(strtolower($data->lokasi));
//         }
//     ],
//     [
//         'label' => 'Anjuran',
//         'value' => function ($data) {
//             return ucwords($data->penganjur) . ' - ' . ucwords(strtoupper($data->namaPenganjur));
//         }
//     ],
//     //            [
//     //                'label' => 'Tarikh Pohon',
//     //                'value' => function ($data){
//     //                                $tarikhKursus = $data->tarikhPohon;
//     //                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
//     //                                $formatteddate = $myDateTime->format('d-m-Y');
//     //                                return $formatteddate;
//     //                            }
//     //            ],
//     //            [
//     //                'label' => 'Kompetensi Dipohon',
//     //                'format' => 'raw',
//     //                'value' => function ($data){
//     //                            return $data->kompetensii;
//     //                            }
//     //            ],
//     //            [
//     //                'label' => 'Dokumen',
//     //                'format' => 'raw',
//     //                'value' => function ($data){
//     //                            return $data->displayLink4;
//     //                            },
//     //                'headerOptions' => ['style' => 'width:200px'],
//     //            ],
//     [
//         'class' => 'yii\grid\ActionColumn',
//         'header' => 'Tindakan',
//         'template' => '{view} | {delete}',
//         'buttons' => [
//             'view' => function ($url, $model) {
//                 return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
//                     'title' => Yii::t('app', 'Papar'),
//                 ]);
//             },
//             'delete' => function ($url, $model) {

//                 if ($model->statusPermohonan == '1') {

//                     return Html::a(
//                         '<span class="glyphicon glyphicon-trash"></span>',
//                         $url,
//                         [
//                             'data' => [
//                                 'confirm' => 'Adakah anda pasti anda ingin membatalkan permohonan ini?',
//                                 'method' => 'post',
//                             ],
//                         ],
//                         ['title' => Yii::t('app', 'Batal'),]
//                     );
//                 }
//             },
//         ],
//         'urlCreator' => function ($action, $model, $key, $index) {
//             if ($action === 'view') {
//                 $url = 'tindakan-pemohon?permohonanID=' . $model->permohonanID;
//                 return $url;
//             }
//             if ($action === 'delete') {
//                 $url = 'batal-permohonan-by-pemohon?id=' . $model->permohonanID;
//                 return $url;
//             }
//         }
//     ],
//     [
//         'label' => 'Status',
//         'hAlign' => 'center',
//         'format' => 'raw',
//         'value' => 'statusPermohonann',
//     ]

// ];


echo $this->render('/e-perkhidmatan/contact');
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>Maklumat Program

                </h5>
            </div>
            <div class="x_content">
                <!-- ada x_content baru boleh collapse -->
                <div class="x_panel">
                    <?php
                    if ($model->entry_date) {
                        echo 'Keterangan </br></br>';
                        echo 'Nama Program :' . strtoupper($model->event_name) . '</br>';
                        echo 'Lokasi Program :' . strtoupper($model->location) . '</br>';
                        //echo strtoupper($model->biodata->department->fullname) . '</br></br>';
                        echo 'Tarikh Permohonan : ' . Yii::$app->formatter->asDate($model->entry_date, 'php:d-m-Y');
                        echo '</br></br>';
                    } else {
                        echo '';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>Senarai Permohonan Banner / Bunting / Poster

                    <div class="pull-right">
                        <?= Html::a(Yii::t('app', 'Tambah'), ['link-Aisyah'], ['class' => 'btn btn-success']) ?>
                    </div>

                </h5>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?php Pjax::begin(); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    //'columns' => $gridColumns,
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
                <h5>Senarai Permohonan Countdown

                    <div class="pull-right">
                        <?= Html::a(Yii::t('app', 'Tambah'), ['link-jaquirah'], ['class' => 'btn btn-success']) ?>
                    </div>

                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?php Pjax::begin(); ?>
                <?php
                // GridView::widget([
                //     'dataProvider' => $dataProviderB,
                //     //'filterModel' => $searchModel,
                //     //'layout' => "{items}\n{pager}",
                //     'pager' => [
                //         'firstPageLabel' => 'Halaman Pertama',
                //         'lastPageLabel'  => 'Halaman Terakhir'
                //     ],
                //     'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                //     'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                //     'columns' => $gridColumnsPeserta,
                // ]);
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
                <h5>Senarai Permohonan Papan Tanda

                    <div class="pull-right">
                        <?= Html::a(Yii::t('app', 'Tambah'), ['papan-tanda/halaman-utama-papan-tanda?id='.$model->event_id], ['class' => 'btn btn-success']) ?>
                    </div>

                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?php Pjax::begin(); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    //'columns' => $gridColumns,
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
                <h5>Senarai Permohonan Parkir

                    <div class="pull-right">
                        <?= Html::a(Yii::t('app', 'Tambah'), ['parkir/halaman-utama-parkir'], ['class' => 'btn btn-success']) ?>
                    </div>

                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?php Pjax::begin(); ?>
                <?php
                // GridView::widget([
                //     'dataProvider' => $dataProviderB,
                //     //'filterModel' => $searchModel,
                //     //'layout' => "{items}\n{pager}",
                //     'pager' => [
                //         'firstPageLabel' => 'Halaman Pertama',
                //         'lastPageLabel'  => 'Halaman Terakhir'
                //     ],
                //     'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                //     'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                //     'columns' => $gridColumnsPeserta,
                // ]);
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
                <h5>Senarai Permohonan Kawalan Keselamatan

                    <div class="pull-right">
                        <?= Html::a(Yii::t('app', 'Tambah'), ['link-jaquirah'], ['class' => 'btn btn-success']) ?>
                    </div>

                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?php Pjax::begin(); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    //'columns' => $gridColumns,
                ]);
                ?>
                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>
</div>