<?php

use app\models\kehadiran\TblRekod;

?>

<row>
    <div style="float: left; width: 50%;">
        Bendahari,<br>Universiti Malaysia Sabah.
    </div>

    <div style="float: right; width: 50%; text-align: right">
        Ruj : UMS(PER)<?= $biodata->COOldID; ?>
    </div>

    <div style="clear: both; margin: 0pt; padding: 0pt; "></div>
</row><br>

<row>
    <?php if(!is_null($roc->reason->rr_report_title)) {?>
    <div class="col-xs-12 col-md-12 col-lg-12" style="text-align: center; margin-bottom: 5px;">
        <?= strtoupper($roc->reason->rr_report_title); ?>
    </div>
    <?php } ?>
    <div class="col-xs-12 col-md-12 col-lg-12" style="text-align: center">
        <?= strtoupper($roc->reason->RR_REASON_DESC); ?>
    </div>
</row><br><br>

<div style="font-size: 11px">
<?php if(!is_null($roc->reason->rr_report_header)) {?>
<row>
    <p>
        <?= $roc->reason->rr_report_header; ?>
    </p>
</row><br>
<?php } ?>

<row>
    <?= ucwords(strtolower($biodata->CONm)); ?><br>
    <?= $biodata->jawatan->fname; ?><br>
    <?= $biodata->department->fullname; ?>
</row>

<row>
    <div style="margin-top: 15px;">
    <table class="table table-condensed" >
        <tr>
            <th style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; padding: 1px;" class="col-md-1">Tarikh</th>
            <th style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; padding: 1px;" class="col-md-1">Telah Bayar</th>
            <th style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; padding: 1px;" class="col-md-1">Patut Bayar</th>
            <th style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; padding: 1px;">Ulasan/Teguran</th>
        </tr>
        <?php foreach($roc->staffRoc as $ind => $sroc) {?>
        <tr>
            <td style="padding: 1px;"><?= ($ind == 0) ? Yii::$app->formatter->asDate($roc->srb_effective_date, 'dd-MM-yyyy') : ''; ?></td>
            <td style="padding: 1px;"><?= (is_null($sroc->SR_OLD_VALUE) OR ($sroc->SR_OLD_VALUE == 0)) ? '<font color="white">asd</font>' : 'RM '.$sroc->SR_OLD_VALUE; ?></td>
            <td style="padding: 1px;"><?= 'RM '.$sroc->SR_NEW_VALUE; ?></td>
            <td style="padding: 1px;"><?= (is_null($sroc->elaun)) ? $sroc->SR_ROC_TYPE : $sroc->elaun->it_account_name; ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td style="padding: 1px;"></td>
            <td style="padding: 1px;"></td>
            <td style="padding: 1px;"></td>
            <td style="padding: 1px;"></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; padding: 1px;">Jumlah</td>
            <td style="border-top: 1px solid #000000; padding: 1px;"><?= ($roc->sumOld == 0) ? '<font color="white">asd</font>' : 'RM '.$roc->sumOld; ?></td>
            <td style="border-top: 1px solid #000000; padding: 1px;"><?= 'RM '.$roc->sumNew; ?></td>
            <td style="border-top: 1px solid #000000; padding: 1px;"></td>
        </tr>
    </table>
    </div>     
</row>

<row>
    Catatan :<br><br>
    <p>
        <?= ucwords(strtolower($roc->srb_remarks)); ?>
    </p>
</row><br>

<row>
    Tarikh : <?= Yii::$app->formatter->asDate($roc->srb_verify_date, 'dd-MM-yyyy'); ?>
</row><br><br>

<row>
    Disahkan Oleh :<br>
    <?= ucwords(strtolower($roc->biodata->CONm)); ?><br>
    <?= ucwords(strtolower($roc->biodata->jawatan->nama)); ?>
</row><br><br>


<row>
    
    s.k.<br>
    - <?= $roc->department->dm_dept_desc ?><br>
    - <?= 'UMS(PER)'.$roc->biodataSendiri->COOldID ?><br>
    - UMS/PN2.2.G1/1
    
</row>
</div>

