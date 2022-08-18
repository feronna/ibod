<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
    
    var datePickers = $(this).find("[data-krajee-kvdatepicker]");
        datePickers.each(function(index, el) {
//            $(this).parent().removeData().kvDatepicker("initDPRemove");
            $(this).parent().kvDatepicker(eval($(this).attr("data-krajee-kvdatepicker")));
        });
});
jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});
';

$this->registerJs($js);
error_reporting(0);
?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
<?php // $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<p align="right"><?= Html::a('Kembali', ['cutibelajar/halaman-pemohon'], ['class' => 'btn btn-primary btn-sm'])
?></p>

<div class="x_panel">  
    <div class="product_price"> 
        <h5 align="center" style="font-size:16px;font-weight: bold;"> 
            LAPOR DIRI TAMAT TEMPOH PENGAJIAN LANJUTAN
</h5> 
        <div class="clearfix"></div> 
    </div> 
</div>
<div class="row"> 
    <div class="col-md-12 col-xs-12"> 

        <div class="x_panel">

            <div class="x_title">
                <h4><strong> PANDUAN PERMOHONAN</strong></h4>
                <div class="clearfix"></div>     
            </div>
            <div class="x_content"> 
                <?php if ($model->biasiswa->jenisCd == 3) {
                    ?>
                    <b style="color:red">JIKA ANDA SELESAI, TAJAAN KPT:</b><br> 
                    <div align="justify"><strong>

                            1. SILA PILIH STATUS PENGAJIAN ANDA <b>LULUS</b>.</strong><br> </div>
                    <div align="justify"><strong>

                            2. SILA MUAT NAIK SALINAN SIJIL ASAL/SURAT PENGESAHAN SENAT LULUS PENGAJIAN.</strong><br> </div>
                    <div align="justify"><strong>

                            3. KLIK BUTANG ELAUN AKHIR PENGAJIAN UNTUK TUNTUTAN.</strong><br> </div>
                    <div align="justify"><strong>

                            4. KLIK BUTANG ELAUN TESIS UNTUK TUNTUTAN.</strong><br> </div>
                    <div align="justify"><strong>

                            5. KLIK BUTANG HADIAH PERGERAKAN GAJI UNTUK TUNTUTAN (HANYA UNTUK JAWATAN GRED DS45 SAHAJA).</strong><br> </div>

                    <div align="justify"><strong>
                            6. KLIK BUTANG PENGESAHAN UNTUK MENGHANTAR BORANG LAPOR DIRI ANDA.</strong><br> </div>

                    <br>
                <?php
                }
//    elseif($model->biasiswa->jenisCd == "NULL"){
//        
//        return "-";
//    }
                else {
                    ?>
                    <b style="color:red">JIKA ANDA SELESAI, TAJAAN UMS/LUAR:</b><br> 
                    <div align="justify"><strong>

                            1. SILA PILIH STATUS PENGAJIAN ANDA <b>LULUS</b>.</strong><br> </div>
                    <div align="justify"><strong>

                            2. KLIK BUTANG HADIAH PERGERAKAN GAJI UNTUK TUNTUTAN.</strong><br> </div>

                    <div align="justify"><strong>
                            3. KLIK BUTANG PENGESAHAN UNTUK MENGHANTAR BORANG LAPOR DIRI ANDA.</strong><br> </div>
<?php } ?>
            </div>
        </div>
    </div></div>
<div class ="row">
    <div class="col-md-12 col-xs-12"> 
        <div class="x_panel" id="rcorners2">
            <!--         <div class="x_title">
                      <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
                     </div>-->
            <!--    <div class="x_title">
                    <h2><strong><i class="fa fa-check-square"></i> PANDUAN PERMOHONAN</strong><br/>
                    <small>Sila Klik Setiap Butang Untuk Hantar Permohonan</small></h2>
                        
                        <div class="clearfix"></div>
                    </div>-->
            <div class="x_content">

                <?php
                echo Html::a(Yii::t('app', ' <i class="fa fa-graduation-cap"></i> STATUS PENGAJIAN'), ['lapordiri/borang'], ['class' => 'btn btn-primary btn-md', 'target' => '_blank']);
