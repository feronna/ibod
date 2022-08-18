<?php

use yii\helpers\Html;

if ($iklan->jawatan->fname == '(N41) Penolong Pendaftar') {
    $iklan->jawatan->fname = '(N41) Pegawai Tadbir';
}
?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <!-- page content --> 


    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= strtoupper($iklan->jawatan->fname); ?> </h2> 
                    <p align="right" >
<?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>  

                    </p>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="col-md-7 col-sm-7 col-xs-12">

                        <div class="table-responsive">
                            <table class="table table-sm table-bordered jambo_table table-striped"> 
                                <tr>
                                    <th class="col-md-3 col-sm-3 col-xs-12 text-right">Jawatan: </th><td><?= $iklan->jawatan->fname; ?></td> 
                                </tr>
                                <tr>
                                    <th class="col-md-3 col-sm-3 col-xs-12 text-right">Kumpulan: </th><td><?= $iklan->kumpulan->name; ?></td> 
                                </tr>
                                <tr>
                                    <th class="col-md-3 col-sm-3 col-xs-12 text-right">Klasifikasi: </th><td><?= $iklan->klasifikasi->name; ?></td> 
                                </tr> 
                                <tr>
                                    <th class="col-md-3 col-sm-3 col-xs-12 text-right">Kategori: </th><td><?= $iklan->kategori->name; ?></td> 
                                </tr> 
                                <tr>
                                    <th class="col-md-3 col-sm-3 col-xs-12 text-right">Penempatan: </th>
                                    <td>
                                        <?php
                                        if ($iklan->id == 18) {
                                            echo $iklan->penempatan->campus_name;
                                        } else {
                                            echo $iklan->penempatan->campus_name . ' - Hospital Universiti Malaysia Sabah';
                                        }
                                        ?> 

                                    </td> 
                                </tr>
                                <tr> 
                                    <th class="col-md-3 col-sm-3 col-xs-12 text-right">Jadual Gaji: </th><td>
                                        RM<?php
                                        if ($iklan->id == 9) {
                                            echo '2,740.00';
                                        } else if ($iklan->id == 11) {
                                            echo '1,218.00';
                                        } else if ($iklan->id == 10) {
                                            echo '1,493.00';
                                        } else if ($iklan->id == 18) {
                                            echo '9,038.00';
                                        } else {
                                            echo $iklan->gaji->r_jg_min;
                                        }
                                        ?> 

                                        - 

                                        RM<?php
                                        if ($iklan->id == 9) {
                                            echo '9,656.00';
                                        } else if ($iklan->id == 11) {
                                            echo '2,939.00';
                                        } else if ($iklan->id == 10) {
                                            echo '5,672.00';
                                        } else if ($iklan->id == 18) {
                                            echo '24,465.00';
                                        } else {
                                            echo $iklan->gaji->r_jg_maks;
                                        }
                                        ?></td> 
                                </tr> 
                                <?php if ($iklan->id == 18) { ?>
                                    <tr>
                                        <th class="col-md-3 col-sm-3 col-xs-12 text-right">Tempoh Lantikan: </th>
                                        <td>Tiga (3) tahun (tertakluk kepada  keputusan Kementerian Pendidikan Malaysia)
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th class="col-md-3 col-sm-3 col-xs-12 text-right">Tarikh Tutup: </th><td><?= $iklan->getTarikh($iklan->tarikh_tutup); ?></td>  
                                </tr> 

                            </table>
                        </div>
                        <div class="x_panel">
                            <h2>KETERANGAN TUGAS </h2> 
                            <table class="table table-borderless">
<?php
if ($iklan->tugas) {
    $counter = 0;
    foreach ($iklan->tugas as $tugas) {
        $counter = $counter + 1;
        ?>
                                        <tr>
                                            <td>
                                        <?= $counter; ?>.  <?= $tugas->tugas_desc; ?>
                                            </td>
                                        </tr>
                                    <?php }
                                }
                                ?>
                            </table>
                        </div> 

                    </div>

                    <div class="col-md-5 col-sm-5 col-xs-12" style="border:0px solid #e5e5e5;">

                        <div class="x_panel">
                            <h2>JUMLAH KEKOSONGAN </h2> 
                            <table class="table table-sm table-bordered jambo_table table-striped">
                                <tr>
                                    <td>
                                        <div align="center"><h3><?= $iklan->jumlah_kekosongan; ?>  <i class="fa fa-briefcase"></i></h3></div>   
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="x_panel">
                            <h2>SYARAT KELAYAKAN </h2>
                            <table class="table table-borderless">

<?php
if ($iklan->kelayakan) {
    $counter = 0;
    foreach ($iklan->kelayakan as $kelayakan) {
        $counter = $counter + 1;
        ?>
                                        <tr>
                                            <td>
                                        <?= $counter; ?>.  <?= $kelayakan->akademik_desc; ?></br></br>
                                        <?php if ($kelayakan->syarat_tamb_desc) { ?>
                                            <?= '<b>Syarat Tambahan</b>: ' . $kelayakan->syarat_tamb_desc; ?>

                                                </td>
                                            </tr>
                                                <?php
                                                }
                                            }
                                        }
                                        ?>
                            </table>
                        </div>
                        <div class="x_panel">
                            <h2>TARAF JAWATAN </h2>
                            <ul class="list-inline prod_size">
<?php foreach ($taraf_jawatan as $taraf_jawatan) { ?>
                                    <li>
                                        <button type="button" class="btn btn-success btn-round btn-sm btn-md">
    <?= $taraf_jawatan->taraf->ApmtStatusNm; ?>
                                        </button>
                                    </li>

                                        <?php } ?>   
                            </ul>
                        </div> 

                    </div>


                </div>
            </div>
        </div>
    </div>  

</div>