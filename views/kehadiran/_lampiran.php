<?php

use app\models\kehadiran\TblRekod;

Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
Yii::$app->response->headers->add('Content-Type', 'application/pdf');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!--<p><strong>LAMPIRAN :1</strong></p>-->

<p style="padding-top: 5px">
    <?php echo $biodata->CONm; ?> (<?php echo $biodata->COOldID; ?>)
    <br>
    <?php echo strtoupper($biodata->jawatan->fname); ?>
</p>
<!--<hr>-->
<table class="table table-sm table-bordered" style="font-size: 11px;">
    <tr style="background-color: #4CAF50;">
        <th class="text-center">BIL</th>
        <th class="text-center">TARIKH</th>
        <th class="text-center">REKOD MASUK</th>
        <th class="text-center">REKOD KELUAR</th>
        <th class="text-center">JENIS KESALAHAN</th>
        <th class="text-center">CATATAN</th>
        <th class="text-center">Status Pengesahan</th>
        <th class="text-center">Catatan Pengesahan</th>
    </tr>
    <?php foreach ($rekod as $rekods) { ?>
        <tr>
            <td class="text-center"  style="text-align:center"><?= $bil++; ?></td>
            <td class="text-center"  style="text-align:center"><?= $rekods->formatTarikh; ?></td>
            <td class="text-center"  style="text-align:center"><?= $rekods->formatTimeIn; ?></td>
            <td class="text-center"  style="text-align:center"><?= $rekods->formatTimeOut; ?></td>
            <td class="text-center"  style="text-align:center"><?= $rekods->statusAll; ?></td>
            <td class="text-center"  style="text-align:center"><?= $rekods->catatan; ?></td>
            <td class="text-center"  style="text-align:center"><?= $rekods->remark_status; ?></td>
            <td class="text-center"  style="text-align:center"><?= $rekods->app_remark; ?></td>
        </tr>
    <?php } ?>
</table>

<div style='border: solid; padding-left: 15px;'>
<h5><strong>JUMLAH KESELURUHAN KETIDAKPATUHAN</strong></h5>
<p>
    Late In : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan, 1) ?></strong>&nbsp;
    Early Out : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan, 2) ?></strong>&nbsp;
    Incomplete : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan, 3) ?></strong>&nbsp;
    Absent : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan, 4) ?></strong>&nbsp;
    External : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan, 5) ?></strong>&nbsp;
</p>
</div>