//  echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
//     echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/lkk-jfpiu'], ['class' => 'btn btn-default btn-lg']);
                ?>
                <?php if ($model->study2->tajaan->jenisCd == 3) {
                    ?><?php
                    echo Html::a(Yii::t('app', ' <i class="fa fa-th-list"></i> ELAUN AKHIR PENGAJIAN'), ['lapordiri/tuntut-akhir'], ['class' => 'btn btn-primary btn-md', 'target' => '_blank']);

                    echo Html::a(Yii::t('app', ' <i class="fa fa-book"></i> ELAUN TESIS'), ['lapordiri/tuntut-tesis'], ['class' => 'btn btn-primary btn-md', 'target' => '_blank']);
                    ?><?php } ?>
                <?php
                if ($model->kakitangan->jawatan->gred == "DS45") {
                    echo Html::a(Yii::t('app', ' <i class="fa fa-gift"></i> HADIAH PERGERAKAN GAJI'), ['lapordiri/tuntut-hpg'], ['class' => 'btn btn-primary btn-md', 'target' => '_blank']);
                }
                echo Html::a(Yii::t('app', ' <i class="fa fa-check"></i> PENGESAHAN'), ['lapordiri/pengesahan', 'i' => $model->laporID], ['class' => 'btn btn-primary btn-md', 'target' => '_blank']);
//  echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
//     echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/lkk-jfpiu'], ['class' => 'btn btn-default btn-lg']);
                ?>
            </div>
        </div>
    </div>


</div>
<div class="x_panel">
    <div class="x_title">
        <h5 ><strong><i class="fa fa-user"></i> MAKLUMAT PEMOHON</strong></h5>


        <div class="clearfix"></div>
    </div>      
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
<!--            <h4 colspan="2" style="background-color:lightseagreen;color:white"><center>MAKLUMAT PERIBADI</center></h4>-->

            <table class="table" style="width:100%">

                <thead>
                    <tr>
                        <th colspan="4" class="text-center">
                <h5><?= strtoupper($model->kakitangan->CONm); ?> |
<?= date("Y") - date("Y", strtotime($model->kakitangan->COBirthDt)) . " " . "TAHUN" ?></h5>
                </th>
                </tr>  
                <tr>
                    <th colspan="4" class="text-center"> 
                    <?= strtoupper($model->kakitangan->jawatan->fname); ?> | 
                    <?= strtoupper($model->kakitangan->department->fullname); ?>
                    </th> 
                </tr>
                </thead>
                <tbody>

                    <tr> 
                        <th style="width:20%">ICNO</th>
                        <td style="width:20%"><?= $model->kakitangan->ICNO; ?></td> 
                        <th>UMSPER</th>
                        <td><?= $model->kakitangan->COOldID; ?></td>  

                    </tr>
                    <tr> 


                        <th style="width:20%">TARIKH LANTIKAN</th>
                        <td style="width:20%"><?= strtoupper($model->kakitangan->displayStartLantik); ?></td>
                        <th width="20%">TARAF PERKAHWINAN: </th>
                        <td><?= strtoupper($model->kakitangan->displayTarafPerkahwinan) ?></td> 

                    </tr>
                    <tr> 

                        <th style="width:20%">TARIKH DISAHKAN DALAM PERKHIDMATAN</th>
                        <td style="width:20%">  <?php
                    if ($model->kakitangan->confirmDt) {
                        echo strtoupper($model->kakitangan->confirmDt->tarikhMula);
                    } else {
                        echo 'Tiada Maklumat';
                    }
                    ?></td>
                        <th style="width:20%">TEMPOH BERKHIDMAT SEMASA</th>
                        <td style="width:20%"><?= strtoupper($model->kakitangan->servPeriodPermanent); ?></td>


                    </tr>

                    <tr> 

                        <th>EMEL</th>
                        <td><?= $model->kakitangan->COEmail; ?></td> 
                        <th style="width:20%">NO. TELEFON</th>
                        <td style="width:20%"><?= $model->kakitangan->COHPhoneNo; ?></td>
                    </tr>



                </tbody>
            </table> 
        </div> 
        <br/>

    </div>
