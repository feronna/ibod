<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
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

<?php
$penyelidikan = app\models\cv\RequirementUmum::penyelidikan($jawatan->id, $cluster);
$penerbitan = app\models\pengesahan\RequirementUmum::penerbitan();
//$penerbitan = app\models\cv\RequirementUmum::penerbitan($jawatan->id, $cluster);
$pengajaran = app\models\cv\RequirementUmum::pengajaran($jawatan->id, $cluster);
$penyeliaan = app\models\cv\RequirementUmum::penyeliaan($jawatan->id, $cluster);
$persidangan = app\models\pengesahan\RequirementUmum::persidangan();
$perundingan = app\models\cv\RequirementUmum::perundingan($jawatan->id, $cluster);
$service = app\models\cv\RequirementUmum::service($jawatan->id, $cluster);
$tempoh = app\models\cv\RequirementUmum::tempoh($jawatan->id);
$umum = app\models\pengesahan\RequirementUmum::umum();
$nameCluster = '';
if ($cluster == 1) {
    $nameCluster = 'Sains Dan Teknologi';
} elseif ($cluster == 2) {
    $nameCluster = 'Sains Sosial Dan Kemanusiaan';
}
?>

<?php echo $this->render('/pengesahan/_topmenu'); ?> 

<marquee class="html-marquee" direction="left" behavior="scroll" scrollamount="8">
    <p>
       <!-- 1. For more information, please contact BIBIANA BINTI ROBERT  (088-320000 Ext. 1154)<br> -->
               Untuk maklumat lanjut berkaitan pengesahan dalam perkhidmatan, sila berhubung dengan Puan BIBIANA BINTI ROBERT di talian 088-320000 Samb. 1154. <br> 
    </p>
</marquee>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<!--    <div class="x_panel" style="display: <?php echo $displaymohon;?>">-->
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Perhatian</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">     
        1. Sila pastikan anda telah mengisi bahagian pendidikan SPM/Setaraf dalam profile anda. Anda adalah <strong>WAJIB</strong> untuk muat naik salinan Sijil Pelajaran Malaysia dan kemaskini gred subjek SPM Bahasa Melayu anda sebelum membuat permohonan. Klik sini <?php echo Html::a('<i class="fa fa-edit"></i> ',['pendidikan/view'], ['class' => 'btn btn-success btn-sm','target'=>'_blank']); ?>untuk semak dan kemaskini.<br>
        2. Jika anda memilih <strong>Pemberian Taraf Berpencen</strong>, sila muat naik Borang Opsyen dan Borang Pemberian Taraf Berpencen yang anda telah anda isi dan lengkapkan beserta salinan Kad Pengenalan.<br>
        3. Jika anda memilih <strong>Skim Kumpulan Wang Simpanan Pekerja (KWSP)</strong>, sila muat naik Borang Opsyen yang anda telah anda isi dan lengkapkan beserta salinan Kad Pengenalan.

        </div>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<!--    <div class="x_panel" style="display: <?php echo $displaymohon;?>">-->
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
            
    1. Memenuhi tempoh percubaan (1 hingga 3 tahun perkhidmatan).<br>
 
    2. Lulus peperiksaan Am Kerajaan atau lulus Program Transformasi Minda (PTM)/Kursus Induksi yang ditetapkan.<br>

    3. Diperakukan oleh Ketua Jabatan.<br>

    4. Mempunyai kelulusan Bahasa Malaysia dengan Kepujian termasuk lulus Ujian Lisan di peringkat Sijil Pelajaran Malaysia atau yang setaraf dengannya.<br>
 
    5. Lulus Peperiksaan Jabatan (jika ada).<br>
 
    6. Markah Prestasi sekurang-kurangnya 80% dan ke atas sepanjang tempoh percubaan.<br>

    <u>Syarat Tambahan:</u><br>
 
    7. Telah menghasilkan sekurang-kurangnya satu [1] majalah/artikel yang telah diterbitkan di dalam jurnal berwasit sebagai <strong>penulis utama</strong>; dan<br> 
 
    8. Telah menghasilkan dan membentangkan sekurang-kurangnya satu [1] kertas kerja sebagai <strong>pembentang utama</strong> dalam seminar peringkat kebangsaan;<br> 

    9. Telah mengikuti kursus Pengajaran dan Pembelajaran dengan jayanya (bagi pensyarah yang tidak mempunyai latihan khas dalam bidang pengajaran)<br>
 
    10. Tutor dan Felo Siswazah yang telah memiliki Ijazah Sarjana dan dilantik ke gred DS45 serta dikehendaki menyambung pengajian ke peringkat Ijazah Doktor Falsafah (PhD):<br>
 
    10.1 Pengesahan jawatan hanya diberikan setelah penyandang mendapat Ijazah Doktor Falsafah (PhD) dengan jayanya.<br>

    10.2 Sekiranya penyandang tamat tempoh pengajian dan melapor diri namun belum tamat pengajian PhD, penyandang akan diberikan pelanjutan tempoh percubaan maksimum satu (1) tahun untuk menyelesaikan pengajian.<br>

    10.3 Perkhidmatan penyandang boleh ditamatkan sekiranya gagal memenuhi perkara 10.1 dan 10.2 di atas.<br> 
    
    <br>
