<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\hronline\Campus;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;
use kartik\popover\PopoverX;
?>

<style>

    .html-marquee {
        height: auto;
        /*background-color:#ffff33;*/
        /*font-family:Cursive;*/
        font-size:14px;
        color:red;
        /*border-width:4;*/
        /*border-style:dotted;*/
        /*border-color:#ff0000;*/
    }
</style>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Permohonan Pengesahan Dalam Perkhidmatan</h2>&nbsp;
                <?php
                echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i> Lihat CV', [ 'cv/view-cv',  'id' => sha1($biodata->ICNO),
                    'title' => 'personal',], [
                    'class' => 'btn btn-primary btn-sm',
                    'target' => '_blank',
                ]);
                ?>    
        <div class="clearfix"></div>
        </div>
        
<div class="x_panel">
    <div class="col-md-3 col-sm-12 col-xs-12 profile_left"> 
        <div class="profile_img">
            <div id="crop-avatar"> <br/><br/>
                <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(SHA1($biodata->ICNO)); ?>.jpeg" width="150" height="180"></center>
            </div>
        </div> 
        <br/> 
    </div>
    <div class="col-md-9 col-sm-12 col-xs-12">
 
            <br/>
            <div class="table-responsive">
            <table class="table" style="width:100%">
                <thead>
                    <tr>
                        <th colspan="4" class="text-center">
                <h2><?= strtoupper($biodata->CONm); ?></h2>
                </th>
                </tr>  
                <tr>
                    <th colspan="4" class="text-center"> 
                        <?php if ($biodata->jawatan->job_category == 1) { ?>
                            GELARAN : <?= strtoupper($biodata->gelaran->Title); ?>
                            <br/>
                            PROGRAM AKADEMIK : <?= $biodata->programPengajaran ? $biodata->programPengajaran->NamaProgram : '-'; ?>
                            <br/>
                        <?php } ?>
                        <i class="fa fa-phone-square user-profile-icon"></i> <?= $biodata->COHPhoneNo; ?> |
                        <i class="fa fa-envelope user-profile-icon"></i> <?= $biodata->COEmail; ?>
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
                        <th style="width:20%">Alamat</th>
                        <td style="width:20%"><?= $biodata->alamatTetap ? $biodata->alamat->alamatPenuh : '-'; ?></td>
                        <th>Negeri</th>
                        <td><?php
                            if ($biodata->COBirthPlaceCd) {
                                echo $biodata->tempatLahir->State;
                            }
                            ?></td> 
                    </tr>
                    <tr> 

                        <th style="width:20%">Tarikh Lahir</th>
                        <td style="width:20%"><?= $biodata->displayBirthDt; ?></td>
                        <th style="width:20%">Jantina</th>
                        <td style="width:20%"><?= $biodata->jantina->Gender; ?></td>

                    </tr>
                </tbody>
            </table> 
            </div> 
        <br/>

    </div>
</div>
<br/>
<?php
$penerbitan = app\models\pengesahan\RequirementUmum1::penerbitan();
$persidangan = app\models\pengesahan\RequirementUmum1::persidangan();
$umum = app\models\pengesahan\RequirementUmum1::umum();
?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
         <div class="x_title">
            <h2><strong>Syarat Pengesahan Dalam Perkhidmatan (Kakitangan Bukan Akademik)</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">                 
        <li> Memenuhi tempoh percubaan sekurang-kurangnya satu (1) sehingga tiga (3) tahun.</li>
 
        <li> Lulus peperiksaan Am Kerajaan atau lulus Program Transformasi Minda/Kursus Induksi yang ditetapkan.</li>
    
        <li> Diperakukan oleh Ketua Jabatan.</li>
    
        <li> Mempunyai kelulusan Bahasa Malaysia dengan Kepujian termasuk lulus Ujian Lisan di peringkat Sijil Pelajaran Malaysia atau yang setaraf dengannya.</li>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kecuali bagi Gred 11 Memiliki Kepujian (sekurang-kurangnya Gred C) dalam subjek Bahasa Melayu pada peringkat Pentaksiran Tingkatan Tiga/Penilaian Menengah &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rendah atau kelulusan yang diiktiraf setaraf dengannya oleh Kerajaan. </li>
        
        <li> Lulus Peperiksaan Jabatan (jika ada).</li>

        <li> Markah Prestasi sekurang-kurangnya 80% dan ke atas sepanjang tempoh percubaan.</li>
            
            <br>
