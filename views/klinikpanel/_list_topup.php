<?php
use yii\helpers\Html;

?>
<div class="table-responsive">

    <table class="table table-bordered table-info table-condensed table-hover table-striped jambo_table">
        <thead>
            <tr class="headings">
                <th>Bil</th>
                <th class="text-center">Jumlah Penambahan (RM)</th>
                <th class="text-center">Di Tambah Oleh</th>
                <th class="text-center">Di Tambah Pada</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($topup) { ?>
            <?php foreach ($topup as $topups) { ?>
                <tr>
                    <td class="text-center"><?= $bil++ ?></td>
                    <td class="text-center"><?= $topups->topup_amount; ?></td>
                    <td class="text-center"><?= $topups->penambah->CONm; ?></td>
                    <td class="text-center"><?php echo Yii::$app->formatter->format($topups->topup_dt, 'date'); ?></td>
                </tr>
            <?php } ?>
            <?php } else { ?>
                    <tr>
                    <td colspan="12" class="align-center text-center"><i>Tiada rekod penambahan</i></td>
                    </tr>
            <?php } ?>
        </tbody>
    </table>
</div>