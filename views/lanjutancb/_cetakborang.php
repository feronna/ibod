<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

error_reporting(0);
$this->title = 'Permohonan Pelanjutan Tempoh Cuti Belajar';
?> 




<div class="col-md-12 col-sm-3 col-xs-12" style=" font-size:15px;">
    <div class="profile_img text-center">
        <div id="crop-avatar"> 

            <img src="/staff/web/images/logo-umsblack-text-png.png" width="200px" height="auto" alt="signature"/> <br><br>
        </div>
    </div>
</div>
<div style=" text-align:center">

    <br><b><h5>UNIT PENGEMBANGAN PROFESIONALISME | BAHAGIAN SUMBER MANUSIA <br/><u> 
                PERMOHONAN PENGAJIAN LANJUTAN TEMPOH CUTI BELAJAR KALI
<?= $model->idlanjutan; ?> </h5></b>
</div>
<br/>
<div class="row">

    <h6><b>MAKLUMAT PERIBADI</b></h6>



    <table class="table" style="font-size: 10px;font-family:Arial;"> 
        <tbody>
            <tr style="background-color:lightseagreen;color:white">

                <th colspan="5" class="text-center"> 
        <p style="font-size: 14px;"><?= strtoupper($model->kakitangan->CONm); ?> |
<?= date("Y") - date("Y", strtotime($model->kakitangan->COBirthDt)) . " " . "TAHUN" ?></p><br/>
        </th>
        </tr>

        <tr>
            <th rowspan="8" class="text-center">
        <center>
            <div class="profile_img">
                <div id="crop-avatar"> <br/><br/>
                    <img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($model->kakitangan->ICNO)); ?>.jpeg" width="90" height="120">
                </div>
            </div> 
        </center>
        </th>  

        </tr>  
        <tr> 
            <th style="width:20%">JAWATAN </th>
            <td style="width:20%"> <?= strtoupper($model->kakitangan->jawatan->fname); ?></td> 
            <th>JFPIB</th>
            <td><?= strtoupper($model->kakitangan->department->fullname); ?></td>  

        </tr>

        <tr> 
            <th style="width:20%">ICNO</th>
            <td style="width:20%"><?= $model->kakitangan->ICNO; ?></td> 
            <th>UMSPER</th>
            <td><?= $model->kakitangan->COOldID; ?></td>  

        </tr>
        <tr> 


            <th style="width:20%">TARIKH LANTIKAN</th>
            <td style="width:20%"><?= strtoupper($model->kakitangan->displayStartLantik); ?></td>
            <th style="width:20%">TARAF PERKAHWINAN</th>
            <td style="width:20%"> <?= strtoupper($model->kakitangan->displayTarafPerkahwinan) ?></td>


        </tr>

        <tr> 

            <th style="width:20%">TARIKH DISAHKAN DALAM PERKHIDMATAN</th>
            <td style="width:20%">  <?php
                if ($model->kakitangan->confirmDt) {
                    echo strtoupper($model->kakitangan->confirmDt->tarikhMula);
                } else {
                    echo '<i>Tiada Maklumat</i>';
                }
                ?></td>
            <th style="width:20%">TEMPOH BERKHIDMAT SEMASA</th>
            <td style="width:20%"><?= strtoupper($model->kakitangan->servPeriodPermanent); ?></td>


        </tr>

        <tr> 

            <th style="width:20%">EMEL</th>
            <td style="width:20%"><?= $model->kakitangan->COEmail; ?></td> 
            <th style="width:20%">NO. TELEFON</th>
            <td style="width:20%"><?= $model->kakitangan->COHPhoneNo; ?></td>
        </tr>
        </tbody>
    </table> 
</div> 
<br/>

