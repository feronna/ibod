<?php
use app\models\kontrak\Kontrak;

error_reporting(0);
?>
<?= $this->render('/kontrak/_topmenu') ?>


<div class="row"> 
    <div class="x_panel">
       
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Ringkasan Data Pelantikan Semula Kontrak Kakitangan Pentadbiran [Sesi <?= $sesi->sesi.' '.$tahun?>]</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            
            <div class="clearfix"></div>
            
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
                <thead>
                <tr class="headings">
                    <th class="text-center">Bil</th>
                    <th class="text-center">Status Lantikan Kontrak</th>
                    <th class="text-center">Markah LNPT</th>
                    <th class="text-center">Jumlah</th>
                </tr>
                </thead>
                <tr>
                   <td class="text-center"  style="text-align:center">1</td>
                   <td class="text-center">2 tahun dengan KGT</td>
                   <td class="text-center" style="color:black">85% ke atas</td>
                   <td class="text-center"  style="text-align:center">
                       <?php $s1 = count(Kontrak::find()->joinWith('markahkeseluruhan1')->where(['sesi_id' => $sesi, 'tahun_sesi' => $tahun])->andWhere(['job_category' => '2', 'status' => '3', 'tempoh_l_jfpiu' => '2 Tahun'])->andWhere(['>=','markah_PP','85'])->all());
                       echo $s1;?></td>
                </tr>
                <tr>
                   <td class="text-center"  style="text-align:center">2</td>
                   <td class="text-center">1 tahun dengan KGT (Cadangan JFPIU)</td>
                   <td class="text-center" style="background-color: rgb(218,150,148); color: black">85% ke atas</td>
                   <td class="text-center"  style="text-align:center">
                       <?php $s2= count(Kontrak::find()->joinWith('markahkeseluruhan1')->where(['sesi_id' => $sesi, 'tahun_sesi' => $tahun])->andWhere(['job_category' => '2', 'status' => '3'])->andWhere(['>=','markah_PP','85'])->andWhere(['tempoh_l_jfpiu' => '1 Tahun'])->all());
                       echo $s2;?></td>
                </tr>
                <tr>
                   <td class="text-center"  style="text-align:center">3</td>
                   <td class="text-center">1 tahun dengan KGT</td>
                   <td class="text-center" style="background-color: rgb(183,222,232); color: black">80% - 84.99%</td>
                   <td class="text-center"  style="text-align:center">
                       <?php $s3 = count(Kontrak::find()->joinWith('markahkeseluruhan1')->where(['sesi_id' => $sesi, 'tahun_sesi' => $tahun])->andWhere(['job_category' => '2', 'status' => '3'])->andWhere(['>=','markah_PP','80'])->andWhere(['<','markah_PP','85'])->all());
                       echo $s3;?></td>
                </tr>
                <tr>
                   <td class="text-center"  style="text-align:center">4</td>
                   <td class="text-center">1 tahun dengan KGT dan surat peringatan</td>
                   <td class="text-center" style="background-color: rgb(177,160,199); color: black">75% - 79.99%</td>
                   <td class="text-center"  style="text-align:center">
                       <?php $s4 = count(Kontrak::find()->joinWith('markahkeseluruhan1')->where(['sesi_id' => $sesi, 'tahun_sesi' => $tahun])->andWhere(['job_category' => '2', 'status' => '3'])->andWhere(['>=','markah_PP','75'])->andWhere(['<','markah_PP','80'])->all());
                       echo $s4;?></td>
                </tr>
                <tr>
                   <td class="text-center"  style="text-align:center">5</td>
                   <td class="text-center">Boleh Ditamatkan/ Dilanjutkan Tanpa KGT</td>
                   <td class="text-center" style="background-color: rgb(79,129,189); color: black">Dibawah 70%</td>
                   <td class="text-center"  style="text-align:center">
                       <?php $s5 = count(Kontrak::find()->joinWith('markahkeseluruhan1')->where(['sesi_id' => $sesi, 'tahun_sesi' => $tahun])->andWhere(['job_category' => '2', 'status' => '3'])->andWhere(['<','markah_PP','70'])->all());
                       echo $s5;?></td>
                </tr>
                <tr>
                   <td class="text-center"  style="text-align:center">6</td>
                   <td class="text-center">Belum Diperakukan</td>
                   <td class="text-center" style="background-color: rgb(250,191,143); color: black"></td>
                   <td class="text-center"  style="text-align:center">
                       <?php $s6 = count(Kontrak::find()->joinWith('markahkeseluruhan1')->where(['sesi_id' => $sesi, 'tahun_sesi' => $tahun])->andWhere(['job_category' => '2'])->andWhere(['!=', 'status', '3'])->all());
                       echo $s6;?></td>
                </tr>
                <tr>
                   <td class="text-center"  style="text-align:center">7</td>
                   <td class="text-center">LNPT belum dinilai</td>
                   <td class="text-center" style="background-color: rgb(112,48,160); color: black"></td>
                   <td class="text-center"  style="text-align:center">
                       <?php $s7 = count(Kontrak::find()->joinWith('markahkeseluruhan1')->where(['sesi_id' => $sesi, 'tahun_sesi' => $tahun])->andWhere(['job_category' => '2', 'status' => '3', 'markah_PP' => NULL])->all());
                       echo $s7;?></td>
                </tr>
                <tr>
                   <td class="text-center"  style="text-align:center">8</td>
                   <td class="text-center">Tidak Diperakukan</td>
                   <td class="text-center" style="background-color: red; color: black"></td>
                   <td class="text-center"  style="text-align:center">
                       <?php $s8 = count(Kontrak::find()->joinWith('markahkeseluruhan1')->where(['sesi_id' => $sesi, 'tahun_sesi' => $tahun])->andWhere(['job_category' => '2'])->andWhere(['status' => '3', 'status_jfpiu' => '5'])->all());
                       echo $s8;?></td>
                </tr>
                <tr>
                    <td class="text-center" colspan="3" style="text-align:right; background-color: rgb(148,138,84); color: black"><b>JUMLAH KESELURUHAN</b></td>
                   <td class="text-center" style="background-color: rgb(148,138,84); color: black"><?= $s1+$s2+$s3+$s4+$s5+$s6+$s7+$s8;?></td>
                </tr>
            </table>
            </div>
        </div>
    </div>
</div>