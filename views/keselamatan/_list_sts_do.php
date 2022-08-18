<div class="table-responsive">

    <table class="table table-bordered table-info table-condensed table-hover table-striped jambo_table">
        <thead>
            <tr class="headings">
                <th>Bil</th>
                <th class="text-center">Anggota</th>
                <th class="text-center">Tarikh STS</th>
                <th class="text-center">Jenis Syif </th>
                <th class="text-center">Syif</th>
                <th class="text-center">Status Perakuan Pelulus</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sts as $rows) { ?>
                <tr>
                    <td class="text-center"><?= $bil++ ?></td>
                    <td class="text-center"><?= $rows->staff->CONm; ?></td>
                    <td class="text-center"><?= $rows->date; ?></td>
                    <td class="text-center"><?= $rows->type; ?></td>
                    <td class="text-center"><?= $rows->syif; ?></td>
                    <td class="text-center"><?= $rows->stat; ?></td>
            <?php } ?>
               
        </tbody>
    </table>
</div>