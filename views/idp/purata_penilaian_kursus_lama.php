<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use kartik\export\ExportMenu;
use app\models\hronline\Campus;
use app\models\myidp\Kehadiran;
use app\models\myidp\SiriLatihan;
use app\models\myidp\PermohonanLatihan;
use app\models\myidp\BorangPenilaianLatihan;

echo $this->render('/idp/_topmenu');
?><?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>
<?php

$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'header' => 'Bil',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'tajukLatihan',
        'contentOptions' => ['style' => 'width:250px;'],
        'filterInputOptions' => [
            'class'       => 'form-control',
            'placeholder' => 'Cari...'
        ],
        'label' => 'Kursus',
        'value' => function ($data) {
            return strtoupper($data->vcsl_nama_latihan);
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'left',

    ],
    [
        'label' => 'Tahun',
        'format' => 'raw',
        'attribute' => 'tahun2',
        'filter' => [  // will override the grid column filter (i.e. `loadEnumAsFilter` will be parsed as `false`)
            '2012' => '2012',
            '2013' => '2013',
            '2014' => '2014',
            '2015' => '2015',
            '2016' => '2016',
            '2017' => '2017',
            '2018' => '2018',
            '2019' => '2019'
        ],
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen    
        'contentOptions' => ['style' => 'width:50px;'],
        'value' => function ($model) {
            if (($model->vcsl_tkh_mula != null) && ($model->vcsl_tkh_mula != 0000 - 00 - 00)) {

                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->vcsl_tkh_mula);
                $formatteddate = $myDateTime->format('Y');
            } else {
                $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
            }
            return $formatteddate;
        },
        'headerOptions' => ['style' => 'width:100px'],
        'vAlign' => 'middle',
        'hAlign' => 'center',
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
        'contentOptions' => ['style' => 'width:50px;'],
        'value' => function ($model) {
            if (($model->vcsl_tkh_mula != null) && ($model->vcsl_tkh_mula != 0000 - 00 - 00)) {

                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->vcsl_tkh_mula);
                $formatteddate = $myDateTime->format('d/m/Y');

                $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->vcsl_tkh_tamat);
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
        'headerOptions' => ['style' => 'width:100px'],
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'class' => 'kartik\grid\EnumColumn',
        'label' => 'Kategori',
        'format' => 'raw',
        'value' => 'kategoriKursus',
        'filter' => [  // will override the grid column filter (i.e. `loadEnumAsFilter` will be parsed as `false`)
            '1' => 'AKADEMIK',
            '0' => 'PENTADBIRAN',
        ],
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen    
        'contentOptions' => ['style' => 'width:50px;'],
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    // [
    //     'header' => 'Jumlah <br> Peserta',
    //     'value' => function ($data) {
    //         return Kehadiran::calculatePeserta($data->siriLatihanID);
    //     },
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    // ],
    // [
    //     'header' => 'Jumlah Lengkap <br> Borang Penilaian',
    //     'format' => 'raw',
    //     'value' => function ($data) {
    //         return BorangPenilaianLatihan::calculateSudahIsi($data->siriLatihanID);
    //     },
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    // ],
    // [
    //     'header' => 'Persekitaran <br>Pembelajaran (%)',
    //     'format' => 'raw',
    //     'value' => function ($data) {
    //         return BorangPenilaianLatihan::calcPurataPenilaian($data->siriLatihanID, 1);
    //     },
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    // ],
    // [
    //     'header' => 'Penyampaian <br>Penceramah (%)',
    //     'format' => 'raw',
    //     'value' => function ($data) {
    //         return BorangPenilaianLatihan::calcPurataPenilaian($data->siriLatihanID, 2);
    //     },
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    // ],
    // [
    //     'header' => 'Kandungan <br>Kursus (%)',
    //     'format' => 'raw',
    //     'value' => function ($data) {
    //         return BorangPenilaianLatihan::calcPurataPenilaian($data->siriLatihanID, 3);
    //     },
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    // ],
    // [
    //     'header' => 'Urusetia (%)',
    //     'format' => 'raw',
    //     'value' => function ($data) {
    //         return BorangPenilaianLatihan::calcPurataPenilaian($data->siriLatihanID, 4);
    //     },
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    // ],
    // [
    //     'header' => 'Kompetensi Sebelum <br>Kursus (%)',
    //     'format' => 'raw',
    //     'value' => function ($data) {
    //         return BorangPenilaianLatihan::calcPurataPenilaian($data->siriLatihanID, 5);
    //     },
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    // ],
    // [
    //     'header' => 'Kompetensi Selepas <br>Kursus (%)',
    //     'format' => 'raw',
    //     'value' => function ($data) {
    //         return BorangPenilaianLatihan::calcPurataPenilaian($data->siriLatihanID, 6);
    //     },
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    // ],

];


?>
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
                <h4>Purata Penilaian Kursus

                    <?=
                    ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumns,
                        'filename' => 'Purata Penilaian Kursus ' . date('Y-m-d'),
                        'clearBuffers' => true,
                        'stream' => false,
                        'folder' => '@app/web/files/myidp/.',
                        'linkPath' => '/files/myidp/',
                        'batchSize' => 10,
                    ]);
                    ?>

                </h4>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
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
                        'bootstrap' => true,
                        'responsiveWrap' => true,
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
            </div> <!-- x_content -->
        </div>
    </div>
</div>