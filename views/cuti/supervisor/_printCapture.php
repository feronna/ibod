<?php

use app\models\cuti\TblRecords;

Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
Yii::$app->response->headers->add('Content-Type', 'application/pdf');


?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php
echo Yii::$app->controller->renderPartial('_staff_details', ['biodata' => $biodata,]); ?>

<table class="table table-sm table-bordered table-striped" style="font-size: 12.5px">
    <tr>
        <th width="auto" class="text-center">Leave Type</th>
        <th width="auto" class="text-center">Start</th>
        <th width="auto" class="text-center">End</th>
        <th width="auto" class="text-center">Duration</th>
        <th width="auto" class="text-center">Status</th>
    </tr>
    <?php foreach ($model as $data) { ?>

        <tr>
            <td class="text-center"><?= $data->jenisCuti->jenis_cuti_nama ?></td>
            <td class="text-center"><?= $data->start_date ?></td>
            <td class="text-center"><?= $data->end_date ?></td>
            <td class="text-center"><?= $data->tempoh ?></td>
            <td class="text-center"><?= $data->status ?></td>
        </tr>

    <?php } ?>
    <tr class="text-center">
        <td class="text-center" colspan="3">Total </td>
        <td class="text-center" ><?= TblRecords::getSum($id, $year, $type) ?> </td>

    </tr>
</table>