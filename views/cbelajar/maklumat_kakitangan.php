<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 

error_reporting(0);
$this->title = 'Permohonan Cuti Belajar'; 
?> 


<div class="x_panel">
        <div class="x_content">  
            <div class="row">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['cutibelajar/laporan']) ?></li>
        <li>Maklumat Pemohon</li>
    </ol>
</div>
            
               <div class="pull-right">
                <?php 
                echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Borang', ['/cutibelajar/generate-permohonan', 'id' =>$model->id, 'ICNO'=>$model->icno, 'takwim_id'=>$model->iklan_id ], [
                    'class'=>'btn btn-primary btn-sm', 
                    'target'=>'_self', 
                    'data-toggle'=>'tooltip', 
                    'title'=>'Borang Permohonan Pengajian Lanjutan'
                ]);
                ?>
    </div> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

 <div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
       
    <div class="x_panel">
        <div class="x_content"> 
              
            <span class="required" style="color:black;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGAJIAN LANJUTAN | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PERMOHONAN PENGAJIAN LANJUTAN KAKITANGAN AKADEMIK
 '); ?>
                        
                </strong> </center>
            </span> 
        </div>
    </div>
           <div class="x_panel">
            
            <div class="x_title">
                <h2><strong><i class="fa fa-user"></i> Maklumat Peribadi</strong></h2>
               


                
                <div class="clearfix"></div>
            </div>
             <div class="table-responsive">
                    <table class="table table-sm jambo_table table-striped"> 
                   <tr>
                        <td rowspan="6" align="right"><?php
                        if ($img) {
                            echo Html::img($img->getImageUrl().$img->filename, [
                                'class' => 'img-thumbnail',
                                'width' => '150',
                                'width' => '150',
                            ]);
                        }
                        ?></td>
                            <th class="col-md-2 col-sm-3 col-xs-12 text-right">Nama Penuh: </th><td><?=  ucwords(strtolower($biodata->CONm)) ?></td><th class="col-md-2 col-sm-3 col-xs-12 text-left">Taraf Perkahwinan: </th><td><?=  ($biodata->displayTarafPerkahwinan) ?></td>
                        </tr>
                         <tr>
                            <th class="col-md-2 col-sm-3 col-xs-12 text-right">Jabatan/Fakulti/Pusat/Institut: </th><td><?=  ucwords(strtolower($biodata->displayDepartment)) ?></td>  <th class="col-md-2 col-sm-3 col-xs-12 text-left">No. Tel Bimbit: </th><td><?=  ucwords(strtolower($biodata->COHPhoneNo)) ?></td> 
                        </tr>
                        <tr>
                            <th class="col-md-2 col-sm-3 col-xs-12 text-right">Jawatan & Gred: </th><td><?=  ($biodata->jawatan->nama) ." ". ($biodata->jawatan->gred) ?></td>  <th class="col-md-2 col-sm-3 col-xs-12 text-left">Emel: </th><td><?= ($biodata->COEmail) ?></td> 
                        </tr>
                         <tr>
                            <th class="col-md-2 col-sm-3 col-xs-12 text-right">No. Kad Pengenalan: </th><td><?=  ($biodata->ICNO) ?></td>  <th class="col-md-2 col-sm-3 col-xs-12 text-left">Umur: </th>                    <td><?=date("Y") - date("Y", strtotime($biodata->COBirthDt))." ". "Tahun"?></td> 
                        </tr>
                        <tr>
                            <th class="col-md-2 col-sm-3 col-xs-12 text-right">Tarikh Lantikan: </th><td><?=  ($biodata->displayStartLantik) ?></td>  

                          
                           <th class="col-md-2 col-sm-3 col-xs-12 text-left">Tarikh Disahkan Dalam Perkhidmatan: </th>
                           <td>
                               <?php if(!empty($biodata->confirmpengesahan->tarikhmula )):?>
                                    <?php echo $biodata->confirmpengesahan->tarikhmula ?></a>
                                          
                                            <?php endif;?>
                           </td>
                           
                     
                    </table>
                </div>
            </div>
    


 

