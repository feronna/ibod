<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" media="print" href="bootstrap.css" />
<?php
use yii\helpers\Html; 
use yii\helpers\Url; 
use yii\widgets\ActiveForm;
error_reporting(0);

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

<div class="col-md-12 col-sm-3 col-xs-12" style="margin-bottom: 15px; font-size:15px; margin-top: 50px">
    <div class="profile_img text-center">
        <div id="crop-avatar"> 
          <img src="/staff/web/images/logo-umsblack-text-png.png" width="200px" height="auto" alt="signature"/> <br><br>
        </div>
    </div>
</div>

<h5 style="text-align: center;  font-family:Arial;"><b>LAPORAN BERTUGAS RASMI DI LUAR NEGARA</b></h5>

<br>
<h6><b>I. MAKLUMAT PEMOHON</b></h6>
<table class="table" style="font-size: 10px;font-family:Arial;"> 
    <tbody>
<!--    <tr>
        <th rowspan="8" class="text-center">
        <center>
            <div class="profile_img">
                <div id="crop-avatar"> <br/><br/>
                    <img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($model->kakitangan->ICNO)); ?>.jpeg" width="90" height="120">
                </div>
            </div> 
        </center>
        </th>  
    </tr> -->
    <tr>
        <th style="width:20%">NAMA:</th> 
            <td style="width:20%"><?= strtoupper($model->kakitangan->CONm);?></td> 
        <th>J/F/P/I/B:</th>
            <td><?= strtoupper($model->kakitangan->department->fullname) ?></td>
    </tr>
    <tr> 
        <th style="width:20%">NO. PEKERJA:</th>
            <td style="width:20%"><?= \strtoupper($model->kakitangan->COOldID); ?></td> 
        <th width="20%">JAWATAN PENTADBIRAN:</th>
            <td>
                <?php if($model->kakitangan->adminpos->adminpos != NULL){?>                   
                <?= $model->kakitangan->adminpos->adminpos->position_name . " (" . $model->kakitangan->adminpos->dept->fullname . ")"; ?>                    
                <?php }else{
                echo "-";
                }?>  
            </td>  
    </tr>
    <tr>  
        <th style="width:20%">JAWATAN HAKIKI:</th>
            <td style="width:20%"><?= strtoupper($model->kakitangan->jawatan->fname);?></td>
        <th width="20%"></th>
            <td>
            </td> 
    </tr>
    </tbody>
</table> 

<h6><b>MAKLUMAT MENGENAI LAWATAN</b></h6>
<table class="table" style="font-size: 10px;font-family:Arial;"> 
    <tbody>
    <tr>
        <th style="width:20%">NAMA LAWATAN:</th> 
            <td><?= strtoupper($model->nama_lawatan);?></td> 
            <th></th>
            <td></td>
            <th></th>
            <td></td>
    </tr>
    </tbody>
</table>
<table class="table" style="font-size: 10px;font-family:Arial;"> 
    <tbody>
    <tr>
        <th style="width:20%">TUJUAN LAWATAN:</th> 
            <td><?= strtoupper($model->tujuan);?></td> 
            <th></th>
            <td></td>
            <th></th>
            <td></td>
    </tr>
    </tbody>
</table>

<table class="table" style="font-size: 10px;font-family:Arial;"> 
    <tbody>
    <tr> 
        <th style="width:20%">TEMPAT:</th>
            <td><?= \strtoupper($model->nama_tempat); ?></td> 
            <th></th>
            <td></td>  
            <th></th>
            <td></td>
    </tr>
    
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

<h6><b>II. TUJUAN LAWATAN KERJA</b></h6>
<table class="table" style="font-size: 10px;font-family:Arial;"> 
    <tbody>
    <tr>
        <th style="width:20%">TUJUAN:</th> 
            <td><?= strtoupper($model->kakitangan2->tujuan_lawatan);?></td> 
            <th></th>
            <td></td>
            <th></th>
            <td></td>
    </tr>
    </tbody>
</table>

