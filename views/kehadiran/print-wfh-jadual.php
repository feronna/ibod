<?php

use app\models\kehadiran\TblRekod;

use app\models\kehadiran\TblWfh;

$bln = TblRekod::viewBulanBm($bulan);


Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
Yii::$app->response->headers->add('Content-Type', 'application/pdf');
?>




<table class="table table-sm table-bordered table-striped" style="font-size: 12.5px">
    <thead>
        <tr class="headings">
            <th class="text-center">Bil</th>
            <th class="text-center">Nama Kakitangan</th>
            <?php foreach ($var as $k => $v) { ?>
                <th class="text-center" style="text-align:center;background-color:<?php echo (TblRekod::DisplayDay($v) == 'Sun') ? 'brown' : (TblRekod::DisplayDay($v) == 'Sat') ? 'brown' : '' ?>; ?>;"><strong><?= date("d", strtotime($v)); ?></strong></th>
            <?php } ?>

        </tr>
    </thead>
    <!-- <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <?php foreach ($var as $k => $v) { ?>
                                    <td class="text-center" style="text-align:center"><strong><?= TblRekod::DisplayDay($v) ?></strong></td>
                                <?php } ?>

                            </tr> -->
    <?php foreach ($staff as $staffs) { ?>
        <tr>
            <td class="text-center" style="text-align:center;width:1px;white-space:nowrap"><?= $bil++ ?></td>
            <td style="width:1px;white-space:nowrap"><?= $staffs->CONm ?></td>
            <?php foreach ($var as $k => $v) { ?>
                <?php $is_wfh = TblWfh::isWfh(date("Y-m-d", strtotime($v)), $staffs->ICNO); ?>
                <?php if (TblRekod::DisplayDay($v) == 'Sun' || TblRekod::DisplayDay($v) == 'Sat') { ?>
                    <td class="text-center" style="text-align:center;background-color:brown">&nbsp;</td>
                <?php } else { ?>

                    <td class="text-center" style="text-align:center;background-color:<?php echo ($is_wfh == 1) ? '#286090' : '#E6E9ED' ?>"><?php echo (TblWfh::isWfh(date("Y-m-d", strtotime($v)), $staffs->ICNO) == 1) ? 'H' : 'O' ?></td>
                <?php } ?>
            <?php } ?>
        </tr>
    <?php } ?>

</table>