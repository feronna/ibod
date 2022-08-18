<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
error_reporting(0);
$this->title = 'Permohonan Cuti Belajar'; 
?> 


           
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

 <div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
       
    <div class="x_panel">
        <div class="x_content"> 
      
              <p align="center"><strong>UNIT PENGAJIAN LANJUTAN | SEKTOR PEMBANGUNAN SUMBER MANUSIA</strong></p> 
              <p align="center"><strong><u>PERMOHONAN PENGAJIAN LANJUTAN KAKITANGAN AKADEMIK</u></strong></p> 
             
        </div>
    </div>
           <div class="x_panel">
            
            <div class="x_title">
                <h6><strong><i class="fa fa-user"></i> Maklumat Peribadi</strong></h6>
                <div class="clearfix"></div>
            </div>
<table class="table table-sm table-bordered">
            <tr>
            <td rowspan="10" align="center"><?php
            if ($img) {
             echo Html::img($img->getImageUrl().$img->filename, 
            [
             'class' => 'img-thumbnail',
             'width' => '120',
             'width' => '120',
            ]);
                      }
            ?>
            </td>
            <td width="35%"><font size="2"><strong>Nama Penuh:</font></strong></td>
            <td><font size="2"><?= ucwords(strtolower($biodata->CONm)); ?></font></td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">No. KP / Pasport:</font></strong></td>
            <td><font size="2"><?= $biodata->ICNO; ?></font></td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">Umur:</font></strong></td>
            <td><font size="2"><?=  date("Y") - date("Y", strtotime($biodata->COBirthDt))." ". "Tahun" ?></font></td>
            </tr>
               
            <tr>
            <td width="35%"><strong><font size="2">Jawatan & Gred:</font></strong></td>
            <td><font size="2"><?=  ($biodata->jawatan->nama) ." ". ($biodata->jawatan->gred) ?></font></td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">Emel:</font></strong></td>
            <td><font size="2"><?=  ($biodata->COEmail)  ?></font></td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">Taraf Perkahwinan:</font></strong></td>
            <td><font size="2"><?= $biodata->displayTarafPerkahwinan; ?></font></td>
            </tr>
                
            <tr>
            <td width="35%"><strong><font size="2">Jabatan/Fakulti/Pusat/Institut:</font></strong></td>
            <td><font size="2"><?= ucwords(strtolower($biodata->displayDepartment)) ?></font></td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">No. Tel Bimbit:</font></strong></td>
            <td><font size="2"><?= ucwords(strtolower($biodata->COHPhoneNo)) ?></font></td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">Tarikh Lantikan:</font></strong></td>
            <td><font size="2"><?= ($biodata->displayStartLantik) ?></font></td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">Tarikh Disahkan Dalam Perkhidmatan:</font></strong></td>
            <td><font size="2">
            <?php if(!empty($biodata->confirmpengesahan->tarikhmula )):?>
            <?php echo $biodata->confirmpengesahan->tarikhmula ?></a>
            <?php endif;?></font></td>
            </tr>
</table>

            </div>
<!-- Maklumat Pendidikan -->

 <div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
       
        <div class="x_panel">
              <?php
                    $akademik = $biodata->akademik;
              if($akademik){ ?>
            <div class="x_title">
                <h6><strong><i class="fa fa-book"></i> Maklumat Akademik</strong></h6>
                
                
                <div class="clearfix"></div>
            </div>

 <div class="table-responsive">
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title"><font size="2">Bil</font></th>
                        <th class="column-title"><font size="2">Tahap Pendidikan</font> </th>
                        <th class="column-title"><font size="2">Bidang</font></th>
                        <th class="column-title"><font size="2">Universiti / Institusi</font></th>
                        <th class="column-title"><font size="2">Kelas / CGPA</font></th>
                        <th class="column-title"><font size="2">Tarikh Dianugerahkan</font></th>
                        <th class="column-title"><font size="2">Tajaan</font></th>
<!--                        <th class="column-title"><font size="2">Baki Ikatan Perkhidmatan</font></th>-->
                    </tr>

                </thead>
                <tbody>

                    <?php $bil=1; foreach ($akademik as $akademik) { ?>

                        <tr>

                            <td><font size="2"><?= $bil++ ?></font></td>
                            <td><font size="2"><?= $akademik->tahapPendidikan; ?></font></td>
                            <td><font size="2"><?= $akademik->namaMajor;?></font></td>
                            <td><font size="2"><?= $akademik->namainstitut;?></font></td>
                            <td><font size="2"><?= $akademik->OverallGrade;?></font></td>
                            <td><font size="2"><?= $akademik->confermentDt;?></font></td> 
                            <td><font size="2"><?= $akademik->Sponsorship;?></font></td>
<!--                            <td align="center"><font size="2"><?= $akademik->jumlahBon;?></font></td>-->
                        </tr>
                    <?php } ?>
                </tbody>

                     </table>
                </form>
            </div>

        </div>
           <?php } ?>
    </div>
