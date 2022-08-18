<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" media="print" href="bootstrap.css" />
<?php
use yii\widgets\ActiveForm;
error_reporting(0);

?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
   
<h6 style="text-align: right"><b><u>LAMPIRAN A</u></b></h6>
<br>
<h6 style="text-align: center; font-family:Arial;"><b><u>MENGHADIRI PERSIDANGAN, SEMINAR DAN<br>LAWATAN RASMI KE LUAR NEGARA</u></b></h6>

<table class="table" style="font-size: 10px;font-family:Arial;"> 
    <tbody>
    <tr>
        <th style="width:30%"> NAMA PERSIDANGAN/SEMINAR/<br>LAWATAN RASMI/KURSUS:</th> 
            <td style="width:70%"><?= strtoupper($model->nama_lawatan);?></td> 
    </tr>
    
    <tr>
        <th style="width:30%"> FAEDAH LAWATAN:</th> 
            <td style="width:70%"><?= strtoupper($model->faedah_lawatan);?></td> 
    </tr>

    <tr>
        <th style="width:30%"> TUJUAN:</th> 
            <td style="width:70%"><?= strtoupper($model->tujuan);?></td> 
    </tr>
    
    <tr>
        <th style="width:30%"> TEMPAT:</th> 
            <td style="width:70%"><?= strtoupper($model->nama_tempat);?></td> 
    </tr>
    
    </tbody>
</table>

<table class="table" style="font-size: 10px;font-family:Arial;"> 
    <tbody> 
    <tr>  
        <th style="width:20%">TARIKH PERGI:</th>
            <td style="width:20%"><?= strtoupper($model->datefrom);?></td>
        <th width="20%">TARIKH BALIK:</th>
            <td><?= strtoupper($model->dateto);?></td> 
        <th width="20%">TEMPOH (HARI):</th>
            <td><?= strtoupper($model->days);?></td> 
    </tr>
    </tbody>
</table> 

<table class="table" style="font-size: 10px;font-family:Arial;"> 
    <tbody>
    <tr> 
        <th style="width:20%">BIL. PESERTA (ORANG):</th>
            <td><?= strtoupper($model->bil_peserta); ?></td> 
            <th></th>
            <td></td>  
            <th></th>
            <td></td>
    </tr>
    </tbody>
