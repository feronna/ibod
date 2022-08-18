<?php

use app\models\cuti\Layak;
use app\models\cuti\TblRecords;
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
                            <th class="text-center">Jumlah Cuti</th>
                            <th class="text-center">Baki Cuti</th>
                            <th class="text-center">Jumlah Cuti Di Pohon Pada Bulan Semasa</th>
                            <!-- <th class="text-center">Mengambil Cuti Hari ini</th> -->
                    
                        </tr>
                        <?php if ($model) { ?>
                            <?php foreach ($model as $senarai) { ?>
                                <tr>
                                    <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                    <td class="text-center"><?php echo $senarai->pemohon->CONm; ?></td>
                                    <td class="text-center"><?php echo $senarai->pemohon->jawatan->fname; ?></td>
                                    <td><?= Layak::getLatestLayak($senarai->pemohon_icno) ? Layak::getLatestLayak($senarai->pemohon_icno)->layak_cuti + Layak::getLatestLayak($senarai->pemohon_icno)->layak_bawa_lepas +  + Layak::getLatestLayak($senarai->pemohon_icno)->layak_selaras : "0" ?></td>
                                    <td class="text-center"><?= Layak::getBakiLatest($senarai->pemohon_icno) ?></td>
                                    <td class="text-center"><?= TblRecords::totalCutiCurr($senarai->pemohon_icno) ?></td>
                                    <!-- <td class="text-center"><?= TblRecords::leavestat($senarai->pemohon_icno) ?></td> -->
                                   
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
