<?php
/* @var $this yii\web\View */

use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Html;

// use yii\widgets\ActiveForm;

$layak = 'layak' . $lpp->tahun;
$jumlah_bhg2 = 'jum' . $lpp->tahun;
$akses = app\models\lppums\TblStafAkses::find()
    ->where(['ICNO' => Yii::$app->user->identity->ICNO])
    ->andWhere(['IN', 'akses_id', [1]])
    ->exists();

if ($lpp->PPP == \Yii::$app->user->identity->ICNO) {
    if (is_null($model->ulasan_PPP_tt)) {
        $acc = false;
    } else {
        $acc = true;
    }
} else {
    $acc = true;
}

?>

<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script>

<?php
// javascript for triggering the dialogs
$js = <<< JS
function delay(callback, ms) {
    var timer = 0;
  return function() {
    var context = this, args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function () {
      callback.apply(context, args);
    }, ms || 0);
  };
}

$("[id*='markah_PPK']").keyup(delay(function (e) {
    if (this.value.length <= this.maxLength) {
      $(this).parent().parent().parent().closest('tr').nextAll().eq(1).find("[id*='markah_PPK']").focus();
      $(this).parent().parent().parent().closest('tr').nextAll().eq(1).find("[id*='markah_PPK']").val("");
    //   alert('asdad');
    }
}, 900));

$("[id*='markah_PPP']").keyup(delay(function (e) {
    if (this.value.length <= this.maxLength) {
      $(this).parent().parent().parent().closest('tr').nextAll().eq(1).find("[id*='markah_PPP']").focus();
      $(this).parent().parent().parent().closest('tr').nextAll().eq(1).find("[id*='markah_PPP']").val("");
    //   alert('asdad');
    }
}, 900));
JS;

// register your javascript
$this->registerJs($js);
?>



