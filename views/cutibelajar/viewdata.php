<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Negara;
use dosamigos\datepicker\DatePicker;
$this->title = 'Permohonan Pengajian Lanjutan'; 
error_reporting(0);
?> 
<?php echo $this->render('/cutibelajar/_topmenu');?>

  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div class="x_content">  
            <div class="row">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['cutibelajar/halaman-utama-pemohon']) ?></li>
        <li>Data Pengajian Lanjutan Pemohon</li>
    </ol>
</div>
            
        </div>
 

    <div class="x_panel">
        <div class="x_content">  
            <h2><strong> MAKLUMAT DAN REKOD PENGAJIAN LANJUTAN : <?= ucwords(strtoupper($biodata->gelaran->Title)) ." ". ucwords(strtoupper($biodata->CONm)) ?></strong></h2>   
        </div>
    </div>

 <div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12" >
       
        <div class="x_panel">
            
       
<div class="row text-center" >
    <br/>
                <div class="col-lg-1 col-sm-3 col-xs-12 text-center">
                    <div class="col-lg-1 col-md-1 col-xs-12 text-center" rowspan="6" valign="top"><span><img height='100px' width="80px" src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(hash('sha1', $biodata->ICNO)); ?>.jpeg"></span></div>
                </div>
                <div class="col-lg-11 col-sm-9 col-xs-12" >
                    <div class="row">
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>Nama:</b></div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 text-left" ><?= $biodata->gelaran->Title ." ". ucwords(strtolower($biodata->CONm)) ?></div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>No. KP / Paspot:</b></div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 text-left "><?= $biodata->ICNO ?></div>
                    </div>
                    <div class="row ">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jabatan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= ucwords(strtolower($biodata->department->fullname)) ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Kampus Cawangan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left " ><?= ucwords(strtolower($biodata->kampus->campus_name)) ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>UMSPER:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $biodata->COOldID ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jawatan Disandang:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $biodata->jawatan->nama . " (" . $biodata->jawatan->gred . ")"; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Sandangan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $biodata->statusSandangan->sandangan_name ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Sandangan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $biodata->displayStartSandangan ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Jawatan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $biodata->statusLantikan->ApmtStatusNm ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tempoh Lantikan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $biodata->displayStartLantik ?> hingga <?= $biodata->tarikhbersara?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Pekerja:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><span><?= $biodata->Status ? $biodata->serviceStatus->ServStatusNm : 'Not Set' ?></span></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Status:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $biodata->displayStartDateStatus ?></div>
                    </div>
                </div>
</div>
<br/>       
             
<div class="well well-lg"> 
                <div class="row ">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <table>
                           
                            <tr>
                                <td class="text-center"><i class="fa fa-university" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Pengajian', ['view?ICNO='.$model->icno.'&id='.$model->id.'&page=maklumat-akademik']) ?></td>
                            </tr>
                            
                            <tr>
                                <td class="text-center"><i class="fa fa-money" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Penajaan', ['view?ICNO='.$model->icno.'&id='.$model->id.'&page=maklumat-pengajian']) ?></td>
                            </tr>

                        </table>
                    </div>
    
                     <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <table>
                            <tr>
                                <td class="text-center"><i class="fa fa-plus-square" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Pelanjutan Tempoh', ['view?ICNO='.$model->icno.'&id='.$model->id.'&page=maklumat-biasiswa']) ?></td>
                            </tr>
                             <tr>
                                <td class="text-center"><i class="fa fa-users" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Bon Perkhidmatan', ['view?ICNO='.$model->icno.'&id='.$model->id.'&page=maklumat-keluarga']) ?></td>
                            </tr>
                        </table>
                    </div>
                    
                     <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <table>
                           
                           
                            <tr>
                                <td class="text-center"><i class="fa fa-list-alt" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('LKK', ['view?ICNO='.$model->icno.'&id='.$model->id.'&page=semakan-syarat']) ?></td>
                            </tr>
                            
                            <tr>
                                <td class="text-center"><i class="fa fa-check-square-o" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Lapor Diri', ['view?ICNO='.$model->icno.'&id='.$model->id.'&page=keputusan-mesyuarat']) ?></td>
                            </tr>

                        </table>
                    </div>
                    
