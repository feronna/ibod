<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\pengesahan\Pengesahan;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\TblWarnaKad;

error_reporting(0);
$bil=1;
?>
<!--<= $this->render('/pengesahan/_topmenu') ?>-->
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Permohonan Pengesahan Dalam Perkhidmatan</h2>&nbsp;
                <?php
                echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i> Lihat CV', [ 'cv/view-cv',  'id' => sha1($model->icno),
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
                <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(SHA1($model->kakitangan->ICNO)); ?>.jpeg" width="150" height="180"></center>
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
                <h2><?= strtoupper($model->kakitangan->CONm); ?></h2>
                </th>
                </tr>  
                <tr>
                    <th colspan="4" class="text-center"> 
                        <?php if ($model->kakitangan->jawatan->job_category == 1) { ?>
                            GELARAN : <?= strtoupper($model->kakitangan->gelaran->Title); ?>
                            <br/>
                            PROGRAM AKADEMIK : <?= $model->kakitangan->programPengajaran ? $model->kakitangan->programPengajaran->NamaProgram : '-'; ?>
                            <br/>
                        <?php } ?>
                        <i class="fa fa-phone-square user-profile-icon"></i> <?= $model->kakitangan->COHPhoneNo; ?> |
                        <i class="fa fa-envelope user-profile-icon"></i> <?= $model->kakitangan->COEmail; ?>
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
                        <th style="width:20%">Alamat</th>
                        <td style="width:20%"><?php
                        if ($biodata->alamatTetap) {
                            echo $biodata->alamatTetap->alamatPenuh;
                        } elseif ($biodata->alamatSemasa) {
                            echo $biodata->alamatSemasa->alamatPenuh;
                        } elseif ($biodata->alamatSuratmenyurat) {
                            echo $biodata->alamatSuratmenyurat->alamatPenuh;
                        } elseif ($biodata->alamatLain2) {
                            echo $biodata->alamatLain2->alamatPenuh;
                        } elseif (empty($biodata->rekodAlamat)) {
                            echo 'N/A';
                        }
                        ?>
                    </td>
                        <th>Negeri</th>
                        <td><?php
                            if ($model->kakitangan->COBirthPlaceCd) {
                                echo $model->kakitangan->tempatLahir->State;
                            }
                            ?></td> 
                    </tr>
                    <tr> 

                        <th style="width:20%">Tarikh Lahir</th>
                        <td style="width:20%"><?= $model->kakitangan->displayBirthDt; ?></td>
                        <th style="width:20%">Jantina</th>
                        <td style="width:20%"><?= $model->kakitangan->jantina->Gender; ?></td>

                    </tr>
                </tbody>
            </table> 
            </div> 
        <br/>

    </div>
</div>
<br/>

