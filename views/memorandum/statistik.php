<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use app\models\memorandum\TblRekod;
use yii\bootstrap\Tabs;



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
        'label' => 'JAFPIB',
        'vAlign' => 'middle',
        'hAlign' => 'left',
        'format' => 'raw',
        'value' => function ($model) {
            return strtoupper($model->fullname);
        },
        'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
        'headerOptions' => [
            'style' => 'display: none;', 'class' => 'text-center success'
        ],
    ],
    
            [
                'attribute' => 'check',
                'label' => 'INDEX SELESAI <span class="fa fa-check">',
                'encodeLabel' => false,
//                                    'label' => 'JUMLAH',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
//                                    'value' => function ($model){
//                                                      return Html::a(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 1, 0), ["senarai", 'kumpulan' => $model->vckl_kod_kumpulan, 'category' => 1, 'calctype' => 0]);
//                                                },
                'value' => function ($model)  {
//            return Department::countProposalDefense($model->id, 0);
                    return Html::a(TblRekod::countSelesai($model->id, 0));
                },
                        'headerOptions' => ['class' => 'text-center success'],
                        'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                    ],
                    [
                        'attribute' => 'times',
                        'label' => 'INDEX BELUM SELESAI <span class="fa fa-times">',
                        'encodeLabel' => false,
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 1, 0);
//                                                  },
                        'value' => function ($model)  {
                            return Html::a(TblRekod::countBelumSelesai($model->id, 0));
                        },
                                'headerOptions' => ['class' => 'text-center danger'],
                                'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                            ],
                                

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
                                             <h5><i class="fa fa-briefcase"></i> Jumlah Memorandum Mengikut JAFPIB</h5>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">

                        <?=
                       // GridView::widget([
                         //   'items' => [
                            //    [
                               //     'label' => 'JAFPIB',
                               //     'content' => 
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
                                                    ['content' => 'JAFPIB', 'options' => ['colspan' => 1, 'rowspan' => 2, 'class' => 'text-center warning']],
                                                    
                                                    ['content' => 'STATUS', 'options' => ['colspan' => 4, 'class' => 'text-center info']],
                                                //['content' => 'Date', 'options' => ['colspan' => 2, 'class' => 'text-center warning']],
                                                ],
                                            ]
                                        ],
                                        'columns' => $gridColumnsK,
                                    ]);
                                //    'active' => true
                             //   ],
                          //  ],
                          
                     //   ]);
                        ?>



            </div> <!-- x_content -->
        </div>
    </div>
</div>