<span class="required" style="color:red;">*</span> Syarat ini berkuatkuasa kepada kakitangan lantikan TETAP sahaja.<br >  
            </div>
        </div> 
    </div>
</div>

<div class="x_panel"> 
    <div class="clearfix"></div> 
    <div class="x_content">    

        <div class="x_panel">  
            <div class="x_title">
                <h2>KRITERIA UMUM</h2>  
                <div class="clearfix"></div>
            </div> 

            <div class="table-responsive">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <center> 
                        <table class="table table-sm table-bordered jambo_table table-striped" style="width:80%"> 
                            <tr>   
                                <th>TEMPOH PERKHIDMATAN</th>  
                                <td colspan="2"><?= $biodata->servPeriodPermanent; ?></td> 
                            </tr>
                            <tr>   
                                <th>STATUS PTM</th>  
                                <td colspan="2">
                                    <?php 
                                    $status_ptm = '';
                                        if ($biodata->ptm){
                                            echo $biodata->ptm->status;
                                        } else {
                                        echo '-';
                                    }
                                    ?></td> 
                            </tr>
                            <tr>   
                                <th style="width:40%">STATUS BM</th>  
                                <td colspan="2">
                                    <?php if ($biodata->jawatan->gred_no != "11"){
                                    $status_spm = '';
                                        if ($subjekspm->gred){
                                            echo $subjekspm->gred;
                                             $status_spm = "YA";
                                        } else  if ($subjekspm2->gred){
                                            echo $subjekspm2->gred;
                                             $status_spm = "YA";
                                        } else {
                                            echo '-';
                                    }
                                    }
                                    
                                    else if ($biodata->jawatan->gred_no == "11"){
                                        $status_pmr = '';
                                        if ($subjekpmr->gred){
                                            echo $subjekpmr->gred;
                                             $status_pmr = "YA";
                                        } else {
                                        echo '-';
                                    }  
                                    }
                                    ?>
                                </td> 
                            </tr> 
                            <tr>   
                                <th rowspan="50">LNPT <br/>
                                </th> 
                                            
                            <?php 
                                for ($t=$tahunstarttetap; $t < date('Y') ; $t++){

                                $markah = \app\models\lppums\Lpp::find()->where(['PYD' => $biodata->ICNO, 'tahun' => $t])->one(); // yang telah disahkan sahaja

                                $record = \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markah->lpp_id])->one();                                    
                                if ($record) {
                                    $allrecord0 = $allrecord0 + $record->markah_PP;

                                        if ($record->markah_PP != '0' || $record->markah_PP != '') {
                                            ?>
                                            <tr>
                                                <td><?= '<b>' . $t . ' :</b> ' . $record->markah_PP; ?></td></tr>
                                            <?php
                                        }
                                    }
                                }
                            
                            ?>            
                            <tr>
                                <td colspan="2">   
                                    Purata Markah:
                                <?php
                                    $yearOld = $tahunstarttetap;
                                    $yearNow = date('Y');
                                    $year = $yearNow - $yearOld;
                                    $allrecord = number_format($allrecord0 / $year, 2, '.', '');
                                    echo $allrecord;
                                ?>
                                </td> 
                            </tr> 

                        </table>
                    </center>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <center>
                        <table class="table table-sm table-bordered jambo_table table-striped" style="width:80%"> 
                            <tr>   
                                <th colspan="5" class="text-center" style="background-color:#20c997; color:white;">KRITERIA</th>   
                            </tr>
                            <?php
                            $totalUmum = 0;
                            foreach ($umum as $p) {
                                ?>
                                <tr>      
                                    <th colspan="3"><?= $p->requirement; ?></th>  
                                    <th><?php
                                    if ($p->info) {
                                        echo PopoverX::widget([
                                            'header' => '<span style="color:black;">Maklumat</span>',
                                            'type' => PopoverX::TYPE_SUCCESS,
                                            'placement' => PopoverX::ALIGN_BOTTOM,
                                            'content' => $p->info,
                                            'toggleButton' => ['label' => '<i class="fa fa-info-circle" aria-hidden="true"></i></button>', 'class' => 'btn btn-success'],
                                        ]);
                                    }
                                    ?></th> 
                                    <?php
                                    if ($p->id == 1) {
                                        if ($biodata->servPeriodPermanent >= $p->ans_no) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
                                    else if ($p->id == 2) {
                                        if (($biodata->ptm->status == $p->ans_char) || ($biodata->ptm->status == $p->ans_char2)){
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
//                                    else if ($p->id == 3) {
//                                        if ($biodata->jawatan->gred_no != "11"){
//                                        if (($status_spm == $p->ans_char) && ($biodata->sijilspm->filename != NULL)) {
//                                            $s = 1;
//                                            $totalUmum++;
//                                        } else {
//                                            $s = 0;
//                                        }
//                                    }
//                                    
//                                    else if ($biodata->jawatan->gred_no == "11"){
//                                        if (($status_pmr == $p->ans_char2) && ($biodata->sijilpmr->filename != NULL)) {
//                                            $s = 1;
//                                            $totalUmum++;
//                                        } else {
//                                            $s = 0;
//                                        }
//                                    }
//                                    }
                                    
                                    else if ($p->id == 3) {
                                        if ($biodata->jawatan->gred_no != "11"){
                                        if (($subjekspm->Grade_id <= '14') && ($subjekspm->Grade_id != NULL) && ($biodata->sijilspm->filename != NULL)) {
                                            $s = 1;
                                            $totalUmum++;
                                        } 
                                        else if (($subjekspm2->Grade_id <= '14') && ($subjekspm2->Grade_id != NULL) && ($biodata->sijilspm->filename != NULL)) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
                                    
                                    else if ($biodata->jawatan->gred_no == "11"){
                                        if (($subjekpmr->Grade_id <= '14') && ($subjekpmr->Grade_id != NULL) && ($biodata->sijilpmr->filename != NULL)) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
                                    }
                                    
//                                    else if ($p->id == 4) {
//                                    for ($t=$tahunstarttetap; $t < date('Y') ; $t++){
//                                    $markah = \app\models\lppums\Lpp::find()->where(['PYD' => $biodata->ICNO, 'tahun' => $t])->one(); // yang telah disahkan sahaja
//
//                                    $record = \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markah->lpp_id])->one();
//                                    if ($record) {
//                                    if ($record->markah_PP >= $p->ans_no) {
////                                                $s = 1;
//                                                $totalUmum++;
//                                            } else {
//                                                $s = 0;
//                                            }
//                                       }
//                                    }
//                                    }
                                    
                                    else if ($p->id == 4) {
                                        for ($t = $tahunstarttetap; $t < date('Y'); $t++) {
                                            
                                            $markah = \app\models\lppums\Lpp::find()->where(['PYD' => $biodata->ICNO, 'tahun' => $t])->one(); // yang telah disahkan sahaja

                                            $record = \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markah->lpp_id])->one();
                                            if ($record) {
                                                if (($record->markah_PP >= $p->ans_no) || ($allrecord >= $p->ans_no)) {
                                                    $allKri++;
                                                } 
                                            }
                                        }
                                        
                                        if($allKri==$year){
                                            $totalUmum++;
                                            $s = 1;
                                        }else{
                                            $s = 0;
                                        }
                                    }
                                    
                                    if ($s == 1) {
                                        $color = "#20c997";
                                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                    } else if ($s == 0 ){
                                        $color = "red";
                                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                    } 

//                                    if ($s != 1) {
//                                        $color = "#20c997";
//                                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
//                                    } else {
//                                        $color = "red";
//                                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
//                                    }

                                    ?>
                                    <td colspan="2" style="background-color:<?= $color; ?>" class="text-center">  
                                        <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                      
                         
                        </table>
                    </center>
                </div>
            </div> 
        </div>   

    </div> 
</div>  

    <?php
        if ($totalUmum == 4) {
            $umum = 1; //pass all kriteria umum
        } else {
            $umum = 0;
        }
        ?>

    <?php
        if ($umum == 1) {
            $checking = 1;
        } else {
            $checking = 0;
        }
        ?>

    </div>
</div>
    
    <!--        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ketua Jabatan :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="tblprcobiodata-enddatelantik" class="form-control" name="Tblprcobiodata[endDateLantik]" value="<?= $model->ketuajfpiu?>" disabled="disabled">
            </div>
        </div>-->
    
<!--    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-user"></i> Ketua Jabatan</strong></h2>
                <div class="clearfix"></div>
            </div>
        
        <div class="x_content">
            <div class="table-responsive">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ketua Jabatan :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" 
                    value="
                        <php if (\app\models\cuti\SetPegawai::find()->where(['pemohon_icno' => $icno])){
                            echo $biodata->rujukan->pelulus->CONm; 
                        }
                        else if ($pegawai2->pelulus_icno == NULL){
                            
                            echo '-';
                        }
                        ?>" disabled="disabled">
                </div>
                </div>
            </div>
        </div>        
        </div>
    </div>-->
    
</div>

