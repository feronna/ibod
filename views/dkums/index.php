<?php

use app\models\dkums\TblMain;
use yii\helpers\Html;
use dosamigos\chartjs\ChartJs;
use yii\helpers\VarDumper;

?>
<?= Yii::$app->controller->renderPartial('_menu'); ?>
<?php if ($papar_settings) { ?>
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-users"></i>&nbsp;<strong>Purata Keseluruhan Staff UMS</strong></h2>
                    <ul class="nav navbar-right panel_toolbox ">
                        <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="tile_count">
                        <div class="col-lg-2 col-md-2 col-sm-12 tile_stats_count">
                            <span class="count_top"><i class="fa fa-users"></i>&nbsp;Purata DKUMS</span>
                            <div class="count blue"><?= $purata['dkums']; ?>%</div>
                            <span class="count_bottom">Tahap <i class="blue"><?= $purata['tahap_dkums']; ?></i></span>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 tile_stats_count">
                            <span class="count_top"><i class="fa fa-heart"></i>&nbsp;Purata Penilaian Hidup</span>
                            <div class="count green"><?= $purata['penilaian_hidup']; ?>%</div>
                            <span class="count_bottom">Tahap <i class="blue"><?= $purata['tahap_penilaian_hidup']; ?></i></span>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 tile_stats_count">
                            <span class="count_top"><i class="fa fa-briefcase"></i>&nbsp;Purata Keterlibatan Kerja</span>
                            <div class="count blue"><?= $purata['keterlibatan_kerja']; ?>%</div>
                            <span class="count_bottom">Tahap <i class="blue"><?= $purata['tahap_keterlibatan_kerja']; ?></i></span>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 tile_stats_count">
                            <span class="count_top"><i class="fa fa-thumbs-up"></i>&nbsp;Purata kepuasan kerja</span>
                            <div class="count green"><?= $purata['kepuasan_kerja']; ?>%</div>
                            <span class="count_bottom">Tahap <i class="blue"><?= $purata['tahap_kepuasan_kerja']; ?></i></span>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 tile_stats_count">
                            <span class="count_top"><i class="fa fa-smile-o"></i>&nbsp;Emosi Positif</span>
                            <div class="count blue"><?= $purata['emosi_positif']; ?>%</div>
                            <span class="count_bottom">Tahap <i class="blue"><?= $purata['tahap_emosi_positif']; ?></i></span>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user-plus"></i>&nbsp;Syukur</span>
                            <div class="count blue"><?= $purata['syukur']; ?>%</div>
                            <span class="count_bottom">Tahap <i class="blue"><?= $purata['tahap_syukur']; ?></i></span>
                        </div>
                    </div>
                    <i class="green">*Maklumat adalah berdasarkan purata keseluruhan data pada Tahun <?= $papar_settings->tahun ?>(Fasa <?= $papar_settings->fasa ?>)</i>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- </div> -->
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-list"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-condensed table-bordered table-striped custom-matrix">
                    <tr>
                        <th class="text-center">Tahun / Year</th>
                        <th class="text-center">Fasa / Phase</th>
                        <th class="text-center">Darjah Kegembiraan / DKUMS</th>
                        <th class="text-center">Tahap / Level</th>
                        <th class="text-center">Masa Jawab</th>
                    </tr>
                    <?php foreach ($year_settings as $year) { ?>
                        <tr>
                            <td class="text-center"><?= $year->tahun; ?></td>
                            <td class="text-center"><?= $year->fasa; ?></td>
                            <?php if ($dk = TblMain::individualDk($icno, $year->tahun, $year->fasa)) { ?>
                                <td class="text-center"><?= $dk->dkums; ?></td>
                                <td class="text-center"><?= $dk->tahapDkums; ?></td>
                                <td class="text-center"><?= $dk->masaJawab; ?></td>
                            <?php } else { ?>
                                <td colspan="3" class="text-center">--Tiada Rekod --</td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </table>
                <div style='padding: 15px; margin:15px; font-weight:bold' class="table-bordered text-center">
                    <span class="label label-success">TINGGI</span> : 80 - 100 %&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="label label-warning">SEDERHANA</span> : 50 - 79.99 % &nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="label label-lg label-danger">RENDAH</span> : 0 - 49.99 %
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                    <?php if ($status_isi) { ?>
                        <?= Html::a('<i class="fa fa-check-square-o"></i>&nbsp;Jawab Soal Selidik&nbsp;<i class="fa fa-arrow-right"></i>', ['intro'], ['class' => 'btn btn-success', 'target' => ""]); ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-area-chart"></i>&nbsp;<strong>Graf Darjah Kegembiraan anda mengikut Tahun(Fasa)</strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?= ChartJs::widget([
                    'type' => 'line',
                    'options' => [
                        'responsive' => true,
                        'height' => 60,
                    ],
                    'clientOptions' => [
                        'responsive' => true,
                        'scales' => [
                            'yAxes' => [[
                                'ticks' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ]],
                        ],
                    ],
                    'data' => [
                        'labels' => TblMain::getStaffYearArr($icno, $limit),
                        'datasets' => [
                            [
                                'label' => "Darjah Kegembiraan Anda",
                                // 'backgroundColor' => "#518EC1",
                                'borderColor' => "rgba(255,99,132,1)",
                                'pointBackgroundColor' => "rgba(255,99,132,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                // 'pointHoverBorderColor' => "rgba(255,99,132,1)",
                                'data' => TblMain::getStaffDkArr($icno, $limit),
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
                <h2><i class="fa fa-line-chart"></i>&nbsp;<strong>Graf megikut dimensi utama anda mengikut Tahun(Fasa)</strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?= ChartJs::widget([
                    'type' => 'bar',

                    'options' => [
                        'responsive' => true,
                        'height' => 80,
                    ],
                    'clientOptions' => [
                        'responsive' => true,

                        'scales' => [
                            'yAxes' => [[
                                'ticks' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ]],
                        ],
                    ],
                    'data' => [
                        'labels' => ['Penilaian Hidup', 'Emosi Positif', 'Kepuasan Kerja', 'Keterlibatan Kerja'],
                        'datasets' =>
                        TblMain::getDimensiArr($icno, $limit),

                    ],

                ]);
                ?>
            </div>
        </div>
    </div>
</div>

<?php

$main = new TblMain();
// $main->syukur(4994);

//  VarDumper::dump($main->syukur(4994), $depth = 10, $highlight = true);

?>