<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\pengesahan\Pengesahan;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\TblWarnaKad;
error_reporting(0);
?>

<?= $this->render('/pengesahan/_topmenu') ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Permohonan Pengesahan Dalam Perkhidmatan</h2>
            <div class="clearfix"></div>
        </div>
        
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Pemohon</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penuh <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model->kakitangan, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS (PER) <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model->kakitangan, 'COOldID')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            </div>
        </div>
    </div>
</div> 
</div>
        
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Maklumat Perkhidmatan</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>
        <div class="x_content">
        <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Gred & Jawatan<span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model->kakitangan->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div> 
            </div>
            <div class="form-group">  
                <label class="control-label col-md-3 col-sm-3 col-xs-12">JAFPIB<span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model->kakitangan->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>   
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Taraf Jawatan <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model->kakitangan->statusLantikan, 'ApmtStatusNm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Pengesahan Dalam Perkhidmatan<span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model->confirmation->statusPengesahan, 'ConfirmStatusNm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lantikan Jawatan Tetap<span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model, 'startdatelantik')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempoh Perkhidmatan Lantikan Tetap Semasa Permohonan Dikemukakan<span class="required"></span> 
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                   <?= $form->field($model->kakitangan, 'servPeriodPermanent')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div> 
            </div>  
        </div>
        </div>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Pendidikan (PMR dan Setaraf)</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>    
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped table-sm jambo_table table-bordered">
                <thead>
                <tr class="headings">
                    <th class="text-center">Bil.</th>
                    <th class="text-center">Subjek</th>
                    <th class="text-center">Gred</th>    
                    <th class="text-center">Penilaian Menengah Rendah</th>
                </tr>
                </thead>     
                <?php
                if ($subjekpmr) { $bil1=1;?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                             <td><?= $subjekpmr->subjek; ?></td>
                             <td><?= $subjekpmr->gred; ?></td>  
                             <td><?= \app\models\hronline\Tblpendidikan::find()->where(['ICNO' => $model->icno, 'HighestEduLevelCd' => '15'])->one()->displayLink ?></td>   
                        </tr>
                <?php  }?>
            </table>
            </div>
        </div>
    </div>
</div>
</div>
        
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Pendidikan (SPM dan Setaraf)</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>    
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped table-sm jambo_table table-bordered">
                <thead>
                <tr class="headings">
                    <th class="text-center">Bil.</th>
                    <th class="text-center">Subjek</th>
                    <th class="text-center">Gred</th>    
                    <th class="text-center">Sijil Pelajaran Malaysia</th>
                </tr>
                </thead>         
                <?php
                if ($subjekspm) { $bil1=1;?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                             <td><?= $subjekspm->subjek; ?></td>
                             <td><?= $subjekspm->gred; ?></td>  
                             <td><?= \app\models\hronline\Tblpendidikan::find()->where(['ICNO' => $model->icno, 'HighestEduLevelCd' => '14'])->one()->displayLink ?></td>   
                        </tr>
                <?php } 
                
                else if ($subjekspm2) { $bil1=1;?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                             <td><?= $subjekspm2->subjek; ?></td>
                             <td><?= $subjekspm2->gred; ?></td>  
                             <td><?= \app\models\hronline\Tblpendidikan::find()->where(['ICNO' => $model->icno, 'HighestEduLevelCd' => '23'])->one()->displayLink ?></td>   
                        </tr>
                <?php }?>
            </table>
            </div>
        </div>
    </div>
</div>
</div>
        
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i>Anugerah</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
               <thead>
                <tr class="headings">
                    <th class="text-center">Bil.</th>
<!--                    <th class="text-center">Kategori</th>-->
                    <th class="text-center">Nama Anugerah</th>
<!--                    <th class="text-center">Singkatan Anugerah</th>-->
<!--                    <th class="text-center">Gelaran</th>-->
                    <th class="text-center">Dianugerahkan Oleh</th>         
