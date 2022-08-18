<?php

use app\models\keselamatan\TblRekod;

Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
Yii::$app->response->headers->add('Content-Type', 'application/pdf');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div style='border: solid black; padding-left: 15px; margin: 15px; font-size: 12.5px'>
    <h5><strong>Name : </strong><u><?= $biodata->CONm ?></u></h5>
    <h5><strong>Position : </strong><u><?= $biodata->jawatan->fname ?></u></h5>
    <h5><strong>J / F / P / I / B : </strong><u><?= $biodata->department->fullname ?></u></h5>
    <h5><strong>Year : </strong><u><?= $tahun ?></u></h5>
    <h5><strong>Month : </strong><u><?= TblRekod::viewBulan($bulan) ?></u></h5>

</div>

<div style='padding: 15px; font-size: 12px' class="table-bordered">
    <font>[ &#10004; ]</font> : Remarked&nbsp;&nbsp;&nbsp;&nbsp;
    <font color="white" style="background-color:green;">[ &#10004; ]</font> : Remark has been Approved &nbsp;&nbsp;&nbsp;&nbsp;
    <font style="color:red">[ &#x2716; ]</font> : No Remark / Remark not approved
</div>
<br>

<table class="table table-sm table-bordered table-striped" style="font-size: 12.5px">
    <tr>
        <th class="text-center">Date</th>
        <th class="text-center">Day</th>
        <th class="text-center">WBB</th>
        <th class="text-center">In</th>
        <th class="text-center">Out</th>
        <th class="text-center">Working Hours</th>
        <th class="text-center">Status</th>
        <th class="text-center">Leave / Outstation</th>
        <th class="text-center">Remark<br>status</th>
        <th class="text-center">Remark</th>
    </tr>
    <?php foreach ($var as $k => $v) { ?>
        <tr>
            <td class="text-center"  style="text-align:center"><?= date("d/m/Y", strtotime($v)); ?></td>
            <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayDay($v) ?></td>
            <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayShift($icno, $v) ?></td>
            <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayTime($icno, $v, 1) ?></td>
            <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayTime($icno, $v, 2) ?></td>
            <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayHours($icno, $v) ?></td>
            <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayTime($icno, $v, 5) ?></td>
            <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayCuti($icno, $v) ?></td>
            <td class="text-center"  style="text-align:center"><?= TblRekod::RemarkStatus($icno, $v) ?></td>
            <td class="text-center"  style="text-align:center;"><?= TblRekod::viewRemark($icno, $v) ?></td>


        </tr>
    <?php } ?>
</table>
<div style='border: solid red; border-style: dashed; padding-left: 15px; font-size: 12.5px'>
    <h5><strong>Monthly Summary</strong></h5>
    <p>
        Late In : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan, $tahun, 1) ?></strong>&nbsp;
        Early Out : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan, $tahun, 2) ?></strong>&nbsp;
        Incomplete : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan, $tahun, 3) ?></strong>&nbsp;
        Absent : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan, $tahun, 4) ?></strong>&nbsp;
        External : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan, $tahun, 5) ?></strong>&nbsp;
    </p>
</div>

