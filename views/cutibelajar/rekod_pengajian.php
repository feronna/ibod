


<?php

use yii\helpers\Html;

echo $this->render('/cutibelajar/_topmenu');

error_reporting(0);
?> 
<p align="right"><?= Html::a('Kembali', ['cutibelajar/halaman-pemohon'], ['class' => 'btn btn-primary btn-sm'])
?></p>

<div class="x_panel">
    <div class="x_content">  
        <span class="required" style="color:#062f49;">
            <strong>
                <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | 
     BAHAGIAN SUMBER MANUSIA<br/><u> REKOD PENGAJIAN
 '); ?>
                </center>  </strong>
        </span> 
    </div>
</div>
<div class="x_panel">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>
        <div class="x_title">
            <h5 ><strong><i class="fa fa-user-circle"></i> MAKLUMAT PERIBADI</strong></h5>


            <div class="clearfix"></div>
            <div class="x_content collapse">
                <div class="col-md-3 col-sm-3  profile_left"> 
                    <div class="profile_img">
                        <div id="crop-avatar"> <br/><br/>
                            <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($biodata->ICNO)); ?>.jpeg" width="150" height="180"></center>
                        </div>
                    </div> 
                    <br/> 
                </div>
                <div class="col-md-9 col-sm-9 col-xs-9">

                    <div class="col-md-12 col-sm-12 col-xs-12">   
                        <br/>
            <!--                        <h4 colspan="2" style="background-color:lightseagreen;color:white"><center>MAKLUMAT PERIBADI</center></h4>-->

                        <table class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th colspan="4" class="text-center">
                            <h5><center><?= strtoupper($biodata->CONm); ?> |
                                    <?= date("Y") - date("Y", strtotime($biodata->COBirthDt)) . " " . "TAHUN" ?> </center></h5> 

                            </th>
                            </tr>  
                            <tr>
                                <th colspan="4" class="text-center"> 
                                    <?= strtoupper($biodata->jawatan->fname); ?> | 
                                    <?= strtoupper($biodata->department->fullname); ?>
                                </th> 
                            </tr>
                            </thead>
                            <tbody>

                                <tr> 
                                    <th style="width:20%">ICNO</th>
                                    <td style="width:20%"><?= $biodata->ICNO; ?></td> 
                                    <th>UMSPER</th>
                                    <td><?= $biodata->COOldID; ?></td>  

                                </tr>
                                <tr> 


                                    <th style="width:20%">TARIKH LANTIKAN</th>
                                    <td style="width:20%"><?= strtoupper($biodata->displayStartLantik); ?></td>
                                    <th style="width:20%">TARIKH DISAHKAN DALAM PERKHIDMATAN</th>
                                    <td style="width:20%">  <?php
                                        if ($biodata->confirmDt) {
                                            echo strtoupper($biodata->confirmDt->tarikhMula);
                                        } else {
                                            echo 'TIADA MAKLUMAT';
                                        }
                                        ?></td>


                                </tr>
                                <tr> 

                                    <th style="width:20%">TARIKH DISAHKAN DALAM PERKHIDMATAN</th>
                                    <td style="width:20%">  <?php
                                        if ($biodata->confirmDt) {
                                            echo strtoupper($biodata->confirmDt->tarikhMula);
                                        } else {
                                            echo 'TIADA MAKLUMAT';
                                        }
                                        ?></td>
                                    <th style="width:20%">TEMPOH BERKHIDMAT SEMASA</th>
                                    <td style="width:20%"><?= strtoupper($biodata->servPeriodPermanent) ?></td>


                                </tr>

                                <tr> 

                                    <th>EMEL</th>
                                    <td><?= $biodata->COEmail; ?></td> 
                                    <th style="width:20%">NO. TELEFON</th>
                                    <td style="width:20%"><?= $biodata->COHPhoneNo; ?></td>
                                </tr>



                            </tbody>
                        </table> 
                    </div> 
                    <br/>

                </div>
            </div>
        </div>
    </div></div>

