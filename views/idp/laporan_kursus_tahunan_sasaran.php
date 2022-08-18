<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;
use app\models\myidp\TblYears;
use app\models\myidp\Kehadiran;
use app\models\myidp\SiriLatihan;
use app\models\myidp\PermohonanLatihan;
use app\models\myidp\BorangPenilaianLatihan;
use app\models\myidp\BorangPenilaianKeberkesanan;

echo $this->render('/idp/_topmenu');

$gridColumns = [
        [
            'class' => 'kartik\grid\SerialColumn',
            'header' => 'Bil',
            'vAlign' => 'middle',
            'hAlign' => 'center',
        ],
        [
            'attribute' => 'tajukLatihan',
            'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
            'filterInputOptions' => [
                'class'       => 'form-control',
                'placeholder' => 'Cari...'
            ],
            'label' => 'Kursus',
            'vAlign' => 'middle',
            'hAlign' => 'left',
            'value' => function ($data) {
                return Html::a(strtoupper($data->sasaran3->tajukLatihan), ["idp/laporan-kehadiran-siri", 'id' => $data->siriLatihanID]);
            },
            'format' => 'raw',

        ],
        [
            'label' => 'Siri',
            'value' => 'siri',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'contentOptions' => ['style' => 'width:10px; white-space: normal;'],
        ],
        [
            'label' => 'Tempat',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'value' => function ($data) {
                return ucwords(strtoupper($data->lokasi));
            },
            'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
        ],
        [
            'label' => 'Tarikh',
            'format' => 'raw',
            'attribute' => 'bulan',
            'filter' => [  // will override the grid column filter (i.e. `loadEnumAsFilter` will be parsed as `false`)
                '1' => 'Januari',
                '2' => 'Februari',
                '3' => 'Mac',
                '4' => 'April',
                '5' => 'Mei',
                '6' => 'Jun',
                '7' => 'Julai',
                '8' => 'Ogos',
                '9' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Disember',

            ],
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen    
            'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
            'value' => function ($model) {
                if (($model->tarikhMula != null) && ($model->tarikhMula != 0000 - 00 - 00)) {

                    $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                    $formatteddate = $myDateTime->format('d/m/Y');

                    $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhAkhir);
                    $formatteddate2 = $myDateTime2->format('d/m/Y');

                    if ($formatteddate == $formatteddate2) {
                        $formatteddate = $formatteddate;
                    } else {
                        $formatteddate = $formatteddate . ' - ' . $formatteddate2;
                    }
                } else {
                    $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
                }
                return $formatteddate;
            },
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'headerOptions' => ['style' => 'width:100px'],
        ],
        [
            'class' => 'kartik\grid\EnumColumn',
            'attribute' => 'kategoriJawatanID',
            'label' => 'Kategori',
            'format' => 'raw',
            'value' => function ($data) {
                return ucwords(strtoupper($data->sasaran3->kategoriJawatanID));
            },
            //                            'enum' => [
            //                                'AKADEMIK' => '<span class="text-muted">AKADEMIK</span>',
            //                                'PENTADBIRAN' => '<span class="text-success">PENTADBIRAN</span>',
            //                                'JFPIU' => '<span class="text-primary">JFPIU</span>',
            //                            ],
            //'loadEnumAsFilter' => true, // optional - defaults to `true`
            'filter' => [  // will override the grid column filter (i.e. `loadEnumAsFilter` will be parsed as `false`)
                'AKADEMIK' => 'AKADEMIK',
                'PENTADBIRAN' => 'PENTADBIRAN',
            ],
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen    
            'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
            'vAlign' => 'middle',
            'hAlign' => 'center',
        ],
        [
            'header' => 'Mata',
            'value' => 'jumlahMataIDP',
            'vAlign' => 'middle',
            'hAlign' => 'center',
        ],
        [
            'header' => 'Sasaran',
            'value' => 'kuota',
            'vAlign' => 'middle',
            'hAlign' => 'center',
        ],
        [
            'header' => 'Bil Pemohon',
            'value' => function ($data) {
                return PermohonanLatihan::calculatePemohon($data->siriLatihanID);
            },
            'vAlign' => 'middle',
            'hAlign' => 'center',
        ],
        [
            'header' => 'Kehadiran',
            'value' => function ($data) {
                return Kehadiran::calculatePeserta($data->siriLatihanID);
            },
            'vAlign' => 'middle',
            'hAlign' => 'center',
        ],
];

/* * * for popover PENCERAMAH & INFO **** */
$js = <<< 'SCRIPT'
/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});
/* To initialize BS3 popovers set this below */
$(function () { 
   $("[data-toggle='popover']").popover();
//    $("[data-trigger='focus']").popover();
//    $('.popover-dismiss').popover({
//        trigger: 'focus'
//        })
});
//$(function() {
//    // use the popoverButton plugin
//    $('#kv-btn-1').popoverButton({
//        placement: 'left', 
//        target: '#myPopover5'
//    });
//});
$(function() {
    $('#testHover').popoverButton({
        trigger: 'hover focus',
        target: '#myPopover6'
    });
});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);
error_reporting(0);
?>
<!---- Hide previous modal screen ---->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#modal").on('hidden.bs.modal', function() {
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
                    'action' => ['idp/index-laporan-sasaran'],
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
            <!--            <div class="x_title">
                <h2>Staf Pentadbiran</h2>
                <div class="clearfix"></div>
            </div>-->
            <div class="x_title">
                <h2><strong><i class="fa fa-line-chart"></i>&nbspLaporan Pelaksanaan Kursus <?= $tahun ?>
                    </strong></h2>
                <div class="pull-right">
                    <?=
                    ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumns,
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
                        'dropdownOptions' => [
                            //'label' => 'Export All',
                            'class' => 'btn btn-outline-secondary'
                        ],
                        'filename' => 'Laporan Pelaksanaan Kursus - ' . $tahun,
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
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'emptyText' => 'Tiada kursus ditemui.',
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumns,
                ]); ?>
            </div> <!-- x_content -->
        </div>
    </div>
</div>