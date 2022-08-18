
<?php

use app\models\kehadiran\TblRekod;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap\Modal;
use kartik\spinner\Spinner;
?>



<form id="w0" class="form-horizontal form-label-left" action="/basic/web/index.php?r=kehadiran%2Fremark&amp;id=51" method="post">

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group field-tblrekod-tarikh">

                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $biodata->CONm ?>" disabled="">

                <div class="help-block"></div>
            </div>                
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Position
        </label>
        <div class="col-md-5 col-sm-6 col-xs-12">
            <div class="form-group field-tblrekod-tarikh">

                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $biodata->jawatan->fname ?>" disabled="">


                <div class="help-block"></div>
            </div>                
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">J / F / P / I / U
        </label>
        <div class="col-md-5 col-sm-6 col-xs-12">
            <div class="form-group field-tblrekod-tarikh">

                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $biodata->department->fullname ?>" disabled="">


                <div class="help-block"></div>
            </div>                
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Card Colour Status
        </label>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <div class="form-group field-tblrekod-tarikh">

                <input type="text" id="tblrekod-tarikh" style="background-color:<?= $warna_kad; ?>;" class="form-control col-md-2 col-sm-2 col-xs-12" name="TblRekod[tarikh]" value="<?= $warna_kad; ?>" disabled="">


                <div class="help-block"></div>
            </div>                
        </div>
    </div>

</form>



<div style='border: solid red; border-style: dashed; padding-left: 15px'>
    <h5><strong>Monthly Summary</strong></h5>
    <p>
        Working day(Completed) : <strong><?php echo TblRekod::TotalWorkingHours($icno, $bulan, 2) ?></strong>&nbsp;
        Working Hours : <strong><?php echo TblRekod::TotalWorkingHours($icno, $bulan) ?></strong>&nbsp;
        Late In : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan, 1) ?></strong>&nbsp;
        Early Out : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan, 2) ?></strong>&nbsp;
        Incomplete : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan, 3) ?></strong>&nbsp;
        Absent : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan, 4) ?></strong>&nbsp;
        External : <strong><?= TblRekod::countKetidakpatuhan($icno, $bulan, 5) ?></strong>&nbsp;
    </p>
</div>
<br>

<table class="table table-striped table-sm jambo_table table-bordered">
    <thead>
        <tr class="headings">
            <th class="text-center">Date</th>
            <th class="text-center">Day</th>
            <th class="text-center">WBB</th>
            <th class="text-center">In</th>
            <th class="text-center">Out</th>
            <th class="text-center">Non-compliance status</th>
            <th class="text-center">Leave/Outstation</th>
            <th class="text-center">Working Hours<br>[h:m]</th>
            <th class="text-center">Remark ?</th>
            <th class="text-center">Location</th>
            <th class="text-center">Details</th>
        </tr>
    </thead>

    <?php foreach ($var as $k => $v) { ?>
        <tr>
            <td class="text-center"  style="text-align:center"><?= date("d/m/Y", strtotime($v)); ?></td>
            <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayDay($v) ?></td>
            <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayWbb($icno, $v) ?></td>
            <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayTime($icno, $v, 1) ?></td>
            <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayTime($icno, $v, 2) ?></td>
            <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayTime($icno, $v, 5) ?></td>
            <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayCuti($icno, $v) ?></td>
            <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayHours($icno, $v) ?></td>
            <td class="text-center"  style="text-align:center"><?= TblRekod::RemarkStatus($icno, $v) ?></td>
            <td class="text-center"  style="text-align:center"><?= TblRekod::DisplayLoc($icno, $v) ?></td>
            <td class="text-center"  style="text-align:center"><?= (TblRekod::DisplayWbb($icno, $v) != '-') ? Html::button('<i class="fa fa-eye"></i>', ['value' => Url::to(['kehadiran/detailrekod', 'icno' => $icno, 'tarikh' => $v]), 'class' => 'detail1', 'id' => 'modalButton']) : ''; ?></td>

        </tr>
    <?php } ?>
</table>
<?php
$spinner = Spinner::widget([
            'preset' => Spinner::LARGE,
            'color' => 'blue',
            'align' => 'center'
        ])
?>
<?php
Modal::begin([
    'header' => '<i class="fa fa-info-circle"></i> <strong>Attendance details</strong>',
    'id' => 'detailView',
    'size' => 'modal-lg',
]);

echo "<div id='modalContent'><div class='well'> . $spinner .</div></div>";

Modal::end();
?>
<script>
    $(document).ready(function () {


        $(".detail1").on("click", function () {
            var url = $(this).val();
//            $('#detailView').show();
            $( "#modalContent" ).load( url );
            $('#detailView').modal('show');
        });


    });
</script>