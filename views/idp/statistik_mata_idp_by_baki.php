<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use app\models\hronline\Kumpulankhidmat;
use app\models\myidp\RptStatistikIdp;
use app\models\myidp\VIdpKumpulan;
use yii\bootstrap\Tabs;

echo $this->render('/idp/_topmenu');

error_reporting(0);
                                                  
$gridColumnsK = [
                                ['class' => 'kartik\grid\SerialColumn',
                                    'header' => 'Bil',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                ],
                                [
                                    'label' => 'KUMPULAN',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'left',
                                    'format' => 'raw',
                                    'value' => function ($model) {return strtoupper($model->name);},
                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'JUMLAH STAF',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return Kumpulankhidmat::countStaff($model->id, 0);
//                                                  },
                                    'value' => function($model){
                                        return Html::a(Kumpulankhidmat::countStaff($model->id, 0, date('Y')), ["senarai-baki", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 44]);
                                        },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    //'footer' => Kumpulankhidmat::getTotal(0),
//                                    'footer' => Kumpulankhidmat::getTotal($dataProvider->models, 'fieldname'),
                                ],
                                [
                                    'label' => 'BAKI (1-3)',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function($model){
                                                      return Html::a(RptStatistikIdp::countStatisticsBalance($model->id, 0, 0), ["senarai-baki", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 0]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'BAKI (4-6)',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function($model){
                                                      return Html::a(RptStatistikIdp::countStatisticsBalance($model->id, 0, 4), ["senarai-baki", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 4]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'BAKI (7-12)',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function($model){
                                                      return Html::a(RptStatistikIdp::countStatisticsBalance($model->id, 0, 7), ["senarai-baki", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 7]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'BAKI (13-18)',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function($model){
                                                      return Html::a(RptStatistikIdp::countStatisticsBalance($model->id, 0, 13), ["senarai-baki", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 13]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'BAKI (19-24)',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function($model){
                                                      return Html::a(RptStatistikIdp::countStatisticsBalance($model->id, 0, 19), ["senarai-baki", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 19]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'BAKI (25-30)',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function($model){
                                                      return Html::a(RptStatistikIdp::countStatisticsBalance($model->id, 0, 25), ["senarai-baki", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 25]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'BAKI (31-36)',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function($model){
                                                      return Html::a(RptStatistikIdp::countStatisticsBalance($model->id, 0, 31), ["senarai-baki", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 31]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'BAKI (37-42)',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function($model){
                                                      return Html::a(RptStatistikIdp::countStatisticsBalance($model->id, 0, 37), ["senarai-baki", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 37]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
//                                [
//                                    'label' => 'BELUM CAPAI IDP MINIMUM',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'center',
//                                    'format' => 'raw',
////                                    'value' => function ($model){
////                                                        return RptStatistikIdp::countStatistics($model->id, 0, 1);
////                                                  },
//                                    'value' => function($model){
//                                                      return Html::a(RptStatistikIdp::countStatistics($model->id, 0, 1), ["senarai", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 1]);
//                                                },
//                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//                                ],
//                                [
//                                    'label' => 'BELUM ADA MATA IDP',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'center',
//                                    'format' => 'raw',
////                                    'value' => function ($model){
////                                                        return RptStatistikIdp::countStatistics($model->id, 0, 2);
////                                                  },
//                                    'value' => function($model){
//                                                      return Html::a(RptStatistikIdp::countStatistics($model->id, 0, 2), ["senarai", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 2]);
//                                                },
//                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//                                ],
                               
                            ];
                                                  
//$gridColumnsA = [
//                                ['class' => 'kartik\grid\SerialColumn',
//                                    'header' => 'Bil',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'center',
//                                ],
//                                [
//                                    'label' => 'KUMPULAN',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'left',
//                                    'format' => 'raw',
//                                    'value' => 'vckl_nama_kumpulan',
//                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
//                                ],
//                                [
//                                    'label' => 'JUMLAH STAF',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'center',
//                                    'format' => 'raw',
////                                    'value' => function ($model){
////                                                        return Kumpulankhidmat::countStaff($model->vckl_kod_kumpulan, 1);
////                                                  },
//                                    'value' => function($model){
//                                        return Html::a(Kumpulankhidmat::countStaff($model->vckl_kod_kumpulan, 1), ["senarai", 'kumpulan' => $model->vckl_kod_kumpulan, 'category' => 1, 'calctype' => 4]);
//                                        },                           
//                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//                                    //'footer' => Kumpulankhidmat::getTotal(0),
////                                    'footer' => Kumpulankhidmat::getTotal($dataProvider->models, 'fieldname'),
//                                ],
//                                [
//                                    'label' => 'CAPAI IDP MINIMUM',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'center',
//                                    'format' => 'raw',
////                                    'value' => function ($model){
////                                                        return RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 1, 0);
////                                                  },
//                                    'value' => function($model){
//                                                      return Html::a(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 1, 0), ["senarai", 'kumpulan' => $model->vckl_kod_kumpulan, 'category' => 1, 'calctype' => 0]);
//                                                },
//                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//                                ],
//                                [
//                                    'label' => 'BELUM CAPAI IDP MINIMUM',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'center',
//                                    'format' => 'raw',
////                                    'value' => function ($model){
////                                                        return RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 1, 1);
////                                                  },
//                                    'value' => function($model){
//                                                      return Html::a(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 1, 1), ["senarai", 'kumpulan' => $model->vckl_kod_kumpulan, 'category' => 1, 'calctype' => 1]);
//                                                },
//                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//                                ],
//                                [
//                                    'label' => 'BELUM ADA MATA IDP',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'center',
//                                    'format' => 'raw',
////                                    'value' => function ($model){
////                                                        return RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 1, 2);
////                                                  },
//                                    'value' => function($model){
//                                                      return Html::a(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 1, 2), ["senarai", 'kumpulan' => $model->vckl_kod_kumpulan, 'category' => 1, 'calctype' => 2]);
//                                                },
//                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//                                ],
                               
//                            ];
                                                  
//$gridColumnsP = [
//                                ['class' => 'kartik\grid\SerialColumn',
//                                    'header' => 'Bil',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'center',
//                                ],
//                                [
//                                    'label' => 'KUMPULAN',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'left',
//                                    'format' => 'raw',
//                                    'value' => 'vckl_nama_kumpulan',
//                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
//                                ],
//                                [
//                                    'label' => 'JUMLAH STAF',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'center',
//                                    'format' => 'raw',
////                                    'value' => function ($model){
////                                                        return Kumpulankhidmat::countStaff($model->vckl_kod_kumpulan, 2);
////                                                  },
//                                    'value' => function($model){
//                                        return Html::a(Kumpulankhidmat::countStaff($model->vckl_kod_kumpulan, 2), ["senarai", 'kumpulan' => $model->vckl_kod_kumpulan, 'category' => 2, 'calctype' => 4]);
//                                        },
//                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//                                    //'footer' => Kumpulankhidmat::getTotal(0),
////                                    'footer' => Kumpulankhidmat::getTotal($dataProvider->models, 'fieldname'),
//                                ],
//                                [
//                                    'label' => 'CAPAI IDP MINIMUM',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'center',
//                                    'format' => 'raw',
////                                    'value' => function ($model){
////                                                        return RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 2, 0);
////                                                  },
//                                    'value' => function($model){
//                                                      return Html::a(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 2, 0), ["senarai", 'kumpulan' => $model->vckl_kod_kumpulan, 'category' => 2, 'calctype' => 0]);
//                                                },
//                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//                                ],
//                                [
//                                    'label' => 'BELUM CAPAI IDP MINIMUM',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'center',
//                                    'format' => 'raw',
////                                    'value' => function ($model){
////                                                        return RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 2, 1);
////                                                  },
//                                    'value' => function($model){
//                                                      return Html::a(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 2, 1), ["senarai", 'kumpulan' => $model->vckl_kod_kumpulan, 'category' => 2, 'calctype' => 1]);
//                                                },
//                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//                                ],
//                                [
//                                    'label' => 'BELUM ADA MATA IDP',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'center',
//                                    'format' => 'raw',
////                                    'value' => function ($model){
////                                                        return RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 2, 2);
////                                                  },
//                                    'value' => function($model){
//                                                      return Html::a(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 2, 2), ["senarai", 'kumpulan' => $model->vckl_kod_kumpulan, 'category' => 2, 'calctype' => 2]);
//                                                },
//                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//                                ],
                               
//                            ];
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
                <h2>Statistik Pencapaian Mata IDP Staf</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                
                <?= Tabs::widget([
                            'items' => [
                                [
                                    'label' => 'KESELURUHAN',
                                    'content' => ExportMenu::widget([
                                        'dataProvider' => $dataProvider,
                                        'columns' => $gridColumnsK,
                                        'filename' => 'laporan_myidp_'.date('Y-m-d'),
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
                                                'columns' => $gridColumnsK,
                                            ]),
                                    'active' => true
                                ],
//                                [
//                                    'label' => 'AKADEMIK',
//                                    'content' => ExportMenu::widget([
//                                        'dataProvider' => $dataProvider2,
//                                        'columns' => $gridColumnsA,
//                                        'filename' => 'laporan_myidp_'.date('Y-m-d'),
//                                        'clearBuffers' => true,
//                                        'stream' => false,
//                                        'folder' => '@app/web/files/myidp/.',
//                                        'linkPath' => '/files/myidp/',
//                                        'batchSize' => 10,
//                        //                'deleteAfterSave' => true
//                                    ]).'<br><br>'.
//                                            GridView::widget([
//                                                'dataProvider' => $dataProvider2,
//                                                //'filterModel' => $kursusJemputan,
//                                                'showFooter' => true,
//                                                'emptyText' => 'Tiada data ditemui.',
//                                                'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
//                                                'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
//                                                'columns' => $gridColumnsA,
//                                            ]),
//                                    //'headerOptions' => [...],
//                                    //'options' => ['id' => 'myveryownID'],
//                                ],
//                                [
//                                    'label' => 'PENTADBIRAN',
//                                    'content' => ExportMenu::widget([
//                                        'dataProvider' => $dataProvider3,
//                                        'columns' => $gridColumnsP,
//                                        'filename' => 'laporan_myidp_'.date('Y-m-d'),
//                                        'clearBuffers' => true,
//                                        'stream' => false,
//                                        'folder' => '@app/web/files/myidp/.',
//                                        'linkPath' => '/files/myidp/',
//                                        'batchSize' => 10,
//                        //                'deleteAfterSave' => true
//                                    ]).'<br><br>'.
//                                            GridView::widget([
//                                                'dataProvider' => $dataProvider3,
//                                                //'filterModel' => $kursusJemputan,
//                                                'showFooter' => true,
//                                                'emptyText' => 'Tiada data ditemui.',
//                                                'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
//                                                'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
//                                                'columns' => $gridColumnsP,
//                                            ]),
//                                    //'headerOptions' => [...],
//                                    //'options' => ['id' => 'myveryownID'],
//                                ],
//                                [
//                                    'label' => 'Example',
//                                    'url' => 'http://www.example.com',
//                                ],
//                                [
//                                    'label' => 'Dropdown',
//                                    'items' => [
//                                         [
//                                             'label' => 'DropdownA',
//                                             'content' => 'DropdownA, Anim pariatur cliche...',
//                                         ],
//                                         [
//                                             'label' => 'DropdownB',
//                                             'content' => 'DropdownB, Anim pariatur cliche...',
//                                         ],
//                                         [
//                                             'label' => 'External Link',
//                                             'url' => 'http://www.example.com',
//                                         ],
//                                    ],
//                                ],
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


            </div> <!-- x_content -->
        </div>
    </div>
</div>