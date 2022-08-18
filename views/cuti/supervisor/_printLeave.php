<?php

use app\models\cuti\TblRecords;

Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
Yii::$app->response->headers->add('Content-Type', 'application/pdf');


?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<table class="table table-sm table-bordered table-striped" style="font-size: 12.5px">
    <tr>
        <th colspan="2" style="background-color: #4CAF50;" style="background-color: #4CAF50;" class="column-title text-center">Leave Application Details</th>

    </tr>

    <tr>
        <th width="40%" class="text-center">Name</th>
        <td class="text-left"><?= $biodata->CONm ?></td>
    </tr>
    <tr>
        <th width="40%" class="text-center">Position</th>
        <td class="text-left"><?= $biodata->jawatan->fname ?></td>
    </tr>
    <tr>
        <th width="40%" class="text-center">JFPIB</th>
        <td class="text-left"><?= $biodata->department->fullname ?></td>
    </tr>
    <tr>
        <th width="40%" class="text-center">Leave Start</th>
        <td class="text-left"><?= $model->start_date ?></td>
    </tr>
    <tr>
        <th width="40%" class="text-center">Leave End</th>
        <td class="text-left"><?= $model->end_date ?></td>
    </tr>
    <tr>
        <th width="40%" class="text-center">Duration</th>
        <td class="text-left"><?= $model->tempoh ?></td>
    </tr>
    <tr>
        <th width="40%" class="text-center">Destination</th>
        <td class="text-left"><?= $model->Destination ?></td>
    </tr>
    <tr>
        <th width="40%" class="text-center">Leave Type</th>
        <td class="text-left"><?= $model->jenisCuti->jenis_cuti_nama . ' - ' . $model->jenisCuti->jenis_cuti_catatan ?></td>
    </tr>
    <tr>
        <th width="40%" class="text-center">Remark</th>
        <td class="text-left"><?= $model->remark ?></td>
    </tr>
    <tr>
            <th width="40%" class="text-center">Tarikh Mohon / Apply Date</th>
            <td class="text-left"><?= TblRecords::getTarikh($model->mohon_dt);  ?></td>
        </tr>
</table>

<table class="table table-sm table-bordered table-striped" style="font-size: 12.5px">
    <tr>

        <th colspan="2" style="background-color: #4CAF50;" class="column-title text-center">Substitute Information</th>
    </tr>
    <?php if ($pengganti) { ?>
        <tr>
            <th width="40%" class="text-center">Name</th>
            <td class="text-left"><?= $pengganti->CONm ?></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Position</th>
            <td class="text-left"><?= $pengganti->jawatan->fname ?></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">JFPIB</th>
            <td class="text-left"><?= $pengganti->department->fullname ?></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Status</th>
            <td class="text-left"><?= $model->statusPengganti ?></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Tarikh / Date</th>
            <td class="text-left"><?= TblRecords::getTarikh($model->ganti_dt);  ?></td>
        </tr>
    <?php } else { ?>

        <tr>
            <th width="40%" class="text-center">Name</th>
            <td class="text-left"></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Position</th>
            <td class="text-left"></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">JFPIB</th>
            <td class="text-left"></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Status</th>
            <td class="text-left"></td>
        </tr>
    <?php } ?>
</table>
<table class="table table-sm table-bordered table-striped" style="font-size: 12.5px">
    <tr>

        <th colspan="2" style="background-color: #4CAF50;" class="column-title text-center">Verification</th>
    </tr>
    <?php if ($semak) { ?>
        <tr>
            <th width="40%" class="text-center">Name</th>
            <td class="text-left"><?= $semak->CONm ?></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Position</th>
            <td class="text-left"><?= $semak->jawatan->fname ?></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Remark</th>
            <td class="text-left"><?= $model->semakan_remark ?></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Status</th>
            <td class="text-left"><?= $model->status ?></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Tarikh Semak / Date</th>
            <td class="text-left"><?= TblRecords::getTarikh($model->semakan_dt);  ?></td>
        </tr>
    <?php } else { ?>

        <tr>
            <th width="40%" class="text-center">Name</th>
            <td class="text-left"></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Position</th>
            <td class="text-left"></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Remark</th>
            <td class="text-left"></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Status</th>
            <td class="text-left"></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Tarikh Semak / Date</th>
            <td class="text-left"><?= TblRecords::getTarikh($model->semakan_dt);  ?></td>
        </tr>
    <?php } ?>
</table>
<table class="table table-sm table-bordered table-striped" style="font-size: 12.5px">
    <tr>

        <th colspan="2" style="background-color: #4CAF50;" class="column-title text-center">Verifier Information</th>
    </tr>
    <?php if (!$peraku) { ?>
        <tr>
            <th width="40%" class="text-center">Name</th>
            <td class="text-left"></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Position</th>
            <td class="text-left"></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">JFPIB</th>
            <td class="text-left"></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Status</th>
            <td class="text-left"></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Verifier Remark</th>
            <td class="text-left"></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Tarikh Peraku</th>
            <td class="text-left"><?= TblRecords::getTarikh($model->peraku_dt);  ?></td>
        </tr>
    <?php } else { ?>
        <tr>
            <th width="40%" class="text-center">Name</th>
            <td class="text-left"><?= $peraku->CONm ?></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Position</th>
            <td class="text-left"><?= $peraku->jawatan->fname ?></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">JFPIB</th>
            <td class="text-left"><?= $peraku->department->fullname ?></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Status</th>
            <td class="text-left"><?= $model->status ?></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Verifier Remark</th>
            <td class="text-left"><?= $model->peraku_remark ?></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Tarikh Peraku</th>
            <td class="text-left"><?= TblRecords::getTarikh($model->peraku_dt);  ?></td>
        </tr>
    <?php } ?>

</table>
<table class="table table-sm table-bordered table-striped" style="font-size: 12.5px">
    <tr>

        <th colspan="2" style="background-color: #4CAF50;" class="column-title text-center">Approver Information</th>
    </tr>
    <?php if (!$pelulus) { ?>

        <tr>
            <th width="40%" class="text-center">Name</th>
            <td class="text-left"></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Position</th>
            <td class="text-left"></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">JFPIB</th>
            <td class="text-left"></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Status</th>
            <td class="text-left"></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Approver Remark</th>
            <td class="text-left"></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Tarikh Semak / Date</th>
            <td class="text-left"><?= TblRecords::getTarikh($model->lulus_dt);  ?></td>
        </tr>
    <?php } else { ?>


        <tr>
            <th width="40%" class="text-center">Name</th>
            <td class="text-left"><?= $pelulus->CONm ?></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Position</th>
            <td class="text-left"><?= $pelulus->jawatan->fname ?></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">JFPIB</th>
            <td class="text-left"><?= $pelulus->department->fullname ?></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Status</th>
            <td class="text-left"><?= $model->status ?></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Approver Remark</th>
            <td class="text-left"><?= $model->lulus_remark ?></td>
        </tr>
        <tr>
            <th width="40%" class="text-center">Tarikh Semak / Date</th>
            <td class="text-left"><?= TblRecords::getTarikh($model->lulus_dt);  ?></td>
        </tr>
    <?php } ?>
</table>