<h6><b>III. PROGRAM LAWATAN KERJA</b></h6>
<table class="table" style="font-size: 10px;font-family:Arial;"> 
    <tbody>
    <tr>
        <th style="width:20%">PROGRAM:</th> 
            <td><?= strtoupper($model->kakitangan2->program_lawatan);?></td> 
            <th></th>
            <td></td>
            <th></th>
            <td></td>
    </tr>
    </tbody>
</table>

<h6><b>IV. IMPLIKASI DAN FAEDAH WATAN KEPADA UNIVERSITI MALAYSIA SABAH</b></h6>
<table class="table" style="font-size: 10px;font-family:Arial;"> 
    <tbody>
    <tr>
        <th style="width:20%">IMPLIKASI / FAEDAH:</th> 
            <td><?= strtoupper($model->kakitangan2->implikasi_lawatan);?></td> 
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
        <h6><strong><i class="fa fa-book"></i>V. KOS PERBELANJAAN SEBENAR</strong></h6>
        <div class="clearfix"></div>
    </div>   
        <div>
            <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                <thead style="background-color:lightseagreen;color:white">
                    <tr>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIL.</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">PERBELANJAAN ( Sila isi jumlah (RM) di ruangan yang berkaitan )</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">JUMLAH DIPOHON (RM)</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">JUMLAH DIPERUNTUKAN (RM)</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">JUMLAH SEBENAR (RM)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">i)</td>
                        <td>Tambang pergi-balik</td>
                        <td><?= strtoupper($model->tambang);?></td>
                        <td><?= strtoupper($model->tambang2);?></td>
                        <td><?= strtoupper($model->kakitangan2->tambang3);?></td>
                    </tr>
                    <tr>
                        <td class="text-center">ii)</td>
                        <td>Elaun Makan</td>
                        <td><?= strtoupper($model->elaun_makan);?></td>
                        <td><?= strtoupper($model->elaun_makan2);?></td>
                        <td><?= strtoupper($model->kakitangan2->elaun_makan3);?></td>
                    </tr>
                    <tr>
                        <td class="text-center">iii)</td>
                        <td>Elaun Sewa Hotel</td>
                        <td><?= strtoupper($model->elaun_hotel);?></td>
                        <td><?= strtoupper($model->elaun_hotel2);?></td>
                        <td><?= strtoupper($model->kakitangan2->elaun_hotel3);?></td>
                    </tr>
                    <tr>
                        <td class="text-center">iv)</td>
                        <td>Yuran Pendaftaran</td>
                        <td><?= strtoupper($model->yuran);?></td>
                        <td><?= strtoupper($model->yuran2);?></td>
                        <td><?= strtoupper($model->kakitangan2->yuran3);?></td>
                    </tr>
                    <tr>
                        <td class="text-center">v)</td>
                        <td>Lain-lain: Pengangkutan</td>
                        <td><?= strtoupper($model->transport);?></td>
                        <td><?= strtoupper($model->transport2);?></td>
                        <td><?= strtoupper($model->kakitangan2->transport3);?></td>
                    </tr>
                    <tr>
                        <td class="text-center">vi)</td>
                        <td>Lain-lain: Pertukaran Wang/Dobi/dll</td>
                        <td><?= strtoupper($model->dll);?></td>
                        <td><?= strtoupper($model->dll2);?></td>
                        <td><?= strtoupper($model->kakitangan2->dll3);?></td>
                    </tr>
                    <tr>
                        <td class="text-center">vii)</td>
                        <td>Jumlah</td>
                        <td><?= strtoupper($model->jumlah);?></td>
                        <td><?= strtoupper($model->jumlah2);?></td>
                        <td><?= strtoupper($model->kakitangan2->jumlah3);?></td>
                    </tr>
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

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
    <div class="x_title">
        <h6><strong><i class="fa fa-book"></i>PERINCIAN PERBELANJAAN</strong></h6>
        <div class="clearfix"></div>
    </div>   
        <div>
            <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial; width:50%;" >
                <tbody>
                    <tr>
                        <td>i)</td>
                        <td><strong>Jumlah Dipohon </strong></td>
                        <td><strong>
                                <?php if($model->jumlah!= NULL){?>  
                                <?= Yii::$app->formatter->asCurrency( $model->jumlah, 'RM '); ?> 
                                <?php }else{
                                    echo "Tidak Berkaitan";
                                }?>
                            </strong></td>
                    </tr>
                    <tr>
                        <td>ii)</td>
                        <td><strong>Jumlah Diperuntukan </strong></td>
                        <td><strong>
                                <?php if($model->jumlah2!= NULL){?>  
                                <?= Yii::$app->formatter->asCurrency( $model->jumlah2, 'RM '); ?> 
                                <?php }else{
                                    echo "Tidak Berkaitan";
                                }?>
                            </strong></td>
                    </tr>
                    <tr>
                        <td>ii)</td>
                        <td><strong>Jumlah Sebenar </strong></td>
                        <td><strong>
                                <?php if($model->kakitangan2->jumlah3!= NULL){?>  
                                <?= Yii::$app->formatter->asCurrency( $model->kakitangan2->jumlah3, 'RM '); ?> 
                                <?php }else{
                                    echo "Tidak Berkaitan";
                                }?>
                            </strong></td>
                    </tr>
                </tbody>
            </table>              
        </div>
    </div>
