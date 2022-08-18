<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;
use app\models\myidp\TblYears;
use app\models\myidp\SiriLatihan;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

echo $this->render('/idp/_topmenu');

error_reporting(0);

//$dataProvider->pagination->pageParam = 'p-page';
//$dataProvider->sort->sortParam = 'p-sort';
//
//$dataProviderA->pagination->pageParam = 'a-page';
//$dataProviderA->sort->sortParam = 'a-sort';

$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'header' => 'Bil',
        'exportMenuStyle' => [ // format the serial column cells
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 
                'color' => ['argb' => 'FFE5E5E5']
            ]
        ]
    ],
    [
        'attribute' => 'tajukLatihan',
        'label' => 'Kursus',
        'value' => function ($data) {
            return strtoupper($data->sasaran3->tajukLatihan);
        },

    ],

    [
        'label' => 'Siri',
        'value' => 'siri',
        'hAlign' => GridView::ALIGN_CENTER
    ],
    [
        'label' => 'Tahun',
        'attribute' => 'tahun',
        'value' => function ($model) {
            if (($model->tarikhMula != null) && ($model->tarikhMula != 0000 - 00 - 00)) {

                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                $formatteddate = $myDateTime->format('Y');
            } else {
                $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
            }
            return $formatteddate;
        },
        'hAlign' => GridView::ALIGN_CENTER
        //'exportMenuStyle' => ['numberFormat' => ['formatCode' => 'YYYY-MM-DD']] // formats a date
    ],

    [
        'label' => 'Tarikh',
        'attribute' => 'bulan',
        'value' => function ($model) {
            if (($model->tarikhMula != null) && ($model->tarikhMula != 0000 - 00 - 00)) {

                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                $formatteddate = $myDateTime->format('d/m/Y');

                if (($model->tarikhAkhir != null) && ($model->tarikhAkhir != 0000 - 00 - 00)) {
                    $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhAkhir);
                    $formatteddate2 = $myDateTime2->format('d/m/Y');
                } else {
                    $formatteddate2 = '<em><b>AKAN DIMAKLUMKAN</b></em>';
                }

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
        'hAlign' => GridView::ALIGN_CENTER
    ],
    [
        'label' => 'Bulan',
        'attribute' => 'bulan', 
        'value' => 'bulanKursus',
        'hAlign' => GridView::ALIGN_CENTER
    ],
    [
        'label' => 'Tempat',
        'hAlign' => GridView::ALIGN_CENTER,
        'value' => 'lokasiKursus',
    ],
    [
        'attribute' => 'kategoriJawatanID',
        'label' => 'Kategori',
        'value' => function ($data) {
            return ucwords(strtoupper($data->sasaran3->kategoriJawatanID));
        },
        'hAlign' => GridView::ALIGN_CENTER,
    ],
    [
        'header' => 'Mata',
        'value' => 'jumlahMataIDP',
        'hAlign' => GridView::ALIGN_CENTER,
    ],
    [
        'label' => 'Status',
        'value' => 'statusSiri',
        'hAlign' => GridView::ALIGN_CENTER,
    ],
    
];

//where $defaultStyle is set as below
$defaultStyle = [
    'font' => ['bold' => true],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => [
            'argb' => 'FFE5E5E5',
        ],
    ],
    'borders' => [
        'outline' => [
            'borderStyle' => Border::BORDER_MEDIUM,
            'color' => ['argb' => Color::COLOR_BLACK],
        ],
        'inside' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => Color::COLOR_BLACK],
        ]
    ],
];

?><?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>
<style>
    .container span {
        display: inline-block;
    }
