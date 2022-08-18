<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */
error_reporting(0);
$this->title = 'Permohonan Cuti Belajar'; 
?> 

  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<div class="x_panel">
        <div class="x_content">  
            <div class="row">
                
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['cutibelajar/halaman-utama-pemohon']) ?></li>
        <li>Pengakuan Pemohon</li>
    </ol>
</div>
         
            <span class="required" style="color:green;">
                Makluman:<br/>
                <strong>
                    <?= strtoupper('
    1. Sila pastikan Maklumat Peribadi, Maklumat Akademik, Maklumat Pengajian, Pembiayaan / Pinjaman, dan Maklumat Keluarga yang diisi adalah tepat dan benar. <br/>
    
    2. Manakala, Maklumat Pengajian dan Pembiayaan / Pinjaman boleh dikemaskini di pautan Maklumat Pengajian dan Pembiayaan / Pinjaman di bahagian Menu Pengajian Lanjutan. <br/>
    3. Sila semak status permohonan di Menu Semakan Permohonan dan pastikan tarikh permohonan adalah terkini.
 '); ?>
                </strong> 
            </span> 
        </div>
    </div>

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
<!--  <div class="row">

    <div class="col-xs-12 col-md-12 col-lg-12">
       
        <div class="x_panel">
           
          
                 <div class="x_title">
            <h4>UNIT PENGAJIAN LANJUTAN | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PERMOHONAN CUTI BELAJAR KAKITANGAN AKADEMIK</u></h4><br/>
            
           <p align ="right">
                    <?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>  
                </p>
                 
        
        </div>
    </div>
</div>
</div> -->
 <div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12" >
       
        <div class="x_panel">
            
            <div class="x_title">
                <h2><strong><i class="fa fa-user"></i> Maklumat Peribadi</strong></h2>
                <p align="right">
                <?php echo Html::a('<i class="fa fa-edit"></i>', ['biodata/userview'], ['class' => 'btn btn-success btn-sm', 'target'=>'_blank']); ?>
                
                </p>


                
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
                          echo Html::a('<i class="fa fa-edit"></i>', ['cbelajar/gambar', 'id'=> $iklan->id], ['class' => 'btn btn-success btn-sm', 'target'=>'_blank']);
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
                            <th class="col-md-2 col-sm-3 col-xs-12 text-right">No. Kad Pengenalan: </th><td><?=  ($biodata->ICNO) ?></td>  <th class="col-md-2 col-sm-3 col-xs-12 text-left">Umur: </th><td><?=date("Y") - date("Y", strtotime($biodata->COBirthDt))." ". "Tahun"?></td> 
                        </tr>
                        <tr>
                            <th class="col-md-2 col-sm-3 col-xs-12 text-right">Tarikh Lantikan: </th><td><?=  ($biodata->displayStartLantik) ?></td>  

                           

                               <th class="col-md-2 col-sm-3 col-xs-12 text-left">Tarikh Disahkan Dalam Perkhidmatan: </th>
                           <td>
                               <?php if(!empty($biodata->confirmpengesahan->tarikhmula )):?>
                                    <?php echo $biodata->confirmpengesahan->tarikhmula ?></a>
                                          
                                            <?php endif;?>
                           </td>
                        </tr>
                    </table>
                </div>
            </div>
    


 

<!-- Maklumat Pendidikan -->

 <div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
              <?php if($model){ ?>
            <div class="x_title">
                <h2><strong><i class="fa fa-book"></i> Maklumat Akademik</strong></h2>
                <p align="right">
                <?php echo Html::a('<i class="fa fa-edit"></i>', ['pendidikan/view'], ['class' => 'btn btn-success btn-sm', 'target'=>'_blank']); ?>
                
                </p>
                <div class="clearfix"></div>
            </div>

 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center" >Bil</th>
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

                            <td class="text-center" style="width:5%;"><?= $bil++ ?></td>
                            <td><?= $akademik->tahapPendidikan; ?></td>
                            <td><?= $akademik->namaMajor;?></td>
                            <td><?= $akademik->namainstitut;?></td>
                            <td><?= $akademik->OverallGrade;?></td>
                            <td><?= $akademik->confermentDt;?></td> 
                            <td><?= $akademik->namaPenaja;?></td>
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





<!-- < Maklumat Pengajian Yang Dipohon -->

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
             <?php
                  
             if($pengajian){ ?>
            <div class="x_title">
                <h2><strong><i class="fa fa-graduation-cap"></i></i> Maklumat Pengajian Yang Dipohon</strong></h2>
                 <p align="right">
                <?php echo Html::a('<i class="fa fa-edit"></i>', ['cbelajar/maklumat-pengajian', 'id' => $iklan->id], ['class' => 'btn btn-success btn-sm', 'target'=>'_blank']); ?>
                
                </p>
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

                            <td class="text-center" style="width:5%;"><?= $bil++ ?></td>
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

      <?php } ?>

<!--  -->


<!-- < Maklumat Biasiswa -->

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
              <?php if($biasiswa){ ?>
            <div class="x_title">
                <h2><strong><i class="fa fa-money"></i> Maklumat Pembiayaan / Pinjaman Yang Dipohon</strong></h2>
                 <p align="right">
                <?php echo Html::a('<i class="fa fa-edit"></i>', ['cbelajar/maklumat-biasiswa', 'id' => $iklan->id], ['class' => 'btn btn-success btn-sm', 'target'=>'_blank']); ?>
                
                </p>
                <div class="clearfix"></div>
            </div>

 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center">Bil</th>
                        <th class="column-title">Nama Agensi / Tajaan </th>
                        <th class="column-title">Bentuk Amaun</th>
                        <th class="column-title">Jumlah Amaun (RM)</th>
                       
                    </tr>

                </thead>
                <tbody>

                    <?php $bil=1; foreach ($biasiswa as $biasiswa) { ?>

                        <tr>

                            <td class="text-center" style="width:5%;"><?= $bil++ ?></td>
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
    </div>      <?php } ?>
</div>




<!-- Maklumat Keluarga -->

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
              <?php if($keluarga){ ?>
            <div class="x_title">
                <h2><strong><i class="fa fa-users"></i> Maklumat Keluarga</strong></h2>
                 <p align="right">
                <?php echo Html::a('<i class="fa fa-edit"></i>', ['keluarga/view', 'id'=> $iklan->id], ['class' => 'btn btn-success btn-sm', 'target'=> '_blank']); ?>
                
                </p>
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
                    if($keluarga->hubunganKeluarga->RelNm == "Isteri" || $keluarga->hubunganKeluarga->RelNm == "Anak Kandung" || $keluarga->hubunganKeluarga->RelNm == "Suami"){?>


                        <tr>

                            <td class="text-center" style="width:5%;"><?= $bil++ ?></td>
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

      <?php } ?>

<!-- Dokumen Yang telah dimuatnaik-->

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
              <?php if($dokumen){ ?>
            <div class="x_title">
                <h2><strong><i class="fa fa-list-alt"></i> Dokumen Yang Telah Dimuatnaik </strong></h2>
                 <p align="right">
                <?php echo Html::a('<i class="fa fa-edit"></i>', ['cbelajar/senarai-dokumen', 'id'=>$iklan->id], ['class' => 'btn btn-success btn-sm', 'target'=>'_blank']); ?>
                
                </p>
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
                                            
                                            <a href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($dokumen2->namafile), true); ?>" target="_blank"/> <u>
                                                <?php echo $dokumen2->dokumen->nama_dokumen ?>
<!--                                            <img src="<?= Url::to('@web/uploads'.$dokumen2->namafile, true);?>"/>-->
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
                                   

                                  <?= Html::a('<i class="fa fa-download" aria-hidden="true"></i>',['uploads/', 'namafile' => $dokumen3->namafile] , ['class' => 'btn btn-default', 'target'=>"_blank"]) ?> 
                                 
                                    
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

</div>
 </div>


<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $view;?>"> 
    <div class="x_panel">
 <div class="form-group">
      <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Perakuan Pemohon</strong></h2>
           
            <div class="clearfix"></div>
        </div>
  <div class="col-sm-12 text-center">
    
    <table>
        <tr>
            <td class="col-sm-3 text-right">
                <?php $model->agree = 1; ?>
                <br><?= $form->field($model, 'agree')->checkbox(['disabled' => true])->label(false); ?> <p>&nbsp;&nbsp;</p>
            </td>

            <td> 
                <div style="width: 800px; height: 90px;border:2px solid red">
             <h5 style="color:light grey;" >Saya mengaku  semua keterangan di atas adalah benar dan jika saya didapati memberi <br/>
                    maklumat palsu, saya bersetuju permohonan ini (jika telah diluluskan) 
                    akan terbatal dengan sendirinya dan boleh diambil tindakan perundangan. </h5>
                    <p style="color:light grey;">Tarikh Mohon: <?php echo $model->tarikhmohon;?></p><br/>
                      
            </div>
            </td>
        </tr>
    </table>
     <br/>
     <div class="col-sm-12 text-center">
          
        <div class="col-md-12 col-sm-12 col-xs-12" align="center"> 
            <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar1', 'value' => 'submit_2']) ?>
            <?= Html::a('Keluar', ['cutibelajar/halaman-utama-pemohon'], ['class' => 'btn btn-danger ']);?>
     
        </div>
    </div>
 </div>
</div>
</div>     
</div>
</div>
 <div class="row">
 
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $edit;?>"> 
    <div class="x_panel">
         <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Perakuan Pemohon</strong></h2>
           
            <div class="clearfix"></div>
        </div>
        <div class="form-group">
 <div class="col-sm-12 text-center">
    
    <table>
        <tr>
            <td class="col-sm-3 text-right">
                <?php // $model->agree = 1; ?>
                                <br><input type="checkbox"  id="checkbox1" class="default-input sale-text-req" onclick="checkTerms();"/>

<!--                <br>//<?= $form->field($model, 'agree')->checkbox()->label(false); ?> <p>&nbsp;&nbsp;</p>-->
            </td>

            <td> 
                <div style="width: 800px; height: 90px;border:2px solid red">
             <h5 style="color:black;" >Saya mengaku  semua keterangan di atas adalah benar dan jika saya didapati memberi <br/>
                    maklumat palsu, saya bersetuju permohonan ini (jika telah diluluskan) 
                    akan terbatal dengan sendirinya dan boleh diambil tindakan perundangan. </h5>
                    <p style="color:black;">Tarikh Mohon: <?php echo $model->tarikhmohon;?></p><br/>
                      
            </div>
            </td>
        </tr>
    </table>
     <br/>
     <div class="col-sm-12 text-center">
          
        <div class="col-md-12 col-sm-12 col-xs-12" align="center"> 
            <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1']) ?>
            <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['id'=> 'submitb', 'disabled'=> true, 'class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2']) ?>
            <?= Html::a('Keluar', ['cutibelajar/halaman-utama-pemohon'], ['class' => 'btn btn-danger ']);?>
     
        </div>
    </div>
 </div>
</div>
    </div>
</div>
        

    </div>
        <?= $form->field($model, 'icno')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>
        <?= $form->field($model, 'iklan_id')->hiddenInput(['value' => $iklan->id])->label(false); ?>
        <?= $form->field($model, 'kali_ke')->hiddenInput(['value' => $iklan->kali_ke])->label(false); ?> 
        <?= $form->field($model, 'tarikh_mesyuarat')->hiddenInput(['value' => $iklan->tarikh_mesyuarat])->label(false); ?>  
        <?= $form->field($model, 'HighestEduLevelCd')->hiddenInput(['value' => $pengajian->HighestEduLevelCd])->label(false); ?>
        <?= $form->field($model, 'CountryCd')->hiddenInput(['value' => $pengajian->CountryCd])->label(false); ?>
        <?= $form->field($model, 'InstNm')->hiddenInput(['value' => $pengajian->InstNm])->label(false); ?>
        <?= $form->field($model, 'modeID')->hiddenInput(['value' => $pengajian->modeID])->label(false); ?>
        <?= $form->field($model, 'tarikh_mula')->hiddenInput(['value' => $pengajian->tarikh_mula])->label(false); ?>
        <?= $form->field($model, 'tarikh_tamat')->hiddenInput(['value' => $pengajian->tarikh_tamat])->label(false); ?>
        <?= $form->field($model, 'BantuanCd')->hiddenInput(['value' => $biasiswa->BantuanCd])->label(false); ?>




<!-- -->
                <!-- --> 
       

    </div>
    </div>
  
     <?php ActiveForm::end(); ?>
    </div> 


<script>
                function checkTerms() {
                  // Get the checkbox
                  var checkBox = document.getElementById("checkbox1");

                  // If the checkbox is checked, display the output text
                  if (checkBox.checked === true){
                    document.getElementById("submitb").disabled = false;
                  } else {
                    document.getElementById("submitb").disabled = true;
                  }
                }
                    </script>