</div>
</div>

<br>

<h6><b>VI. CATATAN UMUM DAN PANDANGAN</b></h6>
<table class="table" style="font-size: 10px;font-family:Arial;"> 
    <tbody>
    <tr>
        <th style="width:30%">CATATAN / PANDANGAN:</th> 
            <td><?= strtoupper($model->kakitangan2->catatan);?></td> 
            <th></th>
            <td></td>
            <th></th>
            <td></td>
    </tr>
    </tbody>
</table>

<br>

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
    <div class="x_title">
        <h6><strong><i class="fa fa-book"></i>VII. STATUS PENYELARASAN PENDAHULUAN DIRI / PELBAGAI</strong></h6>
        <div class="clearfix"></div>
    </div>   
        <div>
            <table class="table" style="font-size: 10px;font-family:Arial;"> 
                <tbody>
                <tr>
                <th style="width:20%">CATATAN:</th> 
                    <td><?= strtoupper($model->kakitangan2->catatan_penyelarasan);?></td> 
                    <th></th>
                    <td></td>
                    <th></th>
                    <td></td>
                </tr>
                </tbody>
            </table>
            <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                <thead style="background-color:lightseagreen;color:white">
                    <tr>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIL.</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">PERBELANJAAN ( Sila tanda √ di ruangan yang berkaitan </th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">i)</td>
                        <td>Selesai</td>
                        <td class="text-center"><br> <?= $form->field($model->kakitangan2, 'penyelarasan')->radio(['disabled'=>'disabled', 'label' => '', 'value' => 1, 'uncheck' => null])->label(false)  ?>     </td>
                    </tr>
                    <tr>
                        <td class="text-center">ii)</td>
                        <td>Belum Selesai</td>
                        <td class="text-center"><br> <?= $form->field($model->kakitangan2, 'penyelarasan')->radio(['disabled'=>'disabled', 'label' => '', 'value' => 2, 'uncheck' => null])->label(false)  ?>     </td>
                    </tr>
                    <tr>
                        <td class="text-center">iii)</td>
                        <td>Tidak Berkenaan</td>
                        <td class="text-center"><br> <?= $form->field($model->kakitangan2, 'penyelarasan')->radio(['disabled'=>'disabled', 'label' => '', 'value' => 3, 'uncheck' => null])->label(false)  ?>     </td>
                    </tr>
                </tbody>
            </table>   
        </div>
    </div>
</div>
</div>

<!--<p align="center"><font size="2">Kegunaan borang ini hanya untuk laporan Lawatan Rasmi ke luar negara <b>tidak termasuk</b> Persidangan/Seminar.
Persidangan termasuk Kongress, Seminar, Forum, Simposium, Kolokium, Wacana, Ceramah, Mesyuarat, Perjumpaan
dan Bengkel yang tidak bersifat kursus diuruskan oleh Pusat Pengurusan Penyelidikan dan Persidangan<p>-->
    
<p align="right"><font size="2">   <?php echo "[Tarikh Dicetak:"  .' '.date("Y-m-d").', '.  date("h:i:sa")."]";?></p>
