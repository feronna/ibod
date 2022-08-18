<?php

use app\models\keselamatan\TblRekod;
?>  
<div class="table-responsive">

    <table class="table table-bordered table-info table-condensed table-hover table-striped jambo_table">
         <thead>
            <tr class="headings">
                <th class="text-center">Jumlah STS DiKeluarkan (<?= TblRekod::viewBulan($month) ?>) </th>
                <th class="text-center">Jumlah STS Diterima</th>
                <th colspan="2" class="text-center">Jumlah STS Ditolak</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td class="text-center"  style="text-align:center"><?=$totalSts?></td>
                    <td class="text-center"  style="text-align:center"><?=$stsApproved?></td>
                    <td colspan="2" class="text-center"  style="text-align:center"><?=$stsRejected?></td>
                </tr>

        </tbody>
    </table>
        <table class="table table-bordered table-info table-condensed table-hover table-striped jambo_table">
       
        <br>
        <thead>
            <tr class="headings">
                <th class="text-center">Bil</th>
                <th class="text-center">Anggota</th>
                <th class="text-center">Tarikh STS</th>
                <th class="text-center">Catatan Anggota</th>
                <th class="text-center">Syif</th>
                <th class="text-center">Jenis Syif</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($model as $models) { ?>
                <tr>
                    <td class="text-center"  style="text-align:center"><?= $bil++?></td>
                    <td class="text-center"  style="text-align:center"><?= $models->staff->CONm?></td>
                    <td class="text-center"  style="text-align:center"><?= $models->date?></td>
                    <td class="text-center"  style="text-align:center"><?= $models->remark?></td>
                    <td class="text-center"  style="text-align:center"><?= $models->syif?></td>
                    <td class="text-center"  style="text-align:center"><?= $models->type?></td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
</div>