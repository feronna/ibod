<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\myidp\TblYears;
use kartik\export\ExportMenu;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;

echo $this->render('/idp/_topmenu');
?>
<?php

$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'header' => 'Bil',
    ],
    [
        //'attribute' => 'kursusLatihanID',
        'contentOptions' => ['style' => 'width:400px;'],
        'filterInputOptions' => [
            'class'       => 'form-control',
            'placeholder' => 'Cari...'
        ],
        'label' => 'Tajuk Latihan',
        'value' => function ($data) {
            return ucwords(strtoupper($data->sasaran9->sasaran4->sasaran3->tajukLatihan));
        },
        //                            'group' => true,  // enable grouping

    ],
    [
        'label' => 'Siri',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function ($data) {
            return ucwords(strtoupper($data->sasaran9->sasaran4->siri));
        },
        //                            'group' => true,  // enable grouping
        //                            'subGroupOf' => 1 // supplier column index is the parent group
    ],
    [
        'class' => 'kartik\grid\EnumColumn',
        'label' => 'Jenis',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'attribute' => 'jenis',
        'value' => 'sasaran9.sasaran4.sasaran3.jenisKursus',
        'format' => 'raw',
        //                            'enum' => [
        //                                'latihanDalaman' => '<span class="text-sucess">DALAMAN</span>',
        //                                'jfpiu' => '<span class="text-primary">JFPIU</span>',
        //                            ],
        //'loadEnumAsFilter' => true, // optional - defaults to `true`
        'filter' => [  // will override the grid column filter (i.e. `loadEnumAsFilter` will be parsed as `false`)
            'latihanDalaman' => 'DALAMAN',
            'jfpiu' => 'JFPIU',
        ],
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen 
    ],

    [
        'label' => 'Tempat',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function ($data) {
            return ucwords(strtoupper($data->sasaran9->sasaran4->lokasi));
        },
    ],

    [
        'label' => 'Tarikh',
        'hAlign' => 'center',
        'vAlign' => 'middle',
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
        'value' => function ($model) {
            if (($model->sasaran9->sasaran4->tarikhMula != null) && ($model->sasaran9->sasaran4->tarikhMula != 0000 - 00 - 00)) {

                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->sasaran9->sasaran4->tarikhMula);
                $formatteddate = $myDateTime->format('d/m/Y');

                if (($model->sasaran9->sasaran4->tarikhAkhir != null) && ($model->sasaran9->sasaran4->tarikhAkhir != 0000 - 00 - 00)) {
                    $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->sasaran9->sasaran4->tarikhAkhir);
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
        'class' => 'kartik\grid\ActionColumn',
        'header' => 'Tindakan',
        //'headerOptions' => ['style' => 'color:#337ab7'],
        'headerOptions' => ['style' => 'width:100px'],
        'contentOptions' => ['style' => 'padding:0px 0px 0px 15px;vertical-align: middle;'],
        'template' => '{laporan_kehadiran}',
        //'contentOptions' => ['style'=>'padding:0px 0px 0px 30px;vertical-align: middle;'],
        'buttons' => [
            'laporan_kehadiran' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-tags"></span>', $url, [
                    'title' => Yii::t('app', 'Papar')
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {

            if ($action === 'laporan_kehadiran') {

                if ($model->sasaran9->sasaran4->sasaran3->jenisLatihanID == 'latihanDalaman') {
                    $url = 'laporan-kehadiran-siri?id=' . $model->sasaran9->siriLatihanID . '&dept=' . $model->peserta->DeptId; //hantar ke Controller
                } else {
                    $url = 'laporan-kehadiran-siri-jfpiu?id=' . $model->sasaran9->siriLatihanID . '&dept=' . $model->peserta->DeptId; //hantar ke Controller
                }

                return $url;
            }
        }
    ],
];



?>

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
                    'action' => ['idp/laporan-kehadiran-jabatan'],
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
                <h5>Senarai Kursus Dihadiri Kakitangan
                    <h3>
                        <span class="label label-success" style="color: white"><?= strtoupper($getJabatan->department->fullname); ?></span>

                        <?=
                        ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'filename' => 'Senarai Kursus Dihadiri Kakitangan ' . strtoupper($getJabatan->department->fullname) . ' - ' . date('Y-m-d'),
                            'clearBuffers' => true,
                            'stream' => false,
                            'folder' => '@app/web/files/myidp/.',
                            'linkPath' => '/files/myidp/',
                            'batchSize' => 10,
                        ]);
                        ?>

                    </h3>

                </h5>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div>
                    <!-- ubah kat sini -->
                    <div class="table-responsive">
                        <!--<php $senaraiKursus = $searchModel->senaraiKursus;-->
                        <!-- $senaraiKursus is a function from myidp\VIdpSenaraiKursus-->
                        <?=
                        GridView::widget([
                            //\yiister\gentelella\widgets\grid\GridView::widget([
                            //'hover' => true,
                            //'dataProvider' => $senaraiKursus,
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'showFooter' => true,
                            'showHeader' => true,
                            'layout' => "{items}\n{pager}",
                            'pager' => [
                                'firstPageLabel' => 'Halaman Pertama',
                                'lastPageLabel'  => 'Halaman Terakhir'
                            ],
                            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>AKAN DIMAKLUMKAN</b></i>'],
                            'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                            'columns' => $gridColumns,
                        ]);
                        ?>
                    </div>
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
        </div>
    </div>
</div>