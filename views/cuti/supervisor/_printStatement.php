<?php

use app\models\cuti\Layak;
use app\models\cuti\TblRecords;

Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
Yii::$app->response->headers->add('Content-Type', 'application/pdf');



?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- <h4 style="text-align:center;">UNIVERSITI MALAYSIA SABAH</h4> -->

<hr>
<h4 style="text-align:center;">PENYATA CUTI TAHUNAN</h4>
<hr>
Name : <?= $biodata->CONm ?><br>
ICNO : <?= $biodata->ICNO ?><br>
Position : <?= $biodata->jawatan->nama ?><br>
Grade : <?= $biodata->jawatan->gred ?><br>
Department : <?= $biodata->department->fullname ?>
<br>
<br>

<table class="table table-sm table-bordered table-striped" style="font-size: 12.5px">
    <tr>
        <!-- <th colspan="2" style="background-color: #4CAF50;" style="background-color: #4CAF50;" class="column-title text-center">Leave Application Details</th> -->
        <!-- <tr class="headings"> -->
        <th class="column-title text-center" width="auto">Entitlement Date</th>
        <th class="column-title text-center">BCTL</th>
        <th class="column-title text-center">Entitlement</th>
        <th class="column-title text-center">Total</th>
        <th class="column-title text-center">Start to End</th>
        <!-- <th class="column-title text-center">Leave End</th> -->
        <th class="column-title text-center">Duration</th>
        <th class="column-title text-center">Increment</th>
        <th class="column-title text-center">Balance</th>
        <th class="column-title text-center">CBTH</th>
        <th class="column-title text-center">GCR</th>
        <th class="column-title text-center">Lupus</th>
        <th class="column-title text-center">Leave Type</th>
        <!-- </tr> -->
    </tr>

    <?php foreach ($query as $data) { ?>
        <tr>
            <td class="text-center"><?= $data->layak_mula . ' - ' . $data->layak_tamat ?></td>
            <td class="text-center"><?= $data->layak_bawa_lepas ?></td>
            <td class="text-center"><?= $data->layak_cuti ?></td>
            <td class="text-center"><?= $data->layak_cuti + $data->layak_bawa_lepas + $data->layak_selaras ?></td>

            <td class="text-center" colspan="8">Leave Records <?php $date = date('Y', strtotime($data->layak_mula));
                                                                echo "($date)"; ?></td>

        <tr>
            <?php foreach (TblRecords::getRecords($data->layak_icno, $data->layak_mula, $data->layak_tamat) as $test) { ?>
        <tr>
            <td class="text-center"></td>
            <td class="text-center" colspan="3"></td>
            <td class="text-center"><?= $test->full_date ?></td>
            <td class="text-center"><?= $test->tempoh ?></td>
            <td class="text-center"><?= TblRecords::getIncrement($test->icno, $data->layak_mula, $test->end_date) ?></td>
            <td class="text-center"><?= $data->layak_cuti + $data->layak_bawa_lepas + $data->layak_selaras - TblRecords::getIncrement($test->icno, $data->layak_mula, $test->end_date) ?></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"><?= $test->jenisCuti->jenis_cuti_nama ?></td>


        </tr>


    <?php  } ?>
    </tr>

    <tr>
        <td class="text-center" colspan="8"></td>
        <td class="text-center"><?= $data->layak_bawa_depan ?></td>
        <td class="text-center"><?= $data->layak_gcr ?></td>
        <td class="text-center"><?= $data->layak_hapus ?></td>
        <td class="text-center"></td>
    </tr>
<?php  } ?>
<tr>
    <td class="text-center" colspan="8">Total GCR</td>
    <td class="text-center"></td>

    <td class="text-center"><?= Layak::getTotalGcr($id, $year) ?></td>
    <td class="text-center"></td>
    <td class="text-center"></td>

</tr>

</tr>

</table>
<div class="page-break">

RUJUKAN
<br>
<br>
JENIS-JENIS CUTI DALAM REKOD PENYATA CUTI
    <table class="table table-sm table-bordered table-striped" style="font-size: 12.5px">

        <?php foreach ($jenis as $j) { ?>
            <tr>
                <td style = "padding-left:20px;padding-right:20px" class="text-center"><?= $bil++ ?></td>
                <td style = "padding-left:80px;"><?= $j->jenis_cuti_catatan ?></td>

            </tr>

        <?php  } ?>

    </table>
*BCTL - BAKI CUTI TAHUN LEPAS<br>
*CBTH - BAKI CUTI BAWA TAHUN HADAPAN<br>
*GCR - GANTIAN CUTI REHAT KEPADA WANG TUNAI

</div>

<!--  -->