</div>
   
<!-- < Maklumat Pengajian Yang Dipohon -->

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
             <?php
             if($pengajian){ ?>
            <div class="x_title">
                <h6><strong><i class="fa fa-graduation-cap"></i></i> Maklumat Pengajian Yang Dipohon</strong></h6>
                <div class="clearfix"></div>
            </div>

 <div class="table-responsive">
                <form id="w0" class="form-horizontal form-label-left" action="">

                    <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title">Bil</th>
                        <th class="column-title">Nama Universiti</th>
                        <th class="column-title">Negara</th>
                        <th class="column-title">Peringkat Pengajian </th>
                         <th class="column-title">Mod Pengajian </th>
                        <th class="column-title">Bidang </th>
                        <th class="column-title">Tarikh Mula Pengajian </th>
                        <th class="column-title">Tarikh Tamat Pengajian </th>
                        <th class="column-title">Tempoh Pengajian </th>
                        <th class="column-title">Tajuk Penyelidikan </th>
                        <th class="column-title">Nama Penyelia </th>
                       
                    </tr>

                </thead>
                <tbody>

                    <?php $bil=1; foreach ($pengajian as $pengajian) { ?>

                        <tr>

                            <td><?= $bil++ ?></td>
                            
                            <td><?= $pengajian->InstNm;?></td>
                            <td class="text-center"><?= $pengajian->negara->Country?></td>
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

      <?php } ?>

<!--  -->


<!-- < Maklumat Biasiswa -->

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
              <?php 
              if($biasiswa){ ?>
            <div class="x_title">
                <h6><strong><i class="fa fa-money"></i> Maklumat Pembiayaan / Pinjaman Yang Dipohon</strong></h6>
                <div class="clearfix"></div>
            </div>

 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title"><font size="2">Bil</font></th>
                        <th class="column-title"><font size="2">Nama Agensi / Tajaan</font> </th>
                        <th class="column-title"><font size="2">Bentuk Amaun</font></th>
                        <th class="column-title"><font size="2">Jumlah Amaun</font></th>
                       
                    </tr>

                </thead>
                <tbody>

                    <?php $bil=1; foreach ($biasiswa as $biasiswa) { ?>

                        <tr>

                            <td><font size="2"><?= $bil++ ?></font></td>
                            <td><font size="2"><?= $biasiswa->nama_tajaan; ?></font></td>
                            <td><font size="2"><?= $biasiswa->bantuan->bentukBantuan;?></font></td>
                            <td><font size="2">RM <?= $biasiswa->amaunBantuan;?></font></td>
                           
                            
                        
                        </tr>
                    <?php } ?>
                </tbody>

                     </table>

                </form>



            </div>
        </div>
    </div>
</div>

      <?php } ?>

      <!-- Maklumat Keluarga -->

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
            <?php
                    $keluarga = $biodata->keluarga;
              if($keluarga){ ?>
            <div class="x_title">
                <h6><strong><i class="fa fa-users"></i> Maklumat Keluarga</strong></h6>
                <div class="clearfix"></div>
            </div>

 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title"><font size="2">Bil</font></th>
                        <th class="column-title"><font size="2">Nama </font></th>
                        <th class="column-title"><font size="2">Hubungan</font></th>
                        <th class="column-title"><font size="2">No. Kad Pengenalan</font> </th>
                        <th class="column-title"><font size="2">Umur </font></th>
                       
                    </tr>

                </thead>
                <tbody>

                    <?php $bil=1; foreach ($keluarga as $keluarga) { 
                        if($keluarga->hubunganKeluarga->RelNm == "Isteri" || $keluarga->hubunganKeluarga->RelNm == "Isteri"){ ?>

                        <tr>

                            <td><font size="2"><?= $bil++ ?></font></td>
                            <td><font size="2"><?= $keluarga->FmyNm; ?></font></td>
                            <td><font size="2"><?= $keluarga->hubunganKeluarga->RelNm;?></font></td>
                            <td><font size="2"><?= $keluarga->FamilyId; ?></font></td>
                            <td><font size="2"><?=date("Y") - date("Y", strtotime($keluarga->FmyBirthDt))." " ."Tahun";?></font></td>
                            
                        
                        </tr>
                    <?php } }?>
                </tbody>

                     </table>

                </form>



            </div>

        </div>
    </div>


      <?php } ?>
</div>
      <!-- Dokumen Yang telah dimuatnaik-->

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
            
            <div class="x_title">
                <h6><strong><i class="fa fa-list-alt"></i> Senarai Dokumen Yang Telah Dimuatnaik</strong></h6>
                 
                <div class="clearfix"></div>
            </div>

        <div>
                <h6><strong><i class="fa fa-list-alt"></i>Dokumen Bagi Permohonan KPM</strong></h6>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center"><font size="2">Bil</font></th>
                        <th class="column-title text-center"><font size="2">Nama Dokumen </font></th>
                        
                    </tr>

                </thead>
                <tbody>

                   <?php
                    if ($dokumen2) {
                        $counter = 0;
                        foreach ($dokumen2 as $dokumen2) {
                            $counter = $counter + 1;
                            ?>

                            <tr>
                                <td class="text-center"><font size="2"><?= $counter; ?></font></td> 
                                
                                <td><font size="2"><?php if(!empty($dokumen2->dokumen->nama_dokumen)):?>
                                            
                                            <?php echo $dokumen2->dokumen->nama_dokumen ?></a>
<!--                                            <img src="<?= Url::to('@web/uploads'.$dokumen2->namafile, true);?>"/>-->
                                            <?php endif;?></font></td>
                              
                            </tr>
                            

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center">Tiada Dokumen Disertakan</td>                     
                        </tr>
<?php }
?>
                </tbody>

                     </table>

                </form>

            </div>
            
            <div class="x_title">
                 
                <div class="clearfix"></div>
            </div>

 <div>          <h6><strong><i class="fa fa-list-alt"></i> Dokumen Bagi Permohonan Pengajian Lanjutan</strong></h6>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center"><font size="2">Bil</font></th>
                        <th class="column-title text-center"><font size="2">Nama Dokumen </font></th>
                     
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
                                <td class="text-center" style="width:6%;"><font size="2"><?= $counter; ?></font></td> 
                                
                                <td><font size="2"><?php if(!empty($dokumen->dokumen->nama_dokumen)):?>
                                            
                                            <?php echo $dokumen->dokumen->nama_dokumen ?></a>
<!--                                            <img src="<?= Url::to('@web/uploads'.$dokumen->namafile, true);?>"/>-->
                                            <?php endif;?></font></td>
                                
                                
                                
                            </tr>
                            

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center">Tiada Dokumen Disertakan</td>                     
                        </tr>
<?php }
?>
                </tbody>

                     </table>

                </form>



 <div>          <h6><strong><i class="fa fa-list-alt"></i> Dokumen Bagi Permohonan Luar Negara</strong></h6>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center"><font size="2">Bil</font></th>
                        <th class="column-title text-center"><font size="2">Nama Dokumen </font></th>
                        
                     
                       
                    </tr>

                </thead>
                <tbody>

                   <?php
                    if ($dokumen3) {
                        $counter = 0;
                        foreach ($dokumen3 as $dokumen3) {
                            $counter = $counter + 1;
                            ?>

                            <tr>
                                <td class="text-center" style="width:6%;"><font size="2"><?= $counter; ?></font></td> 
                                
                                <td><font size="2"><?php if(!empty($dokumen3->dokumen->nama_dokumen)):?>
                                            
                                            <?php echo $dokumen3->dokumen->nama_dokumen ?></a>
<!--                                            <img src="<?= Url::to('@web/uploads'.$dokumen3->namafile, true);?>"/>-->
                                            <?php endif;?></font></td>
                                
                                
                                
                            </tr>
                            

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center">Tiada Dokumen Disertakan</td>                     
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

    
      
            <?php ActiveForm::end(); ?>
  
</div>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">  
     <div class="x_panel">
          <div class="x_title">
                   
               <center><strong><font size="2">Status Perakuan Ketua Jabatan</strong></center>
                     
                    <div class="clearfix"></div>
                </div>
     
    <table class="table table-sm table-bordered">

                   <tr>
                    <td width="15%"><font size="2"><strong>Status Perakuan:</strong></td>
                    <td><font size="2"><?= $model->status_jfpiu; ?></td>
                </tr>
                <tr>
                    <td><strong><font size="2">Ulasan:</strong></td>
                    <td><font size="2"><?= $model->ulasan_jfpiu ?></td>
                </tr>

                <tr>
                    <td><strong><font size="2">Tarikh Diperakukan:</strong></td>
                    <td><font size="2"><?= $model->tarikhkj ?></td>
                </tr>
                 
                
            </table>
</div>
  </div>
  </div>
 </div>

<p align="right"><font size="2">   <?php echo "[Tarikh Dicetak:"  .' '.date("Y-m-d").', '.  date("h:i:sa")."]";?></p>