<!--                    <th class="text-center">Negara</th>
                    <th class="text-center">Negeri</th>-->
                    <th class="text-center">Tarikh Dianugerahkan</th> 
                    <th class="text-center">Sebab Anugerah</th> 
<!--                    <th class="text-center">Status Anugerah</th> -->
                </tr>
               </thead>
                <?php
                if ($anugerah) { $bil1=1;?>
                    <?php foreach ($anugerah as $a) { 
                        { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
<!--                            <td class="text-center"><?php echo $a->kategoriAnugerah->AwdCat; ?></td>-->
                            <td class="text-center"><?php echo $a->namaAnugerah->Awd; ?></td>
<!--                            <td class="text-center"><?php echo $a->AwdAbbr; ?></td>
                            <td class="text-center"><?php is_null($a->gelaran) ? 'Tidak Berkaitan' : $a->gelaran->Title ; ?></td>-->
                            <td class="text-center"><?php echo $a->dianugerahkanOleh->CfdBy; ?></td> 
<!--                            <td class="text-center"><?php is_null($a->negara) ? 'Tidak Berkaitan' : $a->negara->Country; ?></td>
                            <td class="text-center"><?php is_null($a->negeri) ? 'Tidak Berkaitan' : $a->negeri->State; ?></td>-->
                            <td><?php echo $a->awdcfddt; ?></td>
                            <td><?php echo $a->AwdReason; ?></td>
<!--                            <td><?= $a->AwdStatus ? 'Aktif' : 'Tidak Aktif'; ?></td>                        -->
                        </tr>
                    <?php } }?>
                <?php } else { ?>
                   
                <?php } ?>
            </table>        
        </div>
        </div>
    </div>
</div>
</div>
        
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Penglibatan Dalam Aktiviti Semasa Di UMS</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
               <thead>
                <tr class="headings">
                    <th class="text-center">Bil.</th>
                    <th class="text-center">Peringkat</th>
                    <th class="text-center">Jenis Kompetensi</th>
                    <th class="text-center">Program</th>
                    <th class="text-center">Tarikh</th>
                    <th class="text-center">Tempat</th>                          
                </tr>
               </thead>
                <?php
                if ($latihan) { $bil1=1;?>
                    <?php foreach ($latihan as $l) { 
                        if ($l->senarailatihan->vcsl_tkh_mula >= $model->kakitangan->startDateLantik &&
                                $l->senarailatihan->vcsl_tkh_mula <= $model->kakitangan->endDateLantik) { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                            <td class="text-center"><?php echo $l->senarailatihan->vcsl_nama_peringkat; ?></td>
                            <td class="text-center"><?php echo $l->jeniskompetensi->vcks_nama_kompetensi; ?></td>
                            <td class="text-center"><?php echo $l->senarailatihan->vcsl_nama_latihan; ?></td>
                            <td class="text-center"><?php echo $l->senarailatihan->tarikhmulalatihan; ?></td>
                            <td class="text-center"><?php echo $l->senarailatihan->vcsl_tempat; ?></td>
                        </tr>
                    <?php } }?>
                <?php } else { ?>
                   
                <?php } ?>
            </table>
        </div>
        </div>
    </div>
</div>
</div>
        
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Markah Penilaian Prestasi Tahunan(LNPT)</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>  
        </div>
        <div class="x_content">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <table class="table table-striped table-sm jambo_table table-bordered">
               <thead>
                    <tr class="headings">
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Markah</th>
                    </tr>
               </thead>
