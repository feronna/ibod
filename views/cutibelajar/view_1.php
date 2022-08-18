<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Maklumat Dan Rekod Kakitangan';
error_reporting(0);
?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
<?php echo $this->render('/cutibelajar/_topmenu'); ?>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <p align="right">  <?= Html::a('Kembali', ['cutibelajar/index'], ['class' => 'btn btn-primary btn-sm']) ?></p>

            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            <div class="row text-center" >
                <div class="col-lg-1 col-sm-3 col-xs-12 text-center">
                    <div class="col-lg-1 col-md-1 col-xs-12 text-center" rowspan="6" valign="top"><span><img height='100px' width="80px" src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(hash('sha1', $model->ICNO)); ?>.jpeg"></span></div>
                </div>
                <div class="col-lg-11 col-sm-9 col-xs-12" >
                    <div class="row">
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>Nama:</b></div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 text-left" ><?= $model->gelaran->Title ." ". ucwords(strtolower($model->CONm)) ?></div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>No. KP / Paspot:</b></div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 text-left "><?= $model->ICNO ?></div>
                    </div>
                    <div class="row ">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jabatan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= ucwords(strtolower($model->department->fullname)) ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Kampus Cawangan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left " ><?= ucwords(strtolower($model->kampus->campus_name)) ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>UMSPER:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->COOldID ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jawatan Disandang:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->jawatan->nama . " (" . $model->jawatan->gred . ")"; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Sandangan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->statusSandangan->sandangan_name ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Sandangan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStartSandangan ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Jawatan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->statusLantikan->ApmtStatusNm ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tempoh Lantikan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStartLantik ?> hingga <?= $model->tarikhbersara?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Pekerja:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><span><?= $model->Status ? $model->serviceStatus->ServStatusNm : 'Not Set' ?></span></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Status:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStartDateStatus ?></div>
                    </div>
                </div>
            </div> </br>

            <div class="well well-lg"> 
                <div class="row ">
                
<div class="x_content"> 


            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <?php
                    $resume = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'address-card',
                                        'header' => 'Rekod',
                                        'text' => 'Permohonan Baharu Pengajian Lanjutan',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($resume, ['pemohonview?id='.$model->ICNO.'&page=rekod-cuti-belajar']);
        
                    ?>

                </div>
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'clock-o',
                                        'header' => 'Rekod ',
                                        'text' => 'Tempoh Cuti Belajar',
                                        'number' => '2',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['pemohonview?id='.$model->ICNO.'&page=rekod-lanjutan-tempoh']);
                    ?>
                </div>

                 <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'book',
                                        'header' => 'Rekod',
                                        'text' => 'Laporan Kemajuan Kursus (LKK)',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($semakan, ['pemohonview?id='.$model->ICNO.'&page=rekod-lkk']);
                    ?>
           </div>
                
            
                
               
       </div>
<div class="row">
                <div class="col-xs-12 col-md-4">
                    <?php
                    $resume = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'th-list',
                                        'header' => 'Rekod',
                                        'text' => 'Lain - Lain Permohonan',
                                        'number' => '4',
                                    ]
                    );
                    echo Html::a($resume, ['pemohonview?id='.$model->ICNO.'&page=rekod-lain-permohonan']);
        
                    ?>

                </div>
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'plane',
                                        'header' => 'Rekod',
                                        'text' => 'Permohonan Tempahan Tiket Penerbangan',
                                        'number' => '5',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['pemohonview?id='.$model->ICNO.'&page=rekod-tempahan-tiket']);
                    ?>
                </div>

                 <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'suitcase',
                                        'header' => 'Rekod',
                                        'text' => 'Lapor Diri',
                                        'number' => '6',
                                    ]
                    );
                    echo Html::a($semakan, ['pemohonview?id='.$model->ICNO.'&page=rekod-lapor-diri']);
                    ?>
           </div>
                
            
                
               
       </div>
                


        </div>
                    
                   
    </tbody>


   </div>
            </div>
               </div>
</div>
</div>
        <?php    
