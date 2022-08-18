<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use app\models\hronline\Department;
use app\models\myidp\RptStatistikIdp;
use app\models\myidp\VIdpKumpulan;
use app\models\myidp\IdpStatistikJabatan;
use yii\bootstrap\Tabs;

echo $this->render('/idp/_topmenu');

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
                                    'value' => function ($model) {return strtoupper($model->fullname);},
                                    //'value' => 'jabatan.shortname',
                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
                                    'headerOptions' => [
                                        'style' => 'display: none;',
                                    ],
                                    'pageSummary' => '<b>JUMLAH KESELURUHAN</b>',
                                ],
                                [
                                    'label' => 'JUMLAH STAF',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function($model) use ($year){
                                        return Html::a(IdpStatistikJabatan::countStaffByDept($model->id, 0, $year), ["senarai-jabatan", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 4]);
                                        },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'headerOptions' => [
                                        'style' => 'display: none;',
                                    ],
                                    'pageSummary' => true,
                                ],
//                                [
//                                    'label' => 'JUMLAH STAF TIDAK PERLU IDP',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'center',
//                                    'format' => 'raw',
////                                    'value' => function ($model){
////                                                        return Department::countStaff($model->id, 0);
////                                                  },
//                                    'value' => function($model){
////                                        return Html::a(Department::countStaffDeptXlayak($model->id, 0), ["senarai-jabatan", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 33]);
//                                          return Department::countStaffDeptXlayak($model->id, 0);
//                                        },
//                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//                                    //'footer' => Department::getTotal(0),
////                                    'footer' => Department::getTotal($dataProvider->models, 'fieldname'),
//                                    'headerOptions' => [
//                                        'style' => 'display: none;',
//                                    ],
//                                ],
                                [
                                    'label' => 'JUMLAH',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return RptStatistikIdp::countStatistics($model->id, 0, 0);
//                                                  },
                                    'value' => function($model) use ($year){
                                                      return Html::a(IdpStatistikJabatan::countStaffByDept($model->id, 1, $year), ["senarai-jabatan", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 0]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'pageSummary' => true,
                                ],
                                [
                                    'label' => '%',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return RptStatistikIdp::countStatistics($model->id, 0, 0);
//                                                  },
                                    'value' => function($model) use ($year){
                                                      return IdpStatistikJabatan::countStaffByDept($model->id, 2, $year);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'JUMLAH',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return RptStatistikIdp::countStatistics($model->id, 0, 1);
//                                                  },
                                    'value' => function($model) use ($year){
                                                      return Html::a(IdpStatistikJabatan::countStaffByDept($model->id, 3, $year), ["senarai-jabatan", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 1]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'pageSummary' => true,
                                ],
                                [
                                    'label' => '%',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return RptStatistikIdp::countStatistics($model->id, 0, 1);
//                                                  },
                                    'value' => function($model) use ($year){
                                                      return IdpStatistikJabatan::countStaffByDept($model->id, 4, $year);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'JUMLAH',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return RptStatistikIdp::countStatistics($model->id, 0, 2);
//                                                  },
                                    'value' => function($model) use ($year){
                                                      return Html::a(IdpStatistikJabatan::countStaffByDept($model->id, 5, $year), ["senarai-jabatan", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 2]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'pageSummary' => true,
                                ],
                                [
                                    'label' => '%',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return RptStatistikIdp::countStatistics($model->id, 0, 2);
//                                                  },
                                    'value' => function($model) use ($year){
                                                      return IdpStatistikJabatan::countStaffByDept($model->id, 6, $year);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
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
                <h2>Statistik Pencapaian Mata IDP Staf (JAFPIB)</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                
                <?= Tabs::widget([
                            'items' => [
                                [
                                    'label' => 'JAFPIB',
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
                                                'showPageSummary' => false,
                                                'emptyText' => 'Tiada data ditemui.',
                                                'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                                                'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                                                'beforeHeader' => [
                                                    [
                                                        'columns' => [
                                                            ['content' => 'BIL', 'options' => ['colspan' => 1, 'rowspan' => 2], 
                                                                'vAlign' => 'middle',
                                                                'hAlign' => 'center'],
                                                            ['content' => 'JAFPIB', 'options' => ['colspan' => 1, 'rowspan' => 2]],
                                                            ['content' => 'JUMLAH STAF', 'options' => ['colspan' => 1, 'rowspan' => 2],
                                                                'vAlign' => 'middle',
                                                                'hAlign' => 'center'],
//                                                            ['content' => 'JUMLAH STAF <br> TIDAK PERLU IDP', 'options' => ['colspan' => 1, 'rowspan' => 2],
//                                                                'vAlign' => 'middle',
//                                                                'hAlign' => 'center'],
                                                            ['content' => 'CAPAI IDP MINIMUM', 'options' => ['colspan' => 2]],
                                                            ['content' => 'BELUM CAPAI IDP MINIMUM', 'options' => ['colspan' => 2]],
                                                            ['content' => 'BELUM ADA MATA IDP', 'options' => ['colspan' => 2]],
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