<!--                     <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <table>
                           
                            
                            <tr>
                                <td class="text-center"><i class="fa fa-tasks" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Baki Bon Perkhidmatan', ['bahasa/adminview', 'icno' => $biodata->ICNO]) ?></td>
                            </tr>
                            
                            <tr>
                                <td class="text-center"><i class="fa fa-university" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Cuti SABATIKAL', ['view?ICNO='.$model->icno.'&id='.$model->id.'&page=cuti-sabatikal']) ?></td>
                            </tr>

                        </table>
                    </div>-->
        </div>
</div>
        </div>
<?php    
if (isset($_GET['page'])) {
if ($_GET['page'] == "maklumat-akademik") {?>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">

<div class="x_title">
   <h2><strong><i class="fa fa-book"></i> Maklumat Akademik</strong></h2>
   <div class="clearfix"></div>
</div>
 <div>
<form id="w0" class="form-horizontal form-label-left" action="">
   <table class="table table-bordered jambo_table">
   <thead>
        <tr class="headings">
            <th class="column-title text-center">Bil</th>
            <th class="column-title">Tahap Pendidikan </th>
            <th class="column-title">Bidang</th>
            <th class="column-title">Universiti / Institusi</th>
            <th class="column-title">Kelas / CGPA</th>
            <th class="column-title">Tarikh Dianugerahkan</th>
            <th class="column-title">Tajaan</th>
        </tr>

    </thead>
    <tbody>
        <?php $bil=1; foreach ($akademik as $akademik) { ?>
        <tr>
            <td class="text-center"><?= $bil++ ?></td>
            <td><?= $akademik->tahapPendidikan; ?></td>
            <td><?= $akademik->namaMajor;?></td>
            <td><?= $akademik->namainstitut;?></td>
            <td><?= $akademik->OverallGrade;?></td>
            <td><?= $akademik->confermentDt;?></td> 
            <td><?= $akademik->Sponsorship;?></td>
        </tr>
        <?php } ?>
    </tbody>

    </table>
</form>
</div>
</div>
</div>
</div>
        
        
<?php } 
else if ($_GET['page'] == "maklumat-pengajian") 
{?>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">
<?php
    $pengajian = $biodata->pengajian;
    if($pengajian){ ?>
<div class="x_title">
    <h2><strong><i class="fa fa-graduation-cap"></i></i> Maklumat Pengajian Yang Dipohon</strong></h2>
    <div class="clearfix"></div>
</div>
<div>
<form id="w0" class="form-horizontal form-label-left" action="">
    <table class="table table-bordered jambo_table">
        <thead>
                <tr class="headings">
                    <th class="column-title text-center">Bil</th>
                    <th class="column-title">Nama Universiti</th>
                    <th class="column-title">Peringkat Pengajian </th>
                    <th class="column-title">Mod Pengajian </th>
                    <th class="column-title">Bidang </th>
                    <th class="column-title">Tarikh Mula Pengajian </th>
                    <th class="column-title">Tarikh Tamat Pengajian </th>
                    <th class="column-title">Tempoh Pengajian </th>
                    <th class="column-title">Tajuk Tesis </th>
                    <th class="column-title">Nama Penyelia </th>
                </tr>
        </thead>
        <tbody>
        <?php $bil=1; foreach ($pengajian as $pengajian) { ?>
                <tr>
                    <td class="text-center"><?= $bil++ ?></td>
                    <td><?= $pengajian->InstNm;?></td>
                    <td><?= $pengajian->pendidikanTertinggi->HighestEduLevel;?></td>
                    <td><?= $pengajian->mod->studyMode; ?></td>
                    <td><?= $pengajian->major->MajorMinor; ?></td>
                    <td><?= $pengajian->tarikhmula; ?></td>
                    <td><?= $pengajian->tarikhtamat; ?></td>
                    <td><?= $pengajian->tempohpengajian; ?></td>
                    <td><?= $pengajian->tajuk_tesis; ?></td>
                    <td><?= $pengajian->nama_penyelia; ?></td>
                </tr>
        <?php } ?>
        </tbody>
    </table>
</form>
</div>
</div>
</div>
</div>
<?php } }
else if ($_GET['page'] == "maklumat-biasiswa") 
{?>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">
<?php 
    $biasiswa = $biodata->biasiswa;
    if($biasiswa){
         ?>
    <div class="x_title">
        <h2><strong><i class="fa fa-money"></i> Maklumat Pembiayaan / Pinjaman Yang Dipohon</strong></h2>
        <div class="clearfix"></div>
    </div>
<div>
<form id="w0" class="form-horizontal form-label-left" action="">
<table class="table table-bordered jambo_table">
    <thead>
            <tr class="headings">
                <th class="column-title text-center">Bil</th>
                <th class="column-title">Nama Agensi / Tajaan </th>
                <th class="column-title">Bentuk Tajaan</th>
                <th class="column-title">Jumlah Amaun</th>
            </tr>
    </thead>
    <tbody>
    <?php $bil=1; foreach ($biasiswa as $biasiswa) { ?>
    <tr>
        <td class="text-center"><?= $bil++ ?></td>
        <td><?= $biasiswa->nama_tajaan; ?></td>
        <td><?= $biasiswa->bantuan->bentukBantuan;?></td>
        <td><?= $biasiswa->amaunBantuan;?></td>
    </tr>
    <?php } ?>
    </tbody>
</table>
</form>
</div>
</div>
<div>
</div>
<?php }}
else if ($_GET['page'] == "maklumat-keluarga") 
{?> 

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
              <?php if($keluarga){ ?>
            <div class="x_title">
                <h2><strong><i class="fa fa-users"></i> Maklumat Keluarga</strong></h2>
                 
                <div class="clearfix"></div>
            </div>

 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center">Bil</th>
                        <th class="column-title">Nama </th>
                        <th class="column-title">Hubungan</th>
                        <th class="column-title">No. Kad Pengenalan </th>
                        <th class="column-title">Umur </th>
                       
                    </tr>

                </thead>
                <tbody>

                    <?php $bil=1; foreach ($keluarga as $keluarga) { 
                        if ($keluarga->hubunganKeluarga->RelNm == "Isteri" || $keluarga->hubunganKeluarga->RelNm  == "Anak Kandung"){  ?>

                        <tr>

                            <td class="text-center"><?= $bil++ ?></td>
                            <td><?= $keluarga->FmyNm; ?></td>
                            <td><?= $keluarga->hubunganKeluarga->RelNm;?></td>
                            <td><?= $keluarga->FamilyId; ?></td>
                            <td><?=date("Y") - date("Y", strtotime($keluarga->FmyBirthDt))." " ."Tahun";?></td>
                            
                        
                        </tr>
              <?php }} ?>
                </tbody>

                     </table>

                </form>



            </div>
        </div>
    </div>
</div>
<?php }}
else if ($_GET['page'] == "semakan-syarat") 
{?> 
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">

<div class="x_title">
   <h2><strong><i class="fa fa-book"></i> Semakan Syarat Cuti Belajar - Post Doktoral</strong></h2>
   <div class="clearfix"></div>
</div>
<div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center" rowspan="2">No.</th>
                                    <th class="text-center" rowspan="2">Perkara</th>
                                    <th class="text-center" colspan="2">Tindakan</th>
                                  
                                  
                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center">Ya</th>
                                    <th class="column-title text-center">Tidak</th>
                                </tr>
                            </thead>
                         <?php
                            if ($doktoral) 
                            { $no=0;?>
                            
                                <?php foreach ($doktoral as $dok) { $no++; 
                                $mod = \app\models\cbelajar\TblNilaiSyarat::find()->where(['syarat_id' => $dok->syarat_id, 'icno' => $icno])->one();
                                     
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $dok->syarat; ?></td>
                                    <td class="text-center"><?php if($mod->semak_doktoral === 'y') {echo '&#10004;';} ?></td>
                                    <td class="text-center"><?php if($mod->semak_doktoral === 'n') {echo '&#10008;';} ?></td>
                                 
                                </tr>
                                
                                <?php }
                               
//                             }
                            }
                            ?>
                        </table>
                    </div>

</div>
</div>
</div>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">

<div class="x_title">
   <h2><strong><i class="fa fa-book"></i> Semakan Syarat Cuti Belajar</strong></h2>
   <div class="clearfix"></div>
</div>
<div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center" rowspan="2">No.</th>
                                    <th class="text-center" rowspan="2">Perkara</th>
                                    <th class="text-center" colspan="2">Tindakan</th>
                                  
                                  
                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center">Ya</th>
                                    <th class="column-title text-center">Tidak</th>
                                </tr>
                            </thead>
                         <?php
                            if ($kriteriakpi) 
                            { $no=0;?>
                            
                                <?php foreach ($kriteriakpi as $kpi) { $no++; 
                                $mod = \app\models\cbelajar\TblNilaiSyarat::find()->where(['syarat_id' => $kpi->syarat_id, 'icno' => $icno])->one();
                                     
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $kpi->syarat; ?></td>
                                    <td class="text-center"><?php if($mod->semak_phd === 'y') {echo '&#10004;';} ?></td>
                                    <td class="text-center"><?php if($mod->semak_phd === 'n') {echo '&#10008;';} ?></td>
                                 
                                </tr>
                                
                                <?php }
                               
//                             }
                            }
                            ?>
                        </table>
                    </div>

</div>
</div>
</div>

<?php }
else if ($_GET['page'] == "keputusan-mesyuarat") 
{?>        
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" >
<div class="x_panel">     
<div class="row text-center" >
<div class="x_title">
    <h2><strong><i class="fa fa-list-alt"></i> Keputusan Mesyuarat</strong></h2>
    <div class="clearfix"></div>
</div>
 <div class="table-responsive">
        <table class="table table-bordered jambo_table">
  <tr>
    <th style="width:30%;" >Mesyuarat Kali Ke- : </th>
    <td><?=$model->kali_ke ?></td>
  </tr>
  <tr>
    <th style="width:30%;" >Tarikh Mesyuarat : </th>
    <td><?=$model->tarikh_mesyuarat ?></td>
  </tr>
  <tr>
    <th style="width:30%;" >Penajaan : </th>
    <td><?=$model->penajaan->penajaan ?></td>
  </tr>
  <tr>
    <th style="width:30%;" >Status Mesyuarat : </th>
    <td><?=$model->status_mesyuarat ?></td>
  </tr>
  <tr>
    <th style="width:30%;" >Catatan / Syarat Tambahan : </th>
    <td><?=$model->ulasan_bsm ?></td>
  </tr>
        </table>
               
</div>
</div>
</div>
</div>
</div>
<?php} ?>
    
<?php }
else if ($_GET['page'] == "cuti-sabatikal") 
{?>        
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" >
<div class="x_panel">     
<div class="row text-center" >
<div class="x_title">
    <h2><strong><i class="fa fa-university"></i> CUTI SABATIKAL</strong></h2>
    <div class="clearfix"></div>
</div>
   <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-plus-square-o"></i> Tambah Data</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li> 
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content collapse" >
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Peringkat Pengajian: <span class="required" style="color:red;">*</span>
        </label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($sabatikal, 'HighestEduLevel')->textInput(['maxlength' => true])->label(false);?> 
        </div>
        
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mula: <span class="required" style="color:red;">*</span>
        </label>
         <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                    <?=
                    DatePicker::widget([
                        'model' => $sabatikal,
                        'attribute' => 'tarikh_mula',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
        
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Tamat: <span class="required" style="color:red;">*</span>
        </label>
          <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                    <?=
                    DatePicker::widget([
                        'model' => $sabatikal,
                        'attribute' => 'tarikh_tamat',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
        
        </div>    
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Universiti/Institusi: <span class="required" style="color:red;">*</span>
        </label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($sabatikal, 'InstNm')->textInput(['maxlength' => true])->label(false);?> 
        </div>
        </div>
        
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Negara: <span class="required" style="color:red;">*</span>
        </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
                         <?= $form->field($sabatikal, 'CountryCd')->widget(Select2::classname(), 
                        ['data' => ArrayHelper::map(Negara::find()->orderBy(['CountryCd' => SORT_ASC,])->all(), 'CountryCd', 'Country'),
                        'options' => [
                            'placeholder' => 'Pilih Negara'],
                    ])->label(false); ?>
                    </div>
        </div>
        
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Baki Bon Perkhidmatan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($sabatikal, 'baki_bon')->textInput(['maxlength' => true])->label(false);?> 
        </div>
        </div>
  
    <div class="form-group text-center"> 
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>
</div>
   </div>
    
 <div class="table-responsive">
         <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center">Bil</th>
                        <th class="text-center">Peringkat Pengajian </th>
                        <th class="text-center">Tarikh Mula </th>
                        <th class="text-center">Tarikh Tamat</th>
                        <th class="text-center">Universiti / Institusi </th>
                        <th class="text-center">Negara </th>
                        <th class="text-center">Baki Bon Perkhidmatan (Bulan) </th>
                        <th class="text-center">Tindakan</th> 

                    </tr>
                </thead>
                 <?php if($sabatikal2) {
                   $counter = 0; 
                   foreach ($sabatikal2 as $sabatikal2) {
                   $counter = $counter + 1;
                ?>
                   
                <tr>
                    
                    <td><?= $counter; ?></td>
                    <td><?= $sabatikal2->HighestEduLevel?></td>
                    <td><?= $sabatikal2->tarikh_mula?></td>
                    <td><?= $sabatikal2->tarikh_tamat?></td>
                    <td><?= $sabatikal2->InstNm?></td>
                    <td><?= $sabatikal2->negara->Country?></td>
                    <td><?= $sabatikal2->baki_bon;?></td>
                    <td class="text-center">
                         <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-sabatikal', 'id' => $iklan->id], ['class' => 'btn btn-default',
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?>
                    </td>  
                
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
        </table>
               
</div>
</div>
</div>
</div>
</div>

<?php} ?>
<?php }}?>
<!--<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
              <?php if($dokumen){ ?>
            <div class="x_title">
                <h2><strong><i class="fa fa-list-alt"></i> Dokumen Yang Dimuatnaik</strong></h2>
                
                <div class="clearfix"></div>
            </div>

 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center">Bil</th>
                        <th class="column-title text-center">Nama Dokumen </th>
                        <th class="column-title text-center">Lampiran</th>
                        
                       
                    </tr>

                </thead>
                <tbody>

                   <?php
                    if ($dokumen) {
                        $counter = 0;
                        foreach ($dokumen as $dokumen) {
                            $counter = $counter + 1;
                            ?>

                            <tr>
                                <td class="text-center"><?= $counter; ?></td> 
                                
                                <td><?php if((!empty($dokumen->dokumen->nama_dokumen))&& (!empty($dokumen->namafile))):?>
                                            
                                            <a href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($dokumen->namafile), true); ?>" target="_blank"/> <u><?php echo $dokumen->dokumen->nama_dokumen ?>
                                            <img src="<?= Url::to('@web/uploads'.$dokumen->namafile, true);?>"/>
                                            <?php endif;?></u>
                      
                                            
                                         
                                      </td>
                                
                          
                            </tr>
                            

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center">Tiada Rekod</td>                     
                        </tr>
<?php }
?>
                </tbody>

                     </table>

                </form>



            </div>
        </div>
    </div>
</div>
<?php } ?>      -->
</div>
</div>
      


     <?php ActiveForm::end(); ?>
   




