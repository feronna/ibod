<?php

use dosamigos\chartjs\ChartJs;
use \yii\helpers\ArrayHelper;
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">TAHUN PENILAIAN</th>
                                <th class="text-center">PPP</th>
                                <th class="text-center">PPK</th>

                                <th class="text-center">MARKAH</th>
                                <th class="text-center">CATATAN</th>
                            </tr>
                            <?php if (empty($data)) { ?>
                                <tr>
                                    <td colspan="6">Tiada rekod dijumpai.</td>
                                </tr>
                                <?php } else {
                                foreach ($data as $ind => $dt) { ?>
                                    <tr>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= $dt['tahun'] ?></td>
                                        <td class="col-md-2 text-center" style="text-align:center"><?= empty($dt['PPP']) ? '-' : $dt['PPP'] ?></td>
                                        <td class="col-md-2 text-center" style="text-align:center"><?= empty($dt['PPK']) ? '-' : $dt['PPK'] ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= (($dt['PPP_sah'] == 1) and ($dt['PPK_sah'] == 1)
                                                                                                        and ($dt['PEER_sah'] == 1)) ? (empty($dt['purata']) ? '-' : $dt['purata']) : '-' ?></td>
                                        <td class="col-md-6 text-center" style="text-align:center"><?= empty($dt['catatan']) ? '-' : $dt['catatan'] ?> </td>

                                    </tr>
                            <?php }
                            } ?>
                        </table>
                    </div><br>
                    <div class="table-responsive">
                        <div class="col-md-12">
                            <?=
                            ChartJs::widget([
                                'type' => 'line',
                                'options' => [
                                    'height' => 100,
                                    'width' => 400
                                ],
                                'data' => [
                                    'labels' => ArrayHelper::getColumn(array_reverse($data), 'tahun'),
                                    'datasets' => [
                                        [
                                            'data' => ArrayHelper::getColumn(array_reverse($data), 'purata'),
                                            //                                                'label' => ArrayHelper::getColumn($data, 'tahun'),
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