<div class="table-responsive">

    <table class="table table-bordered table-info table-condensed table-hover table-striped jambo_table">
        <thead>
            <tr class="headings">
                <th>BIL</th>
                <th class="text-center">START</th>
                <!-- <th class="text-center">MULA</th> -->
                <th class="text-center">END</th>
                <th class="text-center">ENTITLEMENT</th>
                <th class="text-center">BCTL</th>
                <th class="text-center">TOTAL</th>
                <th class="text-center">APPLIED</th>
                <th class="text-center">BALANCE</th>
                <th class="text-center">CBTH</th>
                <th class="text-center">GCR</th>
                <th class="text-center">DISCARDED</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($layak as $rows) { ?>
                <tr>
                    <td class="text-center"><?= $bil++ ?></td>
                    <td class="text-center"><?= $rows->layakMulaDmy; ?></td>
                    <td class="text-center"><?= $rows->layakTamatDmy; ?></td>
                    <td class="text-center"><?= $rows->layak_cuti; ?></td>
                    <td class="text-center"><?= $rows->layak_bawa_lepas; ?></td>
                    <td class="text-center"><?= $rows->totalLayak; ?></td>
                    <td class="text-center"><?= $rows->jumCuti; ?></td>
                    <td class="text-center"><?= $rows->layak_gcr; ?></td>
                    <td class="text-center"><?= $rows->layak_hapus; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>