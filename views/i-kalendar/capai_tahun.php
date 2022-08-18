<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\JsExpression;
use kartik\widgets\StarRating;

function starRating($total)
{
    // $totall = $total / 100 * 5;

    // $total1 = number_format($totall, 2);

    // if ($total1 == 5) {
    //     $total2 = 5.0;
    // } else if (($total1 >= 4.5) && ($total1 < 5)) {
    //     $total2 = 4.5;
    // } else if (($total1 >= 4) && ($total1 < 4.5)) {
    //     $total2 = 4.0;
    // } else if (($total1 >= 3) && ($total1 < 4)) {
    //     $total2 = 3.0;
    // } else if (($total1 >= 2) && ($total1 < 3)) {
    //     $total2 = 2.0;
    // } else if (($total1 >= 1) && ($total1 < 2)) {
    //     $total2 = 1.0;
    // } else {
    //     $total2 = 0.0;
    // }

    if ($total == 100) {
        $total2 = 5.0;
    } else if (($total >= 90) && ($total < 100)) {
        $total2 = 4.5;
    } else if (($total >= 80) && ($total < 90)) {
        $total2 = 4.0;
    } else if (($total >= 70) && ($total < 80)) {
        $total2 = 3.0;
    } else if (($total >= 60) && ($total < 70)) {
        $total2 = 2.0;
    } else if (($total >= 50) && ($total < 60)) {
        $total2 = 1.0;
    } else {
        $total2 = 0.0;
    }

    // if($total1 > 4)
    //     $total2 = 4.0;
    // else 
    //     $total2 = 1.0;

    // $total2 = 4.5;

    echo StarRating::widget([
        'name' => 'rating_2',
        'value' => number_format($total2, 2),
        'disabled' => true,
        'pluginOptions' => ['size' => 'xs', 'displayOnly' => true, 'showCaption' => false,]
    ]);

    // echo number_format($total2, 2);
}

$i = 1;
?>

<?= $this->render('_menuAdmin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Laporan Pencapaian Aktiviti Bulanan Setiap Bahagian</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th class="text-center">BAHAGIAN</th>
                            <th class="text-center" colspan="6">PERATUS PENCAPAIAN (%)</th>
                        </tr>
                        <tr>
                            <th class="text-center">BULAN</th>
                            <th class="text-center">BSM</th>
                            <th class="text-center">BPA</th>
                            <th class="text-center">BPG</th>
                            <th class="text-center">BPG</th>
                            <th class="text-center">BKES</th>
                        </tr>
                        <?php
                        while ($i <= 12) {
                        ?>
                            <tr>
                                <td class="text-center" style="vertical-align: middle;"> <?= date('F', mktime(0, 0, 0, $i, 10)); ?> </td>
                                <td class="text-center"> <?= $laporan[0][$i] ?? '0'; ?>
                                    <hr> <?=
                                            starRating($laporan[0][$i] ?? '0');
                                            ?>
                                </td>
                                <td class="text-center"> <?= $laporan[2][$i] ?? '0'; ?>
                                    <hr><?=
                                        starRating($laporan[2][$i] ?? '0');
                                        ?>
                                </td>
                                <td class="text-center"> <?= $laporan[1][$i] ?? '0'; ?>
                                    <hr> <?=
                                            starRating($laporan[1][$i] ?? '0');
                                            ?>
                                </td>
                                <td class="text-center"> <?= $laporan[4][$i] ?? '0'; ?>
                                    <hr><?=
                                        starRating($laporan[4][$i] ?? '0');
                                        ?>
                                </td>
                                <td class="text-center"> <?= $laporan[3][$i] ?? '0'; ?>
                                    <hr><?=
                                        starRating($laporan[3][$i] ?? '0');
                                        ?>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>