</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">

            <div class="x_title">
                <h6 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN</strong></h6>

                <div class="clearfix"></div>
            </div>      

            <?php if ($b) {
                ?>  


                <div class="x_content ">

                    <div class="table-responsive" >

                        <table class="table table-striped table-sm  table-bordered" style="font-size: 10px;font-family:Arial;">
                            <thead>

                                <tr class="info">
                                    <th colspan="8" style="background-color:lightseagreen;color:white"><center>

                                <?php
                                if ($b->tahapPendidikan) {
                                    echo strtoupper($b->tahapPendidikan);
                                }
                                ?></center></th>
                            </tr>
                                <?php if ($b->l) { ?> 
                                <tr> 



                                    <th colspan="4" align="left">TEMPAT PENGAJIAN ASAL:</th>
                                    <td colspan="4" align="left">

        <?php echo $b->InstNm; ?>



                                    </td>
                                </tr>
                                <tr> 



                                    <th colspan="4" align="left">TEMPAT PENGAJIAN BAHARU:</th>
                                    <td colspan="4" align="left">

        <?php echo $b->l->renewTempat; ?>



                                    </td>






    <?php } ?></tr>
                            <tr>
                                <th colspan="4" align="left">UNIVERSITI/INSTITUSI</th>
                                <td colspan="4" align="left">
                                <?php echo strtoupper($b->InstNm); ?></td>

                            </tr>

                            <tr>

                                <th colspan="4" align="left">BIDANG</th>
                                <td colspan="4"><?php
                            if (($b->MajorCd == NULL) && ($b->MajorMinor != NULL)) {
                                echo strtoupper($b->MajorMinor);
                            } elseif (($b->MajorCd != NULL) && ($b->MajorMinor != NULL)) {
                                echo strtoupper($b->MajorMinor);
                            } else {
                                echo strtoupper($b->major->MajorMinor);
                            }
                                ?></td>
                            </tr>

                            <tr> 

                                <th colspan="4" align="left">MOD PENGAJIAN</th>
                                <td colspan="4">

                                    <?php
                                    if ($b->modeID) {
                                        echo strtoupper($b->mod->studyMode);
                                    } else {
                                        echo "Tiada Maklumat";
                                    }
                                    ?></td></tr>






                            <tr> 

                                <th colspan="4" align="left">TEMPOH PENGAJIAN LANJUTAN</th>
                                <td colspan="4">
    <?= strtoupper($b->tarikhmula) ?> <b>HINGGA</b> 
    <?= strtoupper($b->tarikhtamat) ?> (<?= strtoupper($b->tempohpengajian); ?>)</td>
                            </tr>



                            <tr>
                                <th colspan="4" align="left">BIASISWA:</th>
                                <td colspan="4" align="left"><?= ucwords(strtoupper($b->tajaan->nama_tajaan)); ?></td> 
                            </tr>









                        </table>
                    </div> 

                </div></div><?php } ?>
    </div>
</div>


<div class="x_panel">
    <div class="x_title">
        <h6><strong><i class="fa fa-th-list"></i> MAKLUMAT PELANJUTAN TERDAHULU</strong></h6>


        <div class="clearfix"></div>
    </div>
    <div>
        <form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered" style="font-size: 11px;font-family:Arial;">
                <thead style="background-color:lightseagreen;color:white">

                    <tr class="headings">
                        <th width="50px" height="20px" class=" text-center" style="background-color:lightseagreen;color:white">BIL</th>
                        <th style="background-color:lightseagreen;color:white">TARIKH PELANJUTAN CUTI BELAJAR </th>
                        <th class="column-title text-center" style="background-color:lightseagreen;color:white">TEMPOH </th>
                        <th class="column-title text-center" style="background-color:lightseagreen;color:white">PELANJUTAN KALI KE</th>
                        <th class="column-title text-center" style="background-color:lightseagreen;color:white">JUSTIFIKASI</th>

                    </tr>




                </thead>
                <tbody>

<?php if ($b->lanjutan) { ?>
    <?php $bil = 1;
    foreach ($b->lanjutan as $l) { ?>
                            <tr>
                                <td class="text-center"><?= $bil++ ?></td>
                                <td> <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id' => $l->id])->one()->stlanjutan) ?> 
                                    HINGGA <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id' => $l->id])->one()->ndlanjutan) ?></td>
                                <td class="text-center">

                            <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id' => $l->id])->one()->tempohlanjutan) ?></td>

                                <td class="text-center"><?= $l->idlanjutan; ?></td>

                                <td class="text-center"><?= $l->justifikasi; ?></td>


                            </tr>
                                <?php }
                            } else {
                                ?>
                        <tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                        </tr>
    <?php }
?>







            </table>
        </form>           </div>
</div>  