<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <p align="center"><strong>PERINGATAN</strong></p>
                    <p>Pegawai Yang Dinilai (PYD) dan Pegawai Penilai Pertama (PPP) hendaklah memberi perhatian kepada perkara-perkara berikut sebelum dan semasa melengkapkan borang ini:</p>
                    <ol type="i">
                        <li>PYD dan PPP hendaklah berbincang bersama dalam membuat penetapan Sasaran Kerja Tahunan (SKT) dan menurunkan tandatangan yang ditetapkan di Bahagian I;</li><br>
                        <li>SKT yang ditetapkan hendaklah mengandungi sekurang-kurangnya satu petunjuk prestasi iaitu samada kuantiti, kualiti, masa atau kos bergantung kepada kesesuaian sesuatu aktiviti / projek;</li><br>
                        <li>SKT yang telah ditetapkan pada awal tahun hendaklah dikaji semula di pertengahan tahun. SKT yang digugurkan atau ditambah hendaklah dicatatkan di ruangan Bahagian II;</li><br>
                        <li>PYD dan PPP hendaklah membuat laporan dan ulasan keseluruhan pencapaian SKT pada akhir tahun serta menurunkan tandatangan di ruangan yang ditetapkan di Bahagian III; dan</li><br>
                        <li>Sila rujuk Panduan Penyediaan Sasaran Kerja Tahunan (SKT) untuk keterangan lanjut.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong>Bahagian I - Penetapan Sasaran Kerja Tahunan</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p><i>(PYD dan PPP hendaklah berbincang bersama sebelum menetapkan SKT dan petunjuk prestasinya)</i></p>

                    <?=
                    GridView::widget([
                        'tableOptions' => [
                            'class' => 'table table-sm table-bordered',
                        ],
                        'emptyText' => 'Tiada rekod penetapan SKT',
                        'summary' => '',
                        'dataProvider' => $sktProvider,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'attribute' => 'skt_projek',
                                'label' => 'Ringkasan Aktiviti / Projek',
                                'headerOptions' => ['class' => 'text-center col-md-2'],
                                //'contentOptions' => ['class'=>'text-center'],
                            ],
                            [
                                'header' => 'Petunjuk Prestasi',
                                'headerOptions' => ['class' => 'text-center col-md-2'],
                                //'contentOptions' => ['class'=>'text-center'],
                                'value' => function ($model) {
                                    return '<dl><dt>Kuantiti</dt><dd>' . (is_null($model->skt_kuantiti) ? '-' : $model->skt_kuantiti) . '</dd>' .
                                        '<dt>Kualiti</dt><dd>' . (is_null($model->skt_kualiti) ? '-' : $model->skt_kualiti) . '</dd>' .
                                        '<dt>Masa</dt><dd>' . (is_null($model->skt_masa) ? '-' : $model->skt_masa) . '</dd>' .
                                        '<dt>Kos</dt><dd>' . (is_null($model->skt_kos) ? '-' : $model->skt_kos) . '</dd></dl>';
                                },
                                'format' => 'html',
                            ],
                            [
                                'attribute' => 'skt_sasar',
                                'header' => 'Sasaran Kerja',
                                'headerOptions' => ['class' => 'text-center col-md-2'],
                                //'contentOptions' => ['class'=>'text-center'],
                                'format' => 'html'
                            ],
                            [
                                'attribute' => 'skt_capai',
                                'header' => 'Pencapaian Sebenar',
                                'headerOptions' => ['class' => 'text-center col-md-2'],
                                //'contentOptions' => ['class'=>'text-center'],
                                'format' => 'html'
                            ],
                            [
                                'attribute' => 'skt_ulasan',
                                'header' => 'Ulasan',
                                'headerOptions' => ['class' => 'text-center col-md-2'],
                                //'contentOptions' => ['class'=>'text-center'],
                                'value' => function ($model) {
                                    if (is_null($model->skt_ulasan)) {
                                        return '';
                                    } else {
                                        return $model->skt_ulasan;
                                    }
                                },
                                'format' => 'html'
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong>Bahagian II - Kajian Semula Sasaran Kerja Tahunan Pertengahan Tahun</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p><strong>1. Aktiviti / Projek Yang Ditambah</strong><br>
                        <i>(PYD hendaklah menyenaraikan aktiviti / projek yang ditambah beserta petunjuk prestasinya setelah berbincang dengan PPP)</i>
                    <p>

                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'tableOptions' => [
                                'class' => 'table table-sm table-bordered',
                            ],
                            'emptyText' => 'Tiada rekod penetapan SKT',
                            'summary' => '',
                            'dataProvider' => $skt2Provider,
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'Bil',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'attribute' => 'skt_projek',
                                    'label' => 'Ringkasan Aktiviti / Projek',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                ],
                                [
                                    'header' => 'Petunjuk Prestasi',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                    'value' => function ($model) {
                                        return '<dl><dt>Kuantiti</dt><dd>' . (is_null($model->skt_kuantiti) ? '-' : $model->skt_kuantiti) . '</dd>' .
                                            '<dt>Kualiti</dt><dd>' . (is_null($model->skt_kualiti) ? '-' : $model->skt_kualiti) . '</dd>' .
                                            '<dt>Masa</dt><dd>' . (is_null($model->skt_masa) ? '-' : $model->skt_masa) . '</dd>' .
                                            '<dt>Kos</dt><dd>' . (is_null($model->skt_kos) ? '-' : $model->skt_kos) . '</dd></dl>';
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'attribute' => 'skt_sasar',
                                    'header' => 'Sasaran Kerja',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                    'format' => 'html'
                                ],
                                [
                                    'attribute' => 'skt_capai',
                                    'header' => 'Pencapaian Sebenar',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                    'format' => 'html'
                                ],
                                [
                                    'attribute' => 'skt_ulasan',
                                    'header' => 'Ulasan',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                    'format' => 'html'
                                ],
                            ],
                        ]);
                        ?>
                    </div>

                    <pagebreak />
                    <p><strong>2. Aktiviti / Projek Yang Digugurkan</strong><br>
                        <i>(PYD hendaklah menyenaraikan aktiviti / projek yang digugurkan setelah berbincang dengan PPP)</i>
                    <p>

                    <p align="center"><b>Senarai SKT yang Telah Ditetapkan</b></p>

                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'tableOptions' => [
                                'class' => 'table table-sm table-bordered',
                            ],
                            'emptyText' => 'Tiada rekod penetapan SKT',
                            'summary' => '',
                            'dataProvider' => $skt2Provider1,
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'Bil',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'attribute' => 'skt_projek',
                                    'label' => 'Ringkasan Aktiviti / Projek',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                ],
                                [
                                    'header' => 'Petunjuk Prestasi',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                    'value' => function ($model) {
                                        return '<dl><dt>Kuantiti</dt><dd>' . (is_null($model->skt_kuantiti) ? '-' : $model->skt_kuantiti) . '</dd>' .
                                            '<dt>Kualiti</dt><dd>' . (is_null($model->skt_kualiti) ? '-' : $model->skt_kualiti) . '</dd>' .
                                            '<dt>Masa</dt><dd>' . (is_null($model->skt_masa) ? '-' : $model->skt_masa) . '</dd>' .
                                            '<dt>Kos</dt><dd>' . (is_null($model->skt_kos) ? '-' : $model->skt_kos) . '</dd></dl>';
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'attribute' => 'skt_sasar',
                                    'header' => 'Sasaran Kerja',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                    'format' => 'html'
                                ],
                                [
                                    'attribute' => 'skt_capai',
                                    'header' => 'Pencapaian Sebenar',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                    'format' => 'html'
                                ],
                                [
                                    'attribute' => 'skt_ulasan',
                                    'header' => 'Ulasan',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                    'format' => 'html'
                                ]
                            ],
                        ]);
                        ?>
                    </div>
                    <pagebreak />

                    <p align="center"><b>Senarai SKT yang Digugurkan</b></p>
                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'tableOptions' => [
                                'class' => 'table table-sm table-bordered',
                            ],
                            'emptyText' => 'Tiada rekod pengguguran SKT',
                            'summary' => '',
                            'dataProvider' => $skt2Provider2,
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'Bil',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'attribute' => 'skt_projek',
                                    'label' => 'Aktiviti / Projek',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return $model->skt_projek . '<br>' .
                                            '<strong>Petunjuk Prestasi</strong> (Kuantiti / Kualiti / Masa / Kos)<br>' .
                                            $model->skt_kuantiti . ' / ' . $model->skt_kualiti . ' / ' . $model->skt_masa . ' / ' . $model->skt_kos . '<br>' .
                                            '<strong>Sasaran Kerja</strong> (Berdasarkan petunjuk prestasi)<br>' .
                                            $model->skt_sasar;
                                    },
                                    'format' => 'raw'
                                    //'contentOptions' => ['class'=>'text-center'],
                                ],
                            ],
                        ]);
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong>Bahagian III - Laporan dan Ulasan Keseluruhan Pencapaian Sasaran Kerja Tahunan Pada Akhir Tahun Oleh PYD dan PPP</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">1. Laporan / Ulasan Oleh PYD</label>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                            <?php echo '<p>' . $modelskt->skt_ulasan_pyd . '</p>'; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">2. Laporan / Ulasan Oleh PPP</label>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                            <?php echo '<p>' . $modelskt->skt_ulasan_ppp . '</p>'; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong>Senarai Tugas</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?=
                    DetailView::widget([
                        'model' => $lpp,
                        'attributes' => [
                            //'ICNO',
                            [
                                'label' => 'NAMA',
                                'value' => function ($model) {
                                    return strtoupper($model->pyd->CONm);
                                },
                                'captionOptions' => ['style' => 'width:25%'],
                                'format' => 'html',
                            ],
                            [
                                'label' => 'JAWATAN',
                                'value' => function ($model) {
                                    return strtoupper($model->gredJawatan->nama) . ' ' . $model->gredJawatan->gred;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'BERTANGGUNGJAWAB KEPADA',
                                'value' => function ($model) {
                                    return '';
                                },
                                'format' => 'html',
                            ],
                            //                               [
                            //                                   'label' => 'SENARAI TUGAS',
                            //                                   'value' => function($model){
                            //                                       return '';
                            //                                   },
                            //                                   'format' => 'html',
                            //                               ],
                        ],
                    ]);
                    ?>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'tableOptions' => [
                                'class' => 'table table-sm table-bordered',
                            ],
                            'emptyText' => 'Tiada rekod penetapan SKT',
                            'summary' => '',
                            'dataProvider' => $senaraiProvider,
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'Bil',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'attribute' => 'senarai_tugas',
                                    'label' => 'Senarai Tugas',
                                    'headerOptions' => ['class' => 'text-center col-md-9'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <p align="center"><strong>PERINGATAN</strong></p>
                    <p>Pegawai Penilai (PP) iaitu Pegawai Penilai Pertama (PPP) dan Pegawai Penilai Kedua (PPK) serta Pegawai Yang Dinilai (PYD) hendaklah memberi perhatian kepada perkara-perkara berikut sebelum dan semasa membuat penilaian:</p>
                    <ol type="i">
                        <li>PYD hendaklah menyemak maklumat di <strong>Bahagian I</strong> di bawah dan melengkapkan Bahagian I dalam borang <strong>Sasaran Kerja Tahunan (SKT)</strong> pada awal tahun;</li><br>
                        <li>PYD hendaklah melengkapkan <strong>Bahagian II</strong> manakala PP hendaklah melengkapkan <strong>Bahagian III</strong> hingga <strong>Bahagian IX</strong>;</li><br>
                        <li>PYD hendaklah menyenaraikan tugas-tugas yang dipertanggungjawabkan sepanjang tahun penilaian;</li><br>
                        <li>PYD dan PP hendaklah merujuk Panduan Pelaksanaan Sistem Penilaian Prestasi Pegawai Perkhidmatan Awam Malaysia (Tahun 2002) sekiranya memerlukan keterangan lanjut semasa mengenai Borang Laporan Penilaian Prestasi Tahunan (LNPT) dan membuat penilaian;</li><br>
                        <li>PP hendaklah menggunakan <strong>Skala Penilaian Prestasi</strong>; dan</li><br>
                        <li>PP hendaklah memaklumkan kepada PYD langkah-langkah meningkatkan prestasi/kemajuan kerjaya yang perlu dilakukan sebelum menandatangani di ruang <strong>Bahagian VIII</strong>.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong>Bahagian I - Maklumat Pegawai</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?=
                    DetailView::widget([
                        'model' => $lpp,
                        'attributes' => [
                            [
                                'label' => 'Nama PYD',
                                'value' => function ($model) {
                                    return $model->pyd->CONm;
                                },
                                'captionOptions' => ['style' => 'width:20%'],
                            ],
                            [
                                'label' => 'Jawatan / Gred',
                                'value' => function ($model) {
                                    return $model->gredJawatan->nama . ' ' . $model->gredJawatan->gred;
                                },
                            ],
                            [
                                'label' => 'JAFPIB',
                                'value' => function ($model) {
                                    return $model->department->fullname;
                                },
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong>Bahagian II - Kegiatan dan Sumbangan Di Luar Tugas Rasmi</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div>
                        <p>
                        <ul>
                            <li>
                                Senaraikan kegiatan dan sumbangan di luar tugas rasmi seperti sukan / pertubuhan / sumbangan kreatif di peringkat komuniti / Jabatan / daerah / Negeri / Negara / Antarabangsa yang berfaedah kepada organisasi / komuniti / negara pada tahun yang dinilai.
                            </li>
                        </ul>
                        </p>

                        <div class="table-responsive">
                            <?=
                            GridView::widget([
                                'tableOptions' => [
                                    'class' => 'table table-sm table-bordered',
                                ],
                                'emptyText' => 'Tiada rekod kegiatan / aktiviti / sumbangan',
                                'summary' => '',
                                'dataProvider' => $dataProvider1,
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\SerialColumn',
                                        'header' => 'Bil',
                                        'headerOptions' => ['class' => 'text-center col-md-1'],
                                        'contentOptions' => ['class' => 'text-center'],
                                    ],
                                    [
                                        'attribute' => 'sumb',
                                        'label' => 'Senarai Kegiatan / Aktiviti / Sumbangan',
                                        'headerOptions' => ['class' => 'text-center col-md-4'],
                                        //'contentOptions' => ['class'=>'text-center'],
                                    ],
                                    [
                                        'attribute' => 'sumb_peringkat',
                                        'label' => 'Peringkat Kegiatan / Aktiviti / Sumbangan',
                                        'headerOptions' => ['class' => 'text-center col-md-4'],
                                        //'contentOptions' => ['class'=>'text-center'],
                                    ],
                                ],
                            ]);
                            ?>
                        </div>
                    </div>

                    <pagebreak />

                    <p>
                    <ul>
                        <li>
                            Senaraikan program latihan (seminar, kursus, bengkel dan lain-lain) yang dihadiri dalam tahun yang dinilai.
                        </li>
                    </ul>
                    </p>


                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center col-md-1" rowspan="2">Bil</th>
                                <th class="text-center col-md-4" rowspan="2">Nama Latihan</th>
                                <th class="text-center col-md-2" rowspan="2">Tarikh / Tambah</th>
                                <th class="text-center col-md-1" rowspan="2">Tempat</th>
                                <th class="text-center" colspan="2">Pencapaian Mata CPD</th>

                            </tr>
                            <tr>
                                <th class="text-center">Mata Minima CPD</th>
                                <th class="text-center">Jumlah Mata CPD Terkumpul</th>
                            </tr>

                            <?php if (!$latih_tmbh) { ?>
                                <tr>
                                    <td colspan="7">Tiada rekod program latihan</td>
                                </tr>
                                <?php } else {
                                foreach ($latih_tmbh as $ind => $lth) { ?>
                                    <tr>
                                        <td class="text-center"><?= $ind + 1; ?></td>
                                        <td><?= ($lpp->tahun >= 2020) ? $lth->sasaran3->tajukLatihan : ($lth->namaLatihan->vcsl_nama_latihan ?? '-'); ?></td>
                                        <td class="text-center"><?php
                                                                $mula = ($lpp->tahun >= 2020) ? strtotime($lth->tarikhMula) : strtotime($lth->vcl_tkh_mula);
                                                                $tamat = ($lpp->tahun >= 2020) ? strtotime($lth->tarikhAkhir) : strtotime($lth->vcl_tkh_tamat);
                                                                $interval = $tamat - $mula;
                                                                //$interval = add(1);
                                                                echo Yii::$app->formatter->asDate(($lpp->tahun >= 2020) ? $lth->tarikhMula : $lth->vcl_tkh_mula, 'dd') . ' - ' . Yii::$app->formatter->asDate(($lpp->tahun >= 2020) ? $lth->tarikhAkhir : $lth->vcl_tkh_tamat, 'dd MMM yyyy') . ' (';
                                                                //echo $interval->format('%a hari').')'; 
                                                                echo (round($interval / (60 * 60 * 24)) + 1) . ' hari)';
                                                                ?></td>
                                        <td class="text-center"><?= ($lpp->tahun >= 2020) ? $lth->lokasi : ($lth->namaLatihan->vcsl_tempat ?? '-'); ?></td>
                                        <?php if ($ind == 0) { ?>
                                            <td class="text-center" rowspan="<?= count($latih_tmbh) ?>">
                                                <?php if ($lpp->tahun >= 2020) { ?>
                                                    <?= $mataCpd->idp_mata_min; ?>
                                                <?php } else { ?>
                                                    <?= !is_null($mataCpd) ? (!isset($mataCpd2->{$layak}) ? '' : $mataCpd2->{$layak}) : (!isset($mataCpd->idp_mata_min) ? 0 : $mataCpd->idp_mata_min); ?>
                                                <?php  } ?>
                                            </td>
                                            <td class="text-center" rowspan="<?= count($latih_tmbh) ?>">
                                                <?php if ($lpp->tahun >= 2020) { ?>
                                                    <?= $summ; ?>
                                                <?php } else { ?>
                                                    <?= !is_null($mataCpd) ? (!isset($mataCpd2->{$jumlah_bhg2}) ? '' : $mataCpd2->{$jumlah_bhg2}) : (!isset($mataCpd->jum_mata_dikira) ? 0 : $mataCpd->jum_mata_dikira); ?>
                                                <?php  } ?>


                                            <?php } ?>
                                            </td>
                                    </tr>
                            <?php }
                            } ?>

                        </table>
                    </div>

                    <pagebreak />

                    <p>
                    <ul>
                        <li>
                            Senarai latihan yang ditambah.
                        </li>
                    </ul>
                    </p>

                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'tableOptions' => [
                                'class' => 'table table-sm table-bordered',
                            ],
                            'emptyText' => 'Tiada rekod tambahan program latihan',
                            'summary' => '',
                            'dataProvider' => $dataProvider3,
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'Bil',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'attribute' => 'lat_tamb',
                                    'label' => 'Nama Latihan',
                                    'headerOptions' => ['class' => 'text-center'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                ],
                                [
                                    'label' => 'Tarikh / Tambah',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        $mula = strtotime($model->lat_tamb_mula);
                                        $tamat = strtotime($model->lat_tamb_tamat);
                                        $interval = $tamat - $mula;
                                        //$interval = add(1);
                                        return Yii::$app->formatter->asDate($model->lat_tamb_mula, 'dd') . ' - ' . Yii::$app->formatter->asDate($model->lat_tamb_tamat, 'dd MMM yyyy') . ' (' . (round($interval / (60 * 60 * 24)) + 1) . ' hari)';
                                        //echo $interval->format('%a hari').')'; 
                                        //echo (round($interval / (60 * 60 * 24)) + 1).' hari)';        
                                    },
                                ],
                                [
                                    'attribute' => 'lat_tamb_tempat',
                                    'label' => 'Tempat',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                            ],
                        ]);
                        ?>
                    </div>

                    <p>
                    <ul>
                        <li>
                            Senarai latihan yang diperlukan.
                        </li>
                    </ul>
                    </p>

                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'tableOptions' => [
                                'class' => 'table table-sm table-bordered',
                            ],
                            'emptyText' => 'Tiada rekod latihan yang diperlukan',
                            'summary' => '',
                            'dataProvider' => $dataProvider2,
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'Bil',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'attribute' => 'lat_perlu',
                                    'label' => 'Nama Bidang / Latihan',
                                    'headerOptions' => ['class' => 'text-center'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                ],
                                [
                                    'attribute' => 'lat_sebab_perlu',
                                    'label' => 'Sebab Diperlukan',
                                    'headerOptions' => ['class' => 'text-center'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong>Bahagian III - Penghasilan Kerja</strong> (Wajaran <?= $mrkhBhg['markah_bahagian']; ?>%) </h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p>
                        Pegawai Penilai dikehendaki memberikan penilaian berdasarkan pencapaian kerja sebenar PYD berbanding dengan SKT yang ditetapkan. Penilaian hendaklah berasaskan kepada penjelasan setiap kriteria yang dinyatakan di bawah dengan menggunakan skala 1 hingga 10:
                    </p>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center col-md-1">Bil</th>
                                <th class="text-center">Kriteria</th>
                                <th class="text-center col-md-1">PPP</th>
                                <th class="text-center col-md-1">PPK</th>
                            </tr>

                            <?php
                            $abc = 0;

                            foreach ($lpp_mrkh as $ind => $p) { ?>
                                <tr>
                                    <td class="text-center"><?= $abc + 1; ?></td>
                                    <td><?= '<b>' . $kriteria[$abc]['kriteria']['kriteria_label'] . '</b><br>' . $kriteria[$abc]['kriteria']['kriteria']; ?></td>
                                    <td class="text-center"><?= $akses ? $p->markah_PPP : 'PPP'; ?></td>
                                    <td class="text-center"><?= $akses ? $p->markah_PPK : 'PPK'; ?></td>

                                </tr>
                            <?php
                                $abc += 1;
                            } ?>

                            <tr>
                                <th colspan="2" class="text-center">Jumlah markah mengikut wajaran</th>
                                <th class="text-center">
                                    <math>
                                        <mfrac>
                                            <mn><?= $akses ? \Yii::$app->formatter->asDecimal(array_sum(array_column($jumlah, 'markah_PPP')), 0) : 'PPP'; ?></mn>
                                            /
                                            <mn><?= $abc * 10 ?></mn>
                                        </mfrac>
                                        <mo>x</mo>
                                        <mn><?= $mrkhBhg['markah_bahagian'] ?></mn>
                                        <mo>=</mo>
                                        <mn>
                                            <?php
                                            $sum = array_sum(array_column($jumlah, 'markah_PPP'));
                                            $total = ($sum / ($abc * 10)) * $mrkhBhg['markah_bahagian'];
                                            echo $akses ? \Yii::$app->formatter->asDecimal($total, 2) : 'PPP';
                                            ?>
                                        </mn>
                                    </math>
                                </th>
                                <th class="text-center">
                                    <math>
                                        <mfrac>
                                            <mn><?= $akses ? \Yii::$app->formatter->asDecimal(array_sum(array_column($jumlah, 'markah_PPK')), 0) : 'PPK'; ?></mn>
                                            /
                                            <mn><?= $abc * 10 ?></mn>
                                        </mfrac>
                                        <mo>x</mo>
                                        <mn><?= $mrkhBhg['markah_bahagian'] ?></mn>
                                        <mo>=</mo>
                                        <mn>
                                            <?php
                                            $sum1 = array_sum(array_column($jumlah, 'markah_PPK'));
                                            $total1 = ($sum1 / ($abc * 10)) * $mrkhBhg['markah_bahagian'];
                                            echo $akses ? \Yii::$app->formatter->asDecimal($total1, 2) : 'PPK';
                                            ?>
                                        </mn>
                                    </math>
                                </th>
                            </tr>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<?php if (isset($mrkhBhg3['markah_bahagian'])) { ?>
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h4><strong>Bahagian IV - Pengetahuan Dan Kemahiran</strong> (Wajaran <?= $mrkhBhg3['markah_bahagian'] ?>%)</h4>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <p>
                            Pegawai Penilai dikehendaki memberikan penilaian berasaskan penjelasan tiap-tiap kriteria yang dinyatakan dengan menggunakan skala 1 hingga 10:
                        </p>

                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <tr>
                                    <th class="text-center col-md-1">Bil</th>
                                    <th class="text-center">Kriteria</th>
                                    <th class="text-center col-md-1">PPP</th>
                                    <th class="text-center col-md-1">PPK</th>
                                </tr>

                                <?php
                                $abc = 0;

                                foreach ($lpp_mrkh3 as $ind => $p) { ?>
                                    <tr>
                                        <td class="text-center"><?= $abc + 1; ?></td>
                                        <td><?= '<b>' . $kriteria3[$abc]['kriteria']['kriteria_label'] . '</b><br>' . $kriteria3[$abc]['kriteria']['kriteria']; ?></td>
                                        <td class="text-center"><?= $akses ? $p->markah_PPP : 'PPP'; ?></td>
                                        <td class="text-center"><?= $akses ? $p->markah_PPK : 'PPK'; ?></td>

                                    </tr>
                                <?php
                                    $abc += 1;
                                } ?>

                                <tr>
                                    <th colspan="2" class="text-center">Jumlah markah mengikut wajaran</th>
                                    <th class="text-center">
                                        <math>
                                            <mfrac>
                                                <mn><?= $akses ? \Yii::$app->formatter->asDecimal(array_sum(array_column($jumlah3, 'markah_PPP')), 0) : 'PPP'; ?></mn>
                                                /
                                                <mn><?= $abc * 10 ?></mn>
                                            </mfrac>
                                            <mo>x</mo>
                                            <mn><?= $mrkhBhg3['markah_bahagian'] ?></mn>
                                            <mo>=</mo>
                                            <mn>
                                                <?php
                                                $sum = array_sum(array_column($jumlah3, 'markah_PPP'));
                                                $total = ($sum / ($abc * 10)) * $mrkhBhg3['markah_bahagian'];
                                                echo $akses ? \Yii::$app->formatter->asDecimal($total, 2) : 'PPP';
                                                ?>
                                            </mn>
                                        </math>
                                    </th>
                                    <th class="text-center">
                                        <math>
                                            <mfrac>
                                                <mn><?= $akses ? \Yii::$app->formatter->asDecimal(array_sum(array_column($jumlah3, 'markah_PPK')), 0) : 'PPK'; ?></mn>
                                                /
                                                <mn><?= $abc * 10 ?></mn>
                                            </mfrac>
                                            <mo>x</mo>
                                            <mn><?= $mrkhBhg3['markah_bahagian'] ?></mn>
                                            <mo>=</mo>
                                            <mn>
                                                <?php
                                                $sum1 = array_sum(array_column($jumlah3, 'markah_PPK'));
                                                $total1 = ($sum1 / ($abc * 10)) * $mrkhBhg3['markah_bahagian'];
                                                echo $akses ? \Yii::$app->formatter->asDecimal($total1, 2) : 'PPK';
                                                ?>
                                            </mn>
                                        </math>
                                    </th>
                                </tr>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <pagebreak />
<?php } ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong>Bahagian V - Kualiti Peribadi</strong> (Wajaran <?= $mrkhBhg2['markah_bahagian'] ?>%)</h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p>
                        Pegawai Penilai dikehendaki memberikan penilaian berasaskan penjelasan tiap-tiap kriteria yang dinyatakan dengan menggunakan skala 1 hingga 10:
                    </p>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center col-md-1">Bil</th>
                                <th class="text-center">Kriteria</th>
                                <th class="text-center col-md-1">PPP</th>
                                <th class="text-center col-md-1">PPK</th>
                            </tr>

                            <?php
                            $abc = 0;

                            foreach ($lpp_mrkh2 as $ind => $p) { ?>
                                <tr>
                                    <td class="text-center"><?= $abc + 1; ?></td>
                                    <td><?= '<b>' . $kriteria2[$abc]['kriteria']['kriteria_label'] . '</b><br>' . $kriteria2[$abc]['kriteria']['kriteria']; ?></td>
                                    <td class="text-center"><?= $akses ? $p->markah_PPP : 'PPP'; ?></td>
                                    <td class="text-center"><?= $akses ? $p->markah_PPK : 'PPK'; ?></td>

                                </tr>
                            <?php
                                $abc += 1;
                            } ?>

                            <tr>
                                <th colspan="2" class="text-center">Jumlah markah mengikut wajaran</th>
                                <th class="text-center">
                                    <math>
                                        <mfrac>
                                            <mn><?= $akses ? \Yii::$app->formatter->asDecimal(array_sum(array_column($jumlah2, 'markah_PPP')), 0) : 'PPP'; ?></mn>
                                            /
                                            <mn><?= $abc * 10 ?></mn>
                                        </mfrac>
                                        <mo>x</mo>
                                        <mn><?= $mrkhBhg2['markah_bahagian'] ?></mn>
                                        <mo>=</mo>
                                        <mn>
                                            <?php
                                            $sum = array_sum(array_column($jumlah2, 'markah_PPP'));
                                            $total = ($sum / ($abc * 10)) * $mrkhBhg2['markah_bahagian'];
                                            echo $akses ? \Yii::$app->formatter->asDecimal($total, 2) : 'PPP';
                                            ?>
                                        </mn>
                                    </math>
                                </th>
                                <th class="text-center">
                                    <math>
                                        <mfrac>
                                            <mn><?= $akses ? \Yii::$app->formatter->asDecimal(array_sum(array_column($jumlah2, 'markah_PPK')), 0) : 'PPK'; ?></mn>
                                            /
                                            <mn><?= $abc * 10 ?></mn>
                                        </mfrac>
                                        <mo>x</mo>
                                        <mn><?= $mrkhBhg2['markah_bahagian'] ?></mn>
                                        <mo>=</mo>
                                        <mn>
                                            <?php
                                            $sum1 = array_sum(array_column($jumlah2, 'markah_PPK'));
                                            $total1 = ($sum1 / ($abc * 10)) * $mrkhBhg2['markah_bahagian'];
                                            echo $akses ? \Yii::$app->formatter->asDecimal($total1, 2) : 'PPK';
                                            ?>
                                        </mn>
                                    </math>
                                </th>
                            </tr>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong>Bahagian VI - Kegiatan Dan Sumbangan Di Luar Tugas Rasmi</strong> (Wajaran <?= $mrkhBhg4['markah_bahagian'] ?>%)</h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p>
                        Pegawai Penilai dikehendaki memberikan penilaian berasaskan penjelasan tiap-tiap kriteria yang dinyatakan dengan menggunakan skala 1 hingga 10:
                    </p>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center col-md-1">Bil</th>
                                <th class="text-center">Kriteria</th>
                                <th class="text-center col-md-1">PPP</th>
                                <th class="text-center col-md-1">PPK</th>
                            </tr>

                            <?php
                            $abc = 0;

                            foreach ($lpp_mrkh4 as $ind => $p) { ?>
                                <tr>
                                    <td class="text-center"><?= $abc + 1; ?></td>
                                    <td><?= '<b>' . $kriteria4[$abc]['kriteria']['kriteria_label'] . '</b><br>' . $kriteria4[$abc]['kriteria']['kriteria']; ?></td>
                                    <td class="text-center"><?= $akses ? $p->markah_PPP : 'PPP'; ?></td>
                                    <td class="text-center"><?= $akses ? $p->markah_PPK : 'PPK'; ?></td>

                                </tr>
                            <?php
                                $abc += 1;
                            } ?>

                            <tr>
                                <th colspan="2" class="text-center">Jumlah markah mengikut wajaran</th>
                                <th class="text-center">
                                    <math>
                                        <mfrac>
                                            <mn><?= $akses ? \Yii::$app->formatter->asDecimal(array_sum(array_column($jumlah4, 'markah_PPP')), 0) : 'PPP'; ?></mn>
                                            /
                                            <mn><?= $abc * 10 ?></mn>
                                        </mfrac>
                                        <mo>x</mo>
                                        <mn><?= $mrkhBhg4['markah_bahagian'] ?></mn>
                                        <mo>=</mo>
                                        <mn>
                                            <?php
                                            $sum = array_sum(array_column($jumlah4, 'markah_PPP'));
                                            $total = ($sum / ($abc * 10)) * $mrkhBhg4['markah_bahagian'];
                                            echo $akses ? \Yii::$app->formatter->asDecimal($total, 2) : 'PPP';
                                            ?>
                                        </mn>
                                    </math>
                                </th>
                                <th class="text-center">
                                    <math>
                                        <mfrac>
                                            <mn><?= $akses ? \Yii::$app->formatter->asDecimal(array_sum(array_column($jumlah4, 'markah_PPK')), 0) : 'PPK'; ?></mn>
                                            /
                                            <mn><?= $abc * 10 ?></mn>
                                        </mfrac>
                                        <mo>x</mo>
                                        <mn><?= $mrkhBhg4['markah_bahagian'] ?></mn>
                                        <mo>=</mo>
                                        <mn>
                                            <?php
                                            $sum1 = array_sum(array_column($jumlah4, 'markah_PPK'));
                                            $total1 = ($sum1 / ($abc * 10)) * $mrkhBhg4['markah_bahagian'];
                                            echo $akses ? \Yii::$app->formatter->asDecimal($total1, 2) : 'PPK';
                                            ?>
                                        </mn>
                                    </math>
                                </th>
                            </tr>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong>Bahagian VII - Jumlah Markah Keseluruhan</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p>
                        Pegawai Penilai dikehendaki menyemak markah keseluruhan yang diperolehi oleh PYD dalam bentuk peratus (%) berdasarkan jumlah markah bagi setiap bahagian yang diberi markah.<br><br>
                        <i>Pengiraan markah Pegawai Penilai telah dikira bersama dengan ASPEK PENILAIAN AKTIVITI RASMI & LATIHAN.</i>
                    </p>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">

                            <tr>
                                <th class="text-center col-md-2" rowspan="2">Markah Keseluruhan</th>
                                <th class="text-center col-md-2">PPP (%)</th>
                                <th class="text-center col-md-2">PPK (%)</th>
                                <th class="text-center col-md-2">Markah Purata (%)</th>
                            </tr>
                            <tr>

                                <td class="text-center"><?= (($lpp->PPP == \Yii::$app->user->identity->ICNO or $lpp->PPK == \Yii::$app->user->identity->ICNO) or $akses) ? $model->markah_PPP : 'PPP' ?></td>
                                <td class="text-center"><?= (($lpp->PPK == \Yii::$app->user->identity->ICNO) or $akses) ? $model->markah_PPK : 'PPK' ?></td>
                                <td class="text-center">
                                    <?php if (empty($lpp->markahSeluruh)) {
                                        echo 'N/A';
                                    } else {
                                        if ($lpp->PPP_sah == 1 and !is_null($lpp->PP_ALL)) {
                                            echo $lpp->markahSeluruh->markah_PP;
                                        } else if ((($lpp->PPP_sah == 1 and $lpp->PPK_sah == 1) and $lpp->PYD == \Yii::$app->user->identity->ICNO)
                                            or $lpp->PPK == \Yii::$app->user->identity->ICNO or $lpp->PPP == \Yii::$app->user->identity->ICNO
                                            or $akses
                                        ) {
                                            echo $lpp->markahSeluruh->markah_PP;
                                        } else {
                                            echo 'Menunggu Penilaian Selesai';
                                        }
                                    } ?>
                                </td>
                            </tr>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong>Bahagian VIII - Ulasan Keseluruhan Dan Pengesahan Oleh Pegawai Penilai Pertama</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">

                    <div class="control-group">
                        <label class="control-label col-sm-4">1. Tempat PYD bertugas di bawah pengawasan (bulan):</label>
                        <?php if ($acc) {
                            echo '<label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12"></label><br><div class="col-md-12 col-sm-12 col-lg-12 col-xs-12"><p>' . $model1->tempoh_PPP_bulan . '</p></div>';
                        } else { ?>
                            <div class="col-md-1 col-sm-1 col-lg-1 col-xs-12">

                                <?=
                                $model1->tempoh_PPP_bulan;
                                ?>

                            </div>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">2. Penilai Pertama hendaklah memberi ulasan keseluruhan pencapaian prestasi PYD</label>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">i. Prestasi kemajuan</label>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                            <?php if ($acc) {
                                echo '<p>' . $model1->ulasan_PPP_prestasi . '</p>';
                            } else { ?>
                                <?=
                                $model1->ulasan_PPP_prestasi;
                                ?>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">i. Kemajuan kerjaya</label>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                            <?php if ($acc) {
                                echo '<p>' . $model1->ulasan_PPP_kemajuan . '</p>';
                            } else { ?>
                                <?=
                                $model1->ulasan_PPP_kemajuan;
                                ?>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">iii. Penjelasan pemberian markah prestasi 90% dan ke atas (jika berkenaan)</label>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                            <?php if ($acc) {
                                echo '<p>' . $model1->ulasan_PPP_markah . '</p>';
                            } else { ?>
                                <?=
                                $model1->ulasan_PPP_markah;
                                ?>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">3. Adalah disahkan bahawa prestasi pegawai ini telah dimaklumkan kepada PYD</label>
                    </div>

                    <div class="col-md-6">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="col-md-2">Nama PPP</th>
                                <td><?= is_null($lpp->PPP) ? '' : $lpp->ppp->CONm ?></td>
                            </tr>
                            <tr>
                                <th class="col-md-2">Jawatan</th>
                                <td><?= is_null($lpp->PPP) ? '' : strtoupper($lpp->gredJawatanPpp->nama) ?></td>
                            </tr>
                            <tr>
                                <th class="col-md-2">JAFPIB</th>
                                <td><?= is_null($lpp->PPP) ? '' : $lpp->departmentPpp->fullname ?></td>
                            </tr>
                            <tr>
                                <th class="col-md-2">No. KP</th>
                                <td><?= is_null($lpp->PPP) ? '' : $lpp->PPP ?></td>
                            </tr>
                        </table>
                    </div>

                    <div style="clear:both;"></div>

                    <?php if (is_null($model1->ulasan_PPP_tt)) { ?>
                        <?php if (($lpp->PPP == \Yii::$app->user->identity->ICNO)) { ?>
                            <div class="row form-group">
                                <?= Html::submitButton('Simpan', [
                                    'class' => 'btn btn-success pull-right',
                                    'data' => [
                                        'confirm' => 'Adakah anda pasti?',
                                    ],
                                ])
                                ?>
                            </div>
                        <?php } ?>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong>Bahagian IX - Ulasan Keseluruhan Dan Pengesahan Oleh Pegawai Penilai Kedua</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">

                    <div class="control-group">
                        <label class="control-label col-sm-4">1. Tempat PYD bertugas di bawah pengawasan (bulan):</label>
                        <?php if ($acc) {
                            echo '<label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12"></label><br><div class="col-md-12 col-sm-12 col-lg-12 col-xs-12"><p>' . $model1->tempoh_PPK_bulan . '</p></div>';
                        } else { ?>
                            <div class="col-md-1 col-sm-1 col-lg-1 col-xs-12">

                                <?=
                                $model->tempoh_PPK_bulan;
                                ?>

                            </div>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">2. PPK hendaklah memberi ulasan keseluruhan pencapaian prestasi PYD berasaskan ulasan keseluruhan oleh PPP</label>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                            <?php if ($acc) {
                                echo '<p>' . $model1->ulasan_PPK . '</p>';
                            } else { ?>
                                <?=
                                $form->field($model1, 'ulasan_PPK')->textArea(['class' => 'form-control', 'rows' => 5, 'placeholder' => '------------------------- Tiada sebarang ulasan oleh PPK -------------------------', 'disabled' => $acc])->label(false);
                                ?>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">3. PPK hendaklah memberi ulasan penjelasan pemberian markah prestasi 90% dan ke atas (jika berkenaan)</label>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                            <?php if ($acc) {
                                echo '<p>' . $model1->ulasan_PPK_markah . '</p>';
                            } else { ?>
                                <?=
                                $form->field($model1, 'ulasan_PPK_markah')->textArea(['class' => 'form-control', 'rows' => 5, 'placeholder' => '------------------------- Tiada sebarang ulasan oleh PPK -------------------------', 'disabled' => $acc])->label(false);
                                ?>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="col-md-2">Nama PPK</th>
                                <td><?= is_null($lpp->PPK) ? '' : $lpp->ppk->CONm ?></td>
                            </tr>
                            <tr>
                                <th class="col-md-2">Jawatan</th>
                                <td><?= is_null($lpp->PPK) ? '' : strtoupper($lpp->gredJawatanPpk->nama) ?></td>
                            </tr>
                            <tr>
                                <th class="col-md-2">JAFPIB</th>
                                <td><?= is_null($lpp->PPK) ? '' : $lpp->departmentPpk->fullname ?></td>
                            </tr>
                            <tr>
                                <th class="col-md-2">No. KP</th>
                                <td><?= is_null($lpp->PPK) ? '' : $lpp->PPK ?></td>
                            </tr>
                        </table>
                    </div>

                    <div style="clear:both;"></div>

                    <?php if (is_null($model1->ulasan_PPK_tt_datetime)) { ?>
                        <?php if (($lpp->PPK == \Yii::$app->user->identity->ICNO)) { ?>
                            <div class="row form-group">
                                <?= Html::submitButton('Simpan', [
                                    'class' => 'btn btn-success pull-right',
                                    'data' => [
                                        'confirm' => 'Adakah anda pasti?',
                                    ],
                                ])
                                ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong>Pengesahan</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h4><strong>Pengesahan Pegawai Yang Dinilai (PYD)</strong></h4>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="row">
                                    <p align="center"><strong>PYD <?= ($lpp->PYD_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN LAPORAN PENILAIAN PRESTASI TAHUN <?= $lpp->tahun; ?> <?= ($lpp->PYD_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lpp->PYD_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>
                                    <ol>
                                        <li>Pastikan Laporan Penilaian Prestasi Tahun <?= $lpp->tahun; ?> telah dilengkapkan sebelum membuat pengesahan</li>
                                        <li>Laporan Penilaian Prestasi yang telah dibuat pengesahan tidak boleh dikemaskini kerana:</li>
                                        <?php if (is_null($lpp->PP_ALL)) { ?>
                                            <ol type="i">
                                                <li>PPP akan mula menilai Laporan Penilaian Prestasi Tahun <?= $lpp->tahun; ?> PYD</li>
                                                <li>PPK akan mula menilai Laporan Penilaian Prestasi Tahun <?= $lpp->tahun; ?> PYD (setelah PPP membuat pengesahan)</li>
                                            </ol>
                                        <?php } else { ?>
                                            <ol type="i">
                                                <li>PP akan mula menilai Laporan Penilaian Prestasi Tahun <?= $lpp->tahun; ?> PYD</li>
                                            </ol>
                                        <?php } ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h4><strong>Pengesahan <?= is_null($lpp->PP_ALL) ? 'Pegawai Penilai Pertama (PPP)' : 'Pegawai Penilai Keseluruhan (PP)' ?></strong></h4>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="row">
                                    <p align="center"><strong><?= is_null($lpp->PP_ALL) ? 'PPP' : 'PP' ?> <?= ($lpp->PPP_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN LAPORAN PENILAIAN PRESTASI TAHUN <?= $lpp->tahun; ?> <?= ($lpp->PPP_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lpp->PPP_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>
                                    <ol>
                                        <li>Pastikan semua laporan/ulasan/komen pada Laporan Penilaian Prestasi Tahun <?= $lpp->tahun; ?> telah dilengkapkan sebelum membuat pengesahan</li>

                                        <li>Laporan Penilaian Prestasi yang telah dibuat pengesahan tidak boleh dikemaskini kerana:</li>
                                        <?php if (is_null($lpp->PP_ALL)) { ?>
                                            <ol type="i">
                                                <li>PPK akan mula menilai Laporan Penilaian Prestasi Tahun <?= $lpp->tahun; ?> PYD</li>
                                            </ol>
                                        <?php } else { ?>
                                            <ol type="i">
                                                <li>LPP akan disahkan oleh Ketua Jabatan</li>
                                            </ol>
                                        <?php } ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (is_null($lpp->PP_ALL)) { ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h4><strong>Pengesahan Pegawai Penilai Kedua (PPK)</strong></h4>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <p align="center"><strong>PPK <?= ($lpp->PPK_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN LAPORAN PENILAIAN PRESTASI TAHUN <?= $lpp->tahun; ?> <?= ($lpp->PPK_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lpp->PPK_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>
                                        <ol>
                                            <li>Pastikan semua laporan/ulasan/komen pada Laporan Penilaian Prestasi Tahun <?= $lpp->tahun; ?> telah dilengkapkan sebelum membuat pengesahan</li>
                                            <li>Laporan Penilaian Prestasi yang telah dibuat pengesahan tidak boleh dikemaskini kerana:</li>
                                            <ol type="i">
                                                <li>LPP akan disahkan oleh Ketua Jabatan</li>
                                            </ol>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>