<!--<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Pemohon</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
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
                    <= $form->field($model->kakitangan, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS (PER) <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <= $form->field($model->kakitangan, 'COOldID')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>-->

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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Gred & Jawatan <span class="required"></span>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Program <span class="required"></span></label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->kakitangan->programPengajaran->NamaProgram.' ('.$model->kakitangan->programPengajaran->KodProgram.')'?>" disabled="disabled">
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
                if ($subjek) { $bil1=1;?>
                    <?php foreach ($subjek as $subjekkakitangan) { 
                        { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                             <td><?= $subjekkakitangan->subjek; ?></td>
                             <td><?= $subjekkakitangan->gred; ?></td>  
                             <td><?= \app\models\hronline\Tblpendidikan::find()->where(['ICNO' => $model->icno, 'HighestEduLevelCd' => '14'])->one()->displayLink ?></td>   
                        </tr>
                <?php } }?>
                        
                <?php } else if ($subjek2) { $bil1=1;?>
                        <?php foreach ($subjek2 as $subjekkakitangan2) { 
                        { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                             <td><?= $subjekkakitangan2->subjek; ?></td>
                             <td><?= $subjekkakitangan2->gred; ?></td>  
                             <td><?= \app\models\hronline\Tblpendidikan::find()->where(['ICNO' => $model->icno, 'HighestEduLevelCd' => '23'])->one()->displayLink ?></td>   
                        </tr>
                <?php }}} ?>
            </table>
            </div>
        </div>
    </div>
</div>
</div>

<!--<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Pengajaran</strong></h2>
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
                    <th class="text-center">Kod Kursus</th>
                    <th class="text-center">Tajuk Kursus</th>
                    <th class="text-center">Kursus dikendalikan</th>   
                    <th class="text-center">Semester</th>    
                    <th class="text-center">Bil. Pelajar</th>
                    <th class="text-center">Bil. Jam Per Semester</th>
                </tr>
                </thead>         
                 <php
                            if ($model->pengajaran) { $bil1=1;?>
                                <php foreach ($model->pengajaran as $l) { $bil1++;
                                        ?>
                                <tr>
                                    <td class="text-center"><= $l->SMP07_KodMP; ?></td>
                                    <td class="text-center"><= $l->NAMAKURSUS; ?></td>        
                                    <td class="text-center"><= $l->SMP07_KodMP; ?>&nbsp;<= $l->NAMAKURSUS; ?></td>
                                    <td class="text-center"><= $l->SESI; ?></td>
                                    <td class="text-center"><= $l->BILPELAJAR; ?></td>
                                    <td class="text-center"><= $l->JAMKREDIT; ?></td>
                                    
                                </tr>

                                <php } }?>
            </table>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Penyelidikan</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>    
       <div class="x_content">
              <= $this->render('_penyelidikan',['model'=>$model,]) ?>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Artikel Dalam Jurnal Berwasit</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>    
       <div class="x_content">
              <= $this->render('_artikelberwasit',['model'=>$model,]) ?>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Artikel Prosiding</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>    
       <div class="x_content">
              <= $this->render('_artikelprosiding',['model'=>$model,]) ?>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Penerbitan Akademik Lain</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>    
       <div class="x_content">
              <= $this->render('_penerbitan',['model'=>$model,]) ?>
        </div>
    </div>
</div>-->

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Anugerah</strong></h2>
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
                  
<!--                    <th class="text-center">Kategori</th>-->
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
<!--                            <td class="text-center"><?php echo $a->AwdAbbr; ?></td>-->
<!--                            <td class="text-center"><?php is_null($a->gelaran) ? 'Tidak Berkaitan' : $a->gelaran->Title ; ?></td>-->
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
                    <th class="text-center">Kategori</th>
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
            <table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="headings">
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Markah</th>
                    </tr>
                </thead>
                        <?php 
                            $i =0; $jumlahKeseluruhan1 = 0;
                            for ($t=$tahunstarttetap; $t < date('Y') ; $t++){

                            //markah tahun 2019 dan ke bawah (beza tbl c cleeve x guna tbl lama tu yg markah 2020 berbeza tempat)
                            $markahOld = \app\models\elnpt\elnpt_lama\TblUser::find()->where(['user_id' => $model->icno])->one();

                            $recordOld = \app\models\elnpt\elnpt_lama\TblMarkahLama::find()->where(['staff_id' => $markahOld->staff_id, 'tahun' => $t])->orderBy(['id' => SORT_DESC])->one();
                            if ($recordOld) {
                                    if ($recordOld->purata != '0' || $recordOld->purata != '') {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $t; ?></td>
                                            <td class="text-center"><?= number_format($recordOld->purata, 2, '.', ''); ?></td>
                                        </tr>
                                        <?php
                                        
                                        $jumlahKeseluruhan1 = $jumlahKeseluruhan1 + $recordOld->purata;
                                        $i++;
                                    }
                                }
                            }

                        ?> 
                            
                        <?php
                            $j =0; $jumlahKeseluruhan2 = 0;
                            for ($t=$tahunstarttetap; $t < date('Y') ; $t++){

                            //markah tahun 2020 dan ke atas
                            $markah = \app\models\elnpt\TblMain::find()->where(['PYD' => $model->icno, 'PPP_sah' => 1, 'PPK_sah' => 1, 'PEER_sah' => 1, 'tahun' => $t])->orderBy(['tahun' => SORT_DESC])->one(); // yang telah disahkan sahaja

                            $record = \app\models\elnpt\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markah->lpp_id])->one();
                            if ($record) {
                                    if ($record->markah != '0' || $record->markah != '') {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $t; ?></td>
                                            <td class="text-center"><?= $record->markah; ?></td></tr>
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
                            $markahPen = \app\models\lppums\Lpp::find()->where(['PYD' => $model->icno, 'tahun' => $t])->orderBy(['tahun' => SORT_DESC])->one();

                            $recordPen = \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markahPen->lpp_id])->one();
                            if ($recordPen) {
                                    if ($recordPen->markah_PP != '0' || $recordPen->markah_PP != '') {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $t; ?></td>
                                            <td class="text-center"><?= $recordPen->markah_PP; ?></td></tr>
                                        <?php
                                        
                                        $jumlahKeseluruhan3 = $jumlahKeseluruhan3 + $recordPen->markah_PP;
                                        $k++;
                                    }
                                }
                            }

                        ?>   
                    <tr class="headings">
                        <th class="text-center">Purata Markah</th>
                        <th class="text-center">
                            <?php
                                $jumlahTahun = $i + $j + $k;
                                $purata = number_format(($jumlahKeseluruhan1 +$jumlahKeseluruhan2 + $jumlahKeseluruhan3) / $jumlahTahun , 2, '.', '');

                                echo $purata;
                            ?>
                        </th>
                    </tr>
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
                                <th class="text-center" style="background-color:red; color:black" >RED</th> 
                            </tr> 
                            <?php
                            for ($i = $tahunstarttetap; $i <= date('Y'); $i++) {
                            
                            //for ($i = 0; $i <= 2; $i++) {
//                            //for ($t=$tahunstarttetap; $t < date('Y') ; $t++){
//
//                                //$tahun = date('Y') - $i;
                                ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= TblWarnaKad::totalByCardColor($i, $biodata->ICNO, 'YELLOW') ?></td>
                                    <td class="text-center"><?= TblWarnaKad::totalByCardColor($i, $biodata->ICNO, 'GREEN') ?></td>
                                    <td class="text-center"><?= TblWarnaKad::totalByCardColor($i, $biodata->ICNO, 'RED') ?></td> 
                                    <td class="text-center"><?= TblWarnaKad::prestasiWarnaKad2($i, $biodata->ICNO) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        
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
<!--                    <th class="text-center">Cadangan Tarikh Mohon</th>-->
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
<!--                             <td><?= $statuss->tempoh_l_jfpiu; ?></td>    -->
                            <td><?php if($model->tempoh_l_jfpiu!= NULL){?>               
                                 <?php echo $model->tempoh_l_jfpiu;?>
                                 <?php }else{ echo "Tidak Berkaitan"; }?>
                            </td>
<!--                            <td><?= $statuss->tempoh_l_bsm; ?></td>  -->
                            <td><?php if($model->tempoh_l_bsm!= NULL){?>               
                                 <?php echo $model->tempoh_l_bsm;?>
                                 <?php }else{ echo "Tidak Berkaitan"; }?>
                            </td>
<!--                             <td><?= $statuss->tarikhmohonbalik; ?> - <?= $statuss->tarikhmohonbalik2; ?></td>  -->
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
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Kursus Kaedah Pengajaran & Pembelajaran<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'tarikhluluspnp')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group" id="file3">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Sijil Kursus Kaedah Pengajaran & Pembelajaran<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php if($model->dokumen_sokongan3!= NULL){?>
                     <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan3), true); ?>" target="_blank" ><i></i><u>Dokumen Sokongan 3.pdf</u></a><br>
                    <?php }else{
                        echo "Tiada Dokumen Disertakan";
                    }?>
                </div>
            </div> 
            <div class="form-group" id="file5">
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
<div class="col-md-12 col-sm-12 col-xs-12">  
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

        <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
        <div class="x_content">
         <table>
             
          <h5 style="color:black;" >
           <strong>PERAKUAN KETUA JABATAN</strong> 
          <br><br>
          Selaras dengan undang undang Malaysia Peraturan Pegawai Awam [Pelantikan, Kenaikan Pangkat dan Penamatan Perkhidmatan] 2005
          <br><br>          
          (Peraturan 27)  
          <br><br>
            Saya telah menyemak permohonan ini dan mengesahkan bahawa <strong><?= $model->kakitangan->CONm ?> </strong>kad
            pengenalan <strong> <?= $model->icno ?> </strong>telah menjalankan tugasnya dengan jujur, tekun dan berkebolehan dan saya berpuas hati dengan sifat peribadi dan
            kelakuannya dan dengan ini memperakuinya untuk disahkan.<br/> </h5>
 
            </td>
        </tr>
        </table>  
        </div> 
        </div>
        </div></div>

            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Perakuan <span class="required"></span>
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
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Ketua Jabatan<span class="required"></span> 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control" value="<?php echo $model->kj->CONm;?>" disabled="disabled">
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

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> STATUS KELULUSAN MESYUARAT JAWATANKUASA PENGESAHAN DALAM PERKHIDMATAN</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

        <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
        <div class="x_content">
         <table>
             
          <h5 style="color:black;" >
           <strong>PERAKUAN PENGESAHAN DALAM PERKHIDMATAN</strong>
          <br><br>          
          [subperaturan 29(2)]
          <br>   
        </tr>
        </table>  
        </div> 
        </div>
        </div></div>

             <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Kelulusan <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->status_bsm;?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_bsm')->textArea(['maxlength' => true, 'rows' => 4, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
<!--            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Cadangan Tempoh Memohon Balik Pengesahan Dalam Perkhidmatan<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <input type="text" class="form-control" value="<?php echo $model->tempoh_l_bsm;?>" disabled="disabled">
                </div>
            </div>-->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Cadangan Tempoh Memohon Balik Pengesahan Dalam Perkhidmatan<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php if($model->tempoh_l_bsm!= NULL){?>                   
                   <input type="text" class="form-control" value="<?php echo $model->tempoh_l_bsm;?>" disabled="disabled">
                    <?php }else{
                        echo "Tidak Berkaitan";
                    }?>
                </div>
            </div>
<!--            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Cadangan Tarikh Mohon<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->tarikhmohonbalik;?> - <?php echo $model->tarikhmohonbalik2;?>" disabled="disabled">
                </div>
            </div>-->
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Diluluskan<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->tarikhlulus;?>" disabled="disabled">
                </div>
            </div>
    </div>
</div>
</div>

</div>
            <?php ActiveForm::end(); ?>
</div>
</div>