<!--                        <tr>
                            <td class="text-center"><php echo date('Y')-1; ?></td>
                            <td class="text-center"><= $model->markahkeseluruhan1->markah_PP; ?></td>
                        </tr>
                        <tr>
                            <td class="text-center"><php echo date('Y')-2; ?></td>
                            <td class="text-center"><= $model->markahkeseluruhan2->markah_PP; ?></td>
                        </tr>
                        <tr>
                            <td class="text-center"><php echo date('Y')-3; ?></td>
                            <td class="text-center"><= $model->markahkeseluruhan3->markah_PP; ?></td>
                        </tr>-->
               
                        <?php
                            for ($t=$tahunstarttetap; $t < date('Y') ; $t++){

                            $markah = \app\models\lppums\Lpp::find()->where(['PYD' => $model->icno, 'tahun' => $t])->one(); // yang telah disahkan sahaja

                            $record = \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markah->lpp_id])->one();                                    
                            if ($record) {
                                $allrecord0 = $allrecord0 + $record->markah_PP;
                                    if ($record->markah_PP != '0' || $record->markah_PP != '') {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $t; ?></td>
                                            <td class="text-center"><?= $record->markah_PP;; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }

                        ?> 
                    <tr>
                        <th class="text-center"> Purata Markah</th>
                        <th class="text-center">           
                            <?php
                                $yearOld = $tahunstarttetap;
                                $yearNow = date('Y');
                                $year = $yearNow - $yearOld;
                                $allrecord = number_format($allrecord0 / $year, 2, '.', '');
                                echo $allrecord;
                            ?>
                        </th> 
                    </tr> 
            </table>
        </div>
        </div>
    </div>
</div> 
</div>

<!--<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i>Laporan Kehadiran Tahunan</strong></h2>
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
                    <th class="text-center">Tahun</th>
                    <th class="text-center">Lambat Masuk</th>
                    <th class="text-center">Awal Keluar</th>
                    <th class="text-center">Tidak Lengkap</th>
                    <th class="text-center">Tidak Hadir</th>
                    <th class="text-center">External</th>
                    <th class="text-center">Jumlah</th>
                </tr>
                </thead>
                <php for($i=0; $i<=2 ; $i++){
                ?>
                        <tr>
                            <td class="text-center"><= (date('Y')-$i) ?></td>
                            <td class="text-center"><= Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 1) ?></td>
                            <td class="text-center"><= Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 2) ?></td>
                            <td class="text-center"><= Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 3) ?></td>
                            <td class="text-center"><= Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 4) ?></td>
                            <td class="text-center"><= Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 5) ?></td>
                            <td class="text-center"><= Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 4) +
                            Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 3)+ 
                            Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 2)+
                            Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 1)+
                            Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 5)
                            ?></td>
                        </tr>
                <php } ?>
            </table>
        </div>
        </div>
    </div>
</div>
</div>-->

<!--<div class="row"> 
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Laporan Kehadiran Tahunan</strong></h2>
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
                    <th class="text-center">Tahun</th>
                    <th class="text-center">Lambat</th>
                    <th class="text-center">Tidak Lengkap</th>
                    <th class="text-center">Tidak Hadir</th>
                    <th class="text-center">Jumlah</th>
                </tr>
                </thead>
                <?php
                    for($i=0; $i<=2 ; $i++){
                      $tahun = date('Y')-$i; ?>
                          <tr>
                            <td class="text-center"><?= $tahun ?></td>
                            <td class="text-center"><?= $model->kehadiran($tahun, 1)?></td>
                            <td class="text-center"><?= $model->kehadiran($tahun, 3) ?></td>
                            <td class="text-center"><?= $model->kehadiran($tahun, 4) ?></td>
                            <td class="text-center"><?= $model->kehadiran($tahun, 1) +
                            $model->kehadiran($tahun, 3)+ 
                            $model->kehadiran($tahun, 4)
                            ?></td>
                        </tr><?php 
                    }
                ?>
                        
            </table>
        </div>
        </div>
    </div>
</div>
</div>-->