<!-- Maklumat Pendidikan -->

 <div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
       
        <div class="x_panel">
              <?php
                    $akademik = $biodata->akademik;
              if($akademik){ ?>
            <div class="x_title">
                <h2><strong><i class="fa fa-book"></i> Maklumat Akademik</strong></h2>
                
                
                <div class="clearfix"></div>
            </div>

 <div class="table-responsive">
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title">Bil</th>
                        <th class="column-title">Tahap Pendidikan </th>
                        <th class="column-title">Bidang</th>
                        <th class="column-title">Universiti / Institusi</th>
                        <th class="column-title">Kelas / CGPA</th>
                        <th class="column-title">Tarikh Dianugerahkan</th>
                        <th class="column-title">Tajaan</th>
                        <th class="column-title">Baki Ikatan Perkhidmatan</th>
                    </tr>

                </thead>
                <tbody>

                    <?php $bil=1; foreach ($akademik as $akademik) { ?>

                        <tr>

                            <td><?= $bil++ ?></td>
                            <td><?= $akademik->tahapPendidikan; ?></td>
                            <td><?= $akademik->namaMajor;?></td>
                            <td><?= $akademik->namainstitut;?></td>
                            <td><?= $akademik->OverallGrade;?></td>
                            <td><?= $akademik->confermentDt;?></td> 
                            <td><?= $akademik->Sponsorship;?></td>
                            <td align="center"><?= $akademik->jumlahBon;?></td>
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
                <h2><strong><i class="fa fa-graduation-cap"></i></i> Maklumat Pengajian Yang Dipohon</strong></h2>
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
                <h2><strong><i class="fa fa-money"></i> Maklumat Pembiayaan / Pinjaman Yang Dipohon</strong></h2>
                <div class="clearfix"></div>
            </div>

 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title">Bil</th>
                        <th class="column-title">Nama Agensi / Tajaan </th>
                        <th class="column-title">Bentuk Amaun</th>
                        <th class="column-title">Jumlah Amaun (RM)</th>
                       
                    </tr>

                </thead>
                <tbody>

                    <?php $bil=1; foreach ($biasiswa as $biasiswa) { ?>

                        <tr>

                            <td><?= $bil++ ?></td>
                            <td><?= $biasiswa->nama_tajaan; ?></td>
                            <td><?= $biasiswa->bantuan->bentukBantuan;?></td>
                            <td>RM <?= $biasiswa->amaunBantuan;?></td>
                           
                            
                        
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
                <h2><strong><i class="fa fa-users"></i> Maklumat Keluarga</strong></h2>
                <div class="clearfix"></div>
            </div>

 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title">Bil</th>
                        <th class="column-title">Nama </th>
                        <th class="column-title">Hubungan</th>
                        <th class="column-title">No. Kad Pengenalan </th>
                        <th class="column-title">Umur </th>
                       
                    </tr>

                </thead>
                <tbody>

                    <?php $bil=1; foreach ($keluarga as $keluarga) { 
                        if($keluarga->hubunganKeluarga->RelNm == "Isteri" || $keluarga->hubunganKeluarga->RelNm == "Anak Kandung"){?>

                        <tr>

                            <td><?= $bil++ ?></td>
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


      <?php } ?>
</div>
      <!-- Dokumen Yang telah dimuatnaik-->

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
              <?php if($dokumen){ ?>
            <div class="x_title">
                <h2><strong><i class="fa fa-list-alt"></i> Dokumen Yang Telah Dimuatnaik </strong></h2>
                
                <div class="clearfix"></div>
            </div>

 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">
<table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center">Bil</th>
                        <th class="column-title text-center">Nama Dokumen </th>
                        
                        
                       
                    </tr>

                </thead>
                <tbody>
 <h5><strong>DOKUMEN BAGI PERMOHONAN KPM</strong></h5>
                   <?php
                    if ($dokumen2) {
                        $counter = 0;
                        foreach ($dokumen2 as $dokumen2) {
                            $counter = $counter + 1;
                            ?>

                            <tr>
                                <td class="text-center"><?= $counter; ?></td> 
                                
                                <td><?php if((!empty($dokumen2->dokumen->nama_dokumen))&& (!empty($dokumen2->namafile))):?>
                                            
                                            <a href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($dokumen2->namafile), true); ?>" target="_blank"/> <u><?php echo $dokumen2->dokumen->nama_dokumen ?>
<!--                                            <img src="<?= Url::to('@web/uploads'.$dokumen2->namafile, true);?>"/>-->
                                            <?php endif;?></u>
                      
                                            
                                         
                                      </td>
                                


<!--                                <td class="text-center">
                                <td class="text-center">
                                   

                                  <?= Html::a('<i class="fa fa-download" aria-hidden="true"></i>',['uploads/', 'namafile' => $dokumen2->namafile] , ['class' => 'btn btn-default', 'target'=>"_blank"]) ?> 
                                 
                                    
                                  </td>  -->
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
                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center">Bil</th>
                        <th class="column-title text-center">Nama Dokumen </th>
                        
                        
                       
                    </tr>

                </thead>
                <tbody>
                  <h5><strong>DOKUMEN BAGI PERMOHONAN PENGAJIAN LANJUTAN</strong></h5>

                   <?php
                    if ($dokumen) {
                        $counter = 0;
                        foreach ($dokumen as $dokumen) {
                            $counter = $counter + 1;
                            ?>

                            <tr>
                                <td class="text-center" style="width:5%;"><?= $counter; ?></td> 
                                
                                <td><?php if((!empty($dokumen->dokumen->nama_dokumen))&& (!empty($dokumen->namafile))):?>
                                            
                                            <a href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($dokumen->namafile), true); ?>" target="_blank"/> <u><?php echo $dokumen->dokumen->nama_dokumen ?>
<!--                                            <img src="<?= Url::to('@web/uploads'.$dokumen->namafile, true);?>"/>-->
                                            <?php endif;?></u>
                      
                                            
                                         
                                      </td>
<!--                                       <td class="text-center">
                                     <i class="fa fa-check-circle " aria-hidden="true" style="color: green"></i>
                                        </td>-->
                                


<!--                                <td class="text-center">
                                <td class="text-center">
                                   

                                  <?= Html::a('<i class="fa fa-download" aria-hidden="true"></i>',['uploads/', 'namafile' => $dokumen->namafile] , ['class' => 'btn btn-default', 'target'=>"_blank"]) ?> 
                                 
                                    
                                  </td>  -->
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

 <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center">Bil</th>
                        <th class="column-title text-center">Nama Dokumen </th>
                        
                        
                       
                    </tr>

                </thead>
                <tbody>
                  <h5><strong>DOKUMEN BAGI PERMOHONAN LUAR NEGARA</strong></h5>

                   <?php
                    if ($dokumen3) {
                        $counter = 0;
                        foreach ($dokumen3 as $dokumen3) {
                            $counter = $counter + 1;
                            ?>

                            <tr>
                                <td class="text-center" style="width:5%;"><?= $counter; ?></td> 
                                
                                <td><?php if((!empty($dokumen3->dokumen->nama_dokumen))&& (!empty($dokumen3->namafile))):?>
                                            
                                            <a href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($dokumen3->namafile), true); ?>" target="_blank"/> <u><?php echo $dokumen3->dokumen->nama_dokumen ?>
<!--                                            <img src="<?= Url::to('@web/uploads'.$dokumen3->namafile, true);?>"/>-->
                                            <?php endif;?></u>
                      
                                            
                                         
                                      </td>
                                


<!--                                <td class="text-center">
                                <td class="text-center">
                                   

                                  <?= Html::a('<i class="fa fa-download" aria-hidden="true"></i>',['uploads/', 'namafile' => $dokumen->namafile] , ['class' => 'btn btn-default', 'target'=>"_blank"]) ?> 
                                 
                                    
                                  </td>  -->
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

      <?php } ?>



<!--  -->


<div class="col-xs-12 col-md-12 col-lg-12"> 
<div class="row" > 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Status Perakuan Ketua Jabatan</strong></h2>
           
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
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
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->tarikhkj;?>" disabled="disabled">
                </div>
            </div>
        </div>
    </div>
</div>
    
    
        

            <?php ActiveForm::end(); ?>
    </div>
</div>

