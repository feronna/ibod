<div class="table-responsive">

    <table class="table table-bordered table-info table-condensed table-hover table-striped jambo_table">
        <thead>
            <tr class="headings">
                <th>Bil</th>
                <th class="text-center">Pemohon</th>
                <th class="text-center">Jenis Cuti</th>
                <th class="text-center">Tarikh Mula</th>
                <th class="text-center">Tarikh Tamat</th>
                <th class="text-center">Tempoh</th>
                <!--<th class="text-center">Perakuan</th>-->
                <th class="text-center">Status Perakuan Pelulus</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cuti_rekod as $rows) { ?>
                <tr>
                    <td class="text-center"><?= $bil++ ?></td>
                    <td class="text-center"><?= $rows->kakitangan->CONm; ?></td>
                    <td class="text-center"><?= $rows->jeniscuti->jenis_cuti_catatan; ?></td>
                    <td class="text-center"><?= $rows->start_date; ?></td>
                    <td class="text-center"><?= $rows->end_date; ?></td>
                    <td class="text-center"><?= $rows->tempoh; ?></td>
                    <td class="text-center"><?= $rows->Status; ?></td>
                </tr>
            <?php } ?>
               
        </tbody>
    </table>
</div>