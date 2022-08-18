<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use app\models\hronline\Department;
use app\models\myidp\RptStatistikIdp;
use app\models\cbelajar\TblLkk;
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
            return Html::a(Department::countStaffDeptCb($model->id, 0), ["senarai-all", 'kumpulan' => $model->id, 'category' => 0], ['target' => '_blank']);
        },
                'contentOptions' => ['class' => 'text-center', 'style' => 'width:150px; white-space: normal;'],
                'headerOptions' => [
                    'style' => 'display: none;',
                ],
                'vAlign' => 'middle',
                'hAlign' => 'center'
            ],
            [
                'attribute' => 'check',
                'label' => 'YA <span class="fa fa-check">',
                'encodeLabel' => false,
//                                    'label' => 'JUMLAH',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
//                                    'value' => function ($model){
//                                                      return Html::a(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 1, 0), ["senarai", 'kumpulan' => $model->vckl_kod_kumpulan, 'category' => 1, 'calctype' => 0]);
//                                                },
                'value' => function ($model) use ($tahun) {
//            return Department::countProposalDefense($model->id, 0);
                    return Html::a(TblLkk::countProposalDefense($model->id, 0), ["senarai-proposal-defense", 'kumpulan' => $model->id, 'category' => 0]);
                },
                        'headerOptions' => ['class' => 'text-center success'],
                        'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                    ],
                    [
                        'attribute' => 'times',
                        'label' => 'TIDAK <span class="fa fa-times">',
                        'encodeLabel' => false,
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 1, 0);
//                                                  },
                        'value' => function ($model) use ($tahun) {
                            return Html::a(TblLkk::countNoProposalDefense($model->id, 0), ["senarai-no-proposal-defense", 'kumpulan' => $model->id, 'category' => 0]);
                        },
                                'headerOptions' => ['class' => 'text-center danger'],
                                'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                            ],
                                [
        'label' => 'BELUM HANTAR PD',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'raw',
        'value' => function ($model) {
            return Html::a((Department::countStaffDeptCb($model->id, 0) -(TblLkk::countNoProposalDefense($model->id, 0)+TblLkk::countProposalDefense($model->id, 0))) , ["senarai-belum-hantar-pd", 'kumpulan' => $model->id, 'category' => 0], ['target' => '_blank']);
        },
                'contentOptions' => ['class' => 'text-center', 'style' => 'width:150px; white-space: normal;'],
                'headerOptions' => [
                    'style' => 'display: none;',
                ],
                'vAlign' => 'middle',
                'hAlign' => 'center'
            ],
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
                                        <h5>STATISTIK PENGHANTARAN LAPORAN KEMAJUAN PENGAJIAN KAKITANGAN AKADEMIK (FPIB)</h5>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">

                        <?=
                        Tabs::widget([
                            'items' => [
                                [
                                    'label' => 'AFPIU',
                                    'content' => ExportMenu::widget([
                                        'dataProvider' => $dataProvider,
                                        'columns' => $gridColumnsK,
                                        'filename' => 'laporan_lkp_'. date('Y-m-d'),
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
                                                    ['content' => 'BIL', 'options' => ['colspan' => 1, 'rowspan' => 2, 'class' => 'text-center info'],
                                                        'vAlign' => 'middle',
                                                        'hAlign' => 'center'],
                                                    ['content' => 'AFPIB', 'options' => ['colspan' => 1, 'rowspan' => 2, 'class' => 'text-center warning']],
                                                    ['content' => 'JUMLAH KAKITANGAN',
                                                        'options' => ['colspan' => 1, 'rowspan' => 2, 'class' => 'text-center info',],
                                                        'vAlign' => 'middle',
                                                        'hAlign' => 'center'],
                                                    ['content' => 'PROPOSAL DEFENSE', 'options' => ['colspan' => 2, 'class' => 'text-center info']],
                                                    ['content' => 'BELUM HANTAR PD', 'options' => ['colspan' => 2,'class' => 'text-center info']],
                                                //['content' => 'Date', 'options' => ['colspan' => 2, 'class' => 'text-center warning']],
                                                ],
                                            ]
                                        ],
                                        'columns' => $gridColumnsK,
                                    ]),
                                    'active' => true
                                ],
                            ],
                            'items' => [
                                [
                                    'label' => 'AFPIU',
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
                                                    ['content' => 'BIL', 'options' => ['colspan' => 1, 'rowspan' => 2, 'class' => 'text-center info'],
                                                        'vAlign' => 'middle',
                                                        'hAlign' => 'center'],
                                                    ['content' => 'AFPIB', 'options' => ['colspan' => 1, 'rowspan' => 2, 'class' => 'text-center warning']],
                                                    ['content' => 'JUMLAH KAKITANGAN',
                                                        'options' => ['colspan' => 1, 'rowspan' => 2, 'class' => 'text-center info',],
                                                        'vAlign' => 'middle',
                                                        'hAlign' => 'center'],
                                                    ['content' => 'PROPOSAL DEFENSE', 'options' => ['colspan' => 2, 'class' => 'text-center info']],
                                            ['content' => 'BELUM HANTAR PD', 'options' => ['colspan' => 1,'rowspan' => 2,'class' => 'text-center info']],
                                                //['content' => 'Date', 'options' => ['colspan' => 2, 'class' => 'text-center warning']],
                                                ],
                                            ]
                                        ],
                                        'columns' => $gridColumnsK,
                                    ]),
                                ],
                            ],
                        ]);
                        ?>