</style>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i>&nbsp;Carian</strong></h2>
                <div class="clearfix"></div>


            </div>
            <div class="x_content">
                <?php
                $form = ActiveForm::begin([
                    'action' => ['idp/takwim'],
                    'method' => 'get',
                ])
                ?>

                <div class="col-xs-6 col-md-3 col-lg-2">

                    <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::findAll(['admin_status' => 1]), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                </div>

                <div class="col-xs-12 col-md-2 col-lg-2">
                    <?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;Cari', ['class' => 'btn btn-primary']) ?>
                </div>
                <div class="pull-right">
                    <?=
                    ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumns,
                        'exportConfig' => [
                            ExportMenu::FORMAT_TEXT => false,
                            ExportMenu::FORMAT_HTML => false,
                            ExportMenu::FORMAT_CSV => false,
                            ExportMenu::FORMAT_EXCEL => $defaultStyle,
                            ExportMenu::FORMAT_PDF => false,
                            ExportMenu::TARGET_POPUP => true,
                        ],
                        
                        'dropdownOptions' => [
                            'label' => 'Muat Turun Takwim',
                            'class' => 'btn btn-outline-secondary'
                        ],
                        'filename' => 'Takwim Kalendar Latihan Tahun ' . $tahun . ' ' . date('Y-m-d'),
                        'clearBuffers' => true,                        
                        'stream' => true,
                        'folder' => '@app/web/files/myidp/.',
                        'linkPath' => '/files/myidp/',
                        'batchSize' => 10,
                    ]);
                    ?></div>
                <div class="clearfix"></div>

                <?php ActiveForm::end() ?>
                <!-- </div> -->
            </div>
        </div>
        <?php

        for ($i = 1; $i <= 12; $i++) {

        ?>

            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <?php if ($i == 1) { ?>
                            <div>
                                <h3><span class="label label-primary" style="color: white">Takwim <?= $tahun ?></span></h3>
                                <div class="clearfix"></div>
                            </div>
                        <?php } ?>
                        <div class="x_title">
                            <h2><strong><i class="fa fa-calendar"></i> <span class="label label-info" style="color: white"><?= SiriLatihan::getTarikh($i) ?></span></strong></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div>
                                <!-- ubah kat sini -->
                                <div class="table-responsive">
                                    <!--<php $senaraiKursus = $searchModel->senaraiKursus;-->
                                    <!-- $senaraiKursus is a function from myidp\VIdpSenaraiKursus-->
                                    <?php
                                    Pjax::begin([
                                        // PJax options
                                    ]);


                                    echo GridView::widget([
                                        'dataProvider' => SiriLatihan::kursusListByMonth($i, $tahun),
                                        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b> - </b></i>'],
                                        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                                        'columns' => [
                                            [
                                                'class' => 'kartik\grid\SerialColumn',
                                                'header' => 'Bil',
                                                'vAlign' => 'middle',
                                                'hAlign' => 'center',
                                            ],
                                            [
                                                'label' => 'Kursus',
                                                'vAlign' => 'middle',
                                                'hAlign' => 'left',
                                                'value' => function ($data) {
                                                    return strtoupper($data->sasaran3->tajukLatihan);
                                                },
                                                'contentOptions' => ['style' => 'width:200px;'],
                                            ],
                                            [
                                                'attribute' => 'siri',
                                                'vAlign' => 'middle',
                                                'hAlign' => 'center',
                                            ],
                                            [
                                                'label' => 'Tarikh',
                                                'vAlign' => 'middle',
                                                'hAlign' => 'center',
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

                                                        if (($model->tarikhAkhir != null) && ($model->tarikhAkhir != 0000 - 00 - 00)) {
                                                            $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhAkhir);
                                                            $formatteddate2 = $myDateTime2->format('d/m/Y');
                                                        } else {
                                                            $formatteddate2 = '<em><b>AKAN DIMAKLUMKAN</b></em>';
                                                        }

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
                                                'headerOptions' => ['style' => 'width:100px'],
                                            ],
                                            [
                                                'label' => 'Tempat',
                                                'value' => function ($data) {
                                                    return ucwords(strtolower($data->lokasiKursus));
                                                },
                                                'vAlign' => 'middle',
                                                'hAlign' => 'left',
                                                'contentOptions' => ['style' => 'width:200px;'],
                                            ],
                                            //                        [ 
                                            //                            'label' => 'Kampus',
                                            //                            'value' => 'campusName.campus_name'
                                            //                        ],
                                            [
                                                'label' => 'Kategori',
                                                // 'value' => function ($data){
                                                //                 return ucwords(strtolower($data->sasaran3->unitBertanggungjawab));
                                                //             },
                                                'value' => function ($data) {
                                                    return ucwords(strtolower($data->sasaran3->kategoriJawatanID));
                                                },
                                                'vAlign' => 'middle',
                                                'hAlign' => 'center',
                                            ],
                                            [
                                                'label' => 'Mata',
                                                'value' => 'jumlahMataIDP',
                                                'vAlign' => 'middle',
                                                'hAlign' => 'center',
                                            ],
                                            [
                                                'label' => 'Status',
                                                'format' => 'raw',
                                                'value' => 'statusSiri',
                                                'vAlign' => 'middle',
                                                'hAlign' => 'center',
                                            ],
                                            [
                                                'label' => 'Bahan',
                                                'vAlign' => 'middle',
                                                'hAlign' => 'center',
                                                'format' => 'raw',
                                                'value' => function ($data) {

                                                    if ($data->linkBahan) {
                                                        return Html::a('<i class="fa fa-external-link-square" aria-hidden="true"></i>', $data->linkBahan, ['class' => 'btn-sm btn-primary', 'target' => '_blank']);
                                                    } else {
                                                        //return Html::button('<i class="fa fa-ban" aria-hidden="true"></i>', ['class' => 'btn-sm btn-danger', 'disabled' => true]);
                                                        return " ";
                                                    }
                                                },
                                            ],
                                        ],
                                    ]);
                                    Pjax::end();
                                    ?>
                                </div>
                            </div> <!-- ubah sini -->
                        </div> <!-- x_content -->
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>