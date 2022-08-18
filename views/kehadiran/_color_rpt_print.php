<?php

use app\models\kehadiran\TblRekod;


Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
Yii::$app->response->headers->add('Content-Type', 'application/pdf');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<table class="table table-bordered table-info table-condensed table-hover table-striped jambo_table">
    <thead>
        <tr class="headings">
            <th>#</th>
            <th>Name</th>
            <th>JFPIB</th>
            <th>Position</th>
            <th>Ketidakpatuhan</th>
            <th>Approved</th>
            <th>Disapproved</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model as $rows) { ?>
            <tr>
                <td><?= $bil++ ?></td>
                <td><?= $rows->kakitangan->CONm; ?></td>
                <td class="text-center"><?= $rows->kakitangan->department->shortname; ?></td>
                <td><?= $rows->kakitangan->jawatan->gred; ?></td>
                <td class="text-center"><?= $rows->ketidakpatuhan; ?></td>
                <td class="text-center"><?= $rows->approved; ?></td>
                <td class="text-center"><?= $rows->disapproved; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>