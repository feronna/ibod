<div class="table-responsive">

    <table class="table table-bordered table-info table-condensed table-hover table-striped jambo_table">
        <thead>
            <tr class="headings">
                <th>Bil</th>
                <th class="text-center">Type</th>
                <th class="text-center">Date</th>
                <th class="text-center">Period</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php

use yii\helpers\Html;

foreach ($cuti_rekod as $rows) { ?>
                <tr>
                    <td class="text-center"><?= $bil++ ?></td>
                    <td class="text-center"><?= $rows->jenisCuti->jenis_cuti_nama; ?></td>
                    <td class="text-center"><?= $rows->full_date; ?></td>
                    <td class="text-center"><?= $rows->tempoh; ?></td>
                    <td class="text-center"><?= $rows->status; ?></td>
                    <?php if($rows->jenis_cuti_id == 28){?>
                        <td class="text-center"><?= Html::a('<i>Upload', ["cuti/individu/upload", 'id' => $rows->id]); ?></td>
                        <?php }else{ ?>
                            <td class="text-center"></td>

                            <?php } ?>

                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>