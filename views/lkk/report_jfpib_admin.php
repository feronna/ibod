<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use app\models\hronline\Department;
use yii\bootstrap\Tabs;

echo $this->render('/cutibelajar/_topmenu');

error_reporting(0);

$gridColumnsK = [
    ['class' => 'kartik\grid\SerialColumn',
        'header' => 'BIL',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'headerOptions' => [
            'style' => 'display: none;',
        ],
    ],
    [
        'label' => 'AFPIB',
        'vAlign' => 'middle',
        'hAlign' => 'left',
        'format' => 'raw',
        'value' => function ($model) {
            return strtoupper($model->shortname);
        },
        'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
        'headerOptions' => [
            'style' => 'display: none;', 'class' => 'text-center success'
        ],
    ],
    [
        'label' => 'JUMLAH KAKITANGAN',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'raw',
        'value' => function ($model) {
//            return Department::countStaffDeptCb($model->id, 0);
            return Html::a(Department::countStaffDeptCb($model->id, 1), ["senarai-all", 'kumpulan' => $model->id, 'category' => 1], ['target' => '_blank']);
        },
                'contentOptions' => ['class' => 'text-center', 'style' => 'width:150px; white-space: normal;'],
                'headerOptions' => [
                    'style' => 'display: none;',
                ],
                'vAlign' => 'middle',
                'hAlign' => 'center'
            ],
            [
                'label' => 'DOKTOR FALSAFAH',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(Department::countPhd($model->id, 1), ["senarai-phd", 'kumpulan' => $model->id, 'category' => 1], ['target' => '_blank']);

//            return Department::countPhd($model->id, 0);
                },
                        'contentOptions' => ['class' => 'text-center', 'style' => 'width:150px; white-space: normal;'],
                        'headerOptions' => [
                            'style' => 'display: none;',
                        ],
                        'vAlign' => 'middle',
                        'hAlign' => 'center'
                    ],
                    [
                        'label' => 'SARJANA ',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a(Department::countSarjana($model->id, 1), ["senarai-sarjana", 'kumpulan' => $model->id, 'category' => 1], ['target' => '_blank']);
                        },
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width:150px; white-space: normal;'],
                                'headerOptions' => [
                                    'style' => 'display: none;',
                                ],
                                'vAlign' => 'middle',
                                'hAlign' => 'center'
                            ],
                            [
                                'label' => 'POS BASIK ',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Html::a(Department::countBasik($model->id, 1), ["senarai-basik", 'kumpulan' => $model->id, 'category' => 1], ['target' => '_blank']);
                                },
                                        'contentOptions' => ['class' => 'text-center', 'style' => 'width:150px; white-space: normal;'],
                                        'headerOptions' => [
                                            'style' => 'display: none;',
                                        ],
                                        'vAlign' => 'middle',
                                        'hAlign' => 'center'
                                    ],
                                        [
                        'label' => 'SARJANA MUDA ',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a(Department::countSarjanamuda($model->id, 0), ["senarai-sarjanamuda", 'kumpulan' => $model->id, 'category' => 0], ['target' => '_blank']);
                        },
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width:150px; white-space: normal;'],
                                'headerOptions' => [
                                    'style' => 'display: none;',
                                ],
                                'vAlign' => 'middle',
                                'hAlign' => 'center'
                            ],
                                    [
                                        'label' => 'DIPLOMA ',
                                        'vAlign' => 'middle',
                                        'hAlign' => 'center',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return Html::a(Department::countDiploma($model->id, 0), ["senarai-diploma", 'kumpulan' => $model->id, 'category' => 0], ['target' => '_blank']);
                                        },
                                                'contentOptions' => ['class' => 'text-center', 'style' => 'width:150px; white-space: normal;'],
                                                'headerOptions' => [
                                                    'style' => 'display: none;',
                                                ],
                                                'vAlign' => 'middle',
                                                'hAlign' => 'center'
                                            ],