if (isset($_GET['page'])) {
if ($_GET['page'] == "rekod-cuti-belajar") {
    ?>
<div class="row"><div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="col-md-12 col-sm-12 col-xs-12 "> 

<div class="x_panel">

<div class="x_title">
   <h2><strong><i class="fa fa-book"></i> Permohonan Pengajian Lanjutan</strong></h2>
   <div class="clearfix"></div>
</div>
 <div>
<form id="w0" class="form-horizontal form-label-left" action="">
   <table class="table table-bordered jambo_table">
   <thead>
        <tr class="headings">
            <th class="column-title text-center">Bil</th>
            <th class="column-title">Peringkat Pengajian </th>
            <th class="column-title">Bidang</th>
            <th class="column-title">Universiti / Institusi</th>
            <th class="column-title">Tajaan</th>
            <th class="column-title">Tarikh Mohon</th>
            <th class="column-title">Tindakan</th>
        </tr>

    </thead>
    <tbody>
         <?php if(!$akademik){ ?>
        <?php $bil=1; foreach ($akademik as $akademik) { ?>
        <tr>
            <td class="text-center"><?= $bil++ ?></td>
            <td><?= $akademik->tahappendidikan; ?></td>
            <td><?= $akademik->major->namamajor; ?></td>
            <td><?= $akademik->InstNm; ?></td>
            <td><?= $akademik->tajaan; ?></td>
            <td><?= $akademik->tarikhmohon; ?></td>
            <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',  ["cutisabatikal/lihat-permohonan",  'id'=>$akademik->id, 'ICNO'=>$akademik->icno, 'takwim_id'=>$akademik->iklan_id]) ?> | <?= Html::a('<i class="fa fa-print" aria-hidden="true"></i>', ['adminview','id'=>$model->ICNO]) ?> </td>  

        </tr>
<?php }} else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>


 </table>
</form>           </div> <!-- div for row-->
            </div> <!-- div for well-->

    </div>
                 
</div>
</div>
<?php }

 else if ($_GET['page'] == "rekod-lanjutan-tempoh") {?>
<div class="row"><div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="col-md-12 col-sm-12 col-xs-12 "> 

<div class="x_panel">

<div class="x_title">
   <h2><strong><i class="fa fa-book"></i> Permohonan Tempoh Lanjutan Cuti Belajar</strong></h2>
   <div class="clearfix"></div>
</div>
 <div>
<form id="w0" class="form-horizontal form-label-left" action="">
   <table class="table table-bordered jambo_table">
   <thead>
        <tr class="headings">
            <th class="column-title text-center">Bil</th>
            <th class="column-title">Peringkat Pengajian </th>
            <th class="column-title">Institut Pengajian</th>
            <th class="column-title">Bidang</th>
            <th class="column-title">Mod Pengajian</th>
            <th class="column-title">Tarikh Mohon</th>
            <th class="column-title">Tindakan</th>
        </tr>

    </thead>
    <tbody>
           <?php if($pengajian){ ?>
        <?php $bil=1; foreach ($pengajian as $pengajian) { ?>
        <tr>
            <td class="text-center"><?= $bil++ ?></td>
            <td><?= $pengajian->alamat; ?></td>
            <td><?= $pengajian->fulldt; ?></td>
            <td><?= $pengajian->justifikasi; ?></td>
          
            <td><?= $pengajian->fulldt; ?></td>
            <td><?= $pengajian->justifikasi; ?></td>
            <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',  ["lanjutancb/lihat-permohonan", 'id'=>$pengajian->iklan_id, 'i'=>$pengajian->id]) ?> | <?= Html::a('<i class="fa fa-print" aria-hidden="true"></i>', ['adminview','id'=>$model->ICNO]) ?> </td>  

        </tr>
           <?php }} else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>


 </table>
</form>           </div> <!-- div for row-->
            </div> <!-- div for well-->

    </div>
                 
</div>
</div>
<?php }
else if ($_GET['page'] == "rekod-lkk") {?>
<div class="row"><div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="col-md-12 col-sm-12 col-xs-12 "> 

<div class="x_panel">

<div class="x_title">
   <h2><strong><i class="fa fa-book"></i> Laporan Kemajuan Kursus (LKK)</strong></h2>
   <div class="clearfix"></div>
</div>
 <div>
     
<form id="w0" class="form-horizontal form-label-left" action="">
   <table class="table table-bordered jambo_table">
   <thead>
        <tr class="headings">
            <th class="column-title text-center">Bil</th>
            <th class="column-title text-center">Semester </th>
            <th class="column-title text-center">Sesi</th>
            <th class="column-title text-center">Tarikh Hantar Laporan</th>
            <th class="column-title text-center">Status Laporan</th>
            <th class="column-title text-center">Tindakan</th>
        </tr>

    </thead>
    <tbody>
           <?php if($lkk){ ?>
        <?php $bil=1; foreach ($lkk as $lkk) { ?>
        <tr>
            <td class="text-center"><?= $bil++ ?></td>
            <td class="text-center"><?= $lkk->semester; ?></td>
            <td class="text-center"><?= $lkk->session; ?></td>
            <td class="text-center"><?= $lkk->tarikh_hantar; ?></td>
            <td class="text-center"><?= $lkk->statuss; ?></td>
            <td class="text-center" style="width:30%;">
                            <?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', 
    ['lkk/lihat-permohonan', "id"=> $lkk->reportID], ['class' => 'btn btn-default btn-xs']) ?>
               <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete?id='.$statuss->reportID], ['class' => 'btn btn-default btn-xs',
                                        'data' => [
                                        'confirm' => 'Anda ingin membuang rekod ini?',
                                        'method' => 'post',
                                        ],
                                    ])
                                  ?>
         </td>  

        </tr>
           <?php }} else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>


 </table>
</form>   <p align="right">
                <?php echo Html::a('Tambah Laporan', ['lkk/borang-permohonan'], ['class' => 'btn btn-primary btn-xs']); ?>
              
                </p>        </div> <!-- div for row-->
            </div> <!-- div for well-->

    </div>
                 
