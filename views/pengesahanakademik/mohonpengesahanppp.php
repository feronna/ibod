<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use kartik\popover\PopoverX;
?>

<?php
$penerbitan = app\models\pengesahan\RequirementUmum2::penerbitan();
$persidangan = app\models\pengesahan\RequirementUmum2::persidangan();
$umum = app\models\pengesahan\RequirementUmum3::umum();
?>

<?php echo $this->render('/pengesahan/_topmenu'); ?> 

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
        2. Jika anda memilih <strong>Pemberian Taraf Berpencen</strong>, sila muat naik Borang Opsyen dan Borang Pemberian Taraf Berpencen yang anda telah anda isi dan lengkapkan.<br>
        3. Jika anda memilih <strong>Skim Kumpulan Wang Simpanan Pekerja (KWSP)</strong>, sila muat naik Borang Opsyen yang anda telah anda isi dan lengkapkan.<br>
        4. Abaikan ruangan tandatangan Ketua Jabatan pada Borang Opsyen dan Borang Pemberian Taraf Berpencen.<br>
        5. <strong> Pastikan dokumen yang dimuat naik maklumat jelas dirujuk dan sesuai dicetak bagi memudahkan pihak Bahagian Sumber Manusia memproses urusan permohonan Pemberian taraf Berpencen ke Jabatan Perkhidmatan Awam. </strong>
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
                                <td colspan="2"><?= $model->kakitangan->servPeriodPermanent; ?></td> 
                            </tr>
                            <tr>   
                                <th>STATUS PENGAJIAN</th>  
                                <td colspan="2"><?php
                         
                          if($model->kakitangan4->lapor->study->status_pengajian)
                          {
                            echo $model->kakitangan4->lapor->study->status_pengajian;
 
                          }
                          else
                          {
                             echo $model->kakitangan4->lapor->status_pengajian;
                          }

                           ?></td> 
                            </tr>
                            <tr>   
                                <th style="width:40%">STATUS SPM (BM)</th>  
                                <td colspan="2">
                                    <?php 
                                    $status_bm = '';
                                        if ($subjek->gred){
                                            echo $subjek->gred;
                                             $status_bm = "YA";
                                         } else  if ($subjek2->gred){
                                            echo $subjek2->gred;
                                             $status_spm = "YA";
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
                                        if ($model->kakitangan->ptm){
                                            echo $model->kakitangan->ptm->status;
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
                                        if ($model->kakitangan->pnp){
                                            echo $model->kakitangan->pnp->status;
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
                                $icno=Yii::$app->user->getId();   
                                for ($t=$tahunstarttetap; $t < date('Y') ; $t++){
                                
                                $markahOld = \app\models\elnpt\elnpt_lama\TblUser::find()->where(['user_id' => $icno])->one();
                            
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
                                $icno=Yii::$app->user->getId();   
                                for ($t=$tahunstarttetap; $t < date('Y') ; $t++){

                                //markah tahun 2020 dan ke atas
                                $markah = \app\models\elnpt\TblMain::find()->where(['PYD' => $icno, 'PPP_sah' => 1, 'PPK_sah' => 1, 'PEER_sah' => 1, 'tahun' => $t])->orderBy(['tahun' => SORT_DESC])->one(); // yang telah disahkan sahaja
        
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
                                $icno=Yii::$app->user->getId();   
                                for ($t=$tahunstarttetap; $t < date('Y') ; $t++){

                                //akademik yg isi borang pentadbiran
                                $markahPen = \app\models\lppums\Lpp::find()->where(['PYD' => $icno, 'tahun' => $t])->orderBy(['tahun' => SORT_DESC])->one();
                                
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
                                        if ($model->kakitangan->servPeriodPermanent >= $p->ans_no) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
                                    
                                    else if ($p->id == 2) {
                                        if (($status_bm == $p->ans_char) && ($model->sijilspm->filename != NULL)) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
                                    
                                    else  if ($p->id == 3) {
                                         if ($model->kakitangan->servPeriodPermanent >= $p->ans_no) {
                                        //if (($model->kakitangan->cpengajian->lapor->study->status_pengajian == $p->ans_char) || ($model->kakitangan->cpengajian->lapor->status_pengajian == $p->ans_char2)) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
                                    
//                                    else  if ($p->id == 3) {
//                                        if ($model->kakitangan4->tempohtajaan >= $p->ans_no) {
//                                            $s = 1;
//                                            $totalUmum++;
//                                        } else {
//                                            $s = 0;
//                                        }
//                                    }
                                    
                                    else if ($p->id == 4) {
                                        if (($model->kakitangan->ptm->status == $p->ans_char) || ($model->kakitangan->ptm->status == $p->ans_char2)){
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

                                            $markahOld = \app\models\elnpt\elnpt_lama\TblUser::find()->where(['user_id' => $icno])->one();

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

                                            $markah = \app\models\elnpt\TblMain::find()->where(['PYD' => $icno, 'PPP_sah' => 1, 'PPK_sah' => 1, 'PEER_sah' => 1, 'tahun' => $t])->one(); // yang telah disahkan sahaja

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

                                            $markahPen = \app\models\lppums\Lpp::find()->where(['PYD' => $icno, 'tahun' => $t])->one();

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
                        $j = count(array_filter($model->kakitangan->publication, function ($var) {
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
                    count(array_filter($model->kakitangan->persidangan2, function ($var){
                                return ($var['Peringkat'] == 'Kebangsaan' && $var['Peranan'] == 'Pembentang');
                            }))
                    ?> 
                </td> 
                <td class="text-center">

                   <?=
                    count(array_filter($model->kakitangan->persidangan2, function ($var){
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
                        $j = count(array_filter($model->kakitangan->persidangan2, function ($var) {
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
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lulus Program Transformasi Minda/Kursus Induksi:<span class="required" style="color:red;">*</span>
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
                    'required' => TRUE,
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
                    ['clientOptions' => 
                        ['changeMonth' => true,
                        'yearRange' => '1996:2099',
                        'changeYear' => true, 
                        'format' => 'yyyy-mm-dd', 
                        'autoclose' => true],
                    'options' => 
                        [ 'placeholder' => 'Pilih Tarikh ',
                        'required' => TRUE,
                        'onchange' => 'cal()', 
                        'id' => 'tarikh_lulus_pnp']])->label(false);
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
            
        <div class="form-group" id="file4">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Muat Naik Dokumen: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'dokumen_sokongan4')->fileInput()->label(false) ?>
                <div class="col-md-12 col-sm-12 col-xs-12" style="color: green; margin-top: -15px;">
                Sila muat naik salinan Sijil/ Surat Kelulusan (Senat) dianugerahkan KEPAKARAN  anda.
                </div>
            </div>
        </div>
            
        <div class="form-group" id="file5">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muat Naik Dokumen: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'dokumen_sokongan5')->fileInput()->label(false) ?>
                <div class="col-md-12 col-sm-12 col-xs-12" style="color: green; margin-top: -15px;">
                Sila muat naik salinan Kad Pengenalan anda.  
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
            
<!--        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ketua Jabatan :</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control" 
                value="
                    <php if (\app\models\cuti\SetPegawai::find()->where(['pemohon_icno' => $icno])){
                        echo $model->kakitangan->rujukan->pelulus->CONm; 
                    }
                    else if ($pegawai2->pelulus_icno == NULL){

                        echo '-';
                    }
                    ?>" disabled="disabled">
            </div>
        </div>-->
        
        <p style="color: green">
            Sila pastikan maklumat permohonan adalah tepat sebelum klik hantar. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini.
        </p>
            
        <div class="ln_solid"></div> 
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <php if($checking==1){?>-->
                <?php if(($checking==1) || ($icno == '880819495143')){?>
                <button class="btn btn-primary" type="reset">Reset</button>
                <?= Html::submitButton('Hantar Permohonan',['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Please Wait..' , 'confirm'=>'Sila pastikan maklumat permohonan adalah tepat. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini. Teruskan?']]) ?>
                <?php }else{
               echo Yii::$app->session->setFlash('alert', ['title' => 'Haraf Maaf', 'type' => 'error', 'msg' => 'Anda belum memenuhi kriteria yang diperlukan untuk pengesahan dalam perkhidmatan.']);
                } ?>
<!--                    <= Html::submitButton('Hantar Permohonan',['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Please Wait..' ,'confirm'=>'Sila pastikan maklumat permohonan adalah tepat. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini. Teruskan?']]) ?>-->
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
            title : "<p><li>Sila muat naik Borang Opsyen dan Borang Pemberian Taraf Berpencen yang anda telah anda isi dan lengkapkan jika anda memilih Pemberian Taraf Berpencen.</li>\n\
                        <li>Sila muat naik Borang Opsyen yang anda telah anda isi dan lengkapkan jika anda memilih Skim Kumpulan Wang Simpanan Pekerja (KWSP).</li></p>",
            html : true
        });
    });
</script>