<div class="x_panel">   <div class="x_content">
        <div class="x_title">
            <h6 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PRESTASI PENGAJIAN (TERKINI)</strong><br><br>
            </h6>





        </div>
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped " style="font-size: 11px;font-family:Arial;"> 

                <tr>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white" >BIL</th>
                    <th class="column-title text-center"   style="background-color:lightseagreen;color:white">PERKARA</th>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">PERATUSAN/ TARIKH/ BILANGAN</th>
                    <th class="column-title text-center" colspan="10"  style="background-color:lightseagreen;color:white">ULASAN</th>

                </tr>

                <tr>
                    <th scope="col" colspan=10"  style="background-color:lightblue;">PENYELIDIKAN:</th>

                </tr>



                <tr>
                    <th scope="col" colspan=13"  style="background-color:lightblue;">KURSUS PENYELIDIKAN:</th>

                </tr>
<?php
foreach ($doktoral as $dok) {
    if ($dok->id < 7) {

        $no++;
        $mod = \app\models\cbelajar\TblPrestasi::find()->where(['idPrestasi' => [$dok->id], 'idLanjutan' => $model->id, 'iklan_id' => $model->iklan_id])->one();
        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $dok->prestasi; ?></td>
                            <td><?php echo $mod->catatan; ?></td> 
                            <td colspan="10"><?php echo $mod->komen; ?></td> 


                        </tr>


        <?php
    }
}

//                             }
//                         
?>










            </table>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped " style="font-size: 11px;font-family:Arial;"> 

                <tr>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white" >BIL</th>
                    <th class="column-title text-center"   style="background-color:lightseagreen;color:white">PERKARA</th>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">PERATUSAN/ TARIKH/ BILANGAN</th>
                    <th class="column-title text-center" colspan="10"  style="background-color:lightseagreen;color:white">ULASAN</th>

                </tr>

                <tr>
                    <th scope="col" colspan=10"  style="background-color:lightblue;">PENYELIDIKAN:</th>

                </tr>



                <tr>
                    <th scope="col" colspan=13"  style="background-color:lightblue;">KERJA KURSUS:</th>

                </tr>
<?php
foreach ($doktoral as $dok) {
    if ($dok->id >= 7) {

        $no++;
        $mod = \app\models\cbelajar\TblPrestasi::find()->where(['idPrestasi' => [$dok->id], 'idLanjutan' => $model->id, 'iklan_id' => $model->iklan_id])->one();
        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $dok->prestasi; ?></td>
                            <td><?php echo $mod->catatan; ?></td> 
                            <td colspan="10"><?php echo $mod->komen; ?></td> 


                        </tr>


                        <?php
                    }
                }

//                             }
//                         
                ?>










            </table>
        </div> </div></div>
<div class="row">

<div class="x_title">
                <h6 ><strong><i class="fa fa-graduation-cap"></i> JUSTIFIKASI PELANJUTAN</strong></h6>
<small><?= $model->justifikasi;?></small>

                <div class="clearfix"></div>
            </div> 
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">

            <div class="x_title">
                <h6 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PERMOHONAN</strong></h6>

                <div class="clearfix"></div>
            </div>      




            <div class="x_content ">

                <div class="table-responsive" >

                    <table class="table table-striped table-sm  table-bordered" style="font-size: 10px;font-family:Arial;">
                        <thead>

                            <tr class="info">
                                <th colspan="8" style="background-color:lightseagreen;color:white"><center>

                            PELANJUTAN BAHARU YANG DIPOHON
                        </center></th>
                        </tr>

                        <tr> 

                            <th colspan="4" align="left">TEMPOH MASA (BULAN):</th>
                            <td colspan="4">
<?php echo strtoupper($model->tempohlanjutan); ?></td></tr>

                        <tr> 

                            <th colspan="4" align="left">TARIKH MULA PELANJUTAN</th>
                            <td colspan="4">
<?= strtoupper($model->stlanjutan) ?> HINGGA <?= strtoupper($model->ndlanjutan) ?> 
                            </td></tr>


                       
                        <tr>
                            <th colspan="4" align="left">SURAT SOKONGAN DAN PERAKUAN PENYELIA:</th>




<?php
if ($model->c4 == 1) {
    ?>

                                <td  colspan="4" align="center" ><?php echo '&#10004;'; ?></td>
<?php
} elseif ($model->c4 == 2) {
    ?>

                                <td  colspan="4" align="center" ><?php echo '&#10008;'; ?></td>

                            <?php } ?>





                        </tr>

                        <tr>
                            <th colspan="4" align="left">PERANCANGAN PENGAJIAN (STUDY PLAN) TERDAHULU:</th>