//    [
//        'attribute' => 'check',
//        'label' => 'YA <span class="fa fa-check">',
//        'encodeLabel' => false,
////                                    'label' => 'JUMLAH',
//        'vAlign' => 'middle',
//        'hAlign' => 'center',
//        'format' => 'raw',
////                                    'value' => function ($model){
////                                                      return Html::a(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 1, 0), ["senarai", 'kumpulan' => $model->vckl_kod_kumpulan, 'category' => 1, 'calctype' => 0]);
////                                                },
//        'value' => function ($model) use ($tahun) {
//            return Department::countProposalDefense($model->id, 0);
//        },
//                               'headerOptions' => ['class' => 'text-center success'],
//
//        'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//    ],
//    [
//        'attribute' => 'times',
//        'label' => 'TIDAK <span class="fa fa-times">',
//        'encodeLabel' => false,
//        'vAlign' => 'middle',
//        'hAlign' => 'center',
//        'format' => 'raw',
////                                    'value' => function ($model){
////                                                        return RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 1, 0);
////                                                  },
//        'value' => function ($model) use ($tahun) {
//            return Department::countNoProposalDefense($model->id, 0);
//        },
//                               'headerOptions' => ['class' => 'text-center danger'],
//
//        'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//    ],
//    [
//        'attribute' => 'times',
//        'label' => 'NO RECORD',
//        'encodeLabel' => false,
//        'vAlign' => 'middle',
//        'hAlign' => 'center',
//        'format' => 'raw',
////                                    'value' => function ($model){
////                                                        return RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 1, 0);
////                                                  },
//        'value' => function ($model) use ($tahun) {
//            return Department::countNoPD($model->id, 0);
//        },
//        'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//    ],
//    [
//        'label' => 'LULUS',
////        'encodeLabel' => false,
////                                    'label' => 'JUMLAH',
//        'vAlign' => 'middle',
//        'hAlign' => 'center',
//        'format' => 'raw',
////                                    'value' => function ($model){
////                                                      return Html::a(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 1, 0), ["senarai", 'kumpulan' => $model->vckl_kod_kumpulan, 'category' => 1, 'calctype' => 0]);
////                                                },
//        'value' => function ($model) use ($tahun) {
//            return Department::countLulusKerjaKursus($model->id, 0);
//        },
//        'headerOptions' => ['class' => 'text-center success'],
//        'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//    ],
//    [
//        
//        'label' => 'LB/GAGAL',
//        'vAlign' => 'middle',
//        'hAlign' => 'center',
//        'format' => 'raw',
////                                    'value' => function ($model){
////                                                        return RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 1, 0);
////                                                  },
//        'value' => function ($model) use ($tahun) {
//            return '';
//        },
//               'headerOptions' => ['class' => 'text-center danger'],
//        'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//    ],
                                        ];
                                        ?>
                                        <!---- Hide previous modal screen ---->
                                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                                        <script>
                                            $(document).ready(function () {
                                                $("#modal").on('hidden.bs.modal', function () {
                                                    $('#modalContent').empty();
                                                });
                                            });
                                        </script>
                                        <!--- /Hide previous modal screen ---->
                                        <style>
                                            a:link {
                                                color: green;
                                                background-color: transparent;
                                                text-decoration: none;
                                            }
                                            a:visited {
                                                color: indigo;
                                                background-color: transparent;
                                                text-decoration: none;
                                            }
                                            a:hover {
                                                color: red;
                                                background-color: transparent;
                                                text-decoration: underline;
                                            }
                                            a:active {
                                                color: yellow;
                                                background-color: transparent;
                                                text-decoration: underline;
                                            }
                                        </style>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <h5>STATISTIK PERINGKAT PENGAJIAN  KAKITANGAN PENTADBIRAN (JFPIB)</h5>
                                                        <div class="clearfix"></div>
                                                    </div>


                                                    <div class="x_content">

                                        <?=
                                        Tabs::widget([
                                            'items' => [
                                                [
                                                    'label' => 'PENTADBIRAN',
                                                    'content' => ExportMenu::widget([
                                                        'dataProvider' => $dataProvider,
                                                        'columns' => $gridColumnsK,
                                                        'filename' => 'laporan_lkp_' . date('Y-m-d'),
                                                        'clearBuffers' => true,
                                                        'stream' => false,
                                                        'folder' => '@app/web/files/cb/.',
                                                        'linkPath' => '/files/cb/',
                                                        'batchSize' => 10,
                                                            //                'deleteAfterSave' => true
                                                    ]) . '<br><br>' .
                                                    GridView::widget([
                                                        'dataProvider' => $dataProvider,
                                                        //'filterModel' => $kursusJemputan,
                                                        'showFooter' => true,
                                                        'emptyText' => 'Tiada data ditemui.',
                                                        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
//                                                'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: white;'],
                                                        'beforeHeader' => [
                                                            [
                                                                'columns' => [
                                                                    ['content' => 'BIL', 'options' => ['colspan' => 1, 'class' => 'text-center info'],
                                                                        'vAlign' => 'middle',
                                                                        'hAlign' => 'center'],
                                                                    ['content' => 'JFPIB', 'options' => ['colspan' => 1, 'class' => 'text-center warning']],
                                                                    ['content' => 'JUMLAH KAKITANGAN',
                                                                        'options' => ['colspan' => 1, 'class' => 'text-center success',],
                                                                        'vAlign' => 'middle',
                                                                        'hAlign' => 'center'],
                                                                    ['content' => 'PHD', 'options' => ['colspan' => 1, 'class' => 'text-center info']],
                                                                    ['content' => 'SARJANA', 'options' => ['colspan' => 1, 'class' => 'text-center info']],
                                                                    ['content' => 'POS BASIK', 'options' => ['colspan' => 1, 'class' => 'text-center info']],
                                                                    ['content' => 'SARJANA MUDA', 'options' => ['colspan' => 1, 'class' => 'text-center info']],
                                                                    ['content' => 'DIPLOMA', 'options' => ['colspan' => 1, 'class' => 'text-center info']],
                                                                //['content' => 'Date', 'options' => ['colspan' => 2, 'class' => 'text-center warning']],
                                                                ],
                                                            ]
                                                        ],
                                                        'columns' => $gridColumnsK,
                                                    ]),
                                                    'active' => true
                                                ],
                                            ],
                                        ]);
                                        ?>

                                                        <!--<div class="clearfix"></div>
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                <div class="x_panel">
                                                                    <div class="x_title">
                                                                        <h2>Staf Pentadbiran</h2>
                                                                        <div class="clearfix"></div>
                                                                    </div>
                                                                    <div class="x_title">
                                                                    <h2>Keseluruhan</h2><div  class="pull-right">
                                                                    <? 
                                                                    ExportMenu::widget([
                                                                        'dataProvider' => $dataProvider,
                                                                        'columns' => $gridColumnsP,
                                                                        'filename' => 'laporan_myidp_pentadbiran_'.date('Y-m-d'),
                                                                        'clearBuffers' => true,
                                                                        'stream' => false,
                                                                        'folder' => '@app/web/files/myidp/.',
                                                                        'linkPath' => '/files/myidp/',
                                                                        'batchSize' => 10,
                                                        //                'deleteAfterSave' => true
                                                                    ]); 
                                                                    ?></div>
                                                                    <div class="clearfix"></div>
                                                                    
                                                                </div>
                                                                    <div class="x_content">
                                                                       <? 
                                                                                GridView::widget([
                                                                                    'dataProvider' => $dataProvider,
                                                                                    //'filterModel' => $kursusJemputan,
                                                                                    'showFooter' => true,
                                                                                    'emptyText' => 'Tiada data ditemui.',
                                                                                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                                                                                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                                                                                    'columns' => $gridColumnsP,
                                                                                ]); ?> 
                                                                    </div>  x_content 
                                                                </div>
                                                            </div>
                                                        </div>-->
                                                        <table class="table table-sm table-bordered">
                                                            <tr>
                                                                <td width="50%"><strong>JUMLAH KAKITANGAN</strong></td>
                                                                <td  class="text-center" colspan="8"><?php echo Html::a(Department::countAllStaffDeptCb(1), [""]); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>DOKTOR FALSAFAH</strong></td>
                                                                <td  class="text-center" colspan="8"><?php echo Html::a(Department::countPhd($model->id, 3), [""]); ?></td>

                                                            </tr>

                                                            <tr>
                                                                <td><strong>SARJANA </strong></td>
                                                                <td class="text-center" colspan="8"><?php echo Html::a(Department::countSarjana($model->id, 3), [""]); ?></td>

                                                            </tr>

                                                            <tr>
                                                                <td><strong>SARJANA MUDA </strong></td>
                                                                <td class="text-center" colspan="8"><?php echo Html::a(Department::countSarjanamuda($model->id, 3), [""]); ?></td>

                                                            </tr>

                                                            <tr>
                                                                <td><strong>POS BASIK</strong></td>
                                                                <td class="text-center" colspan="8"><?php echo Html::a(Department::countBasik($model->id, 3), [""], ['target' => '_blank']); ?></td>

                                                            </tr>

                                                            <tr>
                                                                <td><strong>DIPLOMA</strong></td>
                                                                <td class="text-center" colspan="8"><?php echo Html::a(Department::countDiploma($model->id, 3), [""], ['target' => '_blank']); ?></td>

                    </tr>


                </table>

            </div> <!-- x_content -->
        </div>
    </div>

</div>
