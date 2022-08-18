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
use app\models\myidp\TblYears;

echo $this->render('/idp/_topmenu');

error_reporting(0);

$gridColumnsP = [
                                ['class' => 'kartik\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'headerOptions' => [
                                        'style' => 'display: none;',
                                    ],
                                ],
                                [
                                    'label' => 'KUMPULAN',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'left',
                                    'format' => 'raw',
                                    'value' => 'vckl_nama_kumpulan',
                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
                                    'headerOptions' => [
                                        'style' => 'display: none;',
                                    ],
                                ],
                                [
                                    'label' => 'JUMLAH STAF',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function ($model) use ($tahun){
                                        
                                        return Html::a(Kumpulankhidmat::countStaff($model->vckl_kod_kumpulan, 2, $tahun), ["senarai", 'kumpulan' => $model->vckl_kod_kumpulan, 'category' => 2, 'calctype' => 4, 'tahun' => $tahun]);
                                        //return "";
                                            
                                    },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    //'footer' => Kumpulankhidmat::getTotal(0),
//                                    'footer' => Kumpulankhidmat::getTotal($dataProvider->models, 'fieldname'),
                                    'headerOptions' => [
                                        'style' => 'display: none;',
                                    ],
                                ],
                                [
                                    'label' => 'JUMLAH',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function ($model) use ($tahun){
                                                      return Html::a(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 2, 0, $tahun), ["senarai", 'kumpulan' => $model->vckl_kod_kumpulan, 'category' => 2, 'calctype' => 0, 'tahun' => $tahun]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '%',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function ($model) use ($tahun){
                                                      return round(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 2, 0, $tahun)/Kumpulankhidmat::countStaff($model->vckl_kod_kumpulan, 2, $tahun)*100);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'JUMLAH',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'value' => function ($model){
//                                                        return RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 2, 1);
//                                                  },
                                    'value' => function ($model) use ($tahun){
                                                      return Html::a(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 2, 1, $tahun), ["senarai", 'kumpulan' => $model->vckl_kod_kumpulan, 'category' => 2, 'calctype' => 1, 'tahun' => $tahun]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '%',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function ($model) use ($tahun){
                                                      return round(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 2, 1, $tahun)/Kumpulankhidmat::countStaff($model->vckl_kod_kumpulan, 2, $tahun)*100);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'JUMLAH',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function ($model) use ($tahun){
                                                      return Html::a(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 2, 2, $tahun), ["senarai", 'kumpulan' => $model->vckl_kod_kumpulan, 'category' => 2, 'calctype' => 2, 'tahun' => $tahun]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '%',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function ($model) use ($tahun){
                                                      return round(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan, 2, 2, $tahun)/Kumpulankhidmat::countStaff($model->vckl_kod_kumpulan, 2, $tahun)*100);
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
                    'id' => 'pantau-kehadiran',
                    //                            'options' => ['class' => 'form-horizontal'],
                    'action' => ['idp/statistik-pentadbiran'],
                    'method' => 'get',
                ])
                ?>

                <div class="col-xs-6 col-md-3 col-lg-2">

                    <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::findAll(['admin_status' => 1]), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                </div>
                
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
                <h2>Statistik Pencapaian Mata IDP Staf (Pentadbiran)</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                
                <?= Tabs::widget([
                            'items' => [
                                [
                                    'label' => 'PENTADBIRAN',
                                    'content' => ExportMenu::widget([
                                        'dataProvider' => $dataProvider,
                                        'columns' => $gridColumnsP,
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
                                                'beforeHeader' => [
                                                    [
                                                        'columns' => [
                                                            ['content' => 'BIL', 'options' => ['colspan' => 1, 'rowspan' => 2], 
                                                                'vAlign' => 'middle',
                                                                'hAlign' => 'center'],
                                                            ['content' => 'KUMPULAN', 'options' => ['colspan' => 1, 'rowspan' => 2]],
                                                            ['content' => 'JUMLAH STAF', 'options' => ['colspan' => 1, 'rowspan' => 2],
                                                                'vAlign' => 'middle',
                                                                'hAlign' => 'center'],
                                                            ['content' => 'CAPAI IDP MINIMUM', 'options' => ['colspan' => 2]],
                                                            ['content' => 'BELUM CAPAI IDP MINIMUM', 'options' => ['colspan' => 2]],
                                                            ['content' => 'BELUM ADA MATA IDP', 'options' => ['colspan' => 2]],
                                                            //['content' => 'Date', 'options' => ['colspan' => 2, 'class' => 'text-center warning']],
                                                        ],
                                                    ]
                                                ],
                                                'columns' => $gridColumnsP,
                                            ]),
                                    'active' => true
                                ],
                            ],
                        ]);
                ?>
                
                <table class="table table-sm table-bordered">
                <tr>
                    <td style="width:30%">JUMLAH KESELURUHAN STAF</td>
                    <td><?php echo Html::a(Kumpulankhidmat::countStaff($model->vckl_kod_kumpulan ,4, $tahun), [''], ['target' => '_blank'])?></td>
                </tr>
                 <tr>
                    <td>JUMLAH KESELURUHAN CAPAI IDP MINIMUM</td>
                    <td><?php echo Html::a(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan ,4,0, $tahun), [''], ['target' => '_blank'])?></td>
                </tr>
                 <tr>
                    <td>JUMLAH KESELURUHAN BELUM CAPAI IDP MINIMUM</td>
                    <td><?php echo Html::a(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan ,4,1, $tahun), [''], ['target' => '_blank'])?></td>
                </tr>
                 <tr>
                    <td>JUMLAH KESELURUHAN BELUM ADA MATA IDP</td>
                    <td><?php echo Html::a(RptStatistikIdp::countStatistics($model->vckl_kod_kumpulan ,4,2, $tahun), [''], ['target' => '_blank'])?></td>
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