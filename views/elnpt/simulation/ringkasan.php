<?php
/* @var $this yii\web\View */

use dosamigos\chartjs\ChartJs;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\bootstrap\Alert;

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

<?php
echo $this->render('//elnpt/simulation/_menu', ['menu' => $menu, 'lppid' => $lppid, 'sah' => isset($lpp) ? $lpp->PYD_sah : false]);
?>

<?php
echo Alert::widget([
    'options' => ['class' => 'alert-warning'],
    'body' => '<font color="black">
                     <strong>INFO</strong><br>
                     <p>
                     Sila semak semula setiap bahagian untuk mendapatkan Jumlah Markah Keseluruhan PYD yang terkini.
                     </p>
                 </font>',
]);
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Jumlah Markah Keseluruhan PYD</strong></h2>
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
                                            'data' => array_values(ArrayHelper::getColumn($markah, function ($element) {
                                                $mark = $element['markah'] * 100;
                                                if ($mark > 100) {
                                                    return 100;
                                                } else {
                                                    return  $mark;
                                                }
                                            })),
                                            'label' => 't',
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
                                            // 'suggestedMax' => max(array_values(ArrayHelper::getColumn($pemberat, 'pemberat'))),
                                            'suggestedMax' => 100,
                                            'stepSize' => 20
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
                            <p><strong>
                                    <?= ($lpp->PPP_sah == 1 and $lpp->PPK_sah == 1) ? 'Jumlah Markah Purata (PPP + PPK)' : 'Jumlah Markah Keseluruhan PYD' ?>
                                </strong><br><i>Markah yang dipaparkan adalah tertakluk kepada perubahan selepas proses verifikasi oleh PPP dan penilaian kualiti peribadi oleh PPP, PPK dan PEER.</i></p>
                            <?=
                            \yiister\gentelella\widgets\StatsTile::widget(
                                [
                                    // 'icon' => 'star',
                                    'header' => 'Kategori',
                                    'text' => ($lpp->PPP_sah == 1 and $lpp->PPK_sah == 1) ? '<b>' . strtoupper($kategori) . '</b><br>'
                                        . '- Better than <b>' . Yii::$app->formatter->asDecimal($rankDept) . '   %</b> of all results in ' . $lpp->guru->department->fullname . '<br>'
                                        . '- Better than <b>' . Yii::$app->formatter->asDecimal($rankGred) . '%</b> of all results within ' . $lpp->guru->jawatan->gred . ' in ' . $lpp->guru->department->fullname . '<br>'
                                        . '- Better than <b>' . Yii::$app->formatter->asDecimal($rankWhole) . '%</b> of all results' : '<b>' . strtoupper($kategori) . '</b>',
                                    // 'number' => Yii::$app->formatter->asDecimal($total * 100) . '%',
                                    'number' => ($lpp->PPP_sah == 1 and $lpp->PPK_sah == 1) ? Yii::$app->formatter->asDecimal($total) . '%' : Yii::$app->formatter->asDecimal(array_sum(array_column($pyd, 'mrkh_bhg'))) . '%',
                                    // 'number' => Yii::$app->formatter->asDecimal($total) . '%',
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
                                <?php foreach (array_column($mrkh_all, 'bahagian') as $ind => $b) {
                                    if ($ind == 9)
                                        continue; ?>
                                    <th class="text-center"><?= $b; ?></th>
                                <?php } ?>
                                <th class="text-center">Markah Purata </th>
                                <th class="text-center">Kualiti Peribadi</th>
                                <th class="text-center">Jumlah Markah Purata (PPP + PPK) </th>
                            </tr>
                            <tr>
                                <th class="text-center">PYD</th>
                                <?php foreach ($pyd as $ind => $m) {
                                    if ($ind == 10) { ?>
                                        <!-- <th class="text-center">-</th> -->
                                    <?php continue;
                                    } else {
                                    ?>
                                        <th class="text-center"><?= is_null($m['mrkh_bhg']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>'; ?></th>
                                <?php }
                                } ?>
                                <th class="text-center"><?= Yii::$app->formatter->asDecimal(array_sum(array_column($pyd, 'mrkh_bhg'))); ?></th>
                                <th class="text-center">-</th>
                                <th class="text-center">-</th>
                            </tr>
                            <tr>
                                <th class="text-center">PPP</th>
                                <?php foreach ($ppp as $ind => $m) {
                                    if ($ind == 10) {
                                        continue; ?>
                                        <!-- <th class="text-center"><?= is_null($m['mrkh_bhg']) ? '0<sub> / 3.75</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . ($pemberat[1]['tbl_kump_dept_id'] == 3 ? '<sub> / 6.00</sub>' : '<sub> / 4.00</sub>'); ?></th> -->
                                    <?php } else { ?>
                                        <th class="text-center">
                                            <?php
                                            if ($lpp->PPP_sah != 1 || $lpp->PYD == Yii::$app->user->identity->ICNO) {
                                                echo '-';
                                            } else {
                                                echo is_null($m['mrkh_bhg']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>';
                                            }
                                            ?>
                                        </th>
                                <?php }
                                } ?>
                                <th class="text-center">
                                    <?php
                                    // echo '-';
                                    if ($lpp->PPP_sah != 1 || $lpp->PYD == Yii::$app->user->identity->ICNO) {
                                        echo '-';
                                    } else {
                                        echo  Yii::$app->formatter->asDecimal(array_sum(array_column($ppp, 'mrkh_bhg')) - $ppp[10]['mrkh_bhg']);
                                    }
                                    ?>
                                </th>
                                <th class="text-center"><?= Yii::$app->formatter->asDecimal($ppp[10]['mrkh_bhg'], 2) . ($pemberat[1]['tbl_kump_dept_id'] == 3 ? '<sub> / 6.00</sub>' : '<sub> / 4.00</sub>') ?></th>
                                <th class="text-center">-</th>
                            </tr>
                            <tr>
                                <th class="text-center">PPK</th>
                                <?php foreach ($ppk as $ind => $m) {
                                    if ($ind == 10) {
                                        continue; ?>
                                        <!-- <th class="text-center"><?= is_null($m['mrkh_bhg']) ? '0<sub> / 8.25</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . ($pemberat[1]['tbl_kump_dept_id'] == 3 ? '<sub> / 6.00</sub>' : '<sub> / 4.00</sub>'); ?></th> -->
                                    <?php } else { ?>
                                        <th class="text-center">
                                            <?php
                                            // echo '-';
                                            // is_null($m['mrkh_bhg']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>'; 
                                            if ($lpp->PPK_sah != 1 || $lpp->PYD == Yii::$app->user->identity->ICNO) {
                                                echo '-';
                                            } else {
                                                echo is_null($m['mrkh_bhg']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>';
                                            }
                                            ?>
                                        </th>
                                <?php }
                                } ?>
                                <th class="text-center">
                                    <?php
                                    // echo '-';
                                    if ($lpp->PPK_sah != 1 || $lpp->PYD == Yii::$app->user->identity->ICNO) {
                                        echo '-';
                                    } else {
                                        echo Yii::$app->formatter->asDecimal(array_sum(array_column($ppk, 'mrkh_bhg')) - $ppk[10]['mrkh_bhg']);
                                    }
                                    ?>
                                </th>
                                <th class="text-center"><?= Yii::$app->formatter->asDecimal($ppk[10]['mrkh_bhg'], 2) . ($pemberat[1]['tbl_kump_dept_id'] == 3 ? '<sub> / 6.00</sub>' : '<sub> / 4.00</sub>') ?></th>
                                <th class="text-center">-</th>
                            </tr>
                            <tr>
                                <th class="text-center">PEER</th>
                                <?php foreach ($peer as $ind => $m) {
                                    if ($ind == (count(array_column($mrkh_all, 'bahagian')) > 10 ? 12 : 11)) {
                                        continue; ?>
                                        <!-- <th class="text-center"><?= is_null($m['mrkh_bhg']) ? '0<sub> / 8.25</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . ($pemberat[1]['tbl_kump_dept_id'] == 3 ? '<sub> / 3.00</sub>' : '<sub> / 2.00</sub>'); ?></th> -->
                                    <?php } else { ?>
                                        <th class="text-center">
                                            <?php
                                            echo '-';
                                            // is_null($m['mrkh_bhg']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>'; 
                                            ?>
                                        </th>
                                <?php }
                                } ?>
                                <th class="text-center">
                                    <?php
                                    // echo '-';
                                    echo Yii::$app->formatter->asDecimal($peer[10]['mrkh_bhg']) . ($pemberat[1]['tbl_kump_dept_id'] == 3 ? '<sub> / 3.00</sub>' : '<sub> / 2.00</sub>');
                                    ?>
                                </th>
                                <th class="text-center">-</th>
                            </tr>
                            <!-- <?php if ($lpp->PPP_sah == 1 and $lpp->PPK_sah == 1) { ?>
                                <tr>
                                    <th class="text-center">PPP + PPK</th>
                                    <?php foreach ($ppk as $ind => $m) { ?>
                                        <th class="text-center"><?= is_null($markah[$ind]['markah']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($markah[$ind]['markah'] * $pemberat[$ind]['pemberat']) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>'; ?></th>
                                    <?php } ?>
                                    <th class="text-center"><?= Yii::$app->formatter->asDecimal(array_sum(array_map(
                                                                function ($x, $y) {
                                                                    return $x * $y;
                                                                },
                                                                array_column($markah, 'markah'),
                                                                array_column($pemberat, 'pemberat')
                                                            ))); ?></th>
                                </tr>
                            <?php } ?> -->
                            <?php if ($lpp->PPP_sah == 1 and $lpp->PPK_sah == 1) { ?>
                                <tr>
                                    <th colspan=<?= count(array_column($mrkh_all, 'bahagian')) > 10 ? "11" : "10" ?> style="text-align:right">Total</sub></th>

                                    <th class="text-center">
                                        <?php
                                        // echo '-';
                                        echo  Yii::$app->formatter->asDecimal(array_sum(array_column($ppp, 'mrkh_bhg')) - $ppp[10]['mrkh_bhg']);
                                        ?>
                                    </th>
                                    <th class="text-center">
                                        <?= is_null($markah[10]['markah']) ? '0' : Yii::$app->formatter->asDecimal($markah[10]['markah'] * $pemberat[10]['pemberat'], 2); ?>
                                    </th>
                                    <th class="text-center">
                                        <?= Yii::$app->formatter->asDecimal(array_sum(array_map(
                                            function ($x, $y) {
                                                return $x * $y;
                                            },
                                            array_column($markah, 'markah'),
                                            array_column($pemberat, 'pemberat')
                                        ))); ?>
                                    </th>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (1 == 0) { ?>
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
                                    <?php if (1 == 0) { ?>
                                        <th class="text-center">Markah PPP</th>
                                        <th class="text-center">Markah PPK</th>
                                    <?php } ?>

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

                                            <td class="col-md-1 text-center" style="text-align:center"><?= Yii::$app->formatter->asDecimal($smy['markah_pyd'] * 100); ?></td>
                                            <?php if (1 == 0) { ?>
                                                <td class="col-md-1 text-center" style="text-align:center"><?= Yii::$app->formatter->asDecimal($smy['markah_ppp'] * 100); ?></td>
                                                <td class="col-md-1 text-center" style="text-align:center"><?= Yii::$app->formatter->asDecimal($smy['markah_ppk'] * 100); ?></td><?php } ?>
                                        </tr>
                                    <?php


                                    } ?>
                                <?php

                                    $sumPyd = $sumPyd + $smy['markah_pyd'];
                                    $sumPpp = $sumPpp + $smy['markah_ppp'];
                                    $sumPpk = $sumPpk + $smy['markah_ppk'];
                                    //                                $sumPeer = $sumPeer + $smy['markah_peer'];
                                    $cnt++;
                                } ?>
                                <tr>
                                    <th style="vertical-align : middle;text-align:center;" rowspan="2">JUMLAH MARKAH KESELURUHAN<br>(PYD)</th>

                                    <th class="text-center">
                                        <?= Yii::$app->formatter->asDecimal($sumPyd * 100) ?>
                                    </th>
                                    <?php if (1 == 0) { ?>
                                        <th class="text-center">
                                            <?= Yii::$app->formatter->asDecimal($sumPpp * 100) ?>
                                        </th>
                                        <th class="text-center">
                                            <?= Yii::$app->formatter->asDecimal($sumPpk * 100) ?>
                                        </th>
                                    <?php } ?>

                                </tr>
                                <tr>

                                    <th class="text-center">
                                        <?= Yii::$app->formatter->asDecimal(($sumPyd / $cnt) * 100), ' %'; ?>
                                    </th>
                                    <?php if (1 == 0) { ?>
                                        <th class="text-center">

                                        </th>
                                        <th class="text-center">

                                        </th>
                                    <?php } ?>

                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>