* Syarat ini berkuatkuasa kepada kakitangan lantikan TETAP sahaja.<br   
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
                                <td colspan="2"><?= $model->kakitangan->servPeriodPermanent; ?></td> 
                            </tr>
                            <tr>   
                                <th>STATUS PTM</th>  
                                <td colspan="2">
                                    <?php 
                                    
                                        if ($model->kakitangan->ptm){
                                            echo $model->kakitangan->ptm->status;
                                        } else {
                                        echo '-';
                                    }
                                    ?></td> 
                            </tr>
                            <tr>   
                                <th style="width:40%">STATUS SPM (BM)</th>  
                                <td colspan="2">
                                    <?php
                                     $status_bm = '';
                                     
                                    if ($subjek) { $bil1=1;?>
                                    <?php foreach ($subjek as $subjekkakitangan) { 
                                    { ?>

                                    <?= $subjekkakitangan->gred; 
                                     $status_bm = "YA";
                                    ?>
                    
                                    <?php } }?>
                                    <?php } else {
                                        echo '-';
                                    ?>
                   
                                    <?php } ?>
                        
                                   
                                </td> 
                            </tr> 
                            <tr>   
                                <th style="width:40%">PENGESAHAN PERKHIDMATAN</th>  
                                <td colspan="2">
                                    <?php
                                    $pengesahan_status = '';

                                    if ($model->kakitangan->confirmDt) {
                                        echo $model->kakitangan->confirmDt->tarikhMula;
                                        $pengesahan_status = "YA";
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td> 
                            </tr> 
                            <tr>   
                                <th rowspan="4">LNPT <br/>
                                    (Pemberat 3 Tahun = 20%, 35%, 45%)<br/>
                                    (Pemberat 2 Tahun = 40% , 60%)
                                </th>  
                                <td colspan="2"><?= '<b>' . $model->kakitangan->markahlnptCV(1, 'Tahun') . ' :</b> ' . $model->kakitangan->markahlnptCV(1, 'Markah'); ?></td> 
                            </tr>
                            <tr>   
                                <td colspan="2"><?= '<b>' . $model->kakitangan->markahlnptCV(2, 'Tahun') . ' :</b> ' . $model->kakitangan->markahlnptCV(2, 'Markah'); ?></td>  
                            </tr>
                            <tr>
                                <td colspan="2"><?= '<b>' . $model->kakitangan->markahlnptCV(3, 'Tahun') . ' :</b> ' . $model->kakitangan->markahlnptCV(3, 'Markah'); ?></td> 
                            </tr> 
                            <tr>
                                <td colspan="2">   
                                    <?php if (!empty($model->kakitangan->markahlnptCV(3, 'Tahun'))) { ?>
                                        Avg (3 Tahun) : 
                                        <?php
                                        $lnpt = number_format(($model->kakitangan->markahlnptCV(1, 'Markah') * 0.2) + ($model->kakitangan->markahlnptCV(2, 'Markah') * 0.35) + ($model->kakitangan->markahlnptCV(3, 'Markah') * 0.45));
                                        echo $lnpt;
                                    } else {
                                        ?> 
                                        Avg (2 Tahun) : 
                                        <?php
                                        $lnpt = number_format(($model->kakitangan->markahlnptCV(1, 'Markah') * 0.6) + ($model->kakitangan->markahlnptCV(2, 'Markah') * 0.4));
                                        echo $lnpt;
                                    }
                                    ?>
                                </td> 
                            </tr>
                            <tr>   
                                <th>BERJAWATAN TETAP</th>  
                                <td colspan="2"><?= $model->kakitangan->statusLantikan->ApmtStatusNm; ?></td> 
                            </tr>
                            <tr>   
                                <th>BEBAS TINDAKAN TATATERTIB</th>  
                                <td colspan="2"><?= $model->kakitangan->usercv ? $model->kakitangan->usercv->statusTatatertib() : '-'; ?></td> 
                            </tr>
                        </table>
                    </center>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <center>
                        <table class="table table-sm table-bordered jambo_table table-striped" style="width:80%"> 
                            <tr>   
                                <th colspan="3" class="text-center" style="background-color:#20c997; color:white;">KRITERIA</th>   
                            </tr>
                            <?php
                            $totalUmum = 0;
                            foreach ($umum as $p) {
                                ?>
                                <tr>      
                                    <th colspan="2"><?= $p->requirement; ?></th>   
                                    <?php
                                      if ($p->id == 1) {
                                        if ($model->kakitangan->servPeriodPermanent >= $p->ans_no) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
                                    if ($p->id == 2) {
                                        if ($pengesahan_status == $p->ans_char) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    } else if ($p->id == 3) {
                                        //calon cuti belajar 
                                        if ($model->kakitangan->findCutiBelajar($model->kakitangan->ICNO) != 1) {

                                            if ($lnpt >= $p->ans_no) {
                                                $s = 1;
                                                $totalUmum++;
                                            } else {
                                                $s = 0;
                                            }
                                        } else {
                                            $s = 0; //skip
                                            $totalUmum++;
                                        }
                                    } else if ($p->id == 4) {
                                        if ($model->kakitangan->statLantikan == $p->ans_no) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    } else if ($p->id == 5) {
                                        if (($mode->kakitanganl->usercv ? $model->kakitangan->usercv->tatatertib_status : '') == $p->ans_no) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
                                    else if ($p->id == 6) {
                                        if ($status_bm == $p->ans_char) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }

                                    if ($s == 1) {
                                        $color = "#20c997";
                                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                    } else if ($s == 0) {
                                        if ($p->id == 3) {
                                            $color = "white";
                                        } else {
                                            $color = "red";
                                        }
                                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                    } else {
                                        $color = "#1E90FF";
                                        $button = "HOLD";
                                    }
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

<div class="x_panel">
    <div class="x_title">
        <p align="right"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> <strong>SUMBER DATA SMPPI</strong></p>
        <div class="clearfix"></div>
    </div>
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
                    count(array_filter($model->kakitangan->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                            }))
                    ?>
                </td>
            </tr>
            <tr>
                <th>SEBAGAI PENULIS UTAMA</th>
                <td class="text-center"><?=
                    count(array_filter($model->kakitangan->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                            }))
                    ?>
                </td>
            </tr>
            <tr>     
                <th rowspan="2">JURNAL TIDAK BERINDEKS</th>
                <th>BIL KESELURUHAN</th> 
                <td class="text-center"><?=
                    count(array_filter($model->kakitangan->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                            }))
                    ?>
                </td>
            </tr>
            <tr>
                <th>SEBAGAI PENULIS UTAMA</th>
                <td class="text-center"><?=
                    count(array_filter($model->kakitangan->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                            }))
                    ?>
                </td>
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
                ?></th> 
                        <?php
                    if ($i == 1) {
                        $j = count(array_filter($model->kakitangan->publication, function ($var) {
                                    return ($var['Keterangan_PublicationTypeID'] == 'Article' && $var['KeteranganBI_WriterStatus'] == 'First Author' && $var['Keterangan_PublicationStatus'] == 'Published');
                                }));

                        if ($j >= $p->ans_no) {
                            $s = 1;
                            $totalPenerbitan++;
                        } else {
                            $s = 0;
                        }
                    }  else {
                        //temp for sitasi
                        $s = 2;
                    }

                    $i++;
                    if ($s == 1) {
                        $color = "#20c997";
                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                    } else if ($s == 0) {
                        $color = "red";
                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                    } else {
                        $color = "#1E90FF";
                        $button = "HOLD";
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

<div class="x_panel">
    <div class="x_title">
        <p align="right"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> <strong>SUMBER DATA SMPPI</strong></p>
        <div class="clearfix"></div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <table class="table table-sm table-bordered jambo_table table-striped">  
            <tr>  
                <th></th>
                <th colspan="5" class="text-center" style="background-color:#2A3F54; color:white;">PERINGKAT</th> 
            </tr> 
            <tr> 
                <th class="text-center" style="background-color:#2A3F54; color:white;">PERANAN</th>  
                <th>KEBANGSAAN</th> 
            </tr>
 
                <tr>

                    <th>
                        <?php echo 'PEMBENTANG'; ?> 

                    </th> 
                    <td class="text-center">

                        <?=
                        count(array_filter($model->kakitangan->persidangan2, function ($var){
                                    return ($var['Peringkat'] == 'Kebangsaan' && $var['Peranan'] == 'Pembentang');
                                }))
                        ?> 
                    </td>
                </tr>
        </table>
    </div> 
    
    <div class="col-md-12 col-sm-12 col-xs-12">
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
                ?></th> 
                    
                        <?php
                    if ($i == 1) {
                        $j = count(array_filter($model->kakitangan->persidangan2, function ($var) {
                                     return ($var['Peringkat'] == 'Kebangsaan' && $var['Peranan'] == 'Pembentang');
                                }));

                        if ($j >= $p->ans_no) {
                            $s = 1;
                            $totalPersidangan++;
                        } else {
                            $s = 0;
                        }
                    }  else {
                        //temp for sitasi
                        $s = 2;
                    }

                    $i++;
                    if ($s == 1) {
                        $color = "#20c997";
                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                    } else if ($s == 0) {
                        $color = "red";
                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                    } else {
                        $color = "#1E90FF";
                        $button = "HOLD";
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

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
<!--    <div class="x_panel" style="display: <?php echo $displaymohon;?>">-->
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Permohonan Pengesahan Dalam Perkhidmatan [Akademik]</strong></h2>&nbsp;
            
                <?php
                echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i> Lihat CV', [ 'cv/view-cv',  'id' => sha1($model->icno),
                    'title' => 'personal',], [
                    'class' => 'btn btn-primary btn-sm',
                    'target' => '_blank',
                ]);
                ?>

                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
        <div class="row"> 
            <div class="x_panel">
            <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Pengajaran</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
            </ul>
        <div class="clearfix"></div>
        </div>
            <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