<?php
if ($model->c3 == 1) {
    ?>

                                <td  colspan="4" align="center" ><?php echo '&#10004;'; ?></td>
<?php
} elseif ($model->c3 == 2) {
    ?>

                                <td  colspan="4" align="center" ><?php echo '&#10008;'; ?></td>

                            <?php } ?>





                        </tr>

                        <tr>
                            <th colspan="4" align="left">PERANCANGAN PENGAJIAN YANG DIUBAHSUAI:<br>
                                <small><i>MENGAMBIL KIRA TEMPOH PELANJUTAN YANG DIPOHON</th>




<?php
if ($model->c2 == 1) {
    ?>

                                            <td  colspan="4" align="center" ><?php echo '&#10004;'; ?></td>
<?php
} elseif ($model->c2 == 2) {
    ?>

                                            <td  colspan="4" align="center"><?php echo '&#10008;'; ?></td>

                                        <?php } ?>





                                        </tr>

                                        <tr>
                                            <th colspan="4" align="left">BORANG PERMOHONAN PELANJUTAN BIASISWA KPT:<br>
                                            </th>                        



<?php
if ($model->c5 == 1) {
    ?>

                                                <td  colspan="4" align="center" ><?php echo '&#10004;'; ?></td>
<?php
} elseif ($model->c5 == 2) {
    ?>

                                                <td  colspan="4" align="center"><?php echo '&#10008;'; ?></td>

                                            <?php
                                            } else {
                                                echo '-';
                                            }
                                            ?>





                                        </tr>

                                        <tr>
                                            <th colspan="4" align="left">LAPORAN KEMAJUAN KURSUS & TRANSKRIP KEPUTUSAN PEPERIKSAAN:</th>




<?php
if ($model->c1 == 1) {
    ?>

                                                <td  colspan="4" align="center" ><?php echo '&#10004;'; ?></td>
<?php
} elseif ($model->c1 == 2) {
    ?>

                                                <td  colspan="4" align="center" ><br><?php echo '&#10008;'; ?></td>

                                            <?php } ?>





                                        </tr>
                                        <tr>
                                            <th colspan="4" align="left">DIPERAKUKAN OLEH:</th>
                                            <td colspan="4"> <?= ucwords(strtoupper($model->ketuajfpiu)); ?>  </td>


                                        </tr>
                                        <tr>
                                            <th colspan="4" align="left">STATUS KETUA JABATAN/DEKAN:</th>
                                            <td colspan="4"> <?= ucwords(strtoupper($model->status_jfpiu)); ?> (<?= $model->app_date; ?>)  </td>


                                        </tr>

                                        <tr>
                                            <th colspan="4" align="left">ULASAN JFPIU:</th>
                                            <td colspan="4" style='white-space:pre-line;'> <?= ucwords(strtoupper($model->ulasan_jfpiu)); ?>  </td>


                                        </tr>
                                        <tr>
                                            <th colspan="4" align="left">HASIL SEMAKAN BSM:</th>
                                            <td colspan="4"> <?= ucwords(strtoupper($model->status_semakan)); ?>  </td>


                                        </tr>
                                        <tr>
                                            <th colspan="4" align="left">CATATAN BSM:</th>
                                            <td colspan="4"> <?= ucwords(strtoupper($model->ulasan_bsm)); ?>  </td>


                                        </tr>
                                        <tr>
                                            <th colspan="4" align="left">STATUS PERMOHONAN:</th>
                                            <td colspan="4"> <?= ucwords(strtoupper($model->status)); ?>  </td>


                                        </tr>











                                        </table>
                                        </div> 

                                        </div></div>
                                        </div>
                                        </div>


                                        <div class="row" > 
                                            <div class="col-xs-12 col-md-12 col-lg-12"> 

                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <h6><strong><i class="fa fa-check-square"></i> PERAKUAN PEMOHON </strong></h6>

                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content">
                                                        <h4 style="font-size: 18px;font-family:Times New Roman;"><small>Saya mengaku  semua keterangan di atas adalah benar dan jika saya didapati memberi 
                                                                maklumat palsu, saya bersetuju permohonan ini (jika telah diluluskan) 
                                                                akan terbatal dengan sendirinya dan boleh diambil tindakan perundangan.</small> </h4>
                                                        <h5 style="font-size: 12px;font-family:Times New Roman;">Tarikh Hantar: <?php echo $model->tarikhmohon; ?></h5><br/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <p align="right"><font size="2">  
<?php echo "[Tarikh Dicetak:" . ' ' . date("Y-m-d") . ', ' . date("h:i:sa") . "]"; ?></p>



