<?php
/* @var $this yii\web\View */
//\yii\helpers\VarDumper::dump($summary, 10, true);

use dosamigos\chartjs\ChartJs;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

$label = ArrayHelper::getColumn($markah, 'aspek');

//$bgColor = [];
$bColor = [];
$hColor = [];
foreach ($label as $lab) {
    //array_push($bgColor, sprintf('#%06X', mt_rand(0, 0xFFFFFF)));
    array_push($bColor, '#fff');
    array_push($hColor, '#999');
}

?>

<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script>

<?= $this->render('_semakMenu', ['mrkh_all' => $menu, 'lppid' => $lppid]); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Markah Keseluruhan</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <div class="col-md-9">
                            <?= ChartJs::widget([
                                'type' => 'radar',
                                'id' => 'structureDoughnut',
                                'options' => [
                                    'height' => 300,
                                    'width' => 500,
                                ],
                                'data' => [
                                    //'radius' =>  "90%",
                                    'labels' => array_values(ArrayHelper::getColumn($markah, 'aspek')),
                                    'datasets' => [
                                        [
                                            'data' => array_values(ArrayHelper::getColumn($markah, 'markah')),
                                            'label' => '',
                                            'fill' => true,
                                            'backgroundColor' => "rgba(255,99,132,0.2)",
                                            'borderColor' => "rgba(255,99,132,1)",
                                            'pointBorderColor' => "#fff",
                                            'pointBackgroundColor' => "rgba(255,99,132,1)",
                                            //'hoverBorderColor'=>["#999","#999","#999"],                
                                        ]
                                    ]
                                ],
                                'clientOptions' => [
                                    'responsive' => true,
                                    'legend' => [
                                        'display' => false,
                                        'position' => 'bottom',
                                        'labels' => [
                                            'fontSize' => 14,
                                            'fontColor' => "#425062",
                                        ]
                                    ],
                                    'tooltips' => [
                                        //                                    'enabled' => true,
                                        //                                    'intersect' => true,
                                        'callbacks' => [
                                            'label' => new JsExpression("function(t, d) {
                     var label = d.labels[t.index];
                     var data = d.datasets[t.datasetIndex].data[t.index];
                     if (t.datasetIndex === 0)
                     return label + ': ' + data;
                     else if (t.datasetIndex === 1)
                     return label + ': $' + data.toLocaleString();
              }"),
                                            'title' => new JsExpression('function(){}')
                                            //                                        'title' => '',
                                        ]
                                    ],
                                    'hover' => [
                                        'mode' => false
                                    ],
                                    'maintainAspectRatio' => false,
                                    'scale' => [
                                        'ticks' => [
                                            'beginAtZero' => true,
                                            'precision' => 0,
                                            'suggestedMax' => max(array_values(ArrayHelper::getColumn($pemberat, 'pemberat'))),
                                            'stepSize' => 5
                                            //                                        'maxTicksLimit' => 10
                                        ],
                                        //                                    'pointLabels' => [
                                        //                                        'fontColor' => ArrayHelper::getColumn($markah, 'warna')
                                        //                                    ]
                                    ]

                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-md-3">
                        <p><strong>Markah Purata : </strong></p>
                            <?=
                                \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'star',
                                        'header' => 'Kategori',
                                        'text' => strtoupper($kategori),
                                        'number' => $total . '%',
                                    ]
                                )
                            ?>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center"></th>
                                <?php foreach (array_column($mrkh_all, 'bahagian') as $b) { ?>
                                    <th class="text-center"><?= $b; ?></th>
                                <?php } ?>
                                <th class="text-center">Jumlah <sub>(100%)</sub></th>
                            </tr>
                            <tr>
                                <th class="text-center">PYD</th>
                                <?php foreach ($pyd as $ind => $m) {
                                    if ($ind == 9) { ?>
                                        <th class="text-center">-</th>
                                    <?php continue;
                                    } else {
                                    ?>
                                        <th class="text-center"><?= is_null($m['mrkh_bhg']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>'; ?></th>
                                <?php }
                                } ?>
                                <th class="text-center"><?= Yii::$app->formatter->asDecimal(array_sum(array_column($pyd, 'mrkh_bhg'))); ?></th>
                            </tr>
                            <tr>
                                <th class="text-center">PPP</th>
                                <?php foreach ($ppp as $ind => $m) {
                                    if ($ind == 9) { ?>
                                        <th class="text-center"><?= is_null($m['mrkh_bhg']) ? '0<sub> / 3.75</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / 3.75</sub>'; ?></th>
                                    <?php } else { ?>
                                        <th class="text-center"><?= is_null($m['mrkh_bhg']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>'; ?></th>
                                <?php }
                                } ?>
                                <th class="text-center"><?= Yii::$app->formatter->asDecimal(array_sum(array_column($ppp, 'mrkh_bhg'))); ?></th>
                            </tr>
                            <tr>
                                <th class="text-center">PPK</th>
                                <?php foreach ($ppk as $ind => $m) {
                                    if ($ind == 9) { ?>
                                        <th class="text-center"><?= is_null($m['mrkh_bhg']) ? '0<sub> / 8.25</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / 8.25</sub>'; ?></th>
                                    <?php } else { ?>
                                        <th class="text-center"><?= is_null($m['mrkh_bhg']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>'; ?></th>
                                <?php }
                                } ?>
                                <th class="text-center"><?= Yii::$app->formatter->asDecimal(array_sum(array_column($ppk, 'mrkh_bhg'))); ?></th>
                            </tr>
                            <tr>
                                <th class="text-center">PEER</th>
                                <?php foreach ($peer as $ind => $m) { ?>
                                    <th class="text-center"><?= (is_null($m['mrkh_bhg']) || ($m['bhg_no'] == '-1')) ? '-' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / ' . Yii::$app->formatter->asDecimal(3, 2) . '</sub>'; ?></th>

                                <?php
                                } ?>
                                <th class="text-center">-</th>
                            </tr>
                            <tr>
                                <th class="text-center">PPP + PPK</th>
                                <?php foreach ($ppk as $ind => $m) { ?>
                                    <th class="text-center"><?= is_null($markah[$ind]['markah']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($markah[$ind]['markah'], 2) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>'; ?></th>
                                <?php } ?>
                                <th class="text-center"><?= Yii::$app->formatter->asDecimal(array_sum(array_column($markah, 'markah'))); ?></th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Ringkasan Markah</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">Aspek Penilaian</th>

                                <th class="text-center">Markah PYD</th>
                                <th class="text-center">Markah PPP</th>
                                <th class="text-center">Markah PPK</th>
                                <th class="text-center">Markah Peer</th>
                            </tr>
                            <?php
                            $sumPyd = 0;
                            $sumPpp = 0;
                            $sumPpk = 0;
                            $sumPeer = 0;
                            $cnt = 0;
                            foreach ($summary as $ind => $smyy) { ?>
                                <?php foreach ($smyy as $smy) { ?>
                                    <tr>
                                        <td <?= ($smy['desc'] == 'JUMLAH') ? 'align="right"' : '' ?>><?= $smy['desc']; ?></td>

                                        <td class="col-md-1 text-center" style="text-align:center"><?= $smy['markah_pyd']; ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= $smy['markah_ppp']; ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= $smy['markah_ppk']; ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= ($smy['bhg_no'] == 9 or ($smy['desc'] == 'JUMLAH')) ?  $smy['markah_peer'] : '-'; ?></td>
                                    </tr>
                                <?php


                                } ?>
                            <?php

                                $sumPyd = $sumPyd + $smy['markah_pyd'];
                                $sumPpp = $sumPpp + $smy['markah_ppp'];
                                $sumPpk = $sumPpk + $smy['markah_ppk'];
                                $sumPeer = $sumPeer + $smy['markah_peer'];
                                $cnt++;
                            } ?>
                            <tr>
                                <th class="text-center">TOTAL MARKAH KESELURUHAN</th>

                                <th class="text-center">
                                    <math>
                                        <mfrac>
                                            <mn><?= $sumPyd ?></mn>
                                            <mn><?= ($cnt * 100) ?></mn>
                                        </mfrac>
                                        <mo>x</mo>
                                        <mn>100%</mn>
                                        <mo>=</mo>
                                        <mn>
                                            <?= \Yii::$app->formatter->asDecimal(($sumPyd / ($cnt * 100) * 100), 2) ?>
                                        </mn>
                                    </math>
                                </th>
                                <th class="text-center">
                                    <math>
                                        <mfrac>
                                            <mn><?= $sumPpp ?></mn>
                                            <mn><?= ($cnt * 100) ?></mn>
                                        </mfrac>
                                        <mo>x</mo>
                                        <mn>100%</mn>
                                        <mo>=</mo>
                                        <mn>
                                            <?= \Yii::$app->formatter->asDecimal(($sumPpp / ($cnt * 100) * 100), 2) ?>
                                        </mn>
                                    </math></th>
                                <th class="text-center">
                                    <math>
                                        <mfrac>
                                            <mn><?= $sumPpk ?></mn>
                                            <mn><?= ($cnt * 100) ?></mn>
                                        </mfrac>
                                        <mo>x</mo>
                                        <mn>100%</mn>
                                        <mo>=</mo>
                                        <mn>
                                            <?= \Yii::$app->formatter->asDecimal(($sumPpk / ($cnt * 100) * 100), 2) ?>
                                        </mn>
                                    </math></th>
                                <th class="text-center">
                                    <math>
                                        <mfrac>
                                            <mn><?= $sumPeer ?></mn>
                                            <mn><?= ($cnt * 100) ?></mn>
                                        </mfrac>
                                        <mo>x</mo>
                                        <mn>100%</mn>
                                        <mo>=</mo>
                                        <mn>
                                            <?= \Yii::$app->formatter->asDecimal(($sumPeer / ($cnt * 100) * 100), 2) ?>
                                        </mn>
                                    </math></th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>