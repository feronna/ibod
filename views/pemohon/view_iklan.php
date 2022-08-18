<?php

use yii\helpers\Html;

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
                        <?php echo Html::a('Halaman Utama', ['halaman-utama'], ['class' => 'btn btn-primary btn-sm']); ?>   
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
                                
                                    <th class="col-md-3 col-sm-3 col-xs-12 text-right">Penempatan: </th>
                                    <td>  
                                        <?php
                                        $counter = count($penempatan);
                                        $i = 1;
                                        foreach ($penempatan as $penempatan) {

                                            echo $penempatan->campus->campus_name;
                                            if ($counter != $i) {
                                                echo '/';
                                            }$i++;
                                        }
                                        //temporary
                                        $hums = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 11, 12, 15, 16, 17, 18, 20, 21);
                                        if (in_array($iklan->id, $hums)) {
                                            echo ' - Hospital Universiti Malaysia Sabah';
                                        }
                                        ?>    
                                    </td> 
                                </tr> 
                                <tr> 
                                    <th class="col-md-3 col-sm-3 col-xs-12 text-right">Jadual Gaji: </th><td>
                                     <?php if($iklan->jawatan->gred == "U41") { ?> 
                                        RM 2,429.00 - RM 9,656.00
                                        <?php }else{ ?>
                                        RM <?= $iklan->gaji->r_jg_min; ?> - RM <?= $iklan->gaji->r_jg_maks; ?>
                                        
                                        <?php } ?>    
                                    </td> 
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
                                if ($gred->tugas) {
                                    $counter = 0;
                                    foreach ($gred->tugas as $tugas) {
                                        $counter = $counter + 1;
                                        ?>
                                        <tr>
                                            <td>
                                                <?= $counter; ?>.  <?= $tugas->tugas_desc; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </table>
                        </div> 

                    </div>

                    <div class="col-md-5 col-sm-5 col-xs-12" style="border:0px solid #e5e5e5;">
                        <div class="x_panel">
                            <h2>SYARAT KELAYAKAN</h2>
                            <table class="table table-borderless">

                                <?php
                                if ($gred->kelayakan) {
                                    $counter = 0;
                                    foreach ($gred->kelayakan as $kelayakan) {
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

                    </div>


                </div>
            </div>
        </div>
    </div>  

</div>