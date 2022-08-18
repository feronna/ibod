<?php

use yii\helpers\Html;
use app\models\kehadiran\TblRekod;
?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-line-chart"></i>&nbsp;Laporan Kehadiran staf tahun <?= $year ?></strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <blockquote class="message">
                    NAMA : <?= $biodata->CONm; ?><br>
                    UMSPER : <?= $biodata->COOldID; ?><br>
                    Gred : <?= $biodata->jawatan->fname; ?><br>
                    JFPIB : <?= $biodata->department->fullname; ?>
                </blockquote>
                <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Bulan</th>
                                <th class="text-center">Jam bekerja<br>[Jam:Minit]</th>
                                <th class="text-center">Hari bekerja<br>[Completed]</th>
                                <th class="text-center">Late In</th>
                                <th class="text-center">Early Out</th>
                                <th class="text-center">Incomplete</th>
                                <th class="text-center">Absent</th>
                                <th class="text-center">external</th>
                            </tr>
                        </thead>
                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                            <tr>
                                <td class="text-center"><?= TblRekod::viewBulan($i) ?></td>
                                <td class="text-center"><?= TblRekod::TotalWorkingHours($icno, $i, $year, 1) ?></td>
                                <td class="text-center"><?= TblRekod::TotalWorkingHours($icno, $i, $year, 2) ?></td>
                                <td class="text-center"><?= TblRekod::countKetidakpatuhan($icno, $i, $year, 1) ?></td>
                                <td class="text-center"><?= TblRekod::countKetidakpatuhan($icno, $i, $year, 2) ?></td>
                                <td class="text-center"><?= TblRekod::countKetidakpatuhan($icno, $i, $year, 3) ?></td>
                                <td class="text-center"><?= TblRekod::countKetidakpatuhan($icno, $i, $year, 4) ?></td>
                                <td class="text-center"><?= TblRekod::countKetidakpatuhan($icno, $i, $year, 5) ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <?= Html::a('<i class="fa fa-arrow-left"></i> Back', ['kehadiran/staff-all'], ['class' => 'btn btn-default']) ?>
                <?= Html::a('<i class="fa fa-print"></i> Print', ['kehadiran/report', 'id' => $icno, 'tahun' => $year], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
            </div>
        </div>
    </div>
</div>