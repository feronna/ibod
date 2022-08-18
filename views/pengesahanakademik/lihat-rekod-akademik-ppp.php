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
$penerbitan = app\models\pengesahan\RequirementUmum2::penerbitan();
$persidangan = app\models\pengesahan\RequirementUmum2::persidangan();
$umum = app\models\pengesahan\RequirementUmum3::umum();
?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
         <div class="x_title">
            <h2><strong>Syarat Pengesahan Dalam Perkhidmatan Universiti Malaysia Sabah (Kakitangan Akademik)</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
    <h2><strong> PENSYARAH PERUBATAN PELATIH (DU51P)</strong></h2> 
    1. Memenuhi tempoh percubaan sekurang-kurangnya satu (1) sehingga tiga (3) tahun;<br>
 
    2. Diperakukan oleh Ketua Jabatan;<br>
    
    3. Telah berkhidmat di Kementerian Kesihatan Malaysia dan telah disahkan jawatan dalam  perkhidmatan berkenaan;<br>
    
    4. Mempunyai kelulusan Bahasa Malaysia dengan kepujian termasuk Ujian Lisan di peringkat Sijil Pelajaran Malaysia atau yang setaraf dengannya;<br>

    5. Memiliki kelayakan kepakaran atau ijazah sarjana dalam bidang berkenaan yang disyaratkan;<br>
  
    6. Telah berkhidmat sekurang-kurangnya tiga (3) tahun sebagai Pensyarah Perubatan Pelatih;<br>
    
    7. Hadir dengan jayanya Program Transformasi Minda (PTM) / kursus induksi atau kursus kursus lain yang ditetapkan;<br>

    8. Markah Prestasi sekurang-kurangnya 80 % dan ke atas sepanjang tempoh percubaan.<br>

    <u>Syarat Tambahan:</u><br>
 
    9. Telah mengikuti kursus pengajaran dan pembelajaran dengan jayanya (bagi pensyarah yang tidak mempunyai latihan khas dalam bidang pengajaran).<br>

    <br>
<span class="required" style="color:red;">*</span> Syarat pengesahan dalam perkhidmatan bagi Pensyarah Perubatan Pelatih hanya boleh dibuat selepas pensyarah pelatih tamat daripada menjalani cuti belajar iaitu selepas empat (4) tahun.<br>