</div>

<div class="x_panel">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
<?php if ($model->agree == 2) { ?>   <p align="right">
    <?= Html::a('KEMASKINI BORANG LAPOR DIRI', ['borang?id=' . $model->laporID], ['class' => 'btn btn-primary btn-sm']) ?></p><?php } ?>
        <div class="x_title">
            <h5 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN </strong></h5>


            <div class="clearfix"></div>
        </div>      

<?php if ($model->study2) {
    ?>  


            <div class="x_content ">

                <div class="table-responsive">

                    <table class="table table-striped table-sm  table-bordered">
                        <thead>

                            <tr class="headings">
                                <th colspan="2" style="background-color:lightseagreen;color:white"><center>

    <?php
    if ($stu->tahapPendidikan) {
        echo strtoupper($stu->tahapPendidikan);
    }
    ?></center></th>
                        </tr>

                        <tr> 

                            <th style="width:10%" align="right">UNIVERSITI/INSTITUSI</th>
                            <td style="width:20%">
                            <?php echo strtoupper($stu->InstNm); ?></td></tr>






                        <th style="width:10%" align="right">BIDANG</th>
                        <td style="width:20%"><?php
                        if (($model->study2->MajorCd == NULL) && ($model->study2->MajorMinor != NULL)) {
                            echo strtoupper($model->study2->MajorMinor);
                        } elseif (($model->study2->MajorCd != NULL) && ($model->study2->MajorMinor != NULL)) {
                            echo strtoupper($model->study2->MajorMinor);
                        } else {
                            echo strtoupper($model->study2->major->MajorMinor);
                        }
                        ?></td>


                        <tr> 

                            <th style="width:10%" align="right">MOD PENGAJIAN</th>
                            <td style="width:20%">

                            <?php
                            if ($stu->modeID) {
                                echo strtoupper($stu->mod->studyMode);
                            } else {
                                echo "<i>Tiada Maklumat</i>";
                            }
                            ?></td></tr>

                        <tr> 

                            <th style="width:10%" align="right">TAJUK PENYELIDIKAN</th>
                            <td style="width:20%">
    <?php echo strtoupper($stu->tajuk_tesis); ?></td></tr>
                        <tr> 

                            <th style="width:10%" align="right">NAMA PENYELIA</th>
                            <td style="width:20%">
                                <?php echo strtoupper($stu->nama_penyelia); ?></td></tr>
                        <tr> 

                            <th style="width:10%" align="right">EMEL PENYELIA</th>
                            <td style="width:20%">
                                <?php echo $stu->emel_penyelia; ?></td></tr>




                        <tr> 

                            <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                            <td style="width:40%">
    <?= strtoupper($stu->tarikhmula) ?> <b>HINGGA</b> 
                                <?= strtoupper($stu->tarikhtamat) ?> (<?= strtoupper($stu->tempohpengajian); ?>)</td>
                        </tr>
                        <tr>
                            <th style="width:10%" align="right">BIASISWA:</th>
                            <td><?= ucwords(strtoupper($stu->tajaan->nama_tajaan)); ?></td> 
                        </tr>
                            <?php } else {
                                ?>
                        <tr>
                            <td colspan="8" class="text-center"><b>Tiada Rekod Maklumat Pengajian yang dipohon</b></td>                     
                        </tr>
    <?php }
?> 






                    </thead>




                </table>

            </div> 

        </div></div>
