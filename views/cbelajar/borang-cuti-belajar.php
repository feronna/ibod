<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Permohonan Cuti Belajar'; 
?> 
 <?php echo $this->render('/cbelajar/menu'); ?>

 <div class="x_panel">
        <div class="x_content">  
 <div class="row">

    <div class="col-xs-12 col-md-12 col-lg-12">
       
        <div class="x_panel">
           
          
                 <div class="x_title">
            <center><h2> UNIT PENGAJIAN LANJUTAN | SEKTOR PEMBANGUNAN SUMBER MANUSIA</h2></center>
           <p align ="right">
                    <?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>  
                </p>
                   <div></div>
        
        </div>

  <div class="x_title">
                <h2><strong><i class="fa fa-user"></i> Maklumat Peribadi</strong></h2>
                
                <div class="clearfix"></div>
            </div>

             <div class="table-responsive">
                    <table class="table table-sm jambo_table table-striped"> 
                        <tr>
                            <th class="col-md-2 col-sm-3 col-xs-12 text-right">Nama Penuh: </th><td><?=  ucwords(strtolower($biodata->CONm)) ?></td> <td> </td> <td> </td> 
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
                            <th class="col-md-2 col-sm-3 col-xs-12 text-right">Tarikh Lantikan: </th><td><?=  ($biodata->startDateLantik) ?></td>  <th class="col-md-2 col-sm-3 col-xs-12 text-left">Tarikh Disahkan Dalam Perkhidmatan: </th><td><?=($biodata->startDateLantik)?></td> 
                        </tr>
                    </table>
                </div>
            </div>
    


 

<!-- Maklumat Pendidikan -->

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
                        <th class="column-title">Bil</th>
                        <th class="column-title">Kelayakan </th>
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
                            <td><?= $akademik->ConfermentDt;?></td> 
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

<!-- < Maklumat Pengajian Yang Dipohon -->

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
              <?php if($pengajian){ ?>
            <div class="x_title">
                <h2><strong><i class="fa fa-users"></i> Maklumat Pengajian</strong></h2>
                <div class="clearfix"></div>
            </div>

 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title">Bil</th>
                        <th class="column-title">Tempat </th>
                        <th class="column-title">Nama Universiti</th>
                       
                        <th class="column-title">Peringkat Pengajian </th>
                        <th class="column-title">Bidang </th>
                        <th class="column-title">Tarikh Mula Kursus </th>
                        <th class="column-title">Tarikh Tamat Kursus </th>
                        <th class="column-title">Tajuk Tesis </th>
                        <th class="column-title">Nama Penyelia </th>
                       
                    </tr>

                </thead>
                <tbody>

                    <?php $bil=1; foreach ($pengajian as $pengajian) { ?>

                        <tr>

                            <td><?= $bil++ ?></td>
                            <td><?= $pengajian->alamatUniversiti; ?></td>
                            <td><?= $pengajian->institut->InstNm;?></td>
                       
                            <td><?= $pengajian->pendidikanTertinggi->HighestEduLevel;?></td>
                            <td><?= $pengajian->major->MajorMinor; ?></td>
                            <td><?= $pengajian->tarikh_mula; ?></td>
                            <td><?= $pengajian->tarikh_tamat; ?></td>
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
    </div></div>

      <?php } ?>
</div>

<!--  -->

<!-- Maklumat Keluarga -->

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
                            <td><?= ucwords(strtoupper($keluarga->FmyNm)); ?></td>
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

    </div>           


</div>
</div>