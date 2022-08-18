<?php

use app\controllers\KehadiranController;
use app\models\keselamatan\TblRekod;

Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
Yii::$app->response->headers->add('Content-Type', 'application/pdf');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<?php for ($x = $start_mth; $x <= $end_mth; $x++) { ?>

    <div class="table-bordered" style='padding-left: 10px; font-size: 12.5px;margin-bottom:5px'>
        <h5 style="background-color: yellow" class="text-center"><strong>Monthly Summary (<?php echo TblRekod::viewBulan($x); ?>)</strong></h5>
        <p>
            Late In : <strong><?= TblRekod::countKetidakpatuhan($icno, $x, $tahun, 1) ?></strong>&nbsp;
            Early Out : <strong><?= TblRekod::countKetidakpatuhan($icno, $x, $tahun, 2) ?></strong>&nbsp;
            Incomplete : <strong><?= TblRekod::countKetidakpatuhan($icno, $x, $tahun, 3) ?></strong>&nbsp;
            Absent : <strong><?= TblRekod::countKetidakpatuhan($icno, $x, $tahun, 4) ?></strong>&nbsp;
            External : <strong><?= TblRekod::countKetidakpatuhan($icno, $x, $tahun, 5) ?></strong>&nbsp;
        </p>
    </div>

    <table class="table table-sm table-bordered table-striped" style="font-size: 12px">
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
        <?php foreach (KehadiranController::getDaysInYearMonth($tahun, $x, 'Y-m-d') as $k => $v) { ?>
            <tr>
                <td class="text-center" style="text-align:center"><?= date("d/m/Y", strtotime($v)); ?></td>
                <td class="text-center" style="text-align:center"><?= TblRekod::DisplayDay($v) ?></td>
                <td class="text-center" style="text-align:center"><?= TblRekod::DisplayShift($icno, $v) ?></td>
                <td class="text-center" style="text-align:center"><?= TblRekod::DisplayTime($icno, $v, 1) ?></td>
                <td class="text-center" style="text-align:center"><?= TblRekod::DisplayTime($icno, $v, 2) ?></td>
                <td class="text-center" style="text-align:center"><?= TblRekod::DisplayTime($icno, $v, 5) ?></td>
                <td class="text-center" style="text-align:center"><?= TblRekod::DisplayCuti($icno, $v) ?></td>
                <td class="text-center" style="text-align:center"><?= TblRekod::DisplayHours($icno, $v) ?></td>
                <td class="text-center" style="text-align:center"><?= TblRekod::RemarkStatus($icno, $v) ?></td>
                <td class="text-center" style="text-align:center"><?= TblRekod::Remark($icno, $v) ?></td>
            </tr>
        <?php } ?>
    </table>
    <div style='padding: 15px; font-size: 12px' class="table-bordered">
        <font>[ &#10004; ]</font> : Remarked&nbsp;&nbsp;&nbsp;&nbsp;
        <font color="white" style="background-color:green;">[ &#10004; ]</font> : Remark has been Approved &nbsp;&nbsp;&nbsp;&nbsp;
        <font style="color:red">[ &#x2716; ]</font> : No Remark / Remark not approved &nbsp;&nbsp;&nbsp;&nbsp;
        <font>[ - ]</font> : N/A
    </div>


    <?php if ($x != $end_mth) { ?>
        <div class="page-break"></div>
    <?php } ?>
<?php } ?>