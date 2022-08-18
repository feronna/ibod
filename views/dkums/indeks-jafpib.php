<?php

use app\models\dkums\TblMain;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\dkums\YearSettings;
use app\models\hronline\Department;
use app\models\hronline\Kumpulankhidmat;
use app\models\hronline\StatusLantikan;
use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

?>

<?= Yii::$app->controller->renderPartial('_menu'); ?>

<div class="row">

    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-search"></i> Search</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?= Html::beginForm($url, 'GET', ['class' => 'form-horizontal form-label-left disable-submit-buttons']); ?>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">JAFPIB</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Select2::widget([
                        'name' => 'GetDeptId',
                        'value' => $deptId,
                        'options' => ['placeholder' => '-- Select All --'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        'data' => ArrayHelper::map($data_jafpib, 'id', 'fullname')
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun</label>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <?= Html::dropDownList('GetTahun', $tahun, ArrayHelper::map(YearSettings::find()->all(), 'tahun', 'tahun'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Fasa</label>
                <div class="col-md-1 col-sm-1 col-xs-12">
                    <?= Html::dropDownList('GetFasa', $fasa, [1 => 1, 2 => 2], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Lantikan</label>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <?= Html::dropDownList(
                        'GetLantikan',
                        $lantikan,
                        ArrayHelper::map(StatusLantikan::find()->where(['IN', 'ApmtStatusCd', [1, 3]])->all(), 'ApmtStatusCd', 'ApmtStatusNm'),
                        ['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'prompt' => 'Semua...']
                    ); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori</label>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <?= Html::dropDownList(
                        'GetKategori',
                        $kategori,
                        ArrayHelper::map(Kumpulankhidmat::find()->all(), 'id', 'name'),
                        ['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'prompt' => 'Semua...']
                    ); ?>
                </div>
            </div>
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                    <?= Html::submitButton('<i class="fa fa-search"></i> Carian', ['class' => 'btn btn-primary']); ?>
                </div>
            </div>
            <?= Html::endForm(); ?>

        </div>

    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-check-square-o"></i>&nbsp;<strong>Indeks JAFPIB</strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">


                <table class="table table-striped table-sm jambo_table table-bordered">
                    <thead>
                        <tr class="headings">
                            <th class="text-center" width="20%" style="font-size: 15px;font-weight:bold">Keseluruhan Kakitangan</th>
                            <th class="text-center" width="20%" style="font-size: 15px;font-weight:bold">Telah isi</th>
                            <th class="text-center" width="20%" style="font-size: 15px;font-weight:bold">Belum isi</th>
                            <th class="text-center" width="20%" style="font-size: 15px;font-weight:bold">Peratus Pengisian (%)</th>
                            <th class="text-center" width="20%" style="font-size: 15px;font-weight:bold">Soalan Terbuka</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-center" style="font-size: 35px;font-weight:bold"><?= $totalStaff; ?></td>
                            <th class="text-center" style="font-size: 35px;font-weight:bold"><?= $totalIsi ?><?php //echo Html::button($totalIsi, ['value' => Url::to(['dkums/sudah-isi', 'deptId' => $deptId, 'tahun' => $tahun, 'fasa' => $fasa]), 'class' => 'mapBtn', 'id' => 'modalButton']); 
                                                                                                                ?></td>
                            <th class="text-center" style="font-size: 35px;font-weight:bold"> <?= $totalStaff - $totalIsi ?><?php //echo Html::button($totalStaff - $totalIsi, ['value' => Url::to(['dkums/belum-isi', 'deptId' => $deptId, 'tahun' => $tahun, 'fasa' => $fasa]), 'class' => 'mapBtn', 'id' => 'modalButton']); 
                                                                                                                            ?></td>
                            <th class="text-center" style="font-size: 35px;font-weight:bold"><?= round(@($totalIsi / $totalStaff) * 100, 2); ?></td>
                            <th class="text-center" style="font-size: 35px;font-weight:bold"><?php echo Html::button('<i class="fa fa-comments"></i>', ['value' => Url::to(['dkums/soalan-terbuka', 'deptId' => $deptId, 'tahun' => $tahun, 'fasa' => $fasa]), 'class' => 'mapBtn', 'id' => 'modalButton']);
                                                                                                ?></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="table table-bordered table-striped table-condensed">
                    <tr style="font-weight: bold">
                        <td class="text-center">
                            <p style="font-size:40px">DKUMS</p>
                            <font style="font-size:80px"><?= $data['dkums'] ?> %</font><br>
                            <font style="font-size:20px"><i style="color:<?= $main->warnaKategori($data['tahap_dkums']) ?>"><?= $data['tahap_dkums']; ?></i></font>
                        </td>
                    </tr>
                </table>
                <br>
                <?= ChartJs::widget([
                    'type' => 'radar',
                    'options' => [
                        'responsive' => true,
                        'height' => 60,
                    ],
                    'clientOptions' => [
                        'responsive' => true,
                        'scales' => [
                            // 'xAxes' => [[
                            //     'display' => true,
                            //     'scaleLabel' => [
                            //         'display' => true,
                            //         'labelString' => 'Month',
                            //         'beginAtZero' => true,  // minimum value will be 0.
                            //     ],
                            // ]],
                            'yAxes' => [[
                                // 'ticks' => [
                                //     // 'min' => 0,
                                //     // 'max' => 100,
                                //     // 'beginAtZero' => true,  // minimum value will be 0.
                                //     // 'steps' => 10,
                                //     'stepValue' => 5,
                                //     // 'max' => 100,
                                //     'stack' => true,
                                // ],
                            ]],
                        ],
                    ],
                    'data' => [
                        'labels' => ['Penilaian Hidup', 'Emosi Positif', 'Kepuasan Kerja', 'Keterlibatan Kerja', 'Syukur'],
                        'datasets' => [
                            [
                                'label' => "Dimensi",
                                // 'backgroundColor' => "#518EC1",
                                'borderColor' => "rgba(255,99,132,1)",
                                'pointBackgroundColor' => "rgba(255,99,132,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                // 'pointHoverBorderColor' => "rgba(255,99,132,1)",
                                'data' => [$data['penilaian_hidup'], $data['emosi_positif'], $data['kepuasan_kerja'], $data['keterlibatan_kerja'], $data['syukur']],
                            ],
                        ],
                    ],

                ]);
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-check-square-o"></i>&nbsp;<strong>Penilaian Hidup</strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- Penilaian Hidup -->
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th class="text-center" style="width: 30%;">Dimensi</th>
                            <th class="text-center" style="width: 10%;">Kedudukan Item</th>
                            <th class="text-center">Kenyataan Item</th>
                            <th class="text-center" style="width: 10%;">Purata Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="6" style="font-size: 30px;" class="text-center">Penilaian Hidup<br><?= $data['penilaian_hidup']; ?>%<br>
                                <!-- <font style="font-size:20px"><i style="color:<?= $main->warnaKategori($data['tahap_penilaian_hidup']) ?>">(<?= $data['tahap_penilaian_hidup'] ?>)</i></font> -->
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($h1 = 'a1'); ?></td>
                            <td><?= $arrQuestion[$h1] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $h1]; ?>"><?= $purata[$h1] ?></span></td>
                        </tr>
                    </tbody>
                </table>
                <!-- Penilaian Hidup -->
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-check-square-o"></i>&nbsp;<strong>Emosi Positif: <?= $data['emosi_positif'] ?>%</strong>
                    <i style="color:<?= $main->warnaKategori($data['tahap_emosi_positif']) ?>">
                        (<?= $data['tahap_emosi_positif'] ?>)
                    </i>
                </h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- AFEK -->
                <?= $this->render('user/_skala_bhgn_b') ?>
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th class="text-center" style="width: 30%;">Sub-dimensi</th>
                            <th class="text-center" style="width: 10%;">Kedudukan Item</th>
                            <th class="text-center">Kenyataan Item</th>
                            <th class="text-center" style="width: 10%;">Purata Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="6" style="font-size: 30px;" class="text-center">Afek Positif</td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a1 = 'b1'); ?></td>
                            <td><?= $arrQuestion[$a1] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $a1]; ?>"><?= $purata[$a1] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a2 = 'b5'); ?></td>
                            <td><?= $arrQuestion[$a2] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $a2]; ?>"><?= $purata[$a2] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a3 = 'b7'); ?></td>
                            <td><?= $arrQuestion[$a3] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $a3]; ?>"><?= $purata[$a3] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a4 = 'b8'); ?></td>
                            <td><?= $arrQuestion[$a4] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $a4]; ?>"><?= $purata[$a4] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a5 = 'b10'); ?></td>
                            <td><?= $arrQuestion[$a5] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $a5]; ?>"><?= $purata[$a5] ?></span></td>
                        </tr>
                        <tr>
                            <td rowspan="6" style="font-size: 30px;" class="text-center">Afek Negatif</td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a6 = 'b2'); ?></td>
                            <td><?= $arrQuestion[$a6] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $a6]; ?>"><?= $purata[$a6] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a7 = 'b3'); ?></td>
                            <td><?= $arrQuestion[$a7] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $a7]; ?>"><?= $purata[$a7] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a8 = 'b4'); ?></td>
                            <td><?= $arrQuestion[$a8] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $a8]; ?>"><?= $purata[$a8] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a9 = 'b6'); ?></td>
                            <td><?= $arrQuestion[$a9] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $a9]; ?>"><?= $purata[$a9] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a10 = 'b9'); ?></td>
                            <td><?= $arrQuestion[$a10] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $a10]; ?>"><?= $purata[$a10] ?></span></td>
                        </tr>
                    </tbody>
                </table>
                <!-- AFEK -->
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    <i class="fa fa-check-square-o"></i>&nbsp;<strong>Dimensi Kepuasan Kerja : <?= $data['kepuasan_kerja'] ?>%</strong>
                    <i style="color:<?= $main->warnaKategori($data['tahap_kepuasan_kerja']) ?>">
                        (<?= $data['tahap_kepuasan_kerja'] ?>)
                    </i>
                </h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- KEPUASAN KERJA -->
                <?= $this->render('user/_skala_bhgn_c') ?>
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th class="text-center" style="width: 30%;">Sub-dimensi</th>
                            <th class="text-center" style="width: 10%;">Kedudukan Item</th>
                            <th class="text-center">Kenyataan Item</th>
                            <th class="text-center" style="width: 10%;">Purata Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Gaji
                                <br><?= $purata['gaji']; ?>%
                                <br>
                                <!-- <font style="font-size:20px"><i style="color:<?= $main->warnaKategori($purata['tahap_gaji']) ?>">
                                        (<?= $purata['tahap_gaji']; ?>)
                                    </i>
                                </font> -->
                                <?php TblMain::showMitigasi([$purata['tahap_c1'], $purata['tahap_c15'], $purata['tahap_c21']], 'gaji') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n1 = 'c1'); ?></td>
                            <td><?= $arrQuestion[$n1] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n1] ?>"><?= $purata[$n1] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n2 = 'c15'); ?></td>
                            <td style="color: blue;font-style:italic;"><?= $arrQuestion[$n2] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n2] ?>"><?= $purata[$n2] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n3 = 'c21'); ?></td>
                            <td><?= $arrQuestion[$n3] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n2] ?>"><?= $purata[$n3] ?></span></td>
                        </tr>
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Kenaikan Pangkat<br><?= $purata['pangkat']; ?>%
                                <br>
                                <!-- <font style="font-size:20px"><i style="color:<?= $main->warnaKategori($purata['tahap_pangkat']) ?>">
                                        (<?= $purata['tahap_pangkat']; ?>)
                                    </i>
                                </font> -->
                                <?php TblMain::showMitigasi([$purata['tahap_c2'], $purata['tahap_c9'], $purata['tahap_c24']], 'pangkat') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n4 = 'c2'); ?></td>
                            <td style="color: blue;font-style:italic;"><?= $arrQuestion[$n4] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n4] ?>"><?= $purata[$n4] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n5 = 'c9'); ?></td>
                            <td><?= $arrQuestion[$n5] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n5] ?>"><?= $purata[$n5] ?></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n6 = 'c24'); ?></td>
                            <td><?= $arrQuestion[$n6] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n6] ?>"><?= $purata[$n6] ?></span></td>
                        </tr>
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Penyeliaan<br><?= $purata['penyeliaan']; ?>%
                                <!-- <font style="font-size:20px"><i style="color:<?= $main->warnaKategori($purata['tahap_penyeliaan']) ?>">
                                        <br>(<?= $purata['tahap_penyeliaan']; ?>)
                                    </i>
                                </font> -->
                                <?php TblMain::showMitigasi([$purata['tahap_c3'], $purata['tahap_c16'], $purata['tahap_c23']], 'penyeliaan') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n7 = 'c3'); ?></td>
                            <td><?= $arrQuestion[$n7] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n7] ?>"><?= $purata[$n7] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n8 = 'c16'); ?></td>
                            <td style="color: blue;font-style:italic;"><?= $arrQuestion[$n8] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n8] ?>"><?= $purata[$n8] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n9 = 'c23'); ?></td>
                            <td><?= $arrQuestion[$n9] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n9] ?>"><?= $purata[$n9] ?></span></td>
                        </tr>
                        <!----------------------------------------------------------------------------------------------------------------->
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Faedah Sampingan<br><?= $purata['faedah']; ?>%
                                <!-- <font style="font-size:20px"><i style="color:<?= $main->warnaKategori($purata['tahap_faedah']) ?>">
                                        <br>(<?= $purata['tahap_faedah']; ?>)
                                    </i>
                                </font> -->
                                <?php TblMain::showMitigasi([$purata['tahap_c4'], $purata['tahap_c10'], $purata['tahap_c22']], 'faedah') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n10 = 'c4'); ?></td>
                            <td style="color: blue;font-style:italic;"><?= $arrQuestion[$n10] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n10] ?>"><?= $purata[$n10] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n11 = 'c10'); ?></td>
                            <td><?= $arrQuestion[$n11] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n11] ?>"><?= $purata[$n11] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n12 = 'c22'); ?></td>
                            <td style="color: blue;font-style:italic;"><?= $arrQuestion[$n12] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n12] ?>"><?= $purata[$n12] ?></span></td>
                        </tr>
                        <!----------------------------------------------------------------------------------------------------------------->
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Ganjaran Luar Jangka<br><?= $purata['ganjaran']; ?>%
                                <!-- <font style="font-size:20px"><i style="color:<?= $main->warnaKategori($purata['tahap_ganjaran']) ?>">
                                        <br>(<?= $purata['tahap_ganjaran']; ?>)
                                    </i>
                                </font> -->
                                <?php TblMain::showMitigasi([$purata['tahap_c5'], $purata['tahap_c11'], $purata['tahap_c17']], 'ganjaran') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n13 = 'c5'); ?></td>
                            <td><?= $arrQuestion[$n13] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n13] ?>"><?= $purata[$n13] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n14 = 'c11'); ?></td>
                            <td style="color: blue;font-style:italic;"><?= $arrQuestion[$n14] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n14] ?>"><?= $purata[$n14] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n15 = 'c17'); ?></td>
                            <td style="color: blue;font-style:italic;"><?= $arrQuestion[$n15] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n15] ?>"><?= $purata[$n15] ?></span></td>
                        </tr>
                        <!----------------------------------------------------------------------------------------------------------------->
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Prosedur Operasi<br><?= $purata['prosedur']; ?>%<br>
                                <!-- <font style="font-size:20px"><i style="color:<?= $main->warnaKategori($purata['tahap_prosedur']) ?>">
                                        (<?= $purata['tahap_prosedur']; ?>)
                                    </i>
                                </font> -->
                                <?php TblMain::showMitigasi([$purata['tahap_c6'], $purata['tahap_c12'], $purata['tahap_c18']], 'prosedur') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n16 = 'c6'); ?></td>
                            <td style="color: blue;font-style:italic;"><?= $arrQuestion[$n16] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n16] ?>"><?= $purata[$n16] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n17 = 'c12'); ?></td>
                            <td><?= $arrQuestion[$n17] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n17] ?>"><?= $purata[$n17] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n18 = 'c18'); ?></td>
                            <td style="color: blue;font-style:italic;"><?= $arrQuestion[$n18] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n18] ?>"><?= $purata[$n18] ?></span></td>
                        </tr>
                        <!----------------------------------------------------------------------------------------------------------------->
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Rakan Sekerja<br><?= $purata['rakan']; ?>%
                                <!-- <font style="font-size:20px"><i style="color:<?= $main->warnaKategori($purata['tahap_rakan']) ?>">
                                        <br>(<?= $purata['tahap_rakan']; ?>)
                                    </i>
                                </font> -->
                                <?php TblMain::showMitigasi([$purata['tahap_c13'], $purata['tahap_c19'], $purata['tahap_c25']], 'rakan') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n19 = 'c13'); ?></td>
                            <td style="color: blue;font-style:italic;"><?= $arrQuestion[$n19] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n19] ?>"><?= $purata[$n19] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n20 = 'c19'); ?></td>
                            <td><?= $arrQuestion[$n20] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n20] ?>"><?= $purata[$n20] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n21 = 'c25'); ?></td>
                            <td style="color: blue;font-style:italic;"><?= $arrQuestion[$n21] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n21] ?>"><?= $purata[$n21] ?></span></td>
                        </tr>
                        <!----------------------------------------------------------------------------------------------------------------->
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Sifat Kerja<br><?= $purata['sifat']; ?>%
                                <!-- <font style="font-size:20px"><i style="color:<?= $main->warnaKategori($purata['tahap_sifat']) ?>">
                                        <br>(<?= $purata['tahap_sifat']; ?>)
                                    </i>
                                </font> -->
                                <?php TblMain::showMitigasi([$purata['tahap_c7'], $purata['tahap_c20'], $purata['tahap_c26']], 'sifat') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n22 = 'c7'); ?></td>
                            <td style="color: blue;font-style:italic;"><?= $arrQuestion[$n22] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n22] ?>"><?= $purata[$n22] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n23 = 'c20'); ?></td>
                            <td><?= $arrQuestion[$n23] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n23] ?>"><?= $purata[$n23] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n24 = 'c26'); ?></td>
                            <td><?= $arrQuestion[$n24] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n24] ?>"><?= $purata[$n24] ?></span></td>
                        </tr>
                        <!----------------------------------------------------------------------------------------------------------------->
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Komunikasi<br><?= $purata['komunikasi']; ?>%
                                <!-- <font style="font-size:20px"><i style="color:<?= $main->warnaKategori($purata['tahap_komunikasi']) ?>">
                                        <br>(<?= $purata['tahap_komunikasi']; ?>)
                                    </i>
                                </font> -->
                                <?php TblMain::showMitigasi([$purata['tahap_c8'], $purata['tahap_c14'], $purata['tahap_c27']], 'komunikasi') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n25 = 'c8'); ?></td>
                            <td><?= $arrQuestion[$n25] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n25] ?>"><?= $purata[$n25] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n26 = 'c14'); ?></td>
                            <td style="color: blue;font-style:italic;"><?= $arrQuestion[$n26] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n26] ?>"><?= $purata[$n26] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n27 = 'c27'); ?></td>
                            <td style="color: blue;font-style:italic;"><?= $arrQuestion[$n27] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n27] ?>"><?= $purata[$n27] ?></span></td>
                        </tr>
                        <!----------------------------------------------------------------------------------------------------------------->
                    </tbody>
                </table>
                <!-- KEPUASAN KERJA -->
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-check-square-o"></i>&nbsp;<strong>Dimensi Keterlibatan Kerja : <?= $data['keterlibatan_kerja'] ?>%</strong>
                    <!-- <i style="color:<?= $main->warnaKategori($data['tahap_keterlibatan_kerja']) ?>">
                        (<?= $data['tahap_keterlibatan_kerja'] ?>)
                    </i> -->
                </h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- KETERLIBATAN KERJA -->
                <?= $this->render('user/_skala_bhgn_d') ?>
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th class="text-center" style="width: 30%;">Sub-dimensi</th>
                            <th class="text-center" style="width: 10%;">Kedudukan Item</th>
                            <th class="text-center">Kenyataan Item</th>
                            <th class="text-center" style="width: 10%;">Purata Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Semangat<br><?= $purata['semangat']; ?>%
                                <!-- <font style="font-size:20px"><i style="color:<?= $main->warnaKategori($purata['tahap_semangat']) ?>">
                                        <br>(<?= $purata['tahap_semangat']; ?>)
                                    </i>
                                </font> -->
                                <?php TblMain::showMitigasi([$purata['tahap_d1'], $purata['tahap_d2'], $purata['tahap_d5']], 'semangat'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n1 = 'd1'); ?></td>
                            <td><?= $arrQuestion[$n1] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n1] ?>"><?= $purata[$n1] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n2 = 'd2'); ?></td>
                            <td><?= $arrQuestion[$n2] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n2] ?>"><?= $purata[$n2] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n3 = 'd5'); ?></td>
                            <td><?= $arrQuestion[$n3] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n3] ?>"><?= $purata[$n3] ?></span></td>
                        </tr>
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Dedikasi<br><?= $purata['dedikasi']; ?>%
                                <!-- <font style="font-size:20px"><i style="color:<?= $main->warnaKategori($purata['tahap_dedikasi']) ?>">
                                        <br>(<?= $purata['tahap_dedikasi']; ?>)
                                    </i>
                                </font> -->
                                <?php TblMain::showMitigasi([$purata['tahap_d3'], $purata['tahap_d4'], $purata['tahap_d7']], 'dedikasi') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n4 = 'd3'); ?></td>
                            <td><?= $arrQuestion[$n4] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n4] ?>"><?= $purata[$n4] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n5 = 'd4'); ?></td>
                            <td><?= $arrQuestion[$n5] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n5] ?>"><?= $purata[$n5] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n6 = 'd7'); ?></td>
                            <td><?= $arrQuestion[$n6] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n6] ?>"><?= $purata[$n6] ?></span></td>
                        </tr>
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Kesungguhan<br><?= $purata['kesungguhan']; ?>%
                                <!-- <font style="font-size:20px"><i style="color:<?= $main->warnaKategori($purata['tahap_kesungguhan']) ?>">
                                        <br>(<?= $purata['tahap_kesungguhan']; ?>)
                                    </i>
                                </font> -->
                                <?php TblMain::showMitigasi([$purata['tahap_d6'], $purata['tahap_d8'], $purata['tahap_d9']], 'kesungguhan') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n7 = 'd6'); ?></td>
                            <td><?= $arrQuestion[$n7] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n7] ?>"><?= $purata[$n7] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n8 = 'd8'); ?></td>
                            <td><?= $arrQuestion[$n8]; ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n8] ?>"><?= $purata[$n8] ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n9 = 'd9'); ?></td>
                            <td><?= $arrQuestion[$n9]; ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $n9] ?>"><?= $purata[$n9] ?></span></td>
                        </tr>
                    </tbody>
                </table>
                <!-- KETERLIBATAN KERJA -->
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-check-square-o"></i>&nbsp;<strong>Syukur</strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- Syukur -->
                <?= $this->render('user/_skala_bhgn_e') ?>
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th class="text-center" style="width: 30%;">Dimensi</th>
                            <th class="text-center" style="width: 10%;">Kedudukan Item</th>
                            <th class="text-center">Kenyataan Item</th>
                            <th class="text-center" style="width: 10%;">Purata Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="6" style="font-size: 30px;" class="text-center">Syukur<br><?= $data['syukur']; ?>%<br>
                                <!-- <font style="font-size:20px"><i style="color:<?= $main->warnaKategori($data['tahap_syukur']) ?>">(<?= $data['tahap_syukur'] ?>)</i></font> -->
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($h1 = 'e1'); ?></td>
                            <td><?= $arrQuestion[$h1] ?></td>
                            <td class="text-center"><span class="label <?= $purata['tahap_' . $h1]; ?>"><?= $purata[$h1] ?></span></td>
                        </tr>
                    </tbody>
                </table>
                <!-- Syukur -->
            </div>
        </div>
    </div>
</div>

<?php

// VarDumper::dump(tblmain::purataAll($tahun,$fasa),10,true);
// VarDumper::dump(tblmain::PurataItemAll($tahun,$fasa),10,true);



?>