<div class="tile-stats" style='padding:10px'>
                        <div class="x_content">

                            <div style='padding: 15px;' class="table-bordered">
                                <font><u><strong>MAKLUMAN</u> </strong></font><br><br>
                                <b>PENGAJIAN: SARJANA/SARJANA KEPAKARAN/PHD</b><br>
                                <strong>
                                    
                               1. ANDA DIMINTA UNTUK <b style="color:red">
                                   MENGHANTAR LAPORAN KEMAJUAN PENGAJIAN  (LKP) TERAKHIR</b> ANDA SEBELUM MENGESAHKAN 
                               BORANG LAPOR DIRI <i>ONLINE</i> ANDA.</strong> <br>
                               
                               <p align="left"> <?= Html::a('LAPORAN KEMAJUAN PENGAJIAN (LKP)', ['lkk/senarailkk'], 
                 ['class' => 'btn btn-primary btn-sm','target' => "_blank",'title'=> 'Menu LKP']) ?></p>
                                
                                &nbsp;&nbsp;&nbsp;&nbsp;<br>
                                
                                <strong>
                                    
                               2. TUNTUTAN ELAUN TESIS, ELAUN AKHIR PENGAJIAN HANYA BOLEH DIBUAT JIKA MEMPUNYAI DOKUMEN YANG DIPERLUKAN DI DALAM BORANG TERSEBUT. 
                               NAMUN, JIKA TIADA PERMOHONAN INI
                               BOLEH DILANGKAU DAN DIMOHON KETIKA DOKUMEN-DOKUMEN YANG DIPERLUKAN ADA.
                                   <br>
                                   <p align="left"> <?= Html::a('TUNTUTAN ELAUN', ['cutibelajar/senarai-borang'], 
                 ['class' => 'btn btn-primary btn-sm','target' => "_blank",'title'=> 'Menu LKP']) ?></p>
                            
                                   <br>
<!--                                   <b>3. CUTI SABATIKAL/POS DOKTORAL/LATIHAN INDUSTRI/PRA-WARTA/LATIHAN PENYELIDIKAN</b><br>
                                   LAPORAN AKHIR WAJIB DISERTAKAN DALAM BORANG LAPOR DIRI.-->
                                    <div class="x_panel">
                <style>
.w3-table td,.w3-table th,.w3-table-all td,.w3-table-all th
{padding:2px 2px;display:table-cell;text-align:left;vertical-align:top}
</style>

                <div class="alert alert-info alert-dismissible fade in">
                        <table class="w3-table w3-bordered" style="font-size: 15px; color:black">
                          <h5 style="color:white">
                              <i class="fa fa-question-circle" style="color:white"></i> 
                               CUTI SABATIKAL/POS DOKTORAL/LATIHAN INDUSTRI/PRA-WARTA/LATIHAN PENYELIDIKAN:</h5>
                          <tr>
                             <td width="50px" height="20px"><center>1.</center></td> 
                        <td><small>LAPORAN AKHIR WAJIB DISERTAKAN DALAM BORANG LAPOR DIRI.</small></td>
                          </tr>
                            
                        
                         </table>
                </div>
            </div>
                            </div>
                                 
                        </div>

                    </div>