<div class="row"> 
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Laporan Kehadiran Tahunan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
             
            <table class="table table-striped table-sm jambo_table table-bordered">  
                            <tr>
                                <th class="text-center" rowspan="2" >Year</th>
                                <th class="text-center" colspan="3">Color Card</th> 
                                <th class="text-center" rowspan="2">Achievement</th> 
                            </tr> 
                            <tr> 
                                <th class="text-center" style="background-color:yellow; color:black">YELLOW</th> 
                                <th class="text-center" style="background-color:green; color:black">GREEN</th> 
                                <th class="text-center" style="background-color:red; color:black">RED</th> 
                            </tr> 
                            <?php
                            for ($i = 0; $i <= 2; $i++) {
                                $tahun = date('Y') - $i;
                                ?>
                                <tr>
                                    <td class="text-center"><?= $tahun ?></td>
                                    <td class="text-center"><?= TblWarnaKad::totalByCardColor($tahun, $biodata->ICNO, 'YELLOW') ?></td>
                                    <td class="text-center"><?= TblWarnaKad::totalByCardColor($tahun, $biodata->ICNO, 'GREEN') ?></td>
                                    <td class="text-center"><?= TblWarnaKad::totalByCardColor($tahun, $biodata->ICNO, 'RED') ?></td> 
                                    <td class="text-center"><?= TblWarnaKad::prestasiWarnaKad2($tahun, $biodata->ICNO) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>

        </div>
        </div>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Rekod Tatatertib</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>    
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped table-sm jambo_table table-bordered">
                <thead>
                <tr class="headings">
                    <th class="text-center">Bil.</th>
                    <th class="text-center">Tarikh Mesyuarat</th>
                    <th class="text-center">Tarikh Mula Hukuman</th>
                    <th class="text-center">Tarikh Akhir Hukuman</th>
                    <th class="text-center">Status Kes</th>
                </tr>
                </thead>         
                 <?php
                if ($tatatertib) { $bil1=1;?>
                    <?php foreach ($tatatertib as $tatatertib) { 
                        { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                             <td><?= $tatatertib->tarikh_mesyuarat; ?></td>
                             <td><?= $tatatertib->tarikh_mula_hukuman; ?></td>
                             <td><?= $tatatertib->tarikh_akhir_hukuman; ?></td>
                             <td><?= $tatatertib->status_kes; ?></td>
                        </tr>
                    <?php } }?>
                <?php } else { ?>
                   
                <?php } ?>
            </table>
            </div>
        </div>
    </div>
 </div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Status Permohonan</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>    
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped table-sm jambo_table table-bordered">
                <thead>
                <tr class="headings">
                    <th class="text-center">Bil.</th>
                    <th class="text-center">Tarikh Permohonan</th>
<!--                    <th class="text-center">Status</th>        -->
                    <th class="text-center">Cadangan Tempoh Ketua Jabatan</th>
                    <th class="text-center">Cadangan Tempoh BSM</th>
                </tr>
                </thead>         
                 <?php
                if ($status) { $bil1=1;?>
                    <?php foreach ($status as $statuss) { 
                        { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                             <td><?= $statuss->tarikhmohon; ?></td>
<!--                             <td><?= $statuss->statuss; ?></td>      -->
<!--                             <td><?= $statuss->tempoh_l_jfpiu; ?></td>  -->
                             <td><?php if($model->tempoh_l_jfpiu!= NULL){?>               
                                 <?php echo $model->tempoh_l_jfpiu;?>
                                 <?php }else{ echo "Tidak Berkaitan"; }?>
                             </td>
<!--                              <td><?= $statuss->tempoh_l_bsm; ?></td>    -->
                             <td><?php if($model->tempoh_l_bsm!= NULL){?>               
                                 <?php echo $model->tempoh_l_bsm;?>
                                 <?php }else{ echo "Tidak Berkaitan"; }?>
                             </td>
                        </tr>
                    <?php } }?>
                <?php } else { ?>
                   
                <?php } ?>
            </table>
            </div>
        </div>
    </div>
 </div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Maklumat Permohonan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Adakah anda memilih Skim Kumpulan Wang Simpanan Pekerja (KWSP) atau Skim Pencen?<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'skim')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
             <div class="form-group" id="file2">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen KWSP/PEMBERIAN TARAF BERPENCEN<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php if($model->dokumen_sokongan2!= NULL){?>                   
                    <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan2), true); ?>" target="_blank" ><i></i><u>Dokumen Sokongan 1.pdf</u></a><br>
                    <?php }else{
                        echo "Tiada Dokumen Disertakan";
                    }?>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lulus Program Transformasi Minda/Kursus Induksi<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php if($model->tarikh_lulus_ptm!= NULL){?>
                    <?= $form->field($model, 'tarikhlulusptm2')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                    <?php }else{
                    echo $form->field($model->kakitangan2, 'tarikhlulusptm')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); }?>
                </div>
            </div>
            <div class="form-group" id="file">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Sijil Lulus Program Transformasi Minda/Kursus Induksi<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php if($model->dokumen_sokongan!= NULL){?> 
                    <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><i></i><u>Dokumen Sokongan 2.pdf</u></a><br>
                    <?php }else{
                        echo "Tiada Dokumen Disertakan";
                    }?>
                </div>
            </div>
            <div class="form-group" id="file">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Salinan Kad Pengenalan<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php if($model->dokumen_sokongan5!= NULL){?> 
                    <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan5), true); ?>" target="_blank" ><i></i><u>Dokumen Sokongan 5.pdf</u></a><br>
                    <?php }else{
                        echo "Tiada Dokumen Disertakan";
                    }?>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mohon<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'tarikhmohon')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12" style="display: <?php if($model->status === 'DALAM TINDAKAN KETUA JABATAN'){echo 'none';}?>">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Status Perakuan Ketua Jabatan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Perakuan<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->status_jfpiu;?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_jfpiu')->textArea(['maxlength' => true, 'rows' => 4, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Cadangan Tempoh Memohon Balik Pengesahan Dalam Perkhidmatan<span class="required"></span>
                </label>
