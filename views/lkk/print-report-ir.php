<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" media="print" href="bootstrap.css" />
<?php

use yii\helpers\Html;
use yii\helpers\Url;

error_reporting(0);

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */
?> 



<div class="col-md-12 col-sm-3 col-xs-12" style="margin-bottom: 15px; font-size:15px; margin-top: 50px">
    <div class="profile_img text-center">
        <div id="crop-avatar"> 

            <img src="/staff/web/images/logo-umsblack-text-png.png" width="200px" height="auto" alt="signature"/> <br><br>
        </div>
    </div>
</div>

<div class="x_panel">
    <div class="x_content"> 

        <p align="center"><strong>UNIT PENGEMBANGAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA</strong></p> 
        <p align="center"><strong><u>LAPORAN KEMAJUAN PENGAJIAN | <i>STUDENT PROGRESS REPORT</i></u></strong></p> 

    </div>
</div>

<div class="x_panel">

    <div class="x_title">
        <h6><strong><i class="fa fa-user"></i> PERIOD DETAILS<hr></strong></h6>

    </div>
    <table class="table table-sm table-bordered">


       

        <tr>
            <td width="35%"><strong><font size="2">PERIOD:</font></strong></td>
            <td colspan="3"><font size="2">                            
                From <?= $model->report_fr; ?> To  <?= $model->report_to; ?> </td>
        </tr>


    </table>

</div>

<div class="x_panel">

    <div class="x_title">
        <h6><strong><i class="fa fa-user"></i> STUDENT'S DETAILS<hr></strong></h6>

    </div>
    <table class="table table-sm table-bordered">
        <tr>

            <td width="35%"><font size="2"><strong>FULL NAME:</font></strong></td>
            <td><font size="2"><?= ucwords(strtoupper($model->kakitangan->CONm)); ?></font></td>
        </tr>

        <tr>
            <td width="35%"><strong><font size="2">NO. KP:</font></strong></td>
            <td><font size="2"><?= $model->kakitangan->ICNO; ?></font></td>
        </tr>

        <tr>
            <td width="35%"><strong><font size="2">UMSPER:</font></strong></td>
            <td><font size="2"><?= $model->kakitangan->COOldID; ?></font></td>
        </tr>
     

        <tr>
            <td width="35%"><strong><font size="2">LEVEL OF STUDY:</font></strong></td>
            <td><font size="2"> <?php
                if ($model->pengajian->tahapPendidikan) {
                    echo strtoupper($model->pengajian->tahapPendidikan);
                }
                ?> </font></td>
        </tr>


        <tr>
            <td width="35%"><strong><font size="2">PERIOD AND PLACED OF STUDY APPROVED:</font></strong></td>
            <td><font size="2">(FROM) <?= strtoupper($model->pengajian->tarikhmula); ?> (TO) <?= strtoupper($model->pengajian->tarikhtamat); ?> (<?= strtoupper($model->pengajian->tempohpengajian); ?>) (AT) 
                <?= ucwords(strtoupper($model->pengajian->InstNm)) ?></font>  </td> 
        </tr>

      

        <tr>
            <td width="35%"><strong><font size="2">SUPERVISOR NAME:</font></strong></td>
            <td><font size="2"><?= strtoupper($model->pengajian->nama_penyelia) ?></font></td>
        </tr>
        <tr>
            <td width="35%"><strong><font size="2">SUPERVISOR EMAIL:</font></strong></td>
            <td><font size="2"><?= ($model->pengajian->emel_penyelia) ?></font></td>
        </tr>
     


    </table>

</div>

<div class="x_panel">

    <div class="x_title">
        <h6><strong><i class="fa fa-user"></i> STAFF'S REPORT<hr></strong></h6>

    </div>
    <table class="table table-sm table-bordered">
        <tr>
            <th colspan='6'><center><font size="2">INDUSTRIAL TRAINING'S REPORT</font></center></th>
        </tr>


        <tr>
            <td width="35%"><strong><font size="2">REPORT:</font></strong></td>
            <td colspan='5'><font size="2"> <?php if ($model->dokumen_sokongan) { ?>
                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                       href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" >
                        <i class="fa fa-download"></i> <strong><small><u> Download Document </u></small></strong></a><br>

                    <?php
                } else {
                    echo '<i>No Data</i>' . '<br>';
                }
                ?></font></td>
        </tr>
        <tr>
            <td width="35%"><strong><font size="2">JUSTIFICATION SUPERVISOR :</font></strong></td>
            <td colspan='5'><font size="2"> <?php if ($model->dokumen_sokongan2) { ?>
                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                       href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan2), true); ?>" target="_blank" >
                        <i class="fa fa-download"></i> <strong><small><u> Download Document </u></small></strong></a><br>

                    <?php
                } else {
                    echo '<i>No Data</i>' . '<br>';
                }
                ?></font></td>
        </tr>



    </table>

</div>




<div class="x_panel">

    <div class="x_title">
        <h6><strong><i class="fa fa-user"></i> DEAN/DIRECTOR'S VERIFICATION STATUS<hr></strong></h6>

    </div>
    <table class="table table-sm table-bordered">

        <tr>

            <td width="35%"><font size="2"><strong>VERIFICATION STATUS:</font></strong></td>
            <td  colspan='5'><font size="2"><?= $model->status_jfpiu; ?></font></td>
        </tr>

        <tr>

            <td width="35%"><font size="2"><strong>COMMENT/RECOMMENDATION:</font></strong></td>
            <td  colspan='5'><font size="2"> <?= $model->ulasan_jfpiu; ?></font></td>
        </tr>
        <tr>
            <td width="35%"><font size="2"><strong>VERIFICATION DATE:</font></strong></td>
            <td  colspan='5'><font size="2"><?= $model->verify_dt; ?></font></td>
        </tr>






    </table>

</div>

<div class="x_panel">

    <div class="x_title">
        <h6><strong><i class="fa fa-user"></i> BSM REVIEW STATUS<hr></strong></h6>

    </div>
    <table class="table table-sm table-bordered">

        <tr>

            <td width="35%"><font size="2"><strong>BSM STATUS:</font></strong></td>
            <td  colspan='5'><font size="2"><?= $model->status_bsm; ?></font></td>
        </tr>

        <tr>

            <td width="35%"><font size="2"><strong>COMMENT/RECOMMENDATION:</font></strong></td>
            <td  colspan='5'><font size="2"> <?= $model->catatan; ?></font></td>
        </tr>
        <tr>
            <td width="35%"><font size="2"><strong>VERIFICATION DATE:</font></strong></td>
            <td  colspan='5'><font size="2"><?= $model->ver_date; ?></font></td>
        </tr>






    </table>

</div>

<p align="right"><font size="2">   <?php echo "[DATE OF PRINT:" . ' ' . date("Y-m-d") . ', ' . date("h:i:sa") . "]"; ?></p>