<!--                                    <th class="text-center" rowspan="2">Course Title</th>
                                    <th class="text-center" rowspan="2">Course Code</th>
                                    <th class="text-center" rowspan="2">Semester / Session</th>
                                    <th class="text-center" rowspan="2">No. of Students</th>
                                    <th class="text-center" rowspan="2">No. of Hour Per Semester</th>-->
                                    <th class="text-center" rowspan="2">Kod Kursus</th>
                                    <th class="text-center" rowspan="2">Tajuk Kursus</th>                           
                                    <th class="text-center" rowspan="2">Semester</th>
                                    <th class="text-center" rowspan="2">Bil. Pelajar</th>
<!--                                    <th class="text-center" rowspan="2">Bil. Jam Per Semester</th>-->
                                </tr>
                            </thead>
                             <?php
                            if ($model->pengajaran) { $bil1=1;?>
                                <?php foreach ($model->pengajaran as $l) { $bil1++;
                                        ?>
                                <tr>
                                    <td class="text-center"><?= $l->SMP07_KodMP; ?></td>
                                    <td class="text-center"><?= $l->NAMAKURSUS; ?></td>        
                                    <td class="text-center"><?= $l->SESI; ?></td>
                                    <td class="text-center"><?= $l->BILPELAJAR; ?></td>
<!--                                    <td class="text-center"><?= $l->JAMKREDIT; ?></td>-->                                   
                                </tr>

                                <?php } }?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row"> 
            <div class="x_panel">
                <div class="x_title">