<!--                <div class="col-md-6 col-sm-6 col-xs-12">
                   <input type="text" class="form-control" value="<php echo $model->tempoh_l_jfpiu;?>" disabled="disabled">
                </div>-->
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php if($model->tempoh_l_jfpiu!= NULL){?>                   
                   <input type="text" class="form-control" value="<?php echo $model->tempoh_l_jfpiu;?>" disabled="disabled">
                    <?php }else{
                        echo "Tidak Berkaitan";
                    }?>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Diperaku<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->tarikhkj;?>" disabled="disabled">
                </div>
            </div>    
        </div>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12" style="display: <?php if($model->status != 'DALAM TINDAKAN KETUA JABATAN'){echo 'none';}?>">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Status Perakuan Ketua Jabatan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Status Perakuan<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'status_jfpiu')->label(false)->widget(Select2::classname(), [
                        'data' => ['Diperakui' => 'PERMOHOHAN DIPERAKUI', 'Tidak Diperakui' => 'PERMOHONAN DITOLAK'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "Diperakui"){
                        $("#tempoh").hide();
                        }
                        else{
                        $("#tempoh").show();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
        </div>
        <div class="form-group" id="ulasan" >
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_jfpiu')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>
        <div class="form-group" id="tempoh" style="display: none">
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Cadangan Tempoh Memohon Balik Pengesahan Dalam Perkhidmatan<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?php
                    $tempoh =ArrayHelper::map(\app\models\Pengesahan\RefTempoh::find()->where(['id' =>2])->orWhere(['id' =>3])->orWhere(['id' =>4])->all(), 'tempoh', 'tempoh');
                    ?>
                    <?=
                    $form->field($model, 'tempoh_l_jfpiu')->label(false)->widget(Select2::classname(), [
                        'data' => $tempoh,
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "LAIN-LAIN"){
                        $("#place-holder").show();
                        }
                        else{
                        $("#place-holder").hide();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
                    <div class="col-md-3 col-sm-3 col-xs-12" style="display: inline">
                        <input type="number" id="place-holder" name="tempohs" class="form-control" maxlength="20" style="display: none" placeholder="bulan    cth: 6">
                    </div>                 
                </div>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button class="btn btn-primary" type="reset">Reset</button>
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        </div>
    </div>
</div>
</div>
            <?php ActiveForm::end(); ?>
    </div>
</div>
</div>
