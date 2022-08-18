<?php

use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?= Yii::$app->controller->renderPartial('_menu'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-home"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <table class="table table-bordered table-striped table-condensed">
                    <tr style="font-weight: bold">
                        <td class="text-center">
                            <p style="font-size:20px">Skor anda / Your Score</p>
                            <font style="font-size:80px"><?= $model->dkums ?> %</font><br>
                            <font style="font-size:20px"><i style="color:green"><?= $model->tahapDkums; ?></i></font>
                        </td>
                    </tr>
                </table>
                <div style='padding: 15px; margin:15px; font-weight:bold' class="table-bordered text-center">
                    <span class="label label-success">TINGGI</span> : 80 - 100 %&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="label label-warning">SEDERHANA</span> : 50 - 79.99 % &nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="label label-lg label-danger">RENDAH</span> : 0 - 49.99 %
                </div>

                <?= ChartJs::widget([
                    'type' => 'radar',
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
                        'labels' => ['Penilaian Hidup', 'Emosi Positif', 'Kepuasan Kerja', 'Keterlibatan Kerja'],
                        'datasets' => [
                            [
                                'label' => "Dimensi",
                                // 'backgroundColor' => "#518EC1",
                                'borderColor' => "rgba(255,99,132,1)",
                                'pointBackgroundColor' => "rgba(255,99,132,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                // 'pointHoverBorderColor' => "rgba(255,99,132,1)",
                                'data' => [$model->penilaianHidup, $model->emosiPositif, $model->kepuasanKerja, $model->keterlibatanKerja],
                            ],
                        ],
                    ],

                ]);
                ?>


                <div class="ln_solid"></div>
                <div class="form-group text-center">
                    <?= Html::a('<i class="fa fa-check-circle-o"></i> Tamat / Finished', Url::to(['index']), ['class' => 'btn btn-danger']) ?>
                </div>
            </div>
        </div>
    </div>
</div>