</div>
<?php
if (($model->study2->HighestEduLevelCd == 1) || ($model->study2->HighestEduLevelCd == 20) || ($model->study2->HighestEduLevelCd == 11) || ($model->study2->HighestEduLevelCd == 101) || ($model->study2->HighestEduLevelCd == 102) ||
        ($model->study2->HighestEduLevelCd == 202) || ($model->study2->HighestEduLevelCd == 8) || ($model->study2->HighestEduLevelCd == 210)) {
    ?>
    <div class="x_panel">   <div class="x_content">
    <?php if ($model->agree == NULL) { ?>   <p align="right">
        <?= Html::a('Kemaskini', ['kemaskini-lapordiriselesai?i=' . $model->laporID], ['class' => 'btn btn-primary btn-sm', 'target' => '_blank']) ?></p><?php } ?>
            <div class="x_title">
                <h5><strong><i class="fa fa-exclamation-circle"></i> STATUS PENGAJIAN</strong></h5>


                <div class="clearfix"></div>
            </div>
            <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                    <table class="table table-bordered jambo_table" >
                        <tr>


                        <tr>
                            <th scope="col" colspan=12" style="text-align:left">
                       STATUS PENGAJIAN TERKINI</th>
                        <td colspan='12' style="vertical-align: middle" class="text-justify"><?php
    if ($model->status_pengajian == 1) {
        echo '<b><center>' . $model->study->status_pengajian . '</b></center>';
        ?>  


                            </td>

                            </tr>
                            <tr>
                                <th scope="col" colspan=12" style="text-align:left">

                                    SALINAN SIJIL IJAZAH/SURAT PENGESAHAN SENAT</th>
        <?php if ($model->upload->dokumen) { ?>
                                    <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                                href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen), true); ?>" target="_blank" >
                                            <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
                                <?php
                                } else {
                                    echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>' . '<br>';
                                }
                                ?></td>
                            </tr>
                            <tr>
                                <th scope="col" colspan=12" style="text-align:left">

                                    BORANG TUNTUTAN PELBAGAI - KOS KUARANTIN (LUAR NEARA SAHAJA)</th>
        <?php if ($model->upload->dokumen5) { ?>
                                    <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                                href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen5), true); ?>" target="_blank" >
                                            <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
        <?php
        } else {
            echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>' . '<br>';
        }
        ?></td>
                            </tr>



        <?php
    } else {
        echo $model->study->status_pengajian;
    }
    ?>

                      







                    </table>

            </div> </div></div><?php } ?>

                    <?php if ($model->study2->HighestEduLevelCd == 200) {
                        ?>
    <div class="x_panel">
                        <?php if ($model->agree == NULL) { ?>   <p align="right">
                            <?= Html::a('KEMASKINI BORANG', ['kemaskini-lapordiriselesai?i=' . $model->laporID], ['class' => 'btn btn-primary btn-sm']) ?></p><?php } ?>
        <div class="x_title">
            <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
            </h5>


            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TELAH SELESAI</center></th>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS PENGAJIAN:<br>
                        </th>


                        <td class="text-center"><?= $model->study->status_pengajian; ?></td>      





                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN SEPANJANG TEMPOH PENGAJIAN BAGI:<br>
                            <small>Pos Doktoral</small>
                        </th>







    <?php if ($model->upload->dokumen5) { ?>
                            <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen5), true); ?>" target="_blank" >
                                    <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
    <?php
    } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>' . '<br>';
    }
    ?></td>                      


                    </tr>








                </table>
            </div>  </div>  </div>

                        <?php } ?>
                        <?php
                            if (($model->study2->HighestEduLevelCd == 1) || ($model->study2->HighestEduLevelCd == 20) || ($model->study2->HighestEduLevelCd == 11) || ($model->study2->HighestEduLevelCd == 101) || ($model->study2->HighestEduLevelCd == 102) ||
                                    ($model->study2->HighestEduLevelCd == 202)) {
                                ?> 
    <div class="x_panel"> <div class="x_content">
            <div class="x_title">
                <h5><strong><i class="fa fa-money"></i> TUNTUTAN LAPOR DIRI PENGAJIAN</strong></h5>


                <div class="clearfix"></div>
            </div>
            <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                    <table class="table table-bordered jambo_table" >
                        <tr class="headings">
                            <th   style="background-color:lightseagreen;color:white">
                                JENIS TUNTUTAN
                            </th>
                            <th width="10px" style="background-color:lightseagreen;color:white"><center>
                            SEMAKAN
                            </th>
                            </tr>

                            <tr> 
    <?php if ($stu->tajaan->jenisCd == 3) {
        ?>
                                    <th style="width:10%" align="right">ELAUN AKHIR PENGAJIAN -KPT</th>
                                    <td style="width:20%">
        <?php if ($akhir) {
            ?>
                                            <p>&#9989; <?= $akhir->tarikh_m ?></p>

        <?php } else {
            ?>
                                            <p> &#10060;</p>
        <?php }
        ?></td></tr>
                                <tr> 

                                    <th style="width:10%" align="right">ELAUN TESIS -KPT</th>
                                    <td style="width:20%">
                                    <?php if ($tesis) {
                                        ?>
                                            <p>&#9989; <?= $tesis->tarikh_m ?></p>

                                        <?php } else {
                                            ?>
                                            <p> &#10060;</p>
                                        <?php }
                                        ?>     </td></tr><?php } ?>
                            <tr> 
                                    <?php
                                    if ($model->kakitangan->jawatan->gred == "DS45") {
                                        ?>                        <th style="width:10%" align="right">HADIAH PERGERAKAN GAJI (HPG)</th>
                                    <td style="width:20%">
        <?php if ($hpg) {
            ?>
                                            <p>&#9989; <?= $hpg->tarikh_m ?></p>

                                        <?php } else {
                                            ?>
                                            <p> &#10060;</p>
                                        <?php }
                                        ?> </td><?php } ?></tr>


                    </table>

            </div> </div></div><?php } ?>



                                <?php if ($model->study2->HighestEduLevelCd == 99) {
                                    ?>
    <div class="x_panel">
                                    <?php if ($model->agree == NULL) { ?>   <p align="right">
                                        <?= Html::a('KEMASKINI BORANG', ['kemaskini-lapordiriselesai?i=' . $model->laporID], ['class' => 'btn btn-primary btn-sm', 'target' => '_blank']) ?></p><?php } ?>
        <div class="x_title">
            <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
            </h5>


            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TELAH SELESAI</center></th>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS PENGAJIAN:<br>
                        </th>


                        <td class="text-center"><?= $model->study->status_pengajian; ?></td>      





                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN SEPANJANG TEMPOH PENGAJIAN BAGI:<br>
                            <small>Sabatikal</small>
                        </th>







    <?php if ($model->upload->dokumen5) { ?>
                            <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen5), true); ?>" target="_blank" >
                                    <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
    <?php
    } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>' . '<br>';
    }
    ?></td>                      


                    </tr>








                </table>
            </div>  </div>  </div>

                        <?php } ?>


