<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use app\models\hronline\Department;
use app\models\myidp\UserAccess;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use app\models\myidp\TblYears;

echo $this->render('/idp/_topmenu');

error_reporting(0);
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

$gridColumnsKursusLuar = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'header' => 'Bil',
    ],
    [
        'attribute' => 'CONm',
        'contentOptions' => ['style' => 'width:300px;'],
        'filterInputOptions' => [
            'class'  => 'form-control',
            'placeholder' => 'Cari...'
        ],
        'label' => 'Nama',
        'value' => function ($data) {
            return ucwords(strtolower($data->biodata->CONm));
        },
    ],
    [
        'attribute' => 'DeptId',
        //                'contentOptions' => ['style' => 'width:400px;'],
        'label' => 'JAFPIB',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function ($data) {
            return ucwords(strtoupper($data->biodata->department->shortname));
        },
        'filter'    => ArrayHelper::map(Department::find()->all(), 'id', 'shortname'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen                  
    ],
    [
        'label' => 'Kursus',
        'contentOptions' => ['style' => 'width:300px;'],
        'value' => function ($data) {
            return ucwords(strtolower($data->namaProgram));
        },
    ],
    [
        'label' => 'Tarikh Kursus',
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
        'contentOptions' => ['style' => 'width:50px;'],
        'value' => function ($model) {
            if (($model->tarikhMula != null) && ($model->tarikhMula != 0000 - 00 - 00)) {

                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                $formatteddate = $myDateTime->format('d/m/Y');

                $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhTamat);
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
    ],
    [
        'label' => 'Tahun',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'raw',
        'attribute' => 'tahun',
        'filter' => ArrayHelper::map(TblYears::findAll(['admin_status' => 1]), 'year', 'year'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen    
        'contentOptions' => ['style' => 'width:50px;'],
        'value' => function ($model) {
            if (($model->tarikhMula != null) && ($model->tarikhMula != 0000 - 00 - 00)) {

                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                $formatteddate = $myDateTime->format('Y');
            } else {
                $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
            }
            return $formatteddate;
        },
        'headerOptions' => ['style' => 'width:100px'],
    ],
    //            [
    //                'label' => 'Tarikh Pohon',
    //                'format' => 'raw',
    //                'value' => function ($data){
    //                                $tarikhKursus = $data->tarikhPohon;
    //                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
    //                                $formatteddate = $myDateTime->format('d/m/Y');
    //                                
    //                                return ucwords(strtolower($formatteddate));
    //                            },
    //            ],
    //            [
    //                'label' => 'Tarikh Semakan JFPIU',
    //                'format' => 'raw',
    //                'value' => function ($data){
    //                                
    //                                if ($data->tarikhSemakanKJ){
    //                                    $tarikhKursus = $data->tarikhSemakanKJ;
    //                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
    //                                    $formatteddate = $myDateTime->format('d/m/Y');
    //
    //                                    return ucwords(strtolower($formatteddate));
    //                                }
    //                            },
    //            ],
    //            [
    //                'label' => 'Tarikh Semakan Urusetia',
    //                'format' => 'raw',
    //                'value' => function ($data){
    //                                
    //                                if ($data->tarikhSemakanUL){
    //                                    $tarikhKursus = $data->tarikhSemakanUL;
    //                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
    //                                    $formatteddate = $myDateTime->format('d/m/Y');
    //
    //                                    return ucwords(strtolower($formatteddate));
    //                                }
    //                            },
    //                //'headerOptions' => ['style' => 'width:100px'],
    //            ],
    //            [
    //                'label' => 'Tarikh Semakan BSM',
    //                'format' => 'raw',
    //                'value' => function ($data){
    //                                
    //                                if ($data->tarikhSemakanBSM){
    //                                    $tarikhKursus = $data->tarikhSemakanBSM;
    //                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
    //                                    $formatteddate = $myDateTime->format('d/m/Y');
    //
    //                                    return ucwords(strtolower($formatteddate));
    //                                }
    //                            },
    //                'headerOptions' => ['style' => 'width:50px'],
    //            ],
    [
        'label' => 'Tindakan',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'raw',
        //                'contentOptions' => ['style' => 'width:120px; white-space: normal;'],
        'value' => function ($data) {

            $findUser = UserAccess::find()->where(['userID' => Yii::$app->user->getId()])->one();

            if ($data->tarikhSemakanUL && !$data->tarikhSemakanBSM) {

                if ($findUser->usertype == 'ul') {
                    return Html::a('<i class="fa fa-eye">', '/staff/web/idp/view-latihan-luar-pohon?permohonanID=' . $data->permohonanID . '&userLevel=' . $userLevel . '&update=NO', ['title' => Yii::t('app', 'Papar')]);
                } elseif ($findUser->usertype == 'pegawaiLatihan') {
                    return Html::a('<i class="fa fa-edit">', '/staff/web/idp/view-latihan-luar-pohon?permohonanID=' . $data->permohonanID . '&userLevel=' . $userLevel . '&update=NO', ['title' => Yii::t('app', 'Papar')]);
                }
            } elseif ($data->tarikhSemakanUL && $data->tarikhSemakanBSM) {

                if ($findUser->usertype == 'ul') {
                    return Html::a('<i class="fa fa-eye">', '/staff/web/idp/view-latihan-luar-pohon?permohonanID=' . $data->permohonanID . '&userLevel=' . $userLevel . '&update=NO', ['title' => Yii::t('app', 'Papar')]);
                } elseif ($findUser->usertype == 'pegawaiLatihan') {
                    return Html::a('<i class="fa fa-eye">', '/staff/web/idp/view-latihan-luar-pohon?permohonanID=' . $data->permohonanID . '&userLevel=' . $userLevel . '&update=NO', ['title' => Yii::t('app', 'Papar')]);
                } elseif ($findUser->usertype == 'ketuaSektor') {
                    return Html::a('<i class="fa fa-edit">', '/staff/web/idp/view-latihan-luar-pohon?permohonanID=' . $data->permohonanID . '&userLevel=' . $userLevel . '&update=NO', ['title' => Yii::t('app', 'Papar')]);
                }
            } else {

                if ($data->tarikhSemakanKJ && $data->statusKJ != '3') {
                    return Html::a('<i class="fa fa-edit">', '/staff/web/idp/view-latihan-luar-pohon?permohonanID=' . $data->permohonanID . '&userLevel=' . $userLevel . '&update=NO', ['title' => Yii::t('app', 'Papar')]);
                } elseif (!$data->tarikhSemakanKJ || $data->statusKJ == '3') {
                    //return Html::a('<i class="fa fa-eye">', '/staff/web/idp/view-latihan-luar-pohon?permohonanID='.$data->permohonanID.'&userLevel='.$userLevel.'&update=NO', ['title' => Yii::t('app', 'Papar'), 'class' => 'btn-sm btn-primary']);
                    return Html::a('<i class="fa fa-eye">', '/staff/web/idp/view-latihan-luar-pohon?permohonanID=' . $data->permohonanID . '&userLevel=' . $userLevel . '&update=NO', ['title' => Yii::t('app', 'Papar')]);
                }
            }
        },
        'headerOptions' => ['style' => 'width:50px'],
    ],
    [
        'attribute' => 'statusPermohonan',
        'label' => 'Status Permohonan',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'raw',
        'value' => 'statusPermohonann',
        'filter'    => [
            1 => "MENUNGGU PENGESAHAN KJ",
            2 => "DIBATALKAN",
            3 => "TIDAK DISAHKAN KJ",
            4 => "MENUNGGU SEMAKAN",
            6 => "MENUNGGU PERAKUAN",
            7 => "MENUNGGU KELULUSAN",
            8 => "MENUNGGU KELULUSAN",
            9 => "PERMOHONAN DITOLAK",
            10 => "PERMOHONAN BERJAYA"
        ],
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen
    ]

];

$gridColumnsKursusLuarExport = [
    [
        'class' => 'yii\grid\SerialColumn',
        'header' => 'Bil',
    ],
    [
        'attribute' => 'CONm',
        'contentOptions' => ['style' => 'width:300px;'],
        'filterInputOptions' => [
            'class'  => 'form-control',
            'placeholder' => 'Cari...'
        ],
        'label' => 'Nama',
        'value' => function ($data) {
            return ucwords(strtolower($data->biodata->CONm));
        },
    ],

    [
        'contentOptions' => ['style' => 'width:300px;'],
        'filterInputOptions' => [
            'class'  => 'form-control',
            'placeholder' => 'Cari...'
        ],
        'label' => 'UMS-PER',
        'value' => function ($data) {
            return ucwords(strtolower($data->biodata->COOldID));
        },
    ],
    [
        'attribute' => 'DeptId',
        //                'contentOptions' => ['style' => 'width:400px;'],
        'label' => 'JFPIB',
        'value' => function ($data) {
            return ucwords(strtoupper($data->biodata->department->shortname));
        },
        'filter'    => ArrayHelper::map(Department::find()->all(), 'id', 'shortname'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen                  
    ],
    [
        'attribute' => 'namaPenganjur',
        'contentOptions' => ['style' => 'width:300px;'],
        'filterInputOptions' => [
            'class'  => 'form-control',
            'placeholder' => 'Cari...'
        ],
        'label' => 'Penganjur',
        'value' => function ($data) {
            return ucwords(strtoupper($data->namaPenganjur));
        },
    ],
    [
        'label' => 'Kursus',
        'contentOptions' => ['style' => 'width:300px;'],
        'value' => function ($data) {
            return ucwords(strtolower($data->namaProgram));
        },
    ],
    [
        'label' => 'Tarikh Kursus',
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
            if (($model->tarikhMula != null) && ($model->tarikhMula != 0000 - 00 - 00)) {

                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                $formatteddate = $myDateTime->format('d/m/Y');

                $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhTamat);
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
    ],
    [
        'label' => 'Tahun',
        'format' => 'raw',
        'attribute' => 'tahun',
        'filter' => [  // will override the grid column filter (i.e. `loadEnumAsFilter` will be parsed as `false`)
            '2020' => '2020',
            '2021' => '2021',

        ],
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen    
        'contentOptions' => ['style' => 'width:50px;'],
        'value' => function ($model) {
            if (($model->tarikhMula != null) && ($model->tarikhMula != 0000 - 00 - 00)) {

                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                $formatteddate = $myDateTime->format('Y');
            } else {
                $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
            }
            return $formatteddate;
        },
        'headerOptions' => ['style' => 'width:100px'],
    ],
    [
        'label' => 'Tarikh Pohon',
        'format' => 'raw',
        'value' => function ($data) {
            $tarikhKursus = $data->tarikhPohon;
            $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
            $formatteddate = $myDateTime->format('d/m/Y');

            return ucwords(strtolower($formatteddate));
        },
    ],
    [
        'label' => 'Tarikh Semakan KJ',
        'format' => 'raw',
        'value' => function ($data) {

            if ($data->tarikhSemakanKJ) {
                $tarikhKursus = $data->tarikhSemakanKJ;
                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                $formatteddate = $myDateTime->format('d/m/Y');

                return ucwords(strtolower($formatteddate));
            }
        },
    ],
    [
        'label' => 'Tarikh Semakan Urusetia',
        'format' => 'raw',
        'value' => function ($data) {

            if ($data->tarikhSemakanUL) {
                $tarikhKursus = $data->tarikhSemakanUL;
                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                $formatteddate = $myDateTime->format('d/m/Y');

                return ucwords(strtolower($formatteddate));
            }
        },
        //'headerOptions' => ['style' => 'width:100px'],
    ],
    [
        'header' => 'Tarikh Semakan Pegawai',
        'format' => 'raw',
        'value' => function ($data) {

            if ($data->tarikhSemakanBSM) {
                $tarikhKursus = $data->tarikhSemakanBSM;
                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                $formatteddate = $myDateTime->format('d/m/Y');

                return ucwords(strtolower($formatteddate));
            }
        },
        'headerOptions' => ['style' => 'width:50px'],
    ],
    [
        'header' => 'Tarikh Semakan Sektor',
        'format' => 'raw',
        'value' => function ($data) {

            if ($data->tarikhKelulusan) {
                $tarikhKursus = $data->tarikhKelulusan;
                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                $formatteddate = $myDateTime->format('d/m/Y');

                return ucwords(strtolower($formatteddate));
            }
        },
        'headerOptions' => ['style' => 'width:50px'],
    ],
    [
        'attribute' => 'statusPermohonan',
        'label' => 'Status Permohonan',
        'format' => 'raw',
        'value' => 'statusPermohonann',
        'filter'    => [
            1 => "MENUNGGU PENGESAHAN KJ",
            2 => "DIBATALKAN",
            3 => "TIDAK DISAHKAN KJ",
            4 => "MENUNGGU SEMAKAN",
            6 => "MENUNGGU PERAKUAN",
            7 => "MENUNGGU KELULUSAN",
            8 => "MENUNGGU KELULUSAN",
            9 => "PERMOHONAN DITOLAK",
            10 => "PERMOHONAN BERJAYA"
        ],
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Pilih...', 'multiple' => false], // allows multiple authors to be chosen
    ],
    [
        'attribute' => 'jumlahYuran',
        'label' => 'Yuran Program Dimohon (RM)',
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'jumlahTiketPenerbangan',
        'label' => 'Jumlah Tiket Penerbangan Dimohon (RM)',
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'jumlahPenginapan',
        'label' => 'Jumlah Bayaran Penginapan Dimohon (RM)',
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'layakYuran',
        'label' => 'Yuran Program Layak (RM)',
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'layakTiketPenerbangan',
        'label' => 'Jumlah Tiket Penerbangan Layak (RM)',
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'layakPenginapan',
        'label' => 'Jumlah Bayaran Penginapan Layak (RM)',
        'format' => ['decimal', 2],
    ],
    [
        'label' => 'Ulasan Urusetia',
        'contentOptions' => ['style' => 'width:300px;'],
        'value' => function ($data) {
            return ucwords(strtolower($data->ulasanUL));
        },
    ],
    [
        'attribute' => 'syorYuran',
        'label' => 'Yuran Program Disyorkan (RM)',
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'syorTiketPenerbangan',
        'label' => 'Jumlah Tiket Penerbangan Disyorkan (RM)',
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'syorPenginapan',
        'label' => 'Jumlah Bayaran Penginapan Disyorkan (RM)',
        'format' => ['decimal', 2],
    ],
    [
        'label' => 'Ulasan Pegawai',
        'contentOptions' => ['style' => 'width:300px;'],
        'value' => function ($data) {
            return ucwords(strtolower($data->ulasanBSM));
        },
    ],
    [
        'attribute' => 'lulusYuran',
        'label' => 'Yuran Program Diluluskan (RM)',
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'lulusTiket',
        'label' => 'Jumlah Tiket Penerbangan Diluluskan (RM)',
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'lulusPenginapan',
        'label' => 'Jumlah Bayaran Penginapan Diluluskan (RM)',
        'format' => ['decimal', 2],
    ],
    [
        'label' => 'Ulasan Sektor',
        'contentOptions' => ['style' => 'width:300px;'],
        'value' => function ($data) {
            return ucwords(strtolower($data->ulasanSektor));
        },
    ],

];
?>
<div class="clearfix"></div>

<!--<div class="row">
    <div class="x_panel"> 
    <div class="col-md-12 col-sm-12 col-xs-12">
        <ul>
            <li><span class="label label-default">BARU</span> : Permohonan Baru</li>
            <li><span class="label label-info">DIPERAKUI</span> : Permohonan Telah Diperakui Oleh Pegawai Pelulus Kursus</li>  
            <li><span class="label label-success">LULUS</span> : Permohonan Telah Diluluskan Oleh Ketua JFPIU</li>
            <li><span class="label label-danger">TIDAK DIPERAKUI</span> : Permohonan Tidak Diperakui</li>
            <li><span class="label label-danger">TIDAK DILULUSKAN</span> : Permohonan Tidak Diluluskan</li>
            <li><span class="label label-primary">JEMPUTAN</span> : Permohonan Jemputan Wajib</li>  
        </ul>
    </div>
    </div>
</div>-->

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <?php if ($type == 'aka') {
                    $a = 'Akademik';
                } elseif ($type == 'pen') {
                    $a = 'Pentadbiran';
                } else {
                    $a = 'DILULUSKAN';
                } ?>
                <h5>Senarai Permohonan Kursus Luar <h3><span class="label label-primary" style="color: white"><?= $a; ?></span>
                        <?= ExportMenu::widget([
                            'dataProvider' => $dataProviderKursusLuar,
                            'columns' => $gridColumnsKursusLuarExport,
                            'filename' => 'Senarai Permohonan Kursus Luar Kakitangan ' . $a . ' ' . date('Y-m-d'),
                            'clearBuffers' => true,
                            'stream' => false,
                            'folder' => '@app/web/files/myidp/.',
                            'linkPath' => '/files/myidp/',
                            'batchSize' => 10,
                            //                'deleteAfterSave' => true
                        ]);
                        ?>


                    </h3>
                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?php Pjax::begin(); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProviderKursusLuar,
                    'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsKursusLuar,
                ]);
                ?>
                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>
</div>