<?php

use app\models\kehadiran\TblWarnaKad;

//use Author;
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-bar-chart"></i><?= $this->title ?></strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <blockquote class="message">
                    NAMA : <?= $biodata->CONm; ?><br>
                    UMSPER : <?= $biodata->COOldID; ?><br>
                    Gred : <?= $biodata->jawatan->fname; ?><br>
                    JFPIB : <?= $biodata->department->fullname; ?>
                </blockquote>
                <table class="table table-striped table-sm jambo_table table-bordered">
                    <thead>
                        <tr class="headings">
                            <th class="text-center" style="text-align:right;width:20%">TAHUN</th>
                            <th class="text-center">KUNING</th>
                            <th class="text-center">HIJAU</th>
                            <th class="text-center">MERAH</th>
                            <th class="text-center">PRESTASI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($year as $y) { ?>
                            <tr>
                                <td class="text-center" style="text-align:right;font-weight:bold"><?= $tahun = $y['year'] ?></td>
                                <td class="text-center" style="text-align:center;font-weight:bold"><?= TblWarnaKad::totalByCardColor($tahun, $icno, 'YELLOW') ?></td>
                                <td class="text-center" style="text-align:center;font-weight:bold"><?= TblWarnaKad::totalByCardColor($tahun, $icno, 'GREEN') ?></td>
                                <td class="text-center" style="text-align:center;font-weight:bold"><?= TblWarnaKad::totalByCardColor($tahun, $icno, 'RED') ?></td>
                                <td class="text-center" style="text-align:center;font-weight:bold"><?= TblWarnaKad::prestasiWarnaKad($tahun, $icno) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>