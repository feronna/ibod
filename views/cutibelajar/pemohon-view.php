<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'HALAMAN UTAMA';
error_reporting(0);
?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
            <h2><i class="fa fa-home"></i> <b><?= Html::encode($this->title) ?></b></h2>

          
        
        <div class="x_content">
         

            <div class="well well-lg"> 
                <div class="row ">
                
<div class="x_content"> 


            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <?php
                    $resume = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list-alt',
                                        'header' => ' PERMOHONAN<br>BAHARU',
                                        'text' => 'Pengajian Lanjutan',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($resume, ['view-takwim']);
        
                    ?>

                </div>
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'address-card',
                                        'header' => 'REKOD PENGAJIAN<br> LANJUTAN ',
                                        'text' => 'Rekod Keseluruhan Diluluskan',
                                        'number' => '2',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['view-rekod']);
                    ?>
                </div>

                 <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'bar-chart',
                                        'header' => 'LAPORAN KEMAJUAN<br> PENGAJIAN (LKP)',
                                        'text' => 'Rekod LKP',

//                                        'text' => '<p style="color: red"><b>Dalam Proses Ujilari</b></p>',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($semakan, ['lkk/senarailkk?icno='.$m]);
//                                        echo Html::a($semakan, ['#']);

//                    echo   '<p style="color: red"><strong>DALAM PROSES UJILARI</strong></p>';
                    ?>
           </div>
                
            
                
               
       </div>
<div class="row">
                <div class="col-xs-12 col-md-4">
                    <?php
                    $resume = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'suitcase',
                                        'header' => 'LAPOR DIRI',
                                        'text' => 'Lapor Diri Kembali Bertugas',
                                        'number' => '4',
                                    ]
                    );
//                    echo Html::a($resume, ['lapordiri/borang']);
                                        echo Html::a($resume, ['senarai-borang-lapor']);

        
                    ?>

                </div>
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'calculator',
                                        'header' => 'BON PERKHIDMATAN',
                                        'text' => '<p style="color: red"><b>Dalam Proses Ujilari</b></p>',
                                        'number' => '5',
                                    ]
                    ); 
//                    echo Html::a($dokumen, ['rekod-bon']);
                                        echo Html::a($dokumen, ['#']);

                    ?>
                </div>

                 <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'gift',
                                        'header' => 'BIASISWA / BAYARAN',
//                                         'text' => '<p style="color: red"><b>Dalam Proses Ujilari</b></p>',
                                        'text' => 'Rekod Berkaitan Kewangan & Saraan',
                                        'number' => '6',
                                    ]
                    );
                    echo Html::a($semakan, ['cutibelajar/senarai-borang']);
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