<?php if ($model->study2->HighestEduLevelCd == 207 || $model->study2->HighestEduLevelCd == 211) {
    ?>
    <div class="x_panel">
         <?php if($model->agree == NULL){?>   <p align="right">
     <?= Html::a('KEMASKINI BORANG', ['kemaskini-lapordiriselesai?i='.$model->laporID], ['class' => 'btn btn-primary btn-sm','target'=>'_blank']) ?></p><?php }?>
        <div class="x_title">
            <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
            </h5>


            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TELAH SELESAI</center></th>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS PENGAJIAN:<br>
                        </th>


                        <td class="text-center"><?= $model->study->status_pengajian; ?></td>      





                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN SEPANJANG TEMPOH PENGAJIAN BAGI:<br>
                            <small><?php $model->study2->tahapPendidikan?> </small>
                        </th>







    <?php if ($model->upload->dokumen5) { ?>
                            <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen5), true); ?>" target="_blank" >
                                    <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
    <?php
    } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>' . '<br>';
    }
    ?></td>                      


                    </tr>








                </table>
            </div>  </div>  </div>

                            <?php } ?>

<?php if ($model->study2->HighestEduLevelCd == 999) {
    ?>
    <div class="x_panel">
        
        <div class="x_title">
            <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
            </h5>


            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>TELAH SELESAI</center></th>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS PENGAJIAN:<br>
                        </th>







                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN SEPANJANG TEMPOH PENGAJIAN BAGI:<br>
                            <small>Latihan Industri</small>
                        </th>







    <?php if ($model->upload->dokumen5) { ?>
                            <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen5), true); ?>" target="_blank" >
                                    <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
    <?php
    } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>' . '<br>';
    }
    ?></td>                      


                    </tr>








                </table>
            </div>  </div>  </div>