<div class="x_panel">
    <div class="col-md-12 col-sm-12 col-xs-12">

        <div class="x_title">
            <h5><strong><i class="fa fa-university"></i> REKOD LAPOR DIRI KEMBALI BERTUGAS </strong></h5>
            <!--             <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li> 
                        </ul>-->
            <div class="clearfix"></div>
        </div>

        <div class="x_content">

            <div class="table-responsive">
                <table class="table table-bordered jambo_table">
                    <thead>
                        <tr class="headings">
                            <th class="column-title text-center">BIL</th>
                            <th class="text-center">GRED SEMASA  </th>
                            <th class="text-center">PERINGKAT PENGAJIAN  </th>
                            <th class="text-center">TARIKH PENGAJIAN </th>
                            <th class="text-center">UNIVERSITI/INSTITUSI</th>
                            <th class="text-center">STATUS PENGAJIAN </th>

    <!--                        <th class="text-center">Baki Bon Perkhidmatan (Tahun) </th>-->


                        </tr>
                    </thead>
                    <?php
                    if ($pengajian) {
                        $counter = 0;
                        foreach ($pengajian as $pengajian) {
                            $counter = $counter + 1;
                            ?>

                            <tr>

                                <td width="1%"><?= $counter; ?></td>
                                <td class="text-center"> 
                                    <small><?= $pengajian->gred;
                            ?></small></td>
                                <td class="text-center"> <?php
                                    if ($pengajian->tahapPendidikan) {
                                        echo '<small>' . strtoupper($pengajian->tahapPendidikan) . '</small>';
                                    }
                                    ?></td>
                                <td class="text-center"><small><?= strtoupper($pengajian->tarikhmula) ?> HINGGA
                                        <?= strtoupper($pengajian->tarikhtamat) ?><br> 
                                        (<?= strtoupper($pengajian->tempohtajaan); ?>)</small></td>
                                <?php if ($pengajian->l) { ?> 


                                    <td class="text-center">

                                        <small><?php echo $pengajian->l->renewTempat; ?></small>



                                    </td>


                                    <?php
                                } else {
                                    ?>
                                    <td class="text-center">
                                        <small><?= $pengajian->InstNm; ?></small></td>

                                <?php }
                                ?>

                                <td class="text-center">

                                    <?php
                                    if ($pengajian->lapor->study->status_pengajian && $pengajian->lapor->agree == 1) {
                                        echo '<span class="label label-success">' . ($pengajian->lapor->study->status_pengajian) . '</span><br><small><b>'
                                        . strtoupper($pengajian->lapor->dt_lapordiri) . '</small></b>';
                                    } 
                                    elseif ($pengajian->lapor->status_a == "MANUAL") {
                                        echo '<span class="label label-success">' . ($pengajian->lapor->status_pengajian) . '</span><br><small><b>'
                                        . strtoupper($pengajian->lapor->dt_lapordiri) . '</small></b>';
                                    } else {
                                        ?>

                                        <?php if ($pengajian->lapor->status_pengajian == 1) { ?>
                                            <?= \yii\helpers\Html::a('SELESAI', ['lapordiri/borang'], ['class' => 'btn btn-primary btn-xs', 'target' => '_blank']) ?>  <br>
                                            <b style="color:red"><small>BELUM BUAT PENGESAHAN</small></b>
                                            <?php
                                        } elseif ($pengajian->lapor->status_pengajian == 3 || $pengajian->lapor->status_pengajian == 2 || $pengajian->lapor->status_pengajian == 4 || $pengajian->lapor->status_pengajian == 5 || $pengajian->lapor->status_pengajian == 6) {
                                            ?><br> <b style="color:red"><small>BELUM BUAT PENGESAHAN</small></b>
                                            <?= \yii\helpers\Html::a(' BELUM SELESAI', ['lapordiri/borang-belum-selesai'], ['class' => 'btn btn-danger btn-xs', 'target' => '_blank']) ?>

                                        <?php } else {
                                            ?>       
                                            <?= \yii\helpers\Html::a('SELESAI', ['lapordiri/borang'], ['class' => 'btn btn-primary btn-xs', 'target' => '_blank']) ?> |  
                                            <?= \yii\helpers\Html::a(' BELUM SELESAI', ['lapordiri/borang-belum-selesai'], ['class' => 'btn btn-danger btn-xs', 'target' => '_blank']) ?>

                                            <?php
                                        }
                                    }
                                    ?>




                            </tr>

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="8" class="text-center">Tiada Rekod</td>                     
                        </tr>
                    <?php }
                    ?>
                </table>

            </div>
        </div>
    </div>  

</div>
</div>




