<?php

use app\models\kehadiran\TblRekod;
use app\models\kehadiran\TblWfh;


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


<table class="table table-sm table-bordered table-striped" style="font-size: 12.5px">

    <tr class="headings">
        <th class="text-center">Date</th>
        <th class="text-center">Day</th>
        <th class="text-center">WFO / WFH</th>
    </tr>
    <?php foreach ($var as $k => $v) { ?>

        <tr>
            <td class="text-center" style="text-align:center"><?= date("d/m/Y", strtotime($v)); ?></td>
            <td class="text-center" style="text-align:center"><?= TblRekod::DisplayDay($v, 'l') ?></td>
            <?php if (TblRekod::DisplayCuti($icno, $v)) { ?>
                <td class="text-center"
                    style="text-align:center;background-color:"><?php echo TblRekod::DisplayCuti($icno, $v) ?>
                </td>

            <?php } else { ?>
                <td class="text-center"
                    style="text-align:center;background-color:<?php echo (TblWfh::isWfh(date("Y-m-d", strtotime($v)), $icno) == 1) ? '#286090' : '#73D2BE' ?>"><?php echo (TblWfh::isWfh(date("Y-m-d", strtotime($v)), $icno) == 1) ? 'WFH' : 'WFO' ?></td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>

