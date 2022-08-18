<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use app\models\hronline\GredJawatan;
use app\models\myidp\RptStatistikIdp;
use app\models\myidp\VIdpKumpulan;
use yii\bootstrap\Tabs;

echo $this->render('/idp/_topmenu');

error_reporting(0);
                                                  
$gridColumnsK = [
    
                    [
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions'=>['class'=>'kartik-sheet-style'],
                                    'header' => 'BIL',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'headerOptions' => [
                                        'style' => 'display: none;',
                                    ],
                    ],
                    [
                                    'label' => 'SKIM',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'left',
                                    'format' => 'raw',
                                    'value' => function ($model) {return strtoupper($model->gred_skim);},
                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
                                    'headerOptions' => [
                                        'style' => 'display: none;',
                                    ],
                    ],
                    [
                                    'label' => 'PELAKSANA',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return Kumpulankhidmat::countStaff($model->id, 0);
//                                                  },
                                    'value' => function($model){
                                                return Html::a(GredJawatan::countStaffByScheme($model->gred_skim, 1), ["statistik-senarai", 'id' => '10', 'scheme' => $model->gred_skim]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    //'footer' => Kumpulankhidmat::getTotal(0),
//                                    'footer' => Kumpulankhidmat::getTotal($dataProvider->models, 'fieldname'),
//                                    'headerOptions' => [
//                                        'colspan' => '2',
//                                    ]
                    ],
                    [
                                    'label' => 'P&P',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return Kumpulankhidmat::countStaff($model->id, 0);
//                                                  },
                                    'value' => function($model){
                                                return Html::a(GredJawatan::countStaffByScheme($model->gred_skim, 2), ["statistik-senarai", 'id' => '11', 'scheme' => $model->gred_skim]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    //'footer' => Kumpulankhidmat::getTotal(0),
//                                    'footer' => Kumpulankhidmat::getTotal($dataProvider->models, 'fieldname'),
//                                    'headerOptions' => [
//                                        'style' => 'display: none;',
//                                    ],
                    ],
                    [
                                    'label' => 'PELAKSANA',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return Kumpulankhidmat::countStaff($model->id, 0);
//                                                  },
                                    'value' => function($model){
                                                      return Html::a(RptStatistikIdp::countStatisticsByComponent($model->gred_skim, 1, 1, 5), ["statistik-senarai", 'id' => '1', 'scheme' => $model->gred_skim]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    //'footer' => Kumpulankhidmat::getTotal(0),
//                                    'footer' => Kumpulankhidmat::getTotal($dataProvider->models, 'fieldname'),
//                                    'headerOptions' => [
//                                        'colspan' => '2',
//                                    ]
                    ],
                    [
                                    'label' => '%',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return Kumpulankhidmat::countStaff($model->id, 0);
//                                                  },
                                    'value' => function($model){
                                                      return RptStatistikIdp::countStatisticsByComponent($model->gred_skim, 1, 2, 5);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    //'footer' => Kumpulankhidmat::getTotal(0),
//                                    'footer' => Kumpulankhidmat::getTotal($dataProvider->models, 'fieldname'),
//                                    'headerOptions' => [
//                                        'style' => 'display: none;',
//                                    ],
                    ],
                    [
                                    'label' => 'P&P',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return Kumpulankhidmat::countStaff($model->id, 0);
//                                                  },
                                    'value' => function($model){
                                                      return Html::a(RptStatistikIdp::countStatisticsByComponent($model->gred_skim, 2, 1, 5), ["statistik-senarai", 'id' => '2', 'scheme' => $model->gred_skim]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    //'footer' => Kumpulankhidmat::getTotal(0),
//                                    'footer' => Kumpulankhidmat::getTotal($dataProvider->models, 'fieldname'),
//                                    'headerOptions' => [
//                                        'colspan' => '2',
//                                    ]
                    ],
                    [
                                    'label' => '%',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return Kumpulankhidmat::countStaff($model->id, 0);
//                                                  },
                                    'value' => function($model){
                                                      return RptStatistikIdp::countStatisticsByComponent($model->gred_skim, 2, 2, 5);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    //'footer' => Kumpulankhidmat::getTotal(0),
//                                    'footer' => Kumpulankhidmat::getTotal($dataProvider->models, 'fieldname'),
//                                    'headerOptions' => [
//                                        'style' => 'display: none;',
//                                    ],
                    ],
                    [
                                    'label' => 'PELAKSANA',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return Kumpulankhidmat::countStaff($model->id, 0);
//                                                  },
                                    'value' => function($model){
                                                      return Html::a(RptStatistikIdp::countStatisticsByComponent($model->gred_skim, 1, 1, 6), ["statistik-senarai", 'id' => '3', 'scheme' => $model->gred_skim]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    //'footer' => Kumpulankhidmat::getTotal(0),
//                                    'footer' => Kumpulankhidmat::getTotal($dataProvider->models, 'fieldname'),
//                                    'headerOptions' => [
//                                        'colspan' => '2',
//                                    ]
                    ],
                    [
                                    'label' => '%',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return Kumpulankhidmat::countStaff($model->id, 0);
//                                                  },
                                    'value' => function($model){
                                                      return RptStatistikIdp::countStatisticsByComponent($model->gred_skim, 1, 2, 6);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    //'footer' => Kumpulankhidmat::getTotal(0),
//                                    'footer' => Kumpulankhidmat::getTotal($dataProvider->models, 'fieldname'),
//                                    'headerOptions' => [
//                                        'style' => 'display: none;',
//                                    ],
                    ],
                    [
                                    'label' => 'P&P',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return Kumpulankhidmat::countStaff($model->id, 0);
//                                                  },
                                    'value' => function($model){
                                                      return Html::a(RptStatistikIdp::countStatisticsByComponent($model->gred_skim, 2, 1, 6), ["statistik-senarai", 'id' => '4', 'scheme' => $model->gred_skim]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    //'footer' => Kumpulankhidmat::getTotal(0),
//                                    'footer' => Kumpulankhidmat::getTotal($dataProvider->models, 'fieldname'),
//                                    'headerOptions' => [
//                                        'colspan' => '2',
//                                    ]
                    ],
                    [
                                    'label' => '%',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return Kumpulankhidmat::countStaff($model->id, 0);
//                                                  },
                                    'value' => function($model){
                                                      return RptStatistikIdp::countStatisticsByComponent($model->gred_skim, 2, 2, 6);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    //'footer' => Kumpulankhidmat::getTotal(0),
//                                    'footer' => Kumpulankhidmat::getTotal($dataProvider->models, 'fieldname'),
//                                    'headerOptions' => [
//                                        'style' => 'display: none;',
//                                    ],
                    ],
                    [
                                    'label' => 'PELAKSANA',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return Kumpulankhidmat::countStaff($model->id, 0);
//                                                  },
                                    'value' => function($model){
                                                      return Html::a(RptStatistikIdp::countStatisticsByComponent($model->gred_skim, 1, 1, 4), ["statistik-senarai", 'id' => '5', 'scheme' => $model->gred_skim]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    //'footer' => Kumpulankhidmat::getTotal(0),
//                                    'footer' => Kumpulankhidmat::getTotal($dataProvider->models, 'fieldname'),
//                                    'headerOptions' => [
//                                        'colspan' => '2',
//                                    ]
                    ],
                    [
                                    'label' => '%',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return Kumpulankhidmat::countStaff($model->id, 0);
//                                                  },
                                    'value' => function($model){
                                                      return RptStatistikIdp::countStatisticsByComponent($model->gred_skim, 1, 2, 4);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    //'footer' => Kumpulankhidmat::getTotal(0),
//                                    'footer' => Kumpulankhidmat::getTotal($dataProvider->models, 'fieldname'),
//                                    'headerOptions' => [
//                                        'style' => 'display: none;',
//                                    ],
                    ],
                    [
                                    'label' => 'P&P',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return Kumpulankhidmat::countStaff($model->id, 0);
//                                                  },
                                    'value' => function($model){
                                                      return Html::a(RptStatistikIdp::countStatisticsByComponent($model->gred_skim, 2, 1, 4), ["statistik-senarai", 'id' => '6', 'scheme' => $model->gred_skim]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    //'footer' => Kumpulankhidmat::getTotal(0),
//                                    'footer' => Kumpulankhidmat::getTotal($dataProvider->models, 'fieldname'),
//                                    'headerOptions' => [
//                                        'colspan' => '2',
//                                    ]
                    ],
                    [
                                    'label' => '%',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return Kumpulankhidmat::countStaff($model->id, 0);
//                                                  },
                                    'value' => function($model){
                                                      return RptStatistikIdp::countStatisticsByComponent($model->gred_skim, 2, 2, 4);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    //'footer' => Kumpulankhidmat::getTotal(0),
//                                    'footer' => Kumpulankhidmat::getTotal($dataProvider->models, 'fieldname'),
//                                    'headerOptions' => [
//                                        'style' => 'display: none;',
//                                    ],
                    ],
                               
];
?>
<!---- Hide previous modal screen ---->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#modal").on('hidden.bs.modal', function(){
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
            <h5>Laporan Statistik<h3><span class="label label-default" style="color: white">Statistik Staf Pentadbiran Yang Tidak Cukup Mata IDP Mengikut Komponen</span></h3></h5>
            <div class="clearfix"></div>
        </div>
            <div class="x_content">
                
                <?= Tabs::widget([
                            'items' => [
                                [
                                    'label' => 'PENTADBIRAN',
                                    'content' => ExportMenu::widget([
                                        'dataProvider' => $dataProvider,
                                        'beforeHeader' => [
                                                    [
                                                        'columns' => [
                                                            ['content' => 'BIL', 'options' => ['colspan' => 1, 'rowspan' => 2], 
                                                                'vAlign' => 'middle',
                                                                'hAlign' => 'center'],
                                                            ['content' => 'SKIM', 'options' => ['colspan' => 1, 'rowspan' => 2]],
                                                            ['content' => 'JUMLAH', 'options' => ['colspan' => 2],
                                                                'vAlign' => 'middle',
                                                                'hAlign' => 'center'],
                                                            ['content' => 'TERAS UNIVERSITI', 'options' => ['colspan' => 4]],
                                                            ['content' => 'TERAS SKIM', 'options' => ['colspan' => 4]],
                                                            ['content' => 'ELEKTIF', 'options' => ['colspan' => 4]],
                                                            //['content' => 'Date', 'options' => ['colspan' => 2, 'class' => 'text-center warning']],
                                                        ],
                                                    ]
                                                ],
                                        'columns' => $gridColumnsK,
                                        'filename' => 'Statistik Staf Pentadbiran Yang Tidak Mencukupi Mata IDP Mengikut Komponen - '.date('Y-m-d'),
                                        'clearBuffers' => true,
                                        'stream' => false,
                                        'folder' => '@app/web/files/myidp/.',
                                        'linkPath' => '/files/myidp/',
                                        'batchSize' => 10,
                        //                'deleteAfterSave' => true
                                    ]).'<br><br>'.
                                    GridView::widget([
                                                'dataProvider' => $dataProvider,
                                                //'filterModel' => $kursusJemputan,
                                                'showFooter' => true,
                                                'emptyText' => 'Tiada data ditemui.',
                                                'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                                                'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                                                'beforeHeader' => [
                                                    [
                                                        'columns' => [
                                                            ['content' => 'BIL', 'options' => ['colspan' => 1, 'rowspan' => 2], 
                                                                'vAlign' => 'middle',
                                                                'hAlign' => 'center'],
                                                            ['content' => 'SKIM', 'options' => ['colspan' => 1, 'rowspan' => 2]],
                                                            ['content' => 'JUMLAH', 'options' => ['colspan' => 2],
                                                                'vAlign' => 'middle',
                                                                'hAlign' => 'center'],
                                                            ['content' => 'TERAS UNIVERSITI', 'options' => ['colspan' => 4]],
                                                            ['content' => 'TERAS SKIM', 'options' => ['colspan' => 4]],
                                                            ['content' => 'ELEKTIF', 'options' => ['colspan' => 4]],
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

            </div> <!-- x_content -->
        </div>
    </div>
</div>