<span class="required" style="color:red;">*</span> Syarat ini berkuatkuasa kepada kakitangan lantikan TETAP sahaja.<br
            </div>
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
                                <th>STATUS PENGAJIAN</th>  
                                <td colspan="2"><?php
                         
                          if($biodata->cpengajian->lapor->study->status_pengajian)
                          {
                            echo $biodata->cpengajian->lapor->study->status_pengajian;
                          }
                          else
                          {
                             echo $biodata->cpengajian->lapor->status_pengajian;
                          }

                           ?></td> 
                            </tr>
                            <tr>   
                                <th style="width:40%">STATUS SPM (BM)</th>  
                                <td colspan="2">
                                    <?php
                                    $status_bm = '';
                                    if ($subjek->gred) {
                                        echo $subjek->gred;
                                        $status_bm = "YA";
                                    } else  if ($subjek2->gred){
                                        echo $subjek2->gred;
                                        $status_bm = "YA";
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td> 
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
                                <th>STATUS P&P</th>  
                                <td colspan="2">
                                    <?php 
                                    $status_pnp = '';
                                        if ($biodata->pnp){
                                            echo $biodata->pnp->status;
                                            $status_pnp = "YA";
                                        } else {
                                        echo '-';
                                    }
                                    ?></td> 
                            </tr>
                            <tr>   
                                 <th rowspan="50">LNPT <br/>
                                </th>  
                            <?php
                            $a =0; $jumlahKeseluruhan1 = 0;
                            for ($t=$tahunstarttetap; $t < date('Y') ; $t++){
                                
                                $markahOld = \app\models\elnpt\elnpt_lama\TblUser::find()->where(['user_id' => $biodata->ICNO])->one();

                                $recordOld = \app\models\elnpt\elnpt_lama\TblMarkahLama::find()->where(['staff_id' => $markahOld->staff_id, 'tahun' => $t])->orderBy(['id' => SORT_DESC])->one();
                                    if ($recordOld) {
                                        if ($recordOld->purata != '0' || $recordOld->purata != '') {
                                            ?>
                                            <tr>
                                                <td><?= '<b>' . $t . ' :</b> ' . number_format($recordOld->purata, 2, '.', ''); ?></td></tr>
                                            <?php
                                            
                                            $jumlahKeseluruhan1 = $jumlahKeseluruhan1 + $recordOld->purata;
                                            $a++;
                                        }
                                    }
                                }
                            
                            ?> 
                            
                            <?php
                            $j =0; $jumlahKeseluruhan2 = 0;
                            for ($t=$tahunstarttetap; $t < date('Y') ; $t++){

                                //markah tahun 2020 dan ke atas
                                $markah = \app\models\elnpt\TblMain::find()->where(['PYD' => $biodata->ICNO, 'PPP_sah' => 1, 'PPK_sah' => 1, 'PEER_sah' => 1, 'tahun' => $t])->orderBy(['tahun' => SORT_DESC])->one(); // yang telah disahkan sahaja
        
                                $record = \app\models\elnpt\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markah->lpp_id])->one();
                                    if ($record) {
                                        if ($record->markah != '0' || $record->markah != '') {
                                            ?>
                                            <tr>
                                                <td><?= '<b>' . $t . ' :</b> ' . $record->markah; ?></td></tr>
                                            <?php
                                            
                                            $jumlahKeseluruhan2 = $jumlahKeseluruhan2 + $record->markah;
                                            $j++;
                                        }
                                    }
                                }
                            
                            ?> 
                                                
                            <?php
                            $k =0; $jumlahKeseluruhan3 = 0;

                            for ($t=$tahunstarttetap; $t < date('Y') ; $t++){

                                //akademik yg isi borang pentadbiran
                                $markahPen = \app\models\lppums\Lpp::find()->where(['PYD' => $biodata->ICNO, 'tahun' => $t])->orderBy(['tahun' => SORT_DESC])->one();
                                
                                $recordPen = \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markahPen->lpp_id])->one();
                                    if ($recordPen) {
                                        if ($recordPen->markah_PP != '0' || $recordPen->markah_PP != '') {
                                            ?>
                                            <tr>
                                                <td><?= '<b>' . $t . ' :</b> ' . $recordPen->markah_PP; ?></td></tr>
                                            <?php
                                            
                                            $jumlahKeseluruhan3 = $jumlahKeseluruhan3 + $recordPen->markah_PP;
                                            $k++;
                                        }
                                    }
                                }
                            
                            ?>                            
                            <tr>
                                <td colspan="2">   
                                    Purata Markah:
                                <?php
                                    $jumlahTahun = $a + $j + $k;
                                    $purata = number_format(($jumlahKeseluruhan1 +$jumlahKeseluruhan2 + $jumlahKeseluruhan3) / $jumlahTahun , 2, '.', '');
                                    
                                    echo $purata;
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
                                        if (($status_bm == $p->ans_char) && ($biodata->sijilspm->filename != NULL)) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
                                    
                                    else  if ($p->id == 3) {
                                        if ($biodata->servPeriodPermanent >= $p->ans_no) {
                                        //if (($biodata->cpengajian->lapor->study->status_pengajian == $p->ans_char) || ($biodata->cpengajian->lapor->status_pengajian == $p->ans_char2)) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
                                    
//                                    else  if ($p->id == 3) {
//                                        if ($biodata->cpengajian->tempohtajaan >= $p->ans_no) {
//                                            $s = 1;
//                                            $totalUmum++;
//                                        } else {
//                                            $s = 0;
//                                        }
//                                    }
                                    
                                    else if ($p->id == 4) {
                                        if (($biodata->ptm->status == $p->ans_char) || ($biodata->ptm->status == $p->ans_char2)){
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
                                   
//                                    else if ($p->id == 5) {
////                                        if (($record->markah >= $p->ans_no) || ($recordPen->markah_PP >= $p->ans_no) || ($recordOld->markah >= $p->ans_no)) {
//                                        if ($allrecord >= $p->ans_no) {
//                                            $s = 1;
//                                            $totalUmum++;
//                                        } else {
//                                            $s = 0;
//                                        }
//                                    }
                                    
                                    else if ($p->id == 5) {
                                        $failed = 0;
                                        $a =0; $jumlahKeseluruhan1 = 0;
                                        for ($t = $tahunstarttetap; $t < date('Y'); $t++) {

                                            $markahOld = \app\models\elnpt\elnpt_lama\TblUser::find()->where(['user_id' => $biodata->ICNO])->one();

                                            $recordOld = \app\models\elnpt\elnpt_lama\TblMarkahLama::find()->where(['staff_id' => $markahOld->staff_id, 'tahun' => $t])->one();
                                            if ($recordOld) {
                                                if ($recordOld->purata != '0' || $recordOld->purata != '') {
                                                if ($recordOld->purata < $p->ans_no) {
                                                    $failed++;
                                                }
                                                }
                                                
                                                $jumlahKeseluruhan1 = $jumlahKeseluruhan1 + $recordOld->purata;
                                                $a++;
                                            }
                                        }
                                        
                                        $j =0; $jumlahKeseluruhan2 = 0;
                                        for ($t = $tahunstarttetap; $t < date('Y'); $t++) {

                                            $markah = \app\models\elnpt\TblMain::find()->where(['PYD' => $biodata->ICNO, 'PPP_sah' => 1, 'PPK_sah' => 1, 'PEER_sah' => 1, 'tahun' => $t])->one(); // yang telah disahkan sahaja

                                            $record = \app\models\elnpt\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markah->lpp_id])->one();

                                            if ($record) {
                                                if ($record->markah != '0' || $record->markah != '') {
                                                if ($record->markah < $p->ans_no) {
                                                    $failed++;
                                                }
                                                }
                                                
                                                $jumlahKeseluruhan2 = $jumlahKeseluruhan2 + $record->markah;
                                                $j++;
                                            }
                                        }
                                        
                                        $k =0; $jumlahKeseluruhan3 = 0;
                                        for ($t = $tahunstarttetap; $t < date('Y'); $t++) {

                                            $markahPen = \app\models\lppums\Lpp::find()->where(['PYD' => $biodata->ICNO, 'tahun' => $t])->one();

                                            $recordPen = \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markahPen->lpp_id])->one();
                                            if ($recordPen) {
                                                if ($recordPen->markah_PP != '0' || $recordPen->markah_PP != '') {
                                                if ($recordPen->markah_PP < $p->ans_no) {
                                                    $failed++;
                                                }
                                                }
                                                
                                                $jumlahKeseluruhan3 = $jumlahKeseluruhan3 + $recordPen->markah_PP;
                                                $k++;
                                            }
                                        }
                                        
                                        $jumlahTahun = $a + $j + $k;
                                        //if ($failed <= 0 && $jumlahTahun > 0) {
                                        if ($failed <= 0) {
                                            $totalUmum++;
                                            $s = 1;
                                        } else {
                                            $s = 0;
                                        }
                                        
                                        if(empty($jumlahTahun)){
                                            $s = 0;
                                        }
                                    }
                                    
                                    else if ($p->id == 6) {
                                        if ($status_pnp == $p->ans_char) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
                                    
//                                    else if ($p->id == 4) {
//                                    if ($markah) {
//                                    foreach ($markah as $markah) {
//                                    $record = \app\models\elnpt\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markah->lpp_id])->one();
//                                    if ($record) {
//                                        if (($record->markah >= $p->ans_no)) {
//                                            $s = 1;
//                                            $totalUmum++;
//                                        } else {
//                                            $s = 0;
//                                        }
//                                        } 
//                                    }
//                                    }
//                                    } 
//                                    
//                                    else if ($p->id == 4) {
//                                    if ($markahPen) {
//                                    foreach ($markahPen as $markahPen) {
//                                    $recordPen = \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markahPen->lpp_id])->one();
//                                    if ($recordPen) {
//                                        if (($recordPen->markah_PP >= $p->ans_no)) {
//                                            $s = 1;
//                                            $totalUmum++;
//                                        } else {
//                                            $s = 0;
//                                        }
//                                        } 
//                                    }
//                                    }
//                                    } 
//                                    
//                                    else if ($p->id == 4) {
//                                    if ($markahOld) {
//                                    foreach ($markahOld as $markahOld) {
//                                    $recordOld = \app\models\elnpt\elnpt_lama\TblMarkahLama::find()->where(['staff_id' => $markahOld->staff_id])->orderBy(['id' => SORT_DESC])->all();
//                                    if ($recordOld) {
//                                        if (($recordOld->markah >= $p->ans_no)) {
//                                            $s = 1;
//                                            $totalUmum++;
//                                        } else {
//                                            $s = 0;
//                                        }
//                                        } 
//                                    }
//                                    }
//                                    } 
                                    
                                    if ($s == 1) {
                                        $color = "#20c997";
                                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                    } else if ($s == 0) {
                                        $color = "red";
                                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                    } 
//                                    else {
//                                        $color = "#1E90FF";
//                                        $button = "HOLD";
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
        if ($totalUmum == 6) {
            $umum = 1; //pass all kriteria umum
        } else {
            $umum = 0;
        }
        ?>

<div class="x_panel">
    <div class="col-md-6 col-sm-6 col-xs-6"> 
        <table class="table table-sm table-bordered jambo_table table-striped">

            <tr>
                <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">PENERBITAN</th> 
            </tr>  
            <tr> 
                <th class="text-center" colspan="2">KRITERIA</th> 
                <th class="text-center">JUMLAH SEMASA</th> 
            </tr> 
            <tr>     
                <th rowspan="2">JURNAL BERINDEKS</th>
                <th>BIL KESELURUHAN</th> 
                <td class="text-center"><?=
                    count(array_filter($biodata->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                            }))
                    ?>
                </td>
            </tr>
            <tr>
                <th>SEBAGAI PENULIS UTAMA</th>
                <td class="text-center"><?=
                    count(array_filter($biodata->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                            }))
                    ?>
                </td>
            </tr>
            <tr>     
                <th rowspan="2">JURNAL TIDAK BERINDEKS</th>
                <th>BIL KESELURUHAN</th> 
                <td class="text-center"><?=
                    count(array_filter($biodata->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                            }))
                    ?>
                </td>
            </tr>
            <tr>
                <th>SEBAGAI PENULIS UTAMA</th>
                <td class="text-center"><?=
                    count(array_filter($biodata->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                            }))
                    ?>
                </td>
            </tr>
            <tr>
                <th colspan="4" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data SMPPI</th>
            </tr>
        </table>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-6">
        <table class="table table-sm table-bordered jambo_table table-striped">
            <tr>
                <th colspan="5" class="text-center" style="background-color:#20c997; color:white;">KRITERIA PENERBITAN</th>
            </tr>
            <?php
            $i = 1;
            $totalPenerbitan = 0;
            foreach ($penerbitan as $p) {
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
                    ?>
                    </th> 
                        <?php
                    if ($i == 1) {
                        $j = count(array_filter($biodata->publication, function ($var) {
                                    return ($var['Keterangan_PublicationTypeID'] == 'Article' && $var['KeteranganBI_WriterStatus'] == 'First Author' && $var['Keterangan_PublicationStatus'] == 'Published');
                                }));

                        if ($j >= $p->ans_no) {
                            $s = 1;
                            $totalPenerbitan++;
                        } else {
                            $s = 1;
                        }
                    }  
                                
//                      if (($j >= $p->ans_no) || ($j <= $p->ans_no))  {
//                            $s = 1;
//                            $totalPenerbitan++;
//                        } 
//                    }  

                    $i++;
                    if ($s == 1) {
                        $color = "#20c997";
                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                    } else if ($s == 0) {
                        $color = "red";
                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                    } 

                    ?>
                    <td style="background-color:<?= $color; ?>; width:5%;" class="text-center">  
                        <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>

    <?php
        if ($totalPenerbitan == 1) {
            $penerbitanS = 1;
        } else {
            $penerbitanS = 1;
        }
        ?>

<div class="x_panel"> 
    <div class="col-md-6 col-sm-6 col-xs-6">
        <table class="table table-sm table-bordered jambo_table table-striped">
            <tr> 
                <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">PERSIDANGAN</th>  
            </tr>  

            <tr>
                <th colspan="2">PERINGKAT</th> 
                <th>KEBANGSAAN</th> 
                <th>ANTARABANGSA</th> 
            </tr>

            <tr>

                <th colspan="2">
                    <?php echo 'PEMBENTANG'; ?> 

                </th> 
                <td class="text-center">

                   <?=
                    count(array_filter($biodata->persidangan2, function ($var){
                                return ($var['Peringkat'] == 'Kebangsaan' && $var['Peranan'] == 'Pembentang');
                            }))
                    ?> 
                </td> 
                <td class="text-center">

                   <?=
                    count(array_filter($biodata->persidangan2, function ($var){
                                return ($var['Peringkat'] == 'Antarabangsa' && $var['Peranan'] == 'Pembentang');
                            }))
                    ?> 
                </td> 

            </tr>
            <tr>
                <th colspan="4" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data SMPPI</th>
            </tr>
        </table>
    </div> 
    
     <div class="col-md-6 col-sm-6 col-xs-6">
        <table class="table table-sm table-bordered jambo_table table-striped">
            <tr>
                <th colspan="5" class="text-center" style="background-color:#20c997; color:white;">KRITERIA PERSIDANGAN</th>
            </tr>
            <?php
            $i = 1;
            $totalPersidangan = 0;
            foreach ($persidangan as $p) {
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
                    ?>
                    </th> 
                    
                        <?php
                    if ($i == 1) {
                        $j = count(array_filter($biodata->persidangan2, function ($var) {
                                     return ($var['Peringkat'] == 'Kebangsaan' && $var['Peranan'] == 'Pembentang');
                                }));

                        if ($j >= $p->ans_no) {
                            $s = 1;
                            $totalPersidangan++;
                        } else {
                            $s = 1;
                        }
                    }  
                                
//                      if (($j >= $p->ans_no) || ($j <= $p->ans_no)) {
//                            $s = 1;
//                            $totalPersidangan++;
//                        } 
//                    }

                    $i++;
                    if ($s == 1) {
                        $color = "#20c997";
                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                    } else if ($s == 0) {
                        $color = "red";
                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                    } 

                    ?>
                    <td style="background-color:<?= $color; ?>; width:5%;" class="text-center">  
                        <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>

 <?php
        if ($totalPersidangan == 1) {
            $persidanganS = 1;
        } else {
            $persidanganS = 1;
        }
        ?>

    <?php
        if ($umum == 1 && $penerbitanS == 1 && $persidanganS == 1) {
            $checking = 1;
        } else {
            $checking = 0;
        }
        ?>

</div>
</div>

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

