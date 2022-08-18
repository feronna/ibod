<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Permohonan Cuti Belajar'; 
?> 

  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
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
                            echo Html::img($img->getImageUrl(), [
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
                        <th class="column-title">Bil</th>
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

                            <td><?= $bil++ ?></td>
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
                    $pengajian = $biodata->pengajian;
             if($pengajian){ ?>
            <div class="x_title">
                <h2><strong><i class="fa fa-graduation-cap"></i></i> Maklumat Pengajian</strong></h2>
                 <p align="right">
                <?php echo Html::a('<i class="fa fa-edit"></i>', ['cbelajar/maklumat-pengajian'], ['class' => 'btn btn-success btn-sm', 'target'=>'_blank']); ?>
                
                </p>
                <div class="clearfix"></div>
            </div>

 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title">Bil</th>
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

                            <td><?= $bil++ ?></td>
                            
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
                <h2><strong><i class="fa fa-money"></i> Maklumat Pembiayaan / Pinjaman</strong></h2>
                 <p align="right">
                <?php echo Html::a('<i class="fa fa-edit"></i>', ['cbelajar/maklumat-biasiswa'], ['class' => 'btn btn-success btn-sm', 'target'=>'_blank']); ?>
                
                </p>
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
                        <th class="column-title">Jumlah Amaun</th>
                       
                    </tr>

                </thead>
                <tbody>

                    <?php $bil=1; foreach ($biasiswa as $biasiswa) { ?>

                        <tr>

                            <td><?= $bil++ ?></td>
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
                <?php echo Html::a('<i class="fa fa-edit"></i>', ['keluarga/view'], ['class' => 'btn btn-success btn-sm', 'target'=> '_blank']); ?>
                
                </p>
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

                    <?php $bil=1; foreach ($keluarga as $keluarga) { ?>

                        <tr>

                            <td><?= $bil++ ?></td>
                            <td><?= $keluarga->FmyNm; ?></td>
                            <td><?= $keluarga->hubunganKeluarga->RelNm;?></td>
                            <td><?= $keluarga->FamilyId; ?></td>
                            <td><?=date("Y") - date("Y", strtotime($keluarga->FmyBirthDt))." " ."Tahun";?></td>
                            
                        
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

<!-- Dokumen Yang telah dimuatnaik-->

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
              <?php if($dokumen){ ?>
            <div class="x_title">
                <h2><strong><i class="fa fa-list-alt"></i> Dokumen Yang Dimuatnaik</strong></h2>
                 <p align="right">
                <?php echo Html::a('<i class="fa fa-edit"></i>', ['cbelajar/senarai-dokumen'], ['class' => 'btn btn-success btn-sm', 'target'=>'_blank']); ?>
                
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
<!--                                            <img src="<?= Url::to('@web/uploads'.$dokumen->namafile, true);?>"/>-->
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

</div>



<br/>

    <div class="form-group"> 
    <div class="col-sm-12 text-center">
          
        <div class="col-md-12 col-sm-12 col-xs-12" align="center"> 
            <?= Html::a('<i class="fa fa-floppy-o"></i> Simpan', ['simpan-permohonan'], ['class' => 'btn btn-primary']); ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary btn-md', 'name' => 'hantar', 'value' => 'submit_2']) ?>
                </div>
    </div>
    </div>
        <?= $form->field($model, 'icno')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>
       

<!-- -->
                <!-- --> 
       

    </div>
   
  
     <?php ActiveForm::end(); ?>
  