</div>
</div>
<?php }
else if ($_GET['page'] == "rekod-tempahan-tiket") {?>
<div class="row"><div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="col-md-12 col-sm-12 col-xs-12 "> 

<div class="x_panel">

<div class="x_title">
   <h2><strong><i class="fa fa-book"></i> Permohonan Tempahan Tiket Penerbangan</strong></h2>
   <div class="clearfix"></div>
</div>
 <div>
<form id="w0" class="form-horizontal form-label-left" action="">
   <table class="table table-bordered jambo_table">
   <thead>
        <tr class="headings">
            <th class="column-title text-center">Bil</th>
            <th class="column-title">Jenis Cuti Belajar </th>
            
            <th class="column-title">Tarikh Mohon</th>
            <th class="column-title">Tindakan</th>
        </tr>

    </thead>
    <tbody>
           <?php if($penerbangan){ ?>
        <?php $bil=1; foreach ($penerbangan as $penerbangan) { ?>
        <tr>
            <td class="text-center"><?= $bil++ ?></td>
           
          
            <td><?= $penerbangan->idBorang; ?></td>
            <td><?= $penerbangan->tarikh_mohon; ?></td>
            <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ["tiketpenerbangan/lihat-permohonan",  'id'=>$penerbangan->id]) ?> | <?= Html::a('<i class="fa fa-print" aria-hidden="true"></i>', ['adminview','id'=>$model->ICNO]) ?> </td>  

        </tr>
           <?php }} else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>


 </table>
</form>           </div> <!-- div for row-->
            </div> <!-- div for well-->

    </div>
                 
</div>
</div><?php }else if ($_GET['page'] == "rekod-lain-permohonan") {?>
<div class="row"><div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="col-md-12 col-sm-12 col-xs-12 "> 

<div class="x_panel">

<div class="x_title">
   <h2><strong><i class="fa fa-th-list"></i> Lain-lain Permohonan</strong></h2>
   <div class="clearfix"></div>
</div>
 <div>
<form id="w0" class="form-horizontal form-label-left" action="">
   <table class="table table-bordered jambo_table">
   <thead>
        <tr class="headings">
            <th class="column-title text-center">Bil</th>
            <th class="column-title">Jenis Cuti Belajar </th>
            
            <th class="column-title">Tarikh Mohon</th>
            <th class="column-title">Tindakan</th>
        </tr>

    </thead>
    <tbody>
           <?php if($lain){ ?>
        <?php $bil=1; foreach ($lain as $lain) { ?>
        <tr>
            <td class="text-center"><?= $bil++ ?></td>
           
          
            <td><?= $lain->idBorang; ?></td>
            <td><?= $lain->tarikh_mohon; ?></td>
            <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['cblainlain/lihat-permohonan','id'=>$lain->iklan_id]) ?> | <?= Html::a('<i class="fa fa-print" aria-hidden="true"></i>', ['adminview','id'=>$model->ICNO]) ?> </td>  

        </tr>
           <?php }} else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>


 </table>
</form>           </div> <!-- div for row-->
            </div> <!-- div for well-->

    </div>
                 
</div>
</div><?php }else if ($_GET['page'] == "rekod-lapor-diri") {?>
<div class="row"><div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="col-md-12 col-sm-12 col-xs-12 "> 

<div class="x_panel">

<div class="x_title">
   <h2><strong><i class="fa fa-th-list"></i> Rekod Lapor Diri</strong></h2>
   <div class="clearfix"></div>
</div>
 <div>
<form id="w0" class="form-horizontal form-label-left" action="">
   <table class="table table-bordered jambo_table">
   <thead>
        <tr class="headings">
            <th class="column-title text-center">Bil</th>
            <th class="column-title">Jenis Cuti Belajar </th>
            <th class="column-title">Tarikh Mohon</th>
            <th class="column-title">Status Pengajian</th>
            <th class="column-title">Tindakan</th>
        </tr>

    </thead>
    <tbody>
           <?php if($lapor){ ?>
        <?php $bil=1; foreach ($lapor as $lapor) { ?>
        <tr>
            <td class="text-center"><?= $bil++ ?></td>
           
          
            <td>Lapor Diri </td>
            <td><?= $lapor->tarikh_mohon; ?></td>
            <td>
                <?php
                if($lapor->status_study == "Selesai")
                {
                   echo $lapor->status_study;
                }
                else
                {
                    echo "Tiada Maklumat";
                }
                ?>
               
            </td>
            <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',  ["lapordiri/lihat-permohonan", 'id'=>$lapor->iklan_id, 'i'=>$lapor->laporID]) ?> | <?= Html::a('<i class="fa fa-print" aria-hidden="true"></i>', ['adminview','id'=>$model->ICNO]) ?> </td>  

        </tr>
           <?php }} else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>


 </table>
</form>           </div> <!-- div for row-->
            </div> <!-- div for well-->

    </div>
                 
</div>
</div>
         <?php } } ?>













