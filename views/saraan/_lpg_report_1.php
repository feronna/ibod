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
    <?php if(!is_null($roc->jenisLpg)) {?>
    <div class="col-xs-12 col-md-12 col-lg-12" style="text-align: center; margin-bottom: 5px;">
        <?= strtoupper($roc->jenisLpg->lpgTitle); ?>
    </div>
    <div class="col-xs-12 col-md-12 col-lg-12" style="text-align: center">
        <?= strtoupper($roc->jenisLpg->lpgNm); ?>
    </div>
    <?php } ?>
</row><br><br>

<div style="font-size: 11px">
<?php if(!is_null($roc->jenisLpg)) {?>
<row>
    <p>
        <?= $roc->jenisLpg->lpgTopDesc; ?>
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
        
        <tr>
            <td style="padding: 1px;"><?= Yii::$app->formatter->asDate($roc->t_lpg_date_start, 'dd-MM-yyyy'); ?></td>
            <td style="padding: 1px;"><?= ''; ?></td>
            <td style="padding: 1px;"><?= is_null($roc->t_lpg_amount) ?  '<font color="white">0</font>' : 'RM '.Yii::$app->formatter->asDecimal($roc->t_lpg_amount, 2); ?></td>
            <td style="padding: 1px;"><?= 'GAJI POKOK'; ?></td>
        </tr>
        
        <?php foreach($roc->elaun as $ind => $sroc) {?>
        <tr>
            <td style="padding: 1px;"></td>
            <td style="padding: 1px;"><?= ''; ?></td>
            <td style="padding: 1px;"><?= is_null($sroc->el_amount) ?  '<font color="white">0</font>' : 'RM '.Yii::$app->formatter->asDecimal($sroc->el_amount, 2); ?></td>
            <td style="padding: 1px;"><?= $sroc->elaunName->nama_ringkas; ?></td>
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
            <td style="border-top: 1px solid #000000; padding: 1px;"><?= '<font color="white">0</font>'; ?></td>
            <td style="border-top: 1px solid #000000; padding: 1px;"><?= ($roc->sumNew == 0) ? '<font color="white">0</font>' : 'RM '.Yii::$app->formatter->asDecimal($roc->sumNew, 2); ?></td>
            <td style="border-top: 1px solid #000000; padding: 1px;"></td>
        </tr>
    </table>
    </div>     
</row>

<row>
    Catatan :<br><br>
    <p>
        <?= ucwords(strtolower($roc->t_lpg_remark)); ?>
    </p>
</row><br>

<row>
    Tarikh : <?= Yii::$app->formatter->asDate($roc->t_lpg_ver_by_datetime, 'dd-MM-yyyy'); ?>
</row><br><br>

<row>
    Disahkan Oleh :<br>
    <?= ucwords(strtolower($roc->pengesah->CONm)); ?><br>
    <?= ucwords(strtolower($roc->pengesah->jawatan->nama)); ?>
</row><br><br>


<row>
    
    s.k.<br>
    - <?= $roc->staf->department->fullname ?><br>
    - <?= 'UMS(PER)'.$roc->staf->COOldID ?><br>
    - UMS/PN2.2.G1/1
    
</row>
</div>