<?php } ?><div class="x_panel" style="display: <?php echo $view; ?>">   <div class="x_content" >
        <div class="x_title">
            <h5 ><strong><i class="fa fa-check-square"></i> PERAKUAN </strong></h5>


            <div class="clearfix"></div>
        </div> 
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">
                    <th scope="col" colspan=12">
                    <center>PERAKUAN PEMOHON</center></th></thead>

                    <tr class="headings">



<?php // $model->agree = 0;  ?> 


                        <td class="col-sm-2 text-center">
                            <div >
<?php $model->agree = 1; ?>
                                <br><?= $form->field($model, 'agree')->checkbox(['disabled' => true])->label(false); ?> <p>&nbsp;&nbsp;</p>                            <p class="text-justify"><h5 style="color:black;" ><br> 
                                    &nbsp;Saya mengaku maklumat yang dikemukakan adalah benar dan sekiranya saya tidak melengkapkan
                                    dokumen lapor diri seperti yang dinyatakan dalam senarai semak urusan yang berkaitan dengan
                                    perkhidmatan dan saraan saya tidak akan diproses.</p>

                                </h5> 
                                <center><p style="color:black;">Tarikh Mohon: <?php echo $model->tarikh_mohon; ?></p></center><br/>

                            </div>
                        </td>


                </table>
        </div> </div></div>
<div class="x_panel" style="display: <?php echo $edit; ?>">   <div class="x_content" >
        <div class="x_title">
            <h5 ><strong><i class="fa fa-check-square"></i> PERAKUAN </strong></h5>


            <div class="clearfix"></div>
        </div> 
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">
                    <th scope="col" colspan=12">
                    <center>PERAKUAN PEMOHON</center></th></thead>

                    <tr class="headings">



<?php // $model->agree = 0;  ?> 


                        <td class="col-sm-2 text-center">
                            <div >
<?php $model->agree = 1; ?>
                                <br><?= $form->field($model, 'agree')->checkbox(['disabled' => false])->label(false); ?> <p>&nbsp;&nbsp;</p>                            <p class="text-justify"><h5 style="color:black;" ><br> 
                                    &nbsp;Saya mengaku maklumat yang dikemukakan adalah benar dan sekiranya saya tidak melengkapkan
                                    dokumen lapor diri seperti yang dinyatakan dalam senarai semak urusan yang berkaitan dengan
                                    perkhidmatan dan saraan saya tidak akan diproses.</p>

                                </h5> 
                                <center><p style="color:black;">Tarikh Mohon: <?php echo $model->tarikh_mohon; ?></p></center><br/>

                            </div>
                        </td>


                </table>
                <div class="customer-form">  
                    <div class="form-group" align="center">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2"> 
                            <br>
<?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2']) ?>
                            <button class="btn btn-primary" type="reset">Reset</button>
                        </div>
                    </div>
                </div>
        </div> </div>

</div>



<?php ActiveForm::end(); ?>
 


