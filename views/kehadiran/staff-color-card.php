<?php

use yii\helpers\Html;
use app\models\kehadiran\TblWarnaKad;
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Kakitangan Dibawah Seliaan Anda.</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th class="text-center">Bil</th>
                            <th class="text-center">Nama Kakitangan</th>
                            <th class="text-center">Gred Jawatan</th>
                            <th class="text-center">Ketidakpatuhan</th>
                            <th class="text-center">Diterima</th>
                            <th class="text-center">Tidak Diterima</th>
                            <th class="text-center">Warna Kad</th>
                        </tr>
                        <?php if ($model) { ?>
                            <?php foreach ($model as $senarai) { ?>
                                <tr>
                                    <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                    <td><?php echo $senarai->pemohon->CONm; ?></td>
                                    <td class="text-center"><?php echo $senarai->pemohon->jawatan->fname; ?></td>
                                    <td class="text-center"><?= TblWarnaKad::WarnaKadSemasa($senarai->pemohon_icno, $month, 1, $year) ?></td>
                                    <td class="text-center"><?= TblWarnaKad::WarnaKadSemasa($senarai->pemohon_icno, $month, 2, $year) ?></td>
                                    <td class="text-center"><?= TblWarnaKad::WarnaKadSemasa($senarai->pemohon_icno, $month, 3, $year) ?></td>
                                    <td class="text-center"><div class="tile-stats" style="width:auto; height: 25px; padding:0px;background-color:  <?= TblWarnaKad::WarnaKadSemasa($senarai->pemohon_icno, $month,NULL,$year) ?>"></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="7" class="align-center text-center"><i>Tiada Kakitangan Untuk Dipantau</i></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