</table> 

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
    <div class="x_title">
        <h6><strong><i class="fa fa-book"></i>MAKLUMAT PESERTA</strong></h6>
        <div class="clearfix"></div>
    </div>   
        <div>
            <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                <thead style="background-color:lightseagreen;color:white">
                    <tr>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIL.</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">NAMA PESERTA</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">JAWATAN HAKIKI</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">JABATAN HAKIKI</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">JAWATAN PENTADBIRAN</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">JABATAN PENTADBIRAN</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">PERANAN</th>
                    </tr>
                </thead>
                <tbody>
                <?php $bil=1; foreach ($peserta as $pesertakakitangan) { ?>
                    <tr>
                        <td class="text-center"><?= $bil++ ?></td>
                        <td class="text-center"><?= strtoupper($pesertakakitangan->kakitangan->CONm); ?></td>
                        <td class="text-center"><?= strtoupper($pesertakakitangan->kakitangan->jawatan->fname);?></td>
                        <td class="text-center"><?= strtoupper($pesertakakitangan->kakitangan->department->fullname);?></td>
                        <td class="text-center"><?= strtoupper($pesertakakitangan->kakitangan->adminpos->adminpos->position_name);?></td>
                        <td class="text-center"><?= strtoupper($pesertakakitangan->kakitangan->adminpos->dept->fullname);?></td>
                        <td class="text-center"><?= strtoupper($pesertakakitangan->role->peranan);?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>          
        </div>
    </div>
</div>
</div>

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
    <div class="x_title">
        <h6><strong><i class="fa fa-book"></i>SEJARAH PERJALANAN</strong></h6>
        <div class="clearfix"></div>
    </div>   
        <div>
            <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                <thead style="background-color:lightseagreen;color:white">
                    <tr>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIL.</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">NAMA</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TARIKH</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TUJUAN</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TEMPAT</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">KOD PERUNTUKAN</th>
                    </tr>
                </thead>
                <tbody>
                <?php $bil=1; foreach ($ln as $a) { ?>
                    <tr>
                        <td class="text-center"><?= $bil++ ?></td>
                        <td class="text-center"><?= strtoupper($a->kakitangan->CONm); ?></td>
                        <td class="text-center"><?= strtoupper($a->datefrom);?></td>
                        <td class="text-center"><?= strtoupper($a->nama_lawatan);?></td>
                        <td class="text-center"><?= strtoupper($a->nama_tempat);?></td>
                        <td class="text-center"><?= strtoupper($a->kod_peruntukan_cn);?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>              
        </div>
    </div>
</div>
</div>

<table style="font-size: 10px;font-family:Arial;"> 
    <tbody>
    <tr>
        <th style="width:40%">KOD PERUNTUKAN:</th>
            <td><?= strtoupper($model->kod_peruntukan_cn); ?></td> 
    </tr>
    </tbody>
</table>
<br>

<br>

<h6><b> STATUS PERAKUAN KETUA JABATAN (DEKAN/PENGARAH/KETUA)</b></h6>
<table style="font-size: 10px;font-family:Arial;"> 
    <tbody>
    <tr> 
        <th style="width:20%">STATUS PERAKUAN:</th>
            <td><?= strtoupper($model->status_jfpiu); ?></td> 
    </tr>
</table><br>
<table style="font-size: 10px;font-family:Arial;"> 
    <tr>
        <th style="width:20%">ULASAN:</th> 
            <td><?= strtoupper($model->ulasan_jfpiu);?></td> 
    </tr>
    </tbody>
</table><br>
<table style="font-size: 10px;font-family:Arial;"> 
    <tr>
        <th style="width:20%">TARIKH DIPERAKU:</th> 
            <td><?= strtoupper($model->appdatee);?></td> 
    </tr>
    </tbody>
</table>

<br><br>

<h6><b> STATUS SEMAKAN CANSELORI</b></h6>
<table style="font-size: 10px;font-family:Arial;"> 
    <tbody>
    <tr> 
        <th style="width:20%">STATUS SEMAKAN:</th>
            <td><?= strtoupper($model->status_semakan); ?></td> 
    </tr>
</table><br>
<table style="font-size: 10px;font-family:Arial;"> 
    <tr>
        <th style="width:20%">ULASAN:</th> 
            <td><?= strtoupper($model->ulasan_semakan);?></td> 
    </tr>
    </tbody>
</table><br>
<table style="font-size: 10px;font-family:Arial;"> 
    <tr>
        <th style="width:20%">TARIKH DIPERAKU:</th> 
            <td><?= strtoupper($model->verdatee);?></td> 
    </tr>
    </tbody>
</table>

<br><br>

<h6><b> STATUS KELULUSAN NAIB CANSELOR</b></h6>
<table style="font-size: 10px;font-family:Arial;"> 
    <tbody>
    <tr> 
        <th style="width:20%">STATUS KELULUSAN:</th>
            <td><?= strtoupper($model->status_nc); ?></td> 
    </tr>
</table><br>
<table style="font-size: 10px;font-family:Arial;"> 
    <tr>
        <th style="width:20%">ULASAN:</th> 
            <td><?= strtoupper($model->ulasan_nc);?></td> 
    </tr>
    </tbody>
</table><br>
<table style="font-size: 10px;font-family:Arial;"> 
    <tr>
        <th style="width:20%">TARIKH DILULUSKAN:</th> 
            <td><?= strtoupper($model->lulusdate);?></td> 
    </tr>
    </tbody>
</table>

    <?php ActiveForm::end(); ?>
<p align="right"><font size="2">   <?php echo "[Tarikh Dicetak:"  .' '.date("Y-m-d").', '.  date("h:i:sa")."]";?></p>
