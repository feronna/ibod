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
use app\models\myidp\IdpStatistik;

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
                                    'label' => 'KUMPULAN',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'left',
                                    'format' => 'raw',
                                    'value' => function ($model) {return strtoupper($model->name);},
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
                                        
                                        //return Html::a(Kumpulankhidmat::countStaff($model->id, 0, $tahun), ["senarai", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 4, 'tahun' => $tahun]);
                                        return Html::a(IdpStatistik::countStaffByKumpulan($model->id, 0, $tahun), ["senarai", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 4, 'tahun' => $tahun]);
                                            
                                        },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
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
                                                      //return Html::a(RptStatistikIdp::countStatistics($model->id, 0, 0, $tahun), ["senarai", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 0, 'tahun' => $tahun]);
                                                      //return Html::a(RptStatistikIdp::countStatistics($model->id, 0, 0, $tahun), ["senarai", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 0, 'tahun' => $tahun]);
                                                      return Html::a(IdpStatistik::countStaffByKumpulan($model->id, 1, $tahun), ["senarai", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 0, 'tahun' => $tahun]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '%',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function ($model) use ($tahun){
                                                      //return round(RptStatistikIdp::countStatistics($model->id, 0, 0, $tahun)/Kumpulankhidmat::countStaffByKumpulan($model->id, 0, $tahun)*100);
                                                      return IdpStatistik::countStaffByKumpulan($model->id, 2, $tahun);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'JUMLAH',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function ($model) use ($tahun){
                                                      //return Html::a(RptStatistikIdp::countStatistics($model->id, 0, 0, $tahun), ["senarai", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 0, 'tahun' => $tahun]);
                                                      //return Html::a(RptStatistikIdp::countStatistics($model->id, 0, 0, $tahun), ["senarai", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 0, 'tahun' => $tahun]);
                                                      return Html::a(IdpStatistik::countStaffByKumpulan($model->id, 3, $tahun), ["senarai", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 1, 'tahun' => $tahun]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '%',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function ($model) use ($tahun){
                                                      //return round(RptStatistikIdp::countStatistics($model->id, 0, 0, $tahun)/Kumpulankhidmat::countStaffByKumpulan($model->id, 0, $tahun)*100);
                                                      return IdpStatistik::countStaffByKumpulan($model->id, 4, $tahun);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'JUMLAH',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function ($model) use ($tahun){
                                                      //return Html::a(RptStatistikIdp::countStatistics($model->id, 0, 0, $tahun), ["senarai", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 0, 'tahun' => $tahun]);
                                                      //return Html::a(RptStatistikIdp::countStatistics($model->id, 0, 0, $tahun), ["senarai", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 0, 'tahun' => $tahun]);
                                                      return Html::a(IdpStatistik::countStaffByKumpulan($model->id, 5, $tahun), ["senarai", 'kumpulan' => $model->id, 'category' => 0, 'calctype' => 2, 'tahun' => $tahun]);
                                                },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '%',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function ($model) use ($tahun){
                                                      //return round(RptStatistikIdp::countStatistics($model->id, 0, 0, $tahun)/Kumpulankhidmat::countStaffByKumpulan($model->id, 0, $tahun)*100);
                                                      return IdpStatistik::countStaffByKumpulan($model->id, 6, $tahun);
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
                    'action' => ['idp/statistik'],
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
                <h2>Statistik Pencapaian Mata IDP Staf (Keseluruhan)</h2>
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
                                                'columns' => $gridColumnsK,
                                            ]),
                                    'active' => true
                                ],
                            ],
                        ]);
                ?>
                
                 <table class="table table-sm table-bordered">
                <tr>
                    <td style="width:30%">JUMLAH KESELURUHAN STAF</td>
                    <td><?= IdpStatistik::countStaff(0, $tahun); ?></td>
                </tr>
                 <tr>
                    <td>JUMLAH KESELURUHAN CAPAI IDP MINIMUM</td>
                    <td><?= IdpStatistik::countStaff(1, $tahun); ?></td>
                </tr>
                 <tr>
                    <td>JUMLAH KESELURUHAN BELUM CAPAI IDP MINIMUM</td>
                    <td><?= IdpStatistik::countStaff(2, $tahun); ?></td>
                </tr>
                 <tr>
                    <td>JUMLAH KESELURUHAN BELUM ADA MATA IDP</td>
                    <td><?= IdpStatistik::countStaff(3, $tahun); ?></td>
                </tr>
                </table>
            </div> <!-- x_content -->
        </div>
    </div>
</div>