<!--                    <h2><strong><i class="fa fa-book"></i> Research</strong></h2>-->
                     <h2><strong><i class="fa fa-book"></i> Penyelidikan</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?= $this->render('_penyelidikan',['model'=>$model,]) ?>
                </div>
            </div>
        </div>
        <div class="row"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-book"></i> Artikel Dalam Jurnal Berwasit</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?= $this->render('_artikelberwasit',['model'=>$model,]) ?>
                </div>
            </div>
        </div>
        <div class="row"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-book"></i> Artikel Prosiding Yang Diterbitkan Di Persidangan Kebangsaan Atau Antarabangsa</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?= $this->render('_artikelprosiding',['model'=>$model,]) ?>
                </div>
            </div>
        </div>
        <div class="row"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-book"></i> Penerbitan Akademik Lain</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?= $this->render('_penerbitan',['model'=>$model,]) ?>
                </div>
            </div>
        </div>
        
        <div class="row"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-book"></i> Permohonan</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
                </ul>
                <div class="clearfix"></div>
                </div>
        <div class="x_content">       
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Borang Opsyen :<span class="required"></span>
                </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               <div class="col-md-12 col-sm-12 col-xs-12" style="color: green;">
                    <a href="<?php echo Url::to('@web/'.'uploads/BORANG OPSYEN.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br> 
                Borang ini perlu dimuat turun dan diisi oleh pekerja warganegara Malaysia yang memilih Skim Pencen atau Skim Kumpulan Wang Simpanan Pekerja (KWSP).
            </div>
            </div>
        </div>
        
         <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Borang Pemberian Taraf Berpencen :<span class="required"></span>
                </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               <div class="col-md-12 col-sm-12 col-xs-12" style="color: green;">
                    <a href="<?php echo Url::to('@web/'.'uploads/BORANG BERPENCEN.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br> 
                Borang ini hanya perlu dimuat turun dan diisi oleh pekerja warganegara Malaysia yang tidak memilih Skim Kumpulan Wang Simpanan Pekerja (KWSP).
               </div>
            </div>
        </div>
        
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Adakah anda memilih Skim Kumpulan Wang Simpanan Pekerja (KWSP) atau Skim Pencen?<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'skim')->label(false)->widget(Select2::classname(), [
                        'data' => ['Skim Kumpulan Wang Simpanan Pekerja (KWSP)' => 'Skim Kumpulan Wang Simpanan Pekerja (KWSP)', 'Skim Pencen' => 'Skim Pencen'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                        'onchange' => 'javascript:if ($(this).val() == "Skim Kumpulan Wang Simpanan Pekerja (KWSP)"){
                        $("#file2").show();
                        }
                        else{
                        $("#file2").show();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>     
                </div>  
        </div>
        
        <div class="form-group" id="file2">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
            </label>
            <span data-toggle="tooltip" ><i class="fa fa-info-circle fa-lg"></i></span>
            <div class="col-md-3">
                <?= $form->field($model, 'dokumen_sokongan2')->fileInput()->label(false) ?>
<!--                <div class="col-md-12 col-sm-12 col-xs-12" style="color: green; margin-top: -15px;">
                Sila muat naik Borang Opsyen dan Borang Pemberian Taraf Berpencen yang anda telah anda isi dan lengkapkan beserta salinan Kad Pengenalan jika anda memilih Pemberian Taraf Berpencen atau muat naik Borang Opsyen yang anda telah anda isi dan lengkapkan beserta salinan Kad Pengenalan jika anda memilih Skim Kumpulan Wang Simpanan Pekerja (KWSP).
                </div>-->
            </div>
        </div>
            
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lulus Program Transformasi Minda/Kursus Induksi:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?php if(($model->kakitangan2->tarikhPtm!= NULL)||($model->tarikh_lulus_ptm!= NULL)){?>
                    <?= $form->field($model->kakitangan2, 'tarikhptm')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                    <?php }else{
                        echo  $form->field($model, 'tarikh_lulus_ptm')->widget(DatePicker::className(),
                ['clientOptions' => ['changeMonth' => true,
                    'yearRange' => '1996:2099',
                    'changeYear' => true, 
                    'format' => 'yyyy-mm-dd', 
                    'autoclose' => true],
                'options' => [ 'placeholder' => 'Pilih Tarikh ', 
                    'onchange' => 'cal()', 
                    'id' => 'tarikh_lulus_ptm' ]])
                ->label(false);
                    } ?>
                </div>
        </div> 
                 
        <div class="form-group" id="file">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Muat Naik Dokumen: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'dokumen_sokongan')->fileInput()->label(false) ?>
                <div class="col-md-12 col-sm-12 col-xs-12" style="color: green; margin-top: -15px;">
                Sila muat naik salinan Sijil Lulus Program Transformasi Minda/Kursus Induksi anda.  
                </div>
            </div>
        </div>
        
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Tamat Kaedah Pengajaran & Pembelajaran:<span class="required" style="color:red;">*</span>
                </label>
<!--                <div class="col-md-6 col-sm-6 col-xs-12">
                <= $form->field($model, 'tarikh_lulus_pnp')->widget(DatePicker::className(),
                ['clientOptions' => ['changeMonth' => true,
                    'yearRange' => '1996:2099',
                    'changeYear' => true, 
                    'format' => 'yyyy-mm-dd', 
                    'autoclose' => true],
                'options' => [ 'placeholder' => 'Pilih Tarikh ', 
                    'onchange' => 'cal()', 
                    'id' => 'tarikh_lulus_pnp' ]])
                ->label(false);?>
                </div>-->
            
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?php if(($model->kakitangan3->tarikhPnp!= NULL)||($model->tarikh_lulus_pnp!= NULL)){?>
                    <?= $form->field($model->kakitangan3, 'tarikhpnp')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                    <?php }else{
                        echo  $form->field($model, 'tarikh_lulus_pnp')->widget(DatePicker::className(),
                ['clientOptions' => ['changeMonth' => true,
                    'yearRange' => '1996:2099',
                    'changeYear' => true, 
                    'format' => 'yyyy-mm-dd', 
                    'autoclose' => true],
                'options' => [ 'placeholder' => 'Pilih Tarikh ', 
                    'onchange' => 'cal()', 
                    'id' => 'tarikh_lulus_pnp' ]])
                ->label(false);
                    } ?>
                </div>
        </div>

        <div class="form-group" id="file3">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Muat Naik Dokumen: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'dokumen_sokongan3')->fileInput()->label(false) ?>
                <div class="col-md-12 col-sm-12 col-xs-12" style="color: green; margin-top: -15px;">
                Sila muat naik salinan Sijil Kursus Kaedah Pengajaran & Pembelajaran anda.
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ketua Jabatan :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="tblprcobiodata-enddatelantik" class="form-control" name="Tblprcobiodata[endDateLantik]" value="<?= $model->ketuajfpiu?>" disabled="disabled">
            </div>
        </div>
        
            <p style="color: green">
                Sila pastikan maklumat permohonan adalah tepat sebelum klik hantar. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini.
            </p>
            
        <div class="ln_solid"></div> 
        
        <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar Permohonan',['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Please Wait..' ,'confirm'=>'Sila pastikan maklumat permohonan adalah tepat. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini. Teruskan?']]) ?>
                </div>
        </div>
        </div>
        </div>
    </div>
            <?php ActiveForm::end();?>
    </div>
</div>
</div>

<div id="alert" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Perhatian!</h4>
            </div>
            <div class="modal-body">
                <b>Permohonan masih <mark>ditutup</mark>. Permohonan boleh dilakukan mulai <?= $options['date']['date_open']." hingga ".$options['date']['date_close']  ?></b>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>

    </div>
</div>
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script type="text/javascript">

    $(document).ready(function(){

        function checker(){
            var is_open = <?= $options['open'] ?>

            if(is_open === false){
               $("button[type='submit']").prop("disabled",true);
                $("#alert").modal('show');
            }
        }

        $( "#application-reason").keypress(function() {
            checker();
        });

        checker();
    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip({
            placement: 'right',
            title : "<p><li>Sila muat naik Borang Opsyen dan Borang Pemberian Taraf Berpencen yang anda telah anda isi dan lengkapkan beserta salinan Kad Pengenalan jika anda memilih Pemberian Taraf Berpencen.</li>\n\
                        <li>Sila muat naik Borang Opsyen yang anda telah anda isi dan lengkapkan beserta salinan Kad Pengenalan jika anda memilih Skim Kumpulan Wang Simpanan Pekerja (KWSP).</li></p>",
            html : true
        });
    });
</script>