<table class="table table-sm table-bordered">
                <tr>
                    <td ><strong>JUMLAH KESELURUHAN KAKITANGAN YANG DILULUSKAN PENGAJIAN LANJUTAN</strong></td>
                    <td  class="text-center" width="40%"><?php echo Html::a(Department::countAllStaffDeptCb( 0), ["senarai-all-study", 'category' => 0], ['target' => '_blank']);?></td>
                </tr>
<!--                  <tr>
                        <td><strong> BELUM HANTAR<i class="style=color:green;">  PROPOSAL DEFENSE</i></strong></td>
                         <td class="text-center" colspan="4">
                             <?// Department::countAllStaffDeptCb(0) - (Department::countNoDefense( 0) +Department::countAllPd( 0));?>

                </tr>-->
                    <tr>
                        <td><strong> <i class="style=color:green;">PASS PROPOSAL DEFENSE</i></strong></td>
                        <td  class="text-center" colspan="4"><?php echo Html::a(TblLkk::countAllPd( 0), ["senarai-pass-pd",  'category' => 0], ['target' => '_blank']);?></td>

                </tr>
                <tr>
                        <td><strong> <i class="style=color:green;">NO/NOT PASS PROPOSAL DEFENSE</i></strong></td>
                        <td class="text-center" colspan="4"><?php echo Html::a(TblLkk::countNoDefense( 0), ["senarai-no-pd", 'category' => 0], ['target' => '_blank']);?></td>

                </tr>
                
               
                 <tr>
                    <td><strong> <i class="style=color:green;">BELUM HANTAR PROPOSAL DEFENSE:</i></strong>*<br>
                        <small>* TIADA REKOD MAKLUMAN KEPUTUSAN PROPOSAL DEFENSE<br>(SARJANA KEPAKARAN DIKECUALIKAN)<br>
                              </small></td>
                              <td  class="text-center" colspan="4"> 
                                    <?= Html::a(((TblLkk::countNoRecord($model->id, 0))) , ["lkk/tiada-rekod-pd"], ['target' => '_blank']);?>

                       
                              </td>
                </tr>
                <tr>
                    <td><strong> <i class="style=color:green;">BELUM CAPAI TEMPOH ENAM (6) BULAN:</i></strong>*<br>
                        <small>* PENGHANTARAN LKP BELUM DIMULAKAN<br>
                              </small></td>
                              <td  class="text-center" colspan="4"> 
                          <?= Html::a(((app\models\cbelajar\TblPengajian::countBelumCapai($model->id, 0))) , ["cbadmin/mula-pengajian"], ['target' => '_blank']);?>

                              </td>
                </tr>
                
                
              
                </table>
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


            </div> <!-- x_content -->
        </div>
    </div>
</div>