<?php

use app\models\cuti\Layak;
use app\models\cuti\SetPegawai;
use app\models\cuti\TblRecords;
use app\models\hronline\Tblprcobiodata;
use yii\helpers\Html;
use app\models\keselamatan\TblRekod;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
use yii\widgets\DetailView;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\daterange\DateRangePicker;
use yii\bootstrap\Modal;

Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
Yii::$app->response->headers->add('Content-Type', 'application/pdf');



?>


<hr>
<h4 style="text-align:center;">LAPORAN CUTI BULANAN - <?= $dept_name->fullname ?></h4>
<hr>

<table class="table table-bordered table-condensed table-striped table-sm jambo_table">

    <tr>

        <thead>
            <th class="column-title text-right" colspan="4">There are <?= $total ?> Staff That Taken Leave For <?= TblRecords::viewBulan($month)?> <?= $year ?> </th>
        </thead>
    </tr>

    <?php foreach ($staff_list as $data) { ?>

        <tr>
            <td class="text-left" colspan="4" style="background-color: #A9A9A9;">(<?= $count++ ?>) <?= $data->CONm ?></td>
        <tr>


            <th class="column-title text-center" style="background-color: #e5e5cc;">Start - End</th>
            <th class="column-title text-center" style="background-color: #e5e5cc;">Duration</th>
            <th class="column-title text-center" colspan="2" style="background-color: #e5e5cc;">Leave Type</th>

        </tr>
        <?php foreach (TblRecords::getRecord($data->ICNO, "$year", "$month") as $test) { ?>
            <tr>

                <td class="text-center"><?= $test->full_date ?></td>
                <td class="text-center"><?= $test->tempoh ?></td>
                <td class="text-center"><?= $test->jenisCuti->jenis_cuti_catatan ?></td>


            </tr>
        <?php  } ?>

        </tr>

    <?php  } ?>


</table>
<div class="page-break">
<hr>
<h4 style="text-align:center;">  RUANGAN SEMAKAN / PERAKUAN / PENGESAHAN</h4>
<hr>
<br>

<u><b>PENYELIA CUTI</b></u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<u><b>PEGAWAI PENYELIA CUTI</b></u>
<br>
<br>
<br></br>
TANDATANGAN : _______________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
TANDATANGAN : _______________________ 
<br>
<br>
DISEMAK OLEH : _______________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
DISEMAK OLEH : _______________________ 
      
<br>
<br>
DISEMAK PADA : _______________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
DISEMAK PADA : _______________________ 
<br>
<br>
<br>
<br>
<u><b>DEKAN/PENGARAH/KETUA</b></u>
<br>
<br>

TANDATANGAN : _______________________ 
<br>
<br>

DISEMAK OLEH : _______________________ 
<br>
<br>

DISEMAK PADA